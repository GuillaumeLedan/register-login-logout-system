<?php

class HomeController extends AbstractController {

    private HomeManager $homeManager;

    public function __construct(HomeManager $homeManager) {
        $this->homeManager = $homeManager;
    }
    public function home(): void {
        if (!isset($_SESSION['user']['id'])) {
            http_response_code(404);
            include('views/404.phtml');
            exit();
        }


        $this->render("home.phtml", []);
    }

}