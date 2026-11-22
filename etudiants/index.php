<?php
require_once '../database/connexion.php';

// READ : récupération de tous les enregistrements
$stmt = $pdo->query("SELECT e.id_etudiant, e.nom, e.prenom, e.email, f.titre AS formation FROM etudiant e INNER JOIN formation f ON e.id_formation = f.id_formation ORDER BY e.id_etudiant");
$lignes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des étudiants</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <nav>
        <a href="../index.php">Accueil</a>
        <a href="../formations/index.php">Formations</a>
        <a href="../etudiants/index.php">Étudiants</a>
        <a href="../modules/index.php">Modules</a>
    </nav>

    <h1>Liste des étudiants</h1>
    <?php if (isset($_GET['erreur'])): ?>
        <div class="erreur">Impossible de supprimer cet étudiant.</div>
    <?php endif; ?>
    <a class="btn" href="create.php">+ Ajouter</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Formation</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($lignes as $r): ?>
            <tr>
                <td><?= h($r['id_etudiant']) ?></td>
                <td><?= h($r['nom']) ?></td>
                <td><?= h($r['prenom']) ?></td>
                <td><?= h($r['email']) ?></td>
                <td><?= h($r['formation']) ?></td>
                <td>
                    <a class="btn btn-edit" href="edit.php?id=<?= $r['id_etudiant'] ?>">Modifier</a>
                    <a class="btn btn-del" href="delete.php?id=<?= $r['id_etudiant'] ?>"
                       onclick="return confirm('Supprimer cet étudiant ?');">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (empty($lignes)): ?>
            <tr><td colspan="6">Aucun enregistrement.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
