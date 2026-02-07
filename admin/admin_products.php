<?php
// Démarrer la session
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

require '../models/produits-data.php';

$success = false;
$error = false;

// Ajouter un produit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create'])) {
    $name = $_POST["name"] ?? null;
    $price = $_POST["price"] ?? null;
    $devise = $_POST["devise"] ?? null;
    $type = $_POST["type"] ?? null;
    $descriptions = $_POST["descriptions"] ?? null;

    $image = $_FILES["image"]["name"] ?? null;
    $image_tmp_name = $_FILES["image"]["tmp_name"] ?? null;

    if ($image_tmp_name && $image) {
        move_uploaded_file($image_tmp_name, "../upload/" . $image);
    }

    if ($name && $price && $devise && $type && $descriptions && $image) {
        $produitModel->createProduit($name, $price, $devise, $type, $image, $descriptions);
        $success = "Produit ajouté avec succès.";
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}

// Modifier un produit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = intval($_POST["id"]);
    $name = $_POST["name"] ?? null;
    $price = $_POST["price"] ?? null;
    $devise = $_POST["devise"] ?? null;
    $type = $_POST["type"] ?? null;
    $descriptions = $_POST["descriptions"] ?? null;

    $image = $_FILES["image"]["name"] ?? null;
    $image_tmp_name = $_FILES["image"]["tmp_name"] ?? null;

    if ($image_tmp_name && $image) {
        move_uploaded_file($image_tmp_name, "../upload/" . $image);
    } else {
        $image = $_POST["old_image"]; // garder l’ancienne image si aucune nouvelle
    }

    if ($name && $price && $devise && $type && $descriptions && $image) {
        $produitModel->updateProduit($id, $name, $price, $devise, $type, $image, $descriptions);
        $success = "Produit modifié avec succès.";
    } else {
        $error = "Veuillez remplir tous les champs pour la modification.";
    }
}

// Supprimer un produit
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $produitModel->deleteProduit($id);
    $success = "Produit supprimé avec succès.";
}

// Charger la liste des produits
$produits = $produitModel->all();

$title = "Gestion des produits";
$page = "admin_products.php";
$header = "Gestion des produits";
?>

<section class="bg-white border-gray-200 shadow-sm dark:bg-gray-900">
    <section class="bg-white dark:bg-gray-900">
        <?php require '../composants/head.php'; ?>
        <?php require 'nav_admin.php'; ?>
        <?php require '../composants/header.php'; ?>
        <?php require '../composants/main.php'; ?>

        <div class="max-w-5xl mx-auto p-6">
            <h2 class="text-2xl font-bold mb-4 text-orange-500">Gestion des produits</h2>

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

            <!-- Formulaire d'ajout -->
            <form class="grid gap-4 mb-8" action="admin_products.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="create" value="1">

                <input type="text" name="name" placeholder="Nom du produit" required
                    class="block w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-white" />

                <input type="number" step="0.01" name="price" placeholder="Prix" required
                    class="block w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-white" />

                <select name="devise" required
                    class="block w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                    <option value="">Devise</option>
                    <option value="FC">FC</option>
                    <option value="$">$</option>
                </select>

                <input type="text" name="type" placeholder="Type (ex: Chaussures, Téléphones)" required
                    class="block w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-white" />

                <label class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed rounded-xl cursor-pointer bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600 transition">
    <div class="flex flex-col items-center justify-center pt-5 pb-6">
        <!-- Icône Upload -->
        <svg aria-hidden="true" class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 16v-8m0 0l-3 3m3-3l3 3m6 5a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <!-- Texte -->
        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Cliquez pour uploader</span> ou glissez-déposez</p>
        <p class="text-xs text-gray-400 dark:text-gray-300">PNG, JPG, JPEG (MAX. 5MB)</p>
    </div>
    <!-- Input file masqué -->
    <input type="file" name="image" accept="image/*" class="hidden" />
</label>

                <textarea name="descriptions" rows="3" placeholder="Description..." required
                    class="block w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-white"></textarea>

                <button type="submit"
                    class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded-lg">
                    ➕ Ajouter le produit
                </button>
            </form>

            <!-- Liste des produits -->
            <h3 class="text-xl font-semibold mb-3">Produits existants</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php foreach ($produits as $produit): ?>
                    <div class="border rounded-lg p-4 bg-gray-100 dark:bg-gray-800">
                        <img src="../upload/<?= htmlspecialchars($produit['image']) ?>" 
                             alt="<?= htmlspecialchars($produit['name']) ?>" 
                             class="h-40 w-full object-cover rounded mb-2">

                        <!-- Formulaire de modification inline -->
                        <form action="admin_products.php" method="POST" enctype="multipart/form-data" class="space-y-2">
                            <input type="hidden" name="update" value="1">
                            <input type="hidden" name="id" value="<?= $produit['id'] ?>">
                            <input type="hidden" name="old_image" value="<?= htmlspecialchars($produit['image']) ?>">

                            <input type="text" name="name" value="<?= htmlspecialchars($produit['name']) ?>" required
                                class="block w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-white" />

                            <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($produit['price']) ?>" required
                                class="block w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-white" />

                            <select name="devise" required
                                class="block w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                                <option value="FC" <?= $produit['devise'] == "FC" ? "selected" : "" ?>>FC</option>
                                <option value="$" <?= $produit['devise'] == "$" ? "selected" : "" ?>>$</option>
                            </select>

                            <input type="text" name="type" value="<?= htmlspecialchars($produit['type']) ?>" required
                                class="block w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-white" />

                           <label class="flex flex-col items-center justify-center w-full h-16 border-2 border-dashed rounded-xl cursor-pointer bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600 transition">
    <div class="flex items-center justify-center pt-5 pb-6">
        <!-- Icône Upload -->
        <svg aria-hidden="true" class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 16v-8m0 0l-3 3m3-3l3 3m6 5a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <!-- Texte -->
        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Cliquez pour uploader</span> ou glissez-déposez</p>
    </div>
    <!-- Input file masqué -->
    <input type="file" name="image" accept="image/*" class="hidden" />
</label>

                            <textarea name="descriptions" rows="3" required
                                class="block w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-white"><?= htmlspecialchars($produit['descriptions']) ?></textarea>

                            <div class="flex justify-between">
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">✏️ Modifier</button>
                                <a href="admin_products.php?delete=<?= $produit['id'] ?>" 
                                   onclick="return confirm('Supprimer ce produit ?')" 
                                   class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">🗑 Supprimer</a>
                            </div>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</section>

<?php require '../composants/footer.php'; ?>
