<?php

class ExpenseManager extends AbstractManager 
{
    public function __construct()
    {
        parent::__construct();
    }

    public function createExpense(Expenses $expense, array $participantIds): bool
    {
        $query = $this->db->prepare("
            INSERT INTO expenses (title, amount, date, paid_by_id, category_id, groupe_id) 
            VALUES (:title, :amount, :date, :paid_by_id, :category_id, :groupe_id)
        ");
        
        $success = $query->execute([
            'title' => $expense->getTitle(),
            'amount' => $expense->getAmount(),
            'date' => $expense->getDate(),
            'paid_by_id' => $expense->getPaidById(),
            'category_id' => $expense->getCategoryId(),
            'groupe_id' => $expense->getGroupeId(),
        ]);
        
        if (!$success) {
            return false;
        }

        $insertParticipantsQuery = "
            INSERT INTO expense_participants ( user_id, groupe_id) 
            VALUES ( :user_id, :groupe_id)
        ";
        $participantStatement = $this->db->prepare($insertParticipantsQuery);
        
        foreach ($participantIds as $userId) {
            $participantStatement->execute([
                
                'user_id' => $userId,
                'groupe_id' => $expense->getGroupeId()
            ]);
        }

        return true;
    }
    
    public function getAllCategories(): array
    {
        $query = $this->db->query("SELECT id, type FROM categories");
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $categories = [];
        foreach($results as $result) {
            $categories[] = new Categories($result['id'], $result['type']);
        }
        return $categories;
    }
}
?>