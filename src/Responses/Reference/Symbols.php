<?php
namespace MichaelDrennen\IEXCloud\Responses\Reference;

use MichaelDrennen\IEXCloud\Responses\IEXCloudResponse;


/**
 * Class Symbols
 * @package MichaelDrennen\IEXCloud\Responses\Reference
 */
class Symbols extends IEXCloudResponse
{
    public $data;

    public function __construct( $response ) {
        $jsonString = (string)$response->getBody();
        $this->data = \GuzzleHttp\json_decode( $jsonString, TRUE );
    }
}