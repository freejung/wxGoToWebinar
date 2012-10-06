<?php
define('MODX_API_MODE', true);
require_once '/mnt/stor9-wc1-dfw1/627233/dev.dealerwebinars.com/web/content/index.php';


# Get necessary services
$webinex = $modx->getService('webinex','Webinex',$modx->getOption('webinex.core_path',null,$modx->getOption('core_path').'components/webinex/').'model/webinex/');
if (!($webinex instanceof Webinex)) return 'could not instantiate Webinex';

$gtw = $modx->getService('wxgotowebinar','wxGoToWebinar',$modx->getOption('wxgotowebinar.core_path',null,$modx->getOption('core_path').'components/wxgotowebinar/').'model/wxgotowebinar/');
if (!($gtw instanceof wxGoToWebinar)) return 'could not instantiate wxGoToWebinar';

$presentation = $modx->getObject('wxPresentation',4);

//echo ($gtw->gtwAPI->getAttendeesForAllWebinarSessions(368698758));

echo($gtw->getAttendance($presentation));

exit();
?>