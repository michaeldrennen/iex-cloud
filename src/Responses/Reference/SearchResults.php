<?php
namespace MichaelDrennen\IEXCloud\Responses\Reference;

use MichaelDrennen\IEXCloud\Responses\IEXCloudResponse;

/**
 * Class SearchResults
 * @package MichaelDrennen\IEXCloud\Responses\Reference
 */
class SearchResults extends IEXCloudResponse
{
    public $data;

    public function __construct( $response ) {
        $jsonString = (string)$response->getBody();
        $this->data = \GuzzleHttp\json_decode( $jsonString, TRUE );
    }
}