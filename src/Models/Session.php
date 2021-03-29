<?php

namespace Rowles\Models;

use Exception;
use Rowles\Core\Models\Model;

/**
 * Class Blog
 */
class Session extends Model
{
    /** @var string  */
    protected string $id;

    /** @var string  */
    protected string $user_id;

    /** @var string  */
    protected string $created_at;

    /** @var string  */
    protected string $updated_at;

    protected array $session;

    /**
     * Set session attributes.
     *
     * @param array $data
     * @return Session
     */
    public function setAttributes(array $data): Session
    {
        try {
            $this->setId(session_id());
            $this->setUserId($data['user_id']);

            $this->session = ['id' => $this->id, 'user_id' => $this->user_id];
        } catch (Exception $e) {
            $this->log->error($e->getMessage());
        }

        return $this;
    }

    /**
     * Create a new session.
     *
     * @param array $user
     * @return Session|false
     */
    public function create(array $user)
    {
        try {
            $this->validate($this->session);

            $this->db->query(
                "REPLACE INTO sessions (id, user_id, created_at, updated_at) VALUES (:id, :user_id, NOW(), NOW())"
            );

            $this->db->bind(':id', $this->id);
            $this->db->bind(':user_id', $this->user_id);

            $this->db->execute();

            $_SESSION['authenticated'] = true;
            $_SESSION['id'] = $this->id;
            $_SESSION['user'] = $user;
        } catch (Exception $e) {
            $this->log->error($e->getMessage());
            return false;
        }

        return $this;
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
            if (isset($data['id']) && isset($data['user_id'])) {
                return true;
            } else {
                throw new Exception('Not all required parameters are set.');
            }
        } else {
            throw new Exception('No parameters are set.');
        }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->user_id;
    }

    /**
     * @param string $id
     */
    public function setUserId(string $id): void
    {
        $this->user_id = $id;
    }
}
