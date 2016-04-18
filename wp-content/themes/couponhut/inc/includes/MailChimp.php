<?php
/**
 * Super-simple, minimum abstraction MailChimp API v2 wrapper
 * 
 * The modified version for WordPress using wp_remote_post
 * This probably has more comments than code.
 * 
 * @original link https://github.com/drewm/mailchimp-api/
 * @author Drew McLellan <drew.mclellan@gmail.com>
 * @author Barry Ceelen <b@rryceelen.com>
 */
class MailChimp
{
    private $api_key;
    private $api_endpoint = 'https://<dc>.api.mailchimp.com/2.0';
    private $verify_ssl   = false;

    /**
     * Create a new instance
     * @param string $api_key Your MailChimp API key
     */
    function __construct($api_key)
    {
        $this->api_key = $api_key;
        list(, $datacentre) = explode('-', $this->api_key);
        $this->api_endpoint = str_replace('<dc>', $datacentre, $this->api_endpoint);
    }

    /**
     * Call an API method. Every request needs the API key, so that is added automatically -- you don't need to pass it in.
     * @param  string $method The API method to call, e.g. 'lists/list'
     * @param  array  $args   An array of arguments to pass to the method. Will be json-encoded for you.
     * @return array          Associative array of json decoded API response.
     */
    public function call($method, $args=array())
    {
        return $this->_makeRequest($method, $args);
    }

    /**
     * Performs the underlying HTTP request. Not very exciting
     * @param  string $method The API method to be called
     * @param  array  $args   Assoc array of parameters to be passed
     * @return mixed
     */
    private function _makeRequest($method, $args=array())
    {      
        $args['apikey'] = $this->api_key;
        $args['body'] = json_encode( $args );
        $args['timeout'] = 10;
        $args['sslverify'] = $this->verify_ssl;
        $url = $this->api_endpoint.'/'.$method.'.json';
        $response = wp_remote_post( $url, $args );
        if( !is_wp_error( $response ) ){
            $result = wp_remote_retrieve_body( $response );
            return $result ? json_decode( $result ) : false;
        }
        else{
            return false;
        }
    }
}