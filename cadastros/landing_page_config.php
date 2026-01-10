<?php
require_once 'config/database.php';
$pdo = getConnection();

// Busca as configurações atuais do banco
$query = "SELECT section, key_name, value_text FROM landing_page_config";
$stmt = $pdo->query($query);
$configs = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $configs[$row['section']][$row['key_name']] = $row['value_text'];
}

function getVal($section, $key, $data) {
    return isset($data[$section][$key]) ? htmlspecialchars($data[$section][$key]) : '';
}
?>

<style>
    /* Reset básico para este painel */
    * { box-sizing: border-box; }

    .form-section-title {
        border-bottom: 2px solid #e5e7eb;
        padding-bottom: 0.5rem;
        margin-bottom: 1.5rem;
        font-size: 1.25rem;
        font-weight: 600;
        color: #374151;
    }
    .form-group {
        margin-bottom: 1.5rem;
    }
    .form-label {
        display: block;
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: #4b5563;
        font-size: 0.875rem;
    }
    .form-input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        font-size: 1rem;
    }
    .form-input:focus {
        border-color: #6366f1;
        outline: none;
        box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.5);
    }
    .btn-save, .btn-primary {
        background-color: #4f46e5;
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 0.375rem;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.2s;
        border: none;
    }
    .btn-save:hover {
        background-color: #4338ca;
    }
    .btn-green {
        background-color: #10b981;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 500;
    }
    .btn-green:hover { background-color: #059669; }

    /* Custom Layout Utility Classes */
    .row-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        align-items: flex-end;
    }
    .col-1 { flex: 0 0 50px; text-align: center; display: flex; align-items: center; justify-content: center; height: 42px; font-size: 1.5rem; color: #0d9488; }
    .col-3 { flex: 1; min-width: 200px; }
    .col-5 { flex: 2; min-width: 300px; }
    .col-half { flex: 1; min-width: 45%; }
    
    .card-box {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        padding: 1.5rem;
        border-radius: 0.5rem;
        position: relative;
        margin-bottom: 1.5rem;
    }
    .btn-remove-card {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        background: transparent;
        border: none;
        color: #ef4444;
        cursor: pointer;
        font-size: 1.1rem;
        padding: 0.25rem;
    }
    .btn-remove-card:hover { color: #b91c1c; }

    .input-group {
        display: flex;
    }
    .input-group .form-input {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }
    .input-group-btn {
        border: 1px solid #d1d5db;
        border-left: none;
        background-color: #f3f4f6;
        padding: 0 0.75rem;
        border-top-right-radius: 0.375rem;
        border-bottom-right-radius: 0.375rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .input-group-btn:hover { background-color: #e5e7eb; }

    /* Nav Tabs */
    .nav-tabs {
        display: flex;
        border-bottom: 1px solid #e5e7eb;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }
    .nav-tab {
        padding: 1rem 1.5rem;
        cursor: pointer;
        border-bottom: 2px solid transparent;
        color: #6b7280;
        font-weight: 500;
    }
    .nav-tab.active {
        border-bottom-color: #4f46e5;
        color: #4f46e5;
    }
    .tab-content { display: none; }
    .tab-content.active { display: block; }

    /* Modal Styles */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }
    .modal-overlay.open {
        display: flex;
    }
    .modal-content {
        background-color: white;
        border-radius: 0.5rem;
        padding: 1.5rem;
        width: 100%;
        max-width: 600px;
        max-height: 80vh;
        display: flex;
        flex-direction: column;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    .modal-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: #111827;
        margin: 0;
    }
    .modal-close {
        background: none;
        border: none;
        font-size: 1.25rem;
        color: #6b7280;
        cursor: pointer;
    }
    .icon-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(40px, 1fr));
        gap: 0.5rem;
        overflow-y: auto;
        padding: 0.5rem;
        flex: 1;
        border: 1px solid #e5e7eb;
        border-radius: 0.375rem;
    }
    .icon-btn {
        background: white;
        border: 1px solid transparent;
        border-radius: 0.25rem;
        padding: 0.5rem;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }
    .icon-btn:hover {
        background-color: #f3f4f6;
        border-color: #d1d5db;
    }
    .icon-btn i {
        font-size: 1.5rem;
        color: #4b5563;
        margin-bottom: 0.25rem;
    }
    .mt-4 { margin-top: 1rem; }
    .mr-2 { margin-right: 0.5rem; }
</style>

<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Configurações da Landing Page</h1>
    </div>

    <!-- Abas de Navegação -->
    <div class="nav-tabs">
        <div class="nav-tab active" onclick="switchTab('hero')">Hero (Topo)</div>
        <div class="nav-tab" onclick="switchTab('features')">Recursos</div>
        <div class="nav-tab" onclick="switchTab('about')">Sobre Nós</div>
        <div class="nav-tab" onclick="switchTab('services_page')">Página Serviços</div>
        <div class="nav-tab" onclick="switchTab('segments')">Segmentos</div>
        <div class="nav-tab" onclick="switchTab('contact')">Contato & Social</div>
        <div class="nav-tab" onclick="switchTab('email_config')">Config Email</div>
    </div>

    <form id="landingPageForm">
        <!-- Hero Section -->
        <div id="tab-hero" class="tab-content active">
            <h3 class="form-section-title">Seção Principal (Hero)</h3>
            <div class="form-group">
                <label class="form-label">Título Principal</label>
                <input type="text" name="hero[title]" class="form-input" value="<?php echo getVal('hero', 'title', $configs); ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Subtítulo (Descrição)</label>
                <textarea name="hero[subtitle]" class="form-input" rows="4"><?php echo getVal('hero', 'subtitle', $configs); ?></textarea>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="form-group">
                    <label class="form-label">Texto do Botão</label>
                    <input type="text" name="hero[button_text]" class="form-input" value="<?php echo getVal('hero', 'button_text', $configs); ?>">
                </div>
                <div class="form-group">
                    <label class="form-label">Link do Botão</label>
                    <input type="text" name="hero[button_link]" class="form-input" value="<?php echo getVal('hero', 'button_link', $configs); ?>">
                </div>
            </div>
        </div>

        <!-- Features Section (Dinamica) -->
        <div id="tab-features" class="tab-content">
            <h3 class="form-section-title">Recursos (Destaques)</h3>
            <p class="text-gray-500 mb-4 text-sm">Adicione, ordene e edite os cards de destaque que aparecem na página central.</p>
            
            <div id="features-container">
                <!-- Os cards serão injetados via JS aqui -->
            </div>
            
            <button type="button" class="btn-green mt-4" onclick="addFeatureCard()">
                <i class="fas fa-plus"></i> Adicionar Card
            </button>
            
            <!-- Campo oculto que armazenará o JSON -->
            <input type="hidden" name="features[items]" id="features-json">
        </div>

        <!-- About Section (Sobre Nós) -->
        <div id="tab-about" class="tab-content">
            <h3 class="form-section-title">Sobre Nós</h3>
            <div class="form-group">
                <label class="form-label">Título Banner (Hero)</label>
                <input type="text" name="about[hero_title]" class="form-input" value="<?php echo getVal('about', 'hero_title', $configs); ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Subtítulo Banner (Hero)</label>
                <input type="text" name="about[hero_subtitle]" class="form-input" value="<?php echo getVal('about', 'hero_subtitle', $configs); ?>">
            </div>
            <hr class="my-6 border-gray-200">
            <div class="form-group">
                <label class="form-label">Título Principal (História)</label>
                <input type="text" name="about[main_title]" class="form-input" value="<?php echo getVal('about', 'main_title', $configs); ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Texto Principal (Parágrafo 1)</label>
                <textarea name="about[text_1]" class="form-input" rows="4"><?php echo getVal('about', 'text_1', $configs); ?></textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Texto Secundário (Parágrafo 2)</label>
                <textarea name="about[text_2]" class="form-input" rows="4"><?php echo getVal('about', 'text_2', $configs); ?></textarea>
            </div>
        </div>

        <!-- Services Page Section -->
        <div id="tab-services_page" class="tab-content">
            <h3 class="form-section-title">Página de Serviços</h3>
            <div class="form-group">
                <label class="form-label">Título Banner (Hero)</label>
                <input type="text" name="services_page[hero_title]" class="form-input" value="<?php echo getVal('services_page', 'hero_title', $configs); ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Subtítulo Banner (Hero)</label>
                <input type="text" name="services_page[hero_subtitle]" class="form-input" value="<?php echo getVal('services_page', 'hero_subtitle', $configs); ?>">
            </div>
            
            <hr class="my-6 border-gray-200">
            <h4 class="font-bold mb-4 text-gray-700">Lista de Serviços</h4>
            
            <div id="services-container">
                <!-- Cards de serviços injetados via JS -->
            </div>
            
             <button type="button" class="btn-green mt-4" onclick="addServiceCard()">
                <i class="fas fa-plus"></i> Adicionar Serviço
            </button>
            <input type="hidden" name="services_page[items]" id="services-json">
        </div>

        <!-- Segments Section -->
        <div id="tab-segments" class="tab-content">
            <h3 class="form-section-title">Segmentos (Para Quem É)</h3>
            <!-- Mantendo estático por enquanto pois são só 2 cards fixos no layout original, mas poderia ser dinâmico também -->
            <div class="form-group">
                <label class="form-label">Título da Seção</label>
                <input type="text" name="segments[segment_title]" class="form-input" value="<?php echo getVal('segments', 'segment_title', $configs); ?>">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Card 1 -->
                <div class="p-4 bg-gray-50 rounded border">
                    <h4 class="font-bold mb-4">Card 1 (Clínicas)</h4>
                    <div class="form-group">
                        <label class="form-label">Título</label>
                        <input type="text" name="segments[card_1_title]" class="form-input" value="<?php echo getVal('segments', 'card_1_title', $configs); ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Descrição</label>
                        <input type="text" name="segments[card_1_desc]" class="form-input" value="<?php echo getVal('segments', 'card_1_desc', $configs); ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Link</label>
                        <input type="text" name="segments[card_1_link]" class="form-input" value="<?php echo getVal('segments', 'card_1_link', $configs); ?>">
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="p-4 bg-gray-50 rounded border">
                    <h4 class="font-bold mb-4">Card 2 (Empresas)</h4>
                    <div class="form-group">
                        <label class="form-label">Título</label>
                        <input type="text" name="segments[card_2_title]" class="form-input" value="<?php echo getVal('segments', 'card_2_title', $configs); ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Descrição</label>
                        <input type="text" name="segments[card_2_desc]" class="form-input" value="<?php echo getVal('segments', 'card_2_desc', $configs); ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Link</label>
                        <input type="text" name="segments[card_2_link]" class="form-input" value="<?php echo getVal('segments', 'card_2_link', $configs); ?>">
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Section -->
        <div id="tab-contact" class="tab-content">
            <h3 class="form-section-title">Contato e Redes Sociais</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="font-bold mb-4">Contato</h4>
                    <div class="form-group">
                        <label class="form-label">Telefone</label>
                        <input type="text" name="contact[phone]" class="form-input" value="<?php echo getVal('contact', 'phone', $configs); ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="contact[email]" class="form-input" value="<?php echo getVal('contact', 'email', $configs); ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Endereço</label>
                        <textarea name="contact[address]" class="form-input" rows="2"><?php echo getVal('contact', 'address', $configs); ?></textarea>
                    </div>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Redes Sociais</h4>
                    <div class="form-group">
                        <label class="form-label">LinkedIn</label>
                        <input type="text" name="social[linkedin]" class="form-input" value="<?php echo getVal('social', 'linkedin', $configs); ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Facebook</label>
                        <input type="text" name="social[facebook]" class="form-input" value="<?php echo getVal('social', 'facebook', $configs); ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Instagram</label>
                        <input type="text" name="social[instagram]" class="form-input" value="<?php echo getVal('social', 'instagram', $configs); ?>">
                    </div>
                </div>
            </div>
            <div class="mt-6">
                 <h4 class="font-bold mb-4">Mapa de Localização</h4>
                 <div class="form-group">
                      <label class="form-label">Código Iframe do Google Maps</label>
                      <textarea name="contact[map_iframe]" class="form-input" rows="4"><?php echo getVal('contact', 'map_iframe', $configs); ?></textarea>
                 </div>
            </div>
        </div>
        
        <!-- Email Config Section -->
        <div id="tab-email_config" class="tab-content">
             <h3 class="form-section-title">Configurações de E-mail</h3>
             <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                 <div class="form-group">
                     <label class="form-label">Protocolo</label>
                     <select name="email_config[protocol]" class="form-input">
                         <option value="smtp" <?php echo getVal('email_config', 'protocol', $configs) == 'smtp' ? 'selected' : ''; ?>>SMTP</option>
                         <option value="pop" <?php echo getVal('email_config', 'protocol', $configs) == 'pop' ? 'selected' : ''; ?>>POP3</option>
                     </select>
                 </div>
                 <div class="form-group">
                     <label class="form-label">Host</label>
                     <input type="text" name="email_config[host]" class="form-input" value="<?php echo getVal('email_config', 'host', $configs); ?>">
                 </div>
                 <div class="form-group">
                    <label class="form-label">Porta</label>
                    <input type="text" name="email_config[port]" class="form-input" value="<?php echo getVal('email_config', 'port', $configs); ?>">
                </div>
                <div class="form-group">
                    <label class="form-label">Usuário</label>
                    <input type="text" name="email_config[username]" class="form-input" value="<?php echo getVal('email_config', 'username', $configs); ?>">
                </div>
                <div class="form-group">
                    <label class="form-label">Senha</label>
                    <input type="password" name="email_config[password]" class="form-input" value="<?php echo getVal('email_config', 'password', $configs); ?>">
                </div>
             </div>
             <hr class="my-6 border-gray-200">
             <h4 class="font-bold mb-4">Remetente</h4>
             <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="form-group">
                    <label class="form-label">Nome</label>
                    <input type="text" name="email_config[from_name]" class="form-input" value="<?php echo getVal('email_config', 'from_name', $configs); ?>">
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email_config[from_email]" class="form-input" value="<?php echo getVal('email_config', 'from_email', $configs); ?>">
                </div>
             </div>
        </div>
            <button type="submit" class="btn-save">
                <i class="fas fa-save mr-2"></i> Salvar Alterações
            </button>
        </div>
    </form>
</div>

<!-- Modal de Icones -->
<div id="iconModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Selecione um Ícone</h3>
            <button type="button" onclick="closeIconModal()" class="modal-close"><i class="fas fa-times"></i></button>
        </div>
        <input type="text" id="iconSearch" placeholder="Pesquisar ícone..." class="form-input mb-4" onkeyup="filterIcons()">
        <div id="iconGrid" class="icon-grid">
            <!-- Icons injected via JS -->
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Configurações iniciais vindas do PHP (Raw Data for JS)
    let featuresData = <?php 
        $f = isset($configs['features']['items']) ? $configs['features']['items'] : '[]';
        echo $f ?: '[]';
    ?>;
    
    let servicesData = <?php 
        $s = isset($configs['services_page']['items']) ? $configs['services_page']['items'] : '[]';
        echo $s ?: '[]';
    ?>;

    // Lista simplificada de ícones comuns do FontAwesome 5/6 Free
    const commonIcons = [
        "fas fa-file-medical", "fas fa-file-medical-alt", "fas fa-folder-open", "fas fa-sync", 
        "fas fa-hard-hat", "fas fa-cloud-upload-alt", "fas fa-user-md", "fas fa-notes-medical",
        "fas fa-clinic-medical", "fas fa-hospital", "fas fa-ambulance", "fas fa-heartbeat",
        "fas fa-stethoscope", "fas fa-syringe", "fas fa-pills", "fas fa-first-aid",
        "fas fa-user-nurse", "fas fa-procedures", "fas fa-x-ray", "fas fa-thermometer",
        "fas fa-check", "fas fa-check-circle", "fas fa-times", "fas fa-exclamation-triangle",
        "fas fa-info-circle", "fas fa-cog", "fas fa-cogs", "fas fa-chart-line",
        "fas fa-users", "fas fa-building", "fas fa-city", "fas fa-landmark",
        "fas fa-envelope", "fas fa-phone", "fas fa-map-marker-alt", "fas fa-globe",
        "fas fa-search", "fas fa-calendar", "fas fa-clock", "fas fa-history"
    ];

    let currentIconInput = null;

    function renderFeatures() {
        const container = document.getElementById('features-container');
        container.innerHTML = '';
        featuresData.forEach((item, index) => {
            const html = `
                <div class="card-box">
                    <button type="button" onclick="removeFeature(${index})" class="btn-remove-card" title="Remover Card">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                    <div class="row-grid">
                        <div class="col-1">
                            <i class="${item.icon}"></i>
                        </div>
                        <div class="col-3">
                            <label class="form-label">Ícone</label>
                            <div class="input-group">
                                <input type="text" class="form-input" value="${item.icon}" onchange="updateFeature(${index}, 'icon', this.value)" id="feat-icon-${index}">
                                <button type="button" onclick="openIconModal('feat-icon-${index}')" class="input-group-btn" title="Buscar Ícone">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-3">
                            <label class="form-label">Título</label>
                            <input type="text" class="form-input" value="${item.title}" onchange="updateFeature(${index}, 'title', this.value)">
                        </div>
                        <div class="col-5">
                            <label class="form-label">Descrição</label>
                            <input type="text" class="form-input" value="${item.desc}" onchange="updateFeature(${index}, 'desc', this.value)">
                        </div>
                    </div>
                </div>
            `;
            container.innerHTML += html;
        });
        document.getElementById('features-json').value = JSON.stringify(featuresData);
    }
    
    function renderServices() {
        const container = document.getElementById('services-container');
        container.innerHTML = '';
        servicesData.forEach((item, index) => {
             const html = `
                <div class="card-box">
                    <button type="button" onclick="removeService(${index})" class="btn-remove-card" title="Remover Card">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                    <div class="row-grid">
                        <div class="col-1">
                            <i class="${item.icon}"></i>
                        </div>
                        <div class="col-3">
                            <label class="form-label">Ícone</label>
                            <div class="input-group">
                                <input type="text" class="form-input" value="${item.icon}" onchange="updateService(${index}, 'icon', this.value)" id="serv-icon-${index}">
                                <button type="button" onclick="openIconModal('serv-icon-${index}')" class="input-group-btn" title="Buscar Ícone">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-3">
                            <label class="form-label">Título</label>
                            <input type="text" class="form-input" value="${item.title}" onchange="updateService(${index}, 'title', this.value)">
                        </div>
                        <div class="col-5">
                            <label class="form-label">Descrição</label>
                            <input type="text" class="form-input" value="${item.desc}" onchange="updateService(${index}, 'desc', this.value)">
                        </div>
                    </div>
                </div>
            `;
            container.innerHTML += html;
        });
        document.getElementById('services-json').value = JSON.stringify(servicesData);
    }

    function addFeatureCard() {
        featuresData.push({ icon: 'fas fa-star', title: 'Novo Recurso', desc: 'Descrição do recurso' });
        renderFeatures();
    }
    
    function removeFeature(index) {
        featuresData.splice(index, 1);
        renderFeatures();
    }
    
    function updateFeature(index, key, value) {
        featuresData[index][key] = value;
        document.getElementById('features-json').value = JSON.stringify(featuresData);
        // Se mudou o icone, atualiza visualmente se quiser (opcional, rerender é mais facil mas perde foco, melhor só atualizar value hidden)
        // Como o renderFeatures refaz tudo, o foco se perde. Ideal é não dar re-render no onchange. O renderFeatures já usa os dados atualizados se chamarmos ele.
        // Mas para manter o preview do icone atualizado em tempo real teriamos que manipular o DOM direto.
        // Para simplificar, vou assumir que o usuario edita e clica fora.
        // Se quiser atualizar visualmente o icone ao lado:
        if(key === 'icon') {
             // acha o elemento i correspondente e atualiza classe
             // porem como é array, o seletor é chato.
        }
    }
    
    function addServiceCard() {
        servicesData.push({ icon: 'fas fa-briefcase', title: 'Novo Serviço', desc: 'Descrição do serviço' });
        renderServices();
    }

    function removeService(index) {
        servicesData.splice(index, 1);
        renderServices();
    }

    function updateService(index, key, value) {
        servicesData[index][key] = value;
        document.getElementById('services-json').value = JSON.stringify(servicesData);
    }

    // --- Icon Picker Functions ---

    function openIconModal(inputId) {
        currentIconInput = inputId;
        const grid = document.getElementById('iconGrid');
        grid.innerHTML = '';
        commonIcons.forEach(icon => {
            const btn = document.createElement('button');
            btn.className = "icon-btn";
            btn.innerHTML = `<i class="${icon}"></i>`;
            btn.onclick = () => selectIcon(icon);
            grid.appendChild(btn);
        });
        document.getElementById('iconModal').classList.add('open');
        document.getElementById('iconSearch').value = '';
        document.getElementById('iconSearch').focus();
    }

    function closeIconModal() {
        document.getElementById('iconModal').classList.remove('open');
        currentIconInput = null;
    }

    function selectIcon(iconClass) {
        if(currentIconInput) {
            const input = document.getElementById(currentIconInput);
            input.value = iconClass;
            // Disparar evento onchange manualmente
            input.dispatchEvent(new Event('change'));
            
            // Tenta achar o index e tipo pra atualizar o preview se possivel, ou só o render resolve no proximo clique
            // Vamos forçar um re-render geral após um breve delay pra não quebrar a UI
            if(currentIconInput.startsWith('feat')) renderFeatures();
            if(currentIconInput.startsWith('serv')) renderServices();
        }
        closeIconModal();
    }

    function filterIcons() {
        const query = document.getElementById('iconSearch').value.toLowerCase();
        const grid = document.getElementById('iconGrid');
        grid.innerHTML = '';
        const filtered = commonIcons.filter(i => i.includes(query));
        filtered.forEach(icon => {
            const btn = document.createElement('button');
            btn.className = "icon-btn";
            btn.innerHTML = `<i class="${icon}"></i>`;
            btn.onclick = () => selectIcon(icon);
            grid.appendChild(btn);
        });
    }


    function switchTab(tabId) {
        document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
        document.querySelectorAll('.nav-tab').forEach(el => el.classList.remove('active'));
        document.getElementById('tab-' + tabId).classList.add('active');
        // Find tab element to add active class
        const tabs = document.querySelectorAll('.nav-tab');
        // Simple mapping based on known order or text is fragile. Let's assume order matches or verify
        // Melhor abordagem: adicionar data-target nas tabs
    }
    
    // Inicializar abas com logica melhor de classe ativa
    document.querySelectorAll('.nav-tab').forEach(tab => {
        tab.addEventListener('click', function() {
           // remove active de todos
           document.querySelectorAll('.nav-tab').forEach(t => t.classList.remove('active'));
           this.classList.add('active');
           // switch content is already called inline but cleaning that up would use data attributes. 
           // Mantendo o inline onclick="switchTab" do HTML anterior, a função switchTab só precisa gerenciar o content.
           // A classe active na TAB foi removida pelo switchTab la em cima? Sim.
           // Então preciso re-adicionar na tab clicada. Como o evento onclick chama switchTab, eu posso passar o `this`.
        });
    });

    // Sobrescrevendo a switchTab antiga para ser mais robusta
    window.switchTab = function(tabId) {
        document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
        document.getElementById('tab-' + tabId).classList.add('active');
        
        // Atualiza estilo das abas
        document.querySelectorAll('.nav-tab').forEach(t => {
            if(t.innerText.toLowerCase().includes(tabId.replace('_page', '').replace('features', 'recursos').replace('hero', 'hero').replace('segments', 'segmentos').replace('contact', 'contato').replace('about', 'sobre'))) {
               // logica falha de string matching, vamos confiar no clique do usuario setar a classe ou passar o elemento
            }
        });
    };
    
    // Melhorando o HTML das tabs para passar o elemento
    // Vou reinjetar o HTML das tabs no form replacement para incluir `onclick="switchTab('id', this)"`

    document.getElementById('landingPageForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        formData.append('acao', 'salvar_config');

        const btn = this.querySelector('button[type="submit"]');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Salvando...';
        btn.disabled = true;

        fetch('cadastros/processa_landing_page.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso!',
                    text: 'Configurações atualizadas com sucesso.',
                    timer: 1500,
                    showConfirmButton: false
                });
            } else {
                throw new Error(data.message || 'Erro ao salvar');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Erro!',
                text: 'Não foi possível salvar as alterações: ' + error.message
            });
        })
        .finally(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
        });
    });

    // Iniciar
    renderFeatures();
    renderServices();

</script>
