<?php

class ExpenseManager extends AbstractManager 
{
    public function __construct()
    {
        parent::__construct();
    }

    public function createExpense(Expenses $expense, array $participantIds): bool
{
    $this->db->beginTransaction(); // Ajout d'une transaction pour la sécurité

    
        // 1. INSERTION DE LA DÉPENSE PRINCIPALE
        $query = $this->db->prepare("
            INSERT INTO expenses (title, amount, date, paid_by_id, category_id, groupe_id) 
            VALUES (:title, :amount, :date, :paid_by_id, :category_id, :groupe_id)
        ");
        
        $query->execute([
            'title' => $expense->getTitle(),
            'amount' => $expense->getAmount(),
            'date' => $expense->getDate(),
            'paid_by_id' => $expense->getPaidById(),
            'category_id' => $expense->getCategoryId(),
            'groupe_id' => $expense->getGroupeId(),
        ]);
        
        // 2. RÉCUPÉRATION DE L'ID (CRITIQUE)
        $expenseId = $this->db->lastInsertId();
        
        if (!$expenseId) {
             throw new \PDOException("Impossible de récupérer l'ID de la dépense.", 999);
        }

        // 3. INSERTION DES PARTICIPANTS (CORRIGÉE)
        $insertParticipantsQuery = "
            INSERT INTO expense_participants (expense_id, user_id, groupe_id) 
            VALUES (:expense_id, :user_id, :groupe_id)
        ";
        $participantStatement = $this->db->prepare($insertParticipantsQuery);
        
        foreach ($participantIds as $userId) {
            $participantStatement->execute([
                'expense_id' => $expenseId, // <-- AJOUT DE L'ID DE LA DÉPENSE
                'user_id' => $userId,
                'groupe_id' => $expense->getGroupeId()
            ]);
        }
        
        $this->db->commit();
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
    public function getExpensesByGroup(int $groupeId): array
{
    // Requête principale pour les dépenses et les informations liées (payeur, catégorie)
    $query = $this->db->prepare("
        
        SELECT 
            e.id, 
            e.title, 
            e.amount, 
            e.date, 
            u.username AS paid_by_name,
            c.type
            
        FROM expenses e
        JOIN expense_participants ep ON e.id = expense_id
        JOIN users u ON ep.user_id = u.id
        JOIN categories c on c.id = e.category_id
        WHERE e.groupe_id = :groupe_id
        ORDER BY e.date DESC, e.id DESC
    ");
    
    $query->execute([':groupe_id' => $groupeId]);
    $expenses = $query->fetchAll(PDO::FETCH_ASSOC);

    // Si aucune dépense n'est trouvée
    if (empty($expenses)) {
        return [];
    }

    // Pour chaque dépense, récupérer la liste des participants
    $expenseIds = array_column($expenses, 'id');
    $placeholders = implode(',', array_fill(0, count($expenseIds), '?'));
    
    $participantsQuery = $this->db->prepare("
        SELECT 
            ep.expense_id, 
            u.username 
        FROM expense_participants ep
        JOIN users u ON ep.user_id = u.id
        WHERE ep.expense_id IN ({$placeholders})
    ");

    $participantsQuery->execute($expenseIds);
    $allParticipants = $participantsQuery->fetchAll(PDO::FETCH_ASSOC);
    
    // Organiser les participants par dépense ID
    $participantsByExpense = [];
    foreach ($allParticipants as $participant) {
        $participantsByExpense[$participant['expense_id']][] = $participant['username'];
    }

    // Fusionner les données
    foreach ($expenses as $key => $expense) {
        $expenses[$key]['participants'] = $participantsByExpense[$expense['id']] ?? [];
    }

    return $expenses;
}
}
?>