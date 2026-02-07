<?php
class ProduitModel
{
    protected $db;

    public function __construct(){
        $config = require __DIR__ . '/../config.php';
        $this->db = new DataBase($config["database"]);
    }

    // 🔹 Récupérer tous les produits
    public function all()
    {
        return $this->db->query("SELECT * FROM produit", [])->fetchAll();
    }
    // Récupérer toutes les catégories distinctes
    public function getCategories(): array
    {
    $stmt = $this->db->query("SELECT DISTINCT type FROM produit ORDER BY type ASC");
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

// Récupérer les produits par catégorie
    public function getProduitsByCategorie($categorie): array
    {
        $stmt = $this->db->query("SELECT * FROM produit WHERE type = :type", ["type" => $categorie]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // 🔹 Récupérer un produit par son ID
    public function selectProduit($id){
        $sql = "SELECT * FROM produit WHERE id = :id";
        return $this->db->query($sql, ["id" => $id])->fetch();
    }

    // 🔹 Créer un produit
    public function createProduit($name, $price, $devise, $type, $image, $descriptions){
        $this->db->query(
            "INSERT INTO produit (name, price, devise, type, image, descriptions)
             VALUES (:name, :price, :devise, :type, :image, :descriptions)", 
            [
                "name" => $name,
                "price" => $price,
                "devise" => $devise,
                "type" => $type,
                "image" => $image,
                "descriptions" => $descriptions
            ]
        );
    }

    // 🔹 Modifier un produit
    public function updateProduit($id, $name, $price, $devise, $type, $image, $descriptions){
        $sql = "UPDATE produit 
                SET name = :name, price = :price, devise = :devise, 
                    type = :type, image = :image, descriptions = :descriptions
                WHERE id = :id";
        $this->db->query($sql, [
            "id" => $id,
            "name" => $name,
            "price" => $price,
            "devise" => $devise,
            "type" => $type,
            "image" => $image,
            "descriptions" => $descriptions
        ]);
    }

    // 🔹 Supprimer un produit
    public function deleteProduit($id){
        $sql = "DELETE FROM produit WHERE id = :id";
        $this->db->query($sql, ["id" => $id]);
    }

    // 🔹 Rechercher par nom, type ou description
    public function searchByNomOrType($keyword) {
        $sql = "SELECT * FROM produit 
                WHERE name LIKE :keyword 
                   OR type LIKE :keyword 
                   OR descriptions LIKE :keyword";
        return $this->db->query($sql, ["keyword" => "%" . $keyword . "%"])->fetchAll();
    }

    // 🔹 Recherche avancée avec filtres prix
    public function searchAdvanced($keyword = "", $minPrice = null, $maxPrice = null) {
        $sql = "SELECT * FROM produit WHERE 1=1";
        $params = [];

        if (!empty($keyword)) {
            $sql .= " AND (name LIKE :keyword OR type LIKE :keyword OR descriptions LIKE :keyword)";
            $params["keyword"] = "%" . $keyword . "%";
        }

        if (!empty($minPrice)) {
            $sql .= " AND price >= :minPrice";
            $params["minPrice"] = $minPrice;
        }

        if (!empty($maxPrice)) {
            $sql .= " AND price <= :maxPrice";
            $params["maxPrice"] = $maxPrice;
        }

        return $this->db->query($sql, $params)->fetchAll();
    }

    // 🔹 Récupérer les produits par type/catégorie
    public function getByType($type){
        $sql = "SELECT * FROM produit WHERE type = :type";
        return $this->db->query($sql, ["type" => $type])->fetchAll();
    }

    // 🔹 Récupérer les X derniers produits ajoutés
    public function getRecent($limit = 5){
        $sql = "SELECT * FROM produit ORDER BY id DESC LIMIT :limit";
        return $this->db->query($sql, ["limit" => $limit])->fetchAll();
    }

    // 🔹 Compter le nombre total de produits
    public function countProduits(){
        $sql = "SELECT COUNT(*) as total FROM produit";
        return $this->db->query($sql, [])->fetch()["total"];
    }
}
?>
