<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Cours par Professeur</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 h-screen flex gap-20">
    <div class="w-1/4 bg-white shadow-md">
        <div class="p-6">
            <h1 class="text-3xl font-bold mb-8">Logo</h1>
            <nav>
                <ul>
                    <li class="mb-4">
                        <button class="flex items-center p-2 text-blue-500 bg-blue-100 rounded-lg">
                            <span class="material-icons">dashboard</span>
                        </button>
                    </li>
                    <li class="mb-4">
                        <form action="/profs" method="POST">
                            <button class="flex items-center p-2 text-gray-700 hover:bg-blue-100 rounded-lg">
                                <span class="material-icons"></span>
                                <span class="ml-2">Cours</span>
                            </button>
                        </form>
                    </li>
                    <li class="mb-4">
                        <form action="/session" method="POST">
                            <button class="flex items-center p-2 text-gray-700 hover:bg-blue-100 rounded-lg">
                                <span class="material-icons"></span>
                                <span class="ml-2">Sessions</span>
                            </button>
                        </form>
                    </li>
                    <li class="mb-4">
                        <button class="flex items-center p-2 text-gray-700 hover:bg-blue-100 rounded-lg">
                            <span class="material-icons"></span>
                            <span class="ml-2">Demande d'annulations</span>
                        </button>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <div class="bg-gray-100 h-screen flex flex-col items-center">
        <div class="flex justify-end items-center mb-8 bg-gray-200 p-5 border rounded-20" style="margin-left:500px">
            <div class="flex items-center space-x-4">
                <span> <?php echo htmlspecialchars($_SESSION['user']->getNom().' '.$_SESSION['user']->getPrenom()); ?> <a href="/logout">Se déconnecter</a></span>
            </div>
        </div>

        <h1 class="text-3xl font-bold mt-8 mb-4 text-gray-800">Liste des Cours pour le Professeur</h1>
        <form method="GET" action="/profs" class="grid grid-cols-3 gap-4 mb-8" style="margin-left:-200px" onchange="this.submit()">
            <div>
                <label for="filter-semester" class="block text-gray-700 font-medium mb-2">Filtre par semestre</label>
                <select id="filter-semester" name="semester" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 ease-in-out">
                    <option value="">Choisir un semestre</option>
                    <?php foreach ($semesters as $semester): ?>
                        <option value="<?php echo htmlspecialchars($semester['Nomsemestre'], ENT_QUOTES, 'UTF-8'); ?>">
                            <?php echo htmlspecialchars($semester['Nomsemestre'], ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="filter-module" class="block text-gray-700 font-medium mb-2">Filtre par Module</label>
                <select id="filter-module" name="module" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 ease-in-out">
                    <option value="">Choisir un module</option>
                    <?php foreach ($modules as $module): ?>
                        <option value="<?php echo htmlspecialchars($module['Nommodule'], ENT_QUOTES, 'UTF-8'); ?>">
                            <?php echo htmlspecialchars($module['Nommodule'], ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>    
        <div class="w-11/12 lg:w-3/4" style="width:1000px">
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Nom du Cours</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Nom du Module</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Semestre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Classe</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($courses as $course): ?>
                        <tr class="hover:bg-gray-100">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo htmlspecialchars($course['Nomocour'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo htmlspecialchars($course['Nommodule'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo htmlspecialchars($course['Nomsemestre'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo htmlspecialchars($course['classe_nom'], ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="flex justify-center mt-4">
            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
        <a href="/profs?page=1" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-blue-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-50">
            <span>&laquo; Première</span>
        </a>
        <a href="/profs?page=<?php echo max($page - 1, 1); ?>" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-blue-500 bg-white border border-gray-300 hover:bg-gray-50">
            <span>&lsaquo;</span>
        </a>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="/profs?page=<?php echo $i; ?>" class="<?php echo $i == $page ? 'bg-blue-500 text-white' : 'bg-white text-blue-500'; ?> relative inline-flex items-center px-4 py-2 text-sm font-medium border border-gray-300 hover:bg-gray-50">
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>

        <a href="/profs?page=<?php echo min($page + 1, $totalPages); ?>" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-blue-500 bg-white border border-gray-300 hover:bg-gray-50">
            <span>&rsaquo;</span>
        </a>
        <a href="/profs?page=<?php echo $totalPages; ?>" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-blue-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-50">
            <span>Dernière &raquo;</span>
        </a>
    </nav>
            </div>
        </div>
    </div>
</body>
</html>
