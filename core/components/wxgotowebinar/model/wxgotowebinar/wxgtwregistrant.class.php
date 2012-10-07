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
	
}
?>