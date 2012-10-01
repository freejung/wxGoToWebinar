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
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_TIMEOUT, '10');
        $headers = array(
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: OAuth oauth_token='.$this->oauthToken,
                'Content-Length: '.strlen($data_string)
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
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: OAuth oauth_token=.'$this->oauthToken
            );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
        return curl_exec($ch);
    }
}

class wxGTW {
    
    private $developerKey;
    private $organizerKey;
    private $organizerBaseUrl;
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
        $this->organizerBaseUrl = 'https://api.citrixonline.com/G2W/rest/organizers/'.$this->organizerKey;
        $this->client = new gtwApiClient($this->apps[$app]['oauthToken']);
    }

    /** Registrants **/

    public function createRegistrant($webinarKey, $email, $firstname, $lastname) {
        $url = $this->organizerBaseUrl.'/webinars/'.$webinarKey.'/registrants';
        $data = (object) array(
            'firstName' => $firstname,
            'lastName' => $lastname,
            'email' => $email
        );
        return $this->client->post($url, $data);
    }

    public function getRegistrant($webinarKey, $registrantKey) {
        return $this->client->get($this->organizerBaseUrl.'/webinars/'.$webinarKey.'/registrants/'.$registrantKey);
    }
    
    public function getRegistrants($webinarKey) {
        return $this->client->get($this->organizerBaseUrl.'/webinars/'.$webinarKey.'/registrants');
    }
    
    public function registrationFields($webinarKey) {
        return $this->client->get($this->organizerBaseUrl.'/webinars/'.$webinarKey.'/registrants/fields');
    }
    
    /** Attendees **/
    
    public function getAttendee($webinarKey, $sessionKey, $registrantKey) {
        return $this->client->get($this->organizerBaseUrl.'/webinars/'.$webinarKey.'/sessions/'.$sessionKey.'/attendees/'.$registrantKey);
    }
    
    public function getAttendeePollAnswers($webinarKey, $sessionKey, $registrantKey) {
        return $this->client->get($this->organizerBaseUrl.'/webinars/'.$webinarKey.'/sessions/'.$sessionKey.'/attendees/'.$registrantKey.'/polls');
    }
    
    public function getAttendeeQuestions($webinarKey, $sessionKey, $registrantKey) {
        return $this->client->get($this->organizerBaseUrl.'/webinars/'.$webinarKey.'/sessions/'.$sessionKey.'/attendees/'.$registrantKey.'/questions');
    }
    
    public function getAttendeeSurveyAnswers($webinarKey, $sessionKey, $registrantKey) {
        return $this->client->get($this->organizerBaseUrl.'/webinars/'.$webinarKey.'/sessions/'.$sessionKey.'/attendees/'.$registrantKey.'/surveys');
    }
    
    public function getAttendeesForAllWebinarSessions($webinarKey, $sessionKey, $registrantKey) {
        return $this->client->get($this->organizerBaseUrl.'/webinars/'.$webinarKey.'/attendees');
    }

    /** Webinars **/

    public function getHistoricalWebinars() {
        return $this->client->get($this->organizerBaseUrl.'/historicalWebinars');
    }

    public function getUpcomingWebinars() {
        return $this->client->get($this->organizerBaseUrl.'/upcomingWebinars');
    }
    
    public function getWebinar($webinarKey) {
        return $this->client->get($this->organizerBaseUrl.'/webinars/'.$webinarKey);
    }
    
    public function getWebinarMeetingTimes($webinarKey) {
        return $this->client->get($this->organizerBaseUrl.'/webinars/'.$webinarKey.'/meetingTimes');
    }
    
    /** Sessions **/
    
    public function getOrganizerSessions() {
        return $this->client->get($this->organizerBaseUrl.'/sessions');
    }
    
    public function getSession($webinarKey, $sessionKey) {
        return $this->client->get($this->organizerBaseUrl.'/webinars/'.$webinarKey.'/sessions/'.$sessionKey);
    }
    
    public function getSessionAttendees($webinarKey, $sessionKey) {
        return $this->client->get($this->organizerBaseUrl.'/webinars/'.$webinarKey.'/sessions/'.$sessionKey.'/attendees');
    }
    
    public function getSessionPerformance($webinarKey, $sessionKey) {
        return $this->client->get($this->organizerBaseUrl.'/webinars/'.$webinarKey.'/sessions/'.$sessionKey.'/performance');
    }
    
    public function getSessionPolls($webinarKey, $sessionKey) {
        return $this->client->get($this->organizerBaseUrl.'/webinars/'.$webinarKey.'/sessions/'.$sessionKey.'/polls');
    }
    
    public function getSessionQuestions($webinarKey, $sessionKey) {
        return $this->client->get($this->organizerBaseUrl.'/webinars/'.$webinarKey.'/sessions/'.$sessionKey.'/questions');
    }
    
    public function getSessionSurveys($webinarKey, $sessionKey) {
        return $this->client->get($this->organizerBaseUrl.'/webinars/'.$webinarKey.'/sessions/'.$sessionKey.'/surveys');
    }
    
    public function getWebinarSessions($webinarKey) {
        return $this->client->get($this->organizerBaseUrl.'/webinars/'.$webinarKey.'/sessions');
    }
    
}