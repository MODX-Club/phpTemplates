<?php
/**
 * phpTemplates CRC
 *
 * Author: proxyfabio
 * Date: 29.11.12
 *
 * @package: phpTemplates
 * @subpackage: build
 */

$this->loadClass('modTemplate');

class phpTemplate extends modTemplate{
    public function process($properties = null, $content = null) {
        $this->_process($properties, $content);
        if (!$this->_processed) {
            return parent::process($properties, $content);
        }
        return $this->_output;
    }
     
    protected function _process($properties = null, $content = null) {
        if(!$this->isStatic()){return;}
        if(!$controller = $this->getSourceFile()){return ;}
        $modx = & $this->xpdo;
        $resource = & $this->xpdo->resource;
        $this->_output = require_once $controller;
        $this->_processed = true;
        return ;
    }
}