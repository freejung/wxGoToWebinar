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
    	$registrant->save();
    	$registration->set('reg', $registrant->get('joinurl'));
    	$registration->save();
    }
}