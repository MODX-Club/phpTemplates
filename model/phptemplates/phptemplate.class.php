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

require_once MODX_CORE_PATH.'model/modx/modtemplate.class.php';

class phpTemplate extends modTemplate{
    public $_static_template = false;
    
    public function process($properties= null, $content= null){
        if($this->static != '1'){
            return parent::process($properties, $content);
        }
        
        $this->_static_template = true;
        
        $modx = & $this->xpdo;
        ob_start();
            @include $this->getSourceFile(); 
            $this->_output = ob_get_contents();
        ob_end_clean(); 
        return $this->_output;
    }
}