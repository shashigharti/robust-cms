<?php
namespace Robust\Pages\Models;

use Illuminate\Database\Eloquent\Model;
use Robust\Core\Models\BaseModel;

/**
 * Class Page
 * @package Robust\Pages\Models
 */
class Page extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'pages';

    /**
     * @var boolean
     */
    public $timestamps = true;

    /**
     * @var array
     */
    public $searchable = ['name', 'slug', 'content', 'name_ne', 'excerpt', 'content_ne'];
    /**
     * @var string
     */
    protected $namespace = 'Robust\Pages\Models\Page';

    /**
     * @var string
     */

    protected $fillable = [
        'name',
        'content',
        'slug',
        'excerpt',
        'category_id',
        'excerpt_ne',
        'content_ne',
        'name_ne',
        'thumbnail',
        'created_at',
        'updated_at',
        'status',
        'meta_title',
        'meta_description',
        'meta_keywords'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function downloads()
    {
        return $this->hasMany('Robust\Pages\Models\PageDownload', 'page_id');
    }

    public function category()
    {
        return $this->belongsTo('Robust\Pages\Models\Category', 'category_id');
    }

}
