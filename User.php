<?php

namespace Deputy;

/**
 * User is a class representation of a user.
 */
class User
{
    private $id;
    private $name;
    private $roleId;

    public function __construct(int $id, string $name, int $roleId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->roleId = $roleId;
    }

    /**
     * Returns the user id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the user name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Returns the user role id.
     *
     * @return int
     */
    public function getRoleId()
    {
        return $this->roleId;
    }

}
