<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'experience')] // TODO rename on migration
class EmploymentHistory
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private ?int $id = null;
    
    #[ORM\Column(type: 'string')]
    private string $employer;

    #[ORM\Column(type: 'string')]
    private string $position;

    #[ORM\Column(type: 'string')]
    private string $time;

    #[ORM\Column(type: 'boolean')]
    private bool $isCurrent;

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
     * Get the employer name.
     *
     * @return string
     */
    public function getEmployer()
    {
        return $this->employer;
    }

    /**
     * Set the employer name.
     *
     * @param string $employer
     * @return self
     */
    public function setEmployer(string $employer)
    {
        $this->employer = $employer;
        return $this;
    }

    /**
     * Get the position title.
     *
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set the position title.
     *
     * @param string $position
     * @return self
     */
    public function setPosition(string $position)
    {
        $this->position = $position;
        return $this;
    }

    /**
     * Get the start date.
     *
     * @return string
     */
    public function getTime()
    {
        return $this->time;
    }
    /**
     * Set the end date.
     *
     * @param string $to
     * @return self
     */
    public function setTime(string $time)
    {
        $this->time = $time;
        return $this;
    }

    /**
     * Check if the position is current.
     *
     * @return bool
     */
    public function getIsCurrent()
    {
        return $this->isCurrent;
    }

    /**
     * Set the position as current.
     *
     * @param bool $isCurrent
     * @return self
     */
    public function setIsCurrent(bool $isCurrent)
    {
        $this->isCurrent = $isCurrent;
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