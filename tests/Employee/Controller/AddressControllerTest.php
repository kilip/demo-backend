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

namespace Demo\Test\Employee\Controller;

use ApiPlatform\Core\Serializer\AbstractItemNormalizer;
use Demo\Employee\Controller\AddressController;
use Demo\Entity\Address;
use Demo\Entity\Employee;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AddressControllerTest extends TestCase
{
    public function testAddAction()
    {
        $manager = $this->getMockBuilder(ObjectManager::class)
            ->getMock()
        ;

        $doctrine = $this->getMockBuilder(ManagerRegistry::class)
            ->getMock()
        ;
        $doctrine->expects($this->once())
            ->method('getManagerForClass')
            ->with(Employee::class)
            ->willReturn($manager)
        ;

        $errorNormalizer = $this->getMockBuilder(NormalizerInterface::class)
            ->getMock()
        ;
        $itemNormalizer = $this->getMockBuilder(AbstractItemNormalizer::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $validator = $this->getMockBuilder(ValidatorInterface::class)
            ->getMock()
        ;
        $controller = new AddressController(
            $doctrine,
            $errorNormalizer,
            $itemNormalizer,
            $validator
        );

        $json = <<<EOC
{
	"address": "some address",
	"city": "some city"
}
EOC;

        $request = $this->getMockBuilder(Request::class)
            ->getMock()
        ;
        $request
            ->expects($this->any())
            ->method('get')
            ->willReturnMap(array(
                array('id', null, 1),
                array('type', null, 'employee'),
            ))
        ;
        $request
            ->expects($this->exactly(2))
            ->method('getContent')
            ->willReturn($json)
        ;
        $repository = $this->getMockBuilder(ObjectRepository::class)
            ->getMock()
        ;
        $manager->expects($this->any())
            ->method('getRepository')
            ->with(Employee::class)
            ->willReturn($repository)
        ;

        $address = new Address();
        $itemNormalizer->expects($this->exactly(2))
            ->method('denormalize')
            ->willReturn($address)
        ;
        $employee = new Employee();
	
	    $responseValue = array('some' => 'value');
        $repository->expects($this->exactly(1))
            ->method('findOneBy')
            ->with(array('id' => 1))
            ->willReturn($employee)
        ;
        $itemNormalizer->expects($this->once())
            ->method('normalize')
            ->with($address)
            ->willReturn($responseValue)
        ;
        $validator->expects($this->exactly(2))
	        ->method('validate')
	        ->with($address)
	        ->willReturnOnConsecutiveCalls(
	        	[],['some'=>'error']
	        )
        ;

        // test creating new address
        $response = $controller->addAction($request);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(json_encode($responseValue), $response->getContent());
        $this->assertEquals(201, $response->getStatusCode());

        // test validation error
        $responseValue = array('some' => 'error');
        $errorNormalizer->expects($this->once())
            ->method('normalize')
            ->with($responseValue)
            ->willReturn($responseValue)
        ;
        $response = $controller->addAction($request);
        $this->assertEquals(json_encode($responseValue), $response->getContent());
        $this->assertEquals(401, $response->getStatusCode());
    }
}
