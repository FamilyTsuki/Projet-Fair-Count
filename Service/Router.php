<?php

    class Router
    {
        public function handleRequest(array $get) : void
        {
            if(isset($get["route"]))
            {
                if($get["route"] === "depance")
                {
                    $ctrl = new PageController();
                    $ctrl->depance();
                }

                else if ($get["route"] === "ranbourccemant")    
                {
                    $ctrl = new PageController();
                    $ctrl->ranbourccemant();
                }
                else if ($get["route"] === "groupe")    
                {
                    $ctrl = new PageController();
                    $ctrl->groupe();
                }

                
                else if ($get["route"] === "connect")
                {
                    $ctrl = new PageController();
                    $ctrl->connect();
                }
                else if ($get["route"] === "creat")
                {
                    $ctrl = new PageController();
                    $ctrl->creat();
                }
                else if ($get["route"] === "auth/login") 
                {
                    $ctrl = new AuthController(); 
                    $ctrl->login(); 
                }
                else if ($get["route"] === "auth/unlogin") 
                {
                    $ctrl = new AuthController(); 
                    $ctrl->unlogin(); 
                }
                else if ($get["route"] === "auth/register") 
                {
                    $ctrl = new AuthController(); 
                    $ctrl->register();
                }
                else if ($get["route"] === "created_group") 
                {
                    $ctrl = new PageController(); 
                    $ctrl->created_group();
                }
                else if ($get["route"] === "created_groupv") 
                {
                    $ctrl = new GroupeController(); 
                    $ctrl->create(); 
                }
                else if ($get["route"] === "join_group") 
                {
                    $ctrl = new PageController(); 
                    $ctrl->join_group();
                }
                else if ($get["route"] === "join_groupv") 
                {
                    $ctrl = new GroupeController();
                    $ctrl->join();
                }
                else if ($get["route"] === "compt") 
                {
                    $ctrl = new PageController(); 
                    $ctrl->compt();
                }
                else if ($get["route"] === "budget/ajouter") 
                {
                    $ctrl = new BudgetController(); 
                    $ctrl->handleBudjetAddition();
                }
                else if ($get["route"] === "budget/retirer")
                {
                    $ctrl = new BudgetController(); 
                    $ctrl->handleBudjetRetrait();
                }
                else if ($get["route"] === "depense/creer") 
                {
                    $ctrl = new DepenseController(); 
                    $ctrl->showCreateExpenseForm(intval($_GET['code'])); 
                }
                else if ($get["route"] === "depense/enregistrer") 
                {
                    $ctrl = new DepenseController(); 
                    $ctrl->handleExpenseCreation();
                }
                else if ($get["route"] === "depense/liste")
                {
                    $ctrl = new DepenseController(); 
                    $codeGroupe = $_GET['code_groupe'] ?? '';
                    
                    if (!empty($codeGroupe)) {
                        $ctrl->showExpenseList($codeGroupe); 
                    } else {
                        (new PageController())->notFound(); 
                    }
                }
                
                else if ($get["route"] === "remboursement/afficher") 
                {
                    $ctrl = new RemboursementController(); 
                    $codeGroupe = $_GET['code'] ?? ''; 
                    
                    if (!empty($codeGroupe)) {
                        $ctrl->showRemboursement($codeGroupe);
                    } else {
                        (new PageController())->notFound(); 
                    }
                }
                else
                {
                    $ctrl = new PageController();
                    $ctrl->notFound();
                }
                
            }
            else
            {
                $ctrl = new PageController();
                $ctrl->home();
            }
        }
    }
?>