<?php
/**
 * @package wxgotowebinar
 */
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\', '/') . '/wxgtwregistrant.class.php');
class wxGtwRegistrant_mysql extends wxGtwRegistrant {}
?>