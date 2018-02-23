<?php

declare(strict_types = 1);

/*
 * This file is part of the Demo project.
 *
 * (c) Anthonius Munthi <me@itstoni.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Omed\Security\Services;


use Doctrine\ORM\Event\LifecycleEventArgs;
use FOS\UserBundle\Util\CanonicalFieldsUpdater;
use Omed\Entity\User;
use Omed\Security\Model\SecurityUserInterface;

class UserCreator
{
    /**
     * @var CanonicalFieldsUpdater
     */
    private $canonicalFieldsUpdater;

    public function __construct(CanonicalFieldsUpdater $canonicalFieldsUpdater)
    {
        $this->canonicalFieldsUpdater = $canonicalFieldsUpdater;
    }

    /**
     *
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $securityUser = $args->getEntity();

        if($securityUser instanceof SecurityUserInterface){

            $login = new User();
            $login->setEmail($securityUser->getEmail());
            $login->setRoles([$securityUser->getDefaultRole()]);
            $login->setEnabled(true);
            $this->canonicalFieldsUpdater->updateCanonicalFields($login);

            $securityUser->setLogin($login);
        }
    }
}
