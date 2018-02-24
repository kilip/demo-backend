<?php

declare(strict_types=1);

/*
 * This file is part of the Demo project.
 *
 * (c) Anthonius Munthi <me@itstoni.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Omed\Behat\Contexts;

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Doctrine\Common\Persistence\ManagerRegistry;
use Faker\Factory;
use Omed\Resource\Entity\Address;
use Omed\Resource\Entity\Customer;

class CustomerContext implements Context
{
    use DoctrineContextTrait;

    /**
     * @var RestContext
     */
    private $restContext;

    /**
     * @var UserContext
     */
    private $userContext;

    /**
     * @var Customer
     */
    private $currentCustomer;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->setDoctrine($doctrine);
    }

    /**
     * @param BeforeScenarioScope $scope
     * @BeforeScenario
     */
    public function gatherContexts(BeforeScenarioScope $scope)
    {
        $environment = $scope->getEnvironment();

        $this->restContext = $environment->getContext(RestContext::class);
        $this->userContext = $environment->getContext(UserContext::class);
    }

    /**
     * @Given I don't have any customer data
     */
    public function iDonTHaveAnyCustomerData()
    {
        $qb = $this->getEntityManager()
            ->createQueryBuilder()
            ->delete('Omed:Employee', 'e')
        ;
        $qb->getQuery()->execute();
        $this->getEntityManager()->flush();
    }

    /**
     * @Given I don't have customer named :name
     */
    public function iDonTHaveCustomerNamed($name)
    {
        $customer = $this->findByName($name);
        if ($customer instanceof Customer) {
            $this->getEntityManager()->remove($customer);
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @Given I have customer with data:
     *
     * @param TableNode $table
     */
    public function iHaveCustomerWithData(TableNode $table)
    {
        /* @var Customer $customer */
        $rows = $table->getRowsHash();
        $name = $rows['name'];

        $customer = $this->findByName($name, true);
        foreach ($rows as $key => $value) {
            $callable = array($customer, 'set'.$key);
            if (is_callable($callable)) {
                call_user_func($callable, $value);
            } elseif ('address' == $key) {
                $this->createCustomerAddress($customer, ['address' => $value]);
            }
        }
        $this->getEntityManager()->persist($customer);
        $this->getEntityManager()->flush();
    }

    /**
     * @Given I send :method request to customer :name
     * @Given I send :method request to customer :name with body:
     */
    public function iSendRequestToCustomer($method, $name, PyStringNode $body = null)
    {
        $customer = $this->findByName($name);
        if (!$customer instanceof Customer) {
            throw new \Exception('Customer '.$name.'  Not Exists');
        }
        $routeName = 'api_customers_'.strtolower($method).'_item';
        $url = $this->restContext->generateUrl(
            $routeName,
            ['id' => $customer->getId()]
        );
        $this->restContext->iSetHeaderTypeToHydra();
        if (!is_null($body)) {
            $this->restContext->iSendARequestToWithBody($method, $url, $body);
        } else {
            $this->restContext->iSendARequestTo($method, $url);
        }
    }

    /**
     * @Given I send :method request to customer address for :name with body:
     *
     * @param string            $method
     * @param string            $name
     * @param PyStringNode|null $body
     *
     * @throws \Exception
     */
    public function iSendCustomerAddressRequest($method, $name, PyStringNode $body = null)
    {
        $customer = $this->findByName($name);
        if (!$customer instanceof Customer) {
            throw new \Exception('Customer named: '.$name.' not exists');
        }

        $routeName = 'add_customer_address';
        $url = $this->restContext->generateUrl($routeName, ['id' => $customer->getId()]);

        $this->restContext->iSetHeaderTypeToHydra();
        $this->restContext->iSendARequestToWithBody($method, $url, $body);
    }

    /**
     * @Given I have address for customer named :name
     */
    public function iHaveAddressForCustomerNamed($name)
    {
        $customer = $this->findByName($name, true);
        if (0 === $customer->getAddresses()->count()) {
            $faker = Factory::create();
            $address = new Address();
            $address
                ->setAddress($faker->address)
                ->setCity($faker->city)
            ;
            $customer->addAddress($address);
            $this->getEntityManager()->persist($customer);
            $this->getEntityManager()->flush();
        }
        $this->currentCustomer = $customer;
    }

    /**
     * @Given I have customer named :name
     */
    public function iHaveCustomerNamed($name)
    {
        $this->findByName($name, true);
    }

    /**
     * @Given I send :method request to this current customer first address with:
     * @Given I send :method request to this current customer address
     */
    public function iSendRequestToHisFirstAddressWith($method, PyStringNode $body = null)
    {
        $method = strtolower($method);
        $routeName = 'api_addresses_'.$method.'_item';
        $addresses = $this->currentCustomer->getAddresses();
        $url = $this->restContext->generateUrl(
            $routeName,
            array('id' => $addresses[0]->getId())
        );
        $this->restContext->iSendARequestTo($method, $url, $body);
    }

    /**
     * Create address will be skipped if customer already have same address.
     *
     * @param Customer $customer
     * @param array    $info
     */
    public function createCustomerAddress(Customer $customer, array $info)
    {
        $faker = Factory::create();
        $defaults = [
            'address' => $faker->address,
            'city' => $faker->city,
            'country' => $faker->country,
        ];
        $info = array_merge($defaults, $info);
        if (!$customer->hasAddress($info['address'])) {
            $address = new Address();
            foreach ($info as $key => $value) {
                $callable = array($address, 'set'.$key);
                if (is_callable($callable)) {
                    call_user_func($callable, $value);
                }
            }
        }
    }

    /**
     * Find customer by name.
     *
     * @param $name
     *
     * @return null|object
     */
    public function findByName($name, $create = false)
    {
        $repo = $this->getRepository(Customer::class);
        $customer = $repo->findOneBy(['name' => $name]);

        if ((!$customer instanceof Customer) && $create) {
            $customer = $this->createCustomer(['name' => $name]);
        }

        return $customer;
    }

    /**
     * @param array $data
     *
     * @return Customer
     */
    public function createCustomer(array $data)
    {
        $faker = Factory::create();
        $defaults = [
            'name' => $faker->name,
            'company' => $faker->company,
            'email' => $faker->companyEmail,
        ];

        $data = array_merge($defaults, $data);

        $customer = new Customer();
        $customer
            ->setName($data['name'])
            ->setEmail($data['email'])
            ->setCompany($data['company'])
        ;
        $this->getEntityManager()->persist($customer);
        $this->getEntityManager()->flush();

        return $customer;
    }

    /**
     * @Given I send :method request to customers with body:
     * @Given I send :method to customers
     *
     * @param string            $method
     * @param PyStringNode|null $body
     */
    public function iSendPostRequestToCustomers($method, PyStringNode $body = null)
    {
        $routeName = 'api_customers_'.strtolower($method).'_collection';
        $url = $this->restContext->generateUrl($routeName, []);

        $this->restContext->iSetHeaderTypeToHydra();
        $this->restContext->iSendARequestToWithBody($method, $url, $body);
    }
}
