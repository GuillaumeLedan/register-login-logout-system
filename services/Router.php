<?php

class Router{
    private PDO $db;

    public function __construct()
    {

        $dbHost = 'localhost';
        $dbName = 'register-login';
        $dbUser = 'root';
        $dbPassword = '';


        try {
            $this->db = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->exec("SET NAMES utf8");
        } catch (PDOException $e) {
            echo "Erreur de connexion à la base de données : " . $e->getMessage();
            die();
        }
    }

    /**
     * @throws Exception
     */
    public function route(?string $route): void {

        $authManager = new AuthentificationManager();
        $homeManager = new HomeManager();
        $registerManager = new RegisterManager();

        $ac = new AuthentificationController($this->db,$authManager);
        $hc = new HomeController($homeManager);
        $rc = new RegisterController($this->db, $registerManager);
        $redc = new RedirectionController();

        if ($route !== null){
            $tab = explode("-", $route);

            if ($tab[0] === "connexion"){
                $ac->authentification();
            }
            elseif ($tab[0] === "register"){
                $rc->register();
            }
            elseif ($tab[0] === "redirection") {
                $redc->redirection();
            }
            elseif ($tab[0] === "home"){
                $hc->home();
            }
            elseif ($tab[0]=== "logout"){
                $ac->logout();
            }
            else{
                http_response_code(404);
                include('views/404.phtml');
                exit();
            }
        }
        else {
            $ac->authentification();
        }
    }
}