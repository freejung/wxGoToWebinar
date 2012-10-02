<?php
/**
 * @package wxgotowebinar
 */
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\', '/') . '/wxgtwquestion.class.php');
class wxGtwQuestion_mysql extends wxGtwQuestion {}
?>