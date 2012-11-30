<?php
/**
 * Author: proxyfabio
 * Date: 29.11.12
 *
 * @package: phpTemplates
 * @subpackage: build
 */

class phpTemplateResourceCreateManagerController extends ResourceCreateManagerController {
    /**
     * Returns language topics
     * @return array
     */
    public function getLanguageTopics() {
        return array('resource','phptemplates:default');
    }

 

}
