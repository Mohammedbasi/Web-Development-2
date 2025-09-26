<?php


class User
{
    private $id;
    private $username;
    private $email;
    private $password;
    private $role;
    private $isActive;
    private $createdAt;
    private $updatedAt;

    // Database connection
    private $db;

    // Constructor
    public function __construct($username = '', $email = '', $password = '', $role = 'student')
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;

        // Get database instance
        $this->db = Database::getInstance()->getConnection();
    }

    // Getters and Setters
    public function getId()
    {
        return $this->id;
    }
    public function getUsername()
    {
        return $this->username;
    }
    public function setUsername($username)
    {
        $this->username = $username;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }
    public function getRole()
    {
        return $this->role;
    }
    public function setRole($role)
    {
        $this->role = $role;
    }
    public function getIsActive()
    {
        return $this->isActive;
    }
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function register()
    {
        if ($this->usernameExists($this->username)) {
            throw new Exception('Username already exists');
        }

        if ($this->emailExists($this->email)) {
            throw new Exception('Email already exists');
        }

        $hashedPassword = $this->hashPassword($this->password);

        $stmt = $this->db->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssss', $this->username, $this->email, $hashedPassword, $this->role);

        if ($stmt->execute()) {
            $this->id = $stmt->insert_id;
            return true;
        }
        return false;
    }


    public function login($username, $password)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE (username = ? OR email = ?) AND is_active = TRUE");
        $stmt->bind_param("ss", $username, $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if ($this->verifyPassword($password, $user['password'])) {
                $this->id = $user['id'];
                $this->username = $user['username'];
                $this->email = $user['email'];
                $this->role = $user['role'];
                $this->isActive = $user['is_active'];
                $this->createdAt = $user['created_at'];
                $this->updatedAt = $user['updated_at'];

                return true;
            }
        }

        return false;
    }

    

    public function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function  verifyPassword($password, $hashedPassword)
    {
        return password_verify($password, $hashedPassword);
    }
    public function usernameExists($username)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM users WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row['count'] > 0;
    }

    public function emailExists($email)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row['count'] > 0;
    }

    // Populate object from array
    public function fromArray($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    // Convert object to array
    public function toArray()
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'role' => $this->role,
            'is_active' => $this->isActive,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt
        ];
    }
}
