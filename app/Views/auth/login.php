<section class="card">
    <h2>Entrar</h2>
    <?php if (!empty(\$error)): ?>
        <div class="alert"><?php echo htmlspecialchars(\$error, ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endif; ?>
    <form method="post" action="/login">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(\$csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
        <div>
            <label for="email">E-mail</label><br>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="password">Senha</label><br>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Entrar</button>
    </form>
</section>
