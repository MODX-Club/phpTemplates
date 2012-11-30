<?php
global  $modx, $sources;

$plugins = array();

$plugin = $modx->newObject('modPlugin');
$plugin->set('id', null);
$plugin->set('name', 'phpTemplates');
$plugin->set('description', 'plugin for phpTemplates Extra');
$plugin->set('plugincode', getSnippetContent($sources['source_core'].'/elements/plugins/phptemplates.plugin.php'));

/* add plugin events */
$events = include $sources['data'].'transport.plugins.events.php';
if (is_array($events) && !empty($events)) {
    $plugin->addMany($events, 'PluginEvents');
    $modx->log(xPDO::LOG_LEVEL_INFO,'Packaged in '.count($events).' Plugin Events.'); flush();
} else {
    $modx->log(xPDO::LOG_LEVEL_ERROR,'Could not find plugin events!');
}

$plugins[] = $plugin;

return $plugins;
