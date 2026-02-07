<?php
// Démarrer la session
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

require 'models/produits-data.php';
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"] ?? null;
    $price = $_POST["price"] ?? null;
    $devise = $_POST["devise"] ?? null;
    $type = $_POST["type"] ?? null;
    $descriptions = $_POST["descriptions"] ?? null;

    // Traitement de l'image
    $image = $_FILES["image"]["name"] ?? null;
    $image_tmp_name = $_FILES["image"]["tmp_name"] ?? null;

    if ($image_tmp_name && $image) {
        move_uploaded_file($image_tmp_name, "upload/" . $image);
    } else {
        $image = null;
    }

    if ($name && $price && $devise && $type && $descriptions && $image) {
        $produitModel->createProduit($name, $price, $devise, $type, $image, $descriptions);
        $success = true;
    } else {
        echo "<p style='color: red;'>Veuillez remplir tous les champs correctement.</p>";
    }
}

$title = "Nouveau produit";
$header = "Ajouter un nouveau produit";
$page = "create.php";
?>

<section class="bg-white border-gray-200 shadow-sm dark:bg-gray-900">
    <section class="bg-white dark:bg-gray-900">
        <?php require 'composants/head.php'; ?>
        <?php require 'composants/nav.php'; ?>
        <?php require 'composants/header.php'; ?>
        <?php require 'composants/main.php'; ?>

        <?php if ($success) : ?>
            <div class="max-w-sm mx-auto p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                Le produit <span class="font-medium"><?php echo htmlspecialchars($name) ?></span> a été ajouté avec succès.
            </div>
        <?php endif; ?>

        <div>
            <form class="max-w-sm mx-auto" action="create.php" method="POST" enctype="multipart/form-data">
                <!-- Nom -->
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nom du produit :</label>
                <input type="text" id="name" name="name" required
                    class="block w-full h-11 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />

                <!-- Prix -->
                <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Prix :</label>
                <input type="number" id="price" name="price" step="0.01" required
                    class="block w-full h-11 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />

                <!-- Devise -->
                <label for="devise" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Devise :</label>
                <select id="devise" name="devise" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full h-11 p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">Choisir la devise</option>
                    <option value="FC">FC</option>
                    <option value="$">$</option>
                </select>

                <!-- Type -->
                <label for="type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Type :</label>
                <input type="text" id="type" name="type" required
                    class="block w-full h-11 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />

                <!-- Image -->
                <label for="image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ajouter une image :</label>
                <input type="file" name="image" id="image" accept="image/*" required
                    class="block w-full h-11 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />

                <!-- Description -->
                <label for="descriptions" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description du produit :</label>
                <textarea id="descriptions" name="descriptions" rows="4" required
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    placeholder="Entrez la description du produit"></textarea>

                <!-- Bouton -->
                <button type="submit"
                    class="mt-4 inline-flex justify-center items-center py-3 px-5 w-full text-base font-medium text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900">
                    Ajouter
                </button>
            </form>
        </div>
    </section>
</section>

<?php require 'composants/footer.php'; ?>
