<?php
session_start();
require 'models/produits/Database.php';
require 'models/ProduitModel.php';

$produitModel = new ProduitModel();

$title = "Produit";
$page = "produit.php";

// Récupérer l'ID du produit dans l'URL
$produit_id = isset($_GET["id"]) ? intval($_GET["id"]) : 1;

// Sélectionner le produit
$produit = $produitModel->selectProduit($produit_id);

// Valeurs sécurisées pour affichage
$nom_produit          = $produit['name'] ?? 'Produit inconnu';
$prix_produit         = $produit['price'] ?? 'N/A';
$devise_produit       = $produit['devise'] ?? '';
$type_produit         = $produit['type'] ?? 'Non spécifié';
$descriptions_produit = $produit['descriptions'] ?? 'Aucune description disponible.';
$image_produit        = $produit['image'] ?? 'default.jpg';

$header = $produit ? "Produit sélectionné : " . htmlspecialchars($nom_produit) : "Produit inexistant";

// Numéro WhatsApp admin
$adminNumber = "243900000000";
$message = "Bonjour, je souhaite commander le produit :\n\n"
         . "📦 Produit : $nom_produit\n"
         . "💲 Prix : $prix_produit $devise_produit\n"
         . "🔖 Catégorie : $type_produit\n"
         . "📝 Description : $descriptions_produit\n\nPouvez-vous me donner plus d'informations ?";
$whatsappUrl = "https://wa.me/$adminNumber?text=" . urlencode($message);
?>

<section class="bg-white dark:bg-gray-900 min-h-screen">
    <?php require 'composants/head.php'; ?>
    <?php require 'composants/nav.php'; ?>
    <?php require 'composants/header.php'; ?>
    <?php require 'composants/main.php'; ?>

    <!-- Page Produit -->
    <div class="max-w-6xl mx-auto p-6">
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg grid grid-cols-1 md:grid-cols-2 gap-8 p-6">
            
            <!-- Image produit -->
            <div class="flex justify-center items-center">
                <img class="rounded-lg w-full max-h-[500px] object-cover shadow-md"
                     src="upload/<?php echo htmlspecialchars($image_produit); ?>"
                     alt="<?php echo htmlspecialchars($nom_produit); ?>">
            </div>

            <!-- Détails produit -->
            <div class="flex flex-col justify-between">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                    <?php echo htmlspecialchars($nom_produit); ?>
                </h1>

                <p class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    Prix : <?= htmlspecialchars($prix_produit) . ' ' . htmlspecialchars($devise_produit); ?>
                </p>

                <p class="text-md text-gray-700 dark:text-gray-300 mb-4">
                    <strong>Catégorie :</strong> <?= htmlspecialchars($type_produit); ?>
                </p>

                <p class="text-base text-gray-600 dark:text-gray-400 mb-6 leading-relaxed">
                    <?= nl2br(htmlspecialchars($descriptions_produit)); ?>
                </p>

                <!-- Boutons -->
                <div class="flex flex-col sm:flex-row sm:space-x-3 space-y-3 sm:space-y-0">
                    <a href="produits.php"
                       class="flex-1 text-center px-5 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg shadow-md transition dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                        ← Retour
                    </a>
                    <a href="<?= $whatsappUrl ?>" target="_blank"
                       class="flex-1 text-center px-5 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow-md transition">
                        Commander via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php require 'composants/footer.php'; ?>
</section>
