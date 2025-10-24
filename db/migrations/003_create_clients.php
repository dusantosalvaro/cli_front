<?php

use ActiveRecord\Migration;

class CreateClients extends Migration
{
    public function up()
    {
        $this->create_table('tb_clients', ['primary_key' => 'id'], function ($t) {
            $t->integer('owner_user_id', ['null' => false]);
            $t->string('full_name', ['limit' => 150, 'null' => false]);
            $t->string('email', ['limit' => 150]);
            $t->string('phone', ['limit' => 30]);
            $t->string('document_id', ['limit' => 50]);
            $t->date('birth_date');
            $t->string('gender', ['limit' => 30]);
            $t->string('marital_status', ['limit' => 50]);
            $t->string('occupation', ['limit' => 120]);
            $t->text('notes');
            $t->datetime('created_at');
            $t->datetime('updated_at');
        });

        $this->add_index('tb_clients', 'owner_user_id', ['name' => 'idx_tb_clients_owner']);
        $this->add_index('tb_clients', 'email', ['name' => 'idx_tb_clients_email']);
        $this->add_index('tb_clients', 'document_id', ['name' => 'idx_tb_clients_document']);

        $this->execute('ALTER TABLE tb_clients ADD CONSTRAINT fk_clients_owner FOREIGN KEY (owner_user_id) REFERENCES tb_users(id) ON DELETE CASCADE');
    }

    public function down()
    {
        $this->drop_table('tb_clients');
    }
}
