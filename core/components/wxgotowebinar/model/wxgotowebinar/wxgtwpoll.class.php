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
        $responseArray = array();
        foreach($pollData['responses'] as $responseData) {
            $response = $this->xpdo->newObject('wxGtwPollResponse');
            $response->fromArray($responseData);
            $responseArray[] = $response;
        }
        $this->addMany($responseArray);
        return $this->save();;
    }
	
}
?>