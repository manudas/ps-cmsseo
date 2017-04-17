<?php
/**
 * 2017 Manuel José Pulgar Anguita
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @author    Manuel José Pulgar Anguita <cibermanu@hotmail.com>
 * @copyright 2017 Manuel José Pulgar Anguita
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */

/**
 * Class CMSCore
 */
class CMS extends CMSCore
{

    protected $module_name = 'combinationseo'; 

    /**
     * @param int      $idCms
     * @param int|null $idLang
     * @param int|null $idShop
     *
     * @return array|bool|null|object
     */
    public static function getCMSContent($idCms, $idLang = null, $idShop = null)
    {

        if (is_null($idLang)) {
            $idLang = (int) Configuration::get('PS_LANG_DEFAULT');
        }
        if (is_null($idShop)) {
            $idShop = (int) Configuration::get('PS_SHOP_DEFAULT');
        }

        /* Loading the module we ensure we have included the desired
         * ObjectModel classes we are going to need next
         */
        $combinationseo_module = Module :: getInstanceByName ($this -> module_name);

        $adminCodeCombinatorController =  $combinationseo_module -> getModuleAdminControllerByName('AdminCodeCombinator');
        
        $blockReference = CodeCombination::getBlockReferenceByObjectIdAndType ($idCms, 'cms');
        $combination_seo_string = $adminCodeCombinatorController -> getReplacedBlockString ('cms', $blockReference);
        
        $partial_result = array ('content' => $combination_seo_string);

        $COMBINATIONSEO_CONCATENATE_RESULT = Configuration::get('COMBINATIONSEO_CONCATENATE_RESULT');

        if ($COMBINATIONSEO_CONCATENATE_RESULT == 'true') {

            $cms_result = parent :: getCMSContent($idCms, $idLang, $idShop);

            $final_result = array ('content' => $partial_result['content'] . $cms_result['content']);
        }
        else {
            $final_result = $partial_result;
        }

        return $final_result;
    }
}