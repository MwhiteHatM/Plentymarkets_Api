<?php

@include_once 'OrdersRepository.php';

class Orders {

    private $Username;
    private $Password;
    private $AccessToken;
    private $RefreshToken;
    private $Uri;
    public $response;

    public function __construct() {
        // username and password * user must be admin to get Orders
        $this->Username = "Your_username";
        $this->Password = "Your_password";
        // put here your REST-API HTTP Endpunkt -> from your Plentymarkets-settings
        $this->Uri = "Your_REST-API HTTP Endpunkt"; 
    }

    private function SetAccessToken() {
        
        // Build a post request to login 
        $response = \Httpful\Request::post($this->Uri . "login")                  
                ->sendsJson()                               // tell it we're sending (Content-Type) JSON...
                //->authenticateWith('testApi', 'Toor.123')  // if you authenticate with basic auth use this
                // you can also basic authenticate with json data in request body
                ->body('{"username": "' . $this->Username . '","password": "' . $this->Password . '"}')
                ->send();
        $this->AccessToken = $response->body->access_token;
        $this->RefreshToken = $response->body->refresh_token;
    }

    public function GetAccessToken() {
        $this->SetAccessToken();
        return $this->AccessToken;
    }

    public function GetAllOrdersFromPM() {
        // we make here http request with get method and OAuth0 v2 -> AccessToken
        $response = \Httpful\Request::get($this->Uri . "orders?with[]=addresses&with[]=orderItems.variation")
                ->sendsJson()
                ->addHeaders(array(
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer  ' . $this->AccessToken
                ))
                ->send();
        
        $this->response = $response;
    }

}

$orders = new Orders();
$orders->GetAccessToken();
$orders->GetAllOrdersFromPM();
?>