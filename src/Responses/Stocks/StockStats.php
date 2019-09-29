<?php

namespace MichaelDrennen\IEXCloud\Responses\Stocks;


use MichaelDrennen\IEXCloud\Responses\IEXCloudResponse;

/**
 * Class StockStats
 * @package MichaelDrennen\IEXCloud\Responses
 */
class StockStats extends IEXCloudResponse {

    public $avg10Volume;
    public $avg30Volume;
    public $beta;
    public $companyName;
    public $day200MovingAvg;
    public $day30ChangePercent;
    public $day50MovingAvg;
    public $day5ChangePercent;
    public $dividendYield;
    public $employees;
    public $exDividendDate;
    public $float;
    public $marketcap;
    public $maxChangePercent;
    public $month1ChangePercent;
    public $month3ChangePercent;
    public $month6ChangePercent;
    public $nextDividendDate;
    public $nextEarningsDate;
    public $peRatio;
    public $sharesOutstanding;
    public $ttmDividendRate;
    public $ttmEPS;
    public $week52change;
    public $week52high;
    public $week52low;
    public $year1ChangePercent;
    public $year2ChangePercent;
    public $year5ChangePercent;
    public $ytdChangePercent;


    /**
     * StockStats constructor.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     */
    public function __construct( $response ) {
        $jsonString                = (string)$response->getBody();
        $a                         = \GuzzleHttp\json_decode( $jsonString, TRUE );
        $this->avg10Volume         = $a[ 'avg10Volume' ] ?? NULL;
        $this->avg30Volume         = $a[ 'avg30Volume' ] ?? NULL;
        $this->beta                = $a[ 'beta' ] ?? NULL;
        $this->companyName         = $a[ 'companyName' ] ?? NULL;
        $this->day200MovingAvg     = $a[ 'day200MovingAvg' ] ?? NULL;
        $this->day30ChangePercent  = $a[ 'day30ChangePercent' ] ?? NULL;
        $this->day50MovingAvg      = $a[ 'day50MovingAvg' ] ?? NULL;
        $this->day5ChangePercent   = $a[ 'day5ChangePercent' ] ?? NULL;
        $this->dividendYield       = $a[ 'dividendYield' ] ?? NULL;
        $this->employees           = $a[ 'employees' ] ?? NULL;
        $this->exDividendDate      = $a[ 'exDividendDate' ] ?? NULL;
        $this->float               = $a[ 'float' ] ?? NULL;
        $this->marketcap           = $a[ 'marketcap' ] ?? NULL;
        $this->maxChangePercent    = $a[ 'maxChangePercent' ] ?? NULL;
        $this->month1ChangePercent = $a[ 'month1ChangePercent' ] ?? NULL;
        $this->month3ChangePercent = $a[ 'month3ChangePercent' ] ?? NULL;
        $this->month6ChangePercent = $a[ 'month6ChangePercent' ] ?? NULL;
        $this->nextDividendDate    = $a[ 'nextDividendDate' ] ?? NULL;
        $this->nextEarningsDate    = $a[ 'nextEarningsDate' ] ?? NULL;
        $this->peRatio             = $a[ 'peRatio' ] ?? NULL;
        $this->sharesOutstanding   = $a[ 'sharesOutstanding' ] ?? NULL;
        $this->ttmDividendRate     = $a[ 'ttmDividendRate' ] ?? NULL;
        $this->ttmEPS              = $a[ 'ttmEPS' ] ?? NULL;
        $this->week52change        = $a[ 'week52change' ] ?? NULL;
        $this->week52high          = $a[ 'week52high' ] ?? NULL;
        $this->week52low           = $a[ 'week52low' ] ?? NULL;
        $this->year1ChangePercent  = $a[ 'year1ChangePercent' ] ?? NULL;
        $this->year2ChangePercent  = $a[ 'year2ChangePercent' ] ?? NULL;
        $this->year5ChangePercent  = $a[ 'year5ChangePercent' ] ?? NULL;
        $this->ytdChangePercent    = $a[ 'ytdChangePercent' ] ?? NULL;
    }

}