<?php

namespace Rowles\Models;

use Exception;

/**
 * Class Blog
 */
class User extends Model
{
    /** @var int  */
    protected int $id;

    /** @var string  */
    protected string $email;

    /** @var mixed  */
    protected $password;

    /** @var string  */
    protected string $remember_token;

    /** @var string  */
    protected string $name;

    /** @var string  */
    protected string $created_at;

    /** @var string  */
    protected string $updated_at;

    protected array $user;

    /**
     * Set user attributes.
     *
     * @param array $data
     * @return User
     */
    public function setAttributes(array $data): User
    {
        try {
            if(isset($data['id'])) {
                $this->setId($data['id']);
            } else {
                // TODO implement updating password
                $this->setPassword($data['password']);
            }

            $this->setEmail($data['email']);
            $this->setName($data['name']);

            $this->user = $data;
        } catch (Exception $e) {
            $this->log->error($e->getMessage());
        }

        return $this;
    }

    /**
     * Save a new user.
     *
     * @return array|false
     */
    public function save()
    {
        try {
            $this->validate($this->user);

            $this->db->query(
                "INSERT INTO users (email, password, name, created_at, updated_at) 
                VALUES (:email, :password, :name, NOW(), NOW())"
            );

            $this->db->bind(':email', $this->email);
            $this->db->bind(':password', $this->password);
            $this->db->bind(':name', $this->name);

            $this->db->execute();
        } catch (Exception $e) {
            $this->log->error($e->getMessage());
            return false;
        }

        return $this->user;
    }

    /**
     * Update a user.
     *
     * @return bool
     */
    public function update(): bool
    {
        try {
            $this->validate($this->user);

            $this->db->query("UPDATE users SET email = :email, name = :name, updated_at = NOW() WHERE id = :id");

            $this->db->bind(':email', $this->email);
            $this->db->bind(':name', $this->name);
            $this->db->bind(':id', $this->id);

            $this->db->execute();
        } catch (Exception $e) {
            $this->log->error($e->getMessage());
            return false;
        }

        return true;
    }

    /**
     * Login a user.
     * @param array $data
     * @return array
     * @throws Exception
     */
    public function login(array $data = []): array
    {
        $this->validate($data);

        $email = $data['email'];
        $password = $data['password'];

        $this->db->query('SELECT id, email, password, name, created_at FROM users WHERE email = :email');
        $this->db->bind(':email', $email);
        $user = $this->db->single();

        if ($user && password_verify($password, $user['password'])) {
            $response = [
                'status' => 'success',
                'user' => $user
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Invalid username/password'
            ];
        }

        return $response;
    }

    /**
     * @return bool
     */
    public function check(): bool
    {
        return isset($_SESSION['authenticated']) && $_SESSION['authenticated']
            && isset($_SESSION['name']) && $_SESSION['name'] === session_id();
    }

    /**
     * Delete a user.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        try {
            $this->setId($id);

            $this->db->query("DELETE FROM users WHERE id = :id");
            $this->db->bind(':id', $this->id);

            $this->db->execute();
        } catch (Exception $e) {
            $this->log->error($e->getMessage());
            return false;
        }

        return true;
    }

    /**
     * Validate post data.
     *
     * @param array $data
     * @return bool
     * @throws Exception
     */
    public function validate(array $data): bool
    {
        if (!empty($data)) {
            if (isset($data['email']) && isset($data['password'])) {
                return true;
            } else {
                throw new Exception('Not all required parameters are set.');
            }
        } else {
            throw new Exception('No parameters are set.');
        }
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * @return string
     */
    public function getRememberToken(): string
    {
        return $this->remember_token;
    }

    /**
     * @param string $token
     */
    public function setRememberToken(string $token): void
    {
        $this->remember_token = $token;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
