<?php

namespace MichaelDrennen\IEXCloud;

use MichaelDrennen\IEXCloud\Traits\AccountTrait;
use MichaelDrennen\IEXCloud\Traits\BaseTrait;
use MichaelDrennen\IEXCloud\Traits\Stocks\HistoricalPricesTrait;
use MichaelDrennen\IEXCloud\Traits\Stocks\KeyStatsTrait;

class IEXCloud {

    use BaseTrait;
    use AccountTrait;
    use KeyStatsTrait;
    use HistoricalPricesTrait;

}