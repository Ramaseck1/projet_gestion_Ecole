<?php
use ProjetGestionPedagogique\Core\Route;
use ProjetGestionPedagogique\App\Controllers\UserController;
use ProjetGestionPedagogique\App\Controllers\SessionController;
use ProjetGestionPedagogique\App\Controllers\ProfController;
use ProjetGestionPedagogique\App\Models\UserModel;
use ProjetGestionPedagogique\Core\Database\MysqlDatabase;

// Créer une instance de la connexion PDO
$pdo = MysqlDatabase::getInstance()->getConnection();

// Créer une instance du modèle UserModel
$userModel = new UserModel($pdo);

// Vous n'avez pas besoin de créer explicitement le contrôleur ici
// Le routeur s'en chargera en utilisant la réflexion

$router = new Route();
$router->ajouterRoute('/login', UserController::class, 'showLoginForm');
$router->ajouterRoute('/seConnecter', UserController::class, 'login');
$router->ajouterRoute('/logout', UserController::class, 'logout');
$router->ajouterRoute('/courEtu', UserController::class, 'showCoursesByEtudiant');
$router->ajouterRoute('/session', ProfController::class, 'affichersession');
$router->ajouterRoute('/prof', ProfController::class, 'add');
$router->ajouterRoute('/profs', ProfController::class, 'showCoursesByProfessor');
$router->ajouterRoute('/calendar', ProfController::class, 'affichersessionEtudiant'); 

return $router;

?>
