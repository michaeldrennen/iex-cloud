<?php

namespace MichaelDrennen\IEXCloud\Tests;

use MichaelDrennen\IEXCloud\Responses\Account\Metadata;
use MichaelDrennen\IEXCloud\Responses\Account\Usage;


class IEXCloudAccountTest extends IEXCloudTestBaseTestCase {


    /**
     * @test
     * @group account
     */
    public function requestForAccountMetadataShouldReturnObjectWithData() {
        $iexCloud = $this->getIEXCloudSandboxedStableInstance();
        $object   = $iexCloud->accountMetadata();
        $this->assertInstanceOf( Metadata::class, $object );
        $this->assertIsNumeric( $object->effectiveDate );
    }


    /**
     * @test
     * @group account
     */
    public function requestForAccountUsageShouldReturnObjectWithData() {
        $iexCloud = $this->getIEXCloudSandboxedStableInstance();
        $object   = $iexCloud->accountUsage();
        $this->assertInstanceOf( Usage::class, $object );
        $this->assertIsNumeric( $object->monthlyUsage );
    }


    /**
     * @skiptest
     * @group account
     * @group payg
     */
    public function enablePayAsYouGoShouldEnableIt() {
        $iexCloud = $this->getIEXCloudSandboxedStableInstance();
        try {
            $object = $iexCloud->payAsYouGo( TRUE );
        } catch ( \Exception $exception ) {
            echo $exception->getTraceAsString();
            echo $exception->getMessage();
        }


    }


}