<?php
/**
 * @package wxgotowebinar
 */
class wxGtwQuestion extends xPDOSimpleObject {
	
	/*
    * @param array $questionData
    */
    public function fromFullArray ($questionData = array()) {
        $this->fromArray($questionData);
        $answerArray = array();
        foreach($questionData['answers'] as $answerData) {
            $answer = $this->xpdo->newObject('wxGtwAnswer');
            $answer->fromArray($answerData);
            $answerArray[] = $answer;
        }
        $this->addMany($answerArray);
        return $this->save();;
    }
	
}
?>