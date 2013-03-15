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
$this->loadClass('modResource');

class phpTemplateResource extends modResource{
    public $showInContextMenu = true;
    public $allowChildrenResources = true;
    private static $pkgName = 'phptemplates';

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
        $this->_content= '';
        $this->_output= '';
        $this->xpdo->getParser();
        /** @var modTemplate $baseElement */
        if ($baseElement= $this->getOne('Template') AND $baseElement->process()) {
                $this->_content= $baseElement->_output;
                $this->_processed= true;
        } else {
            return parent::process();
        }
        return $this->_content;  
    }
}