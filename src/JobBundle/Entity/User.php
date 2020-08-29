<?php

namespace JobBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="JobBundle\Repository\UserRepository")
 */
class User implements UserInterface
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
     * @Assert\Length(min="5",max="20",
     *     minMessage="too short",
     *     maxMessage="too long"
     * )
     *
     * @ORM\Column(name="user_name", type="string", length=255)
     *
     *
     */
    private $userName;




    /**
     * @var string
     *
          *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_added", type="datetime")
     */
    private $dateAdded;

    /**
     * @var integer
     * @ORM\Column (name="furlough" , type="integer")
     */
    private $furlough;
    /**
     * @var integer
     * @ORM\Column (name="intern" , type="integer")
     */
    private $intern;
    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="JobBundle\Entity\Role")
     * @ORM\JoinTable(name="users_roles",
     *     joinColumns={@ORM\JoinColumn(name="user_id",referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="role_id",referencedColumnName="id")})
     */
    private $roles;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="JobBundle\Entity\Plan",mappedBy="user")
     *
     */
    private $plans;


public function __construct()
{
    $this->roles=new ArrayCollection();
    $this->dateAdded=new \DateTime("now");
    $this->furlough=30;
    $this->intern=0;
    $this->plans=new ArrayCollection();
}

    /**
     * @param ArrayCollection $roles
     */
    public function setRoles(ArrayCollection $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * @param Role $role
     */
    public function addRole(Role $role): void
    {
        $this->roles->add($role);// = $role;
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
     * Set userName
     *
     * @param string $userName
     *
     * @return User
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * Get userName
     *
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set dateAdded
     *
     * @param \DateTime $dateAdded
     *
     * @return User
     */
    public function setDateAdded($dateAdded)
    {
        $this->dateAdded = $dateAdded;

        return $this;
    }

    /**
     * Get dateAdded
     *
     * @return \DateTime
     */
    public function getDateAdded()
    {
        return $this->dateAdded;
    }

    /**
     * @return ArrayCollection
     *
     */
    public function getRoles(): ?array
    {
        $stringRoles=[];
        /**
         * @var Role $role
         */
        foreach($this->roles->toArray() as $role){
            $stringRoles[]=$role->getStatus();
        }
        return $stringRoles;
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @param int $furlough
     */
    public function setFurlough(int $furlough)
    {
        $this->furlough = $furlough;
        return $this;
    }

    /**
     * @return int
     */
    public function getFurlough(): ?int
    {
        return $this->furlough;
    }

    /**
     * @param int $intern
     */
    public function setIntern(int $intern)
    {
        $this->intern = $intern;
        return $this;
    }

    /**
     * @return int
     */
    public function getIntern(): int
    {
        return $this->intern;
    }

    /**
     * @return array
     */
    public function getPlans():array
    {
        $allPlans=[];
        foreach($this->plans as $plan){
            $allPlans[]=$plan;
        }
        return $allPlans;
    }

    /**
     * @param Plan $plan
     */
    public function addPlans(Plan $plan): void
    {
        $this->plans[] = $plan;
    }



}

