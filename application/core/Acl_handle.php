<?php
/**
 * Access Control List Handle
 * This is for user permissions, roles etc.
 */

 class Acl_Handle {
    
    private $perms = array();
    private $current_user_id = 0; // ID of current user
    private $user_roles = array();
    
    public function __construct($user_id = '') {
        if ($user_id != '') {
            $this->current_user_id = intval($user_id);
        }
        else {
            $this->current_user_id = Session::get('user_id');
        }
        
        $this->user_roles = $this->getUserRoles('ids');
        $this->buildACL();
    }
    
    private function buildACL() {
        if (count($this->user_roles) > 0) {
            $this->perms = array_merge($this->perms, $this->getRolePerms($this->user_roles));
        }
        $this->perms = array_merge($this->perms, $this->getUserPerms($this->current_user_id));
    }
    
    private function getPermKeyFromId($perm_id) {
        $sql = "SELECT perm_key FROM permissions WHERE id = :perm_id LIMIT 1";
        $database = DatabaseFactory::getFactory()->getConnection();
        $data = $database->prepare($sql);
        $data->bindValue(':perm_id', intval($perm_id), PDO::PARAM_INT);
        $data->execute();
        $row = $data->fetch();
        return current((array)$row);
    }
    
    private function getPermNameFromId($perm_id) {
        $sql = "SELECT perm_name FROM permissions WHERE id = :perm_id LIMIT 1";
        $database = DatabaseFactory::getFactory()->getConnection();
        $data = $database->prepare($sql);
        $data->bindValue(':perm_id', intval($perm_id), PDO::PARAM_INT);
        $data->execute();
        $row = $data->fetch();
        return current((array)$row);
    }
    
    public function getRoleNameFromId($role_id) {
        $sql = "SELECT role_name FROM roles WHERE id = :role_id LIMIT 1";
        $database = DatabaseFactory::getFactory()->getConnection();
        $data = $database->prepare($sql);
        $data->bindValue(':role_id', intval($role_id), PDO::PARAM_INT);
        $data->execute();
        $row = $data->fetch();
        return current((array)$row);
    }
    
    public function getRoleDescFromId($role_id) {
      $sql = "SELECT role_description FROM roles WHERE id = :role_id LIMIT 1";
      $database = DatabaseFactory::getFactory()->getConnection();
      $data = $database->prepare($sql);
      $data->bindValue(':role_id', intval($role_id), PDO::PARAM_INT);
      $data->execute();
      $row = $data->fetch();
      return current((array)$row);
    }
    
    public function getUserRoles() {
        $sql = "SELECT * FROM user_roles WHERE user_id = :user_id ORDER BY add_date ASC";
        $database = DatabaseFactory::getFactory()->getConnection();
        $data = $database->prepare($sql);
        $data->bindValue(':user_id', $this->current_user_id, PDO::PARAM_INT);
        $data->execute();
        $resp = array();
        while ($row = $data->fetch()) {
            $resp[] = $row->role_id;
        }
        return $resp;
    }
    
    public function getAllRoles($format = 'ids') {
        $format = strtolower($format);
        $sql = "SELECT * FROM roles ORDER BY role_name ASC";
        $database = DatabaseFactory::getFactory()->getConnection();
        $data = $database->prepare($sql);
        $data->execute();
        $resp = array();
        while ($row = $data->fetch()) {
            if ($format == 'full') {
                $resp[] = array('id' => $row->id, 'name' => $row->role_name, 'user_count' => $this->countUsersInRole($row->id));
            }
            else {
                $resp[] = $row->id;
            }
        }
        return $resp;
    }
    
    public function countUsersInRole($role_id) {
         $sql = "SELECT COUNT(user_id) FROM user_roles WHERE role_id = :role_id";
         $database = DatabaseFactory::getFactory()->getConnection();
         $data = $database->prepare($sql);
         $data->bindValue(':role_id', intval($role_id), PDO::PARAM_INT);
         $data->execute();
         
         $result = $data->fetch(PDO::FETCH_NUM);
         
         return current((array)$result);
    }
    
    public function getUsersInRole($role_id) {
      $sql = "SELECT user_id FROM user_roles WHERE role_id = :role_id";
      $database = DatabaseFactory::getFactory()->getConnection();
      $data = $database->prepare($sql);
      $data->bindValue(':role_id', intval($role_id), PDO::PARAM_INT);
      $data->execute();
      $users = array();
      while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
         $users[] = UserModel::getPublicProfileOfUser($row['user_id']);
      }
      return $users;
    }
    
    public function doesRoleExist($role_id) {
         $sql = "SELECT COUNT(role_name) FROM roles WHERE id = :role_id LIMIT 1";
         $database = DatabaseFactory::getFactory()->getConnection();
         $data = $database->prepare($sql);
         $data->bindValue(':role_id', intval($role_id), PDO::PARAM_INT);
         $data->execute();
         $result = $data->fetch(PDO::FETCH_NUM);
         
         if (current((array)$result) == 1) {
            return true;
         }
         else {
            return false;
         }
    }
    
    public function getAllPerms($format = 'ids') {
        $sql = "SELECT * FROM permissions ORDER BY perm_name ASC";
        $database = DatabaseFactory::getFactory()->getConnection();
        $data = $database->prepare($sql);
        $data->execute();
        $resp = array();
        while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
            if ($format == 'full') {
                $resp[$row['perm_key']] = array('id' => $row['id'], 'name' => $row['perm_name'], 'key' => $row['perm_key']);
            }
            else {
                $resp[] = $row['id'];
            }
        }
        return $resp;
    }
    
    public function getRolePerms($role) {
        if (is_array($role)) {
            $sql = "SELECT * FROM role_perms WHERE role_id IN (" . implode(',', array_fill(0, count($role), '?')) . ")
                    ORDER BY id ASC";
        }
        else {
            $sql2 = "SELECT * FROM role_perms WHERE role_id = :role ORDER BY id ASC";
        }
        
        $database = DatabaseFactory::getFactory()->getConnection();
        if (isset($sql)) {
            $data = $database->prepare($sql);
            foreach ($role AS $k => $r) {
                $data->bindValue(($k + 1), $r);
            }
            $data->execute();
        }
        else {
            $data = $database->prepare($sql2);
            $data->bindValue(':role', intval($role), PDO::PARAM_INT);
            $data->execute();
        }
        
        $perms = array();
        while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
            $perm_key = strtolower($this->getPermKeyFromId($row['perm_id']));
            if ($perm_key == '') {
                continue;
            }
            if ($row['value'] === '1') {
                $hasPermission = true;
            }
            else {
                $hasPermission = false;
            }
            $perms[$perm_key] = array('perm'       => $perm_key,
                                      'inheritted' => true,
                                      'value'      => $hasPermission,
                                      'name'       => $this->getPermNameFromId($row['perm_id']),
                                      'id'         => $row['perm_id']);
        }
        return $perms;
    }
    
    private function getUserPerms($user_id) {
        $sql = "SELECT * FROM user_perms WHERE user_id = :user_id ORDER BY add_date ASC";
        $database = DatabaseFactory::getFactory()->getConnection();
        $data = $database->prepare($sql);
        $data->bindValue(':user_id', intval($user_id), PDO::PARAM_INT);
        $data->execute();
        $perms = array();
        while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
            $perm_key = strtolower($this->getPermKeyFromId($row['perm_id']));
            if ($perm_key == '') {
                continue;
            }
            if ($row['value'] == '1') {
                $hasPermission = true;
            }
            else {
                $hasPermission = false;
            }
            $perms[$perm_key] = array('perm'       => $perm_key,
                                      'inheritted' => true,
                                      'value'      => $hasPermission,
                                      'name'       => $this->getPermNameFromId($row['perm_id']),
                                      'id'         => $row['perm_id']);
        }
        return $perms;
    }
    
    public function userHasRole($role_id) {
        foreach ($this->user_roles AS $key => $value) {
            if (intval($value) === intval($role_id)) {
                return true;
            }
        }
        return false;
    }
    
    public function hasPermission($perm_key) {
        $perm_key = strtolower($perm_key);
        if (array_key_exists($perm_key, $this->perms)) {
            if ($this->perms[$perm_key]['value'] === '1' OR $this->perms[$perm_key]['value'] === true) {
                return true;
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }
 }
 