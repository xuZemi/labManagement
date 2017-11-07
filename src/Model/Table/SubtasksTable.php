<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Subtasks Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsToMany $Tasks
 *
 * @method \App\Model\Entity\Subtask get($primaryKey, $options = [])
 * @method \App\Model\Entity\Subtask newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Subtask[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Subtask|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Subtask patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Subtask[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Subtask findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SubtasksTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('subtasks');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->belongsToMany('Tasks', [
            'foreignKey' => 'subtask_id',
            'targetForeignKey' => 'task_id',
            'joinTable' => 'subtasks_tasks'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->allowEmpty('subdescription');

        $validator
            ->integer('status')
            ->allowEmpty('status');

        $validator
            ->allowEmpty('starttime');

        $validator
            ->allowEmpty('endtime');

        $validator
            ->integer('weight')
            ->allowEmpty('weight');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
