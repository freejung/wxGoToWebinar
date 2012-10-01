<?php
/**
 * wxGoToWebinar
 *
 * Copyright 2012 by Eli Snyder <freejung@gmail.com>
 *
 * wxGoToWebinar is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * wxGoToWebinar is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * wxGoToWebinar; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package wxgotowebinar
 */
/**
 * The base class for wxGoToWebinar.
 *
 * @package wxgotowebinar
 */
class wxGoToWebinar {
    /** @var \modX $modx */
    public $modx;
    /** @var array $config */
    public $config = array();
    /** @var wxGTW $gtw */
    protected $gtw;

    function __construct(modX &$modx,array $config = array()) {
        $this->modx =& $modx;
        $corePath = $this->modx->getOption('wxgotowebinar.core_path',$config,$this->modx->getOption('core_path').'components/wxgotowebinar/');
        $assetsUrl = $this->modx->getOption('wxgotowebinar.assets_url',$config,$this->modx->getOption('assets_url').'components/wxgotowebinar/');
        $connectorUrl = $assetsUrl.'connector.php';
        $this->config = array_merge(array(
            'assetsUrl' => $assetsUrl,
            'cssUrl' => $assetsUrl.'css/',
            'jsUrl' => $assetsUrl.'js/',
            'imagesUrl' => $assetsUrl.'images/',
            'connectorUrl' => $connectorUrl,
            'corePath' => $corePath,
            'modelPath' => $corePath.'model/',
            'chunksPath' => $corePath.'elements/chunks/',
            'chunkSuffix' => '.chunk.tpl',
            'snippetsPath' => $corePath.'elements/snippets/',
            'processorsPath' => $corePath.'processors/',
            'templatesPath' => $corePath.'templates/',
        ),$config);

        $this->modx->addPackage('wxgotowebinar',$this->config['modelPath']);
        $this->modx->lexicon->load('wxgotowebinar:default');
        //Instantiate a new client for the GoToWebinar REST API
        $this->gtw = new wxGTW(array('your_app' => array(
        	'developerKey' => $this->modx->getOption('wxgotowebinar.developer_key',$config,''),
        	'oauthToken' => $this->modx->getOption('wxgotowebinar.oauth_token',$config,''),
        	'organizerKey' => $this->modx->getOption('wxgotowebinar.organizer_key',$config,''),
        )));	
    }
    /*
    * @param wxRegistration $registration
    */
    public function register ($registration) {
    	$prospect = $registration->getOne('wxProspect');
    	$profile = $prospect->getOne('Profile');
    	$registrant = new wxGtwRegistrant();
    	$presentation = $registration->getOne('wxPresentation');
    	$webinarKey = $presentation->get('gtwid');
    	$email = $profile->get('email');
    	$fullname = $profile->get('fullname')
    	$firstname = substr($fullname, 0, strpos($fullname, ' ')-1);
    	$lastname = substr($fullname, strpos($fullname, ' '));
    	$registrant->addOne($registration);
    	$response = '';
    	try
    	{
    	$response = $this->gtw->createRegistrant($webinarKey, $email, $firstname, $lastname); 
    	}
    	catch (Exception $e)
        {
        $this->modx->log(modX::LOG_LEVEL_ERROR, 'wxGTW error: '.$e->getMessage());
        }
    	$registrant->fromJSON($response);
    	$registration->set('reg', $registrant->get('joinUrl'));
    	return $registrant->save();
    }
    
    /*
    * @param wxPresentation $presentation
    */
    public function getAttendance ($presentation) {
    	$webinarKey = $presentation->get('gtwid');
    	$response = '';
    	//get all sessions for the current webinar presentation
    	try
    	{
    	$response = $this->gtw->getWebinarSessions($webinarKey); 
    	}
    	catch (Exception $e)
        {
        $this->modx->log(modX::LOG_LEVEL_ERROR, 'wxGTW error: '.$e->getMessage());
        }
        $sessionArray = $this->modx->fromJSON($response);
        foreach ($sessionArray as $sessionData) {
        	//convert times to mySQL time format
        	$sessionData['startTime'] = date( 'Y-m-d H:i:s',strtotime($sessionData['startTime']));
        	$sessionData['endTime'] = date( 'Y-m-d H:i:s',strtotime($sessionData['endTime']));
        	//instantiate a new wxGtwSession object, set basic properties and save
        	$session = new wxGtwSession;
        	$session->fromArray($sessionData);
        	$session->save();
        	//get session performance data and record it
        	try
	    	{
	    	$response = $this->gtw->getSessionPerformance($webinarKey, $sessionData['sessionKey']); 
	    	}
	    	catch (Exception $e)
	        {
	        $this->modx->log(modX::LOG_LEVEL_ERROR, 'wxGTW error: '.$e->getMessage());
	        }
	        $performance = $this->modx->fromJSON($response);
	        $session->fromArray($performance['attendance']);
	        $session->fromArray($performance['pollsAndSurveys']);
	        $session->save();
	        //get poll and survey questions and add them to the session
	        try
	    	{
	    	$response = $this->gtw->getSessionPolls($webinarKey, $sessionData['sessionKey']); 
	    	}
	    	catch (Exception $e)
	        {
	        $this->modx->log(modX::LOG_LEVEL_ERROR, 'wxGTW error: '.$e->getMessage());
	        }
	        $sessionPolls = $this->modx->fromJSON($response);
	        $session->pollSetup($sessionPolls, 'poll');
	        try
	    	{
	    	$response = $this->gtw->getSessionSurveys($webinarKey, $sessionData['sessionKey']); 
	    	}
	    	catch (Exception $e)
	        {
	        $this->modx->log(modX::LOG_LEVEL_ERROR, 'wxGTW error: '.$e->getMessage());
	        }
	        $sessionSurveys = $this->modx->fromJSON($response);
	        $session->pollSetup($sessionSurveys, 'survey');
	        //get session attendance data
        	try
	    	{
	    	$response = $this->gtw->getSessionAttendees($webinarKey, $sessionData['sessionKey']); 
	    	}
	    	catch (Exception $e)
	        {
	        $this->modx->log(modX::LOG_LEVEL_ERROR, 'wxGTW error: '.$e->getMessage());
	        }
	        $attArray = $this->modx->fromJSON($response);
	        foreach ($attArray as $att) {
	        	//record attendance for registrants who attended
	        	if($att['attendanceTimeInSeconds']) {
		        	if($registrant = $this->modx->getObject('wxGtwRegistrant', array('registrantKey' => $att['registrantKey']))) {
		        		$registrant->set('attendanceTimeInSeconds', $att['attendanceTimeInSeconds']);
		        		$registrant->addOne($session);
		        		$registrant->save();
		        		//record poll and survey answers for attendees
		        		try
				    	{
				    	$response = $this->gtw->getAttendeePollAnswers($webinarKey, $sessionData['sessionKey'], $att['registrantKey']); 
				    	}
				    	catch (Exception $e)
				        {
				        $this->modx->log(modX::LOG_LEVEL_ERROR, 'wxGTW error: '.$e->getMessage());
				        }
				        $pollAnswers = $this->modx->fromJSON($response);
				        $registrant->addPollAnswers($pollAnswers, $session->id);
				        try
				    	{
				    	$response = $this->gtw->getAttendeeSurveyAnswers($webinarKey, $sessionData['sessionKey'], $att['registrantKey']); 
				    	}
				    	catch (Exception $e)
				        {
				        $this->modx->log(modX::LOG_LEVEL_ERROR, 'wxGTW error: '.$e->getMessage());
				        }
				        $surveyAnswers = $this->modx->fromJSON($response);
				        $registrant->addPollAnswers($surveyAnswers, $session->id);
		        		$registrant->save();
		        	}
	        	}
	        }
	        //get session questions and associate them with registrants
	        try
	    	{
	    	$response = $this->gtw->getSessionQuestions($webinarKey, $sessionData['sessionKey']); 
	    	}
	    	catch (Exception $e)
	        {
	        $this->modx->log(modX::LOG_LEVEL_ERROR, 'wxGTW error: '.$e->getMessage());
	        }
	        $sessionQuestions = $this->modx->fromJSON($response);
	        $session->addQuestions($sessionQuestions);
        }
    }
    
}
