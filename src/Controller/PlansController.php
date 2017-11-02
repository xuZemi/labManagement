<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Plans Controller
 *
 * @property \App\Model\Table\PlansTable $Plans
 */
class PlansController extends AppController
{
    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Auth->user();
        $activity = $this->Plans->Activities->find()->where(['user_id' => $user['id']])->first();
        $plan = $this->Plans->newEntity();
        if ($this->request->is('post')) {
            $plan = $this->Plans->patchEntity($plan, $this->request->data);
            if ($this->Plans->save($plan)) {
                $this->Flash->success(__('ToDoを追加しました。'));

                return $this->redirect(['controller' => 'Activities', 'action' => 'index']);
            }
            $this->Flash->error(__('ToDoを追加できませんでした。もう一度試してください。'));
        }
        $activities = $this->Plans->Activities->find('list', ['limit' => 200]);
        $this->set(compact('plan', 'activities', 'activity'));
        $this->set('_serialize', ['plan']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Plan id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $plan = $this->Plans->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
          $plan = $this->Plans->patchEntity($plan, $this->request->data);
          if ($this->request->data['status'] == 1) {
            $tasksModel = $this->loadModel('Tasks');
            $user = $this->Auth->user();
            // Tasksテーブルのための配列を作る
            $taskList = ['description' => $this->request->data['todo'], 'user_id' => $user['id'],'status' => 0, 'weight' => $this->request->data['weight']];
            $task = $tasksModel->newEntity();
            $task = $tasksModel->patchEntity($task, $taskList);

            if ($tasksModel->save($task) && $this->Plans->save($plan)) { // ToDoをタスクへと変更し、Plansのstatusを1へと更新する
                $this->Flash->success(__('ToDoをタスクへ変更しました。ToDoの開始時間と締め切り時間を設定してください'));
                return $this->redirect(['controller' => 'Activities', 'action' => 'index']);
            }
            $this->Flash->error(__('ToDoをタスクへ変更できませんでした。'));
          } else {
            if ($this->Plans->save($plan)) {
                $this->Flash->success(__('ToDoが登録されました'));
                return $this->redirect(['controller' => 'Activities', 'action' => 'index']);
            }
            $this->Flash->error(__('ToDoが登録できませんでした。もう一度試してみてください。'));
          }
        }
        $activities = $this->Plans->Activities->find('list', ['limit' => 200]);
        $this->set(compact('plan', 'activities'));
        $this->set('_serialize', ['plan']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Plan id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $plan = $this->Plans->get($id);
        if ($this->Plans->delete($plan)) {
            $this->Flash->success(__('ToDoを削除しました。'));
        } else {
            $this->Flash->error(__('ToDoを削除できませんでした。もう一度試してください。'));
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