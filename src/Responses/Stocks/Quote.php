<?php

namespace MichaelDrennen\IEXCloud\Responses\Stocks;


use MichaelDrennen\IEXCloud\Responses\IEXCloudResponse;


class Quote extends IEXCloudResponse {

    public $symbol;             // Ex: AAPL
    public $companyName;        // Ex: Apple Inc.
    public $calculationPrice; // Ex: tops
    public $open; // Ex: 154
    public $openTime; // Ex: 1506605400394
    public $close; // Ex: 153.28
    public $closeTime; // Ex: 1506605400394
    public $high; // Ex: 154.80
    public $low; // Ex: 153.25
    public $latestPrice; // Ex: 158.73
    public $latestSource; // Ex: Previous close
    public $latestTime; // Ex: September 19
    public $latestUpdate; // Ex: 1505779200000
    public $latestVolume; // Ex: 20567140
    public $volume; // Ex: 20567140
    public $iexRealtimePrice; // Ex: 158.71
    public $iexRealtimeSize; // Ex: 100
    public $iexLastUpdated; // Ex: 1505851198059
    public $delayedPrice; // Ex: 158.71
    public $delayedPriceTime; // Ex: 1505854782437
    public $extendedPrice; // Ex: 159.21
    public $extendedChange; // Ex: -1.68
    public $extendedChangePercent; // Ex: -0.0125
    public $extendedPriceTime; // Ex: 1527082200361
    public $previousClose; // Ex: 158.73
    public $previousVolume; // Ex: 22268140
    public $change; // Ex: -1.67
    public $changePercent; // Ex: -0.01158
    public $iexMarketPercent; // Ex: 0.00948
    public $iexVolume; // Ex: 82451
    public $avgTotalVolume; // Ex: 29623234
    public $iexBidPrice; // Ex: 153.01
    public $iexBidSize; // Ex: 100
    public $iexAskPrice;        // Ex: 158.66
    public $iexAskSize;         // Ex: 100
    public $marketCap; // Ex: 751627174400
    public $week52High; // Ex: 159.65
    public $week52Low; // Ex: 93.63
    public $ytdChange; // Ex: 0.3665
    public $peRatio; // Ex: 17.18
    public $lastTradeTime; // Ex: 1505779200000
    public $isUSMarketOpen; // Ex: FALSE


    /**
     * Quote constructor.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     */
    public function __construct( $response ) {
        $jsonString                  = (string)$response->getBody();
        $a                           = \GuzzleHttp\json_decode( $jsonString, TRUE );
        $this->symbol                = $a[ 'symbol' ] ?? NULL;
        $this->companyName           = $a[ 'companyName' ] ?? NULL;
        $this->calculationPrice      = $a[ 'calculationPrice' ] ?? NULL;
        $this->open                  = $a[ 'open' ] ?? NULL;
        $this->openTime              = $a[ 'openTime' ] ?? NULL;
        $this->close                 = $a[ 'close' ] ?? NULL;
        $this->closeTime             = $a[ 'closeTime' ] ?? NULL;
        $this->high                  = $a[ 'high' ] ?? NULL;
        $this->low                   = $a[ 'low' ] ?? NULL;
        $this->latestPrice           = $a[ 'latestPrice' ] ?? NULL;
        $this->latestSource          = $a[ 'latestSource' ] ?? NULL;
        $this->latestTime            = $a[ 'latestTime' ] ?? NULL;
        $this->latestUpdate          = $a[ 'latestUpdate' ] ?? NULL;
        $this->latestVolume          = $a[ 'latestVolume' ] ?? NULL;
        $this->volume                = $a[ 'volume' ] ?? NULL;
        $this->iexRealtimePrice      = $a[ 'iexRealtimePrice' ] ?? NULL;
        $this->iexRealtimeSize       = $a[ 'iexRealtimeSize' ] ?? NULL;
        $this->iexLastUpdated        = $a[ 'iexLastUpdated' ] ?? NULL;
        $this->delayedPrice          = $a[ 'delayedPrice' ] ?? NULL;
        $this->delayedPriceTime      = $a[ 'delayedPriceTime' ] ?? NULL;
        $this->extendedPrice         = $a[ 'extendedPrice' ] ?? NULL;
        $this->extendedChange        = $a[ 'extendedChange' ] ?? NULL;
        $this->extendedChangePercent = $a[ 'extendedChangePercent' ] ?? NULL;
        $this->extendedPriceTime     = $a[ 'extendedPriceTime' ] ?? NULL;
        $this->previousClose         = $a[ 'previousClose' ] ?? NULL;
        $this->previousVolume        = $a[ 'previousVolume' ] ?? NULL;
        $this->change                = $a[ 'change' ] ?? NULL;
        $this->changePercent         = $a[ 'changePercent' ] ?? NULL;
        $this->iexMarketPercent      = $a[ 'iexMarketPercent' ] ?? NULL;
        $this->iexVolume             = $a[ 'iexVolume' ] ?? NULL;
        $this->avgTotalVolume        = $a[ 'avgTotalVolume' ] ?? NULL;
        $this->iexBidPrice           = $a[ 'iexBidPrice' ] ?? NULL;
        $this->iexBidSize            = $a[ 'iexBidSize' ] ?? NULL;
        $this->iexAskPrice           = $a[ 'iexAskPrice' ] ?? NULL;
        $this->iexAskSize            = $a[ 'iexAskSize' ] ?? NULL;
        $this->marketCap             = $a[ 'marketCap' ] ?? NULL;
        $this->week52High            = $a[ 'week52High' ] ?? NULL;
        $this->week52Low             = $a[ 'week52Low' ] ?? NULL;
        $this->ytdChange             = $a[ 'ytdChange' ] ?? NULL;
        $this->peRatio               = $a[ 'peRatio' ] ?? NULL;
        $this->lastTradeTime         = $a[ 'lastTradeTime' ] ?? NULL;
        $this->isUSMarketOpen        = $a[ 'isUSMarketOpen' ] ?? NULL;

    }

}