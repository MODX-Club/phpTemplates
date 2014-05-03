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
        $this->getProperties($properties);
        $resource = & $this->xpdo->resource;
        $this->_output = require $controller;
        if (is_string($this->_output) && !empty($this->_output)) {
            /* turn the processed properties into placeholders */
            $this->xpdo->toPlaceholders($this->_properties, '', '.', true);

            /* collect element tags in the content and process them */
            $maxIterations= intval($this->xpdo->getOption('parser_max_iterations',null,10));
            $this->xpdo->parser->processElementTags($this->_tag, $this->_output, false, false, '[[', ']]', array(), $maxIterations);
        }
        $this->filterOutput();
        $this->_processed = true;
        return ;
    }
}