<?php
namespace ProjetGestionPedagogique\App\Entity;

class CourEntity {
    private $id;
    private $Nomocour;
    private $Nommodule;
    private $Nomsemestre;
    private $id_professeur;
    private $id_classe;

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getNomocour() {
        return $this->Nomocour;
    }

    public function getNommodule() {
        return $this->Nommodule;
    }

    public function getNomsemestre() {
        return $this->Nomsemestre;
    }

    public function getIdProfesseur() {
        return $this->id_professeur;
    }

    public function getIdClasse() {
        return $this->id_classe;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setNomocour($Nomocour) {
        $this->Nomocour = $Nomocour;
    }

    public function setNommodule($Nommodule) {
        $this->Nommodule = $Nommodule;
    }

    public function setNomsemestre($Nomsemestre) {
        $this->Nomsemestre = $Nomsemestre;
    }

    public function setIdProfesseur($id_professeur) {
        $this->id_professeur = $id_professeur;
    }

    public function setIdClasse($id_classe) {
        $this->id_classe = $id_classe;
    }
}
?>
