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

namespace Demo\Behat\Contexts;

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behatch\Context\RestContext as BehatchRestContext;

class RestContext implements Context
{
    /**
     * @var BehatchRestContext
     */
    private $restContext;

    /**
     * @param BeforeScenarioScope $scope
     * @BeforeScenario
     */
    public function gatherContexts(BeforeScenarioScope $scope)
    {
        $environment = $scope->getEnvironment();

        $this->restContext = $environment->getContext(BehatchRestContext::class);
    }

    /**
     * @Then I set header type to hydra
     */
    public function iSetHeaderTypeToHydra()
    {
        $this->restContext->iAddHeaderEqualTo('Accept', 'application/ld+json');
        $this->restContext->iAddHeaderEqualTo('Content-Type', 'application/ld+json');
    }
}
