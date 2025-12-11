<?php
    class Router
    {
        public function handleRequest(array $get) : void
        {
            if(isset($get["route"]))
            {
                if($get["route"] === "team")
                {
                    $ctrl = new PageController();
                    $ctrl->team();
                }

                else if ($get["route"] === "player")
                {
                    $ctrl = new PageController();
                    $ctrl->player();
                }

                else if ($get["route"] === "match")
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