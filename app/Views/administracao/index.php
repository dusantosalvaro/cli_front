<section>
    <h2>Administração</h2>
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Papéis</th>
                <th>Permissões</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (\$usuarios as \$usuario): ?>
                <tr>
                    <td><?php echo htmlspecialchars(\$usuario->name, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars(\$usuario->email, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars(\$usuario->role ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars(implode(', ', \$usuario->permissions_list), ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
