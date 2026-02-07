
<?php 
session_start();
require 'models/UserModel.php';

$userModel = new UserModel();

if(!isset($_SESSION['user'])){
    header('Location: login.php');
    exit;
}

// Récupérer les infos utilisateur
$user = $userModel->find($_SESSION['user']['id']);

$title = "Profil";
$page = "profil.php";
?>

<section class="bg-gray-50 dark:bg-gray-900 min-h-screen flex items-center justify-center">
    <?php require 'composants/head.php'; ?>

    <div class="w-full max-w-sm bg-white rounded-2xl shadow dark:bg-gray-800 dark:border dark:border-gray-700 p-6">
        <div class="flex flex-col items-center pb-6">
            <img class="w-24 h-24 mb-3 rounded-full shadow-lg" src="<?= $user['avatar'] ?>" alt="<?= $user['name'] ?>"/>
            <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white"><?= $user['name'] ?></h5>
            <span class="text-sm text-gray-500 dark:text-gray-400"><?= $user['email'] ?></span>

            

            <div class="flex mt-6 w-full justify-between">
                <a href="logout.php"
                   class="w-full text-center text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-xl text-sm px-5 py-3 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                    Déconnexion
                </a>
            </div>
        </div>
    </div>

    <?php require 'composants/footer.php'; ?>
</section>