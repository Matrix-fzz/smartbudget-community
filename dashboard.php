<?php
require 'db.php';

// Protection : Si pas connecté, rediriger vers login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Traitement Ajout Transaction
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_transaction'])) {
    $type = $_POST['type'];
    $montant = $_POST['montant'];
    $desc = $_POST['description'];
    
    // Récupérer le compte principal (simplification: on prend le premier compte)
    $stmt = $pdo->prepare("SELECT id, solde FROM comptes WHERE user_id = ? LIMIT 1");
    $stmt->execute([$user_id]);
    $compte = $stmt->fetch();
    
    if($compte){
        $nouveau_solde = ($type == 'revenu') ? $compte['solde'] + $montant : $compte['solde'] - $montant;
        
        // 1. Ajouter Transaction
        $sql = "INSERT INTO transactions (user_id, compte_id, type, montant, description) VALUES (?, ?, ?, ?, ?)";
        $pdo->prepare($sql)->execute([$user_id, $compte['id'], $type, $montant, $desc]);
        
        // 2. Mettre à jour Solde
        $pdo->prepare("UPDATE comptes SET solde = ? WHERE id = ?")->execute([$nouveau_solde, $compte['id']]);
        
        header("Location: dashboard.php"); // Refresh
    }
}

// Récupérer données
$stmt = $pdo->prepare("SELECT * FROM comptes WHERE user_id = ?");
$stmt->execute([$user_id]);
$compte = $stmt->fetch(); // On suppose 1 compte pour simplifier l'affichage

$stmt = $pdo->prepare("SELECT * FROM transactions WHERE user_id = ? ORDER BY date_transaction DESC LIMIT 10");
$stmt->execute([$user_id]);
$transactions = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - SmartBudget</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-balance { background: linear-gradient(to right, #11998e, #38ef7d); color: white; }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark px-4">
    <a class="navbar-brand" href="#">SmartBudget Panel</a>
    <span class="navbar-text text-white">Bonjour, <?= htmlspecialchars($_SESSION['user_nom']) ?></span>
    <a href="logout.php" class="btn btn-sm btn-outline-danger ms-3">Déconnexion</a>
</nav>

<div class="container mt-4">
    <div class="row">
        <!-- Carte Solde -->
        <div class="col-md-4">
            <div class="card card-balance mb-4">
                <div class="card-body">
                    <h5 class="card-title">Solde Actuel</h5>
                    <h2 class="display-6"><?= number_format($compte['solde'] ?? 0, 2) ?> MAD</h2>
                    <p class="card-text"><?= htmlspecialchars($compte['nom_compte'] ?? 'Aucun compte') ?></p>
                </div>
            </div>
            
            <!-- Formulaire Ajout -->
            <div class="card shadow-sm">
                <div class="card-header bg-white fw-bold">Nouvelle Transaction</div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-2">
                            <label>Type</label>
                            <select name="type" class="form-select">
                                <option value="depense">Dépense (-)</option>
                                <option value="revenu">Revenu (+)</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label>Montant (MAD)</label>
                            <input type="number" step="0.01" name="montant" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Description</label>
                            <input type="text" name="description" class="form-control" placeholder="Ex: Café, Salaire...">
                        </div>
                        <button type="submit" name="add_transaction" class="btn btn-success w-100">Ajouter</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Liste Transactions -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white fw-bold">Dernières Opérations</div>
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Type</th>
                                <th class="text-end">Montant</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($transactions as $t): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($t['date_transaction'])) ?></td>
                                <td><?= htmlspecialchars($t['description']) ?></td>
                                <td>
                                    <span class="badge bg-<?= $t['type'] == 'revenu' ? 'success' : 'danger' ?>">
                                        <?= ucfirst($t['type']) ?>
                                    </span>
                                </td>
                                <td class="text-end fw-bold <?= $t['type'] == 'revenu' ? 'text-success' : 'text-danger' ?>">
                                    <?= $t['type'] == 'depense' ? '-' : '+' ?><?= number_format($t['montant'], 2) ?> MAD
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php if(empty($transactions)) echo "<p class='text-center p-3'>Aucune transaction pour le moment.</p>"; ?>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>