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
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    // Méthode pour trouver les paiements par user_id
    public function findByUserId($user_id) {
        $query = "SELECT p.* 
                  FROM " . $this->table_name . " p
                  JOIN mon_vol mv ON p.mon_vol_id = mv.id
                  WHERE mv.user_id = :user_id";

        $stmt = $this->conn->prepare($query);

        // Sécuriser l'entrée utilisateur
        $user_id = htmlspecialchars(strip_tags($user_id));

        $stmt->bindParam(':user_id', $user_id);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
