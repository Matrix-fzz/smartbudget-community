<?php
// db.php - Connexion à la base de données
$host = 'localhost';
$dbname = 'smartbudget_db';
$username = 'root'; // Par défaut sur XAMPP
$password = '';     // Par défaut vide sur XAMPP

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Démarrer la session sur toutes les pages
session_start();
?>