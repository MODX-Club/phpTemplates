<?php
/**
 * PHPTemplateResource CRC fot modResource
 *
 * Author: proxyfabio
 * Date: 29.11.12
 *
 * @package: PHPTemplates
 * @subpackage: build
 */
require_once MODX_CORE_PATH.'model/modx/modprocessor.class.php';
require_once MODX_CORE_PATH.'model/modx/processors/resource/create.class.php';
require_once MODX_CORE_PATH.'model/modx/processors/resource/update.class.php';


class PHPTemplateResource extends modResource{
    public $showInContextMenu = true;
    public $allowChildrenResources = true;
    private static $pkgName = 'phphtemplates';

    function __construct(xPDO & $xpdo) {
        parent :: __construct($xpdo);
        $this->set('class_key','PHPTemplateResource');
    }

    public static function getControllerPath(xPDO &$modx) {
        return $modx->getOption('phphtemplates.core_path',null,$modx->getOption('core_path').'components/phphtemplates/').'controllers/phptemplateresource/';
    }

    public function getContextMenuText() {
        $this->xpdo->lexicon->load('phphtemplates:default');
        return array(
            'text_create' => $this->xpdo->lexicon('phphtemplates_resource_create'),
            'text_create_here' => $this->xpdo->lexicon('phphtemplates_resource_create_here'),
        );
    }

    public function getResourceTypeName() {
        $this->xpdo->lexicon->load('phphtemplates:default');
        return $this->xpdo->lexicon('phphtemplates_resource');
    }

    public function getContent(array $options = array()) {
        $content = parent::getContent($options);

        return $content;
    }

    /**
     * Clearing cache of this resource
     * @param string $context Key of context for clearing
     * @return void
     */
    public function clearCache($context = null) {
        if (empty($context)) {
            $context = $this->context_key;
        }
        $this->_contextKey = $context;

        /** @var xPDOFileCache $cache */
        $cache = $this->xpdo->cacheManager->getCacheProvider($this->xpdo->getOption('cache_resource_key', null, 'resource'));
        $key = $this->getCacheKey();
        $cache->delete($key, array('deleteTop' => true));
        $cache->delete($key);
    }

}



/**
 * Overrides the modResourceUpdateProcessor to provide custom processor functionality for the TicketsSection type
 *
 * @package tickets
 */
class PHPTemplateResourceUpdateProcessor extends modResourceUpdateProcessor {
    /** @var TicketsSection $object */
    public $object;
    public $classKey = 'PHPTemplateResource';

    public function beforeSet() {
        $this->setProperties(array(
            'hide_children_in_tree' => 0,
        ));
        return parent::beforeSet();
    }

}