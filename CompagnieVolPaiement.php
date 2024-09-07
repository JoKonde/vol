<?php
class CompagnieVolPaiement {
    private $conn;
    private $table_name = "compagnie";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function fetchDetails() {
        $query = "
            SELECT
                c.nom AS compagnieNom,
                v.ville_depart AS villeDepart,
                v.ville_arrivee AS villeArrivee,
                v.date_vol_depart AS dateDepart,
                v.date_vol_arrivee AS dateArrivee,
                IFNULL(p.montant, 'Aucun paiement') AS montantPaiement,
                IFNULL(CONCAT(u.noms, ' (', u.email, ')'), 'Pas d\'utilisateur') AS userName
            FROM
                compagnie c
            LEFT JOIN
                vol v ON c.id = v.compagnie_id
            LEFT JOIN
                mon_vol mv ON v.id = mv.vol_id
            LEFT JOIN
                paiement p ON mv.id = p.mon_vol_id
            LEFT JOIN
                user u ON mv.user_id = u.id
            ORDER BY
                c.nom, v.date_vol_depart;
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
