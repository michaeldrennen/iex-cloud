<?php

namespace MichaelDrennen\IEXCloud\Traits\Stocks;


use MichaelDrennen\IEXCloud\Responses\Stocks\Company;
use MichaelDrennen\IEXCloud\Traits\BaseTrait;

trait CompanyTrait {

    use BaseTrait;


    public function company( string $symbol ): Company {
        $uri      = '/stock/' . $symbol . '/company';
        $response = $this->makeRequest( 'GET', $uri, FALSE );
        return new Company( $response );
    }




}
