<?php
class OrderModel
{
    protected $db;

    public function __construct()
    {
        $config = require __DIR__ . '/../config.php';
        $this->db = new DataBase($config["database"]);
    }

    // Compter le nombre total de commandes
    public function countOrders(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM orders");
        $result = $stmt->fetch();
        return (int)($result['total'] ?? 0);
    }

    // Récupérer les N dernières commandes
    
    public function getRecentOrders(int $limit = 5): array
    {
        $limit = (int)$limit; // sécuriser
        $sql = "
            SELECT o.id, o.total, o.devise, o.created_at as date, u.name as client_name
            FROM orders o
            LEFT JOIN users u ON o.user_id = u.id
            ORDER BY o.created_at DESC
            LIMIT $limit
            ";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    // Récupérer toutes les commandes
    public function all(): array
    {
        $sql = "
            SELECT o.id, o.total, o.devise, o.created_at as date, u.name as client_name
            FROM orders o
            LEFT JOIN users u ON o.user_id = u.id
            ORDER BY o.created_at DESC
        ";
        return $this->db->query($sql, [])->fetchAll();
    }

    // Récupérer une commande par ID
    public function find($id)
    {
        $sql = "
            SELECT o.id, o.total, o.devise, o.created_at as date, u.name as client_name
            FROM orders o
            LEFT JOIN users u ON o.user_id = u.id
            WHERE o.id = :id
        ";
        $stmt = $this->db->query($sql, ["id" => $id]);
        return $stmt->fetch();
    }
}
