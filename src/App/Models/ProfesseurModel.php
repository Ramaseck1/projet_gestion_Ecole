<?php
namespace ProjetGestionPedagogique\App\Models;
use ProjetGestionPedagogique\Core\Database\MysqlDatabase; // Importer la classe MysqlDatabase

use ProjetGestionPedagogique\App\Entity\ProfesseurEntity; // Importer la classe MysqlDatabase

use PDO;
use PDOException;
use Exception;

class ProfesseurModel {
    private $db;

    public function __construct() {
        $this->db = MysqlDatabase::getInstance()->getConnection(); // Utiliser MysqlDatabase pour obtenir la connexion
    }

    public function getProfessors() {
        try{
        $stmt = $this->db->prepare('
            SELECT  p.id,u.nom, u.prenom, p.specialite, p.grade 
            FROM Professeur p 
            JOIN Utilisateur u ON p.id_utilisateur = u.id
        ');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }catch (PDOException $e) {
        // Gérer les erreurs de base de données
        return false;
    }
}
  


   
}
?>
