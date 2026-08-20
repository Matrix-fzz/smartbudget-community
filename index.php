<?php require 'db.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>SmartBudget Community - Accueil</title>
    <!-- On utilise Bootstrap pour le design rapide -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 100px 0; }
        .feature-icon { font-size: 2rem; color: #764ba2; }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">SmartBudget</a>
        <div class="d-flex">
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="dashboard.php" class="btn btn-primary">Mon Tableau de Bord</a>
            <?php else: ?>
                <a href="login.php" class="btn btn-outline-primary me-2">Connexion</a>
                <a href="signup.php" class="btn btn-primary">Inscription</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<header class="hero text-center">
    <div class="container">
        <h1 class="display-4 fw-bold">Prenez le contrôle de vos finances</h1>
        <p class="lead mb-4">Rejoignez la communauté SmartBudget pour gérer, épargner et réussir ensemble.</p>
        <a href="signup.php" class="btn btn-light btn-lg text-primary fw-bold">Commencer Gratuitement</a>
    </div>
</header>

<!-- Features -->
<section class="py-5">
    <div class="container text-center">
        <div class="row">
            <div class="col-md-4">
                <div class="feature-icon mb-3">📊</div>
                <h3>Suivi Budget</h3>
                <p>Visualisez vos revenus et dépenses en temps réel.</p>
            </div>
            <div class="col-md-4">
                <div class="feature-icon mb-3">🤝</div>
                <h3>Communauté</h3>
                <p>Partagez vos objectifs et recevez du soutien.</p>
            </div>
            <div class="col-md-4">
                <div class="feature-icon mb-3">🔒</div>
                <h3>Sécurité</h3>
                <p>Vos données sont chiffrées et sécurisées.</p>
            </div>
        </div>
    </div>
</section>

<footer class="bg-dark text-white text-center py-3">
    <p>&copy; 2024 SmartBudget Community. Projet Innovant.</p>
</footer>

</body>
</html>