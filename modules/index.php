<?php
require_once '../database/connexion.php';

// READ : récupération de tous les enregistrements
$stmt = $pdo->query("SELECT m.id_module, m.titre, m.nombre_heures, f.titre AS formation FROM module m INNER JOIN formation f ON m.id_formation = f.id_formation ORDER BY m.id_module");
$lignes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des modules</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <nav>
        <a href="../index.php">Accueil</a>
        <a href="../formations/index.php">Formations</a>
        <a href="../etudiants/index.php">Étudiants</a>
        <a href="../modules/index.php">Modules</a>
    </nav>

    <h1>Liste des modules</h1>
    <?php if (isset($_GET['erreur'])): ?>
        <div class="erreur">Impossible de supprimer ce module.</div>
    <?php endif; ?>
    <a class="btn" href="create.php">+ Ajouter</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Module</th>
                <th>Heures</th>
                <th>Formation</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($lignes as $r): ?>
            <tr>
                <td><?= h($r['id_module']) ?></td>
                <td><?= h($r['titre']) ?></td>
                <td><?= h($r['nombre_heures']) ?></td>
                <td><?= h($r['formation']) ?></td>
                <td>
                    <a class="btn btn-edit" href="edit.php?id=<?= $r['id_module'] ?>">Modifier</a>
                    <a class="btn btn-del" href="delete.php?id=<?= $r['id_module'] ?>"
                       onclick="return confirm('Supprimer ce module ?');">Supprimer</a>
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
