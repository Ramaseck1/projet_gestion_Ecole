<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../vendor/autoload.php';
use ProjetGestionPedagogique\Core\Database\MysqlDatabase;

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
// Obtient une instance de la connexion à la base de données
$db = MysqlDatabase::getInstance();
$conn = $db->getConnection();

// Test de la connexion
/* if ($conn) {
    echo "Connexion à la base de données  reussi.";
    // Vous pouvez ajouter ici d'autres traitements nécessaires après la connexion réussie
} else {
    echo "Erreur de connexion à la base de données.";
}  
 */
$router = require '../routes/web.php';
/* $router = require '../routes/web.php';
 */


$chemin = $_SERVER['REQUEST_URI'];

$router->routers($chemin);
?>
