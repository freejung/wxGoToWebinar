<?php
/**
 * @package wxgotowebinar
 */
class wxGtwSession extends xPDOSimpleObject {
	
	/*
    * @param array $polls
    * @param string $pollType
    */
    public function pollSetup ($polls = array(), $pollType = 'poll') {
    	$pollArray = array();
        foreach ($polls as $polldata) {
            $poll = $this->xpdo->newObject('wxGtwPoll');
            $poll->set('type', $pollType);
            $poll->fromFullArray($polldata);
            $pollArray[] = $poll;
        }
        $this->addMany($pollArray);
        return $this->save();
    }
    
    /*
    * @param array $questions
    */
    public function addQuestions ($questions = array()) {
        foreach($questions as $questionData) {
        	if (!$question = $this->xpdo->getObject('wxGtwQuestion', array('question' => $questionData['question']))) {
	            $question = $this->xpdo->newObject('wxGtwQuestion');
	            $question->fromFullArray($questionData);
	            if($registrant = $this->xpdo->getObject('wxGtwRegistrant', array('wxgtwsession' => $this->id, 'email' => $questionData['askedBy']))) {
		            $question->addOne($registrant);
		            $question->save();
		        } 
            }
        }
        return true;
    }
	
}
?>