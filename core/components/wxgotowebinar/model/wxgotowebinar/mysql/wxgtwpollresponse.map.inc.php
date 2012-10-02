<?php
/**
 * @package wxgotowebinar
 */
$xpdo_meta_map['wxGtwPollResponse']= array (
  'package' => 'wxgotowebinar',
  'version' => '1.1',
  'table' => 'wx_gtw_pollresponse',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'text' => '',
    'percentage' => '',
    'wxgtwpoll' => 0,
  ),
  'fieldMeta' => 
  array (
    'text' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'percentage' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '20',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'wxgtwpoll' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
  ),
  'indexes' => 
  array (
    'wxgtwpoll' => 
    array (
      'alias' => 'wxgtwpoll',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'wxgtwpoll' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
  ),
  'composites' => 
  array (
    'Answer' => 
    array (
      'class' => 'wxGtwPollAnswer',
      'local' => 'id',
      'foreign' => 'wxgtwpollresponse',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
  'aggregates' => 
  array (
    'Poll' => 
    array (
      'class' => 'wxGtwPoll',
      'local' => 'wxgtwpoll',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);
