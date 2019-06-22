<?php

namespace MichaelDrennen\IEXCloud\Tests;


use MichaelDrennen\IEXCloud\IEXCloud;
use MichaelDrennen\IEXCloud\Responses\StockStats;
use PHPUnit\Framework\TestCase;

class IEXCloudTest extends TestCase {


    /**
     * @test
     */
    public function stockStatsWithValidSymbolShouldReturnStockStatsObject() {
        $iexCloud   = new IEXCloud( getenv( 'IEX_CLOUD_PUBLISHABLE_TOKEN' ), TRUE, FALSE, 'stable' );
        $stockStats = $iexCloud->stockStats( 'AAPL' );

        $this->assertInstanceOf( StockStats::class, $stockStats );
        $this->assertEquals( 'Apple, Inc.', $stockStats->companyName );
    }


    /**
     * @test
     * @group new
     */
    public function stockStatsWithValidSymbolAskingForSpecificStatShouldReturnStockStatsObject() {
        $iexCloud   = new IEXCloud( getenv( 'IEX_CLOUD_PUBLISHABLE_TOKEN' ), TRUE, FALSE, 'stable' );
        $sharesOutstanding = $iexCloud->stockStat( 'AAPL', 'sharesOutstanding' );

        $this->assertGreaterThan( 0, $sharesOutstanding );
    }


}