<?php

namespace MichaelDrennen\IEXCloud;

use MichaelDrennen\IEXCloud\Traits\AccountTrait;
use MichaelDrennen\IEXCloud\Traits\BaseTrait;
use MichaelDrennen\IEXCloud\Traits\Stocks\HistoricalPricesTrait;
use MichaelDrennen\IEXCloud\Traits\Stocks\KeyStatsTrait;

class IEXCloud {

    /**
     * IEXCloud constructor.
     * @param string $publishableToken
     * @param string $secretToken
     * @param bool $sandbox
     * @param bool $sse
     * @param string $version
     */
    public function __construct( string $publishableToken, string $secretToken, bool $sandbox = FALSE, bool $sse = FALSE, string $version = 'stable' ) {
        $this->publishableToken = $publishableToken;
        $this->secretToken      = $secretToken;
        $this->sandbox          = $sandbox;
        $this->sse              = $sse;
        $this->version          = $version;

        $this->setBaseURL();
        $this->setClient();
    }

    use BaseTrait;
    use AccountTrait;
    use KeyStatsTrait;
    use HistoricalPricesTrait;

}