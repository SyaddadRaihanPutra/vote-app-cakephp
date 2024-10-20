<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Users Controller
 *
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Users->find();
        $users = $this->paginate($query);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, contain: []);
        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function daftar()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $user->role = 'siswa';
            $user->password = md5($user->password);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        // Tentukan action yang tidak memerlukan autentikasi secara manual
        $allowedActions = ['login', 'register', 'panel'];

        // Cek apakah action saat ini memerlukan autentikasi
        if (!in_array($this->request->getParam('action'), $allowedActions)) {
            // Cek apakah user sudah login
            if (!$this->request->getSession()->read('Auth.User')) {
                // Redirect ke halaman login jika belum login
                return $this->redirect(['controller' => 'Users', 'action' => 'login']);
            }
        }
    }

    public function login()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $param = $this->request->getData();
            $password = $param['password'];
            $query = $this->Users->find()->where(['nis' => $param['nis'], 'password' => md5($password)])->first();
            if (empty($query)) {
                $this->Flash->error(__('NIS or password is incorrect'));
                return $this->redirect(['action' => 'login']);
            }

            $this->request->getSession()->write('Auth.User', [
                'id' => $query->id,
                'nis' => $query->nis,
                'role' => $query->role,
                'username' => $query->username,
            ]);
            $this->Flash->success(__('Login successful'));
            return $this->redirect(['controller' => 'dashboard', 'action' => 'index']);
        }

        if ($this->request->getSession()->read('Auth.User')) {
            // Jika sudah login, redirect ke halaman dashboard
            return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
        }

        $this->set(compact('user'));
    }

    public function panel()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $param = $this->request->getData();
            $password = $param['password'];
            $query = $this->Users->find()->where(['username' => $param['username'], 'password' => md5($password)])->first();
            if (empty($query)) {
                $this->Flash->error(__('NIS or password is incorrect'));
                return $this->redirect(['action' => 'panel']);
            }

            $this->request->getSession()->write('Auth.User', [
                'id' => $query->id,
                'role' => $query->role,
                'username' => $query->username,
            ]);
            $this->Flash->success(__('Login successful'));
            return $this->redirect(['controller' => 'dashboard', 'action' => 'index']);
        }

        if ($this->request->getSession()->read('Auth.User')) {
            // Jika sudah login, redirect ke halaman dashboard
            return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
        }

        $this->set(compact('user'));
    }

    public function logout()
    {
        $this->request->getSession()->delete('Auth.User');
        $this->Flash->success(__('Logout successful'));
        return $this->redirect(['action' => 'login']);
    }
}
