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
class wxGtwSession extends xPDOSimpleObject {

	/*
    * @param array $polls
    * @param string $pollType
    */
	public function pollSetup ($polls, $pollType) {
		foreach ($polls as $polldata) {
			$poll = new wxGtwPoll();
			$poll->set('type', $pollType);
			$poll->fromFullArray($polls);
			$poll->addOne('Session', $this);
			$poll->save();
		}
		return true;
	}
	
	/*
    * @param array $questions
    * @param int $sessionId
    */
	public function addQuestions ($questions, $sessionId) {
		foreach($questions as $questionData) {
			$question = new wxGtwQuestion();
			$question->fromFullArray($questionData);
			$registrantQuery = $this->xpdo->newQuery('wxGtwRegistrant');
			$registrantQuery->where(array(
				'wxgtwsession' => $sessionId,
				'email' => $questionData['askedBy'],
			));
			$registrant = $this->xpdo->getObject('wxGtwRegistrant', $registrantQuery);
			$question->addOne($registrant);
			$question->save();
		}
		return true;
	}
	
}