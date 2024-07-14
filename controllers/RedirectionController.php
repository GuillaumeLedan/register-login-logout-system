<?php
class RedirectionController extends AbstractController{

    public function redirection() : void
    {
        $this->render("auth/redirection.phtml", []);
    }


}