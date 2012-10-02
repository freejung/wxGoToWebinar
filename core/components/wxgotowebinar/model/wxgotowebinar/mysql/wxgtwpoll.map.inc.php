<?php
/**
 * @package wxgotowebinar
 */
$xpdo_meta_map['wxGtwPoll']= array (
  'package' => 'wxgotowebinar',
  'version' => '1.1',
  'table' => 'wx_gtw_poll',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'question' => '',
    'numberOfResponses' => 0,
    'type' => '',
    'wxgtwsession' => 0,
  ),
  'fieldMeta' => 
  array (
    'question' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'numberOfResponses' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'type' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '20',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'wxgtwsession' => 
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
    'wxgtwsession' => 
    array (
      'alias' => 'wxgtwsession',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'wxgtwsession' => 
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
    'Response' => 
    array (
      'class' => 'wxGtwPollResponse',
      'local' => 'id',
      'foreign' => 'wxgtwpoll',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
  'aggregates' => 
  array (
    'Session' => 
    array (
      'class' => 'wxGtwSession',
      'local' => 'wxgtwsession',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);
