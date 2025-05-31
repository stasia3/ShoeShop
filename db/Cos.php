<?php
    class Cos {
        private $id_cos;
        private $cantitate;
        private $data;
        private $id_u;
        private $id_p;
        private $marime;
        private $culoare;
        private $id_col;

        public function __construct($id_cos, $cantitate, $data, $id_u, $id_p, $marime, $culoare, $id_col) {
            $this->id_cos = $id_cos;
            $this->cantitate = $cantitate;
            $this->data = $data;
            $this->id_u = $id_u;
            $this->id_p = $id_p;
            $this->marime = $marime;
            $this->culoare = $culoare;
            $this->id_col = $id_col;
        }
    }

    class CosDao {
        private $conn;
        private $table = "cos";

        // Database connection
        public function __construct($db) {
            $this->conn = $db;
        }

        // Insert new
        public function insert($cantitate, $data, $id_u, $id_p, $marime, $culoare, $id_col) {
            $query = "SELECT id_cos FROM " . $this->table . " ORDER BY id_cos DESC LIMIT 1";
            $stmt = $this->conn->prepare($query);

            if ($stmt && $stmt->execute()) {
                $result = $stmt->fetch();
                $id_cos = $result ? $result['id_cos'] + 1 : 1;
            } else {
                // fallback or error log
                $id_cos = 1;
            }

            $query = "INSERT INTO " . $this->table . " (id_cos, cantitate, data, id_u, id_p, marime, culoare, id_col) VALUES (:id_cos, :cantitate, :data, :id_u, :id_p, :marime, :culoare, :id_col)";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_cos', $id_cos);
            $stmt->bindParam(':cantitate', $cantitate);
            $stmt->bindParam(':data', $data);
            $stmt->bindParam(':id_u', $id_u);
            $stmt->bindParam(':id_p', $id_p);
            $stmt->bindParam(':marime', $marime);
            $stmt->bindParam(':culoare', $culoare);
            $stmt->bindParam(':id_col', $id_col);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        }

        // Update  by id
        public function update($id_cos, $cantitate, $data, $id_u, $id_p, $marime, $culoare, $id_col) {
            $query = "UPDATE " . $this->table . "
                     SET cantitate = :cantitate, data = :data, id_u = :id_u, id_p = :id_p, marime = :marime, culoare = :culoare, id_col = :id_col
                     WHERE id_cos = :id_cos";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_cos', $id_cos);
            $stmt->bindParam(':cantitate', $cantitate);
            $stmt->bindParam(':data', $data);
            $stmt->bindParam(':id_u', $id_u);
            $stmt->bindParam(':id_p', $id_p);
            $stmt->bindParam(':marime', $marime);
            $stmt->bindParam(':culoare', $culoare);
            $stmt->bindParam(':id_col', $id_col);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        }

        // Delete  by id
        public function delete($id_cos) {
            $query = "DELETE FROM " . $this->table . " WHERE id_cos = :id_cos";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_cos', $id_cos);

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
        public function getById($id_cos) {
            $query = "SELECT * FROM " . $this->table . " WHERE id_cos = :id_cos";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_cos', $id_cos);
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

        // Get  by id prod
        public function getByIdUser($id_u) {
            $query = "SELECT * FROM " . $this->table . " WHERE id_u = :id_u";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_u', $id_u);
            $stmt->execute();
            return $stmt;
        }
    }

?>