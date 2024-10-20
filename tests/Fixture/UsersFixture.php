<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'username' => 'Lorem ipsum dolor sit amet',
                'nis' => 1,
                'password' => 'Lorem ipsum dolor sit amet',
                'role' => 'Lorem ipsum dolor ',
                'created' => '2024-10-20 10:14:14',
                'modified' => '2024-10-20 10:14:14',
            ],
        ];
        parent::init();
    }
}
