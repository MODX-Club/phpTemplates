<?php
/**
 * Meta
 *
 * Author: proxyfabio
 * Date: 29.11.12
 *
 * @package: phpTemplates
 * @subpackage: build
 */
$xpdo_meta_map = array (
    'modResource' =>
    array (
        0 => 'phpTemplateResource',
    ),
);

$this->map['modResource']['aggregates']['Template'] = array(
    'class' => 'phpTemplate',
    'local' => 'template',
    'foreign'   => 'id',
    'cardinality' => 'one',
    'owner' => 'foreign',
);