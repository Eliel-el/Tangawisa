<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit();
}

// Vérifier si admin
if ($_SESSION['user']['role'] !== 'admin') {
    header("Location: ../403.php");
    exit();
}

require_once '../models/produits-data.php';
$userModel = new UserModel();

$success = false;
$error = false;

// Ajouter un nouvel utilisateur/admin
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'user';

    if ($name && $email && $password && $role) {
        if ($userModel->createAdmin($name, $email, $password)) {
            $success = "Nouvel utilisateur ajouté avec succès !";
        } else {
            $error = "Cet email est déjà utilisé.";
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}

// Supprimer un utilisateur
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    if ($id !== $_SESSION['user']['id']) { // éviter de supprimer soi-même
        $userModel->deleteUser($id);
        $success = "Utilisateur supprimé avec succès.";
    } else {
        $error = "Vous ne pouvez pas supprimer votre propre compte.";
    }
}

// Mettre à jour un utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    $id = intval($_POST['id']);
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $role = $_POST['role'] ?? 'user';

    if ($name && $email && $role) {
        $userModel->updateUser($id, $name, $email, $role);
        $success = "Utilisateur mis à jour avec succès.";
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}

// Récupérer tous les utilisateurs
$users = $userModel->all();

$title = "Gestion des utilisateurs";
$page = "admin_users.php";
$header = "Gestion des utilisateurs";
?>

<section class="bg-white dark:bg-gray-900 min-h-screen">
    <?php require 'nav_admin.php'; ?>
    <?php require '../composants/head.php'; ?>

    <div class="max-w-6xl mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4 text-orange-500">Gestion des utilisateurs</h2>

        <!-- Messages -->
        <?php if ($success): ?>
            <div class="p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <!-- Formulaire Ajouter utilisateur/admin -->
        <div class="border rounded-lg p-4 mb-6 bg-gray-100 dark:bg-gray-800">
            <h3 class="font-semibold mb-3 text-lg">Ajouter un utilisateur / admin</h3>
            <form method="POST" class="grid gap-3">
                <input type="hidden" name="add" value="1">
                <input type="text" name="name" placeholder="Nom" required
                       class="block w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                <input type="email" name="email" placeholder="Email" required
                       class="block w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                <input type="password" name="password" placeholder="Mot de passe" required
                       class="block w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                <select name="role" required
                        class="block w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg">
                    ➕ Ajouter
                </button>
            </form>
        </div>

        <!-- Liste des utilisateurs -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <?php foreach ($users as $user): ?>
                <div class="border rounded-lg p-4 bg-gray-100 dark:bg-gray-800">
                    <div class="flex items-center mb-2">
                        <img src="../<?= htmlspecialchars($user['avatar']) ?>" alt="<?= htmlspecialchars($user['name']) ?>"
                             class="w-12 h-12 rounded-full mr-3 object-cover">
                        <div>
                            <h4 class="font-bold text-lg"><?= htmlspecialchars($user['name']) ?></h4>
                            <p class="text-sm text-gray-600 dark:text-gray-300"><?= htmlspecialchars($user['email']) ?></p>
                            <p class="text-sm italic text-gray-500">Rôle: <?= htmlspecialchars($user['role']) ?></p>
                        </div>
                    </div>

                    <!-- Formulaire édition -->
                    <form method="POST" class="grid gap-2 mb-2">
                        <input type="hidden" name="edit" value="1">
                        <input type="hidden" name="id" value="<?= $user['id'] ?>">
                        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required
                               class="block w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required
                               class="block w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                        <select name="role" required
                                class="block w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                            <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
                            <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                        </select>
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg text-sm">
                            ✏️ Mettre à jour
                        </button>
                    </form>

                    <!-- Bouton supprimer -->
                    <?php if ($user['id'] !== $_SESSION['user']['id']): ?>
                        <a href="admin_users.php?delete=<?= $user['id'] ?>"
                           onclick="return confirm('Supprimer cet utilisateur ?')"
                           class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm inline-block">
                            🗑 Supprimer
                        </a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php require '../composants/footer.php'; ?>
</section>
