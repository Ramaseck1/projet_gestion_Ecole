<?php
namespace ProjetGestionPedagogique\Core;

class File {

    public static function uploadImage($file, $uploadDir) {
        $errors = [];

        // Vérification des erreurs d'upload
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $errors['photo'] = "Erreur lors de l'upload de la photo.";
            return ['errors' => $errors, 'photoName' => null];
        }

        // Vérification du type MIME du fichier
        $fileTmpPath = $file['tmp_name'];
        $fileMimeType = mime_content_type($fileTmpPath);

        if (!in_array($fileMimeType, ['image/jpeg', 'image/png'])) {
            $errors['photo'] = "Le format de fichier de la photo n'est pas supporté.";
            return ['errors' => $errors, 'photoName' => null];
        }

        // Génération d'un nom unique pour le fichier
        $photoName = time() . '_' . basename($file['name']);
        $uploadedFile = $uploadDir . $photoName;

        // Vérification du répertoire de destination
        if (!is_dir($uploadDir)) {
            $errors['photo'] = "Le répertoire de destination n'existe pas.";
            return ['errors' => $errors, 'photoName' => null];
        }

        // Déplacement du fichier téléchargé vers le répertoire cible
        if (move_uploaded_file($fileTmpPath, $uploadedFile)) {
            return ['errors' => [], 'photoName' => $photoName];
        } else {
            $errors['photo'] = "Erreur lors de l'upload de la photo.";
            return ['errors' => $errors, 'photoName' => null];
        }
    }
}

?>
