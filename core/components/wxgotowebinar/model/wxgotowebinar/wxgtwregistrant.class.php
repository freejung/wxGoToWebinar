<?php
/**
 * @package wxgotowebinar
 */
class wxGtwRegistrant extends xPDOSimpleObject {
	
	/*
    * @param array $pollAnswers
    * @param int $sessionId
    */
    public function addPollAnswers ($pollAnswers = array(), $sessionId) {
    	$answersArray = array();
        foreach ($pollAnswers as $answerData) {
            if($poll = $this->xpdo->getObject('wxGtwPoll', array('question' => $answerData['question'], 'wxgtwsession' => $sessionId))) {
                if($response = $this->xpdo->getObject('wxGtwPollResponse',array('text' => $answerData['answer'], 'wxgtwpoll' => $poll->id))) {
                	if (!$this->getMany('PollAnswer', array('wxgtwpollresponse' => $response->id))) {
	                	$answer = $this->xpdo->newObject('wxGtwPollAnswer');
	                    $answer->addOne($response);
	                    $answer->save();
	                    $answersArray[] = $answer;
                    }
                }
            }
        }
        $this->addMany($answersArray);
        return $this->save();
    }
    
    /*
    * output a flat associative array containing data from the registrant and associated objects
    */
    
    public function toFlatArray () {
    	$registrantArray = array();
    	$sessionArray = array();
    	$registrationArray = array();
    	$questionsArray = array();
    	$pollAnswersArray = array();
    	$registrantArray = $this->toArray();
    	if($registrantArray['attendanceTimeInSeconds'] > 0) $registrantArray['attendanceTimeInMinutes'] = round($registrantArray['attendanceTimeInSeconds']/60);
    	if($session = $this->getOne('Session')){
	    	$sessionArray = $session->toArray('ses.');
	    }
    	if ($registration = $this->getOne('Registration')) {
	    	$registrationArray = $registration->toArray('reg.');
	    }
    	if($questions = $this->getMany('Question')){
    		$questionsText = '';
	    	foreach ($questions as $question) {
	    		$questionsText .= 'question: "'.$question->get('question').'"';
	    		if($answers = $question->getMany('Answer')) {
		    		foreach ($answers as $answer) {
		    			$questionsText .= ' answer: "'.$answer->get('answer').'" answered by: '.$answer->get('answeredBy');
		    		}
		    	}
	    		$questionsText .= ' || ';
	    	}
	    	$questionsArray = array('questions' => $questionsText);
	    }
    	if ($pollAnswers = $this->getMany('PollAnswer')) {
    		$pollAnswersText = '';
	    	foreach ($pollAnswers as $pollAnswer) {
	    		$response = $pollAnswer->getOne('Response');
	    		$poll = $response->getOne('Poll');
	    		$pollAnswersText .= $poll->get('type').': "'.$poll->get('question').'" response: "'.$response->get('text').'" || ';
	    	}
	    	$pollAnswersArray = array('polls' => $pollAnswersText);
	    }
    	return array_merge($registrantArray, $sessionArray, $registrationArray, $questionsArray, $pollAnswersArray);
    }

}
?>