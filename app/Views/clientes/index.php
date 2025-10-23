<section>
    <h2>Clientes</h2>
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Telefone</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (\$clientes as \$cliente): ?>
                <tr>
                    <td><?php echo htmlspecialchars(\$cliente->nome, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars(\$cliente->email ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars(\$cliente->telefone ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
