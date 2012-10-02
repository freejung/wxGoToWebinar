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
        foreach ($pollAnswers as $answerData) {
            $answer = new wxGtwPollAnswer;
            $pollQuery = $this->xpdo->newQuery('wxGtwPoll');
            $pollQuery->where(array(
                'question:=' => $answerData['question'],
                'wxgtwsession:=' => $sessionId,
            ));
            if($poll = $this->xpdo->getObject('wxGtwPoll', $pollQuery)) {
                $answer->addOne($poll);
                if($responses = $poll->getMany('wxGtwPollResponse', array('text:=' => $answerData['answer']))) {
                    //there should be only one response with matching text, but if there is more than one
                    //just use the first one
                    $answer->addOne($responses[0]);
                    $answer->save();
                }
            }
        }
        return true;
    }
	
}
?>