<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Dashboard Controller
 *
 */
class DashboardController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Authentication.Authentication');
    }
    public function index()
    {
        $role = $this->request->getSession()->read('Auth.User.role');
        if ($role == 'admin') {
            return $this->redirect(['action' => 'admin']);
        }

        // Redirect atau tampilkan halaman lainnya jika perlu
        return $this->redirect(['action' => 'siswa']);
        $this->viewBuilder()->setLayout(false);
    }

    public function admin()
    {
        $this->viewBuilder()->setLayout('admin');
    }

    public function siswa()
    {
        $this->viewBuilder()->setLayout('siswa');
    }

    /**
     * View method
     *
     * @param string|null $id Dashboard id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $dashboard = $this->Dashboard->get($id, contain: []);
        $this->set(compact('dashboard'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $dashboard = $this->Dashboard->newEmptyEntity();
        if ($this->request->is('post')) {
            $dashboard = $this->Dashboard->patchEntity($dashboard, $this->request->getData());
            if ($this->Dashboard->save($dashboard)) {
                $this->Flash->success(__('The dashboard has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The dashboard could not be saved. Please, try again.'));
        }
        $this->set(compact('dashboard'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Dashboard id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $dashboard = $this->Dashboard->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dashboard = $this->Dashboard->patchEntity($dashboard, $this->request->getData());
            if ($this->Dashboard->save($dashboard)) {
                $this->Flash->success(__('The dashboard has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The dashboard could not be saved. Please, try again.'));
        }
        $this->set(compact('dashboard'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Dashboard id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $dashboard = $this->Dashboard->get($id);
        if ($this->Dashboard->delete($dashboard)) {
            $this->Flash->success(__('The dashboard has been deleted.'));
        } else {
            $this->Flash->error(__('The dashboard could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
