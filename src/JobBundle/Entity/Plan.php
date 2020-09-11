<?php

namespace JobBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;




/**
 * Plan
 *
 * @ORM\Table(name="plans")
 * @ORM\Entity(repositoryClass="JobBundle\Repository\PlanRepository")
 */
class Plan
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
     *
     */
    private $name;



    /**
     * @var  User
     *
     * @ORM\ManyToOne(targetEntity="JobBundle\Entity\User",inversedBy="plans")
     * @ORM\JoinColumn (name="user_id",referencedColumnName="id")
     */
    private $users;

    /**
     * @var string
     *
     * @ORM\Column(name="job", type="string", length=255)
     *
     *
     */
    private $job;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;
    /**
     * @ORM\ManyToOne(targetEntity="JobBundle\Entity\Job",inversedBy="plans")
     */
    private $work;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_done", type="boolean")
     */
    private $isDone;
    /**
     * @var Report
     * @ORM\OneToOne(targetEntity="JobBundle\Entity\Report",mappedBy="plan")
     */
    private $report;

    /**
     * @return mixed
     */
    public function getReport()
    {
        return $this->report;
    }

    /**
     * @param mixed $report
     */
    public function setReport($report): void
    {
        $this->report = $report;
    }


    /**
     * @param Job $work
     */
    public function setWork(Job $work): void
    {
        $this->work = $work;
    }

    /**
     * @return mixed
     */
    public function getWork()
    {
        return $this->work;
    }




    /**
     * @param User $users
     */
    public function setUsers(User $users): void
    {
        $this->users = $users;
    }

    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }


    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
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
     * Set job
     *
     * @param string $job
     *
     * @return Plan
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Plan
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set isDone
     *
     * @param boolean $isDone
     *
     * @return Plan
     */
    public function setIsDone($isDone)
    {
        $this->isDone = $isDone;

        return $this;
    }

    /**
     * Get isDone
     *
     * @return bool
     */
    public function getIsDone()
    {
        return $this->isDone;
    }
}