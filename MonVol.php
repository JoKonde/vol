<?php
class MonVol {
    private $conn;
    private $table_name = "mon_vol";

    public $id;
    public $nbre_adulte;
    public $nbre_bebe;
    public $nbre_enfant;
    public $vol_id;
    public $user_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET nbre_adulte=:nbre_adulte, nbre_bebe=:nbre_bebe, nbre_enfant=:nbre_enfant, vol_id=:vol_id, user_id=:user_id";

        $stmt = $this->conn->prepare($query);

        $this->nbre_adulte = htmlspecialchars(strip_tags($this->nbre_adulte));
        $this->nbre_bebe = htmlspecialchars(strip_tags($this->nbre_bebe));
        $this->nbre_enfant = htmlspecialchars(strip_tags($this->nbre_enfant));
        $this->vol_id = htmlspecialchars(strip_tags($this->vol_id));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));

        $stmt->bindParam(":nbre_adulte", $this->nbre_adulte);
        $stmt->bindParam(":nbre_bebe", $this->nbre_bebe);
        $stmt->bindParam(":nbre_enfant", $this->nbre_enfant);
        $stmt->bindParam(":vol_id", $this->vol_id);
        $stmt->bindParam(":user_id", $this->user_id);

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
        $query = "UPDATE " . $this->table_name . " SET nbre_adulte = :nbre_adulte, nbre_bebe = :nbre_bebe, nbre_enfant = :nbre_enfant WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->nbre_adulte = htmlspecialchars(strip_tags($this->nbre_adulte));
        $this->nbre_bebe = htmlspecialchars(strip_tags($this->nbre_bebe));
        $this->nbre_enfant = htmlspecialchars(strip_tags($this->nbre_enfant));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':nbre_adulte', $this->nbre_adulte);
        $stmt->bindParam(':nbre_bebe', $this->nbre_bebe);
        $stmt->bindParam(':nbre_enfant', $this->nbre_enfant);
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

    public function rechercheParUser($userId) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = :user_id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
