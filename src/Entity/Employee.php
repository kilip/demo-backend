<?php


declare(strict_types=1);

/*
 * This file is part of the Demo project.
 *
 * (c) Anthonius Munthi <me@itstoni.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Demo\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Employee.
 *
 * @ORM\Entity()
 * @ORM\Table(name="employees")
 * @ApiResource(
 *     attributes= {
 *         {"access_control"="is_granted('ROLE_EMPLOYEE')"}
 *     },
 *     collectionOperations={
 *         "get"={"method"="GET","access_control"="is_granted('ROLE_EMPLOYEE')"},
 *         "post"={"method"="POST","access_control"="is_granted('ROLE_EMPLOYEE')"}
 *     },
 *     itemOperations={
 *         "get"={"method"="GET","access_control"="is_granted('ROLE_EMPLOYEE')"},
 *         "put"={"method"="PUT","access_control"="is_granted('ROLE_EMPLOYEE')"},
 *         "delete"={"method"="DELETE","access_control"="is_granted('ROLE_EMPLOYEE')"},
 *     }
 * )
 *
 * @author Anthonius Munthi <me@itstoni.com>
 * @TODO: make sync email between user and employee
 */
class Employee implements AddressableInterface
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
     *     joinColumns={@ORM\JoinColumn(name="customer_id",referencedColumnName="id",onDelete="CASCADE")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="address_id",referencedColumnName="id",onDelete="CASCADE")}
     * )
     * @ApiSubresource()
     */
    private $addresses;

    /**
     * @var null|User
     *
     * @ORM\OneToOne(targetEntity="Demo\Entity\User",cascade={"all"},orphanRemoval=true)
     */
    private $login;

    /**
     * Employee constructor.
     */
    public function __construct()
    {
        $this->addresses = new ArrayCollection();
    }

    /**
     * @param User|null $login
     *
     * @return Employee
     */
    public function setLogin($login): self
    {
        $this->login = $login;
        $login->setEmail($this->getEmail());

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
     * @param \DateTime|null $birthDate
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
     * @param null|string $gender
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
     * @return User|null
     */
    public function getLogin()
    {
        return $this->login;
    }
}
