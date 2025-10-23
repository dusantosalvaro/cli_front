<section>
    <h2>Atendimentos</h2>
    <table>
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Profissional</th>
                <th>Status</th>
                <th>Data</th>
                <th>Descrição</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (\$atendimentos as \$atendimento): ?>
                <tr>
                    <td><?php echo htmlspecialchars(\$atendimento->cliente->nome ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars(\$atendimento->profissional->name ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars(\$atendimento->status, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars(\$atendimento->data_atendimento ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo nl2br(htmlspecialchars(\$atendimento->descricao, ENT_QUOTES, 'UTF-8')); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
