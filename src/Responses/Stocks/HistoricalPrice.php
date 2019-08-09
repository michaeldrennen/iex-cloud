<?php

namespace MichaelDrennen\IEXCloud\Responses\Stocks;

use MichaelDrennen\IEXCloud\Responses\IEXCloudResponse;


class HistoricalPrice extends IEXCloudResponse {


    /**
     * @var string    Formatted as YYYY-MM-DD
     */
    public $date;

    /**
     * @var float    Adjusted data for historical dates. Split adjusted only.
     */
    public $high;

    /**
     * @var float    Adjusted data for historical dates. Split adjusted only.
     */
    public $low;

    /**
     * @var int    Adjusted data for historical dates. Split adjusted only.
     */
    public $volume;

    /**
     * @var float    Adjusted data for historical dates. Split adjusted only.
     */
    public $open;

    /**
     * @var float    Adjusted data for historical dates. Split adjusted only.
     */
    public $close;

    /**
     * @var float    Unadjusted data for historical dates.
     */
    public $uHigh;

    /**
     * @var float    Unadjusted data for historical dates.
     */
    public $uLow;

    /**
     * @var int    Unadjusted data for historical dates.
     */
    public $uVolume;

    /**
     * @var float    Unadjusted data for historical dates.
     */
    public $uOpen;

    /**
     * @var float    Unadjusted data for historical dates.
     */
    public $uClose;

    /**
     * @var float    Percent change of each interval relative to first value. Useful for comparing multiple stocks.
     */
    public $changeOverTime;

    /**
     * @var string    A human readable format of the date depending on the range.
     */
    public $label;

    /**
     * @var float    Change from previous trading day.
     */
    public $change;

    /**
     * @var float    Change percent from previous trading day.
     */
    public $changePercent;

    public function __construct( array $a ) {


        $this->date           = $a[ 'date' ] ?? NULL;
        $this->high           = $a[ 'high' ] ?? NULL;
        $this->low            = $a[ 'low' ] ?? NULL;
        $this->volume         = $a[ 'volume' ] ?? NULL;
        $this->open           = $a[ 'open' ] ?? NULL;
        $this->close          = $a[ 'close' ] ?? NULL;
        $this->uHigh          = $a[ 'uHigh' ] ?? NULL;
        $this->uLow           = $a[ 'uLow' ] ?? NULL;
        $this->uVolume        = $a[ 'uVolume' ] ?? NULL;
        $this->uOpen          = $a[ 'uOpen' ] ?? NULL;
        $this->uClose         = $a[ 'uClose' ] ?? NULL;
        $this->changeOverTime = $a[ 'changeOverTime' ] ?? NULL;
        $this->label          = $a[ 'label' ] ?? NULL;
        $this->change         = $a[ 'change' ] ?? NULL;
        $this->changePercent  = $a[ 'changePercent' ] ?? NULL;
    }

}