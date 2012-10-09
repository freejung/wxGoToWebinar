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
 * Resolve creating db tables
 *
 * @package wxgotowebinar
 * @subpackage build
 */
if ($object->xpdo) {
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
            $modx =& $object->xpdo;
            $modelPath = $modx->getOption('wxgotowebinar.core_path',null,$modx->getOption('core_path').'components/wxgotowebinar/').'model/';
            $modx->addPackage('wxgotowebinar',$modelPath);

            $manager = $modx->getManager();

            $manager->createObjectContainer('wxGtwRegistrant');
            $manager->createObjectContainer('wxGtwQuestion');
            $manager->createObjectContainer('wxGtwAnswer');
            $manager->createObjectContainer('wxGtwPoll');
            $manager->createObjectContainer('wxGtwPollResponse');
            $manager->createObjectContainer('wxGtwPollAnswer');
            $manager->createObjectContainer('wxGtwSession');

            break;
        case xPDOTransport::ACTION_UPGRADE:
            break;
    }
}
return true;