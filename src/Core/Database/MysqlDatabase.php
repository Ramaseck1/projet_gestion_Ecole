<?php

namespace ProjetGestionPedagogique\Core\Database;

use PDO;
use Dotenv\Dotenv;
use PDOException;

class MysqlDatabase {
    private static $instance = null;
    protected $pdo;

    protected function __construct() {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../../');
        $dotenv->load();

        $host = $_ENV['DB_HOST'];
        $dbname = $_ENV['DB_NAME'];
        $user = $_ENV['DB_USER'];
        $pass = $_ENV['DB_PASS'];

        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Erreur de connexion : ' . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function prepare($statement) {
        return $this->pdo->prepare($statement);
    }

    public function getConnection() {
        return $this->pdo;
    }
}
?>
