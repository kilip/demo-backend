<?php

/*
 * This file is part of the Northwind project.
 *
 * (c) Anthonius Munthi <me@itstoni.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Northwind\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * Suppliers.
 *
 * @ORM\Table(
 *     name="suppliers",
 *     indexes={
 *          @ORM\Index(columns={"city"}),
 *          @ORM\Index(columns={"company"}),
 *          @ORM\Index(columns={"first_name"}),
 *          @ORM\Index(columns={"last_name"}),
 *          @ORM\Index(columns={"zip_postal_code"}),
 *          @ORM\Index(columns={"state_province"})
 *      }
 * )
 * @ORM\Entity
 * @ApiResource()
 */
class Suppliers
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="company", type="string", length=50, nullable=true)
     */
    private $company;

    /**
     * @var string|null
     *
     * @ORM\Column(name="last_name", type="string", length=50, nullable=true)
     */
    private $lastName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="first_name", type="string", length=50, nullable=true)
     */
    private $firstName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email_address", type="string", length=50, nullable=true)
     */
    private $emailAddress;

    /**
     * @var string|null
     *
     * @ORM\Column(name="job_title", type="string", length=50, nullable=true)
     */
    private $jobTitle;

    /**
     * @var string|null
     *
     * @ORM\Column(name="business_phone", type="string", length=25, nullable=true)
     */
    private $businessPhone;

    /**
     * @var string|null
     *
     * @ORM\Column(name="home_phone", type="string", length=25, nullable=true)
     */
    private $homePhone;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mobile_phone", type="string", length=25, nullable=true)
     */
    private $mobilePhone;

    /**
     * @var string|null
     *
     * @ORM\Column(name="fax_number", type="string", length=25, nullable=true)
     */
    private $faxNumber;

    /**
     * @var string|null
     *
     * @ORM\Column(name="address", type="text", nullable=true)
     */
    private $address;

    /**
     * @var string|null
     *
     * @ORM\Column(name="city", type="string", length=50, nullable=true)
     */
    private $city;

    /**
     * @var string|null
     *
     * @ORM\Column(name="state_province", type="string", length=50, nullable=true)
     */
    private $stateProvince;

    /**
     * @var string|null
     *
     * @ORM\Column(name="zip_postal_code", type="string", length=15, nullable=true)
     */
    private $zipPostalCode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="country_region", type="string", length=50, nullable=true)
     */
    private $countryRegion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="web_page", type="text", nullable=true)
     */
    private $webPage;

    /**
     * @var string|null
     *
     * @ORM\Column(name="notes", type="text", nullable=true)
     */
    private $notes;

    /**
     * @var string|null
     *
     * @ORM\Column(name="attachments", type="blob", nullable=true)
     */
    private $attachments;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getAttachments()
    {
        return stream_get_contents($this->attachments);
    }

    /**
     * @return null|string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param null|string $company
     *
     * @return Suppliers
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param null|string $lastName
     *
     * @return Suppliers
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param null|string $firstName
     *
     * @return Suppliers
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * @param null|string $emailAddress
     *
     * @return Suppliers
     */
    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getJobTitle()
    {
        return $this->jobTitle;
    }

    /**
     * @param null|string $jobTitle
     *
     * @return Suppliers
     */
    public function setJobTitle($jobTitle)
    {
        $this->jobTitle = $jobTitle;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getBusinessPhone()
    {
        return $this->businessPhone;
    }

    /**
     * @param null|string $businessPhone
     *
     * @return Suppliers
     */
    public function setBusinessPhone($businessPhone)
    {
        $this->businessPhone = $businessPhone;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getHomePhone()
    {
        return $this->homePhone;
    }

    /**
     * @param null|string $homePhone
     *
     * @return Suppliers
     */
    public function setHomePhone($homePhone)
    {
        $this->homePhone = $homePhone;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getMobilePhone()
    {
        return $this->mobilePhone;
    }

    /**
     * @param null|string $mobilePhone
     *
     * @return Suppliers
     */
    public function setMobilePhone($mobilePhone)
    {
        $this->mobilePhone = $mobilePhone;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getFaxNumber()
    {
        return $this->faxNumber;
    }

    /**
     * @param null|string $faxNumber
     *
     * @return Suppliers
     */
    public function setFaxNumber($faxNumber)
    {
        $this->faxNumber = $faxNumber;

        return $this;
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
     * @return Suppliers
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
     * @return Suppliers
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getStateProvince()
    {
        return $this->stateProvince;
    }

    /**
     * @param null|string $stateProvince
     *
     * @return Suppliers
     */
    public function setStateProvince($stateProvince)
    {
        $this->stateProvince = $stateProvince;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getZipPostalCode()
    {
        return $this->zipPostalCode;
    }

    /**
     * @param null|string $zipPostalCode
     *
     * @return Suppliers
     */
    public function setZipPostalCode($zipPostalCode)
    {
        $this->zipPostalCode = $zipPostalCode;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getCountryRegion()
    {
        return $this->countryRegion;
    }

    /**
     * @param null|string $countryRegion
     *
     * @return Suppliers
     */
    public function setCountryRegion($countryRegion)
    {
        $this->countryRegion = $countryRegion;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getWebPage()
    {
        return $this->webPage;
    }

    /**
     * @param null|string $webPage
     *
     * @return Suppliers
     */
    public function setWebPage($webPage)
    {
        $this->webPage = $webPage;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param null|string $notes
     *
     * @return Suppliers
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * @param null|string $attachments
     *
     * @return Suppliers
     */
    public function setAttachments($attachments)
    {
        $this->attachments = $attachments;

        return $this;
    }
}
