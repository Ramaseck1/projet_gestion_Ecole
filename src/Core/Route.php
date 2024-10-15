<?php

namespace ProjetGestionPedagogique\Core;

use ProjetGestionPedagogique\Core\Database\MysqlDatabase;
use ReflectionClass;
use ReflectionException;

class Route {
    private array $routes = [];

    public function ajouterRoute(string $chemin, string $controleur, string $methode) {
        $this->routes[$chemin] = [
            'controleur' => $controleur,
            'methode' => $methode
        ];
    }

    public function routers(string $chemin) {
        foreach ($this->routes as $route => $details) {
            if (preg_match("#^" . preg_quote($route, "#") . "(\?.*)?$#", $chemin, $matches)) {
                $nomControleur = $details['controleur'];
                $nomMethode = $details['methode'];

                try {
                    $classeReflection = new ReflectionClass($nomControleur);

                    if ($classeReflection->isInstantiable()) {
                        $params = $this->getConstructorParams($classeReflection);
                        $controleur = $classeReflection->newInstanceArgs($params);

                        if ($classeReflection->hasMethod($nomMethode)) {
                            $methodeReflection = $classeReflection->getMethod($nomMethode);

                            if ($methodeReflection->isPublic()) {
                                $queryParams = $_GET;
                                $methodeReflection->invoke($controleur, $queryParams);
                                return;
                            } else {
                                echo "404 - Méthode non publique pour le chemin";
                                return;
                            }
                        } else {
                            echo "404 - Méthode non trouvée pour le chemin";
                            return;
                        }
                    } else {
                        echo "404 - Contrôleur non instanciable pour le chemin";
                        return;
                    }
                } catch (ReflectionException $e) {
                    echo "404 - Erreur de réflexion : " . $e->getMessage();
                    return;
                }
            }
        }

        echo "404 - Chemin non trouvé";
    }

    private function getConstructorParams(ReflectionClass $classeReflection): array {
        $params = [];
        $constructor = $classeReflection->getConstructor();

        if ($constructor) {
            foreach ($constructor->getParameters() as $param) {
                $paramClass = $param->getType();
                if ($paramClass && !$paramClass->isBuiltin()) {
                    $paramClassName = $paramClass->getName();
                    if ($paramClassName === 'ProjetGestionPedagogique\App\Models\UserModel') {
                        $paramInstance = new $paramClassName(MysqlDatabase::getInstance()->getConnection());
                    } else {
                        $paramInstance = new $paramClassName();
                    }
                    $params[] = $paramInstance;
                } else {
                    $params[] = null;
                }
            }
        }

        return $params;
    }
}

?>
