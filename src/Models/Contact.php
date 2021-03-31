<?php

namespace Rowles\Models;

use Exception;

/**
 * Class Blog
 */
class Contact extends Model
{
    /** @var int $id */
    protected int $id;

    /** @var string $name */
    protected string $name;

    /** @var string $email */
    protected string $email;

    /** @var string $phone */
    protected string $phone;

    /** @var string $message */
    protected string $message;

    /** @var string  */
    protected string $created_at;

    /** @var string  */
    protected string $updated_at;

    /** @var array $enquiry */
    protected array $enquiry;

    /**
     * Set blog post attributes.
     *
     * @param array $data
     * @return Contact
     */
    public function setAttributes(array $data): Contact
    {
        try {
            if(isset($data['id'])) {
                $this->setId($data['id']);
            }

            $this->setName($data['name']);
            $this->setEmail($data['email']);
            $this->setPhone($data['phone']);
            $this->setMessage($data['message']);

            $this->enquiry = $data;

        } catch (Exception $e) {
            $this->log->error($e->getMessage());
        }

        return $this;
    }

    /**
     * Save blog post.
     *
     * @return bool
     */
    public function save(): bool
    {
        try {
            $this->validate($this->enquiry);

            $this->db->query(
                "INSERT INTO contact (name, email, phone, message, created_at, updated_at) 
                VALUES (:name, :email, :phone, :message, NOW(), NOW())"
            );

            $this->db->bind(':name', $this->name);
            $this->db->bind(':email', $this->email);
            $this->db->bind(':phone', $this->phone);
            $this->db->bind(':message', $this->message);

            $this->db->execute();
        } catch (Exception $e) {
            $this->log->error($e->getMessage());
            return false;
        }

        return true;
    }

    /**
     * Validate data.
     *
     * @param array $data
     * @return bool
     * @throws Exception
     */
    public function validate(array $data): bool
    {
        if (!empty($data)) {
            if (isset($data['name']) && isset($data['email']) && isset($data['phone']) && isset($data['message'])) {
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
     * @param int $id
     * @return mixed
     */
    public function setId(int $id): void
    {
        $this->id = $id;
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
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setMessage(string $email): void
    {
        $this->email = $email;
    }
}
