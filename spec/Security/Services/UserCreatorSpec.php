<?php

namespace spec\Omed\Security\Services;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Util\CanonicalFieldsUpdater;
use Omed\Entity\User;
use Omed\Security\Model\SecurityUserInterface;
use Omed\Security\Services\UserCreator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserCreatorSpec extends ObjectBehavior
{
    function let(
        CanonicalFieldsUpdater $canonicalFieldsUpdater,
        LifecycleEventArgs $args,
        SecurityUserInterface $entity,
        UserInterface $user,
        ObjectManager $manager
    )
    {
        $args->getObjectManager()->willReturn($manager);
        $args->getEntity()->willReturn($entity);
        $this->beConstructedWith($canonicalFieldsUpdater);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UserCreator::class);
    }

    function it_should_create_new_login_for_security_user(
        SecurityUserInterface $entity,
        LifecycleEventArgs $args,
        ObjectManager $manager
    )
    {
        $entity->getDefaultRole()
            ->willReturn(User::ROLE_EMPLOYEE)
        ;
        $entity->getEmail()
            ->willReturn('some@example.com')
        ;
        $entity
            ->setLogin(Argument::type(User::class))
            ->shouldBeCalled()
        ;
        $this->prePersist($args);
    }
}