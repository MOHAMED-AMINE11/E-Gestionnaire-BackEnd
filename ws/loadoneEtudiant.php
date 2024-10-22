<?php
include_once '../racine.php';
include_once RACINE . '/service/EtudiantService.php';

// Vérifier si un ID est passé dans la requête GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $es = new EtudiantService();

    // Recherche de l'étudiant par son ID
    $etudiant = $es->findById($id);

    if ($etudiant) {
        // Encodage de l'image en base64 pour l'affichage
        $imageData = base64_encode($etudiant->getImage());

        // Préparation de la réponse
        $response = [
            "id" => $etudiant->getId(),
            "nom" => $etudiant->getNom(),
            "prenom" => $etudiant->getPrenom(),
            "ville" => $etudiant->getVille(),
            "sexe" => $etudiant->getSexe(),
            "image" => $imageData
        ];

        // Envoi de la réponse JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        // Si l'étudiant n'est pas trouvé
        http_response_code(404);
        echo json_encode(["message" => "Étudiant non trouvé."]);
    }
} else {
    // Si l'ID n'est pas fourni
    http_response_code(400);
    echo json_encode(["message" => "ID manquant."]);
}
?>
