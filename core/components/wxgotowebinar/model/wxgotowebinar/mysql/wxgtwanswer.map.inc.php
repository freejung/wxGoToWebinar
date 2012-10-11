<?php
/**
 * @package wxgotowebinar
 */
$xpdo_meta_map['wxGtwAnswer']= array (
  'package' => 'wxgotowebinar',
  'version' => '1.1',
  'table' => 'wx_gtw_answer',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'answer' => '',
    'answeredBy' => '',
    'wxgtwquestion' => 0,
  ),
  'fieldMeta' => 
  array (
    'answer' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'answeredBy' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'wxgtwquestion' => 
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
    'wxgtwquestion' => 
    array (
      'alias' => 'wxgtwquestion',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'wxgtwquestion' => 
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
    'Question' => 
    array (
      'class' => 'wxGtwQuestion',
      'local' => 'wxgtwquestion',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);
