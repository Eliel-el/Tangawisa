<?php
$same = "rounded-md px-3 py-2 text-sm font-medium transition-colors duration-200";
$current = $same . " bg-blue-700 text-white shadow-lg";
$default = $same . " text-gray-300 hover:bg-gray-700 hover:text-white";

$isAdmin = isset($_SESSION['user']) && ($_SESSION['user']['role'] ?? '') === 'admin';
?>

<nav class="bg-gray-900 shadow-lg">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">

            <!-- Logo -->
            <div class="flex items-center">
                <a href="admin_dashboard.php" class="flex items-center">
                    <img class="h-10 w-10 rounded-full border-2 border-blue-500" src="../assets/logo.jpg" alt="Logo">
                    <span class="text-white font-bold ml-2">Admin</span>
                </a>

                <!-- Liens desktop -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="admin_dashboard.php" class="<?= ($page === 'admin_dashboard.php') ? $current : $default ?>">Dashboard</a>
                        <a href="admin_products.php" class="<?= ($page === 'admin_products.php') ? $current : $default ?>">Produits</a>
                        <a href="admin_orders.php" class="<?= ($page === 'admin_orders.php') ? $current : $default ?>">Commandes</a>
                        <a href="admin_users.php" class="<?= ($page === 'admin_users.php') ? $current : $default ?>">Utilisateurs</a>
                    </div>
                </div>
            </div>

            <!-- Menu droit desktop -->
            <div class="hidden md:flex items-center space-x-4">
                <?php if($isAdmin): ?>
                    <span class="text-gray-300">Bonjour, <?= htmlspecialchars($_SESSION['user']['name']) ?></span>
                    <a href="../logout.php" class="<?= $default ?>">Déconnexion</a>
                <?php endif; ?>
            </div>

            <!-- Menu mobile bouton -->
            <div class="-mr-2 flex md:hidden">
                <button id="mobile-menu-button" class="inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white">
                    <svg class="h-6 w-6" id="icon-open" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg class="h-6 w-6 hidden" id="icon-close" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Menu mobile -->
    <div class="hidden md:hidden" id="mobile-menu">
        <div class="grid grid-cols-2 gap-2 px-2 pb-3 pt-2">
            <a href="admin_dashboard.php" class="<?= ($page === 'admin_dashboard.php') ? $current : $default ?> flex flex-col items-center p-2 hover:bg-blue-600 hover:text-white rounded-lg">
                <svg class="h-6 w-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M4 10v10h16V10"/>
                </svg>
                <span class="text-xs font-semibold">Dashboard</span>
            </a>
            <a href="admin_products.php" class="<?= ($page === 'admin_products.php') ? $current : $default ?> flex flex-col items-center p-2 hover:bg-blue-600 hover:text-white rounded-lg">
                <svg class="h-6 w-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V7a2 2 0 00-2-2h-4V3H10v2H6a2 2 0 00-2 2v6m16 0l-8 8-8-8"/>
                </svg>
                <span class="text-xs font-semibold">Produits</span>
            </a>
            <a href="admin_orders.php" class="<?= ($page === 'admin_orders.php') ? $current : $default ?> flex flex-col items-center p-2 hover:bg-blue-600 hover:text-white rounded-lg">
                <svg class="h-6 w-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6h13M9 11V4H5v7h4zm0 6v-6"/>
                </svg>
                <span class="text-xs font-semibold">Commandes</span>
            </a>
            <a href="admin_users.php" class="<?= ($page === 'admin_users.php') ? $current : $default ?> flex flex-col items-center p-2 hover:bg-blue-600 hover:text-white rounded-lg">
                <svg class="h-6 w-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1117.805 5.121 9 9 0 015.121 17.804z"/>
                </svg>
                <span class="text-xs font-semibold">Utilisateurs</span>
            </a>
            <a href="../logout.php" class="<?= $default ?> flex flex-col items-center p-2 hover:bg-red-600 hover:text-white rounded-lg">
                <svg class="h-6 w-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-6 0v-1m0-4V9a3 3 0 016 0v1"/>
                </svg>
                <span class="text-xs font-semibold">Déconnexion</span>
            </a>
        </div>
    </div>
</nav>

<script>
const btn = document.getElementById("mobile-menu-button");
const menu = document.getElementById("mobile-menu");
const iconOpen = document.getElementById("icon-open");
const iconClose = document.getElementById("icon-close");

btn.addEventListener("click", () => {
    menu.classList.toggle("hidden");
    iconOpen.classList.toggle("hidden");
    iconClose.classList.toggle("hidden");
});
</script>
