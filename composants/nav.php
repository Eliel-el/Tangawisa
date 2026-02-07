<?php
$same = "rounded-md px-3 py-2 text-sm font-medium ";
$current = $same . " bg-blue-900 text-white";
$default = $same . " text-gray-300 hover:bg-gray-700 hover:text-white";

// Utilisateur depuis la session
$user = $_SESSION['user'] ?? null;
?>
<nav class="bg-gray-800 relative">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">

            <!-- Logo -->
            <div class="flex items-center">
                <img class="h-10 w-10 rounded-full" src="assets/logo.jpg" alt="Logo">

                <!-- Liens desktop -->
                <div class="hidden md:flex ml-10 space-x-4">
                    <a href="index.php" class="<?= ($page === 'index.php') ? $current : $default; ?>">Accueil</a>
                    <a href="produits.php" class="<?= ($page === 'produits.php') ? $current : $default; ?>">Produits</a>
                    <a href="recherche.php" class="<?= ($page === 'recherche.php') ? $current : $default; ?>">Recherche</a>
                    <a href="categories.php" class="<?= ($page === 'categories.php') ? $current : $default; ?>">Catégories</a>
                    <a href="contact.php" class="<?= ($page === 'contact.php') ? $current : $default; ?>">Contact</a>
                </div>
            </div>

            <!-- Menu utilisateur desktop -->
            <div class="hidden md:flex items-center space-x-4 relative">
                <?php if ($user) : ?>
                    <div class="relative">
                        <button id="user-menu-button" class="focus:outline-none">
                            <img class="h-10 w-10 rounded-full border-2 border-gray-300"
                                 src="<?= $user['avatar'] ?? 'assets/default-avatar.png'; ?>" alt="Profil">
                        </button>

                        <div id="user-menu"
                             class="hidden absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg py-3 text-gray-800 z-50">
                            <!-- Vue profil -->
                            <div id="profile-view" class="px-4">
                                <div class="flex items-center space-x-3">
                                    <img class="h-12 w-12 rounded-full"
                                         src="<?= $user['avatar'] ?? 'assets/default-avatar.png'; ?>" alt="">
                                    <div>
                                        <p class="font-bold"><?= htmlspecialchars($user['name'] ?? "Utilisateur") ?></p>
                                        <p class="text-sm text-gray-500"><?= htmlspecialchars($user['email'] ?? "") ?></p>
                                    </div>
                                </div>
                                <div class="mt-3 space-y-2">
                                    <button id="edit-profile-btn" class="w-full bg-gray-200 hover:bg-gray-300 text-sm py-1 rounded-md">
                                        Modifier le profil
                                    </button>
                                    <a href="logout.php"
                                       class="block text-center w-full bg-red-500 hover:bg-red-600 text-white text-sm py-1 rounded-md">
                                        Déconnexion
                                    </a>
                                </div>
                            </div>

                            <!-- Formulaire édition -->
                            <div id="profile-edit" class="hidden px-4">
                                <form method="POST" action="update_profile.php" enctype="multipart/form-data" class="space-y-2">
                                    <input type="text" name="name" value="<?= htmlspecialchars($user['name'] ?? '') ?>"
                                           class="w-full border rounded px-2 py-1 text-sm">
                                    <input type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>"
                                           class="w-full border rounded px-2 py-1 text-sm">
                                    <input type="password" name="password" placeholder="Nouveau mot de passe"
                                           class="w-full border rounded px-2 py-1 text-sm">
                                    <div>
                                        <label class="block text-sm font-medium">Photo de profil</label>
                                        <input type="file" name="avatar" accept="image/*"
                                               class="w-full border rounded px-2 py-1 text-sm">
                                    </div>
                                    <div class="flex space-x-2">
                                        <button type="submit"
                                                class="w-1/2 bg-green-500 hover:bg-green-600 text-white text-sm py-1 rounded-md">
                                            Enregistrer
                                        </button>
                                        <button type="button" id="cancel-edit"
                                                class="w-1/2 bg-gray-300 hover:bg-gray-400 text-sm py-1 rounded-md">
                                            Annuler
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php else : ?>
                    <a href="login.php" class="<?= ($page === 'login.php') ? $current : $default; ?>">Se connecter</a>
                <?php endif; ?>
            </div>

            <!-- Menu mobile -->
            <div class="md:hidden flex items-center justify-between W-full px-6">
                <!-- Liens horizontal avec icônes -->
                <div class="flex space-x-3 justify-between w-3/4">
                    <a href="index.php" class="text-gray-300 hover:text-white">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3"/>
                        </svg>
                    </a>
                    <a href="produits.php" class="text-gray-300 hover:text-white">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6"/>
                        </svg>
                    </a>
                    <a href="recherche.php" class="text-gray-300 hover:text-white">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </a>
                    <a href="categories.php" class="text-gray-300 hover:text-white">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </a>
                    <a href="contact.php" class="text-gray-300 hover:text-white">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 1118 0z"/>
                        </svg>
                    </a>
                </div>

                <!-- Bouton profil mobile -->
                <?php if ($user) : ?>
                <div class="relative">
                    <button id="user-menu-button-mobile" class="focus:outline-none ml-2">
                        <img class="h-10 w-10 rounded-full border-2 border-gray-300"
                             src="<?= $user['avatar'] ?? 'assets/default-avatar.png'; ?>" alt="Profil">
                    </button>

                    <div id="user-menu-mobile" class="hidden absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg py-3 text-gray-800 z-50">
                        <div id="mobile-profile-view" class="px-4">
                            <div class="flex items-center space-x-3">
                                <img class="h-12 w-12 rounded-full" src="<?= $user['avatar'] ?? 'assets/default-avatar.png'; ?>" alt="">
                                <div>
                                    <p class="font-bold"><?= htmlspecialchars($user['name'] ?? "Utilisateur") ?></p>
                                    <p class="text-sm text-gray-500"><?= htmlspecialchars($user['email'] ?? "") ?></p>
                                </div>
                            </div>
                            <div class="mt-3 space-y-2">
                                <button id="mobile-edit-profile-btn" class="w-full bg-gray-200 hover:bg-gray-300 text-sm py-1 rounded-md">
                                    Modifier le profil
                                </button>
                                <a href="logout.php" class="block text-center w-full bg-red-500 hover:bg-red-600 text-white text-sm py-1 rounded-md">
                                    Déconnexion
                                </a>
                            </div>
                        </div>
                        <div id="mobile-profile-edit" class="hidden px-4">
                            <form method="POST" action="update_profile.php" enctype="multipart/form-data" class="space-y-2 mt-2">
                                <input type="text" name="name" value="<?= htmlspecialchars($user['name'] ?? '') ?>" class="w-full border rounded px-2 py-1 text-sm text-black">
                                <input type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" class="w-full border rounded px-2 py-1 text-sm text-black">
                                <input type="password" name="password" placeholder="Nouveau mot de passe" class="w-full border rounded px-2 py-1 text-sm text-black">
                                <div>
                                    <label class="block text-sm font-medium">Photo de profil</label>
                                    <input type="file" name="avatar" accept="image/*" class="w-full border rounded px-2 py-1 text-sm text-black">
                                </div>
                                <div class="flex space-x-2">
                                    <button type="submit" class="w-1/2 bg-green-500 hover:bg-green-600 text-white text-sm py-1 rounded-md">Enregistrer</button>
                                    <button type="button" id="mobile-cancel-edit" class="w-1/2 bg-gray-300 hover:bg-gray-400 text-sm py-1 rounded-md text-black">Annuler</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<script>
    // Desktop menu profil
    const userBtn = document.getElementById("user-menu-button");
    const userMenu = document.getElementById("user-menu");
    if(userBtn){ userBtn.addEventListener("click", ()=>{ userMenu.classList.toggle("hidden"); }); }

    const editBtn = document.getElementById("edit-profile-btn");
    const profileView = document.getElementById("profile-view");
    const profileEdit = document.getElementById("profile-edit");
    const cancelEdit = document.getElementById("cancel-edit");
    if(editBtn){ editBtn.addEventListener("click", ()=>{ profileView.classList.add("hidden"); profileEdit.classList.remove("hidden"); }); }
    if(cancelEdit){ cancelEdit.addEventListener("click", ()=>{ profileEdit.classList.add("hidden"); profileView.classList.remove("hidden"); }); }

    // Mobile menu profil
    const userBtnMobile = document.getElementById("user-menu-button-mobile");
    const userMenuMobile = document.getElementById("user-menu-mobile");
    if(userBtnMobile){ userBtnMobile.addEventListener("click", ()=>{ userMenuMobile.classList.toggle("hidden"); }); }

    const mobileEditBtn = document.getElementById("mobile-edit-profile-btn");
    const mobileProfileView = document.getElementById("mobile-profile-view");
    const mobileProfileEdit = document.getElementById("mobile-profile-edit");
    const mobileCancelEdit = document.getElementById("mobile-cancel-edit");
    if(mobileEditBtn){ mobileEditBtn.addEventListener("click", ()=>{ mobileProfileView.classList.add("hidden"); mobileProfileEdit.classList.remove("hidden"); }); }
    if(mobileCancelEdit){ mobileCancelEdit.addEventListener("click", ()=>{ mobileProfileEdit.classList.add("hidden"); mobileProfileView.classList.remove("hidden"); }); }
</script>
