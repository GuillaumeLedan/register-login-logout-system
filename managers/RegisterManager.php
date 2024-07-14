<?php
class RegisterManager extends AbstractManager
{
    public function registerUser($firstName, $lastName, $password, $email): bool
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO users (FirstName, LastName, Password, Email, RoleId) VALUES (?, ?, ?, ?, ?)");

            $defaultRoleID = 1;
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $stmt->execute([$firstName, $lastName, $hashedPassword, $email, $defaultRoleID]);

            return true; // L'inscription a réussi
        } catch (PDOException $e) {
            echo "Erreur de base de données : " . $e->getMessage();
            return false;
        }
    }

    public function isEmailExists($email): bool
    {
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
            $stmt->execute([$email]);
            return (bool) $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            return false;
        }
    }

}