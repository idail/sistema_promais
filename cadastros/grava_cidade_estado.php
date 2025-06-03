<div class="tab-container">
    <div class="tab-buttons">
        <button class="tab-button active" onclick="openTab(event, 'dados')">Dados</button>
        <!-- <button class="tab-button" onclick="openTab(event, 'profissionais')">Profissionais da Medicina Relacionados</button> -->
    </div>

    <div id="dados" class="tab-content active">
        <form class="custom-form">
            <input type="hidden" id="empresa_id" name="empresa_id" value="<?php echo $_SESSION['empresa_id']; ?>">

            <input type="hidden" name="cidade_estado_id_alteracao" id="cidade_estado_id_alteracao">

            <!-- <div class="form-group">
                <label for="created_at">Data de Cadastro:</label>
                <div class="input-with-icon">
                    <i class="fas fa-calendar-alt"></i>
                    <input type="datetime-local" id="created_at" name="created_at" class="form-control" readonly>
                </div>
            </div> -->

            <div class="form-columns">
                <div class="form-column">


                    <div class="address-container">

                        <div class="form-group" style="flex: 30%;">
                            <label for="cidade">Cidade:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-city"></i>

                                <input type="text" id="cidade" name="cidade" class="form-control">
                            </div>
                        </div>

                        <div class="form-group" style="flex: 30%;">
                            <label for="cep">CEP:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-envelope-open-text"></i>
                                <!-- <input type="text" id="cpf" name="cpf" class="form-control cnpj-input" oninput="formatCPF(this)"> -->
                                <input type="text" id="cep" name="cep" class="form-control">
                            </div>
                        </div>

                        <div class="form-group" style="flex: 30%;">
                            <label for="estado">Estado:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-city"></i>
                                <select id="estado" name="estado" class="form-control">
                                    <option value="">Selecione</option>
                                    <option value="AC">Acre</option>
                                    <option value="AL">Alagoas</option>
                                    <option value="AP">Amapá</option>
                                    <option value="AM">Amazonas</option>
                                    <option value="BA">Bahia</option>
                                    <option value="CE">Ceará</option>
                                    <option value="DF">Distrito Federal</option>
                                    <option value="ES">Espírito Santo</option>
                                    <option value="GO">Goiás</option>
                                    <option value="MA">Maranhão</option>
                                    <option value="MT">Mato Grosso</option>
                                    <option value="MS">Mato Grosso do Sul</option>
                                    <option value="MG">Minas Gerais</option>
                                    <option value="PA">Pará</option>
                                    <option value="PB">Paraíba</option>
                                    <option value="PR">Paraná</option>
                                    <option value="PE">Pernambuco</option>
                                    <option value="PI">Piauí</option>
                                    <option value="RJ">Rio de Janeiro</option>
                                    <option value="RN">Rio Grande do Norte</option>
                                    <option value="RS">Rio Grande do Sul</option>
                                    <option value="RO">Rondônia</option>
                                    <option value="RR">Roraima</option>
                                    <option value="SC">Santa Catarina</option>
                                    <option value="SP">São Paulo</option>
                                    <option value="SE">Sergipe</option>
                                    <option value="TO">Tocantins</option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group" style="flex: 30%;">
                            <label for="uf">UF:</label>
                            <div class="input-with-icon">
                                <i class="fas fa-map-marked-alt"></i>
                                <!-- <input type="text" id="cpf" name="cpf" class="form-control cnpj-input" oninput="formatCPF(this)"> -->
                                <input type="text" id="uf" name="uf" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-sm text-red-600 mt-3" id="mensagem-campo-vazio">
                <span id="corpo-mensagem-campo-vazio"></span>
            </div>

            <div id="mensagem-gravacao"
                class="hidden items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 transition-opacity duration-500"
                role="alert">
                <!-- <span class="sr-only">Sucesso</span> -->
                <div>
                    <span class="font-medium" id="corpo-mensagem-gravacao"></span>
                </div>
            </div>



            <input type="hidden" name="id_risco_alteracao" id="id_risco_alteracao">

            <button type="button" class="btn btn-primary" name="grava_risco" id="grava-cidade-estado">Salvar</button>
            <button type="button" id="retornar-listagem-medicos" class="botao-cinza">Cancelar</button>
        </form>

        <div class="form-columns">

            <div class="accordion" id="accordion-registros-mt">

                <div class="accordion-item">
                    <button class="accordion-header" aria-expanded="false" aria-controls="section1" id="accordion1">
                        Mato Grosso
                        <span class="accordion-arrow">▼</span>
                    </button>
                    <div class="accordion-content hidden" id="section1" role="region" aria-labelledby="accordion1" style="height: 15%;">
                        <div>
                            <table id="registros_mt">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Cidade</th>
                                        <th>CEP</th>
                                        <th>Estado</th>
                                        <th>UF</th>
                                        <th>Ações</th> <!-- Nova coluna para os botões de ação -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Dados serão preenchidos via JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item" id="accordion-registros-ms">
                <button class="accordion-header" aria-expanded="false" aria-controls="section2" id="accordion1">
                    Mato Grosso do Sul
                    <span class="accordion-arrow">▼</span>
                </button>
                <div class="accordion-content hidden" id="section2" role="region" aria-labelledby="accordion1" style="height: 15%;">
                    <div>
                        <table id="registros_ms">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cidade</th>
                                    <th>CEP</th>
                                    <th>Estado</th>
                                    <th>UF</th>
                                    <th>Ações</th> <!-- Nova coluna para os botões de ação -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dados serão preenchidos via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="accordion-item" id="accordion-registros-bh">
                <button class="accordion-header" aria-expanded="false" aria-controls="section3" id="accordion1">
                    Bahia
                    <span class="accordion-arrow">▼</span>
                </button>
                <div class="accordion-content hidden" id="section3" role="region" aria-labelledby="accordion1" style="height: 15%;">
                    <div>
                        <table id="registros_bh">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cidade</th>
                                    <th>CEP</th>
                                    <th>Estado</th>
                                    <th>UF</th>
                                    <th>Ações</th> <!-- Nova coluna para os botões de ação -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dados serão preenchidos via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="accordion-item" id="accordion-registros-mg">
                <button class="accordion-header" aria-expanded="false" aria-controls="section4" id="accordion1">
                    Minas Gerais
                    <span class="accordion-arrow">▼</span>
                </button>
                <div class="accordion-content hidden" id="section4" role="region" aria-labelledby="accordion1" style="height: 15%;">
                    <div>
                        <table id="registros_mg">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cidade</th>
                                    <th>CEP</th>
                                    <th>Estado</th>
                                    <th>UF</th>
                                    <th>Ações</th> <!-- Nova coluna para os botões de ação -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dados serão preenchidos via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="accordion-item" id="accordion-registros-mg">
                <button class="accordion-header" aria-expanded="false" aria-controls="section5" id="accordion1">
                    São Paulo
                    <span class="accordion-arrow">▼</span>
                </button>
                <div class="accordion-content hidden" id="section5" role="region" aria-labelledby="accordion1" style="height: 15%;">
                    <div>
                        <table id="registros_sp">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cidade</th>
                                    <th>CEP</th>
                                    <th>Estado</th>
                                    <th>UF</th>
                                    <th>Ações</th> <!-- Nova coluna para os botões de ação -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dados serão preenchidos via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="accordion-item" id="accordion-registros-mg">
                <button class="accordion-header" aria-expanded="false" aria-controls="section6" id="accordion1">
                    Santa Catarina
                    <span class="accordion-arrow">▼</span>
                </button>
                <div class="accordion-content hidden" id="section6" role="region" aria-labelledby="accordion1" style="height: 15%;">
                    <div>
                        <table id="registros_sc">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cidade</th>
                                    <th>CEP</th>
                                    <th>Estado</th>
                                    <th>UF</th>
                                    <th>Ações</th> <!-- Nova coluna para os botões de ação -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dados serão preenchidos via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="accordion-item" id="accordion-registros-mg">
                <button class="accordion-header" aria-expanded="false" aria-controls="section7" id="accordion1">
                    Paraná
                    <span class="accordion-arrow">▼</span>
                </button>
                <div class="accordion-content hidden" id="section7" role="region" aria-labelledby="accordion1" style="height: 15%;">
                    <div>
                        <table id="registros_pr">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cidade</th>
                                    <th>CEP</th>
                                    <th>Estado</th>
                                    <th>UF</th>
                                    <th>Ações</th> <!-- Nova coluna para os botões de ação -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dados serão preenchidos via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="accordion-item" id="accordion-registros-mg">
                <button class="accordion-header" aria-expanded="false" aria-controls="section8" id="accordion1">
                    Rio Grande do Sul
                    <span class="accordion-arrow">▼</span>
                </button>
                <div class="accordion-content hidden" id="section8" role="region" aria-labelledby="accordion1" style="height: 15%;">
                    <div>
                        <table id="registros_rs">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cidade</th>
                                    <th>CEP</th>
                                    <th>Estado</th>
                                    <th>UF</th>
                                    <th>Ações</th> <!-- Nova coluna para os botões de ação -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dados serão preenchidos via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="accordion-item" id="accordion-registros-mg">
                <button class="accordion-header" aria-expanded="false" aria-controls="section9" id="accordion1">
                    Goiás
                    <span class="accordion-arrow">▼</span>
                </button>
                <div class="accordion-content hidden" id="section9" role="region" aria-labelledby="accordion1" style="height: 15%;">
                    <div>
                        <table id="registros_go">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cidade</th>
                                    <th>CEP</th>
                                    <th>Estado</th>
                                    <th>UF</th>
                                    <th>Ações</th> <!-- Nova coluna para os botões de ação -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dados serão preenchidos via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="accordion-item" id="accordion-registros-mg">
                <button class="accordion-header" aria-expanded="false" aria-controls="section10" id="accordion1">
                    Ceará
                    <span class="accordion-arrow">▼</span>
                </button>
                <div class="accordion-content hidden" id="section10" role="region" aria-labelledby="accordion1" style="height: 15%;">
                    <div>
                        <table id="registros_ce">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cidade</th>
                                    <th>CEP</th>
                                    <th>Estado</th>
                                    <th>UF</th>
                                    <th>Ações</th> <!-- Nova coluna para os botões de ação -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dados serão preenchidos via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="accordion-item" id="accordion-registros-mg">
                <button class="accordion-header" aria-expanded="false" aria-controls="section11" id="accordion1">
                    Amazonas
                    <span class="accordion-arrow">▼</span>
                </button>
                <div class="accordion-content hidden" id="section11" role="region" aria-labelledby="accordion1" style="height: 15%;">
                    <div>
                        <table id="registros_am">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cidade</th>
                                    <th>CEP</th>
                                    <th>Estado</th>
                                    <th>UF</th>
                                    <th>Ações</th> <!-- Nova coluna para os botões de ação -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dados serão preenchidos via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="accordion-item" id="accordion-registros-mg">
                <button class="accordion-header" aria-expanded="false" aria-controls="section12" id="accordion1">
                    Rio de Janeiro
                    <span class="accordion-arrow">▼</span>
                </button>
                <div class="accordion-content hidden" id="section12" role="region" aria-labelledby="accordion1" style="height: 15%;">
                    <div>
                        <table id="registros_rj">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cidade</th>
                                    <th>CEP</th>
                                    <th>Estado</th>
                                    <th>UF</th>
                                    <th>Ações</th> <!-- Nova coluna para os botões de ação -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dados serão preenchidos via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="accordion-item" id="accordion-registros-mg">
                <button class="accordion-header" aria-expanded="false" aria-controls="section13" id="accordion1">
                    Pará
                    <span class="accordion-arrow">▼</span>
                </button>
                <div class="accordion-content hidden" id="section13" role="region" aria-labelledby="accordion1" style="height: 15%;">
                    <div>
                        <table id="registros_pa">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cidade</th>
                                    <th>CEP</th>
                                    <th>Estado</th>
                                    <th>UF</th>
                                    <th>Ações</th> <!-- Nova coluna para os botões de ação -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dados serão preenchidos via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="accordion-item" id="accordion-registros-mg">
                <button class="accordion-header" aria-expanded="false" aria-controls="section14" id="accordion1">
                    Pernambuco
                    <span class="accordion-arrow">▼</span>
                </button>
                <div class="accordion-content hidden" id="section14" role="region" aria-labelledby="accordion1" style="height: 15%;">
                    <div>
                        <table id="registros_pe">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cidade</th>
                                    <th>CEP</th>
                                    <th>Estado</th>
                                    <th>UF</th>
                                    <th>Ações</th> <!-- Nova coluna para os botões de ação -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dados serão preenchidos via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="accordion-item" id="accordion-registros-mg">
                <button class="accordion-header" aria-expanded="false" aria-controls="section15" id="accordion1">
                    Maranhão
                    <span class="accordion-arrow">▼</span>
                </button>
                <div class="accordion-content hidden" id="section15" role="region" aria-labelledby="accordion1" style="height: 15%;">
                    <div>
                        <table id="registros_ma">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cidade</th>
                                    <th>CEP</th>
                                    <th>Estado</th>
                                    <th>UF</th>
                                    <th>Ações</th> <!-- Nova coluna para os botões de ação -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dados serão preenchidos via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="accordion-item" id="accordion-registros-mg">
                <button class="accordion-header" aria-expanded="false" aria-controls="section16" id="accordion1">
                    Espírito Santo
                    <span class="accordion-arrow">▼</span>
                </button>
                <div class="accordion-content hidden" id="section16" role="region" aria-labelledby="accordion1" style="height: 15%;">
                    <div>
                        <table id="registros_es">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cidade</th>
                                    <th>CEP</th>
                                    <th>Estado</th>
                                    <th>UF</th>
                                    <th>Ações</th> <!-- Nova coluna para os botões de ação -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dados serão preenchidos via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="accordion-item" id="accordion-registros-mg">
                <button class="accordion-header" aria-expanded="false" aria-controls="section17" id="accordion1">
                    Amapá
                    <span class="accordion-arrow">▼</span>
                </button>
                <div class="accordion-content hidden" id="section17" role="region" aria-labelledby="accordion1" style="height: 15%;">
                    <div>
                        <table id="registros_ap">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cidade</th>
                                    <th>CEP</th>
                                    <th>Estado</th>
                                    <th>UF</th>
                                    <th>Ações</th> <!-- Nova coluna para os botões de ação -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dados serão preenchidos via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="accordion-item" id="accordion-registros-mg">
                <button class="accordion-header" aria-expanded="false" aria-controls="section18" id="accordion1">
                    Rio Grande do Norte
                    <span class="accordion-arrow">▼</span>
                </button>
                <div class="accordion-content hidden" id="section18" role="region" aria-labelledby="accordion1" style="height: 15%;">
                    <div>
                        <table id="registros_rn">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cidade</th>
                                    <th>CEP</th>
                                    <th>Estado</th>
                                    <th>UF</th>
                                    <th>Ações</th> <!-- Nova coluna para os botões de ação -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dados serão preenchidos via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="accordion-item" id="accordion-registros-mg">
                <button class="accordion-header" aria-expanded="false" aria-controls="section19" id="accordion1">
                    Paraíba
                    <span class="accordion-arrow">▼</span>
                </button>
                <div class="accordion-content hidden" id="section19" role="region" aria-labelledby="accordion1" style="height: 15%;">
                    <div>
                        <table id="registros_pb">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cidade</th>
                                    <th>CEP</th>
                                    <th>Estado</th>
                                    <th>UF</th>
                                    <th>Ações</th> <!-- Nova coluna para os botões de ação -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dados serão preenchidos via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="accordion-item" id="accordion-registros-mg">
                <button class="accordion-header" aria-expanded="false" aria-controls="section20" id="accordion1">
                    Acre
                    <span class="accordion-arrow">▼</span>
                </button>
                <div class="accordion-content hidden" id="section20" role="region" aria-labelledby="accordion1" style="height: 15%;">
                    <div>
                        <table id="registros_ac">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cidade</th>
                                    <th>CEP</th>
                                    <th>Estado</th>
                                    <th>UF</th>
                                    <th>Ações</th> <!-- Nova coluna para os botões de ação -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dados serão preenchidos via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="accordion-item" id="accordion-registros-mg">
                <button class="accordion-header" aria-expanded="false" aria-controls="section21" id="accordion1">
                    Alagoas
                    <span class="accordion-arrow">▼</span>
                </button>
                <div class="accordion-content hidden" id="section21" role="region" aria-labelledby="accordion1" style="height: 15%;">
                    <div>
                        <table id="registros_al">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cidade</th>
                                    <th>CEP</th>
                                    <th>Estado</th>
                                    <th>UF</th>
                                    <th>Ações</th> <!-- Nova coluna para os botões de ação -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dados serão preenchidos via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="accordion-item" id="accordion-registros-mg">
                <button class="accordion-header" aria-expanded="false" aria-controls="section22" id="accordion1">
                    Tocantins
                    <span class="accordion-arrow">▼</span>
                </button>
                <div class="accordion-content hidden" id="section22" role="region" aria-labelledby="accordion1" style="height: 15%;">
                    <div>
                        <table id="registros_to">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cidade</th>
                                    <th>CEP</th>
                                    <th>Estado</th>
                                    <th>UF</th>
                                    <th>Ações</th> <!-- Nova coluna para os botões de ação -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dados serão preenchidos via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="accordion-item" id="accordion-registros-mg">
                <button class="accordion-header" aria-expanded="false" aria-controls="section23" id="accordion1">
                    Piauí
                    <span class="accordion-arrow">▼</span>
                </button>
                <div class="accordion-content hidden" id="section23" role="region" aria-labelledby="accordion1" style="height: 15%;">
                    <div>
                        <table id="registros_pi">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cidade</th>
                                    <th>CEP</th>
                                    <th>Estado</th>
                                    <th>UF</th>
                                    <th>Ações</th> <!-- Nova coluna para os botões de ação -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dados serão preenchidos via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="accordion-item" id="accordion-registros-mg">
                <button class="accordion-header" aria-expanded="false" aria-controls="section24" id="accordion1">
                    Roraima
                    <span class="accordion-arrow">▼</span>
                </button>
                <div class="accordion-content hidden" id="section24" role="region" aria-labelledby="accordion1" style="height: 15%;">
                    <div>
                        <table id="registros_rr">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cidade</th>
                                    <th>CEP</th>
                                    <th>Estado</th>
                                    <th>UF</th>
                                    <th>Ações</th> <!-- Nova coluna para os botões de ação -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dados serão preenchidos via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="accordion-item" id="accordion-registros-mg">
                <button class="accordion-header" aria-expanded="false" aria-controls="section25" id="accordion1">
                    Rondônia
                    <span class="accordion-arrow">▼</span>
                </button>
                <div class="accordion-content hidden" id="section25" role="region" aria-labelledby="accordion1" style="height: 15%;">
                    <div>
                        <table id="registros_ro">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cidade</th>
                                    <th>CEP</th>
                                    <th>Estado</th>
                                    <th>UF</th>
                                    <th>Ações</th> <!-- Nova coluna para os botões de ação -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dados serão preenchidos via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="accordion-item" id="accordion-registros-mg">
                <button class="accordion-header" aria-expanded="false" aria-controls="section26" id="accordion1">
                    Distrito Federal
                    <span class="accordion-arrow">▼</span>
                </button>
                <div class="accordion-content hidden" id="section26" role="region" aria-labelledby="accordion1" style="height: 15%;">
                    <div>
                        <table id="registros_df">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cidade</th>
                                    <th>CEP</th>
                                    <th>Estado</th>
                                    <th>UF</th>
                                    <th>Ações</th> <!-- Nova coluna para os botões de ação -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dados serão preenchidos via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="accordion-item" id="accordion-registros-mg">
                <button class="accordion-header" aria-expanded="false" aria-controls="section27" id="accordion1">
                    Sergipe
                    <span class="accordion-arrow">▼</span>
                </button>
                <div class="accordion-content hidden" id="section27" role="region" aria-labelledby="accordion1" style="height: 15%;">
                    <div>
                        <table id="registros_se">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cidade</th>
                                    <th>CEP</th>
                                    <th>Estado</th>
                                    <th>UF</th>
                                    <th>Ações</th> <!-- Nova coluna para os botões de ação -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dados serão preenchidos via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- <div class="accordion-item" id="accordion-registros-mg">
                <button class="accordion-header" aria-expanded="false" aria-controls="section28" id="accordion1">
                    Rio Grande do Sul
                    <span class="accordion-arrow">▼</span>
                </button>
                <div class="accordion-content hidden" id="section28" role="region" aria-labelledby="accordion1" style="height: 15%;">
                    <div>
                        <table id="registros_rs">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cidade</th>
                                    <th>CEP</th>
                                    <th>Estado</th>
                                    <th>UF</th>
                                    <th>Ações</th> Nova coluna para os botões de ação
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

<style>
    .tab-container {
        width: 100%;
    }

    .tab-buttons {
        display: flex;
        border-bottom: 1px solid #ccc;
    }

    .tab-button {
        padding: 10px 20px;
        cursor: pointer;
        background-color: #f1f1f1;
        border: none;
        outline: none;
        transition: background-color 0.3s;
    }

    .tab-button:hover {
        background-color: #ddd;
    }

    .tab-button.active {
        background-color: rgb(59, 59, 59);
        color: white;
    }

    .tab-content {
        display: none;
        padding: 20px;
        border: none;
        border-top: none;
    }

    .tab-content.active {
        display: block;
    }

    .custom-form .form-columns {
        display: flex;
        gap: 20px;
    }

    .custom-form .form-column {
        flex: 1;
    }

    .custom-form .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        font-size: 11px;
        color: #888;
    }

    .custom-form .form-control {
        width: 100%;
        padding: 12px 12px 12px 40px;
        border: none;
        border-radius: 8px;
        box-shadow: 0px 3px 5px -3px rgba(0, 0, 0, 0.1);
    }

    .input-with-icon {
        position: relative;
    }

    .input-with-icon i {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: #888;
    }

    .status-toggle {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .status-toggle .toggle-checkbox {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .status-toggle .toggle-label {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }

    .status-toggle .toggle-label:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    .status-toggle .toggle-checkbox:checked+.toggle-label {
        background-color: #4CAF50;
    }

    .status-toggle .toggle-checkbox:checked+.toggle-label:before {
        transform: translateX(26px);
    }

    .btn-primary {
        padding: 10px 20px;
        background-color: rgb(72, 74, 77);
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    /* Ajuste para o campo de data e hora */
    input[type="datetime-local"] {
        width: auto;
        /* Define a largura automática */
        max-width: 300px;
        /* Define uma largura máxima */
    }

    /* Estilo para o container de endereço */
    .address-container {
        display: flex;
        gap: 10px;
    }

    /* Estilo para o input de CNPJ */
    .cnpj-input {
        border: none;
        background-color: rgb(201, 201, 201);
        font-weight: bold;
        color: black;
    }


    .cnpj-input:focus {
        border-color: #45a049;
        box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
    }

    .botao-cinza {
        background-color: #6c757d;
        /* cinza escuro */
        color: white;
        /* texto branco */
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
    }

    .botao-cinza:hover {
        background-color: #5a6268;
        /* cinza mais escuro no hover */
    }

    .accordion {
        margin-top: 30px;
    }

    .accordion-item {
        margin-bottom: 15px;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .accordion-header {
        width: 100%;
        text-align: left;
        background-color: #f1f1f1;
        color: #333;
        font-weight: 600;
        padding: 14px 20px;
        /* Ajuste do padding do cabeçalho */
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .accordion-header:hover {
        background-color: #ddd;
    }

    .accordion-header[aria-expanded="true"] {
        background-color: #ccc;
    }

    .accordion-content {
        padding: 20px 30px;
        /* Aumentei o padding interno */
        background-color: #fafafa;
        color: #555;
        line-height: 1.6;
        font-size: 14px;
    }

    .accordion-content.hidden {
        display: none;
    }


    /* Botões de salvar e cancelar ajustados */
    #grava-medico,
    #retornar-listagem-medicos {
        margin-top: 20px;
    }

    /* Ajuste opcional no botão 'Cancelar' */
    #retornar-listagem-medicos.botao-cinza {
        background-color: #bbb;
        color: #333;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        cursor: pointer;
    }

    #retornar-listagem-medicos.botao-cinza:hover {
        background-color: #999;
    }

    /* Ajuste no container */
    .tab-content {
        background-color: #f9f9f9;
        border-radius: 8px;
        padding: 20px;
    }

    .hidden {
        display: none;
    }

    .accordion-content {
        padding: 10px;
        background-color: #f2f2f2;
        border: 1px solid #ddd;
    }

    #registros_mt {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #registros_mt th,
    #registros_mt td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #registros_mt th {
        background-color: #f2f2f2;
        font-weight: bold;
    }


    #registros_ms {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #registros_ms th,
    #registros_ms td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #registros_ms th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    #registros_bh {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #registros_bh th,
    #registros_bh td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #registros_bh th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    #registros_mg {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #registros_mg th,
    #registros_mg td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #registros_mg th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    #registros_sp {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #registros_sp th,
    #registros_sp td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #registros_sp th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    #registros_sc {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #registros_sc th,
    #registros_sc td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #registros_sc th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    #registros_pr {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #registros_pr th,
    #registros_pr td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #registros_pr th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    #registros_rs {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #registros_rs th,
    #registros_rs td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #registros_rs th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    #registros_go {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #registros_go th,
    #registros_go td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #registros_go th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    #registros_ce {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #registros_ce th,
    #registros_ce td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #registros_ce th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    #registros_am {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #registros_am th,
    #registros_am td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #registros_am th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    #registros_rj {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #registros_rj th,
    #registros_rj td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #registros_rj th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    #registros_pa {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #registros_pa th,
    #registros_pa td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #registros_pa th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    #registros_pe {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #registros_pe th,
    #registros_pe td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #registros_pe th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    #registros_ma {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #registros_ma th,
    #registros_ma td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #registros_ma th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    #registros_es {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #registros_es th,
    #registros_es td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #registros_es th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    #registros_ap {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #registros_ap th,
    #registros_ap td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #registros_ap th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    #registros_rn {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #registros_rn th,
    #registros_rn td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #registros_rn th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    #registros_pb {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #registros_pb th,
    #registros_pb td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #registros_pb th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    #registros_ac {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #registros_ac th,
    #registros_ac td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #registros_ac th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    #registros_al {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #registros_al th,
    #registros_al td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #registros_al th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    #registros_to {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #registros_to th,
    #registros_to td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #registros_to th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    #registros_pi {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #registros_pi th,
    #registros_pi td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #registros_pi th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    #registros_rr {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #registros_rr th,
    #registros_rr td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #registros_rr th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    #registros_ro {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #registros_ro th,
    #registros_ro td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #registros_ro th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    #registros_df {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #registros_df th,
    #registros_df td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #registros_df th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    #registros_se {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #registros_se th,
    #registros_se td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #registros_se th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    /* #registros_rs {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
    }

    #registros_rs th,
    #registros_rs td {
        padding: 10px;
        border: 1px solid #fff;
        text-align: left;

    }

    #registros_rs th {
        background-color: #f2f2f2;
        font-weight: bold;
    } */

    .accordion-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .accordion-arrow {
        font-size: 16px;
        transition: transform 0.3s ease;
    }

    .accordion-header[aria-expanded="true"] .accordion-arrow {
        transform: rotate(180deg);
    }

    /* Alinhar seletor e busca à direita */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        float: right;
        text-align: right;
        margin-left: 10px;
    }

    /* Alinhar paginação à direita */
    .dataTables_wrapper .dataTables_paginate {
        float: right;
        text-align: right;
        margin-top: 10px;
    }

    /* Estilizar o número da página atual */
    .dataTables_wrapper .dataTables_paginate .current {
        background-color: #3b3b3b;
        color: white;
        border-radius: 4px;
        padding: 5px 10px;
        margin: 0 2px;
    }

    #registros_mt {
        width: 100% !important;
    }

    #registros_ms {
        width: 100% !important;
    }

    #registros_mg {
        width: 100% !important;
    }

    #registros_bh {
        width: 100% !important;
    }

    #registros_sp {
        width: 100% !important;
    }

    #registros_sc {
        width: 100% !important;
    }

    #registros_pr {
        width: 100% !important;
    }

    #registros_rs {
        width: 100% !important;
    }

    #registros_go {
        width: 100% !important;
    }

    #registros_ce {
        width: 100% !important;
    }

    #registros_am {
        width: 100% !important;
    }

    #registros_rj {
        width: 100% !important;
    }

    #registros_pa {
        width: 100% !important;
    }

    #registros_pe {
        width: 100% !important;
    }

    #registros_ma {
        width: 100% !important;
    }

    #registros_es {
        width: 100% !important;
    }

    #registros_ap {
        width: 100% !important;
    }

    #registros_rn {
        width: 100% !important;
    }

    #registros_pb {
        width: 100% !important;
    }

    #registros_ac {
        width: 100% !important;
    }

    #registros_al {
        width: 100% !important;
    }

    #registros_to {
        width: 100% !important;
    }

    #registros_pi {
        width: 100% !important;
    }

    #registros_rr {
        width: 100% !important;
    }

    #registros_ro {
        width: 100% !important;
    }

    #registros_df {
        width: 100% !important;
    }

    #registros_se {
        width: 100% !important;
    }

    /* #registros_rs {
        width: 100% !important;
    } */

    /* Força o alinhamento horizontal entre a info e os botões */
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        display: inline-block;
        vertical-align: middle;
        margin: 0;
        padding: 8px 0;
        /* Ajuste a altura aqui */
    }

    /* Para o container geral da parte inferior do DataTable */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        box-sizing: border-box;
    }

    /* Garante que tudo fique dentro do container da tabela */
    .dataTables_wrapper .dataTables_paginate {
        text-align: right;
        float: right;
    }

    .dataTables_wrapper .dataTables_info {
        float: left;
    }

    /* Limpa margens extras do paginador */
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        margin: 0;
        padding: 4px 8px;
        line-height: 1.5;
        vertical-align: middle;
    }

    /* Ajuste para o layout responsivo da section */
    .dataTables_wrapper .row:last-child {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .dataTables_empty {
        text-align: center !important;
    }


    /* .accordion-content {
        min-height: 150px;
        /* ou outro valor */
</style>

<script>
    let recebe_acao_alteracao_cidade_estado = "cadastrar";

    $(document).ready(function(e) {
        async function buscar_informacoes_cidades_estados() {
            await todas_cidades_estados();
        }

        buscar_informacoes_cidades_estados();

        // $("#mensagem-gravacao").hide();
    });

    document.querySelectorAll('.accordion-header').forEach(button => {
        button.addEventListener('click', () => {
            const expanded = button.getAttribute('aria-expanded') === 'true';
            button.setAttribute('aria-expanded', !expanded);

            const content = document.getElementById(button.getAttribute('aria-controls'));
            content.classList.toggle('hidden');
        });
    });

    async function todas_cidades_estados() {


        return new Promise((resolve, reject) => {
            // Cria um array de Promises para cada chamada AJAX
            const promises = [];


            let totalRequisicoes = 28; // Número de requisições
            let concluidas = 0;
            let erro_ocorrido = false;

            function checkFinalizar() {
                concluidas++;
                if (concluidas === totalRequisicoes && !erro_ocorrido) {
                    resolve(); // Todas concluídas
                }
            }

            function handleErro(err) {
                if (!erro_ocorrido) {
                    erro_ocorrido = true;
                    reject(err);
                }
            }

            // 1️⃣ buscar_cidade_estado_mt
            $.ajax({
                url: "cadastros/processa_cidade_estado.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processa_cidade_estado": "buscar_cidade_estado_mt"
                },
                success: function(resposta_cidade_estado) {
                    atualizarTabela("#registros_mt", resposta_cidade_estado);
                    checkFinalizar();
                },
                error: function(xhr, status, error) {
                    handleErro(error);
                }
            });

            // 2️⃣ buscar_cidade_estado_ms
            $.ajax({
                url: "cadastros/processa_cidade_estado.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processa_cidade_estado": "buscar_cidade_estado_ms"
                },
                success: function(resposta_cidade_estado) {
                    atualizarTabela("#registros_ms", resposta_cidade_estado);
                    checkFinalizar();
                },
                error: function(xhr, status, error) {
                    handleErro(error);
                }
            });

            // 3️⃣ buscar_cidade_estado_bh
            $.ajax({
                url: "cadastros/processa_cidade_estado.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processa_cidade_estado": "buscar_cidade_estado_bh"
                },
                success: function(resposta_cidade_estado) {
                    atualizarTabela("#registros_bh", resposta_cidade_estado);
                    checkFinalizar();
                },
                error: function(xhr, status, error) {
                    handleErro(error);
                }
            });

            // 4️⃣ buscar_cidade_estado_mg
            $.ajax({
                url: "cadastros/processa_cidade_estado.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processa_cidade_estado": "buscar_cidade_estado_mg"
                },
                success: function(resposta_cidade_estado) {
                    atualizarTabela("#registros_mg", resposta_cidade_estado);
                    checkFinalizar();
                },
                error: function(xhr, status, error) {
                    handleErro(error);
                }
            });

            // 4️⃣ buscar_cidade_estado_mg
            $.ajax({
                url: "cadastros/processa_cidade_estado.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processa_cidade_estado": "buscar_cidade_estado_sp"
                },
                success: function(resposta_cidade_estado) {
                    atualizarTabela("#registros_sp", resposta_cidade_estado);
                    checkFinalizar();
                },
                error: function(xhr, status, error) {
                    handleErro(error);
                }
            });

            // 4️⃣ buscar_cidade_estado_mg
            $.ajax({
                url: "cadastros/processa_cidade_estado.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processa_cidade_estado": "buscar_cidade_estado_sc"
                },
                success: function(resposta_cidade_estado) {
                    atualizarTabela("#registros_sc", resposta_cidade_estado);
                    checkFinalizar();
                },
                error: function(xhr, status, error) {
                    handleErro(error);
                }
            });

            // 4️⃣ buscar_cidade_estado_mg
            $.ajax({
                url: "cadastros/processa_cidade_estado.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processa_cidade_estado": "buscar_cidade_estado_pr"
                },
                success: function(resposta_cidade_estado) {
                    atualizarTabela("#registros_pr", resposta_cidade_estado);
                    checkFinalizar();
                },
                error: function(xhr, status, error) {
                    handleErro(error);
                }
            });

            // 4️⃣ buscar_cidade_estado_mg
            $.ajax({
                url: "cadastros/processa_cidade_estado.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processa_cidade_estado": "buscar_cidade_estado_rs"
                },
                success: function(resposta_cidade_estado) {
                    atualizarTabela("#registros_rs", resposta_cidade_estado);
                    checkFinalizar();
                },
                error: function(xhr, status, error) {
                    handleErro(error);
                }
            });

            // 4️⃣ buscar_cidade_estado_mg
            $.ajax({
                url: "cadastros/processa_cidade_estado.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processa_cidade_estado": "buscar_cidade_estado_go"
                },
                success: function(resposta_cidade_estado) {
                    atualizarTabela("#registros_go", resposta_cidade_estado);
                    checkFinalizar();
                },
                error: function(xhr, status, error) {
                    handleErro(error);
                }
            });

            // 4️⃣ buscar_cidade_estado_mg
            $.ajax({
                url: "cadastros/processa_cidade_estado.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processa_cidade_estado": "buscar_cidade_estado_ce"
                },
                success: function(resposta_cidade_estado) {
                    atualizarTabela("#registros_ce", resposta_cidade_estado);
                    checkFinalizar();
                },
                error: function(xhr, status, error) {
                    handleErro(error);
                }
            });

            // 4️⃣ buscar_cidade_estado_mg
            $.ajax({
                url: "cadastros/processa_cidade_estado.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processa_cidade_estado": "buscar_cidade_estado_am"
                },
                success: function(resposta_cidade_estado) {
                    atualizarTabela("#registros_am", resposta_cidade_estado);
                    checkFinalizar();
                },
                error: function(xhr, status, error) {
                    handleErro(error);
                }
            });

            // 4️⃣ buscar_cidade_estado_mg
            $.ajax({
                url: "cadastros/processa_cidade_estado.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processa_cidade_estado": "buscar_cidade_estado_rj"
                },
                success: function(resposta_cidade_estado) {
                    atualizarTabela("#registros_rj", resposta_cidade_estado);
                    checkFinalizar();
                },
                error: function(xhr, status, error) {
                    handleErro(error);
                }
            });

            // 4️⃣ buscar_cidade_estado_mg
            $.ajax({
                url: "cadastros/processa_cidade_estado.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processa_cidade_estado": "buscar_cidade_estado_pa"
                },
                success: function(resposta_cidade_estado) {
                    atualizarTabela("#registros_pa", resposta_cidade_estado);
                    checkFinalizar();
                },
                error: function(xhr, status, error) {
                    handleErro(error);
                }
            });

            // 4️⃣ buscar_cidade_estado_mg
            $.ajax({
                url: "cadastros/processa_cidade_estado.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processa_cidade_estado": "buscar_cidade_estado_pe"
                },
                success: function(resposta_cidade_estado) {
                    atualizarTabela("#registros_pe", resposta_cidade_estado);
                    checkFinalizar();
                },
                error: function(xhr, status, error) {
                    handleErro(error);
                }
            });

            // 4️⃣ buscar_cidade_estado_mg
            $.ajax({
                url: "cadastros/processa_cidade_estado.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processa_cidade_estado": "buscar_cidade_estado_ma"
                },
                success: function(resposta_cidade_estado) {
                    atualizarTabela("#registros_ma", resposta_cidade_estado);
                    checkFinalizar();
                },
                error: function(xhr, status, error) {
                    handleErro(error);
                }
            });

            // 4️⃣ buscar_cidade_estado_mg
            $.ajax({
                url: "cadastros/processa_cidade_estado.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processa_cidade_estado": "buscar_cidade_estado_es"
                },
                success: function(resposta_cidade_estado) {
                    atualizarTabela("#registros_es", resposta_cidade_estado);
                    checkFinalizar();
                },
                error: function(xhr, status, error) {
                    handleErro(error);
                }
            });

            // 4️⃣ buscar_cidade_estado_mg
            $.ajax({
                url: "cadastros/processa_cidade_estado.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processa_cidade_estado": "buscar_cidade_estado_ap"
                },
                success: function(resposta_cidade_estado) {
                    atualizarTabela("#registros_ap", resposta_cidade_estado);
                    checkFinalizar();
                },
                error: function(xhr, status, error) {
                    handleErro(error);
                }
            });

            // 4️⃣ buscar_cidade_estado_mg
            $.ajax({
                url: "cadastros/processa_cidade_estado.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processa_cidade_estado": "buscar_cidade_estado_rn"
                },
                success: function(resposta_cidade_estado) {
                    atualizarTabela("#registros_rn", resposta_cidade_estado);
                    checkFinalizar();
                },
                error: function(xhr, status, error) {
                    handleErro(error);
                }
            });

            // 4️⃣ buscar_cidade_estado_mg
            $.ajax({
                url: "cadastros/processa_cidade_estado.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processa_cidade_estado": "buscar_cidade_estado_pb"
                },
                success: function(resposta_cidade_estado) {
                    atualizarTabela("#registros_pb", resposta_cidade_estado);
                    checkFinalizar();
                },
                error: function(xhr, status, error) {
                    handleErro(error);
                }
            });

            // 4️⃣ buscar_cidade_estado_mg
            $.ajax({
                url: "cadastros/processa_cidade_estado.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processa_cidade_estado": "buscar_cidade_estado_ac"
                },
                success: function(resposta_cidade_estado) {
                    atualizarTabela("#registros_ac", resposta_cidade_estado);
                    checkFinalizar();
                },
                error: function(xhr, status, error) {
                    handleErro(error);
                }
            });

            // 4️⃣ buscar_cidade_estado_mg
            $.ajax({
                url: "cadastros/processa_cidade_estado.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processa_cidade_estado": "buscar_cidade_estado_al"
                },
                success: function(resposta_cidade_estado) {
                    atualizarTabela("#registros_al", resposta_cidade_estado);
                    checkFinalizar();
                },
                error: function(xhr, status, error) {
                    handleErro(error);
                }
            });

            // 4️⃣ buscar_cidade_estado_mg
            $.ajax({
                url: "cadastros/processa_cidade_estado.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processa_cidade_estado": "buscar_cidade_estado_to"
                },
                success: function(resposta_cidade_estado) {
                    atualizarTabela("#registros_to", resposta_cidade_estado);
                    checkFinalizar();
                },
                error: function(xhr, status, error) {
                    handleErro(error);
                }
            });

            // 4️⃣ buscar_cidade_estado_mg
            $.ajax({
                url: "cadastros/processa_cidade_estado.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processa_cidade_estado": "buscar_cidade_estado_pi"
                },
                success: function(resposta_cidade_estado) {
                    atualizarTabela("#registros_pi", resposta_cidade_estado);
                    checkFinalizar();
                },
                error: function(xhr, status, error) {
                    handleErro(error);
                }
            });

            // 4️⃣ buscar_cidade_estado_mg
            $.ajax({
                url: "cadastros/processa_cidade_estado.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processa_cidade_estado": "buscar_cidade_estado_rr"
                },
                success: function(resposta_cidade_estado) {
                    atualizarTabela("#registros_rr", resposta_cidade_estado);
                    checkFinalizar();
                },
                error: function(xhr, status, error) {
                    handleErro(error);
                }
            });

            // 4️⃣ buscar_cidade_estado_mg
            $.ajax({
                url: "cadastros/processa_cidade_estado.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processa_cidade_estado": "buscar_cidade_estado_ro"
                },
                success: function(resposta_cidade_estado) {
                    atualizarTabela("#registros_ro", resposta_cidade_estado);
                    checkFinalizar();
                },
                error: function(xhr, status, error) {
                    handleErro(error);
                }
            });

            // 4️⃣ buscar_cidade_estado_mg
            $.ajax({
                url: "cadastros/processa_cidade_estado.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processa_cidade_estado": "buscar_cidade_estado_df"
                },
                success: function(resposta_cidade_estado) {
                    atualizarTabela("#registros_df", resposta_cidade_estado);
                    checkFinalizar();
                },
                error: function(xhr, status, error) {
                    handleErro(error);
                }
            });

            // 4️⃣ buscar_cidade_estado_mg
            $.ajax({
                url: "cadastros/processa_cidade_estado.php",
                method: "GET",
                dataType: "json",
                data: {
                    "processa_cidade_estado": "buscar_cidade_estado_se"
                },
                success: function(resposta_cidade_estado) {
                    atualizarTabela("#registros_se", resposta_cidade_estado);
                    checkFinalizar();
                },
                error: function(xhr, status, error) {
                    handleErro(error);
                }
            });

            // 4️⃣ buscar_cidade_estado_mg
            // $.ajax({
            //     url: "cadastros/processa_cidade_estado.php",
            //     method: "GET",
            //     dataType: "json",
            //     data: {
            //         "processa_cidade_estado": "buscar_cidade_estado_rs"
            //     },
            //     success: function(resposta_cidade_estado) {
            //         atualizarTabela("#registros_rs", resposta_cidade_estado);
            //         checkFinalizar();
            //     },
            //     error: function(xhr, status, error) {
            //         handleErro(error);
            //     }
            // });
        });







        // return new Promise((resolve, reject) => {
        //     $.ajax({
        //         url: "cadastros/processa_cidade_estado.php",
        //         method: "GET",
        //         dataType: "json",
        //         data: {
        //             "processa_cidade_estado": "buscar_cidade_estado_mt",
        //         },
        //         success: function(resposta_cidade_estado) {
        //             debugger;
        //             console.log(resposta_cidade_estado);

        //             if ($.fn.dataTable.isDataTable('#registros_mt')) {
        //                 $('#registros_mt').DataTable().clear().destroy();
        //             }

        //             // Limpa o tbody manualmente (opcional, mas recomendado)
        //             $("#registros_mt tbody").empty();

        //             let corpo = document.querySelector("#registros_mt tbody");
        //             corpo.innerHTML = "";

        //             if (resposta_cidade_estado.length > 0) {
        //                 // $("#risco_ergonomico tbody").html("");
        //                 for (let index = 0; index < resposta_cidade_estado.length; index++) {
        //                     let cidade_estado = resposta_cidade_estado[index];
        //                     // let resultado = risco.grupo_risco !== "" ? "Ergonômico" : "";

        //                     let linha = document.createElement("tr");
        //                     linha.innerHTML = `
        //             <td>${cidade_estado.id}</td>
        //             <td>${cidade_estado.nome}</td>
        //             <td>${cidade_estado.cep}</td>
        //             <td>${cidade_estado.estado}</td>
        //             <td>${cidade_estado.uf}</td>
        //             <td>
        //                 <div class='action-buttons'>
        //                     <a href='#' id='alterar-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" data-cidade="${cidade_estado.nome}"
        //                     data-cep="${cidade_estado.cep}" data-estado="${cidade_estado.estado}" data-estado-uf="${cidade_estado.uf}" title='Editar'><i class="fas fa-edit"></i></a>
        //                     <a href='#' id='excluir-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" class='delete' title='Apagar'><i class="fas fa-trash"></i></a>
        //                 </div>
        //             </td>`;
        //                     corpo.appendChild(linha);
        //                 }
        //             } else {
        //                 $("#registros_mt tbody").append("<tr><td colspan='9' style='text-align:center;'>Nenhum registro localizado</td></tr>");
        //             }

        //             // 🧹 Destrói o DataTable antigo antes de recriar
        //             if ($.fn.dataTable.isDataTable('#registros_mt')) {
        //                 $('#registros_mt').DataTable().destroy();
        //             }

        //             $("#registros_mt").DataTable({
        //                 "language": {
        //                     "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
        //                 },
        //                 "dom": '<"top"lf>rt<"bottom"ip><"clear">',
        //                 "pageLength": 5, // Exibir 5 registros por página
        //                 "lengthMenu": [
        //                     [5, 10, 25, 50, -1],
        //                     [5, 10, 25, 50, "Todos"]
        //                 ]
        //             });
        //             resolve();

        //         },
        //         error: function(xhr, status, error) {
        //             console.error("Erro ao carregar dados:", error);
        //             reject(error);
        //         },
        //     });

        //     $.ajax({
        //         url: "cadastros/processa_cidade_estado.php",
        //         method: "GET",
        //         dataType: "json",
        //         data: {
        //             "processa_cidade_estado": "buscar_cidade_estado_ms",
        //         },
        //         success: function(resposta_cidade_estado) {
        //             debugger;
        //             console.log(resposta_cidade_estado);

        //             if ($.fn.dataTable.isDataTable('#registros_ms')) {
        //                 $('#registros_ms').DataTable().clear().destroy();
        //             }

        //             // Limpa o tbody manualmente (opcional, mas recomendado)
        //             $("#registros_ms tbody").empty();

        //             let corpo = document.querySelector("#registros_ms tbody");
        //             corpo.innerHTML = "";

        //             if (resposta_cidade_estado.length > 0) {
        //                 // $("#risco_ergonomico tbody").html("");
        //                 for (let index = 0; index < resposta_cidade_estado.length; index++) {
        //                     let cidade_estado = resposta_cidade_estado[index];
        //                     // let resultado = risco.grupo_risco !== "" ? "Ergonômico" : "";

        //                     let linha = document.createElement("tr");
        //                     linha.innerHTML = `
        //             <td>${cidade_estado.id}</td>
        //             <td>${cidade_estado.nome}</td>
        //             <td>${cidade_estado.cep}</td>
        //             <td>${cidade_estado.estado}</td>
        //             <td>${cidade_estado.uf}</td>
        //             <td>
        //                 <div class='action-buttons'>
        //                     <a href='#' id='alterar-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" data-cidade="${cidade_estado.nome}"
        //                     data-cep="${cidade_estado.cep}" data-estado="${cidade_estado.estado}" data-estado-uf="${cidade_estado.uf}" title='Editar'><i class="fas fa-edit"></i></a>
        //                     <a href='#' id='excluir-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" class='delete' title='Apagar'><i class="fas fa-trash"></i></a>
        //                 </div>
        //             </td>`;
        //                     corpo.appendChild(linha);
        //                 }
        //             } else {
        //                 $("#registros_ms tbody").append("<tr><td colspan='9' style='text-align:center;'>Nenhum registro localizado</td></tr>");
        //             }

        //             // 🧹 Destrói o DataTable antigo antes de recriar
        //             if ($.fn.dataTable.isDataTable('#registros_ms')) {
        //                 $('#registros_ms').DataTable().destroy();
        //             }

        //             $("#registros_ms").DataTable({
        //                 "language": {
        //                     "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
        //                 },
        //                 "dom": '<"top"lf>rt<"bottom"ip><"clear">',
        //                 "pageLength": 5, // Exibir 5 registros por página
        //                 "lengthMenu": [
        //                     [5, 10, 25, 50, -1],
        //                     [5, 10, 25, 50, "Todos"]
        //                 ]
        //             });
        //             resolve();

        //         },
        //         error: function(xhr, status, error) {
        //             console.error("Erro ao carregar dados:", error);
        //             reject(error);
        //         },
        //     });

        //     $.ajax({
        //         url: "cadastros/processa_cidade_estado.php",
        //         method: "GET",
        //         dataType: "json",
        //         data: {
        //             "processa_cidade_estado": "buscar_cidade_estado_bh",
        //         },
        //         success: function(resposta_cidade_estado) {
        //             debugger;
        //             console.log(resposta_cidade_estado);

        //             if ($.fn.dataTable.isDataTable('#registros_bh')) {
        //                 $('#registros_bh').DataTable().clear().destroy();
        //             }

        //             // Limpa o tbody manualmente (opcional, mas recomendado)
        //             $("#registros_bh tbody").empty();

        //             let corpo = document.querySelector("#registros_bh tbody");
        //             corpo.innerHTML = "";

        //             if (resposta_cidade_estado.length > 0) {
        //                 // $("#risco_ergonomico tbody").html("");
        //                 for (let index = 0; index < resposta_cidade_estado.length; index++) {
        //                     let cidade_estado = resposta_cidade_estado[index];
        //                     // let resultado = risco.grupo_risco !== "" ? "Ergonômico" : "";

        //                     let linha = document.createElement("tr");
        //                     linha.innerHTML = `
        //             <td>${cidade_estado.id}</td>
        //             <td>${cidade_estado.nome}</td>
        //             <td>${cidade_estado.cep}</td>
        //             <td>${cidade_estado.estado}</td>
        //             <td>${cidade_estado.uf}</td>
        //             <td>
        //                 <div class='action-buttons'>
        //                     <a href='#' id='alterar-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" data-cidade="${cidade_estado.nome}"
        //                     data-cep="${cidade_estado.cep}" data-estado="${cidade_estado.estado}" data-estado-uf="${cidade_estado.uf}" title='Editar'><i class="fas fa-edit"></i></a>
        //                     <a href='#' id='excluir-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" class='delete' title='Apagar'><i class="fas fa-trash"></i></a>
        //                 </div>
        //             </td>`;
        //                     corpo.appendChild(linha);
        //                 }
        //             } else {
        //                 $("#registros_bh tbody").append("<tr><td colspan='9' style='text-align:center;'>Nenhum registro localizado</td></tr>");
        //             }

        //             // 🧹 Destrói o DataTable antigo antes de recriar
        //             if ($.fn.dataTable.isDataTable('#registros_bh')) {
        //                 $('#registros_bh').DataTable().destroy();
        //             }

        //             $("#registros_bh").DataTable({
        //                 "language": {
        //                     "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
        //                 },
        //                 "dom": '<"top"lf>rt<"bottom"ip><"clear">',
        //                 "pageLength": 5, // Exibir 5 registros por página
        //                 "lengthMenu": [
        //                     [5, 10, 25, 50, -1],
        //                     [5, 10, 25, 50, "Todos"]
        //                 ]
        //             });
        //             resolve();

        //         },
        //         error: function(xhr, status, error) {
        //             console.error("Erro ao carregar dados:", error);
        //             reject(error);
        //         },
        //     });

        //     $.ajax({
        //         url: "cadastros/processa_cidade_estado.php",
        //         method: "GET",
        //         dataType: "json",
        //         data: {
        //             "processa_cidade_estado": "buscar_cidade_estado_mg",
        //         },
        //         success: function(resposta_cidade_estado) {
        //             // ⚠️ Verifica e destrói o DataTables uma vez
        //             if ($.fn.DataTable.isDataTable('#registros_mg')) {
        //                 $('#registros_mg').DataTable().clear().destroy();
        //             }

        //             // Limpa o tbody
        //             let corpo = document.querySelector("#registros_mg tbody");
        //             corpo.innerHTML = "";

        //             // Popula a tabela
        //             if (resposta_cidade_estado.length > 0) {
        //                 resposta_cidade_estado.forEach((cidade_estado) => {
        //                     let linha = document.createElement("tr");
        //                     linha.innerHTML = `
        //   <td>${cidade_estado.id}</td>
        //   <td>${cidade_estado.nome}</td>
        //   <td>${cidade_estado.cep}</td>
        //   <td>${cidade_estado.estado}</td>
        //   <td>${cidade_estado.uf}</td>
        //   <td>
        //     <div class='action-buttons'>
        //       <a href='#' id='alterar-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" data-cidade="${cidade_estado.nome}"
        //       data-cep="${cidade_estado.cep}" data-estado="${cidade_estado.estado}" data-estado-uf="${cidade_estado.uf}" title='Editar'><i class="fas fa-edit"></i></a>
        //       <a href='#' id='excluir-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" class='delete' title='Apagar'><i class="fas fa-trash"></i></a>
        //     </div>
        //   </td>`;
        //                     corpo.appendChild(linha);
        //                 });
        //             } else {
        //                 corpo.innerHTML = "<tr><td colspan='6' style='text-align:center;'>Nenhum registro localizado</td></tr>";
        //             }

        //             // Recria o DataTables apenas uma vez
        //             $('#registros_mg').DataTable({
        //                 "language": {
        //                     "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
        //                 },
        //                 "dom": '<"top"lf>rt<"bottom"ip><"clear">',
        //                 "pageLength": 5,
        //                 "lengthMenu": [
        //                     [5, 10, 25, 50, -1],
        //                     [5, 10, 25, 50, "Todos"]
        //                 ]
        //             });
        //         },
        //         error: function(xhr, status, error) {
        //             console.error("Erro ao carregar dados:", error);
        //         },
        //     });


        //     $.ajax({
        //         url: "cadastros/processa_cidade_estado.php",
        //         method: "GET",
        //         dataType: "json",
        //         data: {
        //             "processa_cidade_estado": "buscar_cidade_estado_sp",
        //         },
        //         success: function(resposta_cidade_estado) {
        //             debugger;
        //             console.log(resposta_cidade_estado);

        //             if ($.fn.dataTable.isDataTable('#registros_sp')) {
        //                 $('#registros_sp').DataTable().clear().destroy();
        //             }

        //             // Limpa o tbody manualmente (opcional, mas recomendado)
        //             $("#registros_sp tbody").empty();

        //             let corpo = document.querySelector("#registros_sp tbody");
        //             corpo.innerHTML = "";

        //             if (resposta_cidade_estado.length > 0) {
        //                 // $("#risco_ergonomico tbody").html("");
        //                 for (let index = 0; index < resposta_cidade_estado.length; index++) {
        //                     let cidade_estado = resposta_cidade_estado[index];
        //                     // let resultado = risco.grupo_risco !== "" ? "Ergonômico" : "";

        //                     let linha = document.createElement("tr");
        //                     linha.innerHTML = `
        //             <td>${cidade_estado.id}</td>
        //             <td>${cidade_estado.nome}</td>
        //             <td>${cidade_estado.cep}</td>
        //             <td>${cidade_estado.estado}</td>
        //             <td>${cidade_estado.uf}</td>
        //             <td>
        //                 <div class='action-buttons'>
        //                     <a href='#' id='alterar-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" data-cidade="${cidade_estado.nome}"
        //                     data-cep="${cidade_estado.cep}" data-estado="${cidade_estado.estado}" data-estado-uf="${cidade_estado.uf}" title='Editar'><i class="fas fa-edit"></i></a>
        //                     <a href='#' id='excluir-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" class='delete' title='Apagar'><i class="fas fa-trash"></i></a>
        //                 </div>
        //             </td>`;
        //                     corpo.appendChild(linha);
        //                 }
        //             } else {
        //                 $("#registros_sp tbody").append("<tr><td colspan='9' style='text-align:center;'>Nenhum registro localizado</td></tr>");
        //             }

        //             // 🧹 Destrói o DataTable antigo antes de recriar
        //             if ($.fn.dataTable.isDataTable('#registros_sp')) {
        //                 $('#registros_sp').DataTable().destroy();
        //             }

        //             $("#registros_sp").DataTable({
        //                 "language": {
        //                     "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
        //                 },
        //                 "dom": '<"top"lf>rt<"bottom"ip><"clear">',
        //                 "pageLength": 5, // Exibir 5 registros por página
        //                 "lengthMenu": [
        //                     [5, 10, 25, 50, -1],
        //                     [5, 10, 25, 50, "Todos"]
        //                 ]
        //             });

        //             resolve();
        //         },
        //         error: function(xhr, status, error) {
        //             console.error("Erro ao carregar dados:", error);
        //             reject(error);
        //         },
        //     });



        //     $.ajax({
        //         url: "cadastros/processa_cidade_estado.php",
        //         method: "GET",
        //         dataType: "json",
        //         data: {
        //             "processa_cidade_estado": "buscar_cidade_estado_sc",
        //         },
        //         success: function(resposta_cidade_estado) {
        //             debugger;
        //             console.log(resposta_cidade_estado);

        //             if ($.fn.dataTable.isDataTable('#registros_sc')) {
        //                 $('#registros_sc').DataTable().clear().destroy();
        //             }

        //             // Limpa o tbody manualmente (opcional, mas recomendado)
        //             $("#registros_sc tbody").empty();

        //             let corpo = document.querySelector("#registros_sc tbody");
        //             corpo.innerHTML = "";

        //             if (resposta_cidade_estado.length > 0) {
        //                 // $("#risco_ergonomico tbody").html("");
        //                 for (let index = 0; index < resposta_cidade_estado.length; index++) {
        //                     let cidade_estado = resposta_cidade_estado[index];
        //                     // let resultado = risco.grupo_risco !== "" ? "Ergonômico" : "";

        //                     let linha = document.createElement("tr");
        //                     linha.innerHTML = `
        //             <td>${cidade_estado.id}</td>
        //             <td>${cidade_estado.nome}</td>
        //             <td>${cidade_estado.cep}</td>
        //             <td>${cidade_estado.estado}</td>
        //             <td>${cidade_estado.uf}</td>
        //             <td>
        //                 <div class='action-buttons'>
        //                     <a href='#' id='alterar-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" data-cidade="${cidade_estado.nome}"
        //                     data-cep="${cidade_estado.cep}" data-estado="${cidade_estado.estado}" data-estado-uf="${cidade_estado.uf}" title='Editar'><i class="fas fa-edit"></i></a>
        //                     <a href='#' id='excluir-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" class='delete' title='Apagar'><i class="fas fa-trash"></i></a>
        //                 </div>
        //             </td>`;
        //                     corpo.appendChild(linha);
        //                 }
        //             } else {
        //                 $("#registros_sc tbody").append("<tr><td colspan='9' style='text-align:center;'>Nenhum registro localizado</td></tr>");
        //             }

        //             // 🧹 Destrói o DataTable antigo antes de recriar
        //             if ($.fn.dataTable.isDataTable('#registros_sc')) {
        //                 $('#registros_sc').DataTable().destroy();
        //             }

        //             $("#registros_sc").DataTable({
        //                 "language": {
        //                     "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
        //                 },
        //                 "dom": '<"top"lf>rt<"bottom"ip><"clear">',
        //                 "pageLength": 5, // Exibir 5 registros por página
        //                 "lengthMenu": [
        //                     [5, 10, 25, 50, -1],
        //                     [5, 10, 25, 50, "Todos"]
        //                 ]
        //             });

        //             resolve();
        //         },
        //         error: function(xhr, status, error) {
        //             console.error("Erro ao carregar dados:", error);
        //             reject(error);
        //         },
        //     });

        //     $.ajax({
        //         url: "cadastros/processa_cidade_estado.php",
        //         method: "GET",
        //         dataType: "json",
        //         data: {
        //             "processa_cidade_estado": "buscar_cidade_estado_pr",
        //         },
        //         success: function(resposta_cidade_estado) {
        //             debugger;
        //             console.log(resposta_cidade_estado);

        //             if ($.fn.dataTable.isDataTable('#registros_pr')) {
        //                 $('#registros_pr').DataTable().clear().destroy();
        //             }

        //             // Limpa o tbody manualmente (opcional, mas recomendado)
        //             $("#registros_pr tbody").empty();

        //             let corpo = document.querySelector("#registros_pr tbody");
        //             corpo.innerHTML = "";

        //             if (resposta_cidade_estado.length > 0) {
        //                 // $("#risco_ergonomico tbody").html("");
        //                 for (let index = 0; index < resposta_cidade_estado.length; index++) {
        //                     let cidade_estado = resposta_cidade_estado[index];
        //                     // let resultado = risco.grupo_risco !== "" ? "Ergonômico" : "";

        //                     let linha = document.createElement("tr");
        //                     linha.innerHTML = `
        //             <td>${cidade_estado.id}</td>
        //             <td>${cidade_estado.nome}</td>
        //             <td>${cidade_estado.cep}</td>
        //             <td>${cidade_estado.estado}</td>
        //             <td>${cidade_estado.uf}</td>
        //             <td>
        //                 <div class='action-buttons'>
        //                     <a href='#' id='alterar-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" data-cidade="${cidade_estado.nome}"
        //                     data-cep="${cidade_estado.cep}" data-estado="${cidade_estado.estado}" data-estado-uf="${cidade_estado.uf}" title='Editar'><i class="fas fa-edit"></i></a>
        //                     <a href='#' id='excluir-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" class='delete' title='Apagar'><i class="fas fa-trash"></i></a>
        //                 </div>
        //             </td>`;
        //                     corpo.appendChild(linha);
        //                 }
        //             } else {
        //                 $("#registros_pr tbody").append("<tr><td colspan='9' style='text-align:center;'>Nenhum registro localizado</td></tr>");
        //             }

        //             // 🧹 Destrói o DataTable antigo antes de recriar
        //             if ($.fn.dataTable.isDataTable('#registros_pr')) {
        //                 $('#registros_pr').DataTable().destroy();
        //             }

        //             $("#registros_pr").DataTable({
        //                 "language": {
        //                     "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
        //                 },
        //                 "dom": '<"top"lf>rt<"bottom"ip><"clear">',
        //                 "pageLength": 5, // Exibir 5 registros por página
        //                 "lengthMenu": [
        //                     [5, 10, 25, 50, -1],
        //                     [5, 10, 25, 50, "Todos"]
        //                 ]
        //             });

        //             resolve();
        //         },
        //         error: function(xhr, status, error) {
        //             console.error("Erro ao carregar dados:", error);
        //             reject(error);
        //         },
        //     });

        //     $.ajax({
        //         url: "cadastros/processa_cidade_estado.php",
        //         method: "GET",
        //         dataType: "json",
        //         data: {
        //             "processa_cidade_estado": "buscar_cidade_estado_rs",
        //         },
        //         success: function(resposta_cidade_estado) {
        //             debugger;
        //             console.log(resposta_cidade_estado);

        //             if ($.fn.dataTable.isDataTable('#registros_rs')) {
        //                 $('#registros_rs').DataTable().clear().destroy();
        //             }

        //             // Limpa o tbody manualmente (opcional, mas recomendado)
        //             $("#registros_rs tbody").empty();

        //             let corpo = document.querySelector("#registros_rs tbody");
        //             corpo.innerHTML = "";

        //             if (resposta_cidade_estado.length > 0) {
        //                 // $("#risco_ergonomico tbody").html("");
        //                 for (let index = 0; index < resposta_cidade_estado.length; index++) {
        //                     let cidade_estado = resposta_cidade_estado[index];
        //                     // let resultado = risco.grupo_risco !== "" ? "Ergonômico" : "";

        //                     let linha = document.createElement("tr");
        //                     linha.innerHTML = `
        //             <td>${cidade_estado.id}</td>
        //             <td>${cidade_estado.nome}</td>
        //             <td>${cidade_estado.cep}</td>
        //             <td>${cidade_estado.estado}</td>
        //             <td>${cidade_estado.uf}</td>
        //             <td>
        //                 <div class='action-buttons'>
        //                     <a href='#' id='alterar-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" data-cidade="${cidade_estado.nome}"
        //                     data-cep="${cidade_estado.cep}" data-estado="${cidade_estado.estado}" data-estado-uf="${cidade_estado.uf}" title='Editar'><i class="fas fa-edit"></i></a>
        //                     <a href='#' id='excluir-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" class='delete' title='Apagar'><i class="fas fa-trash"></i></a>
        //                 </div>
        //             </td>`;
        //                     corpo.appendChild(linha);
        //                 }
        //             } else {
        //                 $("#registros_rs tbody").append("<tr><td colspan='9' style='text-align:center;'>Nenhum registro localizado</td></tr>");
        //             }

        //             // 🧹 Destrói o DataTable antigo antes de recriar
        //             if ($.fn.dataTable.isDataTable('#registros_rs')) {
        //                 $('#registros_rs').DataTable().destroy();
        //             }

        //             $("#registros_rs").DataTable({
        //                 "language": {
        //                     "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
        //                 },
        //                 "dom": '<"top"lf>rt<"bottom"ip><"clear">',
        //                 "pageLength": 5, // Exibir 5 registros por página
        //                 "lengthMenu": [
        //                     [5, 10, 25, 50, -1],
        //                     [5, 10, 25, 50, "Todos"]
        //                 ]
        //             });

        //             resolve();
        //         },
        //         error: function(xhr, status, error) {
        //             console.error("Erro ao carregar dados:", error);

        //             reject(error);
        //         },
        //     });

        //     $.ajax({
        //         url: "cadastros/processa_cidade_estado.php",
        //         method: "GET",
        //         dataType: "json",
        //         data: {
        //             "processa_cidade_estado": "buscar_cidade_estado_go",
        //         },
        //         success: function(resposta_cidade_estado) {
        //             debugger;
        //             console.log(resposta_cidade_estado);

        //             if ($.fn.dataTable.isDataTable('#registros_go')) {
        //                 $('#registros_go').DataTable().clear().destroy();
        //             }

        //             // Limpa o tbody manualmente (opcional, mas recomendado)
        //             $("#registros_go tbody").empty();

        //             let corpo = document.querySelector("#registros_go tbody");
        //             corpo.innerHTML = "";

        //             if (resposta_cidade_estado.length > 0) {
        //                 // $("#risco_ergonomico tbody").html("");
        //                 for (let index = 0; index < resposta_cidade_estado.length; index++) {
        //                     let cidade_estado = resposta_cidade_estado[index];
        //                     // let resultado = risco.grupo_risco !== "" ? "Ergonômico" : "";

        //                     let linha = document.createElement("tr");
        //                     linha.innerHTML = `
        //             <td>${cidade_estado.id}</td>
        //             <td>${cidade_estado.nome}</td>
        //             <td>${cidade_estado.cep}</td>
        //             <td>${cidade_estado.estado}</td>
        //             <td>${cidade_estado.uf}</td>
        //             <td>
        //                 <div class='action-buttons'>
        //                     <a href='#' id='alterar-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" data-cidade="${cidade_estado.nome}"
        //                     data-cep="${cidade_estado.cep}" data-estado="${cidade_estado.estado}" data-estado-uf="${cidade_estado.uf}" title='Editar'><i class="fas fa-edit"></i></a>
        //                     <a href='#' id='excluir-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" class='delete' title='Apagar'><i class="fas fa-trash"></i></a>
        //                 </div>
        //             </td>`;
        //                     corpo.appendChild(linha);
        //                 }
        //             } else {
        //                 $("#registros_go tbody").append("<tr><td colspan='9' style='text-align:center;'>Nenhum registro localizado</td></tr>");
        //             }

        //             // 🧹 Destrói o DataTable antigo antes de recriar
        //             if ($.fn.dataTable.isDataTable('#registros_go')) {
        //                 $('#registros_go').DataTable().destroy();
        //             }

        //             $("#registros_go").DataTable({
        //                 "language": {
        //                     "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
        //                 },
        //                 "dom": '<"top"lf>rt<"bottom"ip><"clear">',
        //                 "pageLength": 5, // Exibir 5 registros por página
        //                 "lengthMenu": [
        //                     [5, 10, 25, 50, -1],
        //                     [5, 10, 25, 50, "Todos"]
        //                 ]
        //             });

        //             resolve();
        //         },
        //         error: function(xhr, status, error) {
        //             console.error("Erro ao carregar dados:", error);
        //             reject(error);
        //         },
        //     });

        //     $.ajax({
        //         url: "cadastros/processa_cidade_estado.php",
        //         method: "GET",
        //         dataType: "json",
        //         data: {
        //             "processa_cidade_estado": "buscar_cidade_estado_ce",
        //         },
        //         success: function(resposta_cidade_estado) {
        //             debugger;
        //             console.log(resposta_cidade_estado);

        //             if ($.fn.dataTable.isDataTable('#registros_ce')) {
        //                 $('#registros_ce').DataTable().clear().destroy();
        //             }

        //             // Limpa o tbody manualmente (opcional, mas recomendado)
        //             $("#registros_ce tbody").empty();

        //             let corpo = document.querySelector("#registros_ce tbody");
        //             corpo.innerHTML = "";

        //             if (resposta_cidade_estado.length > 0) {
        //                 // $("#risco_ergonomico tbody").html("");
        //                 for (let index = 0; index < resposta_cidade_estado.length; index++) {
        //                     let cidade_estado = resposta_cidade_estado[index];
        //                     // let resultado = risco.grupo_risco !== "" ? "Ergonômico" : "";

        //                     let linha = document.createElement("tr");
        //                     linha.innerHTML = `
        //             <td>${cidade_estado.id}</td>
        //             <td>${cidade_estado.nome}</td>
        //             <td>${cidade_estado.cep}</td>
        //             <td>${cidade_estado.estado}</td>
        //             <td>${cidade_estado.uf}</td>
        //             <td>
        //                 <div class='action-buttons'>
        //                     <a href='#' id='alterar-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" data-cidade="${cidade_estado.nome}"
        //                     data-cep="${cidade_estado.cep}" data-estado="${cidade_estado.estado}" data-estado-uf="${cidade_estado.uf}" title='Editar'><i class="fas fa-edit"></i></a>
        //                     <a href='#' id='excluir-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" class='delete' title='Apagar'><i class="fas fa-trash"></i></a>
        //                 </div>
        //             </td>`;
        //                     corpo.appendChild(linha);
        //                 }
        //             } else {
        //                 $("#registros_ce tbody").append("<tr><td colspan='9' style='text-align:center;'>Nenhum registro localizado</td></tr>");
        //             }

        //             // 🧹 Destrói o DataTable antigo antes de recriar
        //             if ($.fn.dataTable.isDataTable('#registros_ce')) {
        //                 $('#registros_ce').DataTable().destroy();
        //             }

        //             $("#registros_ce").DataTable({
        //                 "language": {
        //                     "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
        //                 },
        //                 "dom": '<"top"lf>rt<"bottom"ip><"clear">',
        //                 "pageLength": 5, // Exibir 5 registros por página
        //                 "lengthMenu": [
        //                     [5, 10, 25, 50, -1],
        //                     [5, 10, 25, 50, "Todos"]
        //                 ]
        //             });
        //             resolve();

        //         },
        //         error: function(xhr, status, error) {
        //             console.error("Erro ao carregar dados:", error);
        //             reject(error);
        //         },
        //     });

        //     $.ajax({
        //         url: "cadastros/processa_cidade_estado.php",
        //         method: "GET",
        //         dataType: "json",
        //         data: {
        //             "processa_cidade_estado": "buscar_cidade_estado_am",
        //         },
        //         success: function(resposta_cidade_estado) {
        //             debugger;
        //             console.log(resposta_cidade_estado);

        //             if ($.fn.dataTable.isDataTable('#registros_am')) {
        //                 $('#registros_am').DataTable().clear().destroy();
        //             }

        //             // Limpa o tbody manualmente (opcional, mas recomendado)
        //             $("#registros_am tbody").empty();

        //             let corpo = document.querySelector("#registros_am tbody");
        //             corpo.innerHTML = "";

        //             if (resposta_cidade_estado.length > 0) {
        //                 // $("#risco_ergonomico tbody").html("");
        //                 for (let index = 0; index < resposta_cidade_estado.length; index++) {
        //                     let cidade_estado = resposta_cidade_estado[index];
        //                     // let resultado = risco.grupo_risco !== "" ? "Ergonômico" : "";

        //                     let linha = document.createElement("tr");
        //                     linha.innerHTML = `
        //             <td>${cidade_estado.id}</td>
        //             <td>${cidade_estado.nome}</td>
        //             <td>${cidade_estado.cep}</td>
        //             <td>${cidade_estado.estado}</td>
        //             <td>${cidade_estado.uf}</td>
        //             <td>
        //                 <div class='action-buttons'>
        //                     <a href='#' id='alterar-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" data-cidade="${cidade_estado.nome}"
        //                     data-cep="${cidade_estado.cep}" data-estado="${cidade_estado.estado}" data-estado-uf="${cidade_estado.uf}" title='Editar'><i class="fas fa-edit"></i></a>
        //                     <a href='#' id='excluir-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" class='delete' title='Apagar'><i class="fas fa-trash"></i></a>
        //                 </div>
        //             </td>`;
        //                     corpo.appendChild(linha);
        //                 }
        //             } else {
        //                 $("#registros_am tbody").append("<tr><td colspan='9' style='text-align:center;'>Nenhum registro localizado</td></tr>");
        //             }

        //             // 🧹 Destrói o DataTable antigo antes de recriar
        //             if ($.fn.dataTable.isDataTable('#registros_am')) {
        //                 $('#registros_am').DataTable().destroy();
        //             }

        //             $("#registros_am").DataTable({
        //                 "language": {
        //                     "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
        //                 },
        //                 "dom": '<"top"lf>rt<"bottom"ip><"clear">',
        //                 "pageLength": 5, // Exibir 5 registros por página
        //                 "lengthMenu": [
        //                     [5, 10, 25, 50, -1],
        //                     [5, 10, 25, 50, "Todos"]
        //                 ]
        //             });

        //             resolve();
        //         },
        //         error: function(xhr, status, error) {
        //             console.error("Erro ao carregar dados:", error);
        //             reject(error);
        //         },
        //     });

        //     $.ajax({
        //         url: "cadastros/processa_cidade_estado.php",
        //         method: "GET",
        //         dataType: "json",
        //         data: {
        //             "processa_cidade_estado": "buscar_cidade_estado_rj",
        //         },
        //         success: function(resposta_cidade_estado) {
        //             debugger;
        //             console.log(resposta_cidade_estado);

        //             if ($.fn.dataTable.isDataTable('#registros_rj')) {
        //                 $('#registros_rj').DataTable().clear().destroy();
        //             }

        //             // Limpa o tbody manualmente (opcional, mas recomendado)
        //             $("#registros_rj tbody").empty();

        //             let corpo = document.querySelector("#registros_rj tbody");
        //             corpo.innerHTML = "";

        //             if (resposta_cidade_estado.length > 0) {
        //                 // $("#risco_ergonomico tbody").html("");
        //                 for (let index = 0; index < resposta_cidade_estado.length; index++) {
        //                     let cidade_estado = resposta_cidade_estado[index];
        //                     // let resultado = risco.grupo_risco !== "" ? "Ergonômico" : "";

        //                     let linha = document.createElement("tr");
        //                     linha.innerHTML = `
        //             <td>${cidade_estado.id}</td>
        //             <td>${cidade_estado.nome}</td>
        //             <td>${cidade_estado.cep}</td>
        //             <td>${cidade_estado.estado}</td>
        //             <td>${cidade_estado.uf}</td>
        //             <td>
        //                 <div class='action-buttons'>
        //                     <a href='#' id='alterar-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" data-cidade="${cidade_estado.nome}"
        //                     data-cep="${cidade_estado.cep}" data-estado="${cidade_estado.estado}" data-estado-uf="${cidade_estado.uf}" title='Editar'><i class="fas fa-edit"></i></a>
        //                     <a href='#' id='excluir-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" class='delete' title='Apagar'><i class="fas fa-trash"></i></a>
        //                 </div>
        //             </td>`;
        //                     corpo.appendChild(linha);
        //                 }
        //             } else {
        //                 $("#registros_rj tbody").append("<tr><td colspan='9' style='text-align:center;'>Nenhum registro localizado</td></tr>");
        //             }

        //             // 🧹 Destrói o DataTable antigo antes de recriar
        //             if ($.fn.dataTable.isDataTable('#registros_rj')) {
        //                 $('#registros_rj').DataTable().destroy();
        //             }

        //             $("#registros_rj").DataTable({
        //                 "language": {
        //                     "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
        //                 },
        //                 "dom": '<"top"lf>rt<"bottom"ip><"clear">',
        //                 "pageLength": 5, // Exibir 5 registros por página
        //                 "lengthMenu": [
        //                     [5, 10, 25, 50, -1],
        //                     [5, 10, 25, 50, "Todos"]
        //                 ]
        //             });

        //             resolve();
        //         },
        //         error: function(xhr, status, error) {
        //             console.error("Erro ao carregar dados:", error);
        //             reject(error);
        //         },
        //     });

        //     $.ajax({
        //         url: "cadastros/processa_cidade_estado.php",
        //         method: "GET",
        //         dataType: "json",
        //         data: {
        //             "processa_cidade_estado": "buscar_cidade_estado_pa",
        //         },
        //         success: function(resposta_cidade_estado) {
        //             debugger;
        //             console.log(resposta_cidade_estado);

        //             if ($.fn.dataTable.isDataTable('#registros_pa')) {
        //                 $('#registros_pa').DataTable().clear().destroy();
        //             }

        //             // Limpa o tbody manualmente (opcional, mas recomendado)
        //             $("#registros_pa tbody").empty();

        //             let corpo = document.querySelector("#registros_pa tbody");
        //             corpo.innerHTML = "";

        //             if (resposta_cidade_estado.length > 0) {
        //                 // $("#risco_ergonomico tbody").html("");
        //                 for (let index = 0; index < resposta_cidade_estado.length; index++) {
        //                     let cidade_estado = resposta_cidade_estado[index];
        //                     // let resultado = risco.grupo_risco !== "" ? "Ergonômico" : "";

        //                     let linha = document.createElement("tr");
        //                     linha.innerHTML = `
        //             <td>${cidade_estado.id}</td>
        //             <td>${cidade_estado.nome}</td>
        //             <td>${cidade_estado.cep}</td>
        //             <td>${cidade_estado.estado}</td>
        //             <td>${cidade_estado.uf}</td>
        //             <td>
        //                 <div class='action-buttons'>
        //                     <a href='#' id='alterar-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" data-cidade="${cidade_estado.nome}"
        //                     data-cep="${cidade_estado.cep}" data-estado="${cidade_estado.estado}" data-estado-uf="${cidade_estado.uf}" title='Editar'><i class="fas fa-edit"></i></a>
        //                     <a href='#' id='excluir-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" class='delete' title='Apagar'><i class="fas fa-trash"></i></a>
        //                 </div>
        //             </td>`;
        //                     corpo.appendChild(linha);
        //                 }
        //             } else {
        //                 $("#registros_pa tbody").append("<tr><td colspan='9' style='text-align:center;'>Nenhum registro localizado</td></tr>");
        //             }

        //             // 🧹 Destrói o DataTable antigo antes de recriar
        //             if ($.fn.dataTable.isDataTable('#registros_pa')) {
        //                 $('#registros_pa').DataTable().destroy();
        //             }

        //             $("#registros_pa").DataTable({
        //                 "language": {
        //                     "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
        //                 },
        //                 "dom": '<"top"lf>rt<"bottom"ip><"clear">',
        //                 "pageLength": 5, // Exibir 5 registros por página
        //                 "lengthMenu": [
        //                     [5, 10, 25, 50, -1],
        //                     [5, 10, 25, 50, "Todos"]
        //                 ]
        //             });

        //             resolve();
        //         },
        //         error: function(xhr, status, error) {
        //             console.error("Erro ao carregar dados:", error);
        //             reject(error);
        //         },
        //     });

        //     $.ajax({
        //         url: "cadastros/processa_cidade_estado.php",
        //         method: "GET",
        //         dataType: "json",
        //         data: {
        //             "processa_cidade_estado": "buscar_cidade_estado_pe",
        //         },
        //         success: function(resposta_cidade_estado) {
        //             debugger;
        //             console.log(resposta_cidade_estado);

        //             if ($.fn.dataTable.isDataTable('#registros_pe')) {
        //                 $('#registros_pe').DataTable().clear().destroy();
        //             }

        //             // Limpa o tbody manualmente (opcional, mas recomendado)
        //             $("#registros_pe tbody").empty();

        //             let corpo = document.querySelector("#registros_pe tbody");
        //             corpo.innerHTML = "";

        //             if (resposta_cidade_estado.length > 0) {
        //                 // $("#risco_ergonomico tbody").html("");
        //                 for (let index = 0; index < resposta_cidade_estado.length; index++) {
        //                     let cidade_estado = resposta_cidade_estado[index];
        //                     // let resultado = risco.grupo_risco !== "" ? "Ergonômico" : "";

        //                     let linha = document.createElement("tr");
        //                     linha.innerHTML = `
        //             <td>${cidade_estado.id}</td>
        //             <td>${cidade_estado.nome}</td>
        //             <td>${cidade_estado.cep}</td>
        //             <td>${cidade_estado.estado}</td>
        //             <td>${cidade_estado.uf}</td>
        //             <td>
        //                 <div class='action-buttons'>
        //                     <a href='#' id='alterar-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" data-cidade="${cidade_estado.nome}"
        //                     data-cep="${cidade_estado.cep}" data-estado="${cidade_estado.estado}" data-estado-uf="${cidade_estado.uf}" title='Editar'><i class="fas fa-edit"></i></a>
        //                     <a href='#' id='excluir-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" class='delete' title='Apagar'><i class="fas fa-trash"></i></a>
        //                 </div>
        //             </td>`;
        //                     corpo.appendChild(linha);
        //                 }
        //             } else {
        //                 $("#registros_pe tbody").append("<tr><td colspan='9' style='text-align:center;'>Nenhum registro localizado</td></tr>");
        //             }

        //             // 🧹 Destrói o DataTable antigo antes de recriar
        //             if ($.fn.dataTable.isDataTable('#registros_pe')) {
        //                 $('#registros_pe').DataTable().destroy();
        //             }

        //             $("#registros_pe").DataTable({
        //                 "language": {
        //                     "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
        //                 },
        //                 "dom": '<"top"lf>rt<"bottom"ip><"clear">',
        //                 "pageLength": 5, // Exibir 5 registros por página
        //                 "lengthMenu": [
        //                     [5, 10, 25, 50, -1],
        //                     [5, 10, 25, 50, "Todos"]
        //                 ]
        //             });

        //             resolve();
        //         },
        //         error: function(xhr, status, error) {
        //             console.error("Erro ao carregar dados:", error);
        //             reject(error);
        //         },
        //     });

        //     $.ajax({
        //         url: "cadastros/processa_cidade_estado.php",
        //         method: "GET",
        //         dataType: "json",
        //         data: {
        //             "processa_cidade_estado": "buscar_cidade_estado_ma",
        //         },
        //         success: function(resposta_cidade_estado) {
        //             debugger;
        //             console.log(resposta_cidade_estado);

        //             if ($.fn.dataTable.isDataTable('#registros_ma')) {
        //                 $('#registros_ma').DataTable().clear().destroy();
        //             }

        //             // Limpa o tbody manualmente (opcional, mas recomendado)
        //             $("#registros_ma tbody").empty();

        //             let corpo = document.querySelector("#registros_ma tbody");
        //             corpo.innerHTML = "";

        //             if (resposta_cidade_estado.length > 0) {
        //                 // $("#risco_ergonomico tbody").html("");
        //                 for (let index = 0; index < resposta_cidade_estado.length; index++) {
        //                     let cidade_estado = resposta_cidade_estado[index];
        //                     // let resultado = risco.grupo_risco !== "" ? "Ergonômico" : "";

        //                     let linha = document.createElement("tr");
        //                     linha.innerHTML = `
        //             <td>${cidade_estado.id}</td>
        //             <td>${cidade_estado.nome}</td>
        //             <td>${cidade_estado.cep}</td>
        //             <td>${cidade_estado.estado}</td>
        //             <td>${cidade_estado.uf}</td>
        //             <td>
        //                 <div class='action-buttons'>
        //                     <a href='#' id='alterar-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" data-cidade="${cidade_estado.nome}"
        //                     data-cep="${cidade_estado.cep}" data-estado="${cidade_estado.estado}" data-estado-uf="${cidade_estado.uf}" title='Editar'><i class="fas fa-edit"></i></a>
        //                     <a href='#' id='excluir-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" class='delete' title='Apagar'><i class="fas fa-trash"></i></a>
        //                 </div>
        //             </td>`;
        //                     corpo.appendChild(linha);
        //                 }
        //             } else {
        //                 $("#registros_ma tbody").append("<tr><td colspan='9' style='text-align:center;'>Nenhum registro localizado</td></tr>");
        //             }

        //             // 🧹 Destrói o DataTable antigo antes de recriar
        //             if ($.fn.dataTable.isDataTable('#registros_ma')) {
        //                 $('#registros_ma').DataTable().destroy();
        //             }

        //             $("#registros_ma").DataTable({
        //                 "language": {
        //                     "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
        //                 },
        //                 "dom": '<"top"lf>rt<"bottom"ip><"clear">',
        //                 "pageLength": 5, // Exibir 5 registros por página
        //                 "lengthMenu": [
        //                     [5, 10, 25, 50, -1],
        //                     [5, 10, 25, 50, "Todos"]
        //                 ]
        //             });

        //             resolve();
        //         },
        //         error: function(xhr, status, error) {
        //             console.error("Erro ao carregar dados:", error);
        //             reject(error)
        //         },
        //     });

        //     $.ajax({
        //         url: "cadastros/processa_cidade_estado.php",
        //         method: "GET",
        //         dataType: "json",
        //         data: {
        //             "processa_cidade_estado": "buscar_cidade_estado_es",
        //         },
        //         success: function(resposta_cidade_estado) {
        //             debugger;
        //             console.log(resposta_cidade_estado);

        //             if ($.fn.dataTable.isDataTable('#registros_es')) {
        //                 $('#registros_es').DataTable().clear().destroy();
        //             }

        //             // Limpa o tbody manualmente (opcional, mas recomendado)
        //             $("#registros_es tbody").empty();

        //             let corpo = document.querySelector("#registros_es tbody");
        //             corpo.innerHTML = "";

        //             if (resposta_cidade_estado.length > 0) {
        //                 // $("#risco_ergonomico tbody").html("");
        //                 for (let index = 0; index < resposta_cidade_estado.length; index++) {
        //                     let cidade_estado = resposta_cidade_estado[index];
        //                     // let resultado = risco.grupo_risco !== "" ? "Ergonômico" : "";

        //                     let linha = document.createElement("tr");
        //                     linha.innerHTML = `
        //             <td>${cidade_estado.id}</td>
        //             <td>${cidade_estado.nome}</td>
        //             <td>${cidade_estado.cep}</td>
        //             <td>${cidade_estado.estado}</td>
        //             <td>${cidade_estado.uf}</td>
        //             <td>
        //                 <div class='action-buttons'>
        //                     <a href='#' id='alterar-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" data-cidade="${cidade_estado.nome}"
        //                     data-cep="${cidade_estado.cep}" data-estado="${cidade_estado.estado}" data-estado-uf="${cidade_estado.uf}" title='Editar'><i class="fas fa-edit"></i></a>
        //                     <a href='#' id='excluir-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" class='delete' title='Apagar'><i class="fas fa-trash"></i></a>
        //                 </div>
        //             </td>`;
        //                     corpo.appendChild(linha);
        //                 }
        //             } else {
        //                 $("#registros_es tbody").append("<tr><td colspan='9' style='text-align:center;'>Nenhum registro localizado</td></tr>");
        //             }

        //             // 🧹 Destrói o DataTable antigo antes de recriar
        //             if ($.fn.dataTable.isDataTable('#registros_es')) {
        //                 $('#registros_es').DataTable().destroy();
        //             }

        //             $("#registros_es").DataTable({
        //                 "language": {
        //                     "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
        //                 },
        //                 "dom": '<"top"lf>rt<"bottom"ip><"clear">',
        //                 "pageLength": 5, // Exibir 5 registros por página
        //                 "lengthMenu": [
        //                     [5, 10, 25, 50, -1],
        //                     [5, 10, 25, 50, "Todos"]
        //                 ]
        //             });

        //             resolve();
        //         },
        //         error: function(xhr, status, error) {
        //             console.error("Erro ao carregar dados:", error);
        //             reject(error);
        //         },
        //     });

        //     $.ajax({
        //         url: "cadastros/processa_cidade_estado.php",
        //         method: "GET",
        //         dataType: "json",
        //         data: {
        //             "processa_cidade_estado": "buscar_cidade_estado_ap",
        //         },
        //         success: function(resposta_cidade_estado) {
        //             debugger;
        //             console.log(resposta_cidade_estado);

        //             if ($.fn.dataTable.isDataTable('#registros_ap')) {
        //                 $('#registros_ap').DataTable().clear().destroy();
        //             }

        //             // Limpa o tbody manualmente (opcional, mas recomendado)
        //             $("#registros_ap tbody").empty();

        //             let corpo = document.querySelector("#registros_ap tbody");
        //             corpo.innerHTML = "";

        //             if (resposta_cidade_estado.length > 0) {
        //                 // $("#risco_ergonomico tbody").html("");
        //                 for (let index = 0; index < resposta_cidade_estado.length; index++) {
        //                     let cidade_estado = resposta_cidade_estado[index];
        //                     // let resultado = risco.grupo_risco !== "" ? "Ergonômico" : "";

        //                     let linha = document.createElement("tr");
        //                     linha.innerHTML = `
        //             <td>${cidade_estado.id}</td>
        //             <td>${cidade_estado.nome}</td>
        //             <td>${cidade_estado.cep}</td>
        //             <td>${cidade_estado.estado}</td>
        //             <td>${cidade_estado.uf}</td>
        //             <td>
        //                 <div class='action-buttons'>
        //                     <a href='#' id='alterar-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" data-cidade="${cidade_estado.nome}"
        //                     data-cep="${cidade_estado.cep}" data-estado="${cidade_estado.estado}" data-estado-uf="${cidade_estado.uf}" title='Editar'><i class="fas fa-edit"></i></a>
        //                     <a href='#' id='excluir-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" class='delete' title='Apagar'><i class="fas fa-trash"></i></a>
        //                 </div>
        //             </td>`;
        //                     corpo.appendChild(linha);
        //                 }
        //             } else {
        //                 $("#registros_ap tbody").append("<tr><td colspan='9' style='text-align:center;'>Nenhum registro localizado</td></tr>");
        //             }

        //             // 🧹 Destrói o DataTable antigo antes de recriar
        //             if ($.fn.dataTable.isDataTable('#registros_ap')) {
        //                 $('#registros_ap').DataTable().destroy();
        //             }

        //             $("#registros_ap").DataTable({
        //                 "language": {
        //                     "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
        //                 },
        //                 "dom": '<"top"lf>rt<"bottom"ip><"clear">',
        //                 "pageLength": 5, // Exibir 5 registros por página
        //                 "lengthMenu": [
        //                     [5, 10, 25, 50, -1],
        //                     [5, 10, 25, 50, "Todos"]
        //                 ]
        //             });

        //             resolve();
        //         },
        //         error: function(xhr, status, error) {
        //             console.error("Erro ao carregar dados:", error);
        //             reject(error);
        //         },
        //     });

        //     $.ajax({
        //         url: "cadastros/processa_cidade_estado.php",
        //         method: "GET",
        //         dataType: "json",
        //         data: {
        //             "processa_cidade_estado": "buscar_cidade_estado_rn",
        //         },
        //         success: function(resposta_cidade_estado) {
        //             debugger;
        //             console.log(resposta_cidade_estado);

        //             if ($.fn.dataTable.isDataTable('#registros_rn')) {
        //                 $('#registros_rn').DataTable().clear().destroy();
        //             }

        //             // Limpa o tbody manualmente (opcional, mas recomendado)
        //             $("#registros_rn tbody").empty();

        //             let corpo = document.querySelector("#registros_rn tbody");
        //             corpo.innerHTML = "";

        //             if (resposta_cidade_estado.length > 0) {
        //                 // $("#risco_ergonomico tbody").html("");
        //                 for (let index = 0; index < resposta_cidade_estado.length; index++) {
        //                     let cidade_estado = resposta_cidade_estado[index];
        //                     // let resultado = risco.grupo_risco !== "" ? "Ergonômico" : "";

        //                     let linha = document.createElement("tr");
        //                     linha.innerHTML = `
        //             <td>${cidade_estado.id}</td>
        //             <td>${cidade_estado.nome}</td>
        //             <td>${cidade_estado.cep}</td>
        //             <td>${cidade_estado.estado}</td>
        //             <td>${cidade_estado.uf}</td>
        //             <td>
        //                 <div class='action-buttons'>
        //                     <a href='#' id='alterar-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" data-cidade="${cidade_estado.nome}"
        //                     data-cep="${cidade_estado.cep}" data-estado="${cidade_estado.estado}" data-estado-uf="${cidade_estado.uf}" title='Editar'><i class="fas fa-edit"></i></a>
        //                     <a href='#' id='excluir-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" class='delete' title='Apagar'><i class="fas fa-trash"></i></a>
        //                 </div>
        //             </td>`;
        //                     corpo.appendChild(linha);
        //                 }
        //             } else {
        //                 $("#registros_rn tbody").append("<tr><td colspan='9' style='text-align:center;'>Nenhum registro localizado</td></tr>");
        //             }

        //             // 🧹 Destrói o DataTable antigo antes de recriar
        //             if ($.fn.dataTable.isDataTable('#registros_rn')) {
        //                 $('#registros_rn').DataTable().destroy();
        //             }

        //             $("#registros_rn").DataTable({
        //                 "language": {
        //                     "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
        //                 },
        //                 "dom": '<"top"lf>rt<"bottom"ip><"clear">',
        //                 "pageLength": 5, // Exibir 5 registros por página
        //                 "lengthMenu": [
        //                     [5, 10, 25, 50, -1],
        //                     [5, 10, 25, 50, "Todos"]
        //                 ]
        //             });

        //             resolve();
        //         },
        //         error: function(xhr, status, error) {
        //             console.error("Erro ao carregar dados:", error);
        //             reject(error);
        //         },
        //     });

        //     $.ajax({
        //         url: "cadastros/processa_cidade_estado.php",
        //         method: "GET",
        //         dataType: "json",
        //         data: {
        //             "processa_cidade_estado": "buscar_cidade_estado_pb",
        //         },
        //         success: function(resposta_cidade_estado) {
        //             debugger;
        //             console.log(resposta_cidade_estado);

        //             if ($.fn.dataTable.isDataTable('#registros_pb')) {
        //                 $('#registros_pb').DataTable().clear().destroy();
        //             }

        //             // Limpa o tbody manualmente (opcional, mas recomendado)
        //             $("#registros_pb tbody").empty();

        //             let corpo = document.querySelector("#registros_pb tbody");
        //             corpo.innerHTML = "";

        //             if (resposta_cidade_estado.length > 0) {
        //                 // $("#risco_ergonomico tbody").html("");
        //                 for (let index = 0; index < resposta_cidade_estado.length; index++) {
        //                     let cidade_estado = resposta_cidade_estado[index];
        //                     // let resultado = risco.grupo_risco !== "" ? "Ergonômico" : "";

        //                     let linha = document.createElement("tr");
        //                     linha.innerHTML = `
        //             <td>${cidade_estado.id}</td>
        //             <td>${cidade_estado.nome}</td>
        //             <td>${cidade_estado.cep}</td>
        //             <td>${cidade_estado.estado}</td>
        //             <td>${cidade_estado.uf}</td>
        //             <td>
        //                 <div class='action-buttons'>
        //                     <a href='#' id='alterar-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" data-cidade="${cidade_estado.nome}"
        //                     data-cep="${cidade_estado.cep}" data-estado="${cidade_estado.estado}" data-estado-uf="${cidade_estado.uf}" title='Editar'><i class="fas fa-edit"></i></a>
        //                     <a href='#' id='excluir-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" class='delete' title='Apagar'><i class="fas fa-trash"></i></a>
        //                 </div>
        //             </td>`;
        //                     corpo.appendChild(linha);
        //                 }
        //             } else {
        //                 $("#registros_pb tbody").append("<tr><td colspan='9' style='text-align:center;'>Nenhum registro localizado</td></tr>");
        //             }

        //             // 🧹 Destrói o DataTable antigo antes de recriar
        //             if ($.fn.dataTable.isDataTable('#registros_pb')) {
        //                 $('#registros_pb').DataTable().destroy();
        //             }

        //             $("#registros_pb").DataTable({
        //                 "language": {
        //                     "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
        //                 },
        //                 "dom": '<"top"lf>rt<"bottom"ip><"clear">',
        //                 "pageLength": 5, // Exibir 5 registros por página
        //                 "lengthMenu": [
        //                     [5, 10, 25, 50, -1],
        //                     [5, 10, 25, 50, "Todos"]
        //                 ]
        //             });

        //             resolve();
        //         },
        //         error: function(xhr, status, error) {
        //             console.error("Erro ao carregar dados:", error);
        //             reject(error);
        //         },
        //     });

        //     $.ajax({
        //         url: "cadastros/processa_cidade_estado.php",
        //         method: "GET",
        //         dataType: "json",
        //         data: {
        //             "processa_cidade_estado": "buscar_cidade_estado_ac",
        //         },
        //         success: function(resposta_cidade_estado) {
        //             debugger;
        //             console.log(resposta_cidade_estado);

        //             if ($.fn.dataTable.isDataTable('#registros_ac')) {
        //                 $('#registros_ac').DataTable().clear().destroy();
        //             }

        //             // Limpa o tbody manualmente (opcional, mas recomendado)
        //             $("#registros_ac tbody").empty();

        //             let corpo = document.querySelector("#registros_ac tbody");
        //             corpo.innerHTML = "";

        //             if (resposta_cidade_estado.length > 0) {
        //                 // $("#risco_ergonomico tbody").html("");
        //                 for (let index = 0; index < resposta_cidade_estado.length; index++) {
        //                     let cidade_estado = resposta_cidade_estado[index];
        //                     // let resultado = risco.grupo_risco !== "" ? "Ergonômico" : "";

        //                     let linha = document.createElement("tr");
        //                     linha.innerHTML = `
        //             <td>${cidade_estado.id}</td>
        //             <td>${cidade_estado.nome}</td>
        //             <td>${cidade_estado.cep}</td>
        //             <td>${cidade_estado.estado}</td>
        //             <td>${cidade_estado.uf}</td>
        //             <td>
        //                 <div class='action-buttons'>
        //                     <a href='#' id='alterar-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" data-cidade="${cidade_estado.nome}"
        //                     data-cep="${cidade_estado.cep}" data-estado="${cidade_estado.estado}" data-estado-uf="${cidade_estado.uf}" title='Editar'><i class="fas fa-edit"></i></a>
        //                     <a href='#' id='excluir-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" class='delete' title='Apagar'><i class="fas fa-trash"></i></a>
        //                 </div>
        //             </td>`;
        //                     corpo.appendChild(linha);
        //                 }
        //             } else {
        //                 $("#registros_ac tbody").append("<tr><td colspan='9' style='text-align:center;'>Nenhum registro localizado</td></tr>");
        //             }

        //             // 🧹 Destrói o DataTable antigo antes de recriar
        //             if ($.fn.dataTable.isDataTable('#registros_ac')) {
        //                 $('#registros_ac').DataTable().destroy();
        //             }

        //             $("#registros_ac").DataTable({
        //                 "language": {
        //                     "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
        //                 },
        //                 "dom": '<"top"lf>rt<"bottom"ip><"clear">',
        //                 "pageLength": 5, // Exibir 5 registros por página
        //                 "lengthMenu": [
        //                     [5, 10, 25, 50, -1],
        //                     [5, 10, 25, 50, "Todos"]
        //                 ]
        //             });

        //             resolve();
        //         },
        //         error: function(xhr, status, error) {
        //             console.error("Erro ao carregar dados:", error);
        //             reject(error);
        //         },
        //     });

        //     $.ajax({
        //         url: "cadastros/processa_cidade_estado.php",
        //         method: "GET",
        //         dataType: "json",
        //         data: {
        //             "processa_cidade_estado": "buscar_cidade_estado_al",
        //         },
        //         success: function(resposta_cidade_estado) {
        //             debugger;
        //             console.log(resposta_cidade_estado);

        //             if ($.fn.dataTable.isDataTable('#registros_al')) {
        //                 $('#registros_al').DataTable().clear().destroy();
        //             }

        //             // Limpa o tbody manualmente (opcional, mas recomendado)
        //             $("#registros_al tbody").empty();

        //             let corpo = document.querySelector("#registros_al tbody");
        //             corpo.innerHTML = "";

        //             if (resposta_cidade_estado.length > 0) {
        //                 // $("#risco_ergonomico tbody").html("");
        //                 for (let index = 0; index < resposta_cidade_estado.length; index++) {
        //                     let cidade_estado = resposta_cidade_estado[index];
        //                     // let resultado = risco.grupo_risco !== "" ? "Ergonômico" : "";

        //                     let linha = document.createElement("tr");
        //                     linha.innerHTML = `
        //             <td>${cidade_estado.id}</td>
        //             <td>${cidade_estado.nome}</td>
        //             <td>${cidade_estado.cep}</td>
        //             <td>${cidade_estado.estado}</td>
        //             <td>${cidade_estado.uf}</td>
        //             <td>
        //                 <div class='action-buttons'>
        //                     <a href='#' id='alterar-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" data-cidade="${cidade_estado.nome}"
        //                     data-cep="${cidade_estado.cep}" data-estado="${cidade_estado.estado}" data-estado-uf="${cidade_estado.uf}" title='Editar'><i class="fas fa-edit"></i></a>
        //                     <a href='#' id='excluir-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" class='delete' title='Apagar'><i class="fas fa-trash"></i></a>
        //                 </div>
        //             </td>`;
        //                     corpo.appendChild(linha);
        //                 }
        //             } else {
        //                 $("#registros_al tbody").append("<tr><td colspan='9' style='text-align:center;'>Nenhum registro localizado</td></tr>");
        //             }

        //             // 🧹 Destrói o DataTable antigo antes de recriar
        //             if ($.fn.dataTable.isDataTable('#registros_al')) {
        //                 $('#registros_al').DataTable().destroy();
        //             }

        //             $("#registros_al").DataTable({
        //                 "language": {
        //                     "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
        //                 },
        //                 "dom": '<"top"lf>rt<"bottom"ip><"clear">',
        //                 "pageLength": 5, // Exibir 5 registros por página
        //                 "lengthMenu": [
        //                     [5, 10, 25, 50, -1],
        //                     [5, 10, 25, 50, "Todos"]
        //                 ]
        //             });

        //             resolve();
        //         },
        //         error: function(xhr, status, error) {
        //             console.error("Erro ao carregar dados:", error);
        //             reject(error)
        //         },
        //     });

        //     $.ajax({
        //         url: "cadastros/processa_cidade_estado.php",
        //         method: "GET",
        //         dataType: "json",
        //         data: {
        //             "processa_cidade_estado": "buscar_cidade_estado_to",
        //         },
        //         success: function(resposta_cidade_estado) {
        //             debugger;
        //             console.log(resposta_cidade_estado);

        //             if ($.fn.dataTable.isDataTable('#registros_to')) {
        //                 $('#registros_to').DataTable().clear().destroy();
        //             }

        //             // Limpa o tbody manualmente (opcional, mas recomendado)
        //             $("#registros_to tbody").empty();

        //             let corpo = document.querySelector("#registros_to tbody");
        //             corpo.innerHTML = "";

        //             if (resposta_cidade_estado.length > 0) {
        //                 // $("#risco_ergonomico tbody").html("");
        //                 for (let index = 0; index < resposta_cidade_estado.length; index++) {
        //                     let cidade_estado = resposta_cidade_estado[index];
        //                     // let resultado = risco.grupo_risco !== "" ? "Ergonômico" : "";

        //                     let linha = document.createElement("tr");
        //                     linha.innerHTML = `
        //             <td>${cidade_estado.id}</td>
        //             <td>${cidade_estado.nome}</td>
        //             <td>${cidade_estado.cep}</td>
        //             <td>${cidade_estado.estado}</td>
        //             <td>${cidade_estado.uf}</td>
        //             <td>
        //                 <div class='action-buttons'>
        //                     <a href='#' id='alterar-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" data-cidade="${cidade_estado.nome}"
        //                     data-cep="${cidade_estado.cep}" data-estado="${cidade_estado.estado}" data-estado-uf="${cidade_estado.uf}" title='Editar'><i class="fas fa-edit"></i></a>
        //                     <a href='#' id='excluir-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" class='delete' title='Apagar'><i class="fas fa-trash"></i></a>
        //                 </div>
        //             </td>`;
        //                     corpo.appendChild(linha);
        //                 }
        //             } else {
        //                 $("#registros_to tbody").append("<tr><td colspan='9' style='text-align:center;'>Nenhum registro localizado</td></tr>");
        //             }

        //             // 🧹 Destrói o DataTable antigo antes de recriar
        //             if ($.fn.dataTable.isDataTable('#registros_to')) {
        //                 $('#registros_to').DataTable().destroy();
        //             }

        //             $("#registros_to").DataTable({
        //                 "language": {
        //                     "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
        //                 },
        //                 "dom": '<"top"lf>rt<"bottom"ip><"clear">',
        //                 "pageLength": 5, // Exibir 5 registros por página
        //                 "lengthMenu": [
        //                     [5, 10, 25, 50, -1],
        //                     [5, 10, 25, 50, "Todos"]
        //                 ]
        //             });
        //             resolve();

        //         },
        //         error: function(xhr, status, error) {
        //             console.error("Erro ao carregar dados:", error);
        //             reject(error);
        //         },
        //     });

        //     $.ajax({
        //         url: "cadastros/processa_cidade_estado.php",
        //         method: "GET",
        //         dataType: "json",
        //         data: {
        //             "processa_cidade_estado": "buscar_cidade_estado_pi",
        //         },
        //         success: function(resposta_cidade_estado) {
        //             debugger;
        //             console.log(resposta_cidade_estado);

        //             if ($.fn.dataTable.isDataTable('#registros_pi')) {
        //                 $('#registros_pi').DataTable().clear().destroy();
        //             }

        //             // Limpa o tbody manualmente (opcional, mas recomendado)
        //             $("#registros_pi tbody").empty();

        //             let corpo = document.querySelector("#registros_pi tbody");
        //             corpo.innerHTML = "";

        //             if (resposta_cidade_estado.length > 0) {
        //                 // $("#risco_ergonomico tbody").html("");
        //                 for (let index = 0; index < resposta_cidade_estado.length; index++) {
        //                     let cidade_estado = resposta_cidade_estado[index];
        //                     // let resultado = risco.grupo_risco !== "" ? "Ergonômico" : "";

        //                     let linha = document.createElement("tr");
        //                     linha.innerHTML = `
        //             <td>${cidade_estado.id}</td>
        //             <td>${cidade_estado.nome}</td>
        //             <td>${cidade_estado.cep}</td>
        //             <td>${cidade_estado.estado}</td>
        //             <td>${cidade_estado.uf}</td>
        //             <td>
        //                 <div class='action-buttons'>
        //                     <a href='#' id='alterar-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" data-cidade="${cidade_estado.nome}"
        //                     data-cep="${cidade_estado.cep}" data-estado="${cidade_estado.estado}" data-estado-uf="${cidade_estado.uf}" title='Editar'><i class="fas fa-edit"></i></a>
        //                     <a href='#' id='excluir-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" class='delete' title='Apagar'><i class="fas fa-trash"></i></a>
        //                 </div>
        //             </td>`;
        //                     corpo.appendChild(linha);
        //                 }
        //             } else {
        //                 $("#registros_pi tbody").append("<tr><td colspan='9' style='text-align:center;'>Nenhum registro localizado</td></tr>");
        //             }

        //             // 🧹 Destrói o DataTable antigo antes de recriar
        //             if ($.fn.dataTable.isDataTable('#registros_pi')) {
        //                 $('#registros_pi').DataTable().destroy();
        //             }

        //             $("#registros_pi").DataTable({
        //                 "language": {
        //                     "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
        //                 },
        //                 "dom": '<"top"lf>rt<"bottom"ip><"clear">',
        //                 "pageLength": 5, // Exibir 5 registros por página
        //                 "lengthMenu": [
        //                     [5, 10, 25, 50, -1],
        //                     [5, 10, 25, 50, "Todos"]
        //                 ]
        //             });

        //             resolve();
        //         },
        //         error: function(xhr, status, error) {
        //             console.error("Erro ao carregar dados:", error);
        //             reject(error);
        //         },
        //     });

        //     $.ajax({
        //         url: "cadastros/processa_cidade_estado.php",
        //         method: "GET",
        //         dataType: "json",
        //         data: {
        //             "processa_cidade_estado": "buscar_cidade_estado_rr",
        //         },
        //         success: function(resposta_cidade_estado) {
        //             debugger;
        //             console.log(resposta_cidade_estado);

        //             if ($.fn.dataTable.isDataTable('#registros_rr')) {
        //                 $('#registros_rr').DataTable().clear().destroy();
        //             }

        //             // Limpa o tbody manualmente (opcional, mas recomendado)
        //             $("#registros_rr tbody").empty();

        //             let corpo = document.querySelector("#registros_rr tbody");
        //             corpo.innerHTML = "";

        //             if (resposta_cidade_estado.length > 0) {
        //                 // $("#risco_ergonomico tbody").html("");
        //                 for (let index = 0; index < resposta_cidade_estado.length; index++) {
        //                     let cidade_estado = resposta_cidade_estado[index];
        //                     // let resultado = risco.grupo_risco !== "" ? "Ergonômico" : "";

        //                     let linha = document.createElement("tr");
        //                     linha.innerHTML = `
        //             <td>${cidade_estado.id}</td>
        //             <td>${cidade_estado.nome}</td>
        //             <td>${cidade_estado.cep}</td>
        //             <td>${cidade_estado.estado}</td>
        //             <td>${cidade_estado.uf}</td>
        //             <td>
        //                 <div class='action-buttons'>
        //                     <a href='#' id='alterar-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" data-cidade="${cidade_estado.nome}"
        //                     data-cep="${cidade_estado.cep}" data-estado="${cidade_estado.estado}" data-estado-uf="${cidade_estado.uf}" title='Editar'><i class="fas fa-edit"></i></a>
        //                     <a href='#' id='excluir-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" class='delete' title='Apagar'><i class="fas fa-trash"></i></a>
        //                 </div>
        //             </td>`;
        //                     corpo.appendChild(linha);
        //                 }
        //             } else {
        //                 $("#registros_rr tbody").append("<tr><td colspan='9' style='text-align:center;'>Nenhum registro localizado</td></tr>");
        //             }

        //             // 🧹 Destrói o DataTable antigo antes de recriar
        //             if ($.fn.dataTable.isDataTable('#registros_rr')) {
        //                 $('#registros_rr').DataTable().destroy();
        //             }

        //             $("#registros_rr").DataTable({
        //                 "language": {
        //                     "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
        //                 },
        //                 "dom": '<"top"lf>rt<"bottom"ip><"clear">',
        //                 "pageLength": 5, // Exibir 5 registros por página
        //                 "lengthMenu": [
        //                     [5, 10, 25, 50, -1],
        //                     [5, 10, 25, 50, "Todos"]
        //                 ]
        //             });

        //             resolve();
        //         },
        //         error: function(xhr, status, error) {
        //             console.error("Erro ao carregar dados:", error);
        //             reject(error);
        //         },
        //     });

        //     $.ajax({
        //         url: "cadastros/processa_cidade_estado.php",
        //         method: "GET",
        //         dataType: "json",
        //         data: {
        //             "processa_cidade_estado": "buscar_cidade_estado_ro",
        //         },
        //         success: function(resposta_cidade_estado) {
        //             debugger;
        //             console.log(resposta_cidade_estado);

        //             if ($.fn.dataTable.isDataTable('#registros_ro')) {
        //                 $('#registros_ro').DataTable().clear().destroy();
        //             }

        //             // Limpa o tbody manualmente (opcional, mas recomendado)
        //             $("#registros_ro tbody").empty();

        //             let corpo = document.querySelector("#registros_ro tbody");
        //             corpo.innerHTML = "";

        //             if (resposta_cidade_estado.length > 0) {
        //                 // $("#risco_ergonomico tbody").html("");
        //                 for (let index = 0; index < resposta_cidade_estado.length; index++) {
        //                     let cidade_estado = resposta_cidade_estado[index];
        //                     // let resultado = risco.grupo_risco !== "" ? "Ergonômico" : "";

        //                     let linha = document.createElement("tr");
        //                     linha.innerHTML = `
        //             <td>${cidade_estado.id}</td>
        //             <td>${cidade_estado.nome}</td>
        //             <td>${cidade_estado.cep}</td>
        //             <td>${cidade_estado.estado}</td>
        //             <td>${cidade_estado.uf}</td>
        //             <td>
        //                 <div class='action-buttons'>
        //                     <a href='#' id='alterar-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" data-cidade="${cidade_estado.nome}"
        //                     data-cep="${cidade_estado.cep}" data-estado="${cidade_estado.estado}" data-estado-uf="${cidade_estado.uf}" title='Editar'><i class="fas fa-edit"></i></a>
        //                     <a href='#' id='excluir-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" class='delete' title='Apagar'><i class="fas fa-trash"></i></a>
        //                 </div>
        //             </td>`;
        //                     corpo.appendChild(linha);
        //                 }
        //             } else {
        //                 $("#registros_ro tbody").append("<tr><td colspan='9' style='text-align:center;'>Nenhum registro localizado</td></tr>");
        //             }

        //             // 🧹 Destrói o DataTable antigo antes de recriar
        //             if ($.fn.dataTable.isDataTable('#registros_ro')) {
        //                 $('#registros_ro').DataTable().destroy();
        //             }

        //             $("#registros_ro").DataTable({
        //                 "language": {
        //                     "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
        //                 },
        //                 "dom": '<"top"lf>rt<"bottom"ip><"clear">',
        //                 "pageLength": 5, // Exibir 5 registros por página
        //                 "lengthMenu": [
        //                     [5, 10, 25, 50, -1],
        //                     [5, 10, 25, 50, "Todos"]
        //                 ]
        //             });

        //             resolve();
        //         },
        //         error: function(xhr, status, error) {
        //             console.error("Erro ao carregar dados:", error);
        //             reject(error);
        //         },
        //     });
        // });
    }

    function atualizarTabela(selector, resposta_cidade_estado) {
        debugger;
        // Adiciona "#" ao seletor, se não tiver
        if (!selector.startsWith('#')) {
            selector = `#${selector}`;
        }

        const tabela = $(selector);

        // Verifica se o DataTable já está inicializado
        if ($.fn.DataTable.isDataTable(selector)) {
            const dt = tabela.DataTable();
            dt.clear(); // Limpa os dados antigos

            // Verifica se a resposta tem dados
            if (Array.isArray(resposta_cidade_estado) && resposta_cidade_estado.length > 0) {
                for (let i = 0; i < resposta_cidade_estado.length; i++) {
                    const cidade_estado = resposta_cidade_estado[i];

                    // Adiciona uma nova linha no DataTable
                    dt.row.add([
                        cidade_estado.id,
                        cidade_estado.nome,
                        cidade_estado.cep,
                        cidade_estado.estado,
                        cidade_estado.uf,
                        `
                    <div class='action-buttons'>
                        <a href='#' id='alterar-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" data-cidade="${cidade_estado.nome}"
                        data-cep="${cidade_estado.cep}" data-estado="${cidade_estado.estado}" data-estado-uf="${cidade_estado.uf}" title='Editar'><i class="fas fa-edit"></i></a>
                        <a href='#' id='excluir-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" class='delete' title='Apagar'><i class="fas fa-trash"></i></a>
                    </div>`
                    ]);
                }
            }

            dt.draw(); // Atualiza a tabela
        } else {
            // Inicializa o DataTable pela primeira vez
            const dadosTabela = [];

            if (Array.isArray(resposta_cidade_estado) && resposta_cidade_estado.length > 0) {
                for (let i = 0; i < resposta_cidade_estado.length; i++) {
                    const cidade_estado = resposta_cidade_estado[i];

                    dadosTabela.push([
                        cidade_estado.id,
                        cidade_estado.nome,
                        cidade_estado.cep,
                        cidade_estado.estado,
                        cidade_estado.uf,
                        `
                    <div class='action-buttons'>
                        <a href='#' id='alterar-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" data-cidade="${cidade_estado.nome}"
                        data-cep="${cidade_estado.cep}" data-estado="${cidade_estado.estado}" data-estado-uf="${cidade_estado.uf}" title='Editar'><i class="fas fa-edit"></i></a>
                        <a href='#' id='excluir-cidade-estado' data-id-cidade-estado="${cidade_estado.id}" class='delete' title='Apagar'><i class="fas fa-trash"></i></a>
                    </div>`
                    ]);
                }
            }

            tabela.DataTable({
                data: dadosTabela,
                columns: [{
                        title: 'ID'
                    },
                    {
                        title: 'Nome'
                    },
                    {
                        title: 'CEP'
                    },
                    {
                        title: 'Estado'
                    },
                    {
                        title: 'UF'
                    },
                    {
                        title: 'Ações',
                        orderable: false
                    }
                ],
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
                },
                dom: '<"top"lf>rt<"bottom"ip><"clear">',
                pageLength: 5,
                lengthMenu: [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "Todos"]
                ]
            });
        }
    }




    $(document).on("click", "#alterar-cidade-estado", function(e) {
        e.preventDefault();

        debugger;

        let recebe_cidade_estado_id = $(this).data("id-cidade-estado");
        let recebe_cidade = $(this).data("cidade");
        let recebe_cep = $(this).data("cep");
        let recebe_estado = $(this).data("estado");
        let recebe_estado_uf = $(this).data("estado-uf");

        $("#cidade_estado_id_alteracao").val(recebe_cidade_estado_id);
        $("#cidade").val(recebe_cidade);
        $("#cep").val(recebe_cep);
        $("#estado").val(recebe_estado);
        $("#uf").val(recebe_estado_uf);

        recebe_acao_alteracao_cidade_estado = "editar";
    });

    $(document).on("click", "#excluir-cidade-estado", function(e) {
        debugger;

        let recebe_confirmar_exclusao_cidade_estado = window.confirm("Tem certeza que deseja excluir cidade?");

        if (recebe_confirmar_exclusao_cidade_estado) {
            let recebe_id_cidade_estado = $(this).data("id-cidade-estado");
            $.ajax({
                url: "cadastros/processa_cidade_estado.php",
                type: "POST",
                dataType: "json",
                data: {
                    processo_cidade_estado: "excluir_cidade_estado",
                    valor_id_cidade_estado: recebe_id_cidade_estado,
                },
                success: async function(retorno_cidade) {
                    debugger;
                    console.log(retorno_cidade);
                    if (retorno_cidade) {
                        // window.location.href = "painel.php?pg=grava_risco";
                        await todas_cidades_estados();
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Falha ao excluir pessoa:" + error);
                },
            });
        } else {
            return;
        }
    });

    $("#grava-cidade-estado").click(function(e) {
        e.preventDefault();

        debugger;
        let recebe_cidade = $("#cidade").val();
        let recebe_cep = $("#cep").val();
        let recebe_estado = $("#estado").val();
        let recebe_uf = $("#uf").val();
        // let recebe_id_cidade_estado = $("#cidade_estado_id_alteracao").val();

        if (recebe_acao_alteracao_cidade_estado === "editar") {
            $.ajax({
                url: "cadastros/processa_cidade_estado.php",
                type: "POST",
                dataType: "json",
                data: {
                    processo_cidade_estado: "alterar_cidade_estado",
                    valor_cidade: recebe_cidade,
                    valor_cep: recebe_cep,
                    valor_estado: recebe_estado,
                    valor_uf: recebe_uf,
                    valor_id_cidade_estado: $("#cidade_estado_id_alteracao").val()
                },
                success: async function(retorno_cidade_estado) {
                    debugger;

                    console.log(retorno_cidade_estado);
                    if (retorno_cidade_estado) {
                        console.log("Cidade alterada com sucesso");
                        $("#corpo-mensagem-gravacao").html("Cidade alterada com sucesso");
                        $("#mensagem-gravacao").removeClass("hidden").addClass("opacity-100");

                        setTimeout(() => {
                            $("#mensagem-gravacao").addClass("opacity-0");
                        }, 4000);

                        setTimeout(() => {
                            $("#mensagem-gravacao").addClass("hidden").removeClass("opacity-0 opacity-100");
                        }, 4500);

                        $("#cidade").val("");
                        $("#cep").val("");
                        $("#estado").val("");
                        $("#uf").val("");
                        // window.location.href = "painel.php?pg=grava_risco";
                        await todas_cidades_estados();
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Falha ao alterar médico:" + error);
                },
            });
        } else {
            $.ajax({
                url: "cadastros/processa_cidade_estado.php",
                type: "POST",
                dataType: "json",
                data: {
                    processo_cidade_estado: "inserir_cidade_estado",
                    valor_cidade: recebe_cidade,
                    valor_cep: recebe_cep,
                    valor_estado: recebe_estado,
                    valor_uf: recebe_uf,
                },
                success: async function(retorno_cidade_estado) {
                    debugger;

                    console.log(retorno_cidade_estado);

                    if (retorno_cidade_estado > 0) {
                        console.log("Cidade cadastrada com sucesso");
                        $("#corpo-mensagem-gravacao").html("Cidade gravada com sucesso");
                        $("#mensagem-gravacao").removeClass("hidden").addClass("opacity-100");

                        setTimeout(() => {
                            $("#mensagem-gravacao").addClass("opacity-0");
                        }, 4000);

                        setTimeout(() => {
                            $("#mensagem-gravacao").addClass("hidden").removeClass("opacity-0 opacity-100");
                        }, 4500);

                        $("#cidade").val("");
                        $("#cep").val("");
                        $("#estado").val("");
                        $("#uf").val("");
                        // window.location.href = "painel.php?pg=grava_risco";
                        await todas_cidades_estados();
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Falha ao inserir empresa:" + error);
                },
            });
        }
    });
</script>