<?php
/**
 * @package modx
 * @subpackage mysql
 */
$xpdo_meta_map['phpTemplateResource']= array (
  'package' => 'modx',
  'version' => '1.1',
  'extends' => 'modResource',
  'fields' => 
  array (
      'class_key' => 'phpTemplateResource',
  ),
  'fieldMeta' => 
  array (
  ),
  'aggregates' => 
  array (  
    'Template' => 
    array (
      'class' => 'phpTemplate',
      'local' => 'template',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ), 
  ),
);