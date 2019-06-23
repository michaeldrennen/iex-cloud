<?php

namespace MichaelDrennen\IEXCloud\Tests;


use MichaelDrennen\IEXCloud\Exceptions\EndpointNotFound;
use MichaelDrennen\IEXCloud\Exceptions\UnknownSymbol;
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
     */
    public function stockStatsWithValidSymbolUsingFilterShouldReturnOnlyRequestedDataPoints() {
        $iexCloud   = new IEXCloud( getenv( 'IEX_CLOUD_PUBLISHABLE_TOKEN' ), TRUE, FALSE, 'stable' );
        $stockStats = $iexCloud->stockStats( 'AAPL', [ 'sharesOutstanding' ] );
        $this->assertGreaterThan( 0, $stockStats->sharesOutstanding );
        $this->assertNull( $stockStats->companyName );
    }


    /**
     * @test
     * @group new
     */
    public function stockStatsWithValidSymbolAskingForSpecificStatShouldReturnStockStatsObject() {
        $iexCloud          = new IEXCloud( getenv( 'IEX_CLOUD_PUBLISHABLE_TOKEN' ), TRUE, FALSE, 'stable' );
        $sharesOutstanding = $iexCloud->stockStat( 'AAPL', 'sharesOutstanding' );

        $this->assertGreaterThan( 0, $sharesOutstanding );
    }

    /**
     * @test
     */
    public function askingForAnInvalidSymbolShouldThrowUnknownSymbolException() {
        $this->expectException( UnknownSymbol::class );
        $iexCloud = new IEXCloud( getenv( 'IEX_CLOUD_PUBLISHABLE_TOKEN' ), TRUE, FALSE, 'stable' );
        $iexCloud->stockStat( 'idontexist', 'sharesOutstanding' );
    }

    /**
     * @test
     */
    public function callingAnEndpointThatDoesNotExistShouldThrowException() {
        $this->expectException( EndpointNotFound::class );
        $iexCloud = new IEXCloud( getenv( 'IEX_CLOUD_PUBLISHABLE_TOKEN' ), TRUE, FALSE, 'stable' );
        $iexCloud->testingNotExistentEndpoint();
    }


}