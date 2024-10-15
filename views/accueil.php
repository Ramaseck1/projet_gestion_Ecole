
<?php
$courses = $courses ?? []; // Assurez-vous que $courses est défini
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 h-screen flex">
    <!-- Sidebar -->
    <div class="w-1/4 bg-white shadow-md">
        <div class="p-6">
            <h1 class="text-3xl font-bold mb-8">Logo</h1>
            <nav>
                <ul>
                    <li class="mb-4">
                        <button  class="flex items-center p-2 text-blue-500 bg-blue-100 rounded-lg">
                            <span class="material-icons"></span>
                            <span class="ml-2">Dashboard</span>
                        </button>
                    </li>
                    <li class="mb-4">
                    <form action="/profs" method="POST">

                        <button  value="<?php echo htmlspecialchars($_SESSION['user']->getId()) ;?>" class="flex items-center p-2 text-gray-700 hover:bg-blue-100  rounded-lg">
                            <span class="material-icons"></span>
                            <span class="ml-2">Cours</span>
                        </button></form>
                    </li>
                    <li class="mb-4">
                        <form action="/session" method="POST">
                        <button  value="<?php echo htmlspecialchars($_SESSION['user']->getId()) ;?>"   class="flex items-center p-2 text-gray-700 hover:bg-blue-100  rounded-lg">
                            <span class="material-icons"></span>
                            <span class="ml-2">Sessions</span>
                        </button>
                        </form>
                    </li>
                    <li class="mb-4">
                        <button  class="flex items-center p-2 text-gray-700 hover:bg-blue-100 rounded-lg">
                            <span class="material-icons"></span>
                            <span class="ml-2">Demande d'annulations</span>
                        </button>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="w-3/4 p-8">
        <div class="flex justify-end items-center mb-8">
            <div class="flex items-center space-x-4">
                <span> <?php echo htmlspecialchars($_SESSION['user']->getNom().' '.$_SESSION['user']->getPrenom()); ?> <a href="/logout">Se déconnecter</a></span>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4 mb-8">
            <div>
                <label for="filter-day" class="block text-gray-700">Filtre par jour</label>
                <input type="text" id="filter-day" class="w-full p-2 border rounded-lg" placeholder="JJ/mm/AA">
            </div>
            <div>
                <label for="filter-week" class="block text-gray-700">Filtre par semaine</label>
                <input type="text" id="filter-week" class="w-full p-2 border rounded-lg" placeholder="semaine">
            </div>
        </div>
        <div class="bg-100 p-4 rounded-lg mb-4">
        
            <div class="flex items-center">
            <?php foreach ($courses as $course): ?>
               <!--  <img src="path/to/image.jpg" alt="Course Image" class="w-16 h-16 rounded-lg mr-4">
                <div>
                    <p>Module : Introduction à la Programmation</p>
                    <p  style="margin-left:700px">Semestre 1</p>
                </div> -->
                <?php endforeach; ?>
            </div>
           
        </div>
        <div class="bg-purple-100 p-4 rounded-lg mb-4">
        <div class="flex items-center">
                <img src="path/to/image.jpg" alt="Course Image" class="w-16 h-16 rounded-lg mr-4">
                <div>
                <h1 class="border px-4 py-2"><?php echo htmlspecialchars($course['Nomocour'], ENT_QUOTES, 'UTF-8'); ?></h1>

                    <p><?php echo htmlspecialchars($course['Nommodule'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p  style="margin-left:700px"><?php echo htmlspecialchars($course['Nomsemestre'], ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
            </div>
        </div>
        <div class="bg-blue-200 p-4 rounded-lg">
             <div class="flex items-center">
                <img src="path/to/image.jpg" alt="Course Image" class="w-16 h-16 rounded-lg mr-4">
                <div>
                <h1 class="border px-4 py-2"><?php echo htmlspecialchars($course['Nomocour'], ENT_QUOTES, 'UTF-8'); ?></h1>
                <p><?php echo htmlspecialchars($course['Nommodule'], ENT_QUOTES, 'UTF-8'); ?></p>
                <p  style="margin-left:700px"><?php echo htmlspecialchars($course['Nomsemestre'], ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar -->
    <div class="w-1/4 p-8">
        <h2 class="text-2xl font-bold mt-10 ">Calendrier</h2>
        <div class="bg-blue-100 p-4 rounded-lg">
            
        </div>
    </div>
</body>
</html>
