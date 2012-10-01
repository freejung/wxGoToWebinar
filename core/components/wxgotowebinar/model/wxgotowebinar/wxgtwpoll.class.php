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
class wxGtwPoll extends xPDOSimpleObject {
    
    /*
    * @param array $pollData
    */
    public function fromFullArray ($pollData) {
        $this->fromArray($pollData);
        $this->save();
        foreach($pollData['responses'] as $responseData) {
            $response = new wxGtwPollResponse();
            $response->fromArray($responseData);
            $response->addOne('Poll', $this);
            $response->save();
        }
        return true;
    }
    
}