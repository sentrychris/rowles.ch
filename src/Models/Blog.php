<?php

namespace Rowles\Models;

use Exception;

/**
 * Class Blog
 */
class Blog extends Model
{
    /** @var int $id */
    protected int $id;

    /** @var string $title */
    protected string $title;

    /** @var string $content */
    protected string $content;

    /** @var string $author */
    protected string $author;

    /** @var array $post */
    protected array $post;

    /**
     * Set blog post attributes.
     *
     * @param array $data
     * @return Blog
     */
    public function setAttributes(array $data): Blog
    {
        try {
            if(isset($data['id'])) {
                $this->setId($data['id']);
            }

            $this->setTitle($data['title']);
            $this->setContent($data['content']);
            $this->setAuthor($data['author']);

            $this->post = $data;

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
            $this->validate($this->post);

            $this->db->query(
                "INSERT INTO blog (title, content, author, created_at, updated_at) 
                VALUES (:title, :content, :author, NOW(), NOW())"
            );

            $this->db->bind(':title', $this->title);
            $this->db->bind(':content', $this->content);
            $this->db->bind(':author', $this->author);

            $this->db->execute();
        } catch (Exception $e) {
            $this->log->error($e->getMessage());
            return false;
        }

        return true;
    }

    /**
     * Update a blog post.
     *
     * @return bool
     */
    public function update(): bool
    {
        try {
            $this->validate($this->post);

            $this->db->query(
                "UPDATE blog SET title = :title, content = :content, author = :author, updated_at = NOW() 
                    WHERE id = :id"
            );

            $this->db->bind(':title', $this->title);
            $this->db->bind(':content', $this->content);
            $this->db->bind(':author', $this->author);
            $this->db->bind(':id', $this->id);

            $this->db->execute();
        } catch (Exception $e) {
            $this->log->error($e->getMessage());
            return false;
        }

        return true;
    }

    /**
     * Delete a blog post.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        try {
            $this->setId($id);

            $this->db->query("DELETE FROM blog WHERE id = :id");
            $this->db->bind(':id', $this->id);

            $this->db->execute();
        } catch (Exception $e) {
            $this->log->error($e->getMessage());
            return false;
        }

        return true;
    }

    /**
     * Get all posts.
     *
     * @return mixed
     */
    public function getAllPosts()
    {
        $this->db->query('SELECT id, title, content, author, created_at FROM blog ORDER BY created_at DESC;');
        return $this->db->resultset();
    }

    /**
     * Get all posts.
     *
     * @param int $id
     * @return mixed
     */
    public function getPost(int $id)
    {
        $this->db->query('SELECT id, title, content, author, created_at FROM blog WHERE id = :id;');
        $this->db->bind(':id', $id);

        return $this->db->single();
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
            if (isset($data['title']) && isset($data['content']) && isset($data['author'])) {
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
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }
}
