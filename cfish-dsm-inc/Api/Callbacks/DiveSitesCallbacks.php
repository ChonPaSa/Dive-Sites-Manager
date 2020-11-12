<?php
/**
 * @package  DiveSitesManager
 */
namespace cfishDSMInc\Api\Callbacks;

use cfishDSMInc\Base\BaseController;

class DiveSitesCallbacks extends BaseController
{
    public function shortcodePage()
    {
        return require_once( "$this->plugin_path/templates/divesites.php" );
    }
}
