<?php 
// Démarrer la session et vérifier l'admin
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit();
}
if ($_SESSION['user']['role'] !== 'admin') {
    header("Location: ../403.php");
    exit();
}

// Au lieu de require
require_once '../models/produits-data.php';


$produitModel = new ProduitModel();
$userModel = new UserModel();
$orderModel = new OrderModel();

// Statistiques
$totalProduits = $produitModel->countProduits();
$totalUsers = $userModel->countUsers();
$totalOrders = $orderModel->countOrders();

// Commandes récentes
$recentOrders = $orderModel->getRecentOrders(5);

$title = "Dashboard Admin";
$page = "admin_dashboard.php";
?>

<section class="bg-white dark:bg-gray-900 min-h-screen">
    <?php require 'nav_admin.php'; ?>
    <?php require '../composants/head.php'; ?>

    <div class="max-w-5xl mx-auto p-6">
        <h2 class="text-2xl font-bold mb-6 text-orange-500">Tableau de bord</h2>

        <!-- Statistiques -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
            <div class="bg-orange-50 dark:bg-gray-800 p-6 rounded-lg shadow">
                <h3 class="text-gray-500 dark:text-gray-300 font-semibold">Produits</h3>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2"><?= $totalProduits ?></p>
            </div>

            <div class="bg-green-50 dark:bg-gray-800 p-6 rounded-lg shadow">
                <h3 class="text-gray-500 dark:text-gray-300 font-semibold">Utilisateurs</h3>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2"><?= $totalUsers ?></p>
            </div>

            <div class="bg-blue-50 dark:bg-gray-800 p-6 rounded-lg shadow">
                <h3 class="text-gray-500 dark:text-gray-300 font-semibold">Commandes</h3>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2"><?= $totalOrders ?></p>
            </div>
        </div>

        <!-- Commandes récentes -->
        <h3 class="text-xl font-semibold mb-4 text-orange-500">Commandes récentes</h3>
        <div class="overflow-x-auto bg-gray-50 dark:bg-gray-800 rounded-lg shadow p-4">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-200">ID</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-200">Client</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-200">Total</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-200">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    <?php foreach($recentOrders as $order): ?>
                        <tr class="bg-white dark:bg-gray-900">
                            <td class="px-4 py-2 text-sm text-gray-900 dark:text-white"><?= $order['id'] ?></td>
                            <td class="px-4 py-2 text-sm text-gray-900 dark:text-white"><?= htmlspecialchars($order['client_name']) ?></td>
                            <td class="px-4 py-2 text-sm text-gray-900 dark:text-white"><?= htmlspecialchars($order['total'] . ' ' . $order['devise']) ?></td>
                            <td class="px-4 py-2 text-sm text-gray-900 dark:text-white"><?= htmlspecialchars($order['date']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>
</section>

<?php require '../composants/footer.php'; ?>
