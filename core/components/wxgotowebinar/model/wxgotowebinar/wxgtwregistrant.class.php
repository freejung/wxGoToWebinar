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
            $answer = $this->xpdo->newObject('wxGtwPollAnswer');
            $pollQuery = $this->xpdo->newQuery('wxGtwPoll');
            $pollQuery->where(array(
                'question:=' => $answerData['question'],
                'wxgtwsession:=' => $sessionId,
            ));
            if($poll = $this->xpdo->getObject('wxGtwPoll', $pollQuery)) {
            	echo('poll found: '.$poll->id);
            	$responseQuery = $this->xpdo->newQuery('wxGtwPollResponse');
            	$responseQuery->where(array(
            		'text:=' => $answerData['answer'],
            		'wxgtwpoll:=' => $poll->id,
            	));
                if($response = $this->xpdo->getObject('wxGtwPollResponse',$responseQuery)) {
                	echo('<br>response found: '. $response->id);
                    $answer->addOne($response);
                    $answer->save();
                }
            }
			$answersArray[] = $answer;
        }
        $this->addMany($answersArray);
        return $this->save();
    }
	
}
?>