<?php
session_start();
require 'models/produits/Database.php';
require 'models/ProduitModel.php';

$produitModel = new ProduitModel();

$title = "Recherche produit";
$page = "recherche.php";
$produits = [];
$search = "";
$header = "Résultats de recherche";

// Vérifier si un mot-clé est envoyé
if (!empty($_GET["q"])) {
    $search = trim($_GET["q"]);
    $produits = $produitModel->searchByNomOrType($search);

    if (count($produits) === 0) {
        $header = "Aucun produit trouvé";
    } else {
        $header = "Résultats de recherche";
    }
}
?>

<section class="bg-white border-gray-200 shadow-sm dark:bg-gray-900">
    <?php require 'composants/head.php'; ?>
    <?php require 'composants/nav.php'; ?>
    <?php require 'composants/header.php'; ?>

    <div class="mb-6 p-4">
        <!-- Formulaire de recherche -->
        <form action="recherche.php" method="get" class="flex gap-2">
            <input type="text" name="q" value="<?php echo htmlspecialchars($search); ?>" 
                placeholder="Rechercher un produit par nom, description ou prix..."
                class="w-full p-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300" />
            <button type="submit" 
                class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                Rechercher
            </button>
        </form>
    </div>

    <h2 class="text-xl font-semibold text-gray-900 dark:text-white px-4 mb-4">
        <?php echo htmlspecialchars($header); ?>
    </h2>

    <div class="grid grid-cols-3 gap-6 p-4">
        <?php foreach ($produits as $produit): ?>
            <div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <a href="produit.php?id=<?php echo $produit['id'] ?? 0; ?>">
                    <img class="p-8 rounded-t-lg" 
                          src="upload/<?= htmlspecialchars($produit['image']); ?>" 
                         alt="<?php echo htmlspecialchars($produit['name'] ?? 'Produit'); ?>" />
                </a>
                <div class="px-5 pb-5">
                    <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">
                        <?php echo htmlspecialchars($produit["name"] ?? 'Produit'); ?>
                    </h5>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                        <?php echo htmlspecialchars($produit["descriptions"] ?? ''); ?>
                    </p>
                    <div class="flex items-center justify-between">
                        <span class="text-2xl font-bold text-gray-900 dark:text-white">
                            <?php 
                                echo ($produit['price'] ?? '0') . ' ' . ($produit['devise'] ?? '');
                            ?>
                        </span>
                        <a href="produit.php?id=<?php echo $produit['id'] ?? 0; ?>" 
                           class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 
                                  font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 
                                  dark:focus:ring-blue-800">
                           Voir le produit
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php require 'composants/footer.php'; ?>
</section>
