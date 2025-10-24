<?php

use ActiveRecord\Migration;

class CreateRolesAndPermissions extends Migration
{
    public function up()
    {
        $this->create_table('tb_roles', ['primary_key' => 'id'], function ($t) {
            $t->string('name', ['limit' => 100, 'null' => false]);
            $t->string('slug', ['limit' => 100, 'null' => false]);
            $t->string('description', ['limit' => 255]);
            $t->boolean('is_default', ['default' => false, 'null' => false]);
            $t->datetime('created_at');
            $t->datetime('updated_at');
        });

        $this->add_index('tb_roles', 'slug', ['unique' => true, 'name' => 'idx_tb_roles_slug']);
        $this->add_index('tb_roles', 'is_default', ['name' => 'idx_tb_roles_is_default']);

        $this->create_table('tb_role_permissions', ['primary_key' => 'id'], function ($t) {
            $t->integer('role_id', ['null' => false]);
            $t->string('permission_key', ['limit' => 150, 'null' => false]);
            $t->datetime('created_at');
            $t->datetime('updated_at');
        });

        $this->add_index('tb_role_permissions', ['role_id', 'permission_key'], [
            'unique' => true,
            'name' => 'idx_tb_role_permissions_unique'
        ]);

        $this->execute('ALTER TABLE tb_role_permissions ADD CONSTRAINT fk_role_permissions_role FOREIGN KEY (role_id) REFERENCES tb_roles(id) ON DELETE CASCADE');
    }

    public function down()
    {
        $this->drop_table('tb_role_permissions');
        $this->drop_table('tb_roles');
    }
}
