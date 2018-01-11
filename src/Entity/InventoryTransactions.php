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
 * InventoryTransactions.
 *
 * @ORM\Table(name="inventory_transactions", indexes={@ORM\Index(name="customer_order_id", columns={"customer_order_id"}), @ORM\Index(name="customer_order_id_2", columns={"customer_order_id"}), @ORM\Index(name="product_id", columns={"product_id"}), @ORM\Index(name="product_id_2", columns={"product_id"}), @ORM\Index(name="purchase_order_id", columns={"purchase_order_id"}), @ORM\Index(name="purchase_order_id_2", columns={"purchase_order_id"}), @ORM\Index(name="transaction_type", columns={"transaction_type"})})
 * @ORM\Entity
 * @ApiResource()
 */
class InventoryTransactions
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
     * @ORM\Column(name="transaction_created_date", type="datetime", nullable=false)
     */
    private $transactionCreatedDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="transaction_modified_date", type="datetime", nullable=false)
     */
    private $transactionModifiedDate;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    private $quantity;

    /**
     * @var string|null
     *
     * @ORM\Column(name="comments", type="string", length=255, nullable=true)
     */
    private $comments;

    /**
     * @var InventoryTransactionTypes
     *
     * @ORM\ManyToOne(targetEntity="InventoryTransactionTypes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="transaction_type", referencedColumnName="id")
     * })
     */
    private $transactionType;

    /**
     * @var Orders
     *
     * @ORM\ManyToOne(targetEntity="Orders")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="customer_order_id", referencedColumnName="id")
     * })
     */
    private $customerOrder;

    /**
     * @var Products
     *
     * @ORM\ManyToOne(targetEntity="Products")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * })
     */
    private $product;

    /**
     * @var PurchaseOrders
     *
     * @ORM\ManyToOne(targetEntity="PurchaseOrders")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="purchase_order_id", referencedColumnName="id")
     * })
     */
    private $purchaseOrder;

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
    public function getTransactionCreatedDate()
    {
        return $this->transactionCreatedDate;
    }

    /**
     * @param \DateTime $transactionCreatedDate
     *
     * @return InventoryTransactions
     */
    public function setTransactionCreatedDate($transactionCreatedDate)
    {
        $this->transactionCreatedDate = $transactionCreatedDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getTransactionModifiedDate()
    {
        return $this->transactionModifiedDate;
    }

    /**
     * @param \DateTime $transactionModifiedDate
     *
     * @return InventoryTransactions
     */
    public function setTransactionModifiedDate($transactionModifiedDate)
    {
        $this->transactionModifiedDate = $transactionModifiedDate;

        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     *
     * @return InventoryTransactions
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param null|string $comments
     *
     * @return InventoryTransactions
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * @return \InventoryTransactionTypes
     */
    public function getTransactionType()
    {
        return $this->transactionType;
    }

    /**
     * @param \InventoryTransactionTypes $transactionType
     *
     * @return InventoryTransactions
     */
    public function setTransactionType($transactionType)
    {
        $this->transactionType = $transactionType;

        return $this;
    }

    /**
     * @return \Orders
     */
    public function getCustomerOrder()
    {
        return $this->customerOrder;
    }

    /**
     * @param \Orders $customerOrder
     *
     * @return InventoryTransactions
     */
    public function setCustomerOrder($customerOrder)
    {
        $this->customerOrder = $customerOrder;

        return $this;
    }

    /**
     * @return \Products
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param \Products $product
     *
     * @return InventoryTransactions
     */
    public function setProduct($product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return \PurchaseOrders
     */
    public function getPurchaseOrder()
    {
        return $this->purchaseOrder;
    }

    /**
     * @param \PurchaseOrders $purchaseOrder
     *
     * @return InventoryTransactions
     */
    public function setPurchaseOrder($purchaseOrder)
    {
        $this->purchaseOrder = $purchaseOrder;

        return $this;
    }
}
