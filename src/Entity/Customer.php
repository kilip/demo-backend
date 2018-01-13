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
 * Class Customer.
 *
 * @ORM\Entity()
 * @ORM\Table(name="customers")
 * @ApiResource()
 *
 * @author Anthonius Munthi <me@itstoni.com>
 */
class Customer implements AddressableInterface
{
    const TYPE_PERSONAL = 1;

    const TYPE_COMPANY = 2;

    const STATUS_REGISTERED = 1;

    const STATUS_EMAIL_CONFIRMED = 2;

    /**
     * @var null|int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var null|string
     * @ORM\Column(type="string",nullable=true)
     * @Assert\Email()
     */
    private $email;

    /**
     * @var int
     * @ORM\Column(type="smallint")
     * @Assert\NotBlank()
     */
    private $type;

    /**
     * @var int
     * @ORM\Column(type="smallint")
     * @Assert\NotBlank()
     */
    private $status;

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
     * @Gedmo\Timestampable(on="update")
     */
    private $updated;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="Address",cascade={"all"},fetch="EAGER")
     * @ORM\JoinTable(
     *     name="customer_address",
     *     joinColumns={@ORM\JoinColumn(name="customer_id",referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="address_id",referencedColumnName="id")}
     * )
     * @ApiSubresource()
     */
    private $addresses;

    public function __construct()
    {
        $this->status = static::STATUS_REGISTERED;
        $this->type = static::TYPE_PERSONAL;
        $this->addresses = new ArrayCollection();
    }

    public function addAddress(Address $address)
    {
        if (!$this->getAddresses()->contains($address)) {
            $this->addresses->add($address);
        }
    }

    /**
     * @return null|int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Customer
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
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
     * @return Customer
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     *
     * @return Customer
     */
    public function setType(int $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     *
     * @return Customer
     */
    public function setStatus(int $status)
    {
        $this->status = $status;

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
     * @return Collection
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    /**
     * @param Collection $addresses
     *
     * @return Customer
     */
    public function setAddresses(Collection $addresses)
    {
        $this->addresses = $addresses;

        return $this;
    }
}
