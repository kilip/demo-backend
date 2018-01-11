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
 * Invoices.
 *
 * @ORM\Table(name="invoices", indexes={@ORM\Index(name="id", columns={"id"}), @ORM\Index(name="id_2", columns={"id"}), @ORM\Index(name="fk_invoices_orders1_idx", columns={"order_id"})})
 * @ORM\Entity
 * @ApiResource()
 */
class Invoices
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
     * @ORM\Column(name="invoice_date", type="datetime", nullable=false)
     */
    private $invoiceDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="due_date", type="datetime", nullable=true)
     */
    private $dueDate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tax", type="decimal", precision=19, scale=4, nullable=true, options={"default"="0.0000"})
     */
    private $tax = 0.0000;

    /**
     * @var string|null
     *
     * @ORM\Column(name="shipping", type="decimal", precision=19, scale=4, nullable=true, options={"default"="0.0000"})
     */
    private $shipping = 0.0000;

    /**
     * @var string|null
     *
     * @ORM\Column(name="amount_due", type="decimal", precision=19, scale=4, nullable=true, options={"default"="0.0000"})
     */
    private $amountDue = 0.0000;

    /**
     * @var Orders
     *
     * @ORM\ManyToOne(targetEntity="Orders")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     * })
     */
    private $order;

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
    public function getInvoiceDate()
    {
        return $this->invoiceDate;
    }

    /**
     * @param \DateTime $invoiceDate
     *
     * @return Invoices
     */
    public function setInvoiceDate($invoiceDate)
    {
        $this->invoiceDate = $invoiceDate;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * @param \DateTime|null $dueDate
     *
     * @return Invoices
     */
    public function setDueDate($dueDate)
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * @param null|string $tax
     *
     * @return Invoices
     */
    public function setTax($tax)
    {
        $this->tax = $tax;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getShipping()
    {
        return $this->shipping;
    }

    /**
     * @param null|string $shipping
     *
     * @return Invoices
     */
    public function setShipping($shipping)
    {
        $this->shipping = $shipping;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getAmountDue()
    {
        return $this->amountDue;
    }

    /**
     * @param null|string $amountDue
     *
     * @return Invoices
     */
    public function setAmountDue($amountDue)
    {
        $this->amountDue = $amountDue;

        return $this;
    }

    /**
     * @return Orders
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param Orders $order
     *
     * @return Invoices
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }
}
