<?php

namespace Robust\RealEstate\Models;

use Robust\Core\Models\BaseModel;

/**
 * Class CoreSetting
 * @package App
 */
class CoreSetting extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'real_estate_settings';

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'package_name',
        'type',
        'values',
        'created_at',
        'updated_at'
    ];
}
