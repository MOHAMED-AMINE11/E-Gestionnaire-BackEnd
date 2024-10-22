<?php
class Etudiant {
    private $id;
    private $nom;
    private $prenom;
    private $ville;
    private $sexe;
    private $image;

    public function __construct($id = null, $nom, $prenom, $ville, $sexe, $image = null) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->ville = $ville;
        $this->sexe = $sexe;
        $this->image = $image;
    }


    public function getSexe() { return $this->sexe; }
    public function getImage() { return $this->image; }
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    public function getVille() {
        return $this->ville;
    }

    public function setVille($ville) {
        $this->ville = $ville;
    }
}
?>
