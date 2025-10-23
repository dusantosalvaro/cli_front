<section>
    <h2>Anamneses</h2>
    <table>
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Descrição</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (\$anamneses as \$anamnese): ?>
                <tr>
                    <td><?php echo htmlspecialchars(\$anamnese->cliente->nome ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo nl2br(htmlspecialchars(\$anamnese->descricao, ENT_QUOTES, 'UTF-8')); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
