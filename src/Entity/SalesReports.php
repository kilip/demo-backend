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
 * SalesReports.
 *
 * @ORM\Table(name="sales_reports")
 * @ORM\Entity
 * @ApiResource()
 */
class SalesReports
{
    /**
     * @var string
     *
     * @ORM\Column(name="group_by", type="string", length=50, nullable=false)
     * @ORM\Id
     */
    private $groupBy;

    /**
     * @var string|null
     *
     * @ORM\Column(name="display", type="string", length=50, nullable=true)
     */
    private $display;

    /**
     * @var string|null
     *
     * @ORM\Column(name="title", type="string", length=50, nullable=true)
     */
    private $title;

    /**
     * @var string|null
     *
     * @ORM\Column(name="filter_row_source", type="text", nullable=true)
     */
    private $filterRowSource;

    /**
     * @var int
     *
     * @ORM\Column(name="default", type="integer", nullable=false)
     */
    private $default = 0;

    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @return string
     */
    public function getGroupBy()
    {
        return $this->groupBy;
    }

    /**
     * @return null|string
     */
    public function getDisplay()
    {
        return $this->display;
    }

    /**
     * @param null|string $display
     *
     * @return SalesReports
     */
    public function setDisplay($display)
    {
        $this->display = $display;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param null|string $title
     *
     * @return SalesReports
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getFilterRowSource()
    {
        return $this->filterRowSource;
    }

    /**
     * @param null|string $filterRowSource
     *
     * @return SalesReports
     */
    public function setFilterRowSource($filterRowSource)
    {
        $this->filterRowSource = $filterRowSource;

        return $this;
    }

    /**
     * @return bool
     */
    public function isDefault()
    {
        return $this->default;
    }

    /**
     * @param bool $default
     *
     * @return SalesReports
     */
    public function setDefault($default)
    {
        $this->default = $default;

        return $this;
    }
}
