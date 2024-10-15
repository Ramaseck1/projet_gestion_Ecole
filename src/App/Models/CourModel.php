<?php
namespace ProjetGestionPedagogique\App\Models;
use ProjetGestionPedagogique\Core\Database\MysqlDatabase; // Importer la classe MysqlDatabase


use PDO;
use PDOException;
use Exception;


class CourModel {
    private $db;

    public function __construct() {
        $this->db = MysqlDatabase::getInstance()->getConnection(); // Utiliser MysqlDatabase pour obtenir la connexion
    }

    public function getCoursesByProfessorId($professorId) {
        try{
        $stmt = $this->db->prepare('
            SELECT c.id, c.Nomocour, c.Nommodule, c.Nomsemestre, cl.nom AS classe_nom 
            FROM Cours c 
            JOIN Classe cl ON c.id_classe = cl.id
            WHERE c.id_professeur = :id_professeur
        ');
        $stmt->execute(['id_professeur' => $professorId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (PDOException $e) {
        // Gérer les erreurs de base de données
        return false;
    }

}

public function getProfesseurId($professorId) {
      
    $stmt = $this->db->prepare('
        select id from `Professeur` where id_utilisateur=:id_professeur;
    ');
    $stmt->execute(['id_professeur' => $professorId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
 public function getCoursesByProfessorIdWithPagination($professorId, $offset, $limit, $filters = []) {
        $query = '
            SELECT c.id, c.Nomocour, c.Nommodule, c.Nomsemestre, cl.nom AS classe_nom 
            FROM Cours c 
            JOIN Classe cl ON c.id_classe = cl.id
            WHERE c.id_professeur = :id_professeur
        ';

        $params = ['id_professeur' => $professorId];
        
        if (!empty($filters['semester'])) {
            $query .= ' AND c.Nomsemestre = :semester';
            $params['semester'] = $filters['semester'];
        }
        if (!empty($filters['module'])) {
            $query .= ' AND c.Nommodule = :module';
            $params['module'] = $filters['module'];
        }

        $query .= ' LIMIT :offset, :limit';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_professeur', $professorId, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);

        foreach ($params as $key => $value) {
            $stmt->bindValue(':'.$key, $value);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllModulesByProfessorId($professorId) {
        try {
            $stmt = $this->db->prepare('
                SELECT DISTINCT Nommodule 
                FROM Cours 
                WHERE id_professeur = :id_professeur
            ');
            $stmt->execute(['id_professeur' => $professorId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Gérer les erreurs de base de données
            return false;
        }
    }

    // Nouvelle méthode pour récupérer tous les semestres
    public function getAllSemestersByProfessorId($professorId) {
        try {
            $stmt = $this->db->prepare('
                SELECT DISTINCT Nomsemestre 
                FROM Cours 
                WHERE id_professeur = :id_professeur
            ');
            $stmt->execute(['id_professeur' => $professorId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Gérer les erreurs de base de données
            return false;
        }
    }
}
?>

