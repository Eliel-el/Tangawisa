<?php
session_start();
require 'models/UserModel.php';


if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$userModel = new UserModel();
$userId = $_SESSION['user']['id'];

// Récupérer les données POST
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$avatarPath = $_SESSION['user']['avatar'] ?? 'assets/default-avatar.png';

// Gestion du fichier avatar
if (!empty($_FILES['avatar']['tmp_name'])) {
    $targetDir = "uploads/avatars/";
    if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

    $filename = uniqid() . "_" . basename($_FILES['avatar']['name']);
    $targetFile = $targetDir . $filename;

    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $targetFile)) {
        $avatarPath = $targetFile;
    }
}

// Mise à jour via UserModel
$userModel->updateProfile($userId, $name, $email, $password ?: null, $avatarPath);

// Mettre à jour la session
$_SESSION['user']['name'] = $name;
$_SESSION['user']['email'] = $email;
$_SESSION['user']['avatar'] = $avatarPath;

// Redirection
header("Location: index.php");
exit();
?>
