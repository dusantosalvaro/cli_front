<?php

use ActiveRecord\Migration;

class CreateFinancialTables extends Migration
{
    public function up()
    {
        $this->create_table('tb_payment_methods', ['primary_key' => 'id'], function ($t) {
            $t->string('name', ['limit' => 80, 'null' => false]);
            $t->string('slug', ['limit' => 80, 'null' => false]);
            $t->string('description', ['limit' => 255]);
            $t->boolean('is_active', ['default' => true, 'null' => false]);
            $t->datetime('created_at');
            $t->datetime('updated_at');
        });

        $this->add_index('tb_payment_methods', 'slug', ['unique' => true, 'name' => 'idx_tb_payment_methods_slug']);
        $this->add_index('tb_payment_methods', 'is_active', ['name' => 'idx_tb_payment_methods_active']);

        $this->create_table('tb_financial_records', ['primary_key' => 'id'], function ($t) {
            $t->integer('client_id', ['null' => false]);
            $t->integer('session_id');
            $t->integer('appointment_id');
            $t->integer('payment_method_id', ['null' => false]);
            $t->decimal('amount', ['precision' => 12, 'scale' => 2, 'null' => false]);
            $t->decimal('discount', ['precision' => 12, 'scale' => 2, 'default' => 0]);
            $t->decimal('total', ['precision' => 12, 'scale' => 2, 'null' => false]);
            $t->string('currency', ['limit' => 3, 'default' => 'BRL']);
            $t->string('status', ['limit' => 30, 'default' => 'pending']);
            $t->date('due_date');
            $t->datetime('paid_at');
            $t->text('notes');
            $t->datetime('created_at');
            $t->datetime('updated_at');
        });

        $this->add_index('tb_financial_records', 'client_id', ['name' => 'idx_tb_financial_records_client']);
        $this->add_index('tb_financial_records', 'payment_method_id', ['name' => 'idx_tb_financial_records_payment_method']);
        $this->add_index('tb_financial_records', 'status', ['name' => 'idx_tb_financial_records_status']);
        $this->add_index('tb_financial_records', 'due_date', ['name' => 'idx_tb_financial_records_due']);

        $this->execute('ALTER TABLE tb_financial_records ADD CONSTRAINT fk_financial_records_client FOREIGN KEY (client_id) REFERENCES tb_clients(id) ON DELETE CASCADE');
        $this->execute('ALTER TABLE tb_financial_records ADD CONSTRAINT fk_financial_records_session FOREIGN KEY (session_id) REFERENCES tb_sessions(id) ON DELETE SET NULL');
        $this->execute('ALTER TABLE tb_financial_records ADD CONSTRAINT fk_financial_records_appointment FOREIGN KEY (appointment_id) REFERENCES tb_appointments(id) ON DELETE SET NULL');
        $this->execute('ALTER TABLE tb_financial_records ADD CONSTRAINT fk_financial_records_payment_method FOREIGN KEY (payment_method_id) REFERENCES tb_payment_methods(id) ON UPDATE CASCADE');
    }

    public function down()
    {
        $this->drop_table('tb_financial_records');
        $this->drop_table('tb_payment_methods');
    }
}
