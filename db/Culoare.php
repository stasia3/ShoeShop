<?php
    class Culoare {
        private $id_col;
        private $culoare;
        private $descriere;
        private $id_mar;

        public function __construct($id_col, $culoare, $descriere, $id_mar) {
            $this->id_col = $id_col;
            $this->culoare = $culoare;
            $this->descriere = $descriere;
            $this->id_mar = $id_mar;
        }
    }

    class CuloareDao {
        private $conn;
        private $table = "culoare";

        // Database connection
        public function __construct($db) {
            $this->conn = $db;
        }

        // Insert new
        public function insert($id_col, $culoare, $descriere, $id_mar) {
            $query = "INSERT INTO " . $this->table . " (id_col, culoare, descriere, id_mar) VALUES (:id_col, :culoare, :descriere, :id_mar)";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_col', $id_col);
            $stmt->bindParam(':culoare', $culoare);
            $stmt->bindParam(':descriere', $descriere);
            $stmt->bindParam(':id_mar', $id_mar);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        }

        // Update  by id
        public function update($id_col, $culoare, $descriere, $id_mar) {
            $query = "UPDATE " . $this->table . "
                     SET culoare = :culoare, descriere = :descriere, id_mar = :id_mar
                     WHERE id_col = :id_col";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_col', $id_col);
            $stmt->bindParam(':culoare', $culoare);
            $stmt->bindParam(':descriere', $descriere);
            $stmt->bindParam(':id_mar', $id_mar);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        }

        // Delete  by id
        public function delete($id_col) {
            $query = "DELETE FROM " . $this->table . " WHERE id_col = :id_col";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_col', $id_mar);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        }

        // Delete  by id produs, all marimi of prod
        public function deleteImgProd($id_mar) {
            $query = "DELETE FROM " . $this->table . " WHERE id_mar = :id_mar";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_mar', $id_mar);
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
        public function getById($id_col) {
            $query = "SELECT * FROM " . $this->table . " WHERE id_col = :id_col";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_col', $id_col);
            $stmt->execute();

            return $stmt;
        }

        // Get  by id prod
        public function getByIdProd($id_mar) {
            $query = "SELECT * FROM " . $this->table . " WHERE id_mar = :id_mar";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_mar', $id_mar);
            $stmt->execute();
            return $stmt;
        }
    }

?>