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
            $question = $this->xpdo->newObject('wxGtwQuestion');
            $question->fromFullArray($questionData);
            $registrantQuery = $this->xpdo->newQuery('wxGtwRegistrant');
            $registrantQuery->where(array(
                'wxgtwsession' => $this->id,
                'email' => $questionData['askedBy'],
            ));
            $registrant = $this->xpdo->getObject('wxGtwRegistrant', $registrantQuery);
            $question->addOne($registrant);
            $question->save();
        }
        return true;
    }
	
}
?>