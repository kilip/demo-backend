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
use Northwind\Entity\Employees;
use Northwind\Test\MutableTest;
use PHPUnit\Framework\TestCase;

class EmployeesTest extends TestCase
{
    use MutableTest;

    /**
     * @var Employees
     */
    protected $entity;

    protected function configureMutablePropertiesTest()
    {
        $this->mutableTestConfig = array(
            'privilege' => array(
                'default' => new ArrayCollection(),
                'value' => new ArrayCollection(),
            ),
            'id' => array(
                'readonly' => true,
            ),
        );
        $this->propertyToIgnores = array('attachments');
    }

    public function testAttachments()
    {
        $entity = new Employees();

        $resource = tmpfile();
        $entity->setAttachments($resource);
        $this->assertEquals('', $entity->getAttachments());
    }
}
