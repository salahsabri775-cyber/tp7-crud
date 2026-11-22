<?php
require_once '../database/connexion.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    try {
        // DELETE ciblant obligatoirement l'identifiant
        $stmt = $pdo->prepare("DELETE FROM etudiant WHERE id_etudiant = :id");
        $stmt->execute([':id' => $id]);
    } catch (PDOException $ex) {
        // Contrainte de clé étrangère (ex : formation encore utilisée)
        header('Location: index.php?erreur=1');
        exit;
    }
}

header('Location: index.php');
exit;
