<?php
namespace ProjetGestionPedagogique\App\Entity;

use ProjetGestionPedagogique\Core\Entity\Entity;

class ProfesseurEntity extends Entity {
    protected $id;
    protected $specialite;
    protected $grade;

    protected $id_utilisateur;
  
    // Getters and Setters
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getspecialiste() {
        return $this->specialite;
    }

    public function setspecialiste($specialite) {
        $this->specialite = $specialite;
    }

    public function getgrade() {
        return $this->grade;
    }

    public function setgrade($grade) {
        $this->grade = $grade;
    }
    public function getid_utilisateur() {
        return $this->id_utilisateur;
    }

    public function setid_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
    }

}
?>
