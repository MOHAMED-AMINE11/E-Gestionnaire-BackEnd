<?php
include_once 'C:\Users\LENOVO$\Desktop\Source Files/racine.php'; 
include_once RACINE . '/classes/Etudiant.php';
include_once RACINE . '/connexion/Connexion.php';
include_once RACINE . '/dao/IDao.php';

class EtudiantService implements IDao {
    private $connexion;

    public function __construct() {
        $this->connexion = new Connexion();
    }

    public function create($o) {
        $query = "INSERT INTO etudiant (nom, prenom, ville, sexe, image) 
                  VALUES (:nom, :prenom, :ville, :sexe, :image);";
        $req = $this->connexion->getConnexion()->prepare($query);
    
        // Stocker les valeurs dans des variables
        $nom = $o->getNom();
        $prenom = $o->getPrenom();
        $ville = $o->getVille();
        $sexe = $o->getSexe();
        $image = $o->getImage();
    
        // Utiliser les variables dans bindParam()
        $req->bindParam(':nom', $nom);
        $req->bindParam(':prenom', $prenom);
        $req->bindParam(':ville', $ville);
        $req->bindParam(':sexe', $sexe);
        $req->bindParam(':image', $image, PDO::PARAM_LOB);
    
        $req->execute() or die('Erreur SQL');
    }
    

    public function delete($o) {
        $query = "DELETE FROM Etudiant WHERE id = :id";
        $req = $this->connexion->getConnexion()->prepare($query);
    
        // Stocker l'id dans une variable avant de l'utiliser dans bindParam()
        $id = $o->getId();
        $req->bindParam(':id', $id, PDO::PARAM_INT);
    
        $req->execute() or die('Erreur SQL');
    }
    

    public function findAll() {
        $etds = array();
        $query = "SELECT * FROM etudiant";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute();
        while ($e = $req->fetch(PDO::FETCH_OBJ)) {
            $etds[] = new Etudiant($e->id, $e->nom, $e->prenom, $e->ville, $e->sexe, $e->image);
        }
        return $etds;
    }

    public function findById($id) {
        $query = "SELECT * FROM etudiant WHERE id = :id";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->bindParam(':id', $id, PDO::PARAM_INT);  // Ajout de type PDO_INT pour plus de précision
        $req->execute();
    
        // Vérifier si une ligne est trouvée
        if ($e = $req->fetch(PDO::FETCH_OBJ)) {
            // Retourner l'étudiant avec toutes ses informations
            return new Etudiant(
                $e->id,
                $e->nom,
                $e->prenom,
                $e->ville,
                $e->sexe,
                $e->image // Image récupérée depuis la base de données
            );
        }
        return null; // Si aucun étudiant trouvé
    }
    

    public function update($o) {
        try {
            $query = "UPDATE etudiant SET nom = :nom, prenom = :prenom, 
                      ville = :ville WHERE id = :id"; // suppression de sexe et image
            $req = $this->connexion->getConnexion()->prepare($query);
    
            $req->bindParam(':nom', $o->getNom());
            $req->bindParam(':prenom', $o->getPrenom());
            $req->bindParam(':ville', $o->getVille());
            $req->bindParam(':id', $o->getId());
    
            $req->execute();
        } catch (PDOException $e) {
            die('Erreur SQL : ' . $e->getMessage());
        }
    }
    

    public function findAllApi() {
        $query = "SELECT * FROM etudiant";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
