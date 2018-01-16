<?php

declare(strict_types=1);

/*
 * This file is part of the Omed project.
 *
 * (c) Anthonius Munthi <me@itstoni.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Omed\Behat\Contexts;

use Behatch\Context\RestContext as BehatchRestContext;
use Behatch\HttpCall\Request;
use Symfony\Component\Routing\RouterInterface;

class RestContext extends BehatchRestContext
{
    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(Request $request, RouterInterface $router)
    {
        parent::__construct($request);
        $this->router = $router;
    }

    /**
     * @Then I set header type to hydra
     */
    public function iSetHeaderTypeToHydra()
    {
        $this->iAddHeaderEqualTo('Accept', 'application/ld+json');
        $this->iAddHeaderEqualTo('Content-Type', 'application/ld+json');
    }

    /**
     * Generate url from route name.
     *
     * @param $routeName
     * @param $parameters
     * @param int $referenceType
     *
     * @return string
     */
    public function generateUrl($routeName, $parameters, $referenceType = RouterInterface::ABSOLUTE_PATH)
    {
        return $this->router->generate($routeName, $parameters, $referenceType);
    }
}
