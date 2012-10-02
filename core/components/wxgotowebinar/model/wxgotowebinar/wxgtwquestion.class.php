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
        $this->save();
        foreach($questionData['answers'] as $answerData) {
            $answer = new wxGtwAnswer;
            $answer->fromArray($answerData);
            $answer->addOne('Question', $this);
            $answer->save();
        }
        return true;
    }
	
}
?>