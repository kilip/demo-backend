<?php


declare(strict_types=1);

/*
 * This file is part of the Omed project.
 *
 * (c) Anthonius Munthi <me@itstoni.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Omed\Test\Entity;

use Omed\Entity\User;
use Doctrine\Common\Collections\Collection;
use Omed\Entity\Address;
use Omed\Entity\Customer;
use Omed\Test\MutableTest;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    use MutableTest;

    protected function configureMutablePropertiesTest()
    {
        $user = new User();
        $this->mutableTestConfig = array(
            'type' => array(
                'value' => Customer::TYPE_COMPANY,
                'default' => Customer::TYPE_PERSONAL,
            ),
            'status' => array(
                'value' => Customer::STATUS_EMAIL_CONFIRMED,
                'default' => Customer::STATUS_REGISTERED,
            ),
            'login' => array(
                'value' => $user,
            ),
        );

        $this->propertyToIgnores = array('addresses');
    }

    public function testAddressCollection()
    {
        $entity = new Customer();
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

    public function testHasAddress()
    {
        $add1 = new Address();
        $add1->setAddress('add1');

        $add2 = new Address();
        $add2->setAddress('add2');

        $entity = new Customer();
        $this->assertFalse($entity->hasAddress('add1'));

        $entity->getAddresses()->add($add1);
        $this->assertTrue($entity->hasAddress($add1));
        $this->assertTrue($entity->hasAddress('add1'));
    }
}
