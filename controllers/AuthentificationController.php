<?php

class AuthentificationController extends AbstractController
{
    protected PDO $db;
    private AuthentificationManager $authManager;

    public function __construct(PDO $db, AuthentificationManager $authManager)
    {
        $this->db = $db;
        $this->authManager = $authManager;
    }

    public function authentification(): void
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Vérifie le jeton CSRF
            $csrfToken = $_POST['csrf_token'] ?? '';
            if (!empty($csrfToken) && $csrfToken === ($_SESSION['csrf_token'] ?? '')) {
                // Le jeton CSRF est valide, continue le traitement du formulaire

                $email = $_POST['email'] ?? '';
                $password = $_POST['password'] ?? '';

                if (empty($email) || empty($password)) {
                    $errors[] = "Tous les champs sont obligatoires.";
                } else {
                    // Vérification de l'utilisateur dans la base de données
                    $user = $this->authManager->getUserByEmail($email);

                    if ($user && password_verify($password, $user['Password'])) {
                        // L'utilisateur est authentifié
                        $_SESSION['user'] = [
                            'id' => $user['Id'],
                            'firstname' => $user['Firstname'] ?? '',
                            'lastname' => $user['Lastname'] ?? '',
                            'email' => $email,
                            'role' => $user['RoleId'] ?? ''
                        ];

                        header("Location: /home"); // Redirige l'utilisateur vers la page d'accueil
                        exit;
                    } else {
                        $errors[] = "Adresse e-mail ou mot de passe incorrect.";
                    }
                }
            } else {
                // Le jeton CSRF est invalide, traitement de l'erreur
                $errors[] = "Requête non autorisée.";
            }
        }

        $this->render("auth/authentification.phtml", ['errors' => $errors]);
    }

    public function logout(): void
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Détruire la session
        // session_unset();
        session_destroy();

        // Redirige l'utilisateur vers la page de connexion
        header("Location: /");
        exit;
    }
}
