<?php
class Vol {
    private $conn;
    private $table_name = "vol";

    public $id;
    public $ville_depart;
    public $ville_arrivee;
    public $date_vol_depart;
    public $date_vol_arrivee;
    public $compagnie_id;
    public $montant;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET ville_depart=:ville_depart, ville_arrivee=:ville_arrivee, date_vol_depart=:date_vol_depart,date_vol_arrivee=:date_vol_arrivee, compagnie_id=:compagnie_id,montant=:montant";

        $stmt = $this->conn->prepare($query);

        $this->ville_depart = htmlspecialchars(strip_tags($this->ville_depart));
        $this->ville_arrivee = htmlspecialchars(strip_tags($this->ville_arrivee));
        $this->date_vol_depart = htmlspecialchars(strip_tags($this->date_vol_depart));
        $this->date_vol_arrivee = htmlspecialchars(strip_tags($this->date_vol_arrivee));
        $this->compagnie_id = htmlspecialchars(strip_tags($this->compagnie_id));
        $this->montant = htmlspecialchars(strip_tags($this->montant));

        $stmt->bindParam(":ville_depart", $this->ville_depart);
        $stmt->bindParam(":ville_arrivee", $this->ville_arrivee);
        $stmt->bindParam(":date_vol_depart", $this->date_vol_depart);
        $stmt->bindParam(":date_vol_arrivee", $this->date_vol_arrivee);
        $stmt->bindParam(":compagnie_id", $this->compagnie_id);
        $stmt->bindParam(":montant", $this->montant);

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
        $query = "UPDATE " . $this->table_name . " SET ville_depart = :ville_depart, ville_arrivee = :ville_arrivee, date_vol_depart=:date_vol_depart,date_vol_arrivee=:date_vol_arrivee, compagnie_id = :compagnie_id,montant=:montant WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->ville_depart = htmlspecialchars(strip_tags($this->ville_depart));
        $this->ville_arrivee = htmlspecialchars(strip_tags($this->ville_arrivee));
        $this->montant = htmlspecialchars(strip_tags($this->montant));
        $this->compagnie_id = htmlspecialchars(strip_tags($this->compagnie_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':ville_depart', $this->ville_depart);
        $stmt->bindParam(':ville_arrivee', $this->ville_arrivee);
        $stmt->bindParam(":date_vol_depart", $this->date_vol_depart);
        $stmt->bindParam(":date_vol_arrivee", $this->date_vol_arrivee);
        $stmt->bindParam(':compagnie_id', $this->compagnie_id);
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

    public function search($ville_depart, $ville_arrivee, $date_vol_depart,$date_vol_arrivee) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE ville_depart = :ville_depart AND ville_arrivee = :ville_arrivee AND date_vol_depart = :date_vol_depart AND date_vol_arrivee = :date_vol_arrivee";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':ville_depart', $ville_depart);
        $stmt->bindParam(':ville_arrivee', $ville_arrivee);
        $stmt->bindParam(":date_vol_depart", $date_vol_depart);
        $stmt->bindParam(":date_vol_arrivee", $date_vol_arrivee);
        $stmt->execute();

        return $stmt;
    }
    public function rechercheParVille($ville_depart, $ville_arrivee) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE ville_depart = :ville_depart AND ville_arrivee = :ville_arrivee";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':ville_depart', $ville_depart);
        $stmt->bindParam(':ville_arrivee', $ville_arrivee);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
