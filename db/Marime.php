<?php
    class Marime {
        private $id_mar;
        private $marime;
        private $cantitate;
        private $id_p;

        public function __construct($id_mar, $marime, $cantitate, $id_p) {
            $this->id_mar = $id_mar;
            $this->marime = $marime;
            $this->cantitate = $cantitate;
            $this->id_p = $id_p;
        }
    }

    class MarimeDao {
        private $conn;
        private $table = "marime";

        // Database connection
        public function __construct($db) {
            $this->conn = $db;
        }

        // Insert new
        public function insert($id_mar, $marime, $cantitate, $id_p) {
            $query = "INSERT INTO " . $this->table . " (id_mar, marime, cantitate, id_p) VALUES (:id_mar, :marime, :cantitate, :id_p)";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_mar', $id_mar);
            $stmt->bindParam(':marime', $marime);
            $stmt->bindParam(':cantitate', $cantitate);
            $stmt->bindParam(':id_p', $id_p);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        }

        // Update  by id
        public function update($id_mar, $marime, $cantitate, $id_p) {
            $query = "UPDATE " . $this->table . "
                     SET marime = :marime, cantitate = :cantitate, id_p = :id_p
                     WHERE id_mar = :id_mar";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_mar', $id_mar);
            $stmt->bindParam(':marime', $marime);
            $stmt->bindParam(':cantitate', $cantitate);
            $stmt->bindParam(':id_p', $id_p);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        }

        // Delete  by id
        public function delete($id_mar) {
            $query = "DELETE FROM " . $this->table . " WHERE id_mar = :id_mar";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_mar', $id_mar);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        }

        // Delete  by id produs, all marimi of prod
        public function deleteImgProd($id_p) {
            $query = "DELETE FROM " . $this->table . " WHERE id_p = :id_p";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_p', $id_p);
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
        public function getById($id_mar) {
            $query = "SELECT * FROM " . $this->table . " WHERE id_mar = :id_mar";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_mar', $id_mar);
            $stmt->execute();

            return $stmt;
        }

        // Get  by id prod
        public function getByIdProd($id_p) {
            $query = "SELECT * FROM " . $this->table . " WHERE id_p = :id_p";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_p', $id_p);
            $stmt->execute();
            return $stmt;
        }
    }

?>