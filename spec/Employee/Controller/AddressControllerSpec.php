<?php

namespace spec\Demo\Employee\Controller;

use ApiPlatform\Core\Serializer\AbstractItemNormalizer;
use Demo\Employee\Controller\AddressController;
use Demo\Entity\Address;
use Demo\Entity\Employee;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AddressControllerSpec extends ObjectBehavior
{
	function let(
		ManagerRegistry $doctrine,
		EntityManagerInterface $manager,
		ObjectRepository $repository,
		NormalizerInterface $errorNormalizer,
		AbstractItemNormalizer $itemNormalizer,
		ValidatorInterface $validator
	)
	{
		$doctrine
			->getManagerForClass(Employee::class)
			->willReturn($manager)
		;
		$manager->getRepository(Employee::class)
			->willReturn($repository)
		;
		$this->beConstructedWith($doctrine,$errorNormalizer,$itemNormalizer,$validator);
	}
	
    function it_is_initializable()
    {
        $this->shouldHaveType(AddressController::class);
    }
    
    function it_should_add_new_address(
    	$repository,
    	Address $address,
    	$itemNormalizer,
    	Employee $employee,
    	Request $request,
		ManagerRegistry $manager,
		ConstraintViolationListInterface $errorNormalizer,
		ValidatorInterface $validator
    )
    {
    	
    	$requestContent = '{"some":"value"}';
        $request->get('id')
	        ->shouldBeCalled()
	        ->willReturn(1)
        ;
	    $request->get('type')
	            ->shouldBeCalled()
	            ->willReturn('employee')
	    ;
	    $request->getContent()
		    ->shouldBeCalled()
		    ->willReturn($requestContent)
	    ;
	    
	    $itemNormalizer
		    ->denormalize(json_decode($requestContent,true),Address::class,'json')
		    ->shouldBeCalled()
		    ->willReturn($address)
	    ;
        $repository
	        ->findOneBy(['id'=>1])
	        ->shouldBeCalled()
	        ->willReturn($employee)
	    ;
        
        $employee->addAddress($address)
	        ->shouldBeCalled()
	        ->willReturn($employee)
        ;
        $manager->persist($employee)
	        ->shouldBeCalled()
	    ;
        $manager->flush()->shouldBeCalled();
        $itemNormalizer->normalize($address)
	        ->shouldBeCalled()
	        ->willReturn('check-value')
        ;
	    
        $validator->validate($address)
	        ->shouldBeCalled()
	        ->willReturn([])
        ;
        $response = $this->addAction($request);
        $response->shouldHaveType(JsonResponse::class);
        $response->getContent()->shouldBe(json_encode('check-value'));
	
        // check error
	    $error = ['some'=>'error'];
	    $validator->validate($address)
	              ->shouldBeCalled()
	              ->willReturn($error)
	    ;
	    $errorNormalizer->normalize($error)
		    ->shouldBeCalled()
		    ->willReturn($error)
	    ;
	    $response = $this->addAction($request);
	    $response->shouldHaveType(JsonResponse::class);
	    $response->getContent()->shouldBe(json_encode($error));
	    
    }
}
