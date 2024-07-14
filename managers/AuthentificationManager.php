<?php
class AuthentificationManager extends AbstractManager{

    // Fonction pour obtenir les informations de l'utilisateur par e-mail depuis la base de données
    public function getUserByEmail($email)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Gérer les erreurs de la base de données ici

            error_log("Erreur de base de données: " . $e->getMessage());
            return false;
        }
    }
}