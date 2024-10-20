<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Master Controller
 *
 */
class MasterController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('admin');
    }
    public function users()
    {
        $query = $this->fetchTable('Users')->find();
        $users = $this->paginate($query); // Menggunakan paginate untuk membagi hasil

        // Kirim data ke view
        $this->set(compact('users'));
    }
}
