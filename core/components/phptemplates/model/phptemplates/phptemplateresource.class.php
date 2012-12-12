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
                $this->_output= $baseElement->_output;
                $this->_processed= true;
        }
        else {
            $this->_output= $this->getContent();
            $maxIterations= intval($this->xpdo->getOption('parser_max_iterations',10));
            $this->xpdo->parser->processElementTags('', $this->_output, false, false, '[[', ']]', array(), $maxIterations);
            $this->_processed= true;
        }
            
        /*
         * If this is static Template
         */
        if($baseElement->_static_template == true){
            
            
            $this->xpdo->resource->_jscripts= $this->xpdo->jscripts;
            $this->xpdo->resource->_sjscripts= $this->xpdo->sjscripts;
            $this->xpdo->resource->_loadedjscripts= $this->xpdo->loadedjscripts;
            
            $this->xpdo->getParser();
            
            $maxIterations= intval($this->xpdo->getOption('parser_max_iterations',10));
            $this->xpdo->parser->processElementTags('', $this->_output, true, false, '[[', ']]', array(), $maxIterations);
            $this->xpdo->parser->processElementTags('', $this->_output, true, true, '[[', ']]', array(), $maxIterations);
            
            /*FIXME: only do this for HTML content ?*/
            if ( $this->contentType == 'text/html') {
                /* Insert Startup jscripts & CSS scripts into template - template must have a </head> tag */
                if (($js= $this->xpdo->getRegisteredClientStartupScripts()) && (strpos($this->_output, '</head>') !== false)) {
                    /* change to just before closing </head> */
                    $this->_output= preg_replace("/(<\/head>)/i", $js . "\n\\1", $this->_output,1);
                }

                /* Insert jscripts & html block into template - template must have a </body> tag */
                if ((strpos($this->_output, '</body>') !== false) && ($js= $this->xpdo->getRegisteredClientScripts())) {
                    $this->_output= preg_replace("/(<\/body>)/i", $js . "\n\\1", $this->_output,1);
                }
            }
            
            $this->xpdo->beforeRender();
            
            $this->xpdo->invokeEvent('OnWebPagePrerender');
            
            /*
             * printting output 
             */
            print $this->_output; 
            
            /*
             * Empty data for minimize document cache
             */
            $this->_output = null;
            $this->xpdo->elementCache = null;
            $this->xpdo->sourceCache = null;
             
            if ($this->xpdo->getOption('cache_resource', null, true)) {
                if ($this->get('id') && $this->get('cacheable')) {
                    $this->xpdo->invokeEvent('OnBeforeSaveWebPageCache');
                    $this->xpdo->cacheManager->generateResource($this);
                }
            }
            
            $this->xpdo->invokeEvent('OnWebPageComplete');
            @session_write_close();
            exit;
        }
        
        return $this->_output;   
    }
}