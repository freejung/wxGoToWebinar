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
/**
 * Loads the home page.
 *
 * @package wxgotowebinar
 * @subpackage controllers
 */
class wxGoToWebinarHomeManagerController extends wxGoToWebinarBaseManagerController {
    public function process(array $scriptProperties = array()) {

    }
    public function getPageTitle() { return $this->modx->lexicon('wxgotowebinar'); }
    public function loadCustomCssJs() {
        $this->addJavascript($this->wxgotowebinar->config['jsUrl'].'mgr/widgets/items.grid.js');
        $this->addJavascript($this->wxgotowebinar->config['jsUrl'].'mgr/widgets/home.panel.js');
        $this->addLastJavascript($this->wxgotowebinar->config['jsUrl'].'mgr/sections/home.js');
    }
    public function getTemplateFile() { return $this->wxgotowebinar->config['templatesPath'].'home.tpl'; }
}