<?php
include_once '../racine.php';
include_once RACINE . '/service/EtudiantService.php';

// Masquer les erreurs PHP pour éviter toute sortie indésirable
error_reporting(0);
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['id'])) {
        $id = $data['id'];
        $es = new EtudiantService();
        $etudiant = $es->findById($id);

        if ($etudiant) {
            if (isset($data['nom'])) {
                $etudiant->setNom($data['nom']);
            }
            if (isset($data['prenom'])) {
                $etudiant->setPrenom($data['prenom']);
            }
            if (isset($data['ville'])) {
                $etudiant->setVille($data['ville']);
            }

            try {
                $es->update($etudiant);
                echo json_encode(["status" => "success", "message" => "Mise à jour réussie"]);
            } catch (Exception $e) {
                echo json_encode(["status" => "error", "message" => "Erreur lors de la mise à jour : " . $e->getMessage()]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Étudiant introuvable"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "ID manquant"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Méthode non autorisée"]);
}
?>
