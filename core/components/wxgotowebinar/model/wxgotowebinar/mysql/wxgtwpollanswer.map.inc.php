<?php
/**
 * @package wxgotowebinar
 */
$xpdo_meta_map['wxGtwPollAnswer']= array (
  'package' => 'wxgotowebinar',
  'version' => '1.1',
  'table' => 'wx_gtw_pollanswer',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'wxgtwpollresponse' => 0,
    'wxgtwregistrant' => 0,
  ),
  'fieldMeta' => 
  array (
    'wxgtwpollresponse' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'wxgtwregistrant' => 
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
    'wxgtwregistrant' => 
    array (
      'alias' => 'wxgtwregistrant',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'wxgtwregistrant' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'wxgtwpollresponse' => 
    array (
      'alias' => 'wxgtwpollresponse',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'wxgtwpollresponse' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
  ),
  'aggregates' => 
  array (
    'Registrant' => 
    array (
      'class' => 'wxGtwRegistrant',
      'local' => 'wxgtwregistrant',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
    'Response' => 
    array (
      'class' => 'wxGtwResponse',
      'local' => 'wxgtwpollresponse',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);
