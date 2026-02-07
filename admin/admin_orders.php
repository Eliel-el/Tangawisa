<?php
// admin_orders.php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../403.php");
    exit();
}

require_once '../models/produits-data.php';

// Récupérer toutes les commandes
$orders = $orderModel->getRecentOrders(20); // dernieres 20 commandes

$title = "Gestion des commandes";
$page = "admin_orders.php";
$header = "Gestion des commandes";
?>

<section class="bg-white dark:bg-gray-900 min-h-screen">
    <?php require '../composants/head.php'; ?>
    <?php require 'nav_admin.php'; ?>
    <?php require '../composants/header.php'; ?>
    <?php require '../composants/main.php'; ?>

    <div class="max-w-6xl mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4 text-orange-500">Gestion des commandes</h2>

        <?php if (empty($orders)): ?>
            <div class="p-4 mb-4 text-gray-800 rounded-lg bg-gray-100 dark:bg-gray-800 dark:text-gray-200">
                Aucune commande pour le moment.
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php foreach ($orders as $order): ?>
                    <div class="border rounded-lg p-4 bg-gray-100 dark:bg-gray-800">
                        <h3 class="font-bold text-lg mb-2">Commande #<?= htmlspecialchars($order['id']) ?></h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300"><strong>Client :</strong> <?= htmlspecialchars($order['client_name'] ?? 'Inconnu') ?></p>
                        <p class="text-sm text-gray-600 dark:text-gray-300"><strong>Total :</strong> <?= htmlspecialchars($order['total']) ?> <?= htmlspecialchars($order['devise']) ?></p>
                        <p class="text-sm text-gray-500 italic"><strong>Date :</strong> <?= htmlspecialchars($order['date']) ?></p>

                        <div class="flex justify-between mt-3">
                            <a href="order_details.php?id=<?= $order['id'] ?>"
                               class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">📄 Détails</a>

                            <a href="admin_orders.php?delete=<?= $order['id'] ?>"
                               onclick="return confirm('Supprimer cette commande ?')"
                               class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">🗑 Supprimer</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require '../composants/footer.php'; ?>
