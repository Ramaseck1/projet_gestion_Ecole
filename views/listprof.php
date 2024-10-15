<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Professeurs</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 h-screen flex flex-col items-center">
    <h1 class="text-3xl font-bold mt-8">Liste des Professeurs</h1>
    <table class="table-auto w-3/4 mt-8">
        <thead>
            <tr>
                <th class="px-4 py-2">Nom</th>
                <th class="px-4 py-2">Prénom</th>
                <th class="px-4 py-2">Spécialité</th>
                <th class="px-4 py-2">Grade</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($professors as $professor): ?>
                <tr>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($professor['nom'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($professor['prenom'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($professor['specialite'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($professor['grade'], ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>

