<?php
class DataBase
{
    private $pdo;

    public function __construct($config)
    {
        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8";
        try {
            $this->pdo = new PDO($dsn, $config['user'], $config['password']);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    // Exécuter une requête et retourner le PDOStatement
    public function query($query, $params = [])
    {
        $pdoStatement = $this->pdo->prepare($query);
        $pdoStatement->execute($params);
        return $pdoStatement;
    }

    // Récupérer le dernier ID inséré
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }
}
?>
