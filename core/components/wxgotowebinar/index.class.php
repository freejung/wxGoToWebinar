<?php
/**
 * wxGoToWebinar
 *
 * Copyright 2012 by Eli Snyder <freejung@gmail.com>
 *
 * wxGoToWebinar is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * wxGoToWebinar is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * wxGoToWebinar; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package wxgotowebinar
 */
require_once dirname(__FILE__) . '/model/wxgotowebinar/wxgotowebinar.class.php';
/**
 * @package wxgotowebinar
 */
class IndexManagerController extends wxGoToWebinarBaseManagerController {
    public static function getDefaultController() { return 'home'; }
}

abstract class wxGoToWebinarBaseManagerController extends wxGoToWebinarManagerController {
    /** @var wxGoToWebinar $wxgotowebinar */
    public $wxgotowebinar;
    public function initialize() {
        $this->wxgotowebinar = new wxGoToWebinar($this->modx);

        $this->addCss($this->wxgotowebinar->config['cssUrl'].'mgr.css');
        $this->addJavascript($this->wxgotowebinar->config['jsUrl'].'mgr/wxgotowebinar.js');
        $this->addHtml('<script type="text/javascript">
        Ext.onReady(function() {
            wxGoToWebinar.config = '.$this->modx->toJSON($this->wxgotowebinar->config).';
            wxGoToWebinar.config.connector_url = "'.$this->wxgotowebinar->config['connectorUrl'].'";
        });
        </script>');
        return parent::initialize();
    }
    public function getLanguageTopics() {
        return array('wxgotowebinar:default');
    }
    public function checkPermissions() { return true;}
}