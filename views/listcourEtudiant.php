<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Pédagogique</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .bg-custom-purple {
            background-color: #663399;
        }

        .text-custom-orange {
            color: #FFA500;
        }

        .bg-custom-orange {
            background-color: #FFA500;
        }
    </style>
</head>

<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-white shadow">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="text-2xl font-bold text-custom-purple"><span class="text-blue-500"> Ecole</span>  <span class="text-custom-orange ">221</span> </div>
            <nav class="space-x-4 flex">
                <a href="#" class="text-gray-600 hover:text-custom-purple">Accueil</a>
                <a href="#" class="text-gray-600 hover:text-custom-purple">Mes cours</a>
                <form action="/calendar" method="POST">
                        <button  value="<?php echo htmlspecialchars($_SESSION['user']->getId()) ;?>"   class=" items-center p-2 text-gray-700 hover:bg-blue-100 -mt-5  rounded-lg">
                            <span class="material-icons"></span>
                            <span class="ml-2">calendrier</span>
                        </button>
                        </form>            </nav>
            <div class="relative flex gap-4">
            <div class="bg-gray-200 text-gray-700 py-2 px-4 rounded-full">
                <span> <?php echo htmlspecialchars($_SESSION['user']->getNom().'  '.$_SESSION['user']->getPrenom()); ?> </span>
            </div>
            <a href="/logout"class="mt-3">Se déconnecter</a>
        </div>
            </div>
        </div>
    </header>

    <!-- Main content -->
    <main class="container mx-auto px-4 py-8 flex">
        <div class="w-3/4">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Mes cours</h2>
            </div>

            <div class="flex space-x-4 mb-4">
                <div class="relative">
                    <select class="bg-gray-200 text-gray-700 py-2 px-4 rounded-full">
                        <option value="all">Tout</option>
                        <!-- Ajoutez d'autres options ici si nécessaire -->
                    </select>
                </div>
                <button class="bg-gray-200 text-gray-700 py-2 px-4 rounded-full">Filtre par module</button>
                <button class="bg-gray-200 text-gray-700 py-2 px-4 rounded-full">Filtre par semestre</button>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <!-- Card 1 -->
                <?php foreach($coursesEtudiant as $course):?>
                <div class="bg-white rounded-lg shadow">
                    <img class="rounded-t-lg" src="https://via.placeholder.com/300" alt="Course Image">
                    <div class="p-4">
                        <div class="flex gap-40"> 
                        <h3 class="text-lg font-semibold"><?php echo htmlspecialchars($course['Nomocour'], ENT_QUOTES, 'UTF-8'); ?></h3>
                        <h3 class="text-lg font-semibold"><?php echo htmlspecialchars($course['classe_nom'], ENT_QUOTES, 'UTF-8'); ?></h3></div>
                        <p class="text-gray-600"><?php echo htmlspecialchars($course['Nommodule'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <div class="flex justify-between items-center mt-4">
                            <button class="bg-custom-orange text-white py-2 px-4 rounded-full">voir cours</button>
                            <span class="text-gray-600"><?php echo htmlspecialchars($course['Nomsemestre'], ENT_QUOTES, 'UTF-8'); ?></span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <!-- Répétez les cartes pour chaque cours -->
               
              
              
              
            </div>

            <div class="relative mt-8">
                <select class="bg-gray-200 text-gray-700 py-2 px-4 rounded-full">
                    <option value="all">Afficher Tout</option>
                    <!-- Ajoutez d'autres options ici si nécessaire -->
                </select>
            </div>
        </div>

        <!-- Sidebar -->
        <aside class=" p-4 w-1/4 ml-8 mt-10 ">
            <h1 class="text-lg font-semibold text-blue-500 text-2xl">Annonce de ce mois</h1>
            <div class="mt-4  bg-white  shadow-lg p-4 h-80" style="height:70vh">
                <p class="text-sm text-gray-600">15 juil 13:00</p>
                <p class="text-sm text-gray-600">bbbbbbbbbbbbbbbbb bbbbbbbbbbbbbbbbbbb bbbbbbbbbbbbbbbbbb bbbbbbbbbbbbbbbbbbb</p>
            </div>
        </aside>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-200 text-center py-4 mt-8">
        <p class="text-gray-600">Copy right</p>
    </footer>
</body>

</html>
