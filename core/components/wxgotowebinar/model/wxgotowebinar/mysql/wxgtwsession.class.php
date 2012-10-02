<?php
/**
 * @package wxgotowebinar
 */
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\', '/') . '/wxgtwsession.class.php');
class wxGtwSession_mysql extends wxGtwSession {}
?>