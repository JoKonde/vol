<?php
class Vol {
    private $conn;
    private $table_name = "vol";

    public $id;
    public $ville_depart;
    public $ville_arrivee;
    public $date_vol;
    public $compagnie_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET ville_depart=:ville_depart, ville_arrivee=:ville_arrivee, date_vol=:date_vol, compagnie_id=:compagnie_id";

        $stmt = $this->conn->prepare($query);

        $this->ville_depart = htmlspecialchars(strip_tags($this->ville_depart));
        $this->ville_arrivee = htmlspecialchars(strip_tags($this->ville_arrivee));
        $this->date_vol = htmlspecialchars(strip_tags($this->date_vol));
        $this->compagnie_id = htmlspecialchars(strip_tags($this->compagnie_id));

        $stmt->bindParam(":ville_depart", $this->ville_depart);
        $stmt->bindParam(":ville_arrivee", $this->ville_arrivee);
        $stmt->bindParam(":date_vol", $this->date_vol);
        $stmt->bindParam(":compagnie_id", $this->compagnie_id);

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
        $query = "UPDATE " . $this->table_name . " SET ville_depart = :ville_depart, ville_arrivee = :ville_arrivee, date_vol = :date_vol, compagnie_id = :compagnie_id WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->ville_depart = htmlspecialchars(strip_tags($this->ville_depart));
        $this->ville_arrivee = htmlspecialchars(strip_tags($this->ville_arrivee));
        $this->date_vol = htmlspecialchars(strip_tags($this->date_vol));
        $this->compagnie_id = htmlspecialchars(strip_tags($this->compagnie_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':ville_depart', $this->ville_depart);
        $stmt->bindParam(':ville_arrivee', $this->ville_arrivee);
        $stmt->bindParam(':date_vol', $this->date_vol);
        $stmt->bindParam(':compagnie_id', $this->compagnie_id);
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

    public function search($ville_depart, $ville_arrivee, $date_vol) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE ville_depart = :ville_depart AND ville_arrivee = :ville_arrivee AND date_vol = :date_vol";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':ville_depart', $ville_depart);
        $stmt->bindParam(':ville_arrivee', $ville_arrivee);
        $stmt->bindParam(':date_vol', $date_vol);

        $stmt->execute();

        return $stmt;
    }
}
?>
