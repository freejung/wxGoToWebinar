<?php
/**
 * @package wxgotowebinar
 */
$xpdo_meta_map['wxGtwRegistrant']= array (
  'package' => 'wxgotowebinar',
  'version' => '1.1',
  'table' => 'wx_gtw_registrant',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'registrantKey' => '',
    'status' => '',
    'joinUrl' => '',
    'email' => '',
    'attendanceTimeInSeconds' => 0,
    'wxgtwsession' => 0,
    'wxregistration' => 0,
  ),
  'fieldMeta' => 
  array (
    'registrantKey' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'status' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'joinUrl' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'email' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'attendanceTimeInSeconds' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => true,
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
    'wxregistration' => 
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
    'registrantkey' => 
    array (
      'alias' => 'registrantkey',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'registrantkey' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
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
    'wxregistration' => 
    array (
      'alias' => 'wxregistration',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'wxregistration' => 
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
    'Question' => 
    array (
      'class' => 'wxGtwQuestion',
      'local' => 'id',
      'foreign' => 'wxgtwregistrant',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
    'PollAnswer' => 
    array (
      'class' => 'wxGtwPollAnswer',
      'local' => 'id',
      'foreign' => 'wxgtwregistrant',
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
    'Registration' => 
    array (
      'class' => 'wxRegistration',
      'local' => 'wxregistration',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);
