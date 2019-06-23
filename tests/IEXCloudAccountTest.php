<?php

namespace MichaelDrennen\IEXCloud\Tests;

use MichaelDrennen\IEXCloud\Responses\Account\Metadata;
use MichaelDrennen\IEXCloud\Responses\Account\Usage;


class IEXCloudAccountTest extends IEXCloudTestBaseTestCase {


    /**
     * @test
     */
    public function requestForAccountMetadataShouldReturnObjectWithData() {
        $iexCloud = $this->getIEXCloudSandboxedStableInstance();
        $object   = $iexCloud->accountMetadata();
        $this->assertInstanceOf( Metadata::class, $object );
        $this->assertIsNumeric( $object->effectiveDate );
    }


    /**
     * @test
     */
    public function requestForAccountUsageShouldReturnObjectWithData() {
        $iexCloud = $this->getIEXCloudSandboxedStableInstance();
        $object   = $iexCloud->accountUsage();

        print_r($object);
        $this->assertInstanceOf( Usage::class, $object );
        $this->assertIsNumeric( $object->monthlyUsage );
    }


}