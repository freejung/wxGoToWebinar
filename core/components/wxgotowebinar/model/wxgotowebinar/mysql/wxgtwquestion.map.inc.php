<?php
/**
 * @package wxgotowebinar
 */
$xpdo_meta_map['wxGtwQuestion']= array (
  'package' => 'wxgotowebinar',
  'version' => '1.1',
  'table' => 'wx_gtw_question',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'question' => '',
    'wxgtwregistrant' => 0,
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
  ),
  'composites' => 
  array (
    'Answer' => 
    array (
      'class' => 'wxGtwAnswer',
      'local' => 'id',
      'foreign' => 'wxgtwquestion',
      'cardinality' => 'many',
      'owner' => 'local',
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
  ),
);
