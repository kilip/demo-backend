<?php


declare(strict_types=1);

/*
 * This file is part of the Omed project.
 *
 * (c) Anthonius Munthi <me@itstoni.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Omed\Resource\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\UserInterface;
use Gedmo\Mapping\Annotation as Gedmo;
use Omed\Security\Model\SecurityUserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Employee.
 *
 * @ORM\Entity()
 * @ORM\Table(name="employees")
 * @ApiResource(
 *     attributes= {
 *         {"access_control"="is_granted('ROLE_ADMIN')"}
 *     },
 *     collectionOperations={
 *         "get"={"method"="GET","access_control"="is_granted('ROLE_EMPLOYEE')"},
 *         "post"={"method"="POST","access_control"="is_granted('ROLE_ADMIN')"}
 *     },
 *     itemOperations={
 *         "get"={"method"="GET","access_control"="is_granted('ROLE_EMPLOYEE')"},
 *         "put"={"method"="PUT","access_control"="is_granted('ROLE_ADMIN')"},
 *         "delete"={"method"="DELETE","access_control"="is_granted('ROLE_ADMIN')"},
 *         "employeeProfile"={
 *              "method"="GET",
 *              "route_name"="api_employees_get_profile",
 *              "path"="/employees/{id}/profile",
 *              "access_control"="is_granted('ROLE_EMPLOYEE') and object.getLogin() == user"
 *         },
 *         "employeeProfileUpdate"={
 *              "method"="PUT",
 *              "route_name"="api_employees_put_profile",
 *              "path"="/employees/{id}/profile",
 *              "access_control"="is_granted('ROLE_EMPLOYEE') and object.getLogin() == user"
 *          }
 *     }
 * )
 *
 * @author Anthonius Munthi <me@itstoni.com>
 */
class Employee implements AddressableInterface, SecurityUserInterface
{
    const GENDER_MALE = 'M';

    const GENDER_FEMALE = 'F';

    /**
     * @var null|int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var null|string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var null|\DateTime
     *
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     * @Assert\Date()
     */
    private $birthDate;

    /**
     * @var null|string
     *
     * @ORM\Column(type="string",length=1)
     * @Assert\Choice(choices={"M","F"}, message="Choose a valid gender type 'M' or 'F'")
     */
    private $gender;

    /**
     * @var null|string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @var null|\DateTime
     *
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $created;

    /**
     * @var null|\DateTime
     *
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $updated;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="Address",cascade={"persist","remove"},fetch="LAZY")
     * @ORM\JoinTable(
     *     name="employee_address",
     *     joinColumns={@ORM\JoinColumn(name="employee_id",referencedColumnName="id",onDelete="CASCADE")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="address_id",referencedColumnName="id",onDelete="CASCADE")}
     * )
     * @ApiSubresource()
     */
    private $addresses;

    /**
     * @var null|User
     *
     * @ORM\OneToOne(targetEntity="Omed\Resource\Entity\User",cascade={"all"},orphanRemoval=true)
     * @ORM\JoinColumn(name="security_user_id",referencedColumnName="id",onDelete="CASCADE")
     */
    private $login;

    /**
     * @var null|\DateTime
     * @ORM\Column(name="hire_date",type="datetime",nullable=true)
     */
    private $hireDate;

    /**
     * @var bool
     */
    private $active = true;

    /**
     * Employee constructor.
     */
    public function __construct()
    {
        $this->addresses = new ArrayCollection();
    }

    public function getDefaultRole()
    {
        return User::ROLE_EMPLOYEE;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive(bool $active)
    {
        $this->active = $active;
    }

    /**
     * @return \DateTime|null
     */
    public function getHireDate()
    {
        return $this->hireDate;
    }

    /**
     * @param \DateTime|null $hireDate
     */
    public function setHireDate($hireDate)
    {
        $this->hireDate = $hireDate;
    }

    /**
     * @param UserInterface $login
     *
     * @return Employee
     */
    public function setLogin(UserInterface $login): self
    {
        $this->login = $login;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @param \DateTime $birthDate
     *
     * @return Employee
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     *
     * @return Employee
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @return \DateTime|null
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param Address $address
     *
     * @return $this
     */
    public function addAddress(Address $address): self
    {
        if (!$this->getAddresses()->contains($address)) {
            $this->getAddresses()->add($address);
        }

        return $this;
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param null|string $email
     *
     * @return Employee
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param null|string $name
     *
     * @return Employee
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    /**
     * @param Collection $addresses
     *
     * @return Employee
     */
    public function setAddresses(Collection $addresses)
    {
        $this->addresses = $addresses;

        return $this;
    }

    /**
     * @return UserInterface|null
     */
    public function getLogin()
    {
        if (is_null($this->login)) {
            $this->login = new User();
        }

        return $this->login;
    }
}
