<?php
/**
 * @package wxgotowebinar
 */
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\', '/') . '/wxgtwpoll.class.php');
class wxGtwPoll_mysql extends wxGtwPoll {}
?>