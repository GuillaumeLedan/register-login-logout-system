<?php

abstract class AbstractManager {

    protected PDO $db;

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
}