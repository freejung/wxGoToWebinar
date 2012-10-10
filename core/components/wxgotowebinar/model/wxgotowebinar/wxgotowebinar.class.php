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
 
require_once 'wxGoToWebinarAPI.php'; 

class wxGoToWebinar {
    /** @var \modX $modx */
    public $modx;
    /** @var array $config */
    public $config = array();
    /** @var wxGTW $gtwAPI */
    public $gtwAPI;

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
        
        $this->gtwAPI = new wxGTW($this->modx->getOption('wxgotowebinar.developer_key',$config,''), $this->modx->getOption('wxgotowebinar.organizer_key',$config,''), $this->modx->getOption('wxgotowebinar.oauth_token',$config,''));    
        
    }
    /*
    * @param array of wxRegistration $registrations
    */
    
    public function register ($registrations) {
    	foreach ($registrations as $registration) {
    		if(!$registrant = $this->modx->getObject('wxGtwRegistrant', array('wxregistration' => $registration->id))) { 
	    		$presentation = $registration->getOne('Presentation');
	    		$webinarKey = str_replace('-', '', $presentation->get('gtwid'));
	    		$prospect = $registration->getOne('Prospect');
		        $profile = $prospect->getOne('Profile');
		        $registrant = $this->modx->newObject('wxGtwRegistrant');
		        $email = $profile->get('email');
		        $fullname = $profile->get('fullname');
		        $firstname = substr($fullname, 0, strpos($fullname, ' '));
		        $lastname = substr($fullname, strpos($fullname, ' '));
		        $registrant->addOne($registration);
		        $response = '';
		        try
		        {
		        $response = $this->gtwAPI->createRegistrant($webinarKey, $email, $firstname, $lastname); 
		        }
		        catch (Exception $e)
		        {
		        $this->modx->log(modX::LOG_LEVEL_ERROR, 'wxGTW error: '.$e->getMessage());
		        }
		        $registrant->fromJSON($response);
				$registrant->save();
			}
        }
        return true;
    }
    
    /*
    * @param wxPresentation $presentation
    */
    public function getAttendance ($presentation) {
    	set_time_limit(86400);
        $webinarKey = str_replace('-', '', $presentation->get('gtwid'));
        $response = '';
        //get all sessions for the current webinar presentation
        try
        {
        $response = $this->gtwAPI->getWebinarSessions($webinarKey); 
        }
        catch (Exception $e)
        {
        $this->modx->log(modX::LOG_LEVEL_ERROR, 'wxGTW error: '.$e->getMessage());
        }
        $sessionArray = $this->modx->fromJSON($response);
        foreach ($sessionArray as $sessionData) {
            //get the session object for this session if it exists, otherwise make a new one
            if (!$session = $this->modx->getObject('wxGtwSession',array('sessionKey' => $sessionData['sessionKey']))) {
            	if(!$session = $this->modx->getObject('wxGtwSession', array('webinarKey' => $webinarKey, 'wxpresentation' => $presentation->id))) {
	    			$session = $this->modx->newObject('wxGtwSession');
	    			$session->addOne($presentation);
	    		}
	            $sessionData['startTime'] = date( 'Y-m-d H:i:s',strtotime($sessionData['startTime']));
	            $sessionData['endTime'] = date( 'Y-m-d H:i:s',strtotime($sessionData['endTime']));
	            $session->fromArray($sessionData);
	            $session->save();
	            //get session performance data and record it
	            try
	            {
	            $response = $this->gtwAPI->getSessionPerformance($webinarKey, $sessionData['sessionKey']); 
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
	            $response = $this->gtwAPI->getSessionPolls($webinarKey, $sessionData['sessionKey']); 
	            }
	            catch (Exception $e)
	            {
	            $this->modx->log(modX::LOG_LEVEL_ERROR, 'wxGTW error: '.$e->getMessage());
	            }
	            $sessionPolls = $this->modx->fromJSON($response);
	            $session->pollSetup($sessionPolls, 'poll');
	            try
	            {
	            $response = $this->gtwAPI->getSessionSurveys($webinarKey, $sessionData['sessionKey']); 
	            }
	            catch (Exception $e)
	            {
	            $this->modx->log(modX::LOG_LEVEL_ERROR, 'wxGTW error: '.$e->getMessage());
	            }
	            $sessionSurveys = $this->modx->fromJSON($response);
	            $session->pollSetup($sessionSurveys, 'survey');
            }
            //get session attendance data
            try
            {
            $response = $this->gtwAPI->getSessionAttendees($webinarKey, $sessionData['sessionKey']); 
            }
            catch (Exception $e)
            {
            $this->modx->log(modX::LOG_LEVEL_ERROR, 'wxGTW error: '.$e->getMessage());
            }
            $attArray = $this->modx->fromJSON($response);
            foreach ($attArray as $att) {
                //record attendance for registrants who attended
                if($att['attendanceTimeInSeconds']) {
                	if(!$prospect = $this->modx->getObject('wxProspect', array('username' => $att['email']))) {
                		$prospect = $this->modx->newObject('wxProspect');
                		$prospect->standardSetup($att['email']);
                		$profile = $prospect->getOne('Profile');
                		$profile->set('fullname', $att['firstName'].' '.$att['lastName']);
                		$prospect->save();
                	}
                	if(!$registrations = $prospect->getMany('Registration', array('presentation' => $presentation->id))) {
                		$registrations = $prospect->registerFor(array($presentation));
                	}
					if(!$registrant = $this->modx->getObject('wxGtwRegistrant', array('registrantKey' => $att['registrantKey']))) {
                    	$registrant = $this->modx->newObject('wxGtwRegistrant');
                	}
                	if(!$registration = $registrant->getOne('Registration')) {
	                	foreach($registrations as $registration){
							$registrant->addOne($registration);
						}
					}
                    $registrant->fromArray($att);
                    $registrant->addOne($session);
                    $registrant->save();
                    //record poll and survey answers for attendees
                    try
                    {
                    $response = $this->gtwAPI->getAttendeePollAnswers($webinarKey, $sessionData['sessionKey'], $att['registrantKey']); 
                    }
                    catch (Exception $e)
                    {
                    $this->modx->log(modX::LOG_LEVEL_ERROR, 'wxGTW error: '.$e->getMessage());
                    }
                    $pollAnswers = $this->modx->fromJSON($response);
                    $registrant->addPollAnswers($pollAnswers, $session->id);
                    try
                    {
                    $response = $this->gtwAPI->getAttendeeSurveyAnswers($webinarKey, $sessionData['sessionKey'], $att['registrantKey']); 
                    }
                    catch (Exception $e)
                    {
                    $this->modx->log(modX::LOG_LEVEL_ERROR, 'wxGTW error: '.$e->getMessage());
                    }
                    $surveyAnswers = $this->modx->fromJSON($response);
                    $registrant->addPollAnswers($surveyAnswers, $session->id);
                }
            }
            //get session questions and associate them with registrants
            try
            {
            $response = $this->gtwAPI->getSessionQuestions($webinarKey, $sessionData['sessionKey']); 
            }
            catch (Exception $e)
            {
            $this->modx->log(modX::LOG_LEVEL_ERROR, 'wxGTW error: '.$e->getMessage());
            }
            $sessionQuestions = $this->modx->fromJSON($response);
            $session->addQuestions($sessionQuestions);
        }
        //record non-attendance for registrants who didn't attend, set registration field 'attended' according to attendance
        $allRegistrations = $this->modx->getIterator('wxRegistration', array('presentation' => $presentation->id));
        foreach ($allRegistrations as $registration) {
        	$attended = 0;
        	if ($registrants = $this->modx->getCollection('wxGtwRegistrant', array('wxregistration' => $registration->id))) {
        		foreach($registrants as $registrant) {
        			$attTime = $registrant->get('attendanceTimeInSeconds');
        			if (is_null($attTime)) {
        				$registrant->set('attendanceTimeInSeconds', 0);
        				$registrant->save();
        			}elseif($attTime > 0) {
        				$attended = 1;
        			}
        		}
        		$registration->set('attended',$attended);
        		$registration->save();
        	}
        }
        return true;
    }
    
    /*
    * Check whether complete attendance has already been recorded for this presentation
    * Returns false if no session, or if any registrant is missing attendance time
    *
    * @param wxPresentation $presentation
    */
    
    public function attendanceExists ($presentation) {
    	if(!$sessions = $this->modx->getCollection('wxGtwSession', array('wxpresentation' => $presentation->id))) return false;
    	foreach ($sessions as $session) {
    		$registrants = $this->modx->getMany('wxGtwRegistrant', array('wxgtwsession' => $session->id));
    		foreach ($registrants as $registrant) {
    			$attTime = $registrant->get('attendanceTimeInSeconds');
    			if (is_null($attTime)) return false;
    		}
    	}
    	return true;
    }
    
    /*
    * output attendance data from the database as a flat array
    *
    * @param wxPresentation $presentation
    */
    
    public function attendanceData ($presentation) {
    	$attData = array();
    	if(!$sessions = $this->modx->getCollection('wxGtwSession', array('wxpresentation' => $presentation->id))) return false;
    	foreach ($sessions as $session) {
    		$registrants = $this->modx->getCollection('wxGtwRegistrant', array('wxgtwsession' => $session->id));
    		foreach ($registrants as $registrant) {
    			$attData[$registrant->get('email')] = $registrant->toFlatArray();
    		}
    	}
    	return $attData;
    }
    
}
