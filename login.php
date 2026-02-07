<?php
session_start();

// Rediriger si déjà connecté
if(isset($_SESSION['user'])) {
    // Redirection selon le rôle
    if($_SESSION['user']['role'] === 'admin'){
        header('Location: admin/admin_dashboard.php');
    } else {
        header('Location: index.php');
    }
    exit;
}
require 'models/produits-data.php';
$error = "";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = $userModel->authenticate($email, $password);

    if($user){
        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'],
            'avatar' => $user['avatar']
        ];
        session_regenerate_id(true);

        // Redirection selon le rôle
        if($user['role'] === 'admin'){
            header('Location: admin/admin_products.php');
        } else {
            header('Location: index.php');
        }
        exit;
    } else {
        $error = "Email ou mot de passe incorrect";
    }
}

$title = "Connexion";
$page = "login.php";
?>

<section class="bg-gray-50 dark:bg-gray-900 min-h-screen flex items-center justify-center">
    <?php require 'composants/head.php'; ?>

    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0 w-full max-w-md">
        <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
            <img class="rounded-full w-14 h-14 mr-2" src="assets/logo.jpg" alt="Logo">
            Tangawisa
        </a>

        <div class="w-full bg-white rounded-2xl shadow dark:border dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white text-center">
                    Connexion à votre compte
                </h1>

                <form class="space-y-4 md:space-y-6" action="login.php" method="POST">
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <input type="email" name="email" id="email" placeholder="name@trucspaschers.com" required
                               class="bg-gray-50 border border-gray-300 text-gray-900 rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    </div>

                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mot de passe</label>
                        <input type="password" name="password" id="password" placeholder="••••••••" required
                               class="bg-gray-50 border border-gray-300 text-gray-900 rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    </div>

                    <?php if($error): ?>
                        <div class="p-3 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-700 dark:text-red-400 text-center">
                            <span class="font-medium"><?= $error ?></span>
                        </div>
                    <?php endif; ?>

                    <button type="submit"
                            class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900">
                        Connexion
                    </button>

                    <p class="text-sm font-light text-gray-500 dark:text-gray-400 text-center">
                        Pas encore de compte ?  
                        <a href="register.php" class="font-medium text-blue-600 hover:underline dark:text-blue-400">Créer un compte</a>
                    </p>
                </form>
            </div>
        </div>
    </div>

    <?php require 'composants/footer.php'; ?>
</section>
