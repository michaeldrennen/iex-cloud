<?php

namespace MichaelDrennen\IEXCloud\Tests;

use MichaelDrennen\IEXCloud\IEXCloud;
use PHPUnit\Framework\TestCase;

class IEXCloudTestBaseTestCase extends TestCase {


    protected function getIEXCloudSandboxedStableInstance(): IEXCloud {
        return new IEXCloud( getenv( 'IEX_CLOUD_PUBLISHABLE_TOKEN' ),
                             getenv( 'IEX_CLOUD_SECRET_TOKEN' ),
                             TRUE,
                             FALSE,
                             'stable' );
    }


}