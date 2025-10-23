<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Clínico</title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
    <header>
        <h1>Painel Clínico</h1>
        <?php if (\App\Core\Auth::check()): ?>
            <nav>
                <a href="/">Dashboard</a>
                <a href="/clientes">Clientes</a>
                <a href="/anamneses">Anamnese</a>
                <a href="/atendimentos">Atendimentos</a>
                <a href="/agenda">Agenda</a>
                <a href="/financeiro">Financeiro</a>
                <a href="/administracao">Administração</a>
                <a href="/logout">Sair</a>
            </nav>
        <?php endif; ?>
    </header>
    <main>
