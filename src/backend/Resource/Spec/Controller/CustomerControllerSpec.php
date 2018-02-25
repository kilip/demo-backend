<?php

namespace Spec\Omed\Resource\Controller;

use Omed\Resource\Controller\CustomerController;
use Omed\Resource\Entity\User;
use PhpSpec\ObjectBehavior;

class CustomerControllerSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(CustomerController::class);
    }

    public function it_should_get_profile_properly(
        $id,
        User $user
    ) {
        $this->getProfile($id, $user)
            ->shouldHaveType(User::class)
        ;
    }

    public function it_should_update_profile_properly(
        $id,
        User $user
    ) {
        $this->updateProfile($id, $user)
            ->shouldHaveType(User::class)
        ;
    }
}
