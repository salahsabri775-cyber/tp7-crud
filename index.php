<?php require_once 'database/connexion.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Centre de formation - Accueil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Centre de formation - Gestion</h1>
    <p>Bienvenue. Choisissez un espace de gestion :</p>
    <div class="cards">
        <div class="card"><h2>Formations</h2><a class="btn" href="formations/index.php">Gérer les formations</a></div>
        <div class="card"><h2>Étudiants</h2><a class="btn" href="etudiants/index.php">Gérer les étudiants</a></div>
        <div class="card"><h2>Modules</h2><a class="btn" href="modules/index.php">Gérer les modules</a></div>
    </div>
</body>
</html>
