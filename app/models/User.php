<?php

class User
{
    private $db;

    public function __construct()
    {
        $this->db = Database::conectar();
    }

    // Buscar usuario por correo (columna 'correo')
    public function findByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE correo = :correo");
        $stmt->execute([':correo' => $email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        return $usuario ?: false;
    }

    // Crear nuevo usuario
    public function createUser($data)
    {
        $sql = "INSERT INTO users (nombre, apellido, correo, password, fecha_creacion, estado) 
                VALUES (:nombre, :apellido, :correo, :password, NOW(), 1)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nombre'   => strtoupper($data['nombre']),
            ':apellido' => strtoupper($data['apellido']),
            ':correo'   => $data['correo'],
            ':password' => $data['password']
        ]);
    }

    // Obtener usuario por ID
public function getById($id)
{
    $stmt = $this->db->prepare("SELECT * FROM users WHERE id_usuario = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Actualizar perfil (solo campos que se envían)
public function updateProfile($id, $data)
{
    $fields = [];
    $params = [':id' => $id];

    if (isset($data['nombre'])) {
        $fields[] = "nombre = :nombre";
        $params[':nombre'] = $data['nombre'];
    }
    if (isset($data['apellido'])) {
        $fields[] = "apellido = :apellido";
        $params[':apellido'] = $data['apellido'];
    }
    if (isset($data['password']) && !is_null($data['password'])) {
        $fields[] = "password = :password";
        $params[':password'] = $data['password'];
    }
    if (isset($data['foto_perfil'])) {
        $fields[] = "foto_perfil = :foto_perfil";
        $params[':foto_perfil'] = $data['foto_perfil'];
    }

    if (empty($fields)) return false;

    $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id_usuario = :id";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute($params);
}
}