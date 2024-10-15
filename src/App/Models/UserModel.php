<?php
namespace ProjetGestionPedagogique\App\Models;

use ProjetGestionPedagogique\App\Entity\UserEntity;
use PDO;

class UserModel {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function findByEmail($email) {
        $stmt = $this->db->prepare('SELECT * FROM Utilisateur WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $user = new UserEntity();
            $user->setId($data['id']);
            $user->setNom($data['nom']);
            $user->setPrenom($data['prenom']);
            $user->setEmail($data['email']);
            $user->setMotDePasse($data['motDePasse']);
            $user->setRole($data['role']);
            return $user;
        }
        return null;
    }

    public function findByEmailAndPassword($email, $password) {
        $stmt = $this->db->prepare('SELECT * FROM Utilisateur WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data && password_verify($password, $data['motDePasse'])) {
            $user = new UserEntity();
            $user->setId($data['id']);
            $user->setNom($data['nom']);
            $user->setPrenom($data['prenom']);
            $user->setEmail($data['email']);
            $user->setMotDePasse($data['motDePasse']);
            $user->setRole($data['role']);
            return $user;
        }
        return null;
    }
    public function getCoursesByProfessorId($professorId) {
      
        $stmt = $this->db->prepare('
            SELECT c.id, c.Nomocour, c.Nommodule, c.Nomsemestre, cl.nom AS classe_nom 
            FROM Cours c 
            JOIN Classe cl ON c.id_classe = cl.id
            WHERE c.id_professeur = :id_professeur
        ');
        $stmt->execute(['id_professeur' => $professorId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
   
    public function getProfesseurId($professorId) {
      
        $stmt = $this->db->prepare('
            select id from `Professeur` where id_utilisateur=:id_professeur;
        ');
        $stmt->execute(['id_professeur' => $professorId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function register($nom, $prenom, $email, $motDePasse, $role) {
        $motDePasse = '123passer';
        $hashedPassword = password_hash($motDePasse, PASSWORD_DEFAULT);
    
        $stmt = $this->db->prepare('
            INSERT INTO Utilisateur (nom, prenom, email, motDePasse, role)
            VALUES (:nom, :prenom, :email, :motDePasse, :role)
        ');
    
        $stmt->execute([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'motDePasse' => $hashedPassword,
            'role' => $role
        ]);
    }
    
    public function getEtudiantId($etudiantid) {
      
        $stmt = $this->db->prepare('
            select id from `Etudiant` where id_utilisateur=:id_etudiant; ');
        $stmt->execute(['id_etudiant' => $etudiantid]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    public function getCoursesByEtudiantId($etudiantId) {
        $stmt = $this->db->prepare('
            SELECT c.id, c.Nomocour, c.Nommodule, c.Nomsemestre, cl.nom AS classe_nom 
            FROM Inscription i
            JOIN Cours c ON i.id_cours = c.id
            JOIN Classe cl ON c.id_classe = cl.id
            WHERE i.id_etudiant = :id_etudiant
        ');
        $stmt->execute(['id_etudiant' => $etudiantId]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>
