<section>
    <h2>Financeiro</h2>
    <table>
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Valor</th>
                <th>Descrição</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (\$lancamentos as \$lancamento): ?>
                <tr>
                    <td><?php echo htmlspecialchars(\$lancamento->tipo, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td>R$ <?php echo number_format((float) \$lancamento->valor, 2, ',', '.'); ?></td>
                    <td><?php echo htmlspecialchars(\$lancamento->descricao ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars(\$lancamento->data_lancamento, ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
