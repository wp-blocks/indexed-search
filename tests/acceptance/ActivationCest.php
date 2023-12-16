<?php

namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

class ActivationCest
{
    /**
     * @group plugin
     */
    public function test_it_deactivates_activates_correctly(AcceptanceTester $I): void
    {
        $I->loginAsAdmin();
        $I->amOnPluginsPage();

        $I->seePluginActivated('indexed-search');

        $I->deactivatePlugin('indexed-search');

        $I->seePluginDeactivated('indexed-search');

        $I->activatePlugin('indexed-search');

        $I->seePluginActivated('indexed-search');
    }
}
