<?php

namespace MichaelDrennen\IEXCloud\Tests;

use MichaelDrennen\IEXCloud\Exceptions\UnknownSymbol;
use MichaelDrennen\IEXCloud\Responses\Stocks\Company;
use MichaelDrennen\IEXCloud\Responses\Stocks\HistoricalPrice;
use MichaelDrennen\IEXCloud\Responses\Stocks\HistoricalPrices;
use MichaelDrennen\IEXCloud\Responses\Stocks\Quote;


class IEXCloudStockCompanyTest extends IEXCloudTestBaseTestCase {


    /**
     * @test
     * @group company
     */
    public function stockCompanyShouldReturnQuote() {
        $iexCloud = $this->getIEXCloudSandboxedStableInstance();
        $company  = $iexCloud->company( 'AAPL' );

        $this->assertInstanceOf( Company::class, $company );
        $this->assertNotEmpty( $company->symbol );
    }


}