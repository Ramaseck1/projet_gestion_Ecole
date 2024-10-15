<?php
namespace ProjetGestionPedagogique\App\Entity;

use ProjetGestionPedagogique\Core\Entity\Entity;

class SessionEntity extends Entity {
    protected $id;
    protected $date;
    protected $heureDebut;
    protected $heureFin;
    protected $status;

    protected $id_professeur;
    protected $id_cours;

    // Getters and Setters
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function getHeureDebut() {
        return $this->heureDebut;
    }

    public function setHeureDebut($heureDebut) {
        $this->heureDebut = $heureDebut;
    }

    public function getHeureFin() {
        return $this->heureFin;
    }

    public function setHeureFin($heureFin) {
        $this->heureFin = $heureFin;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getIdProfesseur() {
        return $this->id_professeur;
    }

    public function setIdProfesseur($id_professeur) {
        $this->id_professeur = $id_professeur;
    }

    public function getIdCours() {
        return $this->id_cours;
    }

    public function setIdCours($id_cours) {
        $this->id_cours = $id_cours;
    }
}
?>
