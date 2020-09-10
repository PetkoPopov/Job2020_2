<?php

namespace JobBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Job
 *
 * @ORM\Table(name="job")
 * @ORM\Entity(repositoryClass="JobBundle\Repository\JobRepository")
 */
class Job
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
     * @ORM\Column(name="nameWork", type="string", length=255)
     */
    private $nameWork;

    /**
     * @var int
     *
     * @ORM\Column(name="payedFor", type="integer", nullable=true)
     */
    private $payedFor;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="JobBundle\Entity\Plan",mappedBy="work")
     */
     private $plans;

     public function __construct()
     {
         $this->plans=new ArrayCollection();
     }

    /**
     * @param ArrayCollection $plans
     */
    public function setPlans(ArrayCollection $plan)
    {
        $this->plans[] = $plan;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getPlans(): ArrayCollection
    {
        $allPlans=[];
        foreach($this->plans->toArray() as $plan){
            $allPlans[]=$plan;
        }
        return $allPlans;
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
     * Set nameWork
     *
     * @param string $nameWork
     *
     * @return Job
     */
    public function setNameWork($nameWork)
    {
        $this->nameWork = $nameWork;

        return $this;
    }

    /**
     * Get nameWork
     *
     * @return string
     */
    public function getNameWork()
    {
        return $this->nameWork;
    }

    /**
     * Set payedFor
     *
     * @param integer $payedFor
     *
     * @return Job
     */
    public function setPayedFor($payedFor)
    {
        $this->payedFor = $payedFor;

        return $this;
    }

    /**
     * Get payedFor
     *
     * @return int
     */
    public function getPayedFor()
    {
        return $this->payedFor;
    }
}

