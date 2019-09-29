<?php

namespace MichaelDrennen\IEXCloud\Tests;


use MichaelDrennen\IEXCloud\Exceptions\APIKeyMissing;
use MichaelDrennen\IEXCloud\Exceptions\EndpointNotFound;
use MichaelDrennen\IEXCloud\Exceptions\UnknownSymbol;
use MichaelDrennen\IEXCloud\Responses\Stocks\StockStats;

class IEXCloudTest extends IEXCloudTestBaseTestCase {




    /**
     * @test
     */
    public function stockStatsWithValidSymbolShouldReturnStockStatsObject() {
        $iexCloud   = $this->getIEXCloudSandboxedStableInstance();
        $stockStats = $iexCloud->stockStats( 'AAPL' );

        $this->assertInstanceOf( StockStats::class, $stockStats );
        $this->assertEquals( 'Apple, Inc.', $stockStats->companyName );
    }

    /**
     * @test
     */
    public function stockStatsWithValidSymbolUsingFilterShouldReturnOnlyRequestedDataPoints() {
        $iexCloud   = $this->getIEXCloudSandboxedStableInstance();
        $stockStats = $iexCloud->stockStats( 'AAPL', [ 'sharesOutstanding' ] );
        $this->assertGreaterThan( 0, $stockStats->sharesOutstanding );
        $this->assertNull( $stockStats->companyName );
    }


    /**
     * @test
     */
    public function stockStatsWithValidSymbolAskingForSpecificStatShouldReturnStockStatsObject() {
        $iexCloud   = $this->getIEXCloudSandboxedStableInstance();
        $sharesOutstanding = $iexCloud->stockStat( 'AAPL', 'sharesOutstanding' );

        $this->assertGreaterThan( 0, $sharesOutstanding );
    }


    /**
     * @test
     */
    public function askingForAnInvalidSymbolShouldThrowUnknownSymbolException() {
        $this->expectException( UnknownSymbol::class );
        $iexCloud   = $this->getIEXCloudSandboxedStableInstance();
        $iexCloud->stockStat( 'idontexist', 'sharesOutstanding' );
    }

    /**
     * @test
     */
    public function callingAnEndpointThatDoesNotExistShouldThrowException() {
        $this->expectException( EndpointNotFound::class );
        $iexCloud   = $this->getIEXCloudSandboxedStableInstance();
        $iexCloud->testingNotExistentEndpoint();
    }

    /**
     * @test
     */
    public function callingValidEndpointWithoutTokenShouldThrowException() {
        $this->expectException( APIKeyMissing::class );
        $iexCloud   = $this->getIEXCloudSandboxedStableInstance();
        $iexCloud->testingValidRequestWithEmptyToken();
    }






}