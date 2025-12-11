<?php
    class Router
    {
        public function handleRequest(array $get) : void
        {
            if(isset($get["route"]))
            {
                if($get["route"] === "dépance")
                {
                    $ctrl = new PageController();
                    $ctrl->team();
                }

                else if ($get["route"] === "ranbourcemant")    
                {
                    $ctrl = new PageController();
                    $ctrl->player();
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