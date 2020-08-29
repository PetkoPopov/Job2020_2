<?php

namespace JobBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Wage
 *
 * @ORM\Table(name="wages")
 * @ORM\Entity(repositoryClass="JobBundle\Repository\WageRepository")
 */
class Wage
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
     *@ORM\Column(name="job", type="string", length=255, unique=true)
     *
     *
     *
     */
    private $job;

    /**
     * @var int
     *
     * @ORM\Column(name="charge", type="integer")
     *
     */
    private $charge;


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
     * Set job
     *
     * @param string $job
     *
     * @return Wage
     */
    public function setJob($job)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Get job
     *
     * @return string
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Set charge
     *
     * @param integer $charge
     *
     * @return Wage
     */
    public function setCharge($charge)
    {
        $this->charge = $charge;

        return $this;
    }

    /**
     * Get charge
     *
     * @return int
     */
    public function getCharge()
    {
        return $this->charge;
    }
}

