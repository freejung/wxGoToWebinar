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
 * gtwAttendanceData snippet - flexible all-purpose snippet for retrieving attendance data
 * @package webinex
 * @subpackage snippets
 */

$prospectId = $modx->getOption('prospectId',$scriptProperties,0);
$presentationId = $modx->getOption('presentationId',$scriptProperties,0);
$getWebinarData = $modx->getOption('getWebinarData',$scriptProperties,0);
$tpl = $modx->getOption('tpl',$scriptProperties,'');
$registrantTpl = $modx->getOption('registrantTpl',$scriptProperties,'');
$getQuestions = $modx->getOption('getQuestions',$scriptProperties,0);
$questionTpl = $modx->getOption('questionTpl',$scriptProperties,'');
$answerTpl = $modx->getOption('answerTpl',$scriptProperties,'');
$getSurveys = $modx->getOption('getSurveys',$scriptProperties,0);
$surveyTpl = $modx->getOption('surveyTpl',$scriptProperties,'');
$default = $modx->getOption('default',$scriptProperties,'');


$output = '';
$registered = 0;
if($prospectId) {
    $gtw = $modx->getService('wxgotowebinar','wxGoToWebinar',$modx->getOption('wxgotowebinar.core_path',null,$modx->getOption('core_path').'components/wxgotowebinar/').'model/wxgotowebinar/');
    if (!($gtw instanceof wxGoToWebinar)) return 'could not instantiate wxGoToWebinar';
    
    $webinex = $modx->getService('webinex','Webinex',$modx->getOption('webinex.core_path',null,$modx->getOption('core_path').'components/webinex/').'model/webinex/',$scriptProperties);
    if (!($webinex instanceof Webinex)) return 'could not instantiate Webinex';
    if($prospect = $modx->getObject('wxProspect',$prospectId)){
    	if($getWebinarData) {
    		if($presentation = $modx->getObject('wxPresentation',$presentationId)) {
    			$presentationArray = $presentation->toFullArray();
    		}
    	}
        if($registrations = $prospect->getMany('Registration',array('presentation' => $presentationId))){
            $registered = 1;
            foreach ($registrations as $registration) {
                if($registrants = $modx->getCollection('wxGtwRegistrant', array('wxregistration' => $registration->id))) {
                    $registrantText = '';
                    foreach($registrants as $registrant) {
                        $questionsText = '';
                        if($getQuestions) {
                            if($questions = $registrant->getMany('Question')) {
                                foreach($questions as $question) {
                                    $answerText = '';
                                    if($answers = $question->getMany('Answer')){
                                        foreach ($answers as $answer) {
                                            $answerArray = $answer->toArray();
                                            if($thisAnswer = $modx->getChunk($answerTpl, $answerArray)){
                                                $answerText .= $thisAnswer;
                                            }
                                        }
                                    }
                                    $questionArray = $question->toArray();
                                    $questionArray['answers'] = $answerText;
                                    if($thisQuestion = $modx->getChunk($questionTpl, $questionArray)){
                                        $questionsText .= $thisQuestion;
                                    }
                                }
                            }
                        }
                        $surveysText = '';
                        if($getSurveys) {
                            if($pollAnswers = $registrant->getMany('PollAnswer')) {
                                foreach($pollAnswers as $pollAnswer) {
                                    $response = $pollAnswer->getOne('Response');
                                    $poll = $response->getOne('Poll');
                                    $pollArray = $poll->toArray();
                                    $pollArray['response'] = $response->get('text');
                                    if($thisSurvey = $modx->getChunk($surveyTpl, $pollArray)){
                                        $surveysText .= $thisSurvey;
                                    }
                                }
                            }
                        }
                        $registrantArray = $registrant->toArray();
                        $registrantArray['questions'] = $questionsText;
                        $registrantArray['surveys'] = $surveysText;
                        $registrantArray['attendanceTimeInMinutes'] = round($registrantArray['attendanceTimeInSeconds']/60);
                        $hours = floor($registrantArray['attendanceTimeInSeconds'] / (60 * 60));
                        $divisor_for_minutes = $registrantArray['attendanceTimeInSeconds'] % (60 * 60);
                        $minutes = floor($divisor_for_minutes / 60);
                        $divisor_for_seconds = $divisor_for_minutes % 60;
                        $seconds = ceil($divisor_for_seconds);
                        $registrantArray['attendanceHours'] = $hours;
                        $registrantArray['attendanceMinutes'] = $minutes;
                        $registrantArray['attendanceSeconds'] = $seconds;
                        if($getWebinarData) $registrantArray = array_merge($presentationArray, $registrantArray);
                        if($thisRegistrant = $modx->getChunk($registrantTpl, $registrantArray)){
                            $registrantText .= $thisRegistrant;
                        }
                    }
                }
            }
        }
        $outputArray = array('registered' => $registered, 'registrantText' => $registrantText, 'presentationId' => $presentationId, 'default' => $default);
        if($getWebinarData) $outputArray = array_merge($presentationArray, $outputArray);
        $output = $modx->getChunk($tpl, $outputArray);
    }
}else{
    $output = $default;
}
return $output;