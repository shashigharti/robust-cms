<?php
namespace Robust\Leads\Repositories\Admin;

use Robust\Core\Repositories\Traits\CommonRepositoryTrait;
use Robust\Core\Repositories\Traits\CrudRepositoryTrait;
use Robust\Core\Repositories\Traits\SearchRepositoryTrait;
use Robust\Leads\Models\UserSearch;

/**
 * Class UserSearchRepository
 * @package Robust\Leads\Repositories\Admin
 */
class UserSearchRepository
{
    use CrudRepositoryTrait, SearchRepositoryTrait, CommonRepositoryTrait;
    /**
     * @var UserSearch
     */
    protected $model;

    /**
     * UserSearchRepository constructor.
     * @param UserSearch $model
     */
    public function __construct(UserSearch $model)
    {
        $this->model=$model;
    }
}
