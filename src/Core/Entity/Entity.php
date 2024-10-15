<?php
namespace ProjetGestionPedagogique\Core\Entity;

abstract class Entity {
    public function __get($name) {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        return null;
    }

    public function __set($name, $value) {
        if (property_exists($this, $name)) {
            $this->$name = $value;
        }
    }

    public function __serialize() {
        return get_object_vars($this);
    }

    public function __unserialize(array $data) {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }
}
?>
