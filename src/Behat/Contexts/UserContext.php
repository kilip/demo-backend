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

namespace Demo\Behat\Contexts;

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Testwork\Hook\Scope\BeforeSuiteScope;
use Demo\Entity\User;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectRepository;
use Faker\Factory;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTManager;
use Symfony\Component\Dotenv\Dotenv;

class UserContext implements Context
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    private $entityManager;

    /**
     * @var JWTManager
     */
    private $jwtManager;

    /**
     * @var RestContext
     */
    private $restContext;

    /**
     * @var ObjectRepository
     */
    private $userRepository;

    public function __construct(ManagerRegistry $doctrine, JWTManager $jwtManager)
    {
        $this->entityManager = $doctrine->getManagerForClass(User::class);
        $this->userRepository = $this->entityManager->getRepository(User::class);
        $this->jwtManager = $jwtManager;
    }

    /**
     * @BeforeSuite
     */
    static public function beforeSuite(BeforeSuiteScope $scope)
    {
        (new Dotenv())->load(getcwd().'/.env');
    }

    /**
     * @BeforeScenario
     *
     * @param BeforeScenarioScope $scope
     */
    public function gatherContexts(BeforeScenarioScope $scope)
    {
        $this->restContext = $scope->getEnvironment()->getContext(RestContext::class);
    }

    /**
     * @Given I am logged in as admin
     */
    public function iAmLoggedInAsAdmin()
    {
        $user = $this->findUserByName('admin');
        if (null === $user) {
            $this->createUser('admin', 'admin', null, 'ROLE_SUPER_ADMIN');
        }
        $this->login($user);
    }

    /**
     * @Given I have user
     */
    public function iHaveUser()
    {
    }

    /**
     * @param User $user
     */
    public function login(User $user)
    {
        $token = $this->jwtManager->create($user);
        $this->restContext->iAddHeaderEqualTo('Authorization', "Bearer $token");
    }

    public function createUser($name, $password, $email = null, $role = User::ROLE_DEFAULT)
    {
        $faker = Factory::create();
        $email = null === $email ? $faker->email : $email;
        $user = new User();
        $user->setUsername($name);
        $user->setPlainPassword($password);
        $user->setEmail($email);
        $user->setRoles(array($role));
        $user->setEnabled(true);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    /**
     * @Given I have logout
     */
    public function logout()
    {
        $this->restContext->iAddHeaderEqualTo('Authorization', '');
    }

    /**
     * @param string $name
     *
     * @return null|User
     */
    public function findUserByName($name, $create = false)
    {
        return $this->userRepository->findOneBy(array('username' => $name));
    }
}
