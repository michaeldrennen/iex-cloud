<?php

namespace MichaelDrennen\IEXCloud;

use GuzzleHttp\Client;
use MichaelDrennen\IEXCloud\Traits\AccountTrait;
use MichaelDrennen\IEXCloud\Traits\BaseTrait;
use MichaelDrennen\IEXCloud\Traits\Stocks\HistoricalPricesTrait;
use MichaelDrennen\IEXCloud\Traits\Stocks\KeyStatsTrait;

class IEXCloud {

    use BaseTrait;
    use AccountTrait;
    use KeyStatsTrait;
    use HistoricalPricesTrait;

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

    /**
     * Sets the base URL to be used requests to IEX Cloud API endpoints.
     * @codeCoverageIgnore
     */
    protected function setBaseURL() {
        if ( $this->sandbox && $this->sse ):
            $this->baseURL = $this->SANDBOX_SSE_URL;
        elseif ( $this->sandbox ):
            $this->baseURL = $this->SANDBOX_URL;
        elseif ( $this->sse ):
            $this->baseURL = $this->PRODUCTION_SSE_URL;
        else:
            $this->baseURL = $this->PRODUCTION_URL;
        endif;
    }


    /**
     * Set up a GuzzleHttp Client with some default settings.
     */
    protected function setClient() {
        $this->client = new Client( [
                                        'verify'   => FALSE,
                                        'base_uri' => $this->baseURL,
                                    ] );
    }

    /**
     * IEX Cloud offers a bunch of options (like filtering results) that are passed as part of the query string.
     * @param array $options The existing $options array used by the Guzzle client. It gets added to and returned by this function.
     * @param array $additionalQueryParameters An array of name => value pairs that will get added to the query string sent to the server.
     * @return array The modified $options array to be used by the Guzzle client.
     */
    protected function setAdditionalQueryParameters( array $options, array $additionalQueryParameters = [] ): array {
        foreach ( $additionalQueryParameters as $key => $value ):
            $options[ 'query' ][ $key ] = $value;
        endforeach;

        return $options;
    }


    protected function setAdditionalFormParams( array $options, array $additionalFormParameters = [] ): array {
        foreach ( $additionalFormParameters as $key => $value ):
            $options[ 'form_params' ][ $key ] = $value;
        endforeach;

        return $options;
    }



}