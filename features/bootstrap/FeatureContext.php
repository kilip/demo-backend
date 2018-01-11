<?php

use Behat\Behat\Context\Context;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\SchemaTool;

/**
 * This context class contains the definitions of the steps used by the demo 
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 * 
 * @see http://behat.org/en/latest/quick_start.html
 */
class FeatureContext implements Context
{
    /**
     * @var ManagerRegistry
     */
    private $doctrine;
	
	/**
	 * @var \Doctrine\Common\Persistence\ObjectManager
	 */
	private $manager;
	
	/**
	 * @var SchemaTool
	 */
	private $schemaTool;
	
	/**
	 * @var array
	 */
	private $classes;
	
	public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
	    $this->manager = $doctrine->getManager();
	    $this->schemaTool = new SchemaTool($this->manager);
	    $this->classes = $this->manager->getMetadataFactory()->getAllMetadata();
    }
	
	/**
	 * @BeforeScenario @createSchema
	 */
	public function createDatabase()
	{
		$this->schemaTool->createSchema($this->classes);
	}
	
	/**
	 * @AfterScenario @dropSchema
	 */
	public function dropDatabase()
	{
		$this->schemaTool->dropSchema($this->classes);
	}
}
