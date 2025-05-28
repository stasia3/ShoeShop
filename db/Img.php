<?php
    class Img {
        private $id_i;
        private $path;
        private $id_p;

        public function __construct($id_i, $path, $id_p) {
            $this->id_i = $id_i;
            $this->path = $path;
            $this->id_p = $id_p;
        }

    }

    class ImgDao {
        private $conn;
        private $table = "img";

        // Database connection
        public function __construct($db) {
            $this->conn = $db;
        }

        // Insert new
        public function insert($id_i, $path, $id_p) {
            $query = "INSERT INTO " . $this->table . " (id_i, path, id_p) VALUES (:id_i, :path, :id_p)";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_i', $id_i);
            $stmt->bindParam(':path', $path);
            $stmt->bindParam(':id_p', $id_p);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        }

        // Update  by id
        public function update($id_i, $path, $id_p) {
            $query = "UPDATE " . $this->table . "
                     SET path = :path, id_p = :id_p
                     WHERE id_i = :id_i";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_i', $id_i);
            $stmt->bindParam(':path', $path);
            $stmt->bindParam(':id_p', $id_p);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        }

        // Delete  by id
        public function delete($id_i) {
            $query = "DELETE FROM " . $this->table . " WHERE id_i = :id_i";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_i', $id_i);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        }

        // Delete  by id produs, all imgs of prod
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
        public function getById($id_i) {
            $query = "SELECT * FROM " . $this->table . " WHERE id_i = :id_i";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_i', $id_i);
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
        public function getByIdProdMain($id_p) {
            $query = "SELECT * FROM " . $this->table . " WHERE id_p = :id_p";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_p', $id_p);
            $stmt->execute();
            foreach ($stmt as $img) {
                return $img;
            }
            $empty = [0, "img/prod/empty.jpg", 0];
            return $empty;
        }
    }

?>