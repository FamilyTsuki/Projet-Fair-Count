<?php

class DepenseController extends AbstractController 
{
    private ExpenseManager $expenseManager;
    private GroupeManager $groupManager; 

    public function __construct()
    {
        $this->expenseManager = new ExpenseManager();
        $this->groupManager = new GroupeManager(); 
    }

    public function handleExpenseCreation(): void
    {
        if (
            isset($_POST['title'], $_POST['amount'], $_POST['date'], 
                  $_POST['category_id'], $_POST['groupe_id'], 
                  $_POST['participants'],$_POST["category_id"])
        ) {
            $CategoryManager = new CategoryManager();
    
    
            $expense = new Expenses(
                null, // ID sera généré par la BDD
                htmlspecialchars($_POST['title']),
                floatval($_POST['amount']),
                $_POST['date'],
                null,
                intval($_POST['paid_by_id']),
                intval($_POST['category_id']),
                intval($_POST['groupe_id']),
                $CategoryManager->getCategoryById(intval($_POST['category_id']))
                
            );
            
            $participantIds = is_array($_POST['participants']) ? array_map('intval', $_POST['participants']) : [];
            
            $success = $this->expenseManager->createExpense($expense, $participantIds);
            
            if ($success) {
                header("Location: index.php?route=groupe&id=" . $expense->getGroupeId());
                exit;
            } else {
                echo "Erreur lors de l'enregistrement de la dépense.";
            }

        } else {
            echo $_POST['title']. " " . $_POST['amount']. " " . $_POST['date']. " " .
                  $_POST['category_id']. " " . $_POST['groupe_id']. " " . 
                  $_POST['participants'];
        }
    }
    public function showCreateExpenseForm(int $groupCode): void
{
    $group = $this->groupManager->getGroupBycode($groupCode);
    $groupeId = $group->getId();
    $currentUserId = $_SESSION['user_id'] ?? 0; 
    
    
    $categories = $this->expenseManager->getAllCategories();
    
    $membres = $this->groupManager->getGroupParticipants($groupeId); 

     $isConnected = $this->isAuthenticated();
        $username = null;
    $username = $_SESSION['username'] ?? 'Utilisateur'; 
    
    
    $data = [
        'groupe_id' => $groupeId,
        'current_user_id' => $currentUserId,
        'categories' => $categories,
        'membres' => $membres,
        "isConnected" => $isConnected, // Envoi de l'état
        "username" => $username,       // Envoi du nom d'utilisateur
        'tune' => $_SESSION['tune'],
        
    ];
    
    (new PageController())->render('create_expense', $data);
    
}
public function showExpenseList(string $codeGroupe): void
{
    $groupeManager = new GroupeManager();
    $expenseManager = new ExpenseManager();
    
    // 1. Récupérer l'ID du groupe à partir du code
    $group = $groupeManager->getGroupBycode($codeGroupe);
    
    if ($group === null) {
        (new PageController())->notFound();
        return;
    }
    
    $groupeId = $group->getId();
    
    // 2. Récupérer la liste des dépenses
    $expenses = $expenseManager->getExpensesByGroup($groupeId);
    
    // 3. Préparer les données
    $isConnected = $this->isAuthenticated();
        $username = null;

        if ($isConnected) {

        $username = $_SESSION['username'] ?? 'Utilisateur'; 
    }
    $data = [
        'groupe' => $group, // Pour le titre et les informations du groupe
        'expenses' => $expenses, // La liste des dépenses
        'code_groupe' => $codeGroupe,
        "isConnected" => $isConnected, // Envoi de l'état
            "username" => $username,       // Envoi du nom d'utilisateur
            'tune' => $_SESSION['tune']

    ];
    
    // 4. Rendre la vue
    (new PageController())->render('list_expenses', $data);
}
}
?>