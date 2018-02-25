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

namespace Omed\Security\Model;

use FOS\UserBundle\Model\UserInterface;

interface SecurityUserInterface
{
    /**
     * @param UserInterface $login
     *
     * @return mixed
     */
    public function setLogin(UserInterface $login);

    /**
     * @return UserInterface
     */
    public function getLogin();

    /**
     * @param string $email
     */
    public function setEmail($email);

    /**
     * @return string
     */
    public function getEmail();

    /**
     * Get default role for this user.
     *
     * @return string
     */
    public function getDefaultRole();
}
