if (!empty($resultado_busca_dados_bancarios)) {
                $tipos = json_decode($resultado_busca_dados_bancarios[0]["tipo_dado_bancario"], true);

                if (!is_array($tipos)) {
                    $tipos = [];
                }

                if (empty($tipos)) {
                    echo '<p style="font-size:11px; color:red; font-family:Arial, sans-serif;">
                                <strong>Atenção:</strong> Nenhuma forma de pagamento selecionada.
                            </p>';
                } else {
                    $temQrCode = in_array('qrcode', $tipos);
                    $temPix = in_array('pix', $tipos);
                    $temAgenciaConta = in_array('agencia-conta', $tipos);

                    if ($temQrCode || $temPix || $temAgenciaConta) {
                        // Container principal
                        echo '<div style="display:flex; justify-content:flex-start; align-items:flex-start; gap:15px; margin-bottom:20px; font-family:Arial, sans-serif; font-size:11px; color:#000;">';

                        // Bloco QR Code (imagem + texto ao lado)
                        if ($temQrCode) {
                            $chave = '(64) 99606-5577'; // ou busca no banco
                            ob_start();
                            QRcode::png($chave, null, QR_ECLEVEL_L, 4, 2);
                            $imageString = base64_encode(ob_get_contents());
                            ob_end_clean();

                            echo '
                                <div style="display:flex; align-items:center; gap:8px; min-width:180px;">
                                    <img src="data:image/png;base64,' . $imageString . '" alt="QR Code" style="width:80px; height:auto;">
                                    <div>
                                        <p style="margin:0; font-weight:bold;">Chave:</p>
                                        <p style="margin:0;">' . htmlspecialchars($chave) . '</p>
                                    </div>
                                </div>
                            ';
                        }

                        // Bloco PIX
                        if ($temPix && !empty($resultado_busca_dados_bancarios[0]["dado_bancario_pix"])) {
                            echo '
                                <div style="display:flex; align-items:center; gap:8px; min-width:200px;margin-top: 35px;">
                                    <p style="margin:0; font-weight:bold;">Chave PIX:</p>
                                    <p style="margin:0;">' . htmlspecialchars($resultado_busca_dados_bancarios[0]["dado_bancario_pix"]) . '</p>
                                </div>';
                        }

                        // Bloco Agência e Conta
                        if ($temAgenciaConta && !empty($resultado_busca_dados_bancarios[0]["dado_bancario_agencia_conta"])) {
                            $dados = explode('|', $resultado_busca_dados_bancarios[0]["dado_bancario_agencia_conta"]);
                            echo '<div style="display:flex; align-items:flex-start; gap:8px; min-width:250px;margin-top: 35px;">
                                    <p style="margin:0; font-weight:bold; white-space:nowrap;">Dados para Transferência:</p>
                                    <div>';
                            foreach ($dados as $dado) {
                                echo '<p style="margin:0;">' . htmlspecialchars($dado) . '</p>';
                            }
                            echo '</div></div>';
                        }

                        echo '</div>'; // fecha container principal
                    }
                }
            }



            echo '
<p style="margin:4px 0;"><strong style="font-size:11px;">Prazo de Entrega:</strong> ' .
    (!empty($prazo_entrega) ? $prazo_entrega : '<span style="font-size:11px;">A combinar</span>') .
'</p>

<p style="margin:4px 0;"><strong style="font-size:11px;">Observações:</strong> ' .
    (!empty($observacoes) ? $observacoes : '<span style="font-size:11px;">Nenhuma</span>') .
'</p>
';

echo '
<p style="margin:4px 0;"><strong style="font-size:11px;">Prazo de Entrega:</strong> ' .
    (!empty($prazo_entrega) ? $prazo_entrega : '<span style="font-size:11px;">A combinar</span>') .
'</p>

<p style="margin:4px 0;"><strong style="font-size:11px;">Observações:</strong> ' .
    (!empty($observacoes) ? $observacoes : '<span style="font-size:11px;">Nenhuma</span>') .
'</p>
';


echo '
<p style="margin:4px 0;"><strong style="font-size:11px;">Prazo de Entrega:</strong> ' .
    (!empty($prazo_entrega) ? $prazo_entrega : '<span style="font-size:11px;">A combinar</span>') .
'</p>

<p style="margin:4px 0;"><strong style="font-size:11px;">Observações:</strong> ' .
    (!empty($observacoes) ? $observacoes : '<span style="font-size:11px;">Nenhuma</span>') .
'</p>
';