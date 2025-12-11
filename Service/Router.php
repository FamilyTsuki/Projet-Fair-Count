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
                    $ctrl->player();
                }

                else if ($get["route"] === "home")
                {
                    $ctrl = new PageController();
                    $ctrl->match();
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