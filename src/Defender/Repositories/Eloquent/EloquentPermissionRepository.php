<?php namespace Artesaos\Defender\Repositories\Eloquent;

use Artesaos\Defender\Exceptions\PermissionExistsException;
use Artesaos\Defender\Permission;
use Artesaos\Defender\Contracts\Repositories\PermissionRepository;
use Illuminate\Contracts\Foundation\Application;

/**
 * Class EloquentPermissionRepository
 *
 * @package Artesaos\Defender\Repositories\Eloquent
 */
class EloquentPermissionRepository extends AbstractEloquentRepository implements PermissionRepository {

	/**
	 * @param Application $app
	 * @param Permission  $model
	 */
	public function __construct(Application $app, Permission $model)
	{
		parent::__construct($app, $model);
	}

	/**
	 * Create a new permission using the given name
	 *
	 * @param $permissionName
	 * @param null $displayName
	 * @return static
	 * @throws PermissionExistsException
	 */
	public function create($permissionName, $displayName = null)
	{
		if ( ! is_null($this->findByName($permissionName)))
		{
			throw new PermissionExistsException('The permission '.$permissionName.' already exists'); // TODO: add translation support
		}

		// Do we have a display_name set?
		is_null($displayName) and $displayName = $permissionName;

		return $permission = $this->model->create([
			'name'  => $permissionName,
			'display_name' => $displayName
		]);
	}

}