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
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Address.
 *
 * @ORM\Entity()
 * @ApiResource(
 *     attributes= {
 *         {"access_control"="is_granted('ROLE_EMPLOYEE')"}
 *     },
 *     collectionOperations={
 *          "get"={"method"="GET","access_control"="is_granted('ROLE_EMPLOYEE')"},
 *          "newEmployeeAddress"={"method"="POST","route_name"="add_employee_address","access_control"="is_granted('ROLE_EMPLOYEE')"},
 *          "newCustomerAddress"={"method"="POST","route_name"="add_customer_address","access_control"="is_granted('ROLE_EMPLOYEE')"},
 *     },
 *     itemOperations={
 *         "get"={"method"="GET","access_control"="is_granted('ROLE_EMPLOYEE')"},
 *         "put"={"method"="PUT","access_control"="is_granted('ROLE_EMPLOYEE')"},
 *         "delete"={"method"="DELETE","access_control"="is_granted('ROLE_EMPLOYEE')"},
 *     }
 * )
 * @ORM\Table(name="address")
 */
class Address
{
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
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $address;

    /**
     * @var null|string
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $city;

    /**
     * @var null|string
     * @ORM\Column(type="string",nullable=true)
     */
    private $state;

    /**
     * @var null|string
     * @ORM\Column(type="string",nullable=true)
     * @Assert\Country()
     */
    private $country;

    /**
     * @var null|string
     * @ORM\Column(type="string",nullable=true)
     */
    private $zip;

    /**
     * @var null|string
     *
     * @ORM\Column(type="string",length=50,nullable=true)
     */
    private $phone;

    /**
     * @var null|string
     *
     * @ORM\Column(type="string",length=50,nullable=true)
     */
    private $fax;

    /**
     * @var null|string
     *
     * @ORM\Column(type="string",length=50,nullable=true)
     */
    private $mobile;

    /**
     * @var null|\DateTime
     *
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updated;

    /**
     * @return null|int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param null|string $address
     *
     * @return Address
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param null|string $city
     *
     * @return Address
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param null|string $state
     *
     * @return Address
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param null|string $country
     *
     * @return Address
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @param null|string $zip
     *
     * @return Address
     */
    public function setZip($zip)
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param null|string $phone
     *
     * @return Address
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * @param null|string $fax
     *
     * @return Address
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * @param null|string $mobile
     *
     * @return Address
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getUpdated()
    {
        return $this->updated;
    }
}
