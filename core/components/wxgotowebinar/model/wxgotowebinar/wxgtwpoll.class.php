<?php
/**
 * @package wxgotowebinar
 */
class wxGtwPoll extends xPDOSimpleObject {
	
    /*
    * @param array $pollData
    */
    public function fromFullArray ($pollData = array()) {
        $this->fromArray($pollData);
        $this->save();
        foreach($pollData['responses'] as $responseData) {
            $response = new wxGtwPollResponse;
            $response->fromArray($responseData);
            $response->addOne('Poll', $this);
            $response->save();
        }
        return true;
    }
	
}
?>