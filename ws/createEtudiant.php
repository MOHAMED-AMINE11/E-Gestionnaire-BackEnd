<?php 
include_once '../racine.php'; 
include_once RACINE . '/service/EtudiantService.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $es = new EtudiantService();

    // Vérifier que les champs obligatoires sont fournis
    if (!isset($_POST['nom'], $_POST['prenom'], $_POST['ville'], $_POST['sexe'])) {
        header('Content-type: application/json');
        echo json_encode(["status" => "error", "message" => "Tous les champs sont requis"]);
        exit();
    }

    // Gestion de l'image (facultative)
    $imageData = isset($_POST['image']) ? base64_decode($_POST['image']) : null;

    try {
        $etudiant = new Etudiant(
            null, 
            $_POST['nom'], 
            $_POST['prenom'], 
            $_POST['ville'], 
            $_POST['sexe'], 
            $imageData
        );
        $es->create($etudiant);

        header('Content-type: application/json');
        echo json_encode(["status" => "success", "message" => "Étudiant ajouté avec succès"]);
    } catch (Exception $e) {
        header('Content-type: application/json');
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }
}
?>
