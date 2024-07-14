<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'contact_details')]
class ContactDetail
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private ?int $id = null;
    
    #[ORM\Column(type: 'string')]
    private string $title;

    #[ORM\Column(type: 'string')]
    private string $link;

    #[ORM\Column(type: 'string')]
    private string $text;

    #[ORM\Column(type: 'integer', options: ['default' => 1])]
    private int $sortOrder;

    /**
     * Get the ID
     * 
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set the ID
     * 
     * @return int|null
     */
    public function setId(int $id): int
    {
        return $this->id = $id;
    }
    
    /**
     * Get the contact title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the contact title.
     *
     * @param string $title
     * @return self
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get the contact link.
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set the contact link.
     *
     * @param string $link
     * @return self
     */
    public function setLink(string $link)
    {
        $this->link = $link;
        return $this;
    }

    /**
     * Get the contact text.
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }
    /**
     * Set the contact text.
     *
     * @param string $text
     * @return self
     */
    public function setText(string $text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * Get the sort order.
     *
     * @return string
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    /**
     * Set the sort order.
     *
     * @param int $sortOrder
     * @return self
     */
    public function setSortOrder(int $sortOrder)
    {
        $this->sortOrder = $sortOrder;
        return $this;
    }
}