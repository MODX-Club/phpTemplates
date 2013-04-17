<?php
switch($modx->event->name) {
	case 'OnManagerPageInit':
		$cssFile = $modx->getOption('phptemplates.assets_url',null,$modx->getOption('assets_url').'components/phptemplates/').'css/mgr/phptemplates.css';
		$modx->regClientCSS($cssFile);
	break;
    
    case 'OnLoadWebDocument':
        if($modx->resource instanceOf modResource
            AND $template = $modx->resource->getOne('Template') 
            AND $properties = $template->getProperties()
            AND !empty($properties['phptemplates.non-cached'])
        ){
            $modx->resource->setProcessed(false);
        }
        break;
}