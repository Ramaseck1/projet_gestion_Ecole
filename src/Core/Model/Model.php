<?php
namespace ProjetGestionPedagogique\Core\Model;
use ProjetGestionPedagogique\Core\Database\MysqlDatabase;
use PDO;


use PDOException;

class Model {
    protected $db;

    public function __construct() {
        $this->database = MysqlDatabase::getInstance()->getConnection();

    }

    public function findById($table, $id) {
        $stmt = $this->db->prepare("SELECT * FROM $table WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findAll($table) {
        $stmt = $this->db->query("SELECT * FROM $table");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($table, $id) {
        $stmt = $this->db->prepare("DELETE FROM $table WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
