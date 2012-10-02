<?php
/**
 * @package wxgotowebinar
 */
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\', '/') . '/wxgtwpollresponse.class.php');
class wxGtwPollResponse_mysql extends wxGtwPollResponse {}
?>