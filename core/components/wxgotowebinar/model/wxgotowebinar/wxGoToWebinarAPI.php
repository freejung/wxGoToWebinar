<?php

class gtwApiClient {
    
    private $oauthToken;
    
    public function __construct($oauthToken) {
        $this->oauthToken = $oauthToken;
    }
    
    public function post($url, $data) {
        $data_string = json_encode($data);   
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_TIMEOUT, '10');
        $headers = array(
                "Content-Type: application/json",
                "Accept: application/json",
                "Authorization: OAuth oauth_token={$this->oauthToken}",
                "Content-Length: " . strlen($data_string)
            );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
        return = curl_exec($ch);
    }
    
    public function get($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, '10');
        $headers = array(
                "Content-Type: application/json",
                "Accept: application/json",
                "Authorization: OAuth oauth_token={$this->oauthToken}"
            );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
        return = curl_exec($ch);
    }
}

class gtwClient {
    
    private $developerKey;
    private $organizerKey;
    protected $client;
    
    private $apps = array(
        'your_app' => array(
            'developerKey' => '',
            'oauthToken' => '',
            'organizerKey' => '')
    );
    
    public function __construct($app = 'your_app') {
        if(!array_key_exists($app, $this->apps)) {
            throw new Exception('Invalid argument: unknown developer key');
        }
        $this->developerKey = $this->apps[$app]['developerKey'];
        $this->organizerKey = $this->apps[$app]['organizerKey'];
        $this->client = new ApiClient($this->apps[$app]['oauthToken']);
    }
    
    public function getUpcoming() {
        return $this->client->get("https://api.citrixonline.com/G2W/rest/organizers/{$this->organizerKey}/upcomingWebinars");
    }
    
    public function getHistorical() {
        return $this->client->get("https://api.citrixonline.com/G2W/rest/organizers/{$this->organizerKey}/historicalWebinars");
    }
    
    public function addRegistrant($webinarKey, $email, $firstname, $lastname) {
        $url = "https://api.citrixonline.com/G2W/rest/organizers/{$this->organizerKey}/webinars/{$webinarKey}/registrants";
        $data = (object) array(
            'firstName' => $firstname,
            'lastName' => $lastname,
            'email' => $email
        );
        return $this->client->post($url, $data);
    }
}