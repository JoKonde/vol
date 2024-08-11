<?php
class Paiement {
    private $conn;
    private $table_name = "paiement";

    public $id;
    public $montant;
    public $date;
    public $mon_vol_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET montant=:montant, mon_vol_id=:mon_vol_id";

        $stmt = $this->conn->prepare($query);

        $this->montant = htmlspecialchars(strip_tags($this->montant));
        $this->mon_vol_id = htmlspecialchars(strip_tags($this->mon_vol_id));

        $stmt->bindParam(":montant", $this->montant);
        $stmt->bindParam(":mon_vol_id", $this->mon_vol_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET montant = :montant WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->montant = htmlspecialchars(strip_tags($this->montant));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':montant', $this->montant);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>
