<?php
session_start();
require 'models/produits/Database.php';
require 'models/ProduitModel.php';

$produitModel = new ProduitModel();

// Récupérer toutes les catégories disponibles
$categories = $produitModel->getCategories();

// Si une catégorie est sélectionnée
$categorie_selected = $_GET['categorie'] ?? null;
$produits = [];

if ($categorie_selected) {
    $produits = $produitModel->getProduitsByCategorie($categorie_selected);
}

$title = "Catégories";
$page = "categories.php";
$header = "Catégories";
?>

<?php require 'composants/head.php'; ?>
<?php require 'composants/nav.php'; ?>
<?php require 'composants/header.php'; ?>

<section class="bg-white dark:bg-gray-900 min-h-screen">
    <div class="max-w-6xl mx-auto p-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Catégories de produits</h1>

        <!-- Liste des catégories -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <?php foreach ($categories as $categorie): ?>
                <a href="categories.php?categorie=<?= urlencode($categorie) ?>"
                   class="block p-4 text-center bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg shadow transition">
                    <?= htmlspecialchars($categorie) ?>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Produits de la catégorie sélectionnée -->
        <?php if ($categorie_selected): ?>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                Produits dans la catégorie : <?= htmlspecialchars($categorie_selected) ?>
            </h2>

            <?php if (empty($produits)): ?>
                <p class="text-gray-600 dark:text-gray-300">Aucun produit trouvé dans cette catégorie.</p>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <?php foreach ($produits as $produit): ?>
                        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg overflow-hidden">
                            <img src="upload/<?= htmlspecialchars($produit['image']) ?>"
                                 alt="<?= htmlspecialchars($produit['name']) ?>"
                                 class="w-full h-48 object-cover">

                            <div class="p-4">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                                    <?= htmlspecialchars($produit['name']) ?>
                                </h3>
                                <p class="text-blue-600 dark:text-blue-400 font-semibold">
                                    <?= htmlspecialchars($produit['price']) ?> <?= htmlspecialchars($produit['devise']) ?>
                                </p>
                                <p class="text-gray-600 dark:text-gray-300 mt-1 text-sm">
                                    <?= htmlspecialchars($produit['descriptions']) ?>
                                </p>
                                <a href="produit.php?id=<?= $produit['id'] ?>"
                                   class="mt-3 inline-block bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm">
                                    Voir le produit
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<?php require 'composants/footer.php'; ?>
