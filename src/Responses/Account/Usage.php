<?php

namespace MichaelDrennen\IEXCloud\Responses\Account;

use MichaelDrennen\IEXCloud\Responses\IEXCloudResponse;

/**
 * Class AccountMetadata
 * @package MichaelDrennen\IEXCloud\Responses
 */
class Usage extends IEXCloudResponse {

    public $monthlyUsage;
    public $monthlyPayAsYouGo;
    public $dailyUsage;
    public $tokenUsage;
    public $keyUsage;

    public function __construct( $response ) {
        $jsonString = (string)$response->getBody();
        $a          = \GuzzleHttp\json_decode( $jsonString, TRUE );

        $a                       = $a[ 'messages' ]; // Kludge because of how this request is formatted.
        $this->monthlyUsage      = $a[ 'monthlyUsage' ] ?? NULL;
        $this->monthlyPayAsYouGo = $a[ 'monthlyPayAsYouGo' ] ?? NULL;
        $this->dailyUsage        = $a[ 'dailyUsage' ] ?? [];
        $this->tokenUsage        = $a[ 'tokenUsage' ] ?? [];
        $this->keyUsage          = $a[ 'keyUsage' ] ?? [];
        $this->monthlyUsage      = $a[ 'monthlyUsage' ] ?? NULL;
        $this->monthlyPayAsYouGo = $a[ 'monthlyPayAsYouGo' ] ?? NULL;
    }

}