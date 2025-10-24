<?php

use ActiveRecord\Migration;

class CreateCareTables extends Migration
{
    public function up()
    {
        $this->create_table('tb_anamneses', ['primary_key' => 'id'], function ($t) {
            $t->integer('client_id', ['null' => false]);
            $t->integer('practitioner_user_id', ['null' => false]);
            $t->text('presenting_complaint');
            $t->text('medical_history');
            $t->text('current_medications');
            $t->text('lifestyle_information');
            $t->text('family_history');
            $t->text('allergies');
            $t->text('notes');
            $t->datetime('created_at');
            $t->datetime('updated_at');
        });

        $this->add_index('tb_anamneses', 'client_id', ['name' => 'idx_tb_anamneses_client']);
        $this->add_index('tb_anamneses', 'practitioner_user_id', ['name' => 'idx_tb_anamneses_practitioner']);

        $this->create_table('tb_sessions', ['primary_key' => 'id'], function ($t) {
            $t->integer('client_id', ['null' => false]);
            $t->integer('practitioner_user_id', ['null' => false]);
            $t->datetime('session_date', ['null' => false]);
            $t->integer('duration_minutes', ['null' => false, 'default' => 60]);
            $t->string('session_type', ['limit' => 80]);
            $t->text('summary');
            $t->text('recommendations');
            $t->text('homework');
            $t->string('status', ['limit' => 30, 'default' => 'completed']);
            $t->datetime('created_at');
            $t->datetime('updated_at');
        });

        $this->add_index('tb_sessions', ['client_id', 'session_date'], ['name' => 'idx_tb_sessions_client_date']);
        $this->add_index('tb_sessions', 'practitioner_user_id', ['name' => 'idx_tb_sessions_practitioner']);

        $this->create_table('tb_appointments', ['primary_key' => 'id'], function ($t) {
            $t->integer('client_id', ['null' => false]);
            $t->integer('practitioner_user_id', ['null' => false]);
            $t->datetime('scheduled_start', ['null' => false]);
            $t->datetime('scheduled_end');
            $t->string('status', ['limit' => 30, 'default' => 'scheduled']);
            $t->string('location', ['limit' => 150]);
            $t->boolean('is_virtual', ['default' => false, 'null' => false]);
            $t->datetime('reminder_sent_at');
            $t->text('cancellation_reason');
            $t->datetime('created_at');
            $t->datetime('updated_at');
        });

        $this->add_index('tb_appointments', ['client_id', 'scheduled_start'], ['name' => 'idx_tb_appointments_client_start']);
        $this->add_index('tb_appointments', 'practitioner_user_id', ['name' => 'idx_tb_appointments_practitioner']);
        $this->add_index('tb_appointments', 'status', ['name' => 'idx_tb_appointments_status']);

        $this->execute('ALTER TABLE tb_anamneses ADD CONSTRAINT fk_anamneses_client FOREIGN KEY (client_id) REFERENCES tb_clients(id) ON DELETE CASCADE');
        $this->execute('ALTER TABLE tb_anamneses ADD CONSTRAINT fk_anamneses_practitioner FOREIGN KEY (practitioner_user_id) REFERENCES tb_users(id) ON DELETE CASCADE');

        $this->execute('ALTER TABLE tb_sessions ADD CONSTRAINT fk_sessions_client FOREIGN KEY (client_id) REFERENCES tb_clients(id) ON DELETE CASCADE');
        $this->execute('ALTER TABLE tb_sessions ADD CONSTRAINT fk_sessions_practitioner FOREIGN KEY (practitioner_user_id) REFERENCES tb_users(id) ON DELETE CASCADE');

        $this->execute('ALTER TABLE tb_appointments ADD CONSTRAINT fk_appointments_client FOREIGN KEY (client_id) REFERENCES tb_clients(id) ON DELETE CASCADE');
        $this->execute('ALTER TABLE tb_appointments ADD CONSTRAINT fk_appointments_practitioner FOREIGN KEY (practitioner_user_id) REFERENCES tb_users(id) ON DELETE CASCADE');
    }

    public function down()
    {
        $this->drop_table('tb_appointments');
        $this->drop_table('tb_sessions');
        $this->drop_table('tb_anamneses');
    }
}
