<?php 
namespace ProjetGestionPedagogique\App\Controllers;

use ProjetGestionPedagogique\App\Models\UserModel;
use ProjetGestionPedagogique\Core\Validators\Validators;
use Exception;
class UserController {
    private $userModel;
    private $validators;

    public function __construct(UserModel $userModel) {
        $this->userModel = $userModel;
        $this->validators = new Validators();
        session_start(); // Démarrer la session
    } 

    public function showLoginForm() {
        include '../views/User.php';
    }
  

    public function showCoursesByEtudiant() {
        $utilisateurId = $_SESSION['user']->getId();

        $etudiantInfo = $this->userModel->getEtudiantId($utilisateurId);
        $coursesEtudiant = $this->userModel->getCoursesByEtudiantId($etudiantInfo[0]['id']);
        include '../views/listcourEtudiant.php';

    
    
    }
    public function login() {
        $data = [
            'email' => $_POST['email'] ?? '',
            'motDePasse' => $_POST['motDePasse'] ?? ''
        ];

        // Définir les règles de validation
        $rules = [
            'email' => ['required', 'email'],
            'motDePasse' => ['required', 'min' => 6] // Ajustez les règles selon vos besoins
        ];

        // Valider les données
        $errors = $this->validators->validate($data, $rules);

        if ($this->validators->hasErrors()) {
            // En cas d'erreurs, afficher le formulaire avec les messages d'erreur
            include '../views/User.php';
        } else {
            $email = $data['email'];
            $password = $data['motDePasse'];

            $user = $this->userModel->findByEmailAndPassword($email, $password);

            if ($user && password_verify($password, $user->getMotDePasse())) {
                $_SESSION['user'] = $user;

                $role = $user->getRole();
                $utilisateurId = $user->getId();

                if ($role === 'professeur') {
                    $professorId = $this->userModel->getProfesseurId($utilisateurId);
                    $courses = $this->userModel->getCoursesByProfessorId($professorId[0]['id']);
                    include '../views/accueil.php';
                } elseif ($role === 'etudiant') {
                    $etudiantInfo = $this->userModel->getEtudiantId($utilisateurId);
                    $coursesEtudiant = $this->userModel->getCoursesByEtudiantId($etudiantInfo[0]['id']);
                    include '../views/listcourEtudiant.php';

                  
                    // Vous pouvez rediriger vers une autre page spécifique pour les étudiants si nécessaire
                    // header('Location: /etudiantAccueil');
                }

            } else {
                $error = 'Email ou mot de passe incorrect.';
                include '../views/User.php';
            }
        }
        exit();
    }
   
    public function register()
    {
        // Exemple d'inscription d'un utilisateur
        $prenom = 'rama';
        $nom = 'dieye';
        $email = 'rams1seck@gmail.com';
        $hashedPassword = 'passer123';
        $rol = 'etudiant'; 
        
        $this->userModel->register($prenom, $nom, $email, $hashedPassword, $rol);
        include '../views/User.php';

    }
    //Etudiant
  
    public function logout() {
        session_unset();
        session_destroy();
        header('Location: /login');
        exit();
    }
}

?>
