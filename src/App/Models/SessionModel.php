<?php
namespace ProjetGestionPedagogique\App\Models;
use ProjetGestionPedagogique\Core\Database\MysqlDatabase; // Importer la classe MysqlDatabase


use PDO;
use PDOException;
use Exception;


class SessionModel {
    private $db;

    public function __construct() {
        $this->db = MysqlDatabase::getInstance()->getConnection(); // Utiliser MysqlDatabase pour obtenir la connexion
    }
 
    public function getSessionByProfessorId($professorId, $statusFilter = null) {
        try {
            $query = '
                SELECT s.id, s.date, s.heureDebut, s.heureFin, s.status, cl.Nomocour AS cour_nom, cl.Nommodule AS cour_nommodule
                FROM Sessions s
                JOIN Cours cl ON s.id_cours = cl.id
                WHERE s.id_professeur = :id_professeur
            ';

            if ($statusFilter) {
                $query .= ' AND s.status = :status';
            }

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id_professeur', $professorId, PDO::PARAM_INT);

            if ($statusFilter) {
                $stmt->bindParam(':status', $statusFilter, PDO::PARAM_STR);
            }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Gérer les erreurs de base de données
            return false;
        }
    }

  
    
    public function getSessionsByEtudiantId($etudiantId, $statusFilter = 'terminé') {
        try {
            $query = '
                SELECT s.id, s.date, s.heureDebut, s.heureFin, s.status, c.Nomocour, c.Nommodule, p.id AS id_professeur
                FROM Sessions s
                JOIN Cours c ON s.id_cours = c.id
                JOIN Inscription i ON c.id = i.id_cours
                JOIN Professeur p ON c.id_professeur = p.id
                WHERE i.id_etudiant = :id_etudiant AND s.status = :status
            ';
    
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id_etudiant', $etudiantId, PDO::PARAM_INT);
            $stmt->bindParam(':status', $statusFilter, PDO::PARAM_STR);
    
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Gérer les erreurs de base de données
            return false;
        }
    }
    

    public function getSessionsByProfessorAndEtudiantId($professorId, $etudiantId, $statusFilter = null) {
        try {
            $query = '
                SELECT s.id, s.date, s.heureDebut, s.heureFin, s.status, c.Nomocour, c.Nommodule, p.id AS id_professeur
                FROM Sessions s
                JOIN Cours c ON s.id_cours = c.id
                JOIN Inscription i ON c.id = i.id_cours
                JOIN Professeur p ON c.id_professeur = p.id
                WHERE p.id = :id_professeur AND i.id_etudiant = :id_etudiant
            ';
    
            if ($statusFilter) {
                $query .= ' AND s.status = :status';
            }
    
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id_professeur', $professorId, PDO::PARAM_INT);
            $stmt->bindParam(':id_etudiant', $etudiantId, PDO::PARAM_INT);
            if ($statusFilter) {
                $stmt->bindParam(':status', $statusFilter, PDO::PARAM_STR);
               

            }
    
            $stmt->execute();
            var_dump($stmt);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
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

public function addDemandeAnnulation($professorId, $sessionId, $raison) {
    try {
        $stmt = $this->db->prepare('
            INSERT INTO DemandeAnnulation (dateDemande, raison, id_professeur, id_sessions)
            VALUES (NOW(), :raison, :id_professeur, :id_sessions)
        ');
        $stmt->execute([
            'raison' => $raison,
            'id_professeur' => $professorId,
            'id_sessions' => $sessionId
        ]);
        return true;
    } catch (PDOException $e) {
        return false;
    }
}
public function getEtudiantId($etudiantid) {
      
    $stmt = $this->db->prepare('
        select id from `Etudiant` where id_utilisateur=:id_etudiant; ');
    $stmt->execute(['id_etudiant' => $etudiantid]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function updateSessionStatus($sessionId, $status) {
    try {
        $stmt = $this->db->prepare('UPDATE Sessions SET status = :status WHERE id = :session_id');
        $stmt->execute([
            'status' => $status,
            'session_id' => $sessionId,
        ]);
        return true;
    } catch (PDOException $e) {
        // Gérer les erreurs de base de données
        return false;
    }
}






  
}
?>

