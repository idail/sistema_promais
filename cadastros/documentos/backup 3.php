echo '
<style>
    body { font-family: Arial, sans-serif; background:#f2f2f2; }
    .guia-container {
        width: 210mm; min-height: 297mm; margin:20px auto; padding:20px;
        background:#fff; border:1px solid #ccc; box-shadow:0 0 10px rgba(0,0,0,.1);
        page-break-after: always;
    }
    h2 { text-align:center; margin:20px 0; }
    h3 {
        margin-top:20px; margin-bottom:10px;
        background:#e9ecef; padding:6px 10px; border:1px solid #ccc; font-size:14px;
    }
    table { width:100%; border-collapse:collapse; margin-bottom:15px; }
    th, td { border:1px solid #ccc; padding:6px; font-size:13px; vertical-align:top; }
    th { background:#f8f9fa; text-align:left; }
    .valor { text-align:right; font-weight:bold; }
</style>

<div class="guia-container">
    <h2>FATURAMENTO</h2>

    <h3>Resumo do Faturamento</h3>
    <table>
        <tr><th colspan="2">Itens Selecionados</th></tr>';

        // Exames
        if (!empty($itens_exames)) {
            echo '<tr><td>Exames e Procedimentos</td><td class="valor">R$ ' . number_format($total_exames, 2, ",", ".") . '</td></tr>';
        }

        // Treinamentos
        if (!empty($itens_treinamentos)) {
            echo '<tr><td>Treinamentos</td><td class="valor">R$ ' . number_format($total_treinamentos, 2, ",", ".") . '</td></tr>';
        }

        // EPI/EPC
        if (!empty($itens_epi)) {
            echo '<tr><td>EPI / EPC</td><td class="valor">R$ ' . number_format($total_epi, 2, ",", ".") . '</td></tr>';
        }

        echo '
        <tr>
            <th>Total Geral</th>
            <td class="valor">R$ ' . number_format(($total_exames + $total_treinamentos + $total_epi), 2, ",", ".") . '</td>
        </tr>
    </table>

    <h3>Detalhamento</h3>
    <table>
        <tr><th>Descrição</th><th>Qtd</th><th>Valor Unitário</th><th>Total</th></tr>';

        // Lista os exames
        if (!empty($itens_exames)) {
            foreach ($itens_exames as $exame) {
                echo '<tr>
                        <td>'.htmlspecialchars($exame["descricao"]).'</td>
                        <td>'.htmlspecialchars($exame["quantidade"]).'</td>
                        <td class="valor">R$ '.number_format($exame["valor_unitario"],2,",",".").'</td>
                        <td class="valor">R$ '.number_format($exame["total"],2,",",".").'</td>
                      </tr>';
            }
        }

        // Lista os treinamentos
        if (!empty($itens_treinamentos)) {
            foreach ($itens_treinamentos as $trein) {
                echo '<tr>
                        <td>'.htmlspecialchars($trein["descricao"]).'</td>
                        <td>'.htmlspecialchars($trein["quantidade"]).'</td>
                        <td class="valor">R$ '.number_format($trein["valor_unitario"],2,",",".").'</td>
                        <td class="valor">R$ '.number_format($trein["total"],2,",",".").'</td>
                      </tr>';
            }
        }

        // Lista os EPIs
        if (!empty($itens_epi)) {
            foreach ($itens_epi as $epi) {
                echo '<tr>
                        <td>'.htmlspecialchars($epi["descricao"]).'</td>
                        <td>'.htmlspecialchars($epi["quantidade"]).'</td>
                        <td class="valor">R$ '.number_format($epi["valor_unitario"],2,",",".").'</td>
                        <td class="valor">R$ '.number_format($epi["total"],2,",",".").'</td>
                      </tr>';
            }
        }

echo '
    </table>
</div>
';
