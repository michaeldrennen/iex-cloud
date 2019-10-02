<?php

namespace MichaelDrennen\IEXCloud\Tests;

use MichaelDrennen\IEXCloud\Exceptions\UnknownSymbol;
use MichaelDrennen\IEXCloud\Responses\Stocks\HistoricalPrice;
use MichaelDrennen\IEXCloud\Responses\Stocks\HistoricalPrices;
use MichaelDrennen\IEXCloud\Responses\Stocks\Quote;


class IEXCloudStockQuoteTest extends IEXCloudTestBaseTestCase {


    /**
     * @test
     * @group quote
     */
    public function stockQuoteShouldReturnQuote() {
        $iexCloud = $this->getIEXCloudSandboxedStableInstance();
        $quote    = $iexCloud->quote( 'AAPL' );
        $this->assertInstanceOf( Quote::class, $quote );
        $this->assertNotEmpty( $quote->symbol );
    }


    /**
     * @test
     * @group quote
     */
    public function stockQuoteWithFieldSpecifiedShouldReturnOnlyField() {
        $iexCloud = $this->getIEXCloudSandboxedStableInstance();
        $iexAskPrice    = $iexCloud->quoteField( 'AAPL','iexAskPrice' );
        $this->assertIsNumeric( $iexAskPrice );
    }


}