<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Activities Controller
 *
 * @property \App\Model\Table\ActivitiesTable $Activities
 */
class ActivitiesController extends AppController
{


    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $tasksModel = $this->loadModel('Tasks');
        $user = $this->Auth->user();
        $activity = $this->Activities->find()->where(['user_id' => $user['id']])->contain(['Users']);
        if($activity->isEmpty()){ // 研究テーマを登録していない場合は登録画面へ遷移
          return $this->redirect(['action' => 'add', $user['id']]);
        } else {
          $result = $activity->first();
        }
        $plans = $this->Activities->Plans->find()->where(['activity_id' => $result['id']])->order(['Plans.created' => 'ASC']);
        $tasks = $tasksModel->find()->where(['user_id' => $user['id']])->contain(['Subtasks']);
        $this->set(compact('result', 'plans', 'tasks'));
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $activity = $this->Activities->newEntity();
        if ($this->request->is('post')) {
            $activity = $this->Activities->patchEntity($activity, $this->request->data);
            if ($this->Activities->save($activity)) {
                $this->Flash->success(__('The activity has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The activity could not be saved. Please, try again.'));
        }
        $users = $this->Activities->Users->find('list', ['limit' => 200]);
        $this->set(compact('activity', 'users'));
        $this->set('_serialize', ['activity']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Activity id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $activity = $this->Activities->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $activity = $this->Activities->patchEntity($activity, $this->request->data);
            if ($this->Activities->save($activity)) {
                $this->Flash->success(__('The activity has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The activity could not be saved. Please, try again.'));
        }
        $users = $this->Activities->Users->find('list', ['limit' => 200]);
        $this->set(compact('activity', 'users'));
        $this->set('_serialize', ['activity']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Activity id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $activity = $this->Activities->get($id);
        if ($this->Activities->delete($activity)) {
            $this->Flash->success(__('The activity has been deleted.'));
        } else {
            $this->Flash->error(__('The activity could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function isAuthorized($user)
    {
        $action = $this->request->params['action'];
        // index, add, edit, deleteページは誰でも見れる
        if (in_array($action, ['index','add','edit','delete','logout'])) {
            return true;
        }
        if (isset($user['role']) && $user['role'] === 'admin') {
            return true;
        }
        // リクエストされたページのUser idと
        // ログイン中のUseridが一致する場合はその他のアクションも許可する
        $id = $this->request->params['pass'][0];
        $current_user = $this->Activities->get($id);
        if ($current_user->user_id == $user['id']) {
            return true;
        }else{
            $this->Flash->error(__('他のユーザーのファイルは操作できません'));
            return false;
        }
        $this->Flash->error(__('管理者の機能です'));
        return false;
    }
}
