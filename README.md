# Painel Clínico PHP

Aplicação exemplo em PHP 7 com arquitetura MVC, ActiveRecord e autenticação baseada em sessões para gestão clínica.

## Requisitos

- PHP 7.4+
- Extensões: `pdo_sqlite`
- Composer (para instalar dependências)

## Configuração

```bash
composer install
cp .env.example .env
php -S localhost:8000 -t public/
```

As tabelas são criadas automaticamente em um banco SQLite localizado em `storage/database.sqlite`. O seeder cria um usuário administrador (`admin@example.com` / `secret`).

## Testes

```bash
composer test
```

## Endpoints principais

- `GET /` - Dashboard
- `GET /clientes` - Módulo de clientes
- `GET /anamneses`
- `GET /atendimentos`
- `GET /agenda` - Exibe instruções para integração com FullCalendar
- `GET /agenda/eventos` - API JSON de eventos
- `GET /financeiro`
- `GET /administracao`
- `GET /login` / `POST /login`

A API de agenda retorna o formato esperado pelo FullCalendar.
