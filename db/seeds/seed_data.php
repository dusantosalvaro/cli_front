<?php

use ActiveRecord\ConnectionManager;
use PDO;

$bootstrapPath = __DIR__ . '/../config/database.php';
if (file_exists($bootstrapPath)) {
    require_once $bootstrapPath;
}

if (!class_exists(ConnectionManager::class)) {
    throw new RuntimeException('ActiveRecord\ConnectionManager not available. Configure PHP ActiveRecord before running this seeder.');
}

$connection = ConnectionManager::get_connection();
$now = date('Y-m-d H:i:s');

$connection->transaction(function () use ($connection, $now) {
    $roles = [
        ['name' => 'Administrador', 'slug' => 'admin', 'description' => 'Acesso completo ao sistema', 'is_default' => 0],
        ['name' => 'Terapeuta', 'slug' => 'therapist', 'description' => 'Gerencia clientes, sessões e prontuários', 'is_default' => 1],
        ['name' => 'Assistente', 'slug' => 'assistant', 'description' => 'Suporte administrativo e financeiro', 'is_default' => 0],
    ];

    $insertRole = $connection->prepare('INSERT INTO tb_roles (name, slug, description, is_default, created_at, updated_at) VALUES (:name, :slug, :description, :is_default, :created_at, :updated_at)');
    $findRole = $connection->prepare('SELECT COUNT(*) FROM tb_roles WHERE slug = :slug');

    foreach ($roles as $role) {
        $findRole->execute(['slug' => $role['slug']]);
        if ((int) $findRole->fetchColumn() === 0) {
            $insertRole->execute([
                'name' => $role['name'],
                'slug' => $role['slug'],
                'description' => $role['description'],
                'is_default' => $role['is_default'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    $roleIds = $connection->query('SELECT slug, id FROM tb_roles')->fetchAll(PDO::FETCH_KEY_PAIR);

    $permissionsByRole = [
        'admin' => ['clients:read', 'clients:write', 'appointments:manage', 'sessions:manage', 'financial:manage', 'users:manage'],
        'therapist' => ['clients:read', 'clients:write', 'appointments:manage', 'sessions:manage'],
        'assistant' => ['clients:read', 'appointments:manage', 'financial:manage'],
    ];

    $insertPermission = $connection->prepare('INSERT INTO tb_role_permissions (role_id, permission_key, created_at, updated_at) VALUES (:role_id, :permission_key, :created_at, :updated_at)');
    $findPermission = $connection->prepare('SELECT COUNT(*) FROM tb_role_permissions WHERE role_id = :role_id AND permission_key = :permission_key');

    foreach ($permissionsByRole as $roleSlug => $permissions) {
        if (!isset($roleIds[$roleSlug])) {
            continue;
        }

        foreach ($permissions as $permission) {
            $findPermission->execute(['role_id' => $roleIds[$roleSlug], 'permission_key' => $permission]);
            if ((int) $findPermission->fetchColumn() === 0) {
                $insertPermission->execute([
                    'role_id' => $roleIds[$roleSlug],
                    'permission_key' => $permission,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }

    $paymentMethods = [
        ['name' => 'Dinheiro', 'slug' => 'cash', 'description' => 'Pagamento em dinheiro'],
        ['name' => 'Cartão de Crédito', 'slug' => 'credit_card', 'description' => 'Pagamento com cartão de crédito'],
        ['name' => 'Pix', 'slug' => 'pix', 'description' => 'Pagamento instantâneo via Pix'],
        ['name' => 'Transferência Bancária', 'slug' => 'bank_transfer', 'description' => 'Pagamento por TED ou DOC'],
    ];

    $insertPaymentMethod = $connection->prepare('INSERT INTO tb_payment_methods (name, slug, description, is_active, created_at, updated_at) VALUES (:name, :slug, :description, 1, :created_at, :updated_at)');
    $findPaymentMethod = $connection->prepare('SELECT COUNT(*) FROM tb_payment_methods WHERE slug = :slug');

    foreach ($paymentMethods as $method) {
        $findPaymentMethod->execute(['slug' => $method['slug']]);
        if ((int) $findPaymentMethod->fetchColumn() === 0) {
            $insertPaymentMethod->execute([
                'name' => $method['name'],
                'slug' => $method['slug'],
                'description' => $method['description'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    if (!isset($roleIds['admin']) || !isset($roleIds['therapist'])) {
        return;
    }

    $password = password_hash('admin123', PASSWORD_BCRYPT);
    $insertUser = $connection->prepare('INSERT INTO tb_users (full_name, email, password_hash, role_id, status, created_at, updated_at) VALUES (:full_name, :email, :password_hash, :role_id, :status, :created_at, :updated_at)');
    $findUserByEmail = $connection->prepare('SELECT COUNT(*) FROM tb_users WHERE email = :email');

    $findUserByEmail->execute(['email' => 'admin@example.com']);
    if ((int) $findUserByEmail->fetchColumn() === 0) {
        $insertUser->execute([
            'full_name' => 'Administrador do Sistema',
            'email' => 'admin@example.com',
            'password_hash' => $password,
            'role_id' => $roleIds['admin'],
            'status' => 'active',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    $findUserByEmail->execute(['email' => 'terapeuta@example.com']);
    if ((int) $findUserByEmail->fetchColumn() === 0) {
        $insertUser->execute([
            'full_name' => 'Terapeuta Exemplo',
            'email' => 'terapeuta@example.com',
            'password_hash' => password_hash('therapist123', PASSWORD_BCRYPT),
            'role_id' => $roleIds['therapist'],
            'status' => 'active',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    $therapistId = (int) $connection->query("SELECT id FROM tb_users WHERE email = 'terapeuta@example.com'")->fetchColumn();
    if ($therapistId <= 0) {
        return;
    }

    $clientEmail = 'cliente@example.com';
    $findClientByEmail = $connection->prepare('SELECT COUNT(*) FROM tb_clients WHERE email = :email');
    $findClientByEmail->execute(['email' => $clientEmail]);

    if ((int) $findClientByEmail->fetchColumn() === 0) {
        $insertClient = $connection->prepare('INSERT INTO tb_clients (owner_user_id, full_name, email, phone, document_id, birth_date, occupation, created_at, updated_at) VALUES (:owner_user_id, :full_name, :email, :phone, :document_id, :birth_date, :occupation, :created_at, :updated_at)');
        $insertClient->execute([
            'owner_user_id' => $therapistId,
            'full_name' => 'Cliente Exemplo',
            'email' => $clientEmail,
            'phone' => '+55 11 99999-0000',
            'document_id' => '123.456.789-00',
            'birth_date' => '1990-05-15',
            'occupation' => 'Analista de Sistemas',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    $clientId = (int) $connection->query("SELECT id FROM tb_clients WHERE email = 'cliente@example.com'")->fetchColumn();
    if ($clientId <= 0) {
        return;
    }

    $anamnesisExists = (int) $connection->query("SELECT COUNT(*) FROM tb_anamneses WHERE client_id = {$clientId}")->fetchColumn() > 0;
    if (!$anamnesisExists) {
        $insertAnamnesis = $connection->prepare('INSERT INTO tb_anamneses (client_id, practitioner_user_id, presenting_complaint, medical_history, notes, created_at, updated_at) VALUES (:client_id, :practitioner_user_id, :presenting_complaint, :medical_history, :notes, :created_at, :updated_at)');
        $insertAnamnesis->execute([
            'client_id' => $clientId,
            'practitioner_user_id' => $therapistId,
            'presenting_complaint' => 'Ansiedade e dificuldade para dormir.',
            'medical_history' => 'Histórico sem comorbidades significativas.',
            'notes' => 'Cliente encaminhado por indicação.',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    $sessionExists = (int) $connection->query("SELECT COUNT(*) FROM tb_sessions WHERE client_id = {$clientId}")->fetchColumn() > 0;
    if (!$sessionExists) {
        $insertSession = $connection->prepare('INSERT INTO tb_sessions (client_id, practitioner_user_id, session_date, duration_minutes, session_type, summary, status, created_at, updated_at) VALUES (:client_id, :practitioner_user_id, :session_date, :duration_minutes, :session_type, :summary, :status, :created_at, :updated_at)');
        $insertSession->execute([
            'client_id' => $clientId,
            'practitioner_user_id' => $therapistId,
            'session_date' => date('Y-m-d H:i:s', strtotime('-7 days')),
            'duration_minutes' => 60,
            'session_type' => 'Psicoterapia',
            'summary' => 'Sessão inicial com levantamento de queixas principais.',
            'status' => 'completed',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    $appointmentExists = (int) $connection->query("SELECT COUNT(*) FROM tb_appointments WHERE client_id = {$clientId}")->fetchColumn() > 0;
    if (!$appointmentExists) {
        $insertAppointment = $connection->prepare('INSERT INTO tb_appointments (client_id, practitioner_user_id, scheduled_start, scheduled_end, status, location, is_virtual, created_at, updated_at) VALUES (:client_id, :practitioner_user_id, :scheduled_start, :scheduled_end, :status, :location, :is_virtual, :created_at, :updated_at)');
        $insertAppointment->execute([
            'client_id' => $clientId,
            'practitioner_user_id' => $therapistId,
            'scheduled_start' => date('Y-m-d H:i:s', strtotime('+3 days 10:00')),
            'scheduled_end' => date('Y-m-d H:i:s', strtotime('+3 days 11:00')),
            'status' => 'scheduled',
            'location' => 'Consultório 101',
            'is_virtual' => 0,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    $appointmentId = (int) $connection->query("SELECT id FROM tb_appointments WHERE client_id = {$clientId} ORDER BY id DESC LIMIT 1")->fetchColumn();
    $sessionId = (int) $connection->query("SELECT id FROM tb_sessions WHERE client_id = {$clientId} ORDER BY id DESC LIMIT 1")->fetchColumn();
    $paymentMethodId = (int) $connection->query("SELECT id FROM tb_payment_methods WHERE slug = 'pix'")->fetchColumn();

    if ($paymentMethodId > 0) {
        $financialExists = (int) $connection->query("SELECT COUNT(*) FROM tb_financial_records WHERE client_id = {$clientId}")->fetchColumn() > 0;
        if (!$financialExists) {
            $insertFinancial = $connection->prepare('INSERT INTO tb_financial_records (client_id, session_id, appointment_id, payment_method_id, amount, discount, total, currency, status, due_date, notes, created_at, updated_at) VALUES (:client_id, :session_id, :appointment_id, :payment_method_id, :amount, :discount, :total, :currency, :status, :due_date, :notes, :created_at, :updated_at)');
            $insertFinancial->execute([
                'client_id' => $clientId,
                'session_id' => $sessionId ?: null,
                'appointment_id' => $appointmentId ?: null,
                'payment_method_id' => $paymentMethodId,
                'amount' => 200.00,
                'discount' => 0,
                'total' => 200.00,
                'currency' => 'BRL',
                'status' => 'pending',
                'due_date' => date('Y-m-d', strtotime('+5 days')),
                'notes' => 'Sessão inicial agendada via Pix.',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
});

