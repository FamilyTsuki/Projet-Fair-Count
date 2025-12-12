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
                else if ($get["route"] === "auth/register") 
                {
                    $ctrl = new AuthController(); 
                    $ctrl->register();
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