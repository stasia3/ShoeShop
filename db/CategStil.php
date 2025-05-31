<?php
    class CategS {
        private $id_cs;
        private $den;
        private $path;

        public function __construct($id_cs, $den, $path) {
            $this->id_i = $id_i;
            $this->den = $den;
            $this->path = $path;
        }
    }

    class CategSDao {
        private $conn;
        private $table = "categ_stil";

        // Database connection
        public function __construct($db) {
            $this->conn = $db;
        }

        // Insert new
        public function insert($id_cs, $den, $path) {
            $query = "INSERT INTO " . $this->table . " (id_cs, den, path) VALUES (:id_cs, :den, :path)";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_cs', $id_cs);
            $stmt->bindParam(':den', $den);
            $stmt->bindParam(':path', $path);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        }

        // Update  by id
        public function update($id_cs, $den, $path) {
            $query = "UPDATE " . $this->table . "
                     SET den = :den, path = :path
                     WHERE id_cs = :id_cs";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_cs', $id_cs);
            $stmt->bindParam(':den', $den);
            $stmt->bindParam(':path', $path);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        }

        // Delete  by id
        public function delete($id_cs) {
            $query = "DELETE FROM " . $this->table . " WHERE id_cs = :id_cs";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_cs', $id_cs);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        }

        // Get all
        public function getAll(){
            $query = "SELECT * FROM " . $this->table;

            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt;
        }

        // Get  by id
        public function getById($id_cs) {
            $query = "SELECT * FROM " . $this->table . " WHERE id_cs = :id_cs";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_cs', $id_cs);
            $stmt->execute();

            return $stmt;
        }


    }

?>