<?php
/**
 * @package bannery
 * @subpackage build
 */
global  $modx, $sources;
$events = array();

$events['OnManagerPageInit']= $modx->newObject('modPluginEvent');
$events['OnManagerPageInit']->fromArray(array(
    'event' => 'OnManagerPageInit',
    'priority' => 0,
    'propertyset' => 0,
),'',true,true);

$events['OnLoadWebDocument']= $modx->newObject('modPluginEvent');
$events['OnLoadWebDocument']->fromArray(array(
    'event' => 'OnLoadWebDocument',
    'priority' => 0,
    'propertyset' => 0,
),'',true,true);

return $events;