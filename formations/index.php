<?php
require_once '../database/connexion.php';

// READ : récupération de tous les enregistrements
$stmt = $pdo->query("SELECT id_formation, titre, description, duree_mois FROM formation ORDER BY id_formation");
$lignes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des formations</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <nav>
        <a href="../index.php">Accueil</a>
        <a href="../formations/index.php">Formations</a>
        <a href="../etudiants/index.php">Étudiants</a>
        <a href="../modules/index.php">Modules</a>
    </nav>

    <h1>Liste des formations</h1>
    <?php if (isset($_GET['erreur'])): ?>
        <div class="erreur">Impossible de supprimer cette formation : elle contient encore des étudiants ou des modules. Supprimez-les d'abord.</div>
    <?php endif; ?>
    <a class="btn" href="create.php">+ Ajouter</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Description</th>
                <th>Durée (mois)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($lignes as $r): ?>
            <tr>
                <td><?= h($r['id_formation']) ?></td>
                <td><?= h($r['titre']) ?></td>
                <td><?= h($r['description']) ?></td>
                <td><?= h($r['duree_mois']) ?></td>
                <td>
                    <a class="btn btn-edit" href="edit.php?id=<?= $r['id_formation'] ?>">Modifier</a>
                    <a class="btn btn-del" href="delete.php?id=<?= $r['id_formation'] ?>"
                       onclick="return confirm('Supprimer cette formation ?');">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (empty($lignes)): ?>
            <tr><td colspan="5">Aucun enregistrement.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
