<?php
include_once '../racine.php';
include_once RACINE . '/service/EtudiantService.php';

// Définir l'en-tête de la réponse comme JSON
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $es = new EtudiantService();

    // Récupération des données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $ville = $_POST['ville'];
    $sexe = $_POST['sexe'];

    // Vérifier si une image a été téléchargée avec succès
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTempPath = $_FILES['image']['tmp_name'];
        $imageData = file_get_contents($imageTempPath);  // Lecture du contenu de l'image

        // Création de l'objet étudiant avec l'image
        $etudiant = new Etudiant(null, $nom, $prenom, $ville, $sexe, $imageData);
        
        try {
            $es->create($etudiant);

            // Réponse JSON formatée correctement
            echo json_encode([
                "success" => true,  // Changer "status" en "success"
                "message" => "Étudiant ajouté avec succès.",
                "etudiant" => [
                    "nom" => $etudiant->getNom(),
                    "prenom" => $etudiant->getPrenom(),
                    "ville" => $etudiant->getVille(),
                    "sexe" => $etudiant->getSexe(),
                    // Ajoutez d'autres propriétés de l'objet étudiant si nécessaire
                ]
            ]);
        } catch (Exception $e) {
            // En cas d'erreur lors de l'ajout
            echo json_encode([
                "success" => false,
                "message" => "Erreur lors de l'ajout de l'étudiant: " . $e->getMessage()
            ]);
        }
    } else {
        // En cas d'erreur de téléchargement de l'image
        echo json_encode([
            "success" => false,
            "message" => "Erreur lors du téléchargement de l'image."
        ]);
    }
} else {
    // En cas de méthode non autorisée
    echo json_encode([
        "success" => false,
        "message" => "Méthode non autorisée."
    ]);
}
?>
