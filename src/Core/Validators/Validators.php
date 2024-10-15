<?php
namespace ProjetGestionPedagogique\Core\Validators;
class Validators
{
    private $errors = [];

    public function validate($data, $rules)
    {
        foreach ($rules as $field => $rulesArray) {
            foreach ($rulesArray as $rule) {
                if (is_string($rule)) {
                    $method = 'validate' . ucfirst($rule);
                    if (method_exists($this, $method)) {
                        $this->$method($field, $data[$field] ?? null);
                    }
                } elseif (is_array($rule) && isset($rule[0])) {
                    $method = 'validate' . ucfirst($rule[0]);
                    if (method_exists($this, $method)) {
                        $param = $rule[1] ?? null;
                        $this->$method($field, $data[$field] ?? null, $param);
                    }
                }
            }
        }

        return $this->errors;
    }
    private function validateRequired($field, $value)
    {
        if (empty($value)) {
            $this->errors[$field] = "Le champ $field est requis.";
        }
    }


    private function validateEmail($field, $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = "Le champ $field doit être une adresse email valide.";
        }
    }

    private function validateRegex($field, $value, $pattern)
    {
        if ($pattern !== null && !preg_match($pattern, $value)) {
            $this->errors[$field] = "Le champ $field n'est pas valide.";
        }
    }

    private function validateFile($field, $value, $required = false)
    {
        if ($required && (!isset($_FILES[$field]) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE)) {
            $this->errors[$field] = "Le champ $field est obligatoire.";
        } else {
            if (isset($_FILES[$field]) && $_FILES[$field]['error'] !== UPLOAD_ERR_NO_FILE) {
                $fileTmpPath = $_FILES[$field]['tmp_name'];
                $fileMimeType = mime_content_type($fileTmpPath);
                $allowedMimeTypes = ['image/jpeg', 'image/png'];
                $maxFileSize = 2048; // 2 MB

                if (!in_array($fileMimeType, $allowedMimeTypes)) {
                    $this->errors[$field] = "Le fichier téléchargé n'est pas une image JPEG ou PNG.";
                }

                if ($_FILES[$field]['size'] > $maxFileSize * 1024) {
                    $this->errors[$field] = "Le fichier téléchargé dépasse la taille maximale autorisée de 2MB.";
                }
            }
        }
    }

    private function validateMin($field, $value, $min)
    {
        if ($value !== null && strlen($value) < $min) {
            $this->errors[$field] = "Le champ $field doit contenir au moins $min caractères.";
        }
    }

    private function validateMaxLength($field, $value, $max)
    {
        if ($value !== null && strlen($value) > $max) {
            $this->errors[$field] = "Le champ $field ne doit pas dépasser $max caractères.";
        }
    }

    private function validateNumeric($field, $value)
    {
        if ($value !== null && !is_numeric($value)) {
            $this->errors[$field] = "Le champ $field doit être un nombre.";
        }
    }

    private function validateBetween($field, $value, $range)
    {
        if ($value !== null && ($value < $range[0] || $value > $range[1])) {
            $this->errors[$field] = "Le champ $field doit être compris entre {$range[0]} et {$range[1]}.";
        }
    }

    private function validateConfirmed($field, $value, $confirmationField)
    {
        global $_POST;
        if ($value !== ($_POST[$confirmationField] ?? '')) {
            $this->errors[$field] = "Le champ $field ne correspond pas au champ de confirmation.";
        }
    }

    public function hasErrors()
    {
        return !empty($this->errors);
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
