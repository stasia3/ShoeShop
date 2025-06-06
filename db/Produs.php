<?php
    class Produs {
        private $id_p;
        private $den;
        private $pret;
        private $categ;
        private $stil;
        private $producator;
        private $descriere;

        public function __construct($id_p, $den, $pret, $categ, $stil, $producator,$descriere) {
            $this->id_p = $id_p;
            $this->den = $den;
            $this->pret = $pret;
            $this->categ = $categ;
            $this->stil = $stil;
            $this->producator = $producator;
            $this->descriere = $descriere;
        }

    }

    class ProdusDao {
        private $conn;
        private $table = "prod";

        // Database connection
        public function __construct($db) {
            $this->conn = $db;
        }

        // Insert new
        public function insert($id_p, $den, $pret, $categ, $stil, $producator, $descriere) {
            $query = "INSERT INTO " . $this->table . " (id_p, den, pret, categ, stil, producator, descriere) VALUES (:id_p, :den, :pret, :categ, stil, producator)";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_p', $id_p);
            $stmt->bindParam(':den', $den);
            $stmt->bindParam(':pret', $pret);
            $stmt->bindParam(':categ', $categ);
            $stmt->bindParam(':stil', $stil);
            $stmt->bindParam(':producator', $producator);
            $stmt->bindParam(':descriere', $descriere);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        }

        // Update  by id
        public function update($id_p, $den, $pret, $categ, $stil, $producator, $descriere) {
            $query = "UPDATE " . $this->table . "
                     SET den = :den, pret = :pret, categ = :categ, stil = :stil, producator = :producator, descriere = :descriere
                     WHERE id_p = :id_p";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_p', $id_p);
            $stmt->bindParam(':den', $den);
            $stmt->bindParam(':pret', $pret);
            $stmt->bindParam(':categ', $categ);
            $stmt->bindParam(':stil', $stil);
            $stmt->bindParam(':producator', $producator);
            $stmt->bindParam(':descriere', $descriere);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        }

        // Delete  by id
        public function delete($id_p) {
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
        public function getById($id_p) {
            $query = "SELECT * FROM " . $this->table . " WHERE id_p = :id_p";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_p', $id_p);
            $stmt->execute();

            return $stmt;
        }

        // Get  like
        public function getLike($search) {
            $query = "SELECT * FROM " . $this->table . " WHERE den LIKE ?";
            $stmt = $this->conn->prepare($query);
            $stmt->execute(["%$search%"]);

            return $stmt;
        }

        public function getByCateg($categ) {
            $query = "SELECT * FROM " .$this->table . " WHERE stil = :categ";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':categ', $categ);
            $stmt->execute();

            return $stmt;
        }
    }

?>