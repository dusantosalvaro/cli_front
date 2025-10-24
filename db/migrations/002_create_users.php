<?php

use ActiveRecord\Migration;

class CreateUsers extends Migration
{
    public function up()
    {
        $this->create_table('tb_users', ['primary_key' => 'id'], function ($t) {
            $t->string('full_name', ['limit' => 150, 'null' => false]);
            $t->string('email', ['limit' => 150, 'null' => false]);
            $t->string('password_hash', ['limit' => 255, 'null' => false]);
            $t->integer('role_id', ['null' => false]);
            $t->string('phone', ['limit' => 30]);
            $t->string('document_id', ['limit' => 50]);
            $t->string('status', ['limit' => 30, 'default' => 'active']);
            $t->datetime('last_login_at');
            $t->datetime('created_at');
            $t->datetime('updated_at');
        });

        $this->add_index('tb_users', 'email', ['unique' => true, 'name' => 'idx_tb_users_email']);
        $this->add_index('tb_users', 'role_id', ['name' => 'idx_tb_users_role']);

        $this->execute('ALTER TABLE tb_users ADD CONSTRAINT fk_users_role FOREIGN KEY (role_id) REFERENCES tb_roles(id) ON UPDATE CASCADE');
    }

    public function down()
    {
        $this->drop_table('tb_users');
    }
}
