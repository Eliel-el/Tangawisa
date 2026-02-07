<?php
session_start();
require 'models/produits/Database.php';
require 'models/ProduitModel.php';

$produitModel = new ProduitModel();
$produits = $produitModel->all();

$title = "Produits";
$header = "Tous nos produits";
$page = "produits.php";
$adminNumber = "+243895964503"; // Numéro WhatsApp de l'administrateur
?>

<section class="bg-white dark:bg-gray-900">
    <?php require 'composants/head.php'; ?>
    <?php require 'composants/nav.php'; ?>
    <?php require 'composants/header.php'; ?>
    <?php require 'composants/main.php'; ?>

    <section class="p-6 max-w-7xl mx-auto">
        <!-- Grille responsive : 1 col par défaut, 2 col sur sm, 3 col sur lg -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($produits as $produit) : ?>
                <?php
                // Préparer le message pour WhatsApp
                $message = "Bonjour, je voudrais commander ce produit :\n\n"
                         . "📦 *Produit* : " . $produit['name'] . "\n"
                         . "💲 *Prix* : " . $produit['price'] . " " . $produit['devise'] . "\n"
                         . "🔖 *Type* : " . $produit['type'] . "\n"
                         . "📝 *Description* : " . $produit['descriptions'] . "\n\n"
                         . "Pouvez-vous me donner plus d’informations ?";
                $whatsappUrl = "https://wa.me/" . $adminNumber . "?text=" . urlencode($message);
                ?>

<!-- Carte produit -->
<div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm overflow-hidden flex flex-col w-full">
    <a href="produit.php?id=<?= $produit['id'] ?>" class="block">
        <img class="w-full h-48 sm:h-56 lg:h-64 object-cover transition-transform duration-300 hover:scale-105" 
             src="upload/<?= htmlspecialchars($produit['image']); ?>" 
             alt="<?= htmlspecialchars($produit['name']); ?>">
    </a>

    <div class="px-4 py-4 flex-1 flex flex-col justify-between">
        <div>
            <h5 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white truncate">
                <?= htmlspecialchars($produit['name']); ?>, <?= htmlspecialchars($produit['type']); ?>
            </h5>
            <span class="block mt-2 text-2xl font-bold text-gray-900 dark:text-white">
                <?= htmlspecialchars($produit['price']) . ' ' . htmlspecialchars($produit['devise']); ?>
            </span>
        </div>

        <!-- Boutons -->
        <div class="mt-4 flex flex-col sm:flex-row sm:space-x-3 space-y-2 sm:space-y-0">
            <a href="produit.php?id=<?= $produit['id'] ?>" 
               class="flex-1 text-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 sm:px-5 sm:py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition">
                Voir le produit
            </a>
            <a href="<?= $whatsappUrl ?>" target="_blank"
               class="flex-1 text-center inline-flex items-center justify-center px-4 py-2 sm:px-5 sm:py-2.5 bg-green-500 text-white font-medium rounded-lg shadow hover:bg-green-600 transition">
                WhatsApp
            </a>
        </div>
    </div>
</div>

            <?php endforeach; ?>
        </div>
    </section>

    <?php require 'composants/footer.php'; ?>
</section>

