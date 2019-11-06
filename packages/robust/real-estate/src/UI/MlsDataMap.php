<?php
namespace Robust\RealEstate\UI;

use Robust\Core\UI\Core\BaseUI;

/**
 * Class MlsUser
 * @package Robust\Mls\UI
 */
class MlsDataMap extends BaseUI
{
    /**
     * @var string
     */
    protected $route_name = "mlsuser";




    public function getRoute($model)
    {
        return ['admin.mlsuser.store'];
    }

    /**
     * @return string
     */
    public function getModel()
    {
        return 'Robust\RealEstate\Models\MlsDataMap';
    }

    public function getMethod($model)
    {
        return 'post';
    }

}
