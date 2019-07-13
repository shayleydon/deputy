<?php

namespace Deputy\Tests;

use Deputy\RoleHierarchy;
use PHPUnit\Framework\TestCase;

class RoleHierarchyTest extends TestCase
{
    private $roles;
    private $users;
 
    protected function setUp() : void
    {
        $this->roles = [
            (object) [
                'Id' => 1,
                'Name' => 'System Administrator',
                'Parent' => 0,
            ],
            (object) [
                'Id' => 2,
                'Name' => 'Location Manager',
                'Parent' => 1,
            ],
            (object) [
                'Id' => 3,
                'Name' => 'Supervisor',
                'Parent' => 2,
            ],
            (object) [
                'Id' => 4,
                'Name' => 'Employee',
                'Parent' => 3,
            ],
            (object) [
                'Id' => 5,
                'Name' => 'Trainer',
                'Parent' => 3,
            ],
        ];

        $this->users = [
            (object) [
                'Id' => 1,
                'Name' => 'Adam Admin',
                'Role' => 1,
            ],
            (object) [
                'Id' => 2,
                'Name' => 'Emily Employee',
                'Role' => 4,
            ],
            (object) [
                'Id' => 3,
                'Name' => 'Sam Supervisor',
                'Role' => 3,
            ],
            (object) [
                'Id' => 4,
                'Name' => 'Mary Manager',
                'Role' => 2,
            ],
            (object) [
                'Id' => 5,
                'Name' => 'Steve Trainer',
                'Role' => 5,
            ],
        ];
    }

    public function provideExpected()
    {
        return [
            [
                ['UserId' => 3],
                [
                    (object) [
                        'Id' => 2,
                        'Name' => 'Emily Employee',
                        'Role' => 4,
                    ],
                    (object) [
                        'Id' => 5,
                        'Name' => 'Steve Trainer',
                        'Role' => 5,
                    ],
                ],
            ],
            [
                ['UserId' => 1],
                [
                    (object) [
                        'Id' => 2,
                        'Name' => 'Emily Employee',
                        'Role' => 4,
                    ],
                    (object) [
                        'Id' => 3,
                        'Name' => 'Sam Supervisor',
                        'Role' => 3,
                    ],
                    (object) [
                        'Id' => 4,
                        'Name' => 'Mary Manager',
                        'Role' => 2,
                    ],
                    (object) [
                        'Id' => 5,
                        'Name' => 'Steve Trainer',
                        'Role' => 5,
                    ],
                ],
            ],
            [
                ['UserId' => 2],
                [],
            ],
            [
                ['UserId' => 4],
                [
                    (object) [
                        'Id' => 2,
                        'Name' => 'Emily Employee',
                        'Role' => 4,
                    ],
                    (object) [
                        'Id' => 3,
                        'Name' => 'Sam Supervisor',
                        'Role' => 3,
                    ],
                    (object) [
                        'Id' => 5,
                        'Name' => 'Steve Trainer',
                        'Role' => 5,
                    ],
                ],
            ],
            [
                ['UserId' => 5],
                [],
            ],
        ];
    }

    /**
     * @dataProvider provideExpected
     *
     * @param array $collection
     * @param array $expected
     */
    public function test($collection, $expected)
    {
        $service = new RoleHierarchy($this->roles, $this->users);

        $this->assertEqualsCanonicalizing($expected, $service->getSubOrdinates($collection['UserId']));
    }

}