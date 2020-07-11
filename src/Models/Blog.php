<?php

namespace Rowles\Models;

use Rowles\Core\Models\Model;

/**
 * Class Blog
 */
class Blog extends Model
{
    /** @var int $id */
    protected $id;

    /** @var string $title */
    protected $title;

    /** @var string $content */
    protected $content;

    /** @var string $author */
    protected $author;

    /** @var array $post */
    protected $post;

    /**
     * Set blog post attributes.
     *
     * @param array $data
     * @return mixed
     */
    public function setAttributes(array $data)
    {
        try {

            if($data['id']) {
                $this->setId($data['id']);
            }

            $this->setTitle($data['title']);
            $this->setContent($data['content']);
            $this->setAuthor($data['author']);

            $this->post = $data;

        } catch (\Exception $e) {
            $this->log->error($e->getMessage());
        }

        return $this;
    }

    /**
     * Save blog post.
     *
     * @return bool
     */
    public function save()
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
        } catch (\Exception $e) {
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
    public function update()
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
        } catch (\Exception $e) {
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
    public function delete(int $id)
    {
        try {
            $this->setId($id);

            $this->db->query("DELETE FROM blog WHERE id = :id");
            $this->db->bind(':id', $this->id);

            $this->db->execute();
        } catch (\Exception $e) {
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
     * @return mixed
     */
    public function getPost($id)
    {
        $this->setId($id);

        $this->db->query('SELECT id, title, content, author, created_at FROM blog WHERE id = :id ORDER BY created_at DESC;');
        $this->db->bind(':id', $this->id);

        return $this->db->single();
    }

    /**
     * Validate post data.
     *
     * @param $data
     * @return bool
     * @throws \Exception
     */
    public function validate($data)
    {
        if (!empty($data)) {
            if (isset($data['title']) && isset($data['content']) && isset($data['author'])) {
                return true;
            } else {
                throw new \Exception('Not all required parameters are set.');
            }
        } else {
            throw new \Exception('No parameters are set.');
        }
    }

    /**
     * @return mixed
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author): void
    {
        $this->author = $author;
    }
}
