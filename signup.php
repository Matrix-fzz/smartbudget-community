<?php
require 'db.php';

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = htmlspecialchars($_POST['nom']);
    $email = htmlspecialchars($_POST['email']);
    $pass = password_hash($_POST['password'], PASSWORD_BCRYPT); // Sécurité (F5)

    // Vérifier si email existe
    $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $check->execute([$email]);
    
    if($check->rowCount() > 0){
        $message = "Cet email est déjà utilisé.";
    } else {
        // Insertion User
        $stmt = $pdo->prepare("INSERT INTO users (nom, email, password) VALUES (?, ?, ?)");
        if($stmt->execute([$nom, $email, $pass])){
            // Créer un compte courant par défaut
            $user_id = $pdo->lastInsertId();
            $pdo->prepare("INSERT INTO comptes (user_id, nom_compte, solde) VALUES (?, 'Compte Courant', 0)")->execute([$user_id]);
            
            header("Location: login.php?success=1");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Inscription</title>
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="card p-4 shadow" style="width: 400px;">
        <h3 class="text-center mb-4">Inscription</h3>
        <?php if($message): ?><div class="alert alert-danger"><?= $message ?></div><?php endif; ?>
        
        <form method="POST">
            <div class="mb-3">
                <label>Nom complet</label>
                <input type="text" name="nom" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Mot de passe</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
        </form>
        <p class="text-center mt-3"><a href="login.php">Déjà un compte ?</a></p>
    </div>
</body>
</html>