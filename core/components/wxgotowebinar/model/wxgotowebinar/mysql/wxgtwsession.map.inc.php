<?php
/**
 * @package wxgotowebinar
 */
$xpdo_meta_map['wxGtwSession']= array (
  'package' => 'wxgotowebinar',
  'version' => '1.1',
  'table' => 'wx_gtw_session',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'webinarKey' => '',
    'sessionKey' => '',
    'startTime' => NULL,
    'endTime' => NULL,
    'percentageAttendance' => '',
    'averageAttendanceTimeSeconds' => '',
    'averageInterestRating' => '',
    'averageAttentiveness' => '',
    'pollCount' => 0,
    'surveyCount' => 0,
    'questionsAsked' => 0,
    'percentagePollsCompleted' => '',
    'percentageSurveysCompleted' => '',
    'wxpresentation' => 0,
  ),
  'fieldMeta' => 
  array (
    'webinarKey' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'sessionKey' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'startTime' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
      'null' => true,
    ),
    'endTime' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
      'null' => true,
    ),
    'percentageAttendance' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '20',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'averageAttendanceTimeSeconds' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '20',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'averageInterestRating' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '20',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'averageAttentiveness' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '20',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'pollCount' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'surveyCount' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'questionsAsked' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'percentagePollsCompleted' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '20',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'percentageSurveysCompleted' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '20',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'wxpresentation' => 
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
    'webinarkey' => 
    array (
      'alias' => 'webinarkey',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'webinarkey' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'sessionkey' => 
    array (
      'alias' => 'sessionkey',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'sessionkey' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'wxpresentation' => 
    array (
      'alias' => 'wxpresentation',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'wxpresentation' => 
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
    'PollQuestion' => 
    array (
      'class' => 'wxgtwpoll',
      'local' => 'id',
      'foreign' => 'wxgtwsession',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
    'Registrant' => 
    array (
      'class' => 'wxGtwRegistrant',
      'local' => 'id',
      'foreign' => 'wxgtwsession',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
  'aggregates' => 
  array (
    'Presentation' => 
    array (
      'class' => 'wxPresentation',
      'local' => 'wxpresentation',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);
