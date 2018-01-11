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
 * Orders.
 *
 * @ORM\Table(
 *     name="orders",
 *     indexes={
 *          @ORM\Index(columns={"customer_id"}),
 *          @ORM\Index(columns={"employee_id"}),
 *          @ORM\Index(columns={"id"}),
 *          @ORM\Index(columns={"shipper_id"}),
 *          @ORM\Index(columns={"tax_status_id"}),
 *          @ORM\Index(columns={"ship_zip_postal_code"}),
 *          @ORM\Index(columns={"status_id"})
 *      }
 * )
 * @ORM\Entity
 * @ApiResource()
 */
class Orders
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
     * @var \DateTime
     *
     * @ORM\Column(name="order_date", type="datetime", nullable=false)
     */
    private $orderDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="shipped_date", type="datetime", nullable=true)
     */
    private $shippedDate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ship_name", type="string", length=50, nullable=true)
     */
    private $shipName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ship_address", type="text", nullable=true)
     */
    private $shipAddress;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ship_city", type="string", length=50, nullable=true)
     */
    private $shipCity;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ship_state_province", type="string", length=50, nullable=true)
     */
    private $shipStateProvince;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ship_zip_postal_code", type="string", length=50, nullable=true)
     */
    private $shipZipPostalCode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ship_country_region", type="string", length=50, nullable=true)
     */
    private $shipCountryRegion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="shipping_fee", type="decimal", precision=19, scale=4, nullable=true, options={"default"="0.0000"})
     */
    private $shippingFee = 0.0000;

    /**
     * @var string|null
     *
     * @ORM\Column(name="taxes", type="decimal", precision=19, scale=4, nullable=true, options={"default"="0.0000"})
     */
    private $taxes = 0.0000;

    /**
     * @var string|null
     *
     * @ORM\Column(name="payment_type", type="string", length=50, nullable=true)
     */
    private $paymentType;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="paid_date", type="datetime", nullable=true)
     */
    private $paidDate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="notes", type="text", nullable=true)
     */
    private $notes;

    /**
     * @var float|null
     *
     * @ORM\Column(name="tax_rate", type="float", precision=10, scale=0, nullable=true)
     */
    private $taxRate = 0;

    /**
     * @var Customers
     *
     * @ORM\ManyToOne(targetEntity="Customers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     * })
     */
    private $customer;

    /**
     * @var Employees
     *
     * @ORM\ManyToOne(targetEntity="Employees")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="employee_id", referencedColumnName="id")
     * })
     */
    private $employee;

    /**
     * @var OrdersStatus
     *
     * @ORM\ManyToOne(targetEntity="OrdersStatus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     * })
     */
    private $status;

    /**
     * @var OrdersTaxStatus
     *
     * @ORM\ManyToOne(targetEntity="OrdersTaxStatus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tax_status_id", referencedColumnName="id")
     * })
     */
    private $taxStatus;

    /**
     * @var Shippers
     *
     * @ORM\ManyToOne(targetEntity="Shippers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="shipper_id", referencedColumnName="id")
     * })
     */
    private $shipper;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getOrderDate()
    {
        return $this->orderDate;
    }

    /**
     * @param \DateTime $orderDate
     *
     * @return Orders
     */
    public function setOrderDate($orderDate)
    {
        $this->orderDate = $orderDate;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getShippedDate()
    {
        return $this->shippedDate;
    }

    /**
     * @param \DateTime|null $shippedDate
     *
     * @return Orders
     */
    public function setShippedDate($shippedDate)
    {
        $this->shippedDate = $shippedDate;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getShipName()
    {
        return $this->shipName;
    }

    /**
     * @param null|string $shipName
     *
     * @return Orders
     */
    public function setShipName($shipName)
    {
        $this->shipName = $shipName;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getShipAddress()
    {
        return $this->shipAddress;
    }

    /**
     * @param null|string $shipAddress
     *
     * @return Orders
     */
    public function setShipAddress($shipAddress)
    {
        $this->shipAddress = $shipAddress;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getShipCity()
    {
        return $this->shipCity;
    }

    /**
     * @param null|string $shipCity
     *
     * @return Orders
     */
    public function setShipCity($shipCity)
    {
        $this->shipCity = $shipCity;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getShipStateProvince()
    {
        return $this->shipStateProvince;
    }

    /**
     * @param null|string $shipStateProvince
     *
     * @return Orders
     */
    public function setShipStateProvince($shipStateProvince)
    {
        $this->shipStateProvince = $shipStateProvince;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getShipZipPostalCode()
    {
        return $this->shipZipPostalCode;
    }

    /**
     * @param null|string $shipZipPostalCode
     *
     * @return Orders
     */
    public function setShipZipPostalCode($shipZipPostalCode)
    {
        $this->shipZipPostalCode = $shipZipPostalCode;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getShipCountryRegion()
    {
        return $this->shipCountryRegion;
    }

    /**
     * @param null|string $shipCountryRegion
     *
     * @return Orders
     */
    public function setShipCountryRegion($shipCountryRegion)
    {
        $this->shipCountryRegion = $shipCountryRegion;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getShippingFee()
    {
        return $this->shippingFee;
    }

    /**
     * @param null|string $shippingFee
     *
     * @return Orders
     */
    public function setShippingFee($shippingFee)
    {
        $this->shippingFee = $shippingFee;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getTaxes()
    {
        return $this->taxes;
    }

    /**
     * @param null|string $taxes
     *
     * @return Orders
     */
    public function setTaxes($taxes)
    {
        $this->taxes = $taxes;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPaymentType()
    {
        return $this->paymentType;
    }

    /**
     * @param null|string $paymentType
     *
     * @return Orders
     */
    public function setPaymentType($paymentType)
    {
        $this->paymentType = $paymentType;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getPaidDate()
    {
        return $this->paidDate;
    }

    /**
     * @param \DateTime|null $paidDate
     *
     * @return Orders
     */
    public function setPaidDate($paidDate)
    {
        $this->paidDate = $paidDate;

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
     * @return Orders
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getTaxRate()
    {
        return $this->taxRate;
    }

    /**
     * @param float|null $taxRate
     *
     * @return Orders
     */
    public function setTaxRate($taxRate)
    {
        $this->taxRate = $taxRate;

        return $this;
    }

    /**
     * @return Customers
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param Customers $customer
     *
     * @return Orders
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return Employees
     */
    public function getEmployee()
    {
        return $this->employee;
    }

    /**
     * @param Employees $employee
     *
     * @return Orders
     */
    public function setEmployee($employee)
    {
        $this->employee = $employee;

        return $this;
    }

    /**
     * @return \OrdersStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param \OrdersStatus $status
     *
     * @return Orders
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return \OrdersTaxStatus
     */
    public function getTaxStatus()
    {
        return $this->taxStatus;
    }

    /**
     * @param \OrdersTaxStatus $taxStatus
     *
     * @return Orders
     */
    public function setTaxStatus($taxStatus)
    {
        $this->taxStatus = $taxStatus;

        return $this;
    }

    /**
     * @return \Shippers
     */
    public function getShipper()
    {
        return $this->shipper;
    }

    /**
     * @param \Shippers $shipper
     *
     * @return Orders
     */
    public function setShipper($shipper)
    {
        $this->shipper = $shipper;

        return $this;
    }
}
