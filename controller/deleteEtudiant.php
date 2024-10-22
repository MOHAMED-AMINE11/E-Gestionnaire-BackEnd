<?php
include_once '../racine.php';
include_once RACINE . '/service/EtudiantService.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $es = new EtudiantService();
    $etudiant = $es->findById($id);
    if ($etudiant) {
        $es->delete($etudiant);
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Étudiant introuvable"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "ID manquant"]);
}
