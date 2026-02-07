<?php  session_start();
$title = "Accueil";
$page = "index.php";
 ?>


<?php require 'composants/head.php'; ?>
<?php require 'composants/nav.php'; ?>
<?php require 'composants/main.php'; ?>

<?php
       require 'models/articles-data.php'; 
       require 'models/produits-data.php';
   ?>


<section class="bg-white h-full dark:bg-gray-900">
    <div class="py-6 px-4 sm:py-8 sm:px-6 lg:py-16 lg:px-12 mx-auto max-w-screen-xl text-center">
        <!-- Alert / New -->
        <a href="categories.php"
           class="inline-flex flex-col sm:flex-row justify-center sm:justify-between items-center py-2 px-3 sm:px-4 mb-6 text-sm text-gray-700 bg-gray-100 rounded-full dark:bg-gray-800 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-700">
            <span class="text-xs sm:text-sm bg-blue-700 rounded-full text-white px-2 py-1 sm:px-3 sm:py-1 mr-0 sm:mr-2 mb-1 sm:mb-0">New</span>
            <span class="text-sm font-medium">Découvrir nos différentes catégories</span>
            <svg class="ml-0 sm:ml-2 w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                      d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                      clip-rule="evenodd"></path>
            </svg>
        </a>

        <!-- Titre -->
        <h1 class="mb-4 text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-extrabold leading-tight text-gray-900 dark:text-white">
            Bienvenue sur notre site Tangawisa
        </h1>

        <!-- Description -->
        <p class="mb-6 text-sm sm:text-base md:text-lg lg:text-xl font-normal text-gray-500 dark:text-gray-400 sm:px-8 lg:px-48">
            Ici nous vendons <strong>des produits</strong> de tout genre. Si vous voulez aussi vendre sur notre site, c'est très simple, veuillez contacter l'admin.
        </p>

        <!-- Boutons principaux -->
        <div class="flex flex-col sm:flex-row sm:justify-center sm:space-x-4 space-y-3 sm:space-y-0 mb-8 lg:mb-16">
            <a href="produits.php"
               class="inline-flex justify-center items-center py-2 px-4 sm:py-3 sm:px-5 text-sm sm:text-base font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900 transition">
                Découvrir nos produits
                <svg class="ml-1 sm:ml-2 w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                          d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                          clip-rule="evenodd"></path>
                </svg>
            </a>

            <a href="categories.php"
               class="inline-flex justify-center items-center py-2 px-4 sm:py-3 sm:px-5 text-sm sm:text-base font-medium text-blue-700 bg-gray-100 rounded-lg hover:bg-gray-200 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700 transition">
                Voir les catégories
            </a>
        </div>

        <!-- Featured In / Réseaux sociaux -->
        <div class="px-4 md:px-12 lg:px-36">
            <span class="font-semibold text-gray-400 uppercase text-xs sm:text-sm">FEATURED IN</span>
            <div class="flex flex-wrap justify-center sm:justify-evenly items-center mt-6 gap-4">
                <!-- WhatsApp -->
                <a href="#" class="flex flex-col items-center hover:text-green-500 transition">
                    <svg class="h-8 w-8 sm:h-10 sm:w-10" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M20.52 3.48C18.34 1.3 15.37 0 12 0 5.37 0 0 5.37 0 12c0 2.11.55 4.12 1.6 5.88L0 24l6.48-1.56C8.88 23.45 10.92 24 12 24c6.63 0 12-5.37 12-12 0-3.37-1.3-6.34-3.48-8.52zm-8.52 18.12c-1.85 0-3.66-.5-5.2-1.44l-.37-.22-3.84.93.97-3.73-.24-.38C2.42 15.67 1.92 13.85 1.92 12c0-5.54 4.5-10 10-10s10 4.46 10 10-4.5 10-10 10zm5.45-7.88c-.28-.14-1.65-.81-1.9-.9-.25-.09-.43-.14-.61.14-.18.28-.7.9-.86 1.09-.16.18-.32.2-.6.07-.28-.14-1.18-.44-2.24-1.38-.83-.74-1.39-1.65-1.55-1.93-.16-.28-.02-.43.12-.57.12-.12.28-.32.42-.48.14-.16.18-.28.28-.47.09-.18.05-.35-.02-.48-.07-.14-.61-1.48-.83-2.03-.22-.55-.44-.48-.61-.49l-.52-.01c-.18 0-.48.07-.73.35s-.96.94-.96 2.3c0 1.37.98 2.7 1.11 2.89.14.18 1.92 2.95 4.65 4.13.65.28 1.15.45 1.55.58.65.2 1.24.17 1.7.1.52-.08 1.65-.67 1.88-1.32.23-.66.23-1.22.16-1.32-.07-.09-.25-.14-.52-.28z"/>
                    </svg>
                    <span class="text-xs sm:text-sm mt-1">WhatsApp</span>
                </a>

                <!-- Facebook -->
                <a href="#" class="flex flex-col items-center hover:text-blue-600 transition">
                    <svg class="h-8 w-8 sm:h-10 sm:w-10" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M22.675 0H1.325C.593 0 0 .593 0 1.326v21.348C0 23.407.593 24 1.325 24h11.494v-9.294H9.691v-3.622h3.128V8.413c0-3.1 1.893-4.788 4.658-4.788 1.325 0 2.464.099 2.795.143v3.24h-1.918c-1.505 0-1.797.716-1.797 1.767v2.317h3.592l-.468 3.622h-3.124V24h6.127C23.407 24 24 23.407 24 22.674V1.326C24 .593 23.407 0 22.675 0z"/>
                    </svg>
                    <span class="text-xs sm:text-sm mt-1">Facebook</span>
                </a>

                <!-- Instagram -->
                <a href="#" class="flex flex-col items-center hover:text-pink-500 transition">
                    <svg class="h-8 w-8 sm:h-10 sm:w-10" viewBox="0 0 512 512" fill="currentColor">
                        <path d="M349.33 69.33H162.67C105.46 69.33 64 110.79 64 168v180c0 57.21 41.46 98.67 98.67 98.67h186.66C406.54 446.67 448 405.21 448 348V168c0-57.21-41.46-98.67-98.67-98.67zM256 352c-52.94 0-96-43.06-96-96s43.06-96 96-96 96 43.06 96 96-43.06 96-96 96zm104-176c-13.25 0-24-10.75-24-24s10.75-24 24-24 24 10.75 24 24-10.75 24-24 24z"/>
                        <circle cx="256" cy="256" r="64"/>
                    </svg>
                    <span class="text-xs sm:text-sm mt-1">Instagram</span>
                </a>
            </div>
        </div>
    </div>
</section>
<?php require 'composants/footer.php'; ?>