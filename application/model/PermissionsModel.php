<?php
/**
* Permissions model, interface for acl handle
*/
class PermissionsModel {
	
	const PERM_CAN_MANAGE_FORUMS = 0;
	const PERM_CAN_ACCESS_ADMINCP = 0;
	const PERM_CAN_MANAGE_USERS = 0;
	const PERM_CAN_EDIT_AVATAR = 0;
	const PERM_CAN_EDIT_USERNAME = 0;

	private static $make;
	private $handle;

	public function __construct() {
		$this->handle = new Acl_handle();
	}

	public static function make() {
		if (!self::$make) {
			self::$make = new PermissionsModel();
		}

		return self::$make;
	}

	public function getPermKeyFromId($perm_id) {
		return $this->handle->getPermKeyFromId($perm_id);
	}
	
	public function getPermNameFromId($perm_id) {
		return $this->handle->getPermNameFromId($perm_id);
	}
	
	public function getRoleNameFromId($role_id) {
		return $this->handle->getRoleNameFromId($role_id);
	}
	
	public function getRoleDescFromId($role_id) {
		return $this->handle->getRoleDescFromId($role_id);
	}
	
	public function getUserRoles() {
		return $this->handle->getUserRoles();
	}

	public function getAllRoles($format = 'ids') {
		return $this->handle->getAllRoles($format);
	}

	public function countUsersInRole($role_id) {
		return $this->handle->countUsersInRole($role_id);
	} 
	
	public function getUsersInRole($role_id) {
		return $this->handle->getUsersInRole($role_id);
	}
	
	public function doesRoleExist($role_id) {
		return $this->handle->doesRoleExist($role_id);
	}
	
	public function getAllPerms($format = 'ids') {
		return $this->handle->getAllPerms($format);
	}
	
	public function getRolePerms($role) {
		return $this->handle->getRolePerms($role);
	}
	
	public function getUserPerms($user_id) {
		return $this->handle->getUserPerms($user_id);
	}

	public function userHasRole($role_id) {
		return $this->handle->userhasRole($role_id);
	}
	
	public function hasPermission($perm_key) {
		return $this->handle->hasPermission($perm_key);
	} 

}