<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <h1 class="text-2xl font-bold mb-6 text-center">Connexion</h1>
        <form method="POST" action="/seConnecter" class="space-y-4">
            <div>
                <label for="email" class="block text-gray-700">Email:</label>
                <input type="email" id="email" name="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" >
                <?php if (isset($errors['email'])): ?>
                    <p class="text-red-500 text-sm"><?php echo htmlspecialchars($errors['email']); ?></p>
                <?php endif; ?>
            </div>
            <div>
                <label for="motDePasse" class="block text-gray-700">Mot de passe:</label>
                <input type="password" id="motDePasse" name="motDePasse" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" >
                <?php if (isset($errors['motDePasse'])): ?>
                    <p class="text-red-500 text-sm"><?php echo htmlspecialchars($errors['motDePasse']); ?></p>
                <?php endif; ?>
            </div>
            <div>
                <button type="submit" class="w-full bg-blue-300 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Se connecter</button>
            </div>
        </form>
        <?php if (isset($error)): ?>
            <p class="mt-4 text-red-500 text-center"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
