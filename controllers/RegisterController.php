<?php

#[AllowDynamicProperties]
class RegisterController extends AbstractController {
    public function __construct(PDO $db, RegisterManager $registerManager) {
        $this->db = $db;
        $this->registerManager = $registerManager;
    }

    /**
     * @throws Exception
     */
    public function register(): void {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validation des données d'entrée
            $firstName = isset($_POST['firstName']) ? filter_var($_POST['firstName'], FILTER_SANITIZE_SPECIAL_CHARS) : '';
            $lastName = isset($_POST['lastName']) ? filter_var($_POST['lastName'], FILTER_SANITIZE_SPECIAL_CHARS) : '';
            $email = isset($_POST['reg-email']) ? filter_var($_POST['reg-email'], FILTER_SANITIZE_EMAIL) : '';
            $password = isset($_POST['reg-password']) ? $_POST['reg-password'] : '';
            $confirmPassword = isset($_POST['reg-confirmPassword']) ? $_POST['reg-confirmPassword'] : '';

            // Vérifie si l'email existe déjà
            $model = new RegisterManager($this->db);
            if ($model->isEmailExists($email)) {
                $errors[] = "L'adresse e-mail est déjà utilisée.";
            }

            if (empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($confirmPassword)) {
                $errors[] = "Tous les champs sont obligatoires.";
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "L'adresse e-mail n'est pas valide.";
            }
            if ($password !== $confirmPassword) {
                $errors[] = "Les mots de passe ne correspondent pas.";
            }

            // Protection CSRF
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                $errors[] = "Validation CSRF échouée.";
            }

            if (empty($errors)) {
                $model = new RegisterManager($this->db);

                // Inscrit l'utilisateur dans la base de données
                $registrationResult = $model->registerUser($firstName, $lastName, $password, $email);

                if ($registrationResult) {
                    // Redirige l'utilisateur vers une page de confirmation
                    header("Location: /redirection");
                    exit;
                }

                $errors[] = "Une erreur est survenue lors de l'inscription.";
            }
        }

        // Génération d'un nouveau jeton CSRF
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

        $this->render("auth/register.phtml", ['errors' => $errors]);
    }
}
