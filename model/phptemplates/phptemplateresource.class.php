<?php
/**
 * phpTemplateResource CRC fot modResource
 *
 * Author: proxyfabio
 * Date: 29.11.12
 *
 * @package: phpTemplates
 * @subpackage: build
 */
require_once MODX_CORE_PATH.'model/modx/modresource.class.php';


class phpTemplateResource extends modResource{
    public $showInContextMenu = true;
    public $allowChildrenResources = true;
    private static $pkgName = 'phptemplates';

    function __construct(xPDO & $xpdo) {
        parent :: __construct($xpdo);
        $this->set('class_key','phpTemplateResource');
    }

    public static function getControllerPath(xPDO &$modx) {
        return $modx->getOption('phptemplates.core_path',null,$modx->getOption('core_path').'components/phptemplates/').'controllers/phptemplateresource/';
    }

    public function getContextMenuText() {
        $this->xpdo->lexicon->load('phptemplates:default');
        return array(
            'text_create' => $this->xpdo->lexicon('phptemplates_resource_create'),
            'text_create_here' => $this->xpdo->lexicon('phptemplates_resource_create_here'),
        );
    }

    public function getResourceTypeName() {
        $this->xpdo->lexicon->load('phptemplates:default');
        return $this->xpdo->lexicon('phptemplates_resource');
    }

    function process(){
        /*
         * Try to get Template
         */
        if(!$baseElement= $this->getOne('Template')){
            return parent::process();
        }
        
        /*
         * Try to precess Template
         */
        if ($baseElement->process()) {
                $this->_content= $baseElement->_output;
                $this->_processed= true;
        }
        else {
            $this->_content= $this->getContent();
            $maxIterations= intval($this->xpdo->getOption('parser_max_iterations',10));
            $this->xpdo->parser->processElementTags('', $this->_content, false, false, '[[', ']]', array(), $maxIterations);
            $this->_processed= true;
        }
            
        /*
         * If this is static Template
         */
        if($baseElement->_static_template == true){
            
            $maxIterations= intval($this->xpdo->getOption('parser_max_iterations',10));
            $this->xpdo->parser->processElementTags('', $this->_content, true, false, '[[', ']]', array(), $maxIterations);
            $this->xpdo->parser->processElementTags('', $this->_content, true, true, '[[', ']]', array(), $maxIterations);

            $this->xpdo->invokeEvent('OnWebPagePrerender');
            
            print $this->_content;
            
            $this->_content = null;
            
            if ($this->xpdo->getOption('cache_resource', null, true)) {
                if ($this->get('id') && $this->get('cacheable')) {
                    $this->xpdo->invokeEvent('OnBeforeSaveWebPageCache');
                    $this->xpdo->cacheManager->generateResource($this);
                }
            }
            $this->xpdo->invokeEvent('OnWebPageComplete');
            exit;
        }
        
        return $this->_content;   
    }
}