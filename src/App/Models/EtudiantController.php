<?php
namespace ProjetGestionPedagogique\App\Models;
use ProjetGestionPedagogique\Core\Database\MysqlDatabase; // Importer la classe MysqlDatabase

use ProjetGestionPedagogique\App\Entity\EtudiantEntity; // Importer la classe MysqlDatabase

use PDO;
use PDOException;
use Exception;

class EtudiantController {
    private $db;

    public function __construct() {
        $this->db = MysqlDatabase::getInstance()->getConnection(); // Utiliser MysqlDatabase pour obtenir la connexion
    }

    public function getEtudiant() {
        try{
        $stmt = $this->db->prepare('
            SELECT  e.id,u.nom, u.prenom, e.photo, e.genre 
            FROM Etudiant e 
            JOIN Utilisateur u ON e.id_utilisateur = u.id
        ');
        $stmt->execute();
        var_dump($stmt);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }catch (PDOException $e) {
        // Gérer les erreurs de base de données
        return false;
    }
}
  


   
}
?>
