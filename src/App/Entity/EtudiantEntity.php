<?php
namespace ProjetGestionPedagogique\App\Entity;

use ProjetGestionPedagogique\Core\Entity\Entity;

class EtudiantEntity extends Entity {
    protected $id;
    protected $photo;
    protected $genre;

    protected $id_utilisateur;
  
    // Getters and Setters
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getphoto() {
        return $this->photo;
    }

    public function setphoto($photo) {
        $this->photo = $photo;
    }

    public function getgenre() {
        return $this->genre;
    }

    public function setgenre($genre) {
        $this->genre = $genre;
    }
    public function getid_utilisateur() {
        return $this->id_utilisateur;
    }

    public function setid_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
    }

}
?>
