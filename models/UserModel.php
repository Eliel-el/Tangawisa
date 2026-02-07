<?php
require_once __DIR__ . '/produits/Database.php';

class UserModel
{
    protected $db;
    

    public function __construct()
    {
        $config = require __DIR__ . '/../config.php';
        $this->db = new DataBase($config["database"]);
    }

     public function countUsers(): int {
        $stmt = $this->db->query("SELECT COUNT(*) FROM users");
        return (int)$stmt->fetchColumn();
    }

    public function createAdmin($name, $email, $password, $avatar = "assets/default-avatar.jpg")
{
    // Vérifier si l’email existe déjà
    $stmt = $this->db->query("SELECT id FROM users WHERE email = :email", [
        "email" => $email
    ]);
    if ($stmt->fetch()) return false;

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $this->db->query(
        "INSERT INTO users (name, email, password, role, avatar) 
         VALUES (:name, :email, :password, 'admin', :avatar)",
        [
            "name" => $name,
            "email" => $email,
            "password" => $hash,
            "avatar" => $avatar
        ]
    );

    return true;
}


    // Récupérer tous les utilisateurs
    public function all()
    {
        return $this->db->query("SELECT id, name, email, role, avatar FROM users", [])->fetchAll();
    }

    // Trouver un utilisateur par ID
    public function find($id)
    {
        $stmt = $this->db->query("SELECT id, name, email, role, avatar FROM users WHERE id = :id", [
            "id" => $id
        ]);
        return $stmt->fetch();
    }

    // Authentification
    public function authenticate($email, $password)
    {
        $stmt = $this->db->query("SELECT * FROM users WHERE email = :email", [
            "email" => $email
        ]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return null;
    }


    // Mettre à jour un utilisateur
public function updateUser($id, $name, $email, $role = 'user', $avatar = null)
{
    // Vérifier si l’email est déjà utilisé par un autre utilisateur
    $stmt = $this->db->query("SELECT id FROM users WHERE email = :email AND id != :id", [
        "email" => $email,
        "id" => $id
    ]);
    if ($stmt->fetch()) {
        return false; // Email déjà utilisé
    }

    // Préparer la requête de mise à jour
    $sql = "UPDATE users SET name = :name, email = :email, role = :role";
    $params = [
        "name" => $name,
        "email" => $email,
        "role" => $role,
        "id" => $id
    ];

    if ($avatar) {
        $sql .= ", avatar = :avatar";
        $params["avatar"] = $avatar;
    }

    $sql .= " WHERE id = :id";

    $this->db->query($sql, $params);

    return true;
}


    // Supprimer un utilisateur par ID
public function deleteUser($id)
{
    // Supprimer l'utilisateur de la base
    $this->db->query("DELETE FROM users WHERE id = :id", [
        "id" => $id
    ]);

    return true;
}

    // Enregistrer un nouvel utilisateur
    public function register($name, $email, $password, $role = "user", $avatar = "assets/default-avatar.jpg")
    {
        // Vérifier si l’email existe déjà
        $stmt = $this->db->query("SELECT id FROM users WHERE email = :email", [
            "email" => $email
        ]);
        if ($stmt->fetch()) return false;

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $this->db->query(
            "INSERT INTO users (name, email, password, role, avatar) 
             VALUES (:name, :email, :password, :role, :avatar)",
            [
                "name" => $name,
                "email" => $email,
                "password" => $hash,
                "role" => $role,
                "avatar" => $avatar
            ]
        );

        // Retourner le nouvel utilisateur en utilisant lastInsertId()
        $lastId = $this->db->lastInsertId();
        return $this->find($lastId);
    }



    // Dans UserModel.php
public function updateProfile($id, $name, $email, $password = null, $avatar = null)
{
    // Vérifier si l’email est déjà utilisé par un autre utilisateur
    $stmt = $this->db->query("SELECT id FROM users WHERE email = :email AND id != :id", [
        "email" => $email,
        "id" => $id
    ]);
    if ($stmt->fetch()) {
        return false; // Email déjà utilisé
    }

    $sql = "UPDATE users SET name = :name, email = :email";
    $params = [
        "name" => $name,
        "email" => $email,
        "id" => $id
    ];

    if ($avatar) {
        $sql .= ", avatar = :avatar";
        $params["avatar"] = $avatar;
    }

    if ($password) {
        $sql .= ", password = :password";
        $params["password"] = password_hash($password, PASSWORD_DEFAULT);
    }

    $sql .= " WHERE id = :id";

    $this->db->query($sql, $params);

    return true;
}


    // Recherche utilisateur par nom ou email
    public function search($keyword)
    {
        $sql = "SELECT id, name, email, role, avatar FROM users 
                WHERE name LIKE :keyword OR email LIKE :keyword";
        return $this->db->query($sql, ["keyword" => "%" . $keyword . "%"])->fetchAll();
    }
}
?>
