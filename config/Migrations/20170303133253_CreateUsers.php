<?php
use Migrations\AbstractMigration;

class CreateUsers extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('users');
        $table->addColumn('name', 'text', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('password', 'text', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('email', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('phone', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('role', 'text', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('photo', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('photo_dir', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('deleted', 'timestamp', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('created', 'timestamp', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('modified', 'timestamp', [
            'default' => null,
            'null' => false,
        ]);
        $table->create();
    }
}
