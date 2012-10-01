<?php
/**
 * wxGoToWebinar
 *
 * Copyright 2012 by Eli Snyder <freejung@gmail.com>
 */
/**
 * @package wxGoToWebinar
 * @subpackage model
 */
class wxGtwQuestion extends xPDOSimpleObject {
	
	/*
    * @param array $questionData
    */
	public function fromFullArray ($questionData) {
		$this->fromArray($questionData);
		$this->save();
		foreach($questionData['answers'] as $answerData) {
			$answer = new wxGtwAnswer();
			$answer->fromArray($answerData);
			$answer->addOne('Question', $this);
			$answer->save();
		}
		return true;
	}
	
}