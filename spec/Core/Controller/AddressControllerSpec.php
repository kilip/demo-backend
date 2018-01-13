<?php

namespace spec\Demo\Core\Controller;

use Demo\Core\Controller\AddressController;
use Demo\Core\Service\AddressService;
use Demo\Entity\Customer;
use Demo\Entity\Employee;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Request;

class AddressControllerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(AddressController::class);
    }
    
    public function it_should_create_address_for_employee(
    	AddressService $service, Request $request
    )
    {
        $service->createNew(Employee::class,1,$request)
	        ->shouldBeCalled()
        ;
        $this->addForEmployeeAction(1,$service,$request);
    }
	
	public function it_should_create_address_for_customer(
		AddressService $service, Request $request
	)
	{
		$service->createNew(Customer::class,1,$request)
		        ->shouldBeCalled()
		;
		$this->addForCustomerAction(1,$service,$request);
	}
}
