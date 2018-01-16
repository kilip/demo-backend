<?php

namespace spec\Omed\Customer\Controller;

use Omed\Customer\Controller\CustomerController;
use Omed\Entity\User;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CustomerControllerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CustomerController::class);
    }

    function it_should_get_profile_properly(
        $id,
        User $user
    )
    {
        $this->getProfile($id,$user)
            ->shouldHaveType(User::class)
        ;
    }

    function it_should_update_profile_properly(
        $id,
        User $user
    )
    {
        $this->updateProfile($id,$user)
            ->shouldHaveType(User::class)
        ;
    }
}
