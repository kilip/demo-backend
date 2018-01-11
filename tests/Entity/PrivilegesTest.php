<?php


/*
 * This file is part of the northwind-backend project.
 *
 * (c) Anthonius Munthi <me@itstoni.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Northwind\Tests\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Northwind\Test\MutableTest;
use PHPUnit\Framework\TestCase;

class PrivilegesTest extends TestCase
{
    use MutableTest;

    protected function configureMutablePropertiesTest()
    {
        $this->mutableTestConfig = array(
            'employee' => array(
                'default' => new ArrayCollection(),
            ),
        );
    }
}
