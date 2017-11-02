<div class="activities content container">
  <div class="row text-center">
    <div class="col-xs-12">
        <h1 class="theme">
          <div class="themeHead">
            <span class="font-20"><?= $user['nickname'].__('さんの研究テーマ') ?><?= $this->Html->link(__('研究テーマの修正'), ['action' => 'edit',$result['id']], ['class' => 'font-14']); ?></span>
          </div>
          <?= $result['theme']; ?>
        </h1>
    </div>
  </div>
  <div class="row text-center">
    <div class="col-xs-12">
      <h2><?= __('本日のタスク') ?></h2>
      <hr class="today-plan-hr">
      <ul>
        <div class="text-left">
          <?php foreach($todayTasks as $todayTask): ?>
            <li>
              <?php date('Y-m-d') <= $todayTask['endtime']->i18nFormat('YYYY-MM-dd') ? print '<div>': print '<div class="limitOver">'; ?>
                <span class="font-20"><?= $todayTask['description'] ?></span>
                <span class="font-14"><?= $todayTask['starttime']->i18nFormat('YYYY-MM-dd').$week[date('w', strtotime($todayTask['starttime']))].__('〜').$todayTask['endtime']->i18nFormat('YYYY-MM-dd').$week[date('w', strtotime($todayTask['endtime']))] ?></span>
                <?= $this->Html->link(__('設定'), ['controller' => 'Tasks','action' => 'edit',$todayTask['id']]); ?>
              </div>
            </li>
            <ul>
              <?php foreach($todayTask['subtasks'] as $todaySubtask): ?>
                <?php $startSubtask = $todaySubtask['starttime']->i18nFormat('YYYY-MM-dd'); ?>
                <?php $endSubtask = $todaySubtask['endtime']->i18nFormat('YYYY-MM-dd'); ?>
                <?php $startWeek = $week[date('w', strtotime($todaySubtask['starttime']))] ?>
                <?php $endWeek = $week[date('w', strtotime($todaySubtask['endtime']))] ?>
                <li>
                <?php if(date('Y-m-d H:i:s') >= $startSubtask && date('Y-m-d H:i:s') <= $endSubtask): ?>
                    <span class="font-14 color-<?= $todaySubtask['status']?>"><?= $todaySubtask['subdescription'] ?></span>
                    <p><span class="font-14 color-<?= $todaySubtask['status']?>"><?= $startSubtask.$startWeek.__('〜').$endSubtask.$endWeek ?></span>
                <?php elseif(date('Y-m-d H:i:s') <= $startSubtask): ?>
                    <span class="font-14 color-<?= $todaySubtask['status']?>"><?= $todaySubtask['subdescription'] ?></span>
                    <p><span class="font-14 color-<?= $todaySubtask['status']?>"><?= $startSubtask.$startWeek.__('〜').$endSubtask.$endWeek.__("※まだ開始期間にはいっていません") ?></span>
                <?php else: ?>
                  <?php if($todaySubtask['status'] == 1): ?>
                    <span class="font-14 color-<?= $todaySubtask['status']?>"><?= $todaySubtask['subdescription'] ?></span>
                    <p><span class="font-14 color-<?= $todaySubtask['status']?>"><?= $startSubtask.$startWeek.__('〜').$endSubtask.$endWeek.__("※このサブタスクは完了しています") ?></span>
                  <?php else: ?>
                    <span class="font-14 limitOver"><?= $todaySubtask['subdescription'] ?></span>
                    <p><span class="font-14 limitOver"><?= $startSubtask.$startWeek.__('〜').$endSubtask.$endWeek.__("※期限が切れています。延長するか、サブタスクを終わらせてください") ?></span>
                  <?php endif ?>
                <?php endif ?>
                  <?= $this->Html->link(__('設定'), ['controller' => 'Subtasks','action' => 'edit',$todaySubtask['id']], ['class' => "status{$todaySubtask['status']}"]); ?></p>
                </li>
              <?php endforeach ?>
            </ul>
          <?php endforeach ?>
        </div>
      </ul>
    </div>
  </div>
  <hr class="today-plan-hr">
  <div class="row text-center">
    <div class="col-md-4">
      <div class="box box-todo">
        <h2><?= __('ToDo') ?></h2>
        <?= $this->Html->link(__('ToDoの登録'), ['controller' => 'Plans', 'action' => 'add']); ?>
        <hr>
        <div class="pad-20">
          <ul>
            <div class="text-left">
            <?php foreach($plans as $plan): ?>
              <?php if($plan['status'] != 1): ?>
                <li><span class="font-20"><?= $plan['todo'] ?></span><?= $this->Html->link(__('設定(ToDoへ変更する)'), ['controller' => 'Plans','action' => 'edit',$plan['id']]); ?></li>
              <?php endif ?>
            <?php endforeach ?>
            </div>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="box box-task">
        <h2><?= __('タスク') ?></h2>
        <?= $this->Html->link(__('タスクの登録'), ['controller' => 'Tasks', 'action' => 'add']); ?>
        <hr>
        <div class="pad-20">
          <ul>
            <div class="text-left">
            <?php foreach($tasks as $task): ?>
              <?php if($task['status'] != 1): ?>
                <li>
                  <?php if(isset($task['starttime']) && isset($task['endtime'])): ?>
                      <span class="font-20"><?= $task['description'] ?></span>
                      <?= $this->Html->link(__('設定'), ['controller' => 'Tasks','action' => 'edit',$task['id']]); ?></p>
                      <p><span class="font-14">
                        <?= $task['starttime']->i18nFormat('YYYY-MM-dd').$week[date('w', strtotime($task['starttime']))].__('〜').$task['endtime']->i18nFormat('YYYY-MM-dd').$week[date('w', strtotime($task['endtime']))] ?>
                      </span>
                      <?php if(date('Y-m-d') > $task['endtime']->i18nFormat('YYYY-MM-dd')): ?>
                        <p><?= __("※期限が切れています。延長してください") ?></p>
                      <?php endif ?>
                  <?php else: ?>
                    <span class="font-20"><?= $task['description'] ?></span>
                    <?= $this->Html->link(__('設定'), ['controller' => 'Tasks','action' => 'edit',$task['id']]); ?>
                  <?php endif ?>
                </li>
              <?php endif ?>
            <?php endforeach ?>
            </div>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="box box-subtask">
        <h2><?= __('サブタスク') ?></h2>
        <?= $this->Html->link(__('サブタスクの登録'), ['controller' => 'Subtasks', 'action' => 'add']); ?>
        <hr>
        <div class="pad-20">
          <ul>
            <div class="text-left">
            <?php foreach($tasks as $key => $task): ?>
              <?php if(count($task['subtasks']) != 0): ?>
                <?php if(isset(array_count_values($subList[$key])[0])): ?>
                  <li>
                    <span class="font-20"><?= $task['description'] ?></span>
                  </li>
                  <ul>
                    <?php foreach($task['subtasks'] as $subtask): ?>
                        <li>
                          <span class="font-14"><?= $subtask['subdescription'] ?></span>
                          <?= $this->Html->link(__('設定'), ['controller' => 'Subtasks','action' => 'edit',$subtask['id']], ['class' => "status{$subtask['status']}"]); ?></p>
                          <p><span class="font-14">
                            <?= $subtask['starttime']->i18nFormat('YYYY-MM-dd').$week[date('w', strtotime($subtask['starttime']))].__('〜').$subtask['endtime']->i18nFormat('YYYY-MM-dd').$week[date('w', strtotime($subtask['endtime']))] ?>
                          </span>
                          <?php (date('Y-m-d') > $subtask['endtime']->i18nFormat('YYYY-MM-dd') && $subtask['status'] != 1) ? print '※期限が切れています。延長してください。' : ''; ?>
                        </li>
                    <?php endforeach ?>
                  </ul>
                <?php endif ?>
              <?php endif ?>
            <?php endforeach ?>
            </div>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="row text-center">
    <div class="col-xs-12">
      <h2><?= __('みんなの進捗度') ?></h2>
      <hr>
      <h3><strong><?= __('〇〇の試みと応用') ?></strong></h3>
    </div>
  </div>
  <div class="row text-center">
    <div class="col-xs-12">
      <h2><?= __('解決済みのタスク') ?></h2>
      <hr>
      <div class="endTask text-left">
      <ul>
        <?php foreach($tasks as $key => $task): ?>
          <?php if(count($task['subtasks']) != 0): ?>
            <?php if(isset(array_count_values($subList[$key])[1])): ?>
              <li><span class="font-20"><?= $task['description'] ?></span></li>
              <ul>
                <?php foreach($task['subtasks'] as $subtask): ?>
                  <?php if($subtask['status'] == 1): ?>
                    <li>
                      <span class="font-18 sub-color-<?= $subtask['status']?>"><?= $subtask['subdescription'] ?></span>
                      <span class="font-14 color-<?= $subtask['status']?>">
                        <?= $subtask['starttime']->i18nFormat('YYYY-MM-dd').$week[date('w', strtotime($subtask['starttime']))].__("〜").$subtask['endtime']->i18nFormat('YYYY-MM-dd').$week[date('w', strtotime($subtask['endtime']))] ?>
                      </span>
                      <?= $this->Html->link(__('設定'), ['controller' => 'Subtasks','action' => 'edit',$subtask['id']], ['class' => "status{$subtask['status']}"]); ?>
                    </li>
                  <?php endif ?>
                <?php endforeach ?>
              </ul>
            <?php endif ?>
          <?php endif ?>
        <?php endforeach ?>
      </ul>
      </div>
    </div>
  </div>
</div>
