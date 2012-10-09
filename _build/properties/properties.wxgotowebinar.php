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
 * Properties for the wxGoToWebinar snippet.
 *
 * @package wxgotowebinar
 * @subpackage build
 */
$properties = array(
    array(
        'name' => 'tpl',
        'desc' => 'prop_wxgotowebinar.tpl_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => 'Item',
        'lexicon' => 'wxgotowebinar:properties',
    ),
    array(
        'name' => 'sortBy',
        'desc' => 'prop_wxgotowebinar.sortby_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => 'name',
        'lexicon' => 'wxgotowebinar:properties',
    ),
    array(
        'name' => 'sortDir',
        'desc' => 'prop_wxgotowebinar.sortdir_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => 'ASC',
        'lexicon' => 'wxgotowebinar:properties',
    ),
    array(
        'name' => 'limit',
        'desc' => 'prop_wxgotowebinar.limit_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => 5,
        'lexicon' => 'wxgotowebinar:properties',
    ),
    array(
        'name' => 'outputSeparator',
        'desc' => 'prop_wxgotowebinar.outputseparator_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
        'lexicon' => 'wxgotowebinar:properties',
    ),
    array(
        'name' => 'toPlaceholder',
        'desc' => 'prop_wxgotowebinar.toplaceholder_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => true,
        'lexicon' => 'wxgotowebinar:properties',
    ),
/*
    array(
        'name' => '',
        'desc' => 'prop_wxgotowebinar.',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
        'lexicon' => 'wxgotowebinar:properties',
    ),
    */
);

return $properties;