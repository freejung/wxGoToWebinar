<?php
/**
 * Webinex
 *
 * Copyright 2012 by Eli Snyder <freejung@gmail.com>
 *
 * Webinex is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * Webinex is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * Webinex; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package webinex
 */
/**
 * Register hook snippet - register user for a webinar
 * @package webinex
 * @subpackage snippets
 */
 
$gtw = $modx->getService('wxgotowebinar','wxGoToWebinar',$modx->getOption('wxgotowebinar.core_path',null,$modx->getOption('core_path').'components/wxgotowebinar/').'model/wxgotowebinar/');
if (!($gtw instanceof wxGoToWebinar)) return 'could not instantiate wxGoToWebinar'; 
 
$webinex = $modx->getService('webinex','Webinex',$modx->getOption('webinex.core_path',null,$modx->getOption('core_path').'components/webinex/').'model/webinex/',$scriptProperties);
if (!($webinex instanceof Webinex)) return 'Error: could not instantiate Webinex';

$join = 0;
$email = '';

if(filter_has_var(INPUT_GET, 'jn')){
	if(filter_input(INPUT_GET, 'jn', FILTER_VALIDATE_INT)) {
	    $join = $_GET['jn'];
    }
}

if(filter_has_var(INPUT_GET, 'em')){
	if(filter_input(INPUT_GET, 'em', FILTER_VALIDATE_EMAIL)) {
	    $email = $_GET['em'];
    }
}

$resource = $modx->resource;

if($join) {
	//echo('join true<br>');
	if($webinar = $modx->getObject('wxWebinar', $resource->id)) {
		if($presentation = $webinar->primaryPresentation()) {
			if($presentation->get('recording')) return '';
			if($email) {
				if($prospect = $modx->getObject('wxProspect', array('username' => $email))) {
					//echo('<br><br>prospect id ='.$prospect->get('id'));
					$c = $modx->newQuery('wxRegistration');
					//echo('<br>presentation id='.$presentation->get('id'));
					$whereArray = array('prospect' => $prospect->get('id'), 'presentation' => $presentation->get('id'));
					$c->where($whereArray);
					if($registrations = $modx->getCollection('wxRegistration', $c)) {
						$joinUrl = '';
						foreach($registrations as $registration) {
							if ($registrant = $modx->getObject('wxGtwRegistrant', array('wxregistration' => $registration->id)) {
								$joinUrl = $registrant->get('joinUrl');
							}
						}
						if(!empty($joinUrl)) {
							//echo($joinUrl);
							$modx->sendRedirect($joinUrl);
						}
					}
				}
			}
			if($joinUrl = $presentation->get('joinurl')) {
				//echo('default join url='.$joinUrl);
				$modx->sendRedirect($joinUrl);
			}
		}
	}
}

return '';