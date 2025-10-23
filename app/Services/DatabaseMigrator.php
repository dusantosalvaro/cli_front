<?php

declare(strict_types=1);

namespace App\Services;

use PDO;

class DatabaseMigrator
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function migrate(): void
    {
        $this->pdo->exec('CREATE TABLE IF NOT EXISTS tb_users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            email TEXT NOT NULL UNIQUE,
            password_hash TEXT NOT NULL,
            role TEXT,
            permissions TEXT
        )');

        $this->pdo->exec('CREATE TABLE IF NOT EXISTS tb_clientes (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nome TEXT NOT NULL,
            email TEXT,
            telefone TEXT
        )');

        $this->pdo->exec('CREATE TABLE IF NOT EXISTS tb_anamneses (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            cliente_id INTEGER NOT NULL,
            descricao TEXT NOT NULL,
            FOREIGN KEY(cliente_id) REFERENCES tb_clientes(id)
        )');

        $this->pdo->exec('CREATE TABLE IF NOT EXISTS tb_atendimentos (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            cliente_id INTEGER NOT NULL,
            usuario_id INTEGER NOT NULL,
            descricao TEXT NOT NULL,
            status TEXT NOT NULL,
            data_atendimento TEXT,
            FOREIGN KEY(cliente_id) REFERENCES tb_clientes(id),
            FOREIGN KEY(usuario_id) REFERENCES tb_users(id)
        )');

        $this->pdo->exec('CREATE TABLE IF NOT EXISTS tb_agenda_eventos (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            titulo TEXT NOT NULL,
            inicio TEXT NOT NULL,
            fim TEXT NOT NULL,
            cliente_id INTEGER,
            FOREIGN KEY(cliente_id) REFERENCES tb_clientes(id)
        )');

        $this->pdo->exec('CREATE TABLE IF NOT EXISTS tb_lancamentos (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            tipo TEXT NOT NULL,
            valor REAL NOT NULL,
            descricao TEXT,
            data_lancamento TEXT NOT NULL
        )');
    }
}
