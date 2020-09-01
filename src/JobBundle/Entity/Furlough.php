<?php

namespace JobBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Furlough
 *
 * @ORM\Table(name="furloughs")
 * @ORM\Entity(repositoryClass="JobBundle\Repository\FurloughRepository")
 */
class Furlough
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="days", type="integer")
     */
    private $days;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_permited", type="boolean")
     */
    private $isPermited;

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }
    /**
     * @ORM\ManyToOne (targetEntity="JobBundle\Entity\User",inversedBy="furloughs")
     *
     *
     */
 private $user;

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Furlough
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set days
     *
     * @param integer $days
     *
     * @return Furlough
     */
    public function setDays($days)
    {
        $this->days = $days;

        return $this;
    }

    /**
     * Get days
     *
     * @return int
     */
    public function getDays()
    {
        return $this->days;
    }

    /**
     * Set isPermited
     *
     * @param boolean $isPermited
     *
     * @return Furlough
     */
    public function setIsPermited($isPermited)
    {
        $this->isPermited = $isPermited;

        return $this;
    }

    /**
     * Get isPermited
     *
     * @return bool
     */
    public function getIsPermited()
    {
        return $this->isPermited;
    }
}

