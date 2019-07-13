<?php

namespace Deputy;

use Deputy\Role;
use Deputy\User;

/**
 * RoleHierarchy defines a role hierarchy.
 * A user hierarchy is based on the role hierarchy.
 *
 * @author Shay Leydon <shayleydon@gmail.com>
 */
class RoleHierarchy
{
    private $roles;
    private $users;
    private $hierarchy;

    /**
     * @param array $roles An array of objects defining the roles
     * @param array $users An array of objects defining the users
     */
    public function __construct(array $roles = [], array $users = [])
    {
        $this->hierarchy = [];
        $this->setRoles($roles);
        $this->setUsers($users);
    }

    /**
     * @param array $roles An array of objects defining the roles
     */
    public function setRoles(array $roles)
    {
        foreach($roles as $r){
            $role = new Role($r->Id, $r->Name, $r->Parent);
            $this->roles[$role->getId()] = $r;
            $this->hierarchy[$role->getId()] = $this->hierarchy[$role->getId()] ?? [];

            if($role->getParentId()){
                $this->hierarchy[$role->getParentId()][] = $role->getId();
            }
        }
        $this->buildRoleHierarchy();
    }

    /**
     * @param array $users An array of objects defining the users
     */
    public function setUsers(array $users)
    {
        foreach($users as $u){
            $user = new User($u->Id, $u->Name, $u->Role);
            $this->users[$user->getId()] = $u;
        }
    }
    
    /**
     * Map subordinates recursively to build a complete role hierarchy
     */
    private function buildRoleHierarchy()
    {
        foreach($this->hierarchy as $parent => $stackSubOrdinates){
            while($stackSubOrdinates){
                $id = array_shift($stackSubOrdinates);
                $stackSubOrdinates = array_merge($stackSubOrdinates, $this->hierarchy[$id]);
                $this->hierarchy[$parent] = array_merge($this->hierarchy[$parent], $this->hierarchy[$id]);
            }
        }
    }

    /**
     * Returns an array of a users subordinates.
     *
     * @param int $userId
     * @return array
     */
    public function getSubOrdinates(int $userId)
    {
        $subOrdinates = [];
        $roleId = $this->users[$userId]->Role;

        foreach($this->hierarchy[$roleId] as $id){
            foreach($this->users as $user){
                if($user->Role == $id){
                    $subOrdinates[] = $user;
                }
            }
        }
        return $subOrdinates;
    }
}