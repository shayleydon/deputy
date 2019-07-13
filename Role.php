<?php

namespace Deputy;

/**
 * Role is a class representation of a role.
 */
class Role
{
    private $id;
    private $name;
    private $parentId;

    public function __construct(int $id, string $name, int $parentId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->parentId = $parentId;
    }

    /**
     * Returns the role id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the role name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Returns the parent role id.
     *
     * @return int
     */
    public function getParentId()
    {
        return $this->parentId;
    }
}
