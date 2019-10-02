<?php

namespace MichaelDrennen\IEXCloud\Responses\IEX;

class LastTrade {

    /**
     * @var string $symbol The ticker of the stock that was traded.
     */
    public $symbol; // Ex: SNAP

    /**
     * @var float $price The price of the last sale of this stock through IEX
     */
    public $price;  // Ex: 111.76

    /**
     * @var int $size The number of shares that were sold in this trade.
     */
    public $size;   // Ex: 5

    /**
     * @var int $time The unix timestamp of this sale.
     */
    public $time;   // Ex: 1480446905681


    /**
     * LastTrade constructor.
     * @param string $symbol
     * @param float $price
     * @param int $size
     * @param int $time
     */
    public function __construct( string $symbol, float $price, int $size, int $time ) {
        $this->symbol = $symbol;
        $this->price  = $price;
        $this->size   = $size;
        $this->time   = $time;
    }

}