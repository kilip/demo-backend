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

namespace Omed\Employee\EventListener;


use Doctrine\ORM\Event\LifecycleEventArgs;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Util\CanonicalFieldsUpdater;
use Omed\Security\Model\SecurityUserInterface;

class EmployeeListener
{
    private $canonicalFieldsUpdater;

    public function __construct(CanonicalFieldsUpdater $canonicalFieldsUpdater)
    {
        $this->canonicalFieldsUpdater = $canonicalFieldsUpdater;
    }

    /**
     * @param LifecycleEventArgs $args
     * @internal param Employee $employee
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if($entity instanceof SecurityUserInterface){
            $this->syncEmailToUser($entity,$args);
        }
    }

    private function syncEmailToUser(SecurityUserInterface $entity, LifecycleEventArgs $args)
    {
        $user = $entity->getLogin();
        if($user instanceof UserInterface){
            if($user->getEmail() != $entity->getEmail()){
                $user
                    ->setEmail($entity->getEmail())
                ;
                $this->canonicalFieldsUpdater->updateCanonicalFields($user);
                $em = $args->getEntityManager();
                $em->persist($user);
                $em->flush($user);
            }
        }
    }

}
