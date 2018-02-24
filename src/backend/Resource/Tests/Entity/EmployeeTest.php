<?php

/*
 * This file is part of the Omed project.
 *
 * (c) Anthonius Munthi <me@itstoni.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Omed\Resource\Tests\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Omed\Resource\Entity\Address;
use Omed\Resource\Entity\Employee;
use Omed\Resource\Entity\User;
use Omed\Core\Test\MutableTest;
use PHPUnit\Framework\TestCase;

class EmployeeTest extends TestCase
{
    use MutableTest;

    protected function configureMutablePropertiesTest()
    {
        $user = new User();
        $this->mutableTestConfig = array(
            'addresses' => array(
                'value' => new ArrayCollection(),
            ),
            'login' => array(
                'value' => $user,
            ),
            'active' => [
                'value' => false,
            ]
        );
    }

    public function testAddressCollection()
    {
        $entity = new Employee();
        $address1 = new Address();
        $address2 = new Address();

        $this->assertInstanceOf(
            Collection::class,
            $entity->getAddresses(),
            'Should create address collection on construct'
        );
        $entity->addAddress($address1);
        $entity->addAddress($address2);
        $this->assertCount(2, $entity->getAddresses());

        $entity->addAddress($address1);
        $this->assertCount(2, $entity->getAddresses(), 'Can\'t add same address twice');

        $collection = $this->getMockForAbstractClass(Collection::class);
        $entity->setAddresses($collection);
        $this->assertEquals($collection, $entity->getAddresses());
    }
}
