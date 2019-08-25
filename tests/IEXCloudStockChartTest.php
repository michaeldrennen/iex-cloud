<?php

namespace MichaelDrennen\IEXCloud\Tests;

use MichaelDrennen\IEXCloud\Exceptions\UnknownSymbol;
use MichaelDrennen\IEXCloud\Responses\Stocks\HistoricalPrices;


class IEXCloudStockChartTest extends IEXCloudTestBaseTestCase {


    /**
     * @test
     * @group chart
     */
    public function stockChartWithValidSymbolAndNoRangeShouldReturnResult() {
        $iexCloud         = $this->getIEXCloudSandboxedStableInstance();
        $historicalPrices = $iexCloud->stockChart( 'AAPL' );
        $this->assertInstanceOf( HistoricalPrices::class, $historicalPrices );
        $this->assertNotEmpty( $historicalPrices->prices );
    }


    /**
     * @test
     */
    public function stockChartWithValidSymbolAndSixMonthRangeShouldReturnResult() {
        $iexCloud         = $this->getIEXCloudSandboxedStableInstance();
        $historicalPrices = $iexCloud->stockChart( 'AAPL', '6m' );
        $this->assertInstanceOf( HistoricalPrices::class, $historicalPrices );
        $this->assertGreaterThan( 100, count( $historicalPrices->prices ) );
    }

    /**
     * @test
     * @group new
     */
    public function stockChartWithValidSymbolAndGivenDateShouldReturnResult() {
        $iexCloud         = $this->getIEXCloudSandboxedStableInstance();
        $historicalPrices = $iexCloud->stockChart( 'AAPL', 'date', [
            'chartByDay' => TRUE,
        ], '20190220' );
        $this->assertInstanceOf( HistoricalPrices::class, $historicalPrices );
    }


    /**
     * @test
     */
    public function stockChartWithInvalidSymbolShouldThrowException() {
        $this->expectException( UnknownSymbol::class );
        $iexCloud = $this->getIEXCloudSandboxedStableInstance();
        $iexCloud->stockChart( 'THIS_IS_NOT_A_VALID_SYMBOL' );
    }

    /**
     * @test
     */
    public function stockChartWithInvalidRangeShouldThrowException() {
        $this->expectException( \Exception::class );
        $iexCloud = $this->getIEXCloudSandboxedStableInstance();
        $iexCloud->stockChart( 'AAPL', 'notValidRange' );
    }

    /**
     * @test
     */
    public function stockChartWithInvalidQueryStringShouldThrowException() {
        $this->expectException( \Exception::class );
        $iexCloud = $this->getIEXCloudSandboxedStableInstance();
        $iexCloud->stockChart( 'AAPL', 'notValidRange', [ 'invalidQueryString' => 'foobar' ] );
    }

}