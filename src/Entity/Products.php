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
 * Products.
 *
 * @ORM\Table(name="products", indexes={@ORM\Index(name="product_code", columns={"product_code"})})
 * @ORM\Entity
 * @ApiResource()
 */
class Products
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
     * @ORM\Column(name="supplier_ids", type="text", nullable=true)
     */
    private $supplierIds;

    /**
     * @var string|null
     *
     * @ORM\Column(name="product_code", type="string", length=25, nullable=true)
     */
    private $productCode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="product_name", type="string", length=50, nullable=true)
     */
    private $productName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="standard_cost", type="decimal", precision=19, scale=4, nullable=true, options={"default"="0.0000"})
     */
    private $standardCost = 0.0000;

    /**
     * @var string
     *
     * @ORM\Column(name="list_price", type="decimal", precision=19, scale=4, nullable=false, options={"default"="0.0000"})
     */
    private $listPrice = 0.0000;

    /**
     * @var int|null
     *
     * @ORM\Column(name="reorder_level", type="integer", nullable=true)
     */
    private $reorderLevel;

    /**
     * @var int|null
     *
     * @ORM\Column(name="target_level", type="integer", nullable=true)
     */
    private $targetLevel;

    /**
     * @var string|null
     *
     * @ORM\Column(name="quantity_per_unit", type="string", length=50, nullable=true)
     */
    private $quantityPerUnit;

    /**
     * @var bool
     *
     * @ORM\Column(name="discontinued", type="integer", nullable=false)
     */
    private $discontinued = 0;

    /**
     * @var int|null
     *
     * @ORM\Column(name="minimum_reorder_quantity", type="integer", nullable=true)
     */
    private $minimumReorderQuantity;

    /**
     * @var string|null
     *
     * @ORM\Column(name="category", type="string", length=50, nullable=true)
     */
    private $category;

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

    public function getDiscontinued()
    {
        return $this->isDiscontinued();
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
    public function getSupplierIds()
    {
        return $this->supplierIds;
    }

    /**
     * @param null|string $supplierIds
     *
     * @return Products
     */
    public function setSupplierIds($supplierIds)
    {
        $this->supplierIds = $supplierIds;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getProductCode()
    {
        return $this->productCode;
    }

    /**
     * @param null|string $productCode
     *
     * @return Products
     */
    public function setProductCode($productCode)
    {
        $this->productCode = $productCode;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getProductName()
    {
        return $this->productName;
    }

    /**
     * @param null|string $productName
     *
     * @return Products
     */
    public function setProductName($productName)
    {
        $this->productName = $productName;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param null|string $description
     *
     * @return Products
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getStandardCost()
    {
        return $this->standardCost;
    }

    /**
     * @param null|string $standardCost
     *
     * @return Products
     */
    public function setStandardCost($standardCost)
    {
        $this->standardCost = $standardCost;

        return $this;
    }

    /**
     * @return string
     */
    public function getListPrice()
    {
        return $this->listPrice;
    }

    /**
     * @param string $listPrice
     *
     * @return Products
     */
    public function setListPrice($listPrice)
    {
        $this->listPrice = $listPrice;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getReorderLevel()
    {
        return $this->reorderLevel;
    }

    /**
     * @param int|null $reorderLevel
     *
     * @return Products
     */
    public function setReorderLevel($reorderLevel)
    {
        $this->reorderLevel = $reorderLevel;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getTargetLevel()
    {
        return $this->targetLevel;
    }

    /**
     * @param int|null $targetLevel
     *
     * @return Products
     */
    public function setTargetLevel($targetLevel)
    {
        $this->targetLevel = $targetLevel;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getQuantityPerUnit()
    {
        return $this->quantityPerUnit;
    }

    /**
     * @param null|string $quantityPerUnit
     *
     * @return Products
     */
    public function setQuantityPerUnit($quantityPerUnit)
    {
        $this->quantityPerUnit = $quantityPerUnit;

        return $this;
    }

    /**
     * @return bool
     */
    public function isDiscontinued()
    {
        return $this->discontinued;
    }

    /**
     * @param bool $discontinued
     *
     * @return Products
     */
    public function setDiscontinued($discontinued)
    {
        $this->discontinued = $discontinued;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getMinimumReorderQuantity()
    {
        return $this->minimumReorderQuantity;
    }

    /**
     * @param int|null $minimumReorderQuantity
     *
     * @return Products
     */
    public function setMinimumReorderQuantity($minimumReorderQuantity)
    {
        $this->minimumReorderQuantity = $minimumReorderQuantity;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param null|string $category
     *
     * @return Products
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @param null|string $attachments
     *
     * @return Products
     */
    public function setAttachments($attachments)
    {
        $this->attachments = $attachments;

        return $this;
    }
}
