<?php
// Connexion PDO centralisée - à inclure avec require_once
$host    = 'localhost';
$dbname  = 'tp7_crud';
$user    = 'root';
$pass    = '';   // XAMPP : mot de passe vide par défaut

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

// Échappe une valeur avant affichage HTML (protection XSS)
function h($valeur) {
    return htmlspecialchars((string)$valeur, ENT_QUOTES, 'UTF-8');
}
