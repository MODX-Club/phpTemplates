<?php
switch($modx->event->name) {
	case 'OnManagerPageInit':
		$cssFile = $modx->getOption('phptemplates.assets_url',null,$modx->getOption('assets_url').'components/phptemplates/').'css/mgr/phptemplates.css';
		$modx->regClientCSS($cssFile);
	break;
}