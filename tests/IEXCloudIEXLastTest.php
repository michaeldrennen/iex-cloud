<?php

namespace MichaelDrennen\IEXCloud\Tests;

use MichaelDrennen\IEXCloud\Responses\IEX\LastTrades;

class IEXCloudIEXLastTest extends IEXCloudTestBaseTestCase {

    /**
     * @test
     * @group last
     */
    public function lastWithTwoSymbolsShouldReturnLastTradesWithTwoTrades() {
        // Stop here and mark this test as incomplete.
        $this->markTestIncomplete(
            "IEX Cloud is returning a 404 API endpoint not found for /last. That needs to be investigated."
        );
        $iexCloud   = $this->getIEXCloudSandboxedStableInstance();
        $lastTrades = $iexCloud->last( [ 'AAPL','SNAP' ] );
        $this->assertInstanceOf( LastTrades::class, $lastTrades );
        $this->assertCount( 2, $lastTrades->lastTrades );
    }


}