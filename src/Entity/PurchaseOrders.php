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
 * PurchaseOrders.
 *
 * @ORM\Table(
 *     name="purchase_orders",
 *     indexes={
 *          @ORM\Index(columns={"created_by"}),
 *          @ORM\Index(columns={"status_id"}),
 *          @ORM\Index(columns={"id"}),
 *          @ORM\Index(columns={"supplier_id"}),
 *      }
 * )
 * @ORM\Entity
 * @ApiResource()
 */
class PurchaseOrders
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="submitted_date", type="datetime", nullable=true)
     */
    private $submittedDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime", nullable=false)
     */
    private $creationDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="expected_date", type="datetime", nullable=true)
     */
    private $expectedDate;

    /**
     * @var string
     *
     * @ORM\Column(name="shipping_fee", type="decimal", precision=19, scale=4, nullable=false, options={"default"="0.0000"})
     */
    private $shippingFee = 0.0000;

    /**
     * @var string
     *
     * @ORM\Column(name="taxes", type="decimal", precision=19, scale=4, nullable=false, options={"default"="0.0000"})
     */
    private $taxes = 0.0000;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="payment_date", type="datetime", nullable=true)
     */
    private $paymentDate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="payment_amount", type="decimal", precision=19, scale=4, nullable=true, options={"default"="0.0000"})
     */
    private $paymentAmount = 0.0000;

    /**
     * @var string|null
     *
     * @ORM\Column(name="payment_method", type="string", length=50, nullable=true)
     */
    private $paymentMethod;

    /**
     * @var string|null
     *
     * @ORM\Column(name="notes", type="text", nullable=true)
     */
    private $notes;

    /**
     * @var int|null
     *
     * @ORM\Column(name="approved_by", type="integer", nullable=true)
     */
    private $approvedBy;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="approved_date", type="datetime", nullable=true)
     */
    private $approvedDate;

    /**
     * @var int|null
     *
     * @ORM\Column(name="submitted_by", type="integer", nullable=true)
     */
    private $submittedBy;

    /**
     * @var Employees
     *
     * @ORM\ManyToOne(targetEntity="Employees")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="created_by", referencedColumnName="id")
     * })
     */
    private $createdBy;

    /**
     * @var PurchaseOrderStatus
     *
     * @ORM\ManyToOne(targetEntity="PurchaseOrderStatus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     * })
     */
    private $status;

    /**
     * @var Suppliers
     *
     * @ORM\ManyToOne(targetEntity="Suppliers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="supplier_id", referencedColumnName="id")
     * })
     */
    private $supplier;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \DateTime|null
     */
    public function getSubmittedDate()
    {
        return $this->submittedDate;
    }

    /**
     * @param \DateTime|null $submittedDate
     *
     * @return PurchaseOrders
     */
    public function setSubmittedDate($submittedDate)
    {
        $this->submittedDate = $submittedDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @param \DateTime $creationDate
     *
     * @return PurchaseOrders
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getExpectedDate()
    {
        return $this->expectedDate;
    }

    /**
     * @param \DateTime|null $expectedDate
     *
     * @return PurchaseOrders
     */
    public function setExpectedDate($expectedDate)
    {
        $this->expectedDate = $expectedDate;

        return $this;
    }

    /**
     * @return string
     */
    public function getShippingFee()
    {
        return $this->shippingFee;
    }

    /**
     * @param string $shippingFee
     *
     * @return PurchaseOrders
     */
    public function setShippingFee($shippingFee)
    {
        $this->shippingFee = $shippingFee;

        return $this;
    }

    /**
     * @return string
     */
    public function getTaxes()
    {
        return $this->taxes;
    }

    /**
     * @param string $taxes
     *
     * @return PurchaseOrders
     */
    public function setTaxes($taxes)
    {
        $this->taxes = $taxes;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getPaymentDate()
    {
        return $this->paymentDate;
    }

    /**
     * @param \DateTime|null $paymentDate
     *
     * @return PurchaseOrders
     */
    public function setPaymentDate($paymentDate)
    {
        $this->paymentDate = $paymentDate;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPaymentAmount()
    {
        return $this->paymentAmount;
    }

    /**
     * @param null|string $paymentAmount
     *
     * @return PurchaseOrders
     */
    public function setPaymentAmount($paymentAmount)
    {
        $this->paymentAmount = $paymentAmount;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * @param null|string $paymentMethod
     *
     * @return PurchaseOrders
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;

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
     * @return PurchaseOrders
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getApprovedBy()
    {
        return $this->approvedBy;
    }

    /**
     * @param int|null $approvedBy
     *
     * @return PurchaseOrders
     */
    public function setApprovedBy($approvedBy)
    {
        $this->approvedBy = $approvedBy;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getApprovedDate()
    {
        return $this->approvedDate;
    }

    /**
     * @param \DateTime|null $approvedDate
     *
     * @return PurchaseOrders
     */
    public function setApprovedDate($approvedDate)
    {
        $this->approvedDate = $approvedDate;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getSubmittedBy()
    {
        return $this->submittedBy;
    }

    /**
     * @param int|null $submittedBy
     *
     * @return PurchaseOrders
     */
    public function setSubmittedBy($submittedBy)
    {
        $this->submittedBy = $submittedBy;

        return $this;
    }

    /**
     * @return Employees
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param Employees $createdBy
     *
     * @return PurchaseOrders
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * @return PurchaseOrderStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param PurchaseOrderStatus $status
     *
     * @return PurchaseOrders
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Suppliers
     */
    public function getSupplier()
    {
        return $this->supplier;
    }

    /**
     * @param Suppliers $supplier
     *
     * @return PurchaseOrders
     */
    public function setSupplier($supplier)
    {
        $this->supplier = $supplier;

        return $this;
    }
}
