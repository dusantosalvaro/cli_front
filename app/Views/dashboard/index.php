<section>
    <h2>Bem-vindo, <?php echo htmlspecialchars(\$user->name ?? 'Usuário', ENT_QUOTES, 'UTF-8'); ?>!</h2>
    <p>Selecione um módulo para começar.</p>
    <div class="card-grid">
        <div class="card">
            <h3>Clientes</h3>
            <p>Gerencie o cadastro de pacientes.</p>
            <a href="/clientes">Acessar</a>
        </div>
        <div class="card">
            <h3>Anamnese</h3>
            <p>Registre informações clínicas detalhadas.</p>
            <a href="/anamneses">Acessar</a>
        </div>
        <div class="card">
            <h3>Atendimentos</h3>
            <p>Acompanhe o histórico de consultas.</p>
            <a href="/atendimentos">Acessar</a>
        </div>
        <div class="card">
            <h3>Agenda</h3>
            <p>Visualize e organize compromissos.</p>
            <a href="/agenda">Acessar</a>
        </div>
        <div class="card">
            <h3>Financeiro</h3>
            <p>Controle lançamentos de receitas e despesas.</p>
            <a href="/financeiro">Acessar</a>
        </div>
        <div class="card">
            <h3>Administração</h3>
            <p>Gerencie usuários, papéis e permissões.</p>
            <a href="/administracao">Acessar</a>
        </div>
    </div>
</section>
