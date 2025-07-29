<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Etapas</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Fustat Font -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/fustat@5.0.0/400.min.css">
  <style>
    /* Estilos globais de fonte */
    @font-face {
      font-family: 'Fustat';
      src: url('https://cdn.jsdelivr.net/npm/@fontsource/fustat@5.0.0/files/fustat-latin-400-normal.woff2') format('woff2'),
        url('https://cdn.jsdelivr.net/npm/@fontsource/fustat@5.0.0/files/fustat-latin-400-normal.woff') format('woff');
      font-weight: normal;
      font-style: normal;
      font-display: swap;
    }

    body {
      font-family: 'Fustat', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', sans-serif;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      line-height: 1.5;
      color: #333;
    }

    /* Estilos para os dropdowns do laudo */
    .laudo-dropdown-wrapper {
      display: flex;
      flex-direction: column;
      min-width: 140px;
    }

    .laudo-dropdown-wrapper label {
      font-size: 12px;
      color: #495057;
      margin-bottom: 4px;
      font-weight: 500;
      display: block;
    }

    .laudo-dropdown {
      position: relative;
      cursor: pointer;
      border: 1px solid #ced4da;
      border-radius: 4px;
      padding: 6px 10px;
      background-color: white;
      font-size: 13px;
      min-width: 120px;
      user-select: none;
      height: 36px;
      display: flex;
      align-items: center;
    }

    .laudo-dropdown:hover {
      border-color: #adb5bd;
    }

    .laudo-dropdown:hover {
      border-color: #4a90e2;
      box-shadow: 0 0 0 1px #4a90e2;
    }

    .laudo-dropdown .dropdown-options {
      display: none;
      position: absolute;
      top: 100%;
      left: 0;
      right: 0;
      background: white;
      border: 1px solid #dee2e6;
      border-radius: 4px;
      margin-top: 4px;
      z-index: 1000;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      max-height: 200px;
      overflow-y: auto;
    }

    .laudo-dropdown.active .dropdown-options {
      display: block;
    }

    .laudo-dropdown .dropdown-option {
      padding: 6px 10px;
      cursor: pointer;
      font-size: 13px;
    }

    .laudo-dropdown .dropdown-option:hover {
      background-color: #f5f5f5;
    }

    .laudo-dropdown .dropdown-selected {
      display: flex;
      justify-content: space-between;
      align-items: center;
      width: 100%;
    }

    .selected-text {
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      margin-right: 8px;
    }

    .laudo-dropdown .dropdown-arrow {
      font-size: 10px;
      color: #6c757d;
      transition: transform 0.2s;
      margin-left: 8px;
      flex-shrink: 0;
    }

    .laudo-dropdown.active .dropdown-arrow {
      transform: rotate(180deg);
    }

    /* Estilos para o resumo */
    #resumo-laudo {
      display: flex;
      flex-wrap: wrap;
      gap: 8px;
      margin-top: 8px;
    }

    .resumo-item {
      background-color: #fff3cd;
      border: 1px solid #ffeeba;
      border-radius: 12px;
      padding: 2px 10px;
      font-size: 12px;
      color: #856404;
      display: flex;
      align-items: center;
      height: 24px;
      white-space: nowrap;
    }

    .resumo-item .label {
      font-weight: 500;
      margin-right: 4px;
    }

    .resumo-item .value {
      font-weight: 600;
    }

    .laudo-dropdown-wrapper {
      margin-bottom: 15px;
    }

    .laudo-dropdown-wrapper label {
      display: block;
      margin-bottom: 5px;
      font-size: 13px;
      color: #333;
      font-weight: 500;
    }

    /* Estilos para o ECP */
    .ecp-container {
      padding: 20px 0;
    }

    .ecp-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 20px;
      margin: 20px 0;
    }

    @media (max-width: 768px) {
      .ecp-grid {
        grid-template-columns: 1fr;
      }
    }

    .ecp-field {
      margin-bottom: 20px;
      break-inside: avoid;
    }

    .ecp-field-empresa {
      grid-column: 1 / -1;
      margin-bottom: 30px;
      background: #f8f9fa;
      padding: 20px;
      border-radius: 8px;
      border-left: 4px solid #4a90e2;
    }

    .ecp-field-empresa .ecp-input {
      font-size: 16px;
      padding: 14px 18px;
    }

    .ecp-label {
      display: block;
      font-weight: 600;
      margin-bottom: 8px;
      color: #333;
    }

    .ecp-input-group {
      display: flex;
      gap: 8px;
    }

    .ecp-input {
      flex: 1;
      padding: 12px 15px;
      border: 1px solid #ddd;
      border-radius: 8px;
      font-size: 14px;
    }

    .ecp-button-add {
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 8px;
      padding: 0 16px;
      cursor: pointer;
      font-size: 16px;
      font-weight: bold;
    }

    .ecp-results {
      max-height: 300px;
      overflow-y: auto;
      border: 1px solid #e2e8f0;
      border-radius: 4px;
      margin-top: 5px;
      background: white;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      position: relative;
      z-index: 1000;
    }

    .ecp-results div {
      padding: 10px;
      cursor: pointer;
      border-bottom: 1px solid #eee;
    }

    .ecp-results div:hover {
      background-color: #f5f5f5;
    }

    .ecp-details {
      margin-top: 12px;
      font-size: 13px;
      color: #555;
      background: #f8f9fa;
      padding: 12px 15px;
      border-radius: 6px;
      border-left: 4px solid #4a90e2;
    }

    .ecp-empresa-info {
      margin-top: 12px;
    }

    .ecp-empresa-dados {
      margin-bottom: 10px;
      line-height: 1.4;
    }

    .ecp-empresa-metadados {
      display: flex;
      gap: 20px;
      margin-top: 12px;
      flex-wrap: wrap;
      padding-top: 10px;
      border-top: 1px solid #eee;
    }

    .ecp-info-item {
      display: flex;
      align-items: center;
      gap: 6px;
      margin-right: 15px;
    }

    .ecp-info-item i {
      color: #4a90e2;
      font-size: 14px;
    }

    .ecp-status {
      display: inline-flex;
      align-items: center;
      padding: 2px 8px;
      border-radius: 10px;
      font-size: 12px;
      font-weight: 500;
    }

    .ecp-status.ativo {
      background-color: #e6f7e6;
      color: #2e7d32;
    }

    .ecp-status.inativo {
      background-color: #ffebee;
      color: #c62828;
    }

    .ecp-questionario {
      background: white;
      padding: 20px;
      border-radius: 8px;
      margin-top: 0;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
      height: 100%;
      box-sizing: border-box;
    }

    .ecp-questionario-title {
      color: #1a73e8;
      font-weight: 600;
      margin-bottom: 15px;
    }

    .ecp-questionario-label {
      display: block;
      font-weight: 500;
      margin-bottom: 10px;
      font-size: 16px;
    }

    .ecp-radio-group {
      display: flex;
      gap: 20px;
      margin: 10px 0;
    }

    .ecp-radio {
      display: flex;
      align-items: center;
      gap: 8px;
      cursor: pointer;
    }

    .ecp-radio input[type="radio"] {
      width: 18px;
      height: 18px;
    }

    .ecp-questionario-note {
      font-size: 13px;
      color: #666;
      font-style: italic;
      margin-top: 10px;
    }

    @keyframes blink {
      0% {
        opacity: 1;
      }

      50% {
        opacity: 0.3;
      }

      100% {
        opacity: 1;
      }
    }

    .blink-truck {
      animation: blink 1.5s infinite;
      color: #e67e22;
    }

    /* Modal Styles */
    .ecp-modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 1000;
      align-items: center;
      justify-content: center;
    }

    .ecp-modal-content {
      background: white;
      padding: 25px;
      border-radius: 10px;
      width: 90%;
      max-width: 500px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .ecp-modal h2 {
      margin-top: 0;
      color: #333;
      font-size: 1.5em;
      margin-bottom: 20px;
    }

    .ecp-modal-input {
      width: 100%;
      padding: 12px;
      margin-bottom: 15px;
      border: 1px solid #ddd;
      border-radius: 6px;
      font-size: 14px;
    }

    .ecp-modal-buttons {
      display: flex;
      justify-content: flex-end;
      gap: 10px;
      margin-top: 20px;
    }

    .ecp-button-cancel {
      padding: 8px 16px;
      background: #f0f0f0;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    .ecp-button-save {
      padding: 8px 20px;
      background: #4CAF50;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    .ecp-result-item {
      padding: 10px;
      cursor: pointer;
      border-bottom: 1px solid #eee;
    }

    .ecp-result-item:hover {
      background-color: #f5f5f5;
    }

    :root {
      --fustat-font: 'Fustat Variable', sans-serif;
    }

    body {
      font-family: var(--fustat-font);
      background: #f5f5f5;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: flex-start;
      min-height: 100vh;
      margin: 0;
      padding-top: 60px;
    }

    .tabs-container {
      position: relative;
      width: 800px;
      max-width: 90vw;
      z-index: 2;
      margin-bottom: -8px;
    }

    .tabs {
      display: flex;
      justify-content: space-around;
      position: relative;
      width: 65%;
      flex-wrap: nowrap;
      margin-left: 200px;
    }

    .tab {
      padding: 15px 25px;
      border-radius: 20px 20px 0 0;
      background: #e0e0e0;
      background: linear-gradient(0deg, rgba(224, 224, 224, 1) 0%, rgba(255, 255, 255, 1) 99%);
      color: #adadad;
      font-weight: 500;
      cursor: pointer;
      transition: 0.3s ease;
      display: flex;
      align-items: center;
      gap: 8px;
      z-index: 1;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      transform: translateY(0);
      box-shadow: 0 -1px 0 #fff, 0 4px 12px rgba(0, 0, 0, 0.15);

    }

    .tab {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 10px 15px;
      min-height: 60px;
      transition: all 0.3s ease;
    }

    .tab i {
      margin-bottom: 2px;
    }

    .step-annotation {
      font-size: 10px;
      margin-top: 2px;
      font-weight: normal;
      opacity: 0.8;
    }

    /* Cores específicas para cada aba */
    .tab[data-step="0"] {
      color: #3b82f6;
      /* Azul */
    }

    .tab[data-step="1"] {
      color: rgba(16, 185, 129, 0.6);
      /* Verde com opacidade */
    }

    .tab[data-step="2"] {
      color: rgba(139, 92, 246, 0.6);
      /* Roxo com opacidade */
    }

    .tab[data-step="3"] {
      color: rgba(245, 158, 11, 0.6);
      /* Âmbar com opacidade */
    }

    .tab[data-step="4"] {
      color: rgba(236, 72, 153, 0.6);
      /* Rosa com opacidade */
    }

    .tab[data-step="5"] {
      color: rgba(6, 182, 212, 0.6);
      /* Ciano com opacidade */
    }

    /* Estilo para abas ativas - cores mais vibrantes */
    .tab.active[data-step="0"] {
      color: #3b82f6;
    }

    .tab.active[data-step="1"] {
      color: #10b981;
    }

    .tab.active[data-step="2"] {
      color: #8b5cf6;
    }

    .tab.active[data-step="3"] {
      color: #f59e0b;
    }

    .tab.active[data-step="4"] {
      color: #ec4899;
    }

    .tab.active[data-step="5"] {
      color: #06b6d4;
    }

    /* Estilo para aba ativa */
    .tab.active {
      background: #fff;
      box-shadow: 0 -1px 0 #fff, 0 4px 12px rgba(0, 0, 0, 0.15);
      z-index: 3;
      transform: translateY(-8px);
      font-weight: 600;
    }

    /* Efeito hover */
    .tab:not(.active):hover {
      opacity: 0.9;
      transform: translateY(-4px);
    }

    .tab-content {
      background: #fff;
      width: 900px;
      max-width: 90vw;
      min-height: 500px;
      border-radius: 40px;
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
      padding: 40px;
      position: relative;
      z-index: 2;
      display: flex;
      flex-direction: column;
    }

    .exam-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
      margin-top: 30px;
      flex-grow: 1;
    }

    .exam-card {
      background: #fff;
      border: 2px solid #e9ecef;
      border-radius: 15px;
      padding: 25px 20px;
      text-align: center;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }

    .exam-card img {
      background-color: #f8f9fa;
      padding: 15px;
      border-radius: 12px;
      margin-bottom: 15px;
      transition: all 0.3s ease;
      position: relative;
      z-index: 1;
    }

    /* Cores específicas para cada tipo de exame */
    .exam-card[data-exam="admissional"]:hover,
    .exam-card[data-exam="admissional"].active {
      border-color: #4a90e2;
    }

    .exam-card[data-exam="admissional"]:hover img {
      background-color: #4a90e2;
    }

    .exam-card[data-exam="admissional"].active {
      background-color: #e7f1ff;
    }

    .exam-card[data-exam="admissional"].active img {
      background-color: #4a90e2;
    }

    .exam-card[data-exam="periodico"]:hover,
    .exam-card[data-exam="periodico"].active {
      border-color: #34c759;
    }

    .exam-card[data-exam="periodico"]:hover img {
      background-color: #34c759;
    }

    .exam-card[data-exam="periodico"].active {
      background-color: #e8f5e9;
    }

    .exam-card[data-exam="periodico"].active img {
      background-color: #34c759;
    }

    .exam-card[data-exam="demissional"]:hover,
    .exam-card[data-exam="demissional"].active {
      border-color: #ff3b30;
    }

    .exam-card[data-exam="demissional"]:hover img {
      background-color: #ff3b30;
    }

    .exam-card[data-exam="demissional"].active {
      background-color: #ffebee;
    }

    .exam-card[data-exam="demissional"].active img {
      background-color: #ff3b30;
    }

    .exam-card[data-exam="retorno"]:hover,
    .exam-card[data-exam="retorno"].active {
      border-color: #ff9500;
    }

    .exam-card[data-exam="retorno"]:hover img {
      background-color: #ff9500;
    }

    .exam-card[data-exam="retorno"].active {
      background-color: #fff3e0;
    }

    .exam-card[data-exam="retorno"].active img {
      background-color: #ff9500;
    }

    .exam-card[data-exam="mudanca"]:hover,
    .exam-card[data-exam="mudanca"].active {
      border-color: #af52de;
    }

    .exam-card[data-exam="mudanca"]:hover img {
      background-color: #af52de;
    }

    .exam-card[data-exam="mudanca"].active {
      background-color: #f3e5f5;
    }

    .exam-card[data-exam="mudanca"].active img {
      background-color: #af52de;
    }

    .exam-card[data-exam="exame_laudo"]:hover,
    .exam-card[data-exam="exame_laudo"].active {
      border-color: #5856d6;
    }

    .exam-card[data-exam="exame_laudo"]:hover img {
      background-color: #5856d6;
    }

    .exam-card[data-exam="exame_laudo"].active {
      background-color: #e8eaf6;
    }

    .exam-card[data-exam="exame_laudo"].active img {
      background-color: #5856d6;
    }

    .exam-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .exam-card.active {
      border-color: #4a90e2;
      background-color: #f8f9fa;
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .validation-error {
      color: #dc3545;
      font-size: 14px;
      margin: 15px 0;
      display: none;
    }

    .ecp-details {
      margin-top: 10px;
      padding: 10px;
      background-color: #f9f9f9;
      border-radius: 4px;
      border-left: 3px solid #4CAF50;
      display: none;
      /* Esconde por padrão */
    }

    .validation-visible {
      display: block;
      animation: shake 0.5s ease-in-out;
    }

    /* Estilos para o componente de Riscos */
    .group-option {
      display: block;
      padding: 0.6rem 1rem;
      margin: 0.2rem 0;
      border-radius: 4px;
      cursor: pointer;
      transition: all 0.15s;
      user-select: none;
    }

    .group-option:hover {
      background-color: #f1f3f5;
    }

    .group-option input[type="checkbox"] {
      margin-right: 10px;
    }

    .group-option input[type="checkbox"]:checked+span {
      font-weight: 500;
      color: #1971c2;
    }

    .ecp-results {
      display: none;
      max-height: 300px;
      overflow-y: auto;
      border: 1px solid #dee2e6;
      border-radius: 8px;
      margin-top: 0.5rem;
      background: white;
    }

    .risk-item {
      display: flex;
      align-items: center;
      padding: 0.6rem 1rem;
      cursor: pointer;
      transition: background 0.15s;
      border-bottom: 1px solid #f1f3f5;
      font-size: 0.9rem;
    }

    .risk-item:hover {
      background-color: #f8f9fa;
    }

    .risk-code {
      font-weight: 600;
      margin-right: 0.6rem;
      color: #1971c2;
      min-width: 60px;
      font-size: 0.9em;
    }

    .risk-name {
      flex: 1;
      font-size: 0.95em;
      line-height: 1.3;
    }

    .risk-group-tag {
      background: #e2e8f0;
      padding: 0.2rem 0.5rem;
      border-radius: 4px;
      font-size: 0.7rem;
      color: #495057;
      margin-left: 0.5rem;
    }

    .riscos-selecionados {
      background: #f8f9fa;
      border: 1px solid #dee2e6;
      border-radius: 8px;
      padding: 1rem;
      min-height: 200px;
    }

    .risk-group {
      margin-bottom: 1rem;
      border: 1px solid #e0e0e0;
      border-radius: 6px;
      overflow: hidden;
    }

    .risk-group-header {
      background: #f1f3f5;
      padding: 0.5rem 1rem;
      font-size: 0.9rem;
      color: #333;
      font-weight: 600;
      border-bottom: 1px solid #dee2e6;
    }

    .risk-group-content {
      padding: 0.5rem;
      background: white;
    }

    .selected-risk {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0.5rem 0.8rem;
      margin-bottom: 0.4rem;
      background: #e7f5ff;
      border-radius: 6px;
      border: 1px solid #d0ebff;
      font-size: 0.9rem;
      line-height: 1.3;
    }

    .remove-risk {
      color: #e03131;
      cursor: pointer;
      font-weight: 600;
      margin-left: 0.5rem;
      padding: 0.2rem 0.5rem;
      border-radius: 4px;
      transition: background 0.2s;
    }

    .remove-risk:hover {
      background: rgba(224, 49, 49, 0.1);
    }

    .ecp-modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      z-index: 1000;
      align-items: center;
      justify-content: center;
    }

    .ecp-modal-content {
      background: white;
      padding: 1.5rem;
      border-radius: 8px;
      width: 100%;
      max-width: 500px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .ecp-modal h2 {
      margin-top: 0;
      margin-bottom: 1.5rem;
      color: #333;
      font-size: 1.25rem;
    }

    .ecp-modal-input {
      width: 100%;
      padding: 0.75rem;
      margin-bottom: 1.5rem;
      border: 1px solid #dee2e6;
      border-radius: 6px;
      font-size: 1rem;
    }

    .ecp-modal-buttons {
      display: flex;
      justify-content: flex-end;
      gap: 0.75rem;
    }

    .ecp-button {
      padding: 0.5rem 1rem;
      border: none;
      border-radius: 6px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s;
      background: #1971c2;
      color: white;
    }

    .ecp-button:hover {
      background: #1864ab;
    }

    .ecp-button-secondary {
      background: #6c757d;
      color: white;
    }

    .ecp-button-secondary:hover {
      background: #5a6268;
    }

    @keyframes shake {

      0%,
      100% {
        transform: translateX(0);
      }

      25% {
        transform: translateX(-5px);
      }

      75% {
        transform: translateX(5px);
      }
    }

    .exam-card svg {
      width: 60px;
      height: 60px;
      margin-bottom: 15px;
    }

    .exam-card h3 {
      margin: 10px 0 5px;
      font-size: 18px;
      color: #333;
    }

    .exam-card p {
      color: #666;
      font-size: 14px;
      margin: 0;
    }

    .step-header {
      display: flex;
      gap: 20px;
      margin: 30px 0 40px 30px;
    }

    .step-title {
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .step-title h2 {
      font-size: 28px;
      font-weight: 500;
      color: #333;
      margin: 0;
      line-height: 1.3;
      letter-spacing: 0.3px;
    }

    .step-title .title-icon {
      width: 48px;
      height: 48px;
      display: flex;
      align-items: flex-start;
      justify-content: center;
      margin-top: 6px;
    }

    .step-subtitle {
      color: #666;
      margin-top: 8px;
      font-size: 18px;
      font-weight: 400;
      line-height: 1.4;
    }

    .navigation-buttons {
      display: flex;
      justify-content: space-between;
      width: 800px;
      max-width: 90vw;
      margin-top: 20px;
      z-index: 1;
    }

    .btn-nav {
      font-size: 18px;
      font-weight: 600;
      color: #000;
      cursor: pointer;
      border: none;
      background: #fff;
      padding: 10px 20px;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      display: flex;
      align-items: center;
      gap: 10px;
      transition: 0.3s;
    }

    .btn-nav:hover {
      background-color: #eaeaea;
      color: #007bff;
    }

    /* Estilo específico para o botão Salvar Kit */
    .btn-save-kit {
      background-color: #28a745;
      color: white;
      border: 1px solid #28a745;
      transition: all 0.3s ease;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      font-weight: 500;
      padding: 8px 20px;
      border-radius: 6px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    .btn-save-kit:hover {
      background-color: #218838;
      border-color: #1e7e34;
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .btn-save-kit:active {
      transform: translateY(0);
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* Estilos para a mensagem de validação */
    .validation-message {
      background-color: #fff8e6;
      border-left: 4px solid #ffc107;
      padding: 12px 20px;
      margin: 0 0 20px 0;
      border-radius: 0 4px 4px 0;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      animation: slideIn 0.3s ease-out;
      position: relative;
      overflow: hidden;
    }

    .validation-message-content {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .validation-message i {
      color: #ffc107;
      font-size: 18px;
      flex-shrink: 0;
    }

    .validation-message span {
      color: #856404;
      font-size: 14px;
      line-height: 1.5;
      flex-grow: 1;
    }

    .validation-close {
      background: none;
      border: none;
      color: #ffc107;
      cursor: pointer;
      padding: 0 5px;
      font-size: 16px;
      opacity: 0.7;
      transition: opacity 0.2s;
      display: flex;
      align-items: center;
      justify-content: center;
      width: 24px;
      height: 24px;
      border-radius: 50%;
    }

    .validation-close:hover {
      opacity: 1;
      background-color: rgba(0, 0, 0, 0.05);
    }

    .validation-close:focus {
      outline: none;
      box-shadow: 0 0 0 2px rgba(255, 193, 7, 0.5);
    }

    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeOut {
      from {
        opacity: 1;
        transform: translateY(0);
      }

      to {
        opacity: 0;
        transform: translateY(-10px);
      }
    }

    .validation-message.fade-out {
      animation: fadeOut 0.3s ease-out forwards;
    }

    #examValidation {
      display: none;
      color: #dc3545;
      font-size: 14px;
      margin: 0 auto 20px auto;
      text-align: center;
      grid-column: 1 / -1;
      padding: 12px 20px;
      background-color: #f8d7da;
      border: 1px solid #f5c6cb;
      border-radius: 8px;
      width: 100%;
      max-width: 800px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      opacity: 0;
      transform: translateY(-10px);
      transition: opacity 0.3s ease, transform 0.3s ease;
    }

    #examValidation.validation-visible {
      display: block;
      opacity: 1;
      transform: translateY(0);
    }

    .exam-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
      margin-top: 30px;
      flex-grow: 1;
      position: relative;
    }

    .exam-card {
      position: relative;
      overflow: hidden;
      padding: 24px;
      text-align: center;
      border-radius: 12px;
      background: #ffffff;
      border: 1px solid #e5e7eb;
      transition: all 0.3s ease;
    }

    .exam-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 100px;
      background: transparent;
      transition: all 0.3s ease;
      z-index: 1;
    }

    .exam-card:hover::before {
      background: rgba(243, 244, 246, 0.7);
    }

    .exam-card img {
      position: relative;
      z-index: 2;
      margin-bottom: 16px;
      transition: all 0.3s ease;
    }

    .exam-card h3,
    .exam-card p {
      position: relative;
      z-index: 2;
    }

    .exam-card h3 {
      font-size: 1.125rem;
      font-weight: 600;
      color: #111827;
      margin: 0 0 8px 0;
    }

    .exam-card p {
      font-size: 0.875rem;
      color: #6b7280;
      margin: 0;
      line-height: 1.5;
    }
  </style>
</head>
<style>
  #motorista-banner {
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    border-left: 5px solid #4a90e2;
    box-shadow: 0 4px 12px rgba(30, 60, 114, 0.2);
  }

  #motorista-banner i {
    animation: blink 1s infinite;
  }

  @keyframes blink {
    0% {
      opacity: 1;
      transform: scale(1);
    }

    50% {
      opacity: 0.5;
      transform: scale(1.1);
    }

    100% {
      opacity: 1;
      transform: scale(1);
    }
  }

  html,
  body {
    width: 100%;
    margin: 0;
    padding: 0;
  }

  /* Se existir um container pai do conteúdo principal */
  #conteudo,
  .main-wrapper,
  .container-geracao-kit {
    width: 100%;
    max-width: none;
    margin: 0 auto;
    padding: 0;
  }

  .box {
    width: 100%;
    max-width: 100%;
    margin: 0;
    padding: 0 2rem;
    /* ou ajuste conforme necessário */
    box-sizing: border-box;
  }

  .tab-content {
    width: 100%;
    max-width: 100%;
    padding: 0 2rem;
    box-sizing: border-box;
  }

  .exam-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1rem;
    width: 100%;
  }

  .tabs-container {
    width: 100%;
    max-width: 100%;
    padding: 0 2rem;
    box-sizing: border-box;
  }

  .navigation-buttons {
    display: flex;
    justify-content: space-between;
    width: 100%;
    padding: 1rem 2rem;
    box-sizing: border-box;
  }

  html,
  body {
    width: 100%;
    margin: 0;
    padding: 0;
  }

  /* Se existir um container pai do conteúdo principal */
  #conteudo,
  .main-wrapper,
  .container-geracao-kit {
    width: 100%;
    max-width: none;
    margin: 0 auto;
    padding: 0;
  }

  .box {
    width: 100%;
    max-width: 100%;
    margin: 0;
    padding: 0 2rem;
    /* ou ajuste conforme necessário */
    box-sizing: border-box;
  }

  .tab-content {
    width: 100%;
    max-width: 100%;
    padding: 0 2rem;
    box-sizing: border-box;
  }

  .exam-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1rem;
    width: 100%;
  }

  .tabs-container {
    width: 100%;
    max-width: 100%;
    padding: 0 2rem;
    box-sizing: border-box;
  }

  .navigation-buttons {
    display: flex;
    justify-content: space-between;
    width: 100%;
    padding: 1rem 2rem;
    box-sizing: border-box;
  }

  .success-message {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
    padding: 10px;
    margin-top: 15px;
    margin-bottom: 15px;
    border-radius: 4px;
    font-size: 14px;
    display: none;
    /* oculto por padrão */
  }
  </style>
</head>
<style>
  #motorista-banner {
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    border-left: 5px solid #4a90e2;
    box-shadow: 0 4px 12px rgba(30, 60, 114, 0.2);
  }
  
  #motorista-banner i {
    animation: blink 1s infinite;
  }
  
  @keyframes blink {
    0% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(1.1); }
    100% { opacity: 1; transform: scale(1); }
  }
</style>

<body>

  <!-- Mensagem de validação -->
  <div id="validation-message" class="validation-message" style="display: none;">
    <div class="validation-message-content">
      <i class="fas fa-exclamation-circle"></i>
      <span id="validation-text"></span>
      <button class="validation-close" aria-label="Fechar mensagem">
        <i class="fas fa-times"></i>
      </button>
    </div>
  </div>
  
  <div class="tabs-container">
    <div class="tabs">
      <div class="tab active" data-step="0"><i class="fas fa-vial"></i> Exame<div class="step-annotation">(Passo 1)</div></div>
      <div class="tab" data-step="1"><i class="fas fa-tasks"></i> Preenchimento ECP<div class="step-annotation">(Passo 2)</div></div>
      <div class="tab" data-step="2"><i class="fas fa-user-md"></i> Médicos<div class="step-annotation">(Passo 3)</div></div>
      <div class="tab" data-step="3"><i class="fas fa-exclamation-triangle"></i> Riscos<div class="step-annotation">(Passo 4)</div></div>
      <div class="tab" data-step="4"><i class="fas fa-stethoscope"></i> Aptidões e Exames<div class="step-annotation">(Passo 5)</div></div>
      <div class="tab" data-step="5"><i class="fas fa-money-bill-wave"></i> Modelos e Faturas<div class="step-annotation">(Passo 6)</div></div>
    </div>
  </div>

  <div class="tab-content" id="tabContent">
    <div class="step-header">
      <div class="title-icon">
        <img src="./img/svg/simbolo_inicial_colorido.svg" alt="" width="64" height="64">
      </div>
      <div class="step-title">
        <h2>Selecione o tipo de exame</h2>
        <div class="step-subtitle">Escolha o tipo de exame que deseja realizar</div>
      </div>
    </div>
    <div class="exam-grid">
      <div class="validation-error" id="examValidation">
        Por favor, selecione um tipo de exame para continuar
      </div>
      <div class="exam-card" data-exam="admissional">
        <img src="./img/svg/admissional.svg" alt="Admissional" width="60" height="60">
        <h3>Admissional</h3>
        <p>Exame realizado na admissão do funcionário</p>
      </div>
      <div class="exam-card" data-exam="periodico">
        <img src="./img/svg/periodico.svg" alt="Periódico" width="60" height="60">
        <h3>Periódico</h3>
        <p>Avaliação de rotina para acompanhamento</p>
      </div>
      <div class="exam-card" data-exam="demissional">
        <img src="./img/svg/demissional.svg" alt="Demissional" width="60" height="60">
        <h3>Demissional</h3>
        <p>Realizado no desligamento do funcionário</p>
      </div>
      <div class="exam-card" data-exam="retorno">
        <img src="./img/svg/retorno_ao_trabalho.svg" alt="Retorno ao Trabalho" width="60" height="60">
        <h3>Retorno ao Trabalho</h3>
        <p>Para funcionários que retornam de afastamento</p>
      </div>
      <div class="exam-card" data-exam="mudanca">
        <img src="./img/svg/mudanca_risco_funcao.svg" alt="Mudança de Função" width="60" height="60">
        <h3>Mudança de Função</h3>
        <p>Quando há alteração nas atividades do funcionário</p>
      </div>
      <div class="exam-card" data-exam="exame_laudo">
        <img src="./img/svg/exame_laudo.svg" alt="Exame com Laudo" width="60" height="60">
        <h3>Exame com Laudo</h3>
        <p>Exames que requerem análise detalhada</p>
      </div>
    </div>
  </div>

  <div class="navigation-buttons">
    <button class="btn-nav" id="prevBtn"><i class="fas fa-arrow-left"></i> Anterior</button>
    <button class="btn-nav" id="nextBtn">Próximo <i class="fas fa-arrow-right"></i></button>
  </div>

  <script>
    // Inicializa o formatter de moeda global
    window.fatFormatter = new Intl.NumberFormat('pt-BR', {
      style: 'currency',
      currency: 'BRL',
      minimumFractionDigits: 2
    });
    
    // Inicializa as variáveis de totais
    window.fatTotalExames = 0;
    window.fatTotalTreinamentos = 0;
    window.fatTotalEPI = 0;
    
    const tabs = document.querySelectorAll('.tab');
    const content = document.getElementById('tabContent');
    const nextBtn = document.getElementById('nextBtn');
    const prevBtn = document.getElementById('prevBtn');

    // Estado da aplicação
    const appState = {
      currentStep: 0,
      selectedExam: null,
      validation: {
        examSelected: false
      },
      motorista: false
    };

    // Conteúdo do passo 2 (ECP)
    const ecpContent = `
      <div class="ecp-container">
        <div class="step-header">
          <div class="title-icon">
            <i class="fas fa-tasks" style="font-size: 48px; color: #4a90e2;"></i>
          </div>
          <div class="step-title">
            <h2>Preenchimento de Empresas/Clínicas/Pessoas</h2>
            <div class="step-subtitle">Preencha as informações necessárias</div>
          </div>
        </div>

        <!-- EMPRESA - Destaque na primeira linha -->
        <div class="ecp-field ecp-field-empresa">
          <label class="ecp-label">Buscar / Selecionar empresa</label>
          <div class="ecp-input-group">
            <input id="inputEmpresa" type="text" class="ecp-input" placeholder="Digite o nome da empresa..." />
            <button onclick="abrirModal('modalEmpresa')" class="ecp-button-add">+</button>
          </div>
          <div id="resultEmpresa" class="ecp-results"></div>
          <div id="detalhesEmpresa" class="ecp-details"></div>
        </div>

        <div class="ecp-grid">
          <!-- CLÍNICA -->
          <div class="ecp-field">
            <label class="ecp-label">Buscar / Selecionar clínica</label>
            <div class="ecp-input-group">
              <input id="inputClinica" type="text" class="ecp-input" placeholder="Digite para procurar..." />
              <button onclick="abrirModal('modalClinica')" class="ecp-button-add">+</button>
            </div>
            <div id="resultClinica" class="ecp-results"></div>
            <div id="detalhesClinica" class="ecp-details"></div>
          </div>

          <!-- CARGO -->
          <div class="ecp-field">
            <label class="ecp-label">Buscar Cargo / CBO</label>
            <div class="ecp-input-group">
              <input id="inputCargo" type="text" class="ecp-input" placeholder="Digite o cargo..." />
              <button onclick="abrirModal('modalCargo')" class="ecp-button-add">+</button>
            </div>
            <div id="resultCargo" class="ecp-results"></div>
            <div id="detalhesCargo" class="ecp-details"></div>
          </div>

          <!-- COLABORADOR -->
          <div class="ecp-field">
            <label class="ecp-label">Buscar / Selecionar pessoa/colaborador</label>
            <div class="ecp-input-group">
              <input id="inputColaborador" type="text" class="ecp-input" placeholder="Digite o nome ou CPF..." />
              <button onclick="abrirModal('modalColaborador')" class="ecp-button-add">+</button>
            </div>
            <div id="resultColaborador" class="ecp-results"></div>
            <div id="detalhesColaborador" class="ecp-details"></div>
          </div>

          <!-- QUESTIONÁRIO -->
          <div class="ecp-field ecp-questionario">
            <p class="ecp-questionario-title">Questionário para Emissão de Guia para Exame Toxicológico</p>
            <label class="ecp-questionario-label">É motorista?</label>
            <div class="ecp-radio-group">
              <label class="ecp-radio">
                <input type="radio" name="motorista" value="sim">
                <span>Sim <i class="fas fa-truck-moving blink-truck" style="display: none; margin-left: 5px;"></i></span>
              </label>
              <label class="ecp-radio">
                <input type="radio" name="motorista" value="nao">
                <span>Não</span>
              </label>
            </div>
            <p class="ecp-questionario-note">Apenas motorista profissional exceto veículos leves</p>
          </div>
        </div>
      </div>

      <!-- MODAIS -->
      <div id="modalEmpresa" class="ecp-modal">
        <div class="ecp-modal-content">
          <h2>Nova Empresa</h2>
          <input id="novaEmpresaNome" type="text" placeholder="Nome da empresa" class="ecp-modal-input">
          <input id="novaEmpresaEndereco" type="text" placeholder="Endereço" class="ecp-modal-input">
          <input id="novaEmpresaCidade" type="text" placeholder="Cidade" class="ecp-modal-input">
          <input id="novaEmpresaCnpj" type="text" placeholder="CNPJ" class="ecp-modal-input">
          <div class="ecp-modal-buttons">
            <button onclick="fecharModal('modalEmpresa')" class="ecp-button-cancel">Cancelar</button>
            <button onclick="salvarNovaEmpresa()" class="ecp-button-save">Salvar</button>
          </div>
        </div>
      </div>

      <div id="modalClinica" class="ecp-modal">
        <div class="ecp-modal-content">
          <h2>Nova Clínica</h2>
          <input id="novaClinicaNome" type="text" placeholder="Nome da clínica" class="ecp-modal-input">
          <input id="novaClinicaCnpj" type="text" placeholder="CNPJ" class="ecp-modal-input">
          <div class="ecp-modal-buttons">
            <button onclick="fecharModal('modalClinica')" class="ecp-button-cancel">Cancelar</button>
            <button onclick="salvarNovaClinica()" class="ecp-button-save">Salvar</button>
          </div>
        </div>
      </div>

      <div id="modalColaborador" class="ecp-modal">
        <div class="ecp-modal-content">
          <h2>Novo Colaborador</h2>
          <input id="novoColaboradorNome" type="text" placeholder="Nome" class="ecp-modal-input">
          <input id="novoColaboradorCpf" type="text" placeholder="CPF" class="ecp-modal-input">
          <div class="ecp-modal-buttons">
            <button onclick="fecharModal('modalColaborador')" class="ecp-button-cancel">Cancelar</button>
            <button onclick="salvarNovoColaborador()" class="ecp-button-save">Salvar</button>
          </div>
        </div>
      </div>

      <div id="modalCargo" class="ecp-modal">
        <div class="ecp-modal-content">
          <h2>Novo Cargo</h2>
          <div class="ecp-form-group">
            <label for="novoCargoTitulo" class="ecp-label">Título do Cargo</label>
            <input id="novoCargoTitulo" type="text" placeholder="Ex: Motorista de Caminhão" class="ecp-modal-input" required>
          </div>
          <div class="ecp-form-group">
            <label for="novoCargoCBO" class="ecp-label">Código CBO</label>
            <input id="novoCargoCBO" type="text" placeholder="Ex: 7823-10" class="ecp-modal-input" pattern="[0-9]{4}-[0-9]{1,2}" title="Formato: XXXX-XX">
          </div>
          <div class="ecp-form-group">
            <label for="novoCargoDescricao" class="ecp-label">Descrição do Cargo</label>
            <textarea id="novoCargoDescricao" rows="3" class="ecp-modal-input" placeholder="Descreva as principais atividades do cargo"></textarea>
          </div>
          <div class="ecp-modal-buttons">
            <button type="button" onclick="fecharModal('modalCargo')" class="ecp-button-cancel">Cancelar</button>
            <button type="button" onclick="salvarNovoCargo()" class="ecp-button-save">Salvar</button>
          </div>
        </div>
      </div>
    `;

    // Conteúdo do formulário de Profissionais da Medicina
    const profissionaisMedicinaContent = `
      <div class="ecp-container">
        <div class="step-header">
          <div class="title-icon">
            <i class="fas fa-user-md" style="font-size: 48px; color: #4a90e2;"></i>
          </div>
          <div class="step-title">
            <h2>Profissionais da Medicina</h2>
            <div class="step-subtitle">Profissionais Relacionados à clínica <strong>Hospital Samaritano – Alto Araguaia/MT</strong></div>
          </div>
        </div>

        <div class="ecp-grid">
          <!-- Coordenador Responsável -->
          <div class="ecp-field">
            <label class="ecp-label">Coordenador Responsável PCMSO da empresa</label>
            <div class="ecp-input-group">
              <input type="text" id="inputCoordenador" class="ecp-input" placeholder="Digite para procurar..." onkeyup="mostrarListaProfissionais('coordenador')">
              <button class="ecp-button-add" onclick="abrirModalProfissionais('modalCoordenador')">+</button>
            </div>
            <div class="autocomplete-list" id="listaCoordenador"></div>
            <div id="resultadoCoordenador"></div>
          </div>

          <!-- Médico Emitente/Examinador -->
          <div class="ecp-field">
            <label class="ecp-label">Médico Emitente/Examinador da Clínica</label>
            <div class="ecp-input-group">
              <input type="text" id="inputMedico" class="ecp-input" placeholder="Digite para procurar..." onkeyup="mostrarListaProfissionais('medico')">
              <button class="ecp-button-add" onclick="abrirModalProfissionais('modalMedico')">+</button>
            </div>
            <div class="autocomplete-list" id="listaMedico"></div>
            <div id="resultadoMedico"></div>
          </div>
        </div>
      </div>

      <!-- Modal Coordenador -->
      <div id="modalCoordenador" class="ecp-modal">
        <div class="ecp-modal-content">
          <h2>Adicionar Novo Coordenador</h2>
          <input type="text" id="novoCoordenador" class="ecp-modal-input" placeholder="Nome do Coordenador" required>
          <input type="text" id="cpfCoordenador" class="ecp-modal-input" placeholder="CPF" oninput="formatarCPF(this)" maxlength="14">
          <div class="ecp-modal-buttons">
            <button type="button" class="ecp-button-cancel" onclick="fecharModal('modalCoordenador')">Cancelar</button>
            <button type="button" class="ecp-button-save" onclick="confirmarAdicaoProfissional('coordenador')">Salvar</button>
          </div>
        </div>
      </div>

      <!-- Modal Médico -->
      <div id="modalMedico" class="ecp-modal">
        <div class="ecp-modal-content">
          <h2>Adicionar Novo Médico</h2>
          <input type="text" id="novoMedico" class="ecp-modal-input" placeholder="Nome do Médico" required>
          <input type="text" id="cpfMedico" class="ecp-modal-input" placeholder="CPF" oninput="formatarCPF(this)" maxlength="14">
          <input type="text" id="crmMedico" class="ecp-modal-input" placeholder="CRM" maxlength="15">
          <div class="ecp-modal-buttons">
            <button type="button" class="ecp-button-cancel" onclick="fecharModal('modalMedico')">Cancelar</button>
            <button type="button" class="ecp-button-save" onclick="confirmarAdicaoProfissional('medico')">Salvar</button>
          </div>
        </div>
      </div>
    `;

    // Conteúdo do componente de Riscos
    const riscosContent = `
      <div class="ecp-container">
        <!-- Cabeçalho -->
        <div class="step-header">
          <div class="title-icon">
            <i class="fas fa-exclamation-triangle" style="font-size: 48px; color: #4a90e2;"></i>
          </div>
          <div class="step-title">
            <h2>Riscos Ocupacionais relacionados á PGR/PCMSO</h2>
            <div class="step-subtitle">Selecione os riscos ocupacionais do colaborador</div>
          </div>
        </div>

        <!-- Grid de Riscos -->
        <div class="riscos-grid">
          <!-- Conteúdo original do grid de riscos será inserido aqui -->
        </div>

        <div class="riscos-grid" style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 20px;">
          <!-- Coluna 1: Grupos de Riscos -->
          <div class="riscos-column" style="grid-column: 1;">
            <div class="ecp-field">
              <label class="ecp-label">Grupos de Riscos</label>
              <div id="group-select-container" style="max-height: 300px; overflow-y: auto; border: 1px solid #dee2e6; border-radius: 8px; padding: 8px;">
                <label class="group-option">
                  <input type="checkbox" value="ergonomicos" checked>
                  Riscos Ergonômicos
                </label>
                <label class="group-option">
                  <input type="checkbox" value="acidentes-mecanicos">
                  Riscos Acidentes - Mecânicos
                </label>
                <label class="group-option">
                  <input type="checkbox" value="fisicos">
                  Riscos Físicos
                </label>
                <label class="group-option">
                  <input type="checkbox" value="quimicos">
                  Riscos Químicos
                </label>
                <label class="group-option">
                  <input type="checkbox" value="biologicos">
                  Riscos Biológicos
                </label>
                <label class="group-option">
                  <input type="checkbox" value="outros">
                  Outros
                </label>
              </div>
            </div>
          </div>

          <!-- Coluna 2: Busca -->
          <div class="riscos-column" style="grid-column: 2;">
            <div class="ecp-field">
              <label class="ecp-label">Buscar Riscos</label>
              <div style="position: relative;">
                <div class="ecp-input-group" style="margin-bottom: 10px;">
                  <input type="text" class="ecp-input" id="riscos-search-box" placeholder="Digite para buscar riscos..." style="width: 100%;">
                </div>
                <div class="ecp-results" id="riscos-search-results" style="display: none; position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #e2e8f0; border-top: none; border-radius: 0 0 4px 4px; max-height: 300px; overflow-y: auto; z-index: 1000; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">
                  <!-- Resultados da busca aparecerão aqui -->
                </div>
              </div>

            </div>
          </div>

          <!-- Coluna 3: Riscos Selecionados -->
          <div class="riscos-column" style="grid-column: 3;">
            <div class="ecp-field">
              <label class="ecp-label">Riscos Selecionados</label>
              <div id="selected-risks-container" class="riscos-selecionados" style="height: 300px; border: 1px solid #ddd; padding: 10px; border-radius: 4px; background: #f9f9f9; overflow-y: auto;">
                <div class="no-risks" style="color: #666; font-style: italic; text-align: center; padding: 20px 0;">Nenhum risco selecionado</div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Seção de Treinamentos e Capacitação -->
        <div id="secao-treinamentos" style="margin: 30px 0 20px; padding: 20px; background: #f0f7ff; border-radius: 12px; border: 1px solid #cce5ff;">
          <div style="margin-bottom: 20px;">
            <h3 style="margin: 0 0 15px 0; color: #004085; font-size: 18px; display: flex; align-items: center;">
              <i class="fas fa-graduation-cap" style="margin-right: 10px;"></i>
              Treinamentos e Capacitação
            </h3>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 15px;">
              <!-- Lista de Treinamentos -->
              <div>
                <div style="margin-bottom: 10px;">
                  <label style="font-weight: 500; color: #004085;">Treinamentos Disponíveis</label>
                </div>
                
                <div id="listaTreinamentos" style="border: 1px solid #b8daff; border-radius: 6px; background: white; max-height: 300px; overflow-y: auto;">
                  <!-- Treinamentos serão inseridos aqui via JavaScript -->
                </div>
              </div>
              
              <!-- Treinamentos Selecionados -->
              <div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                  <label style="font-weight: 500; color: #004085;">Treinamentos Selecionados</label>
                  <div id="totalTreinamentos" style="font-weight: 600; color: #0056b3;">Total: R$ 0,00</div>
                </div>
                
                <div id="treinamentosSelecionados" style="border: 1px solid #b8daff; border-radius: 6px; background: white; min-height: 100px; max-height: 300px; overflow-y: auto; padding: 10px;">
                  <div style="color: #6c757d; font-style: italic; text-align: center; padding: 20px 0;">
                    Nenhum treinamento selecionado
                  </div>
                </div>
              </div>
            </div>
            
            <div style="text-align: right; margin-top: 10px;">
              <button id="btnAplicarTreinamentos" class="btn" style="background-color: #28a745; color: white; border: none; padding: 8px 16px; border-radius: 4px; font-size: 14px; cursor: pointer; display: inline-flex; align-items: center; gap: 5px;">
                <i class="fas fa-check"></i> Aplicar Seleção
              </button>
            </div>
          </div>
        </div>
        
        <!-- Seção de Laudo Técnico -->
        <div style="margin: 30px 0 20px; padding: 20px; background: #f8f9fa; border-radius: 12px; border: 1px solid #e9ecef;">
          <!-- Cabeçalho -->
          <div style="margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #e9ecef;">
            <div style="display: flex; align-items: center;">
              <i class="fas fa-file-medical" style="font-size: 24px; color: #4a90e2; margin-right: 10px;"></i>
              <div>
                <h3 style="margin: 0 0 4px 0; font-size: 18px; color: #333; font-weight: 600;">Área Técnica / Resumo de Laudo de Segurança do Trabalho</h3>
                <div style="font-size: 13px; color: #6c757d;">RESUMO DE LAUDOS/ LTCAT / LAUDO DE INSALUBRIDADE E PERICULOSIDADE</div>
              </div>
            </div>
          </div>
          
          <!-- Área de resumo -->
          <div id="resumo-laudo" style="display: flex; flex-wrap: wrap; gap: 8px; margin-top: 15px; padding: 10px; background: #fff; border-radius: 6px; border: 1px solid #e9ecef;">
            <!-- Resumo será inserido aqui -->
          </div>
          
          <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 12px; margin-top: 15px; align-items: start;">
            <!-- Dropdown Insalubridade -->
            <div class="laudo-dropdown-wrapper">
              <label>Insalubridade</label>
              <div class="laudo-dropdown">
                <div class="dropdown-selected">
                  <span class="selected-text">Selecione</span>
                  <span class="dropdown-arrow">▼</span>
                </div>
                <div class="dropdown-options">
                  <div class="dropdown-option">Sim</div>
                  <div class="dropdown-option">Não</div>
                </div>
              </div>
            </div>
            
            <!-- Dropdown Porcentagem -->
            <div class="laudo-dropdown-wrapper">
              <label>Porcentagem</label>
              <div class="laudo-dropdown">
                <div class="dropdown-selected">
                  <span class="selected-text">Selecione</span>
                  <span class="dropdown-arrow">▼</span>
                </div>
                <div class="dropdown-options">
                  <div class="dropdown-option">10%</div>
                  <div class="dropdown-option">20%</div>
                  <div class="dropdown-option">40%</div>
                </div>
              </div>
            </div>
            
            <!-- Dropdown Periculosidade -->
            <div class="laudo-dropdown-wrapper">
              <label>Periculosidade 30%</label>
              <div class="laudo-dropdown">
                <div class="dropdown-selected">
                  <span class="selected-text">Selecione</span>
                  <span class="dropdown-arrow">▼</span>
                </div>
                <div class="dropdown-options">
                  <div class="dropdown-option">Sim</div>
                  <div class="dropdown-option">Não</div>
                </div>
              </div>
            </div>
            
            <!-- Dropdown Aposentadoria Especial -->
            <div class="laudo-dropdown-wrapper">
              <label>Aposent. Especial</label>
              <div class="laudo-dropdown">
                <div class="dropdown-selected">
                  <span class="selected-text">Selecione</span>
                  <span class="dropdown-arrow">▼</span>
                </div>
                <div class="dropdown-options">
                  <div class="dropdown-option">Sim</div>
                  <div class="dropdown-option">Não</div>
                </div>
              </div>
            </div>
            
            <!-- Dropdown Agente Nocivo -->
            <div class="laudo-dropdown-wrapper">
              <label>Agente Nocivo</label>
              <div class="laudo-dropdown">
                <div class="dropdown-selected">
                  <span class="selected-text">Selecione</span>
                  <span class="dropdown-arrow">▼</span>
                </div>
                <div class="dropdown-options">
                  <div class="dropdown-option">Sim</div>
                  <div class="dropdown-option">Não</div>
                </div>
              </div>
            </div>
            
            <!-- Dropdown Ocorrência GFIP -->
            <div class="laudo-dropdown-wrapper">
              <label>Ocorrência GFIP</label>
              <div class="laudo-dropdown">
                <div class="dropdown-selected">
                  <span class="selected-text">Selecione</span>
                  <span class="dropdown-arrow">▼</span>
                </div>
                <div class="dropdown-options">
                  <div class="dropdown-option">00</div>
                  <div class="dropdown-option">01</div>
                  <div class="dropdown-option">02</div>
                  <div class="dropdown-option">03</div>
                  <div class="dropdown-option">04</div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

      <!-- Modal para risco personalizado -->
      <div id="custom-risk-modal" class="ecp-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 1000; justify-content: center; align-items: center;">
        <div class="ecp-modal-content" style="background: white; padding: 25px; border-radius: 8px; width: 100%; max-width: 450px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);">
          <h2 style="margin-top: 0; color: #333; font-size: 1.5em; margin-bottom: 20px; font-weight: 500;">Adicionar Risco Personalizado</h2>
          <input type="text" id="custom-risk-name" class="ecp-modal-input" placeholder="Digite o nome do risco" style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; box-sizing: border-box;">
          <div class="ecp-modal-buttons" style="display: flex; justify-content: flex-end; gap: 10px;">
            <button class="ecp-button ecp-button-secondary" id="cancel-custom-risk" style="padding: 8px 16px; background: #f0f0f0; border: 1px solid #ddd; border-radius: 4px; cursor: pointer; font-size: 14px;">Cancelar</button>
            <button class="ecp-button" id="confirm-custom-risk" style="padding: 8px 20px; background: #4a90e2; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px;">Adicionar</button>
          </div>
        </div>
      </div>
    `;


    let etapas = [];

    function updateTab(step) {
      console.log('Atualizando para a aba:', step, 'Conteúdo:', etapas[step] ? 'disponível' : 'indisponível');
      
      // Atualiza a aba ativa
      tabs.forEach((tab, index) => {
        tab.classList.toggle('active', index === step);
      });
      
      // Atualiza o conteúdo da aba
      if (step === 0) {
        // Se for a primeira etapa, usamos o conteúdo original com a grade de exames
        if (etapas[0] && content.innerHTML.trim() !== etapas[0].trim()) {
          content.innerHTML = etapas[0];
        }
        // Configurar os cards de exame
        setTimeout(() => {
          setupExamCards();
          // Restaurar a seleção do exame se existir
          if (appState.selectedExam) {
            const selectedCard = document.querySelector(`.exam-card[data-exam="${appState.selectedExam}"]`);
            if (selectedCard) {
              document.querySelectorAll('.exam-card').forEach(card => card.classList.remove('active'));
              selectedCard.classList.add('active');
            }
          }
        }, 0);
      } else {
        // Para outras etapas, apenas atualizamos o conteúdo
        content.innerHTML = ''; // Limpa o conteúdo primeiro
        
        // Se for a etapa de faturamento, adiciona um observador de mutação
        if (step === 5) {
          console.log('Iniciando observação da aba de faturamento...');
          
          // Função para verificar e atualizar totais
          const checkAndUpdateTotals = () => {
            const totaisContainer = content.querySelector('#fat-totais-container');
            if (totaisContainer) {
              console.log('Container de totais encontrado, atualizando...');
              
              // Pequeno atraso para garantir que o DOM foi completamente renderizado
              setTimeout(() => {
                if (typeof window.fatAtualizarTotais === 'function') {
                  console.log('Chamando fatAtualizarTotais...');
                  try {
                    window.fatAtualizarTotais();
                    
                    // Adiciona um ouvinte para atualizações futuras
                    document.removeEventListener('totaisAtualizados', handleTotaisAtualizados);
                    document.addEventListener('totaisAtualizados', handleTotaisAtualizados);
                  } catch (error) {
                    console.error('Erro ao chamar fatAtualizarTotais:', error);
                  }
                }
              }, 100);
              return true;
            }
            return false;
          };
          
          // Função para lidar com o evento de totais atualizados
          const handleTotaisAtualizados = (event) => {
            console.log('Evento totaisAtualizados recebido:', event.detail);
          };
          
          // Tenta atualizar imediatamente (pode não funcionar se o conteúdo ainda não estiver pronto)
          if (!checkAndUpdateTotals()) {
            // Se não encontrou o container, configura um observador
            console.log('Container de totais ainda não encontrado, configurando MutationObserver...');
            
            const observer = new MutationObserver((mutations, obs) => {
              console.log('Mudanças detectadas no DOM, verificando totais...');
              if (checkAndUpdateTotals()) {
                console.log('Totais atualizados, desconectando observador...');
                obs.disconnect(); // Para de observar após atualizar com sucesso
              }
            });
            
            // Configura o observador
            observer.observe(content, { 
              childList: true, 
              subtree: true,
              attributes: true,
              characterData: true
            });
            
            // Configura um timeout para garantir que o observador não fique rodando para sempre
            setTimeout(() => {
              observer.disconnect();
              console.log('Observador de mutação desconectado após timeout');
              
              // Tenta uma última vez após o timeout
              checkAndUpdateTotals();
            }, 5000); // 5 segundos de timeout
          }
        }
        
        // Define o novo conteúdo
        content.innerHTML = etapas[step];
      }
      
      // Atualiza o estado da aplicação
      appState.currentStep = step;
      
      // Habilita/desabilita botões de navegação e atualiza o texto do botão
      prevBtn.disabled = step === 0;
      
      // Verifica se é a última etapa para alterar o texto e estilo do botão
      const isLastStep = step === tabs.length - 1;
      nextBtn.disabled = false;
      
      if (isLastStep) {
        nextBtn.innerHTML = '<i class="fas fa-save"></i> Salvar Kit';
        nextBtn.classList.add('btn-save-kit');
        nextBtn.classList.remove('btn-nav');
      } else {
        nextBtn.innerHTML = 'Próximo <i class="fas fa-arrow-right"></i>';
        nextBtn.classList.add('btn-nav');
        nextBtn.classList.remove('btn-save-kit');
      }
      
      // Dispara evento de mudança de aba
      const event = new CustomEvent('tabChanged', { detail: { step } });
      document.dispatchEvent(event);
      
      // Se for a aba de faturamento (etapa 5), atualiza os totais
      if (step === 5) {
        console.log('=== Aba de faturamento aberta ===');
        console.log('Conteúdo da etapa:', etapas[step].substring(0, 200) + '...');
        console.log('Função fatAtualizarTotais disponível:', typeof fatAtualizarTotais);
        console.log('Função window.fatAtualizarTotais disponível:', typeof window.fatAtualizarTotais);
        
        // Pequeno atraso para garantir que o DOM foi atualizado
        setTimeout(() => {
          console.log('Verificando elementos do DOM após atraso...');
          console.log('Elemento fat-total-exames:', document.getElementById('fat-total-exames'));
          
          if (typeof window.fatAtualizarTotais === 'function') {
            console.log('Chamando window.fatAtualizarTotais()...');
            try {
              window.fatAtualizarTotais();
            } catch (error) {
              console.error('Erro ao chamar fatAtualizarTotais:', error);
            }
          } else if (typeof fatAtualizarTotais === 'function') {
            console.log('Chamando fatAtualizarTotais()...');
            try {
              fatAtualizarTotais();
            } catch (error) {
              console.error('Erro ao chamar fatAtualizarTotais:', error);
            }
          } else {
            console.warn('Nenhuma versão da função fatAtualizarTotais está disponível');
          }
        }, 100);
      }
      // Configurar eventos de clique nos grupos de risco
      const groupOptions = document.querySelectorAll('#group-select option');
      groupOptions.forEach(option => {
        option.addEventListener('click', function() {
          // Garante que apenas uma opção fique selecionada
          groupOptions.forEach(opt => opt.selected = false);
          this.selected = true;
          document.getElementById('group-select').dispatchEvent(new Event('change'));
          
          // Mostrar/ocultar botão de adicionar risco personalizado
          const customRiskButton = document.getElementById('custom-risk-button-container');
          if (customRiskButton) {
            customRiskButton.style.display = this.value === 'outros' ? 'block' : 'none';
          }
        });
      });
    }

    function setupExamCards() {
      const examCards = document.querySelectorAll('.exam-card');
      examCards.forEach(card => {
        card.addEventListener('click', function() {
          // Remove active class from all cards
          examCards.forEach(c => c.classList.remove('active'));
          // Add active class to clicked card
          this.classList.add('active');
          // Salva o exame selecionado no estado
          appState.selectedExam = this.dataset.exam;
          appState.validation.examSelected = true;
          document.getElementById('examValidation').classList.remove('validation-visible');
          console.log('Selected exam:', appState.selectedExam);
        });
      });
    }

    document.addEventListener('DOMContentLoaded', function() {
      // Configurar os event listeners das abas
      tabs.forEach((tab, index) => {
        tab.addEventListener('click', () => {
          appState.currentStep = index;
          updateTab(appState.currentStep);
          
          // Se for a aba de faturamento (etapa 5), atualiza os totais
          if (index === 5) {
            console.log('Clicou diretamente na aba de faturamento, atualizando totais...');
            // Usa o mesmo mecanismo de atualização da função updateTab
            const content = document.getElementById('tabContent');
            if (content) {
              const checkAndUpdateTotals = () => {
                const totaisContainer = content.querySelector('#fat-totais-container');
                if (totaisContainer && typeof window.fatAtualizarTotais === 'function') {
                  console.log('Atualizando totais após clique na aba...');
                  window.fatAtualizarTotais();
                  return true;
                }
                return false;
              };
              
              // Tenta atualizar imediatamente
              if (!checkAndUpdateTotals()) {
                // Se não encontrou, tenta novamente após um pequeno atraso
                setTimeout(() => checkAndUpdateTotals(), 100);
              }
            }
          }
        });
      });

      // Configurar botões de navegação
      nextBtn.addEventListener('click', () => {
        // Validação apenas na primeira etapa
        if (appState.currentStep === 0) {
          if (!appState.validation.examSelected) {
            document.getElementById('examValidation').classList.add('validation-visible');
            return; // Impede a navegação se não houver exame selecionado
          }
          document.getElementById('examValidation').classList.remove('validation-visible');
        }
        
        // Verifica se é a última etapa
        if (appState.currentStep === tabs.length - 1) {
          // Lógica para salvar o kit
          salvarKit();
        } else {
          // Navega para a próxima etapa
          const nextStep = (appState.currentStep + 1) % etapas.length;
          appState.currentStep = nextStep;
          updateTab(nextStep);
          
          // A atualização dos totais agora é tratada pela função updateTab
          // através do MutationObserver quando a etapa 5 é carregada
        }
      });

      prevBtn.addEventListener('click', () => {
        const prevStep = (appState.currentStep - 1 + etapas.length) % etapas.length;
        appState.currentStep = prevStep;
        updateTab(prevStep);
        
        // A atualização dos totais agora é tratada pela função updateTab
        // através do MutationObserver quando a etapa 5 é carregada
      });

      // Inicializar a primeira aba
      updateTab(appState.currentStep);
      
      // Configurar os cards de exame
      setupExamCards();
      
      // Restaurar a seleção do exame se existir
      if (appState.selectedExam) {
        const selectedCard = document.querySelector(`.exam-card[data-exam="${appState.selectedExam}"]`);
        if (selectedCard) {
          selectedCard.click();
        }
      }
    });
    // Funções do ECP
    const ecpData = {
      empresas: [
        { 
          id: 1, 
          nome: 'Empresa A', 
          cnpj: '00.000.000/0001-00',
          endereco: 'Rua das Flores, 123',
          complemento: 'Sala 42',
          bairro: 'Centro',
          cidade: 'São Paulo',
          estado: 'SP',
          cep: '01001-000',
          ativo: true,
          quantidadeVidas: 150,
          quantidadeClinicas: 5
        },
        { 
          id: 2, 
          nome: 'Empresa B', 
          cnpj: '00.000.000/0001-01',
          endereco: 'Av. Paulista, 1000',
          complemento: '10º andar',
          bairro: 'Bela Vista',
          cidade: 'São Paulo',
          estado: 'SP',
          cep: '01310-100',
          ativo: true,
          quantidadeVidas: 320,
          quantidadeClinicas: 8
        },
      ],
      clinicas: [
        { nome: "Clínica Vida", cnpj: "45.987.654/0001-01" }
      ],
      colaboradores: [
        { nome: "João da Silva", cpf: "123.456.789-00", cargo: "Analista de Segurança" },
        { nome: "Maria Oliveira", cpf: "987.654.321-00", cargo: "Técnico de Segurança" },
        { nome: "Carlos Eduardo", cpf: "456.123.789-11", cargo: "Engenheiro de Segurança" },
        { nome: "Ana Paula Santos", cpf: "789.123.456-22", cargo: "Enfermeira do Trabalho" },
        { nome: "Roberto Almeida", cpf: "321.654.987-33", cargo: "Técnico em Enfermagem" },
        { nome: "Fernanda Lima", cpf: "654.987.321-44", cargo: "Médica do Trabalho" },
        { nome: "Ricardo Pereira", cpf: "159.753.486-55", cargo: "Técnico em Segurança" }
      ],
      cargos: [
        { titulo: "Motorista de Caminhão", cbo: "7823-10", descricao: "Conduz caminhão para transporte de cargas, realizando operações de carga e descarga, manutenção preventiva e cumprindo normas de trânsito e segurança." },
        { titulo: "Auxiliar de Enfermagem", cbo: "3222-40", descricao: "Realiza atividades de assistência de enfermagem, como curativos, administração de medicamentos e acompanhamento do estado de saúde dos pacientes." },
        { titulo: "Técnico em Segurança do Trabalho", cbo: "3516-10", descricao: "Fiscaliza o cumprimento das normas de segurança, realiza inspeções, treinamentos e elabora relatórios de segurança no trabalho." },
        { titulo: "Eletricista de Manutenção", cbo: "7411-10", descricao: "Executa manutenção corretiva e preventiva em instalações elétricas, seguindo normas técnicas e de segurança." },
        { titulo: "Auxiliar Administrativo", cbo: "4110-10", descricao: "Auxilia nos serviços de escritório, como atendimento, arquivamento, organização de documentos e apoio às atividades administrativas." }
      ]
    };

    // Função para remover acentos e converter para minúsculas
    function removerAcentos(str) {
      if (!str) return '';
      return str.toString().normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase();
    }

    function removerAcentos(str) {
  if (!str) return '';
  return str.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase();
}

function buscarECP(tipo, inputId, resultadoId, chave) {
      try {
        // Obtém os elementos do DOM
        const inputElement = document.getElementById(inputId);
        const resultEl = document.getElementById(resultadoId);
        
        // Verifica se os elementos existem
        if (!inputElement || !resultEl) return;
        
        // Obtém e limpa o valor da busca
        const valor = inputElement.value.trim();
        
        // Se o campo estiver vazio, esconde os resultados
        if (!valor) {
          resultEl.style.display = 'none';
          return;
        }
        
        // Prepara os valores para busca
        const valorBusca = removerAcentos(valor).toLowerCase();
        const valorNumerico = valor.replace(/[^\d]/g, '');
        
        // Verifica se o tipo de busca é válido
        if (!ecpData || !ecpData[tipo]) {
          console.error('Tipo de busca inválido ou dados não carregados:', tipo);
          return;
        }
        
        console.log('Buscando', tipo, 'com termo:', valor, '| Valor normalizado:', valorBusca);
        
        // Filtra os itens baseado no tipo de busca
        let resultados = [];
        
        if (tipo === 'colaboradores') {
          // Busca em colaboradores (nome ou CPF)
          resultados = ecpData[tipo].filter(item => {
            if (!item) return false;
            
            try {
              // Verifica se o item e o nome existem
              if (!item || typeof item.nome !== 'string') {
                console.log('Item inválido ou sem nome:', item);
                return false;
              }
              
              // Busca por nome (insensível a acentos e case)
              const nome = removerAcentos(item.nome).toLowerCase();
              
              // Verifica se o nome contém o termo de busca
              // Considera tanto o início do nome quanto palavras inteiras
              const nomeMatch = nome.includes(valorBusca) || 
                              nome.split(' ').some(palavra => palavra.startsWith(valorBusca));
              
              // Busca por CPF (busca parcial)
              const cpf = (item.cpf || '').replace(/[^\d]/g, '');
              const cpfMatch = valorNumerico && cpf.includes(valorNumerico);
              
              // Debug
              console.log('Item:', item.nome, '| Nome normalizado:', nome, '| Termo busca:', valorBusca, '| Match:', nomeMatch, '| CPF:', cpf, '| CPF Match:', cpfMatch);
              
              // Retorna true se encontrar pelo nome ou CPF
              return nomeMatch || cpfMatch;
            } catch (error) {
              console.error('Erro ao processar item:', item, error);
              return false;
            }
          });
        } else {
          // Busca em outros tipos (usando a chave fornecida)
          resultados = ecpData[tipo].filter(item => {
            if (!item || !item[chave]) return false;
            const valorChave = removerAcentos(item[chave].toString()).toLowerCase();
            return valorChave.includes(valorBusca);
          });
        }
        
        console.log('Resultados encontrados para', tipo + ':', resultados.length);
        
        // Exibe os resultados
        if (resultados.length > 0) {
          resultEl.innerHTML = resultados.map(item => {
            // Formata o texto de exibição
            let displayText = '';
            
            if (item.cbo) {
              displayText = `${item[chave]} (CBO: ${item.cbo})`;
            } else if (item.cpf) {
              displayText = `${item.nome || ''} (${item.cpf || ''})`;
            } else {
              displayText = item[chave] || '';
            }
            
            // Cria o HTML para cada item do resultado
            const itemData = JSON.stringify(item).replace(/"/g, '&quot;');
            return `<div onclick="selecionarECP('${inputId}', '${resultadoId}', '${itemData}', '${chave}')" 
              class="ecp-result-item" title="${item.descricao || ''}">
              ${displayText}
            </div>`;
          }).join('');
          
          // Exibe os resultados
          resultEl.style.display = 'block';
        } else {
          // Se não encontrar resultados, exibe mensagem
          resultEl.innerHTML = '<div class="ecp-result-item">Nenhum resultado encontrado</div>';
          resultEl.style.display = 'block';
        }
      } catch (error) {
        // Em caso de erro, exibe no console e mensagem para o usuário
        console.error('Erro na busca ECP:', error);
        const resultEl = document.getElementById(resultadoId);
        if (resultEl) {
          resultEl.innerHTML = '<div class="ecp-result-item">Erro ao realizar a busca</div>';
          resultEl.style.display = 'block';
        }
      }
    }

    function selecionarECP(inputId, resultadoId, item, chave) {
      // Se o item for uma string, faz o parse do JSON
      const itemObj = typeof item === 'string' ? JSON.parse(item) : item;
      
      // Atualiza o valor do input
      const inputElement = document.getElementById(inputId);
      if (inputElement) {
        inputElement.value = itemObj[chave] || '';
      }
      
      // Esconde os resultados
      const resultElement = document.getElementById(resultadoId);
      if (resultElement) {
        resultElement.style.display = 'none';
      }
      
      // Atualiza os detalhes da empresa
      if (inputId === 'inputEmpresa') {
        const detalhes = document.getElementById('detalhesEmpresa');
        if (itemObj.nome || itemObj.cnpj) {
          detalhes.className = 'ecp-details';
          detalhes.style.display = 'block';
          detalhes.innerHTML = `
            <div class="ecp-empresa-dados">
              <div><strong>${itemObj.nome || ''}</strong></div>
              <div>${itemObj.cnpj || ''}</div>
              ${itemObj.endereco ? `<div>${itemObj.endereco}${itemObj.complemento ? ', ' + itemObj.complemento : ''}</div>` : ''}
              ${itemObj.bairro ? `<div>${itemObj.bairro}</div>` : ''}
              ${itemObj.cidade ? `<div>${itemObj.cidade}${itemObj.estado ? '/' + itemObj.estado : ''} ${itemObj.cep || ''}</div>` : ''}
            </div>
            <div class="ecp-empresa-metadados">
              <div class="ecp-info-item">
                <i class="fas ${itemObj.ativo ? 'fa-check-circle' : 'fa-times-circle'}"></i>
                <span class="ecp-status ${itemObj.ativo ? 'ativo' : 'inativo'}">
                  ${itemObj.ativo ? 'Ativa' : 'Inativa'}
                </span>
              </div>
              <div class="ecp-info-item">
                <i class="fas fa-users"></i>
                <span>${itemObj.quantidadeVidas || 0} vidas</span>
              </div>
              <div class="ecp-info-item">
                <i class="fas fa-clinic-medical"></i>
                <span>${itemObj.quantidadeClinicas || 0} clínicas</span>
              </div>
            </div>
          `;
        } else {
          detalhes.style.display = 'none';
        }
      }
      
      // Atualiza os detalhes da clínica
      if (inputId === 'inputClinica') {
        const detalhes = document.getElementById('detalhesClinica');
        if (itemObj.nome || itemObj.cnpj) {
          detalhes.className = 'ecp-details';
          detalhes.style.display = 'block';
          detalhes.innerHTML = `
            <strong>${itemObj.nome || ''}</strong>
            <div>${itemObj.cnpj || ''}</div>
          `;
        } else {
          detalhes.style.display = 'none';
        }
      }
      
      // Atualiza os detalhes do colaborador
      if (inputId === 'inputColaborador') {
        const detalhes = document.getElementById('detalhesColaborador');
        if (itemObj.nome || itemObj.cpf) {
          detalhes.className = 'ecp-details';
          detalhes.style.display = 'block';
          
          // Mostrar detalhes básicos do colaborador
          let html = `
            <div style="background: white; padding: 1rem; border-radius: 0.5rem; border: 1px solid #f3f4f6; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);">
              <div style="display: flex; align-items: center; margin-bottom: 0.75rem;">
                <div style="width: 3rem; height: 3rem; border-radius: 9999px; background-color: #dbeafe; display: flex; align-items: center; justify-content: center; margin-right: 0.75rem; flex-shrink: 0;">
                  <i class="fas fa-user" style="color: #2563eb; font-size: 1.25rem;"></i>
                </div>
                <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0; line-height: 1.2;">
                  ${itemObj.nome || 'Nome não informado'}
                </h3>
              </div>
              <div style="margin-left: 3.75rem;">
                <div style="display: flex; align-items: center; margin-bottom: 0.25rem; font-size: 0.875rem; color: #6b7280;">
                  <i class="far fa-id-card" style="margin-right: 0.375rem; color: #9ca3af; width: 1rem; text-align: center;"></i>
                  <span>${itemObj.cpf ? itemObj.cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4') : 'CPF não informado'}</span>
                </div>
                ${itemObj.cargo ? `
                <div style="display: flex; align-items: center; font-size: 0.875rem; color: #6b7280;">
                  <i class="fas fa-briefcase" style="margin-right: 0.375rem; color: #9ca3af; width: 1rem; text-align: center;"></i>
                  <span>${itemObj.cargo}</span>
                </div>
                ` : ''}
              </div>
            </div>
          `;
          
          // Adicionar seção de Kits relacionados
          const cpf = itemObj.cpf ? itemObj.cpf.replace(/[^\d]/g, '') : '';
          const kitsDoColaborador = kitsColaboradores[cpf] || [];
          
          html += `
            <div style="margin-top: 1.5rem; border-top: 1px solid #f3f4f6; padding-top: 1.25rem;">
              <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <h4 style="font-size: 1rem; font-weight: 500; color: #111827; margin: 0; display: flex; align-items: center;">
                  <i class="fas fa-box-open" style="color: #3b82f6; margin-right: 0.5rem; font-size: 1.1rem;"></i>
                  Kits do Colaborador
                </h4>
                <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.625rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; background-color: #dbeafe; color: #1e40af;">
                  ${kitsDoColaborador.length} ${kitsDoColaborador.length === 1 ? 'kit' : 'kits'} encontrados
                </span>
              </div>
          `;
          
          if (kitsDoColaborador.length > 0) {
            // Ordena os kits por data (mais recente primeiro)
            const kitsOrdenados = [...kitsDoColaborador].sort((a, b) => 
              new Date(b.data.split('/').reverse().join('-')) - new Date(a.data.split('/').reverse().join('-'))
            );
            
            // Pega os 5 primeiros kits
            const kitsParaExibir = kitsOrdenados.slice(0, 5);
            
            html += `
              <div style="display: grid; gap: 0.75rem;">
                ${kitsParaExibir.map(kit => {
                  const statusConfig = {
                    'Concluído': { bg: '#dcfce7', text: '#166534', icon: 'fa-check-circle' },
                    'Pendente': { bg: '#fef3c7', text: '#92400e', icon: 'fa-clock' },
                    'default': { bg: '#fee2e2', text: '#991b1b', icon: 'fa-times-circle' }
                  };
                  
                  const status = kit.status || 'Pendente';
                  const config = statusConfig[status] || statusConfig.default;
                  
                  return `
                    <div style="background: white; padding: 1rem; border: 1px solid #e5e7eb; border-radius: 0.5rem; 
                                cursor: pointer; transition: all 0.2s ease;"
                         onclick="abrirDetalhesKit(${JSON.stringify(kit).replace(/"/g, '&quot;')}, '${itemObj.nome ? itemObj.nome.replace(/'/g, "\\'") : 'Colaborador'}')">
                      <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <div style="flex: 1; min-width: 0;">
                          <div style="display: flex; align-items: center; margin-bottom: 0.25rem;">
                            <span style="font-weight: 500; color: #111827; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-right: 0.5rem;">
                              ${kit.id}
                            </span>
                            <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.5rem; border-radius: 0.25rem; 
                                      font-size: 0.75rem; font-weight: 500; background-color: ${config.bg}; color: ${config.text};">
                              <i class="fas ${config.icon} mr-1"></i>
                              ${status}
                            </span>
                          </div>
                          <div style="font-size: 0.875rem; color: #4b5563; margin-bottom: 0.25rem;">
                            <span style="font-weight: 500;">${kit.empresa || 'Sem empresa'}</span>
                            ${kit.cargo ? `<span style="margin: 0 0.25rem; color: #d1d5db;">•</span><span>${kit.cargo}</span>` : ''}
                          </div>
                        </div>
                        <div style="display: flex; align-items: center; margin-left: 0.5rem; color: #9ca3af; font-size: 0.875rem; white-space: nowrap;">
                          <i class="far fa-calendar-alt mr-1"></i>
                          ${kit.data}
                        </div>
                      </div>
                    </div>
                  `;
                }).join('')}
              </div>
            `;
            
            if (kitsDoColaborador.length > 5) {
              html += `
                <div style="margin-top: 1rem; text-align: center;">
                  <button style="background: none; border: none; color: #3b82f6; font-size: 0.875rem; 
                               cursor: pointer; display: inline-flex; align-items: center;"
                          onclick="this.parentElement.previousElementSibling.querySelectorAll('div').forEach(el => el.style.display = 'block'); this.remove()">
                    <i class="fas fa-chevron-down mr-1"></i>
                    Mostrar mais ${kitsDoColaborador.length - 5} kits
                  </button>
                </div>
              `;
            }
          } else {
            html += `
              <div style="text-align: center; padding: 1.5rem 1rem; background-color: #f9fafb; 
                           border-radius: 0.5rem; border: 1px dashed #e5e7eb; margin-top: 0.5rem;">
                <i class="fas fa-inbox" style="font-size: 1.5rem; color: #9ca3af;"></i>
                <p style="font-size: 0.875rem; color: #6b7280; margin-top: 0.5rem; margin-bottom: 0;">
                  Nenhum kit encontrado para este colaborador
                </p>
              </div>
            `;
          }
          
          html += `</div>`; // Fecha a div de Kits do Colaborador
          
          detalhes.innerHTML = html;
        } else {
          detalhes.style.display = 'none';
        }
      }
      
      // Atualiza os detalhes do cargo
      if (inputId === 'inputCargo') {
        const detalhes = document.getElementById('detalhesCargo');
        if (detalhes) {
          if (itemObj.titulo || itemObj.cbo) {
            detalhes.className = 'ecp-details';
            detalhes.style.display = 'block';
            detalhes.innerHTML = `
              <div style="background: white; padding: 1rem; border-radius: 0.5rem; border: 1px solid #e5e7eb; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem;">
                  <h3 style="font-size: 1rem; font-weight: 600; color: #111827; margin: 0; line-height: 1.2;">
                    ${itemObj.titulo || 'Cargo não especificado'}
                  </h3>
                  ${itemObj.cbo ? `
                    <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.5rem; border-radius: 0.25rem; 
                              font-size: 0.75rem; font-weight: 500; background-color: #e0f2fe; color: #0369a1;">
                      CBO: ${itemObj.cbo}
                    </span>
                  ` : ''}
                </div>
                ${itemObj.descricao ? `
                  <div style="font-size: 0.875rem; color: #4b5563; line-height: 1.5; margin-top: 0.75rem; padding-top: 0.75rem; border-top: 1px solid #f3f4f6;">
                    <h4 style="font-size: 0.875rem; font-weight: 600; color: #374151; margin: 0 0 0.5rem 0;">Descrição:</h4>
                    <p style="margin: 0;">${itemObj.descricao}</p>
                  </div>
                ` : ''}
              </div>
            `;
          } else {
            detalhes.style.display = 'none';
          }
        }
      }
      
      // Limpa os campos dependentes quando necessário
      if (inputId === 'inputEmpresa') {
        limparCampos(['inputClinica', 'inputColaborador']);
        // Limpa o cargo apenas se não houver valor selecionado
        const cargoInput = document.getElementById('inputCargo');
        if (cargoInput && !cargoInput.value) {
          limparCampos(['inputCargo']);
        }
      } else if (inputId === 'inputClinica') {
        limparCampos(['inputColaborador']);
        // Limpa o cargo apenas se não houver valor selecionado
        const cargoInput = document.getElementById('inputCargo');
        if (cargoInput && !cargoInput.value) {
          limparCampos(['inputCargo']);
        }
      } else if (inputId === 'inputColaborador') {
        // Não limpa mais o cargo automaticamente
        // O cargo pode ser selecionado independentemente do colaborador
      }
    }

    function abrirModal(id) {
      const modal = document.getElementById(id);
      if (modal) {
        modal.style.display = 'flex';
      }
    }
    
    function abrirDetalhesKit(kit, nomeColaborador) {
      // Configurações de status
      const statusConfig = {
        'Concluído': { bg: '#dcfce7', text: '#166534', icon: 'fa-check-circle' },
        'Pendente': { bg: '#fef3c7', text: '#92400e', icon: 'fa-clock' },
        'default': { bg: '#fee2e2', text: '#991b1b', icon: 'fa-times-circle' }
      };
      const status = kit.status || 'Pendente';
      const statusInfo = statusConfig[status] || statusConfig.default;
      
      // Criar o modal
      const modal = document.createElement('div');
      modal.id = 'modalDetalhesKit';
      modal.style.cssText = `
        display: flex;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
        z-index: 1000;
        opacity: 0;
        transition: opacity 0.2s ease-in-out;
      `;
      
      // Conteúdo do modal
      modal.innerHTML = `
        <div style="
          background: white;
          border-radius: 12px;
          width: 90%;
          max-width: 520px;
          max-height: 90vh;
          overflow-y: auto;
          box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
          position: relative;
        ">
          <!-- Cabeçalho do Modal -->
          <div style="
            padding: 18px 24px;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            justify-content: space-between;
            align-items: center;
          ">
            <h3 style="
              font-size: 1.25rem;
              font-weight: 600;
              color: #111827;
              margin: 0;
              display: flex;
              align-items: center;
              gap: 10px;
            ">
              <i class="fas fa-box-open" style="color: #3b82f6;"></i>
              Detalhes do Kit
            </h3>
            <button onclick="fecharModal('modalDetalhesKit')" style="
              background: none;
              border: none;
              font-size: 1.5rem;
              cursor: pointer;
              color: #9ca3af;
              line-height: 1;
              padding: 4px;
              border-radius: 4px;
              transition: all 0.2s;
            " onmouseover="this.style.color='#6b7280'; this.style.backgroundColor='#f3f4f6'" 
              onmouseout="this.style.color='#9ca3af'; this.style.backgroundColor='transparent'"
              aria-label="Fechar">
              &times;
            </button>
          </div>
          
          <!-- Corpo do Modal -->
          <div style="padding: 24px;">
            <!-- Cabeçalho com ID e Status -->
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px;">
              <div>
                <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 4px;">Código</div>
                <div style="font-size: 1.25rem; font-weight: 600; color: #111827;">${kit.id}</div>
              </div>
              <div style="text-align: right;">
                <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 4px;">Status</div>
                <div style="
                  display: inline-flex;
                  align-items: center;
                  padding: 0.35rem 0.75rem;
                  border-radius: 6px;
                  font-size: 0.8125rem;
                  font-weight: 500;
                  background-color: ${statusInfo.bg};
                  color: ${statusInfo.text};
                ">
                  <i class="fas ${statusInfo.icon} mr-1.5"></i>
                  ${status}
                </div>
              </div>
            </div>
            
            <!-- Informações do Colaborador -->
            <div style="background: #f9fafb; border-radius: 8px; padding: 16px; margin-bottom: 20px;">
              <div style="display: flex; align-items: center; margin-bottom: 12px;">
                <div style="
                  width: 40px;
                  height: 40px;
                  border-radius: 8px;
                  background: #e0e7ff;
                  display: flex;
                  align-items: center;
                  justify-content: center;
                  margin-right: 12px;
                  flex-shrink: 0;
                ">
                  <i class="fas fa-user" style="color: #4f46e5; font-size: 1.1rem;"></i>
                </div>
                <div>
                  <div style="font-weight: 600; color: #111827; margin-bottom: 2px;">${nomeColaborador || 'Nome não informado'}</div>
                  <div style="font-size: 0.8125rem; color: #6b7280;">
                    ${kit.cargo || 'Cargo não informado'}
                  </div>
                </div>
              </div>
              <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 12px;">
                <div>
                  <div style="font-size: 0.75rem; color: #6b7280; margin-bottom: 4px;">Empresa</div>
                  <div style="font-size: 0.9375rem; color: #111827;">${kit.empresa || 'Não informada'}</div>
                </div>
                <div>
                  <div style="font-size: 0.75rem; color: #6b7280; margin-bottom: 4px;">Data</div>
                  <div style="font-size: 0.9375rem; color: #111827;">${kit.data || 'Não informada'}</div>
                </div>
              </div>
            </div>
            
            <!-- Seção de Ações Rápidas -->
            <div style="margin-top: 24px;">
              <h4 style="font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 12px; display: flex; align-items: center;">
                <i class="fas fa-bolt mr-2" style="color: #f59e0b;"></i>
                Ações Rápidas
              </h4>
              <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px;">
                <button onclick="duplicarKit('${kit.id}')" style="
                  display: flex;
                  flex-direction: column;
                  align-items: center;
                  justify-content: center;
                  padding: 12px 8px;
                  background: white;
                  border: 1px solid #e5e7eb;
                  border-radius: 8px;
                  cursor: pointer;
                  transition: all 0.2s;
                " onmouseover="this.style.borderColor='#bfdbfe'; this.style.boxShadow='0 1px 3px 0 rgba(0, 0, 0, 0.05)'"
                  onmouseout="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                  <i class="far fa-copy" style="font-size: 1.25rem; color: #3b82f6; margin-bottom: 6px;"></i>
                  <span style="font-size: 0.75rem; font-weight: 500; color: #4b5563;">Duplicar</span>
                </button>
                <button onclick="editarKit('${kit.id}')" style="
                  display: flex;
                  flex-direction: column;
                  align-items: center;
                  justify-content: center;
                  padding: 12px 8px;
                  background: white;
                  border: 1px solid #e5e7eb;
                  border-radius: 8px;
                  cursor: pointer;
                  transition: all 0.2s;
                " onmouseover="this.style.borderColor='#bfdbfe'; this.style.boxShadow='0 1px 3px 0 rgba(0, 0, 0, 0.05)'"
                  onmouseout="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                  <i class="far fa-edit" style="font-size: 1.25rem; color: #3b82f6; margin-bottom: 6px;"></i>
                  <span style="font-size: 0.75rem; font-weight: 500; color: #4b5563;">Editar</span>
                </button>
                <button onclick="visualizarKit('${kit.id}')" style="
                  display: flex;
                  flex-direction: column;
                  align-items: center;
                  justify-content: center;
                  padding: 12px 8px;
                  background: white;
                  border: 1px solid #e5e7eb;
                  border-radius: 8px;
                  cursor: pointer;
                  transition: all 0.2s;
                " onmouseover="this.style.borderColor='#bfdbfe'; this.style.boxShadow='0 1px 3px 0 rgba(0, 0, 0, 0.05)'"
                  onmouseout="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                  <i class="far fa-eye" style="font-size: 1.25rem; color: #10b981; margin-bottom: 6px;"></i>
                  <span style="font-size: 0.75rem; font-weight: 500; color: #4b5563;">Visualizar</span>
                </button>
              </div>
            </div>
          </div>
          
          <!-- Rodapé do Modal -->
          <div style="
            padding: 16px 24px;
            border-top: 1px solid #f3f4f6;
            display: flex;
            justify-content: flex-end;
            gap: 12px;
          ">
            <button onclick="fecharModal('modalDetalhesKit')" style="
              padding: 0.5rem 1rem;
              background: white;
              border: 1px solid #e5e7eb;
              border-radius: 6px;
              font-size: 0.875rem;
              font-weight: 500;
              color: #4b5563;
              cursor: pointer;
              transition: all 0.2s;
            " onmouseover="this.style.backgroundColor='#f9fafb'" 
              onmouseout="this.style.backgroundColor='white'">
              Fechar
            </button>
            <button onclick="visualizarKit('${kit.id}')" style="
              padding: 0.5rem 1rem;
              background: #3b82f6;
              border: 1px solid #3b82f6;
              border-radius: 6px;
              font-size: 0.875rem;
              font-weight: 500;
              color: white;
              cursor: pointer;
              transition: all 0.2s;
              display: flex;
              align-items: center;
              gap: 6px;
            " onmouseover="this.style.backgroundColor='#2563eb'; this.style.borderColor='#2563eb'" 
              onmouseout="this.style.backgroundColor='#3b82f6'; this.style.borderColor='#3b82f6'">
              <i class="far fa-eye"></i>
              Visualizar KIT Completo
            </button>
          </div>
        </div>
      `;
      
      // Adicionar o modal ao body
      document.body.appendChild(modal);
      
      // Adicionar animação de fade-in
      setTimeout(() => {
        modal.style.opacity = '1';
      }, 10);
      
      // Desabilitar scroll do body quando o modal estiver aberto
      document.body.style.overflow = 'hidden';
      
      // Salvar referência ao último elemento focado para retornar o foco ao fechar
      window.lastFocusedElement = document.activeElement;
    }
    
    function editarKit(kitId) {
      // Implementar lógica de edição
      alert(`Editando kit ${kitId}...`);
      fecharModal('modalDetalhesKit');
    }
    
    function visualizarKit(kitId) {
      try {
        // Implementar lógica de visualização
        showToast(`Visualizando kit ${kitId}...`, 'success');
      } catch (error) {
        showToast(`Erro ao visualizar kit ${kitId}: ${error.message}`, 'error');
      } finally {
        fecharModal('modalDetalhesKit');
      }
    }

    function fecharModal(modalId) {
      const modal = document.getElementById(modalId);
      if (modal) {
        // Add fade out animation
        modal.style.opacity = '0';
        modal.style.pointerEvents = 'none';
        
        // Remove modal after animation
        setTimeout(() => {
          if (modal && modal.parentNode) {
            document.body.removeChild(modal);
            
            // Re-enable body scroll
            document.body.style.overflow = '';
            
            // Focus management - return focus to the element that opened the modal if it exists
            const lastFocusedElement = document.activeElement;
            if (lastFocusedElement && lastFocusedElement !== document.body) {
              lastFocusedElement.focus();
            }
          }
        }, 300);
      }
      
      // Return focus to the element that opened the modal
      if (window.lastFocusedElement) {
        window.lastFocusedElement.focus();
      }
    }

    // Helper function to show toast messages
    function showToast(message, type = 'success') {
      const toast = document.createElement('div');
      const typeClasses = {
        success: 'bg-green-500',
        error: 'bg-red-500',
        warning: 'bg-yellow-500',
        info: 'bg-blue-500'
      };
      
      toast.className = `fixed bottom-4 right-4 text-white px-4 py-2 rounded-md shadow-lg transform transition-all duration-300 translate-y-2 opacity-0 ${typeClasses[type] || typeClasses.success}`;
      toast.setAttribute('role', 'alert');
      toast.setAttribute('aria-live', 'polite');
      toast.textContent = message;
      
      document.body.appendChild(toast);
      
      // Trigger reflow to apply initial styles
      void toast.offsetWidth;
      
      // Animate in
      toast.classList.remove('translate-y-2', 'opacity-0');
      toast.classList.add('translate-y-0', 'opacity-100');
      
      // Remove after delay
      setTimeout(() => {
        toast.classList.remove('translate-y-0', 'opacity-100');
        toast.classList.add('translate-y-2', 'opacity-0');
        
        // Remove from DOM after animation
        setTimeout(() => {
          if (toast.parentNode) {
            document.body.removeChild(toast);
          }
        }, 300);
      }, 3000);
    }

    function limparCampos(ids) {
      ids.forEach(id => {
        const element = document.getElementById(id);
        if (element) {
          element.value = '';
          // Não limpa a div de resultados se for o campo de cargo
          if (id !== 'inputCargo') {
            const detalhes = document.getElementById(`detalhes${id.charAt(0).toUpperCase() + id.slice(1)}`);
            if (detalhes) detalhes.innerHTML = '';
          } else {
            // Para o campo de cargo, apenas esconde os resultados
            const resultCargo = document.getElementById('resultCargo');
            if (resultCargo) resultCargo.style.display = 'none';
          }
        }
      });
    }

    function limparCampos(ids) {
      ids.forEach(id => {
        const element = document.getElementById(id);
        if (element) {
          element.value = '';
          // Não limpa a div de resultados se for o campo de cargo
          if (id !== 'inputCargo') {
            const detalhes = document.getElementById(`detalhes${id.charAt(0).toUpperCase() + id.slice(1)}`);
            if (detalhes) detalhes.innerHTML = '';
          } else {
            // Para o campo de cargo, apenas esconde os resultados
            const resultCargo = document.getElementById('resultCargo');
            if (resultCargo) resultCargo.style.display = 'none';
          }
        }
      });
    }

    function salvarNovaEmpresa() {
      const nova = {
        nome: document.getElementById('novaEmpresaNome').value,
        endereco: document.getElementById('novaEmpresaEndereco').value,
        cidade: document.getElementById('novaEmpresaCidade').value,
        cnpj: document.getElementById('novaEmpresaCnpj').value
      };
      
      ecpData.empresas.push(nova);
      fecharModal('modalEmpresa');
      limparCampos(['novaEmpresaNome', 'novaEmpresaEndereco', 'novaEmpresaCidade', 'novaEmpresaCnpj']);
      
      // Atualiza o input e exibe os detalhes da nova empresa
      document.getElementById('inputEmpresa').value = nova.nome;
      document.getElementById('detalhesEmpresa').innerHTML = `
        <strong>Empresa:</strong> ${nova.nome}<br>
        <strong>Endereço:</strong> ${nova.endereco}<br>
        <strong>Cidade:</strong> ${nova.cidade}<br>
        <strong>CNPJ:</strong> ${nova.cnpj}`;
    }

    function salvarNovaClinica() {
      const nova = {
        nome: document.getElementById('novaClinicaNome').value,
        cnpj: document.getElementById('novaClinicaCnpj').value
      };
      
      ecpData.clinicas.push(nova);
      fecharModal('modalClinica');
      limparCampos(['novaClinicaNome', 'novaClinicaCnpj']);
      
      document.getElementById('inputClinica').value = nova.nome;
      document.getElementById('detalhesClinica').innerHTML = `
        <strong>Clínica:</strong> ${nova.nome}<br>
        <strong>CNPJ:</strong> ${nova.cnpj}`;
    }

    function salvarNovoColaborador() {
      const novo = {
        nome: document.getElementById('novoColaboradorNome').value,
        cpf: document.getElementById('novoColaboradorCpf').value
      };
      
      ecpData.colaboradores.push(novo);
      fecharModal('modalColaborador');
      limparCampos(['novoColaboradorNome', 'novoColaboradorCpf']);
      
      document.getElementById('inputColaborador').value = novo.nome;
      document.getElementById('detalhesColaborador').innerHTML = `
        <strong>Nome:</strong> ${novo.nome}<br>
        <strong>CPF:</strong> ${novo.cpf}`;
    }

    function salvarNovoCargo() {
      const titulo = document.getElementById('novoCargoTitulo').value.trim();
      const cbo = document.getElementById('novoCargoCBO').value.trim();
      const descricao = document.getElementById('novoCargoDescricao').value.trim();
      
      if (!titulo) {
        alert('Por favor, preencha o título do cargo');
        return;
      }
      
      const novo = { 
        titulo: titulo,
        cbo: cbo,
        descricao: descricao
      };
      
      ecpData.cargos.push(novo);
      fecharModal('modalCargo');
      limparCampos(['novoCargoTitulo', 'novoCargoCBO', 'novoCargoDescricao']);
      
      // Atualiza o input e mostra os detalhes
      const inputCargo = document.getElementById('inputCargo');
      if (inputCargo) {
        inputCargo.value = titulo;
        const detalhes = document.getElementById('detalhesCargo');
        if (detalhes) {
          detalhes.innerHTML = `
            <div class="font-medium">${titulo}</div>
            ${cbo ? `<div class="text-sm text-gray-500">CBO: ${cbo}</div>` : ''}
            ${descricao ? `<div class="mt-2 text-sm">${descricao}</div>` : ''}
          `;
        }
      }
    }

    // Dados dos Kits relacionados aos colaboradores
    const kitsColaboradores = {
      '12345678900': [
        { id: 'KIT001', data: '15/10/2023', empresa: 'Indústria ABC Ltda', cargo: 'Analista de Segurança', status: 'Concluído' },
        { id: 'KIT002', data: '20/09/2023', empresa: 'Indústria ABC Ltda', cargo: 'Analista de Segurança', status: 'Pendente' },
        { id: 'KIT003', data: '10/08/2023', empresa: 'Comércio XYZ S/A', cargo: 'Técnico de Segurança', status: 'Concluído' },
        { id: 'KIT010', data: '05/07/2023', empresa: 'Indústria ABC Ltda', cargo: 'Analista de Segurança', status: 'Concluído' },
        { id: 'KIT011', data: '22/06/2023', empresa: 'Serviços Gama', cargo: 'Analista de Segurança', status: 'Cancelado' }
      ],
      '98765432100': [
        { id: 'KIT004', data: '05/11/2023', empresa: 'Construtora Delta', cargo: 'Engenheiro de Segurança', status: 'Concluído' },
        { id: 'KIT005', data: '28/10/2023', empresa: 'Construtora Delta', cargo: 'Engenheiro de Segurança', status: 'Cancelado' },
        { id: 'KIT012', data: '15/09/2023', empresa: 'Indústria ABC Ltda', cargo: 'Engenheiro de Segurança', status: 'Concluído' }
      ],
      '45612378911': [
        { id: 'KIT006', data: '12/11/2023', empresa: 'Tecnologia Inova', cargo: 'Engenheiro de Segurança', status: 'Concluído' },
        { id: 'KIT007', data: '30/10/2023', empresa: 'Tecnologia Inova', cargo: 'Engenheiro de Segurança', status: 'Concluído' },
        { id: 'KIT013', data: '18/09/2023', empresa: 'Comércio XYZ S/A', cargo: 'Engenheiro de Segurança', status: 'Pendente' },
        { id: 'KIT014', data: '05/08/2023', empresa: 'Tecnologia Inova', cargo: 'Engenheiro de Segurança', status: 'Concluído' }
      ],
      '78912345622': [
        { id: 'KIT008', data: '08/11/2023', empresa: 'Saúde Total', cargo: 'Enfermeira do Trabalho', status: 'Concluído' },
        { id: 'KIT015', data: '22/10/2023', empresa: 'Saúde Total', cargo: 'Enfermeira do Trabalho', status: 'Concluído' },
        { id: 'KIT016', data: '14/09/2023', empresa: 'Clínica Vida', cargo: 'Enfermeira do Trabalho', status: 'Concluído' }
      ],
      '32165498733': [
        { id: 'KIT009', data: '03/11/2023', empresa: 'Hospital Esperança', cargo: 'Técnico em Enfermagem', status: 'Pendente' },
        { id: 'KIT017', data: '19/10/2023', empresa: 'Hospital Esperança', cargo: 'Técnico em Enfermagem', status: 'Concluído' },
        { id: 'KIT018', data: '07/09/2023', empresa: 'Clínica Saúde', cargo: 'Técnico em Enfermagem', status: 'Concluído' }
      ]
    };

    // Dados dos Profissionais de Medicina
    const profissionaisMedicinaData = {
      coordenadores: [
        { nome: "Carlos Almeida Silva", cpf: "665.985.754-98" }
      ],
      medicos: [
        { nome: "Marcia Candida", cpf: "558.587.887-98" },
        { nome: "João Martins", cpf: "789.456.123-77", assinatura: "./assinatura_valida.png" }
      ]
    };

    const tipoMapeado = {
      coordenador: "coordenadores",
      medico: "medicos"
    };

    // Funções para o formulário de Profissionais de Medicina
    function mostrarListaProfissionais(tipo) {
      const inputElement = document.getElementById(`input${capitalize(tipo)}`);
      const input = inputElement.value.toLowerCase();
      const lista = profissionaisMedicinaData[tipoMapeado[tipo]];
      const container = document.getElementById(`lista${capitalize(tipo)}`);
      
      if (input.trim() === '') {
        container.style.display = 'none';
        return;
      }
      
      container.style.display = 'block';
      container.innerHTML = '';

      lista.filter(p => p.nome.toLowerCase().includes(input)).forEach(p => {
        const div = document.createElement('div');
        div.className = 'ecp-result-item';
        div.innerHTML = `
          <div class="font-medium">${p.nome}</div>
          <div class="text-sm text-gray-500">CPF: ${p.cpf}</div>
        `;
        div.onclick = () => {
          renderizarPessoa(tipo, p, document.getElementById(`resultado${capitalize(tipo)}`));
          container.style.display = 'none';
          inputElement.value = '';
        };
        container.appendChild(div);
      });
    }

    function abrirModalProfissionais(id) {
      document.getElementById(id).style.display = 'flex';
    }

    function formatarCPF(input) {
      let value = input.value.replace(/\D/g, '');
      if (value.length > 11) value = value.substring(0, 11);
      
      if (value.length > 9) {
        value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
      } else if (value.length > 6) {
        value = value.replace(/(\d{3})(\d{3})(\d{1,3})/, '$1.$2.$3');
      } else if (value.length > 3) {
        value = value.replace(/(\d{3})(\d{1,2})/, '$1.$2');
      }
      
      input.value = value;
    }

    function confirmarAdicaoProfissional(tipo) {
      const nomeInput = document.getElementById(`novo${capitalize(tipo)}`);
      const cpfInput = document.getElementById(`cpf${capitalize(tipo)}`);
      const crmInput = tipo === 'medico' ? document.getElementById('crmMedico') : null;
      
      const nome = nomeInput.value.trim();
      let cpf = cpfInput.value.replace(/\D/g, '');
      const crm = crmInput ? crmInput.value.trim() : '';
      
      if (!nome || cpf.length !== 11) {
        alert('Por favor, preencha todos os campos corretamente.');
        return;
      }
      
      const novo = { 
        nome, 
        cpf: cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4'),
        ...(tipo === 'medico' && crm && { crm })
      };
      
      profissionaisMedicinaData[tipoMapeado[tipo]].push(novo);
      renderizarPessoa(tipo, novo, document.getElementById(`resultado${capitalize(tipo)}`));
      fecharModal(`modal${capitalize(tipo)}`);
      
      // Limpar campos
      nomeInput.value = '';
      cpfInput.value = '';
      if (crmInput) crmInput.value = '';
    }

    function renderizarPessoa(tipo, pessoa, area) {
      area.className = 'ecp-details';
      area.style.display = 'block';
      area.innerHTML = `
        <div class="font-medium">${pessoa.nome}</div>
        <div class="text-sm text-gray-500">CPF: ${pessoa.cpf}${pessoa.crm ? ` | CRM: ${pessoa.crm}` : ''}</div>
        ${tipo === 'medico' ? renderAssinatura(pessoa) : ''}
        <button class="ecp-button-cancel mt-2" type="button" onclick="removerPessoa('${area.id}')">✖ Remover</button>
      `;
    }

    function renderAssinatura(pessoa) {
      if (pessoa.assinatura) {
        return `
          <div class="mt-2">
            <img src="${pessoa.assinatura}" alt="Assinatura" style="max-width: 200px; max-height: 100px; border: 1px solid #ddd; border-radius: 4px;">
          </div>
        `;
      }
      return `
        <div class="mt-2">
          <label class="ecp-label">Enviar Assinatura</label>
          <input 
            type="file" 
            id="assinatura-${pessoa.cpf}" 
            class="ecp-input" 
            accept="image/*" 
            onchange="handleAssinaturaUpload(this, '${pessoa.cpf}')"
          >
          <div class="ecp-questionario-note">Formatos aceitos: JPG, PNG, GIF. Tamanho máximo: 2MB</div>
        </div>
      `;
    }
    
    function handleAssinaturaUpload(input, cpf) {
      const file = input.files[0];
      if (!file) return;
      
      // Validar o tipo do arquivo
      const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
      if (!validTypes.includes(file.type)) {
        alert('Por favor, selecione um arquivo de imagem válido (JPG, PNG ou GIF)');
        input.value = '';
        return;
      }
      
      // Validar o tamanho do arquivo (2MB)
      if (file.size > 2 * 1024 * 1024) {
        alert('O arquivo é muito grande. O tamanho máximo permitido é 2MB.');
        input.value = '';
        return;
      }
      
      // Criar uma URL para visualização da imagem
      const reader = new FileReader();
      reader.onload = function(e) {
        // Encontrar o médico correspondente e atualizar a assinatura
        const medico = profissionaisMedicinaData.medicos.find(m => m.cpf === cpf);
        if (medico) {
          // Em um ambiente real, aqui você faria o upload do arquivo para o servidor
          // e salvaria o caminho/URL da imagem
          medico.assinatura = e.target.result; // URL temporária para visualização
          
          // Atualizar a exibição
          const resultadoMedico = document.getElementById('resultadoMedico');
          if (resultadoMedico) {
            renderizarPessoa('medico', medico, resultadoMedico);
          }
        }
      };
      reader.readAsDataURL(file);
    }

    function removerPessoa(id) {
      document.getElementById(id).innerHTML = '';
    }

    function capitalize(str) {
      return str.charAt(0).toUpperCase() + str.slice(1);
    }

    // Função para configurar os eventos dos campos de busca do ECP
    const setupECPEvents = () => {
      // Remove os event listeners antigos para evitar duplicação
      const inputs = [
        'inputEmpresa', 'inputClinica', 'inputColaborador', 'inputCargo',
        'inputCoordenador', 'inputMedico' // Adiciona os novos campos
      ];
      
      inputs.forEach(id => {
        const input = document.getElementById(id);
        if (input) {
          // Clona o elemento para remover todos os event listeners antigos
          const newInput = input.cloneNode(true);
          input.parentNode.replaceChild(newInput, input);
        }
      });

      // Configura os eventos para os campos do ECP
      const empresaInput = document.getElementById('inputEmpresa');
      const clinicaInput = document.getElementById('inputClinica');
      const colaboradorInput = document.getElementById('inputColaborador');
      const cargoInput = document.getElementById('inputCargo');
      const coordenadorInput = document.getElementById('inputCoordenador');
      const medicoInput = document.getElementById('inputMedico');

      if (empresaInput) {
        empresaInput.addEventListener('input', () => buscarECP('empresas', 'inputEmpresa', 'resultEmpresa', 'nome'));
      }
      if (clinicaInput) {
        clinicaInput.addEventListener('input', () => buscarECP('clinicas', 'inputClinica', 'resultClinica', 'nome'));
      }
      if (colaboradorInput) {
        colaboradorInput.addEventListener('input', () => buscarECP('colaboradores', 'inputColaborador', 'resultColaborador', 'nome'));
      }
      if (cargoInput) {
        cargoInput.addEventListener('input', () => buscarECP('cargos', 'inputCargo', 'resultCargo', 'titulo'));
      }
      if (coordenadorInput) {
        coordenadorInput.addEventListener('input', () => mostrarListaProfissionais('coordenador'));
      }
      if (medicoInput) {
        medicoInput.addEventListener('input', () => mostrarListaProfissionais('medico'));
      }
    };

    // Função para inicializar os dropdowns do laudo
    function initializeLaudoDropdowns() {
      // Remove event listeners antigos para evitar duplicação
      const dropdowns = document.querySelectorAll('.laudo-dropdown');
      
      dropdowns.forEach(dropdown => {
        // Cria um novo dropdown para substituir o antigo (evita duplicação de eventos)
        const newDropdown = dropdown.cloneNode(true);
        dropdown.parentNode.replaceChild(newDropdown, dropdown);
        
        const options = newDropdown.querySelectorAll('.dropdown-option');
        const selected = newDropdown.querySelector('.dropdown-selected');
        
        // Adiciona evento de clique para abrir/fechar o dropdown
        newDropdown.addEventListener('click', (e) => {
          e.stopPropagation();
          closeAllDropdowns(newDropdown);
          newDropdown.classList.toggle('active');
        });

        // Adiciona evento de clique para as opções
        options.forEach(option => {
          option.addEventListener('click', (e) => {
            e.stopPropagation();
            const value = option.textContent.trim();
            const selectedText = newDropdown.querySelector('.selected-text');
            
            if (selectedText) {
              selectedText.textContent = value;
            } else {
              const newSelected = document.createElement('span');
              newSelected.className = 'selected-text';
              newSelected.textContent = value;
              selected.innerHTML = '';
              selected.appendChild(newSelected);
              
              const arrow = document.createElement('span');
              arrow.className = 'dropdown-arrow';
              arrow.innerHTML = '▼';
              selected.appendChild(arrow);
            }
            
            newDropdown.classList.remove('active');
            
            // Dispara evento de mudança
            const event = new Event('change');
            newDropdown.dispatchEvent(event);
            
            // Atualiza o resumo
            atualizarResumoLaudo();
          });
        });
      });
      
      // Fecha dropdowns ao clicar fora
      document.addEventListener('click', function(e) {
        if (!e.target.closest('.laudo-dropdown')) {
          closeAllDropdowns();
        }
      });
      
      // Função auxiliar para fechar todos os dropdowns exceto o atual
      function closeAllDropdowns(currentDropdown = null) {
        document.querySelectorAll('.laudo-dropdown').forEach(dropdown => {
          if (dropdown !== currentDropdown) {
            dropdown.classList.remove('active');
          }
        });
      }
      
      // Atualiza o resumo inicial
      atualizarResumoLaudo();
    }

    // Função para verificar se a aba de riscos está visível e inicializar componentes
    function checkAndInitializeRiscosTab() {
      const riscosTab = document.querySelector('.tab[data-step="3"]');
      if (riscosTab && riscosTab.classList.contains('active')) {
        // Pequeno atraso para garantir que o conteúdo foi renderizado
        setTimeout(initializeLaudoDropdowns, 100);
        
        // Inicializa os treinamentos se ainda não foram inicializados
        if (!window.treinamentosInicializados) {
          const initTreinamentos = () => {
            // Verifica se o container de treinamentos está no DOM
            const containerTreinamentos = document.getElementById('secao-treinamentos');
            if (!containerTreinamentos) {
              console.log('Aguardando container de treinamentos ser carregado...');
              setTimeout(initTreinamentos, 100);
              return;
            }
            
            try {
              const treinamentos = gerenciarTreinamentos();
              if (treinamentos && typeof treinamentos.init === 'function') {
                treinamentos.init();
                window.treinamentosInicializados = true;
                console.log('Treinamentos inicializados com sucesso');
              }
            } catch (error) {
              console.error('Erro ao inicializar treinamentos:', error);
              // Tenta novamente após um atraso em caso de erro
              setTimeout(initTreinamentos, 200);
            }
          };
          
          // Inicia o processo de inicialização
          setTimeout(initTreinamentos, 200);
        }
      }
    }
    
    // Função para inicializar o componente de Aptidões e Exames
    function initializeAptidoesExames() {
      console.log('Inicializando componente de Aptidões e Exames...');
      
      // Dados de exemplo para aptidões
      const aptidoes = [
        { codigo: 'APT001', nome: 'Aptidão Cardíaca' },
        { codigo: 'APT002', nome: 'Aptidão Auditiva' },
        { codigo: 'APT003', nome: 'Aptidão Visual' },
        { codigo: 'APT004', nome: 'Aptidão Respiratória' },
        { codigo: 'APT005', nome: 'Aptidão Esforço Físico' }
      ];
      
      // Dados de exemplo para exames
      const exames = [
        { codigo: 'EX001', nome: 'Eletrocardiograma' },
        { codigo: 'EX002', nome: 'Audiometria' },
        { codigo: 'EX003', nome: 'Avaliação Psicossocial' },
        { codigo: 'EX004', nome: 'Espirometria' },
        { codigo: 'EX005', nome: 'Exame de Sangue' }
      ];
      
      // Preenche o select de aptidões
      const selectAptidao = document.getElementById('apt-selectAptidao');
      if (selectAptidao) {
        selectAptidao.innerHTML = '<option value="">Selecione uma aptidão</option>';
        aptidoes.forEach(apt => {
          const option = document.createElement('option');
          option.value = apt.codigo;
          option.textContent = `${apt.codigo} - ${apt.nome}`;
          selectAptidao.appendChild(option);
        });
      }
      
      // Preenche o select de exames
      const selectExame = document.getElementById('apt-selectExame');
      if (selectExame) {
        selectExame.innerHTML = '<option value="">Selecione um exame</option>';
        exames.forEach(ex => {
          const option = document.createElement('option');
          option.value = ex.codigo;
          option.textContent = `${ex.codigo} - ${ex.nome}`;
          selectExame.appendChild(option);
        });
      }
      
      // Adiciona evento ao botão de adicionar aptidão
      const btnAddAptidao = document.getElementById('apt-btnAddAptidao');
      if (btnAddAptidao) {
        btnAddAptidao.onclick = function() {
          const select = document.getElementById('apt-selectAptidao');
          const selectedOption = select.options[select.selectedIndex];
          
          if (selectedOption.value) {
            adicionarItemNaLista('apt-listaAptidoes', selectedOption.text, selectedOption.value);
            select.selectedIndex = 0; // Volta para a opção padrão
          }
        };
      }
      
      // Adiciona evento ao botão de adicionar exame
      const btnAddExame = document.getElementById('apt-btnAddExame');
      if (btnAddExame) {
        btnAddExame.onclick = function() {
          const select = document.getElementById('apt-selectExame');
          const selectedOption = select.options[select.selectedIndex];
          
          if (selectedOption.value) {
            adicionarItemNaLista('apt-listaExames', selectedOption.text, selectedOption.value);
            select.selectedIndex = 0; // Volta para a opção padrão
          }
        };
      }
      
      // Adiciona evento ao botão de adicionar item personalizado
      const btnAddPersonalizado = document.getElementById('apt-btnAddPersonalizado');
      if (btnAddPersonalizado) {
        btnAddPersonalizado.onclick = function() {
          const tipo = this.getAttribute('data-tipo');
          abrirModalItemPersonalizado(tipo);
        };
      }
      
      // Adiciona eventos ao modal
      const modal = document.getElementById('apt-modal');
      const btnSalvar = document.getElementById('apt-btnSalvar');
      const btnCancelar = document.getElementById('apt-btnCancelar');
      
      if (btnSalvar) {
        btnSalvar.onclick = function() {
          const codigo = document.getElementById('apt-novoCodigo').value.trim();
          const nome = document.getElementById('apt-novoNome').value.trim();
          const tipo = this.getAttribute('data-tipo');
          
          if (codigo && nome) {
            const listaId = tipo === 'aptidao' ? 'apt-listaAptidoes' : 'apt-listaExames';
            adicionarItemNaLista(listaId, `${codigo} - ${nome}`, codigo);
            fecharModalItemPersonalizado();
          } else {
            alert('Por favor, preencha todos os campos.');
          }
        };
      }
      
      if (btnCancelar) {
        btnCancelar.onclick = fecharModalItemPersonalizado;
      }
      
      // Fecha o modal ao clicar fora dele
      if (modal) {
        modal.onclick = function(e) {
          if (e.target === modal) {
            fecharModalItemPersonalizado();
          }
        };
      }
    }
    
    // Função auxiliar para adicionar item na lista
    function adicionarItemNaLista(listaId, texto, valor) {
      const lista = document.getElementById(listaId);
      if (!lista) return;
      
      // Verifica se o item já existe na lista
      const itensExistentes = lista.querySelectorAll('.apt-item');
      for (let item of itensExistentes) {
        if (item.getAttribute('data-valor') === valor) {
          alert('Este item já foi adicionado à lista.');
          return;
        }
      }
      
      // Cria o novo item
      const item = document.createElement('div');
      item.className = 'apt-item';
      item.setAttribute('data-valor', valor);
      item.innerHTML = `
        <span>${texto}</span>
        <button type="button" class="apt-btn-remover">
          <i class="fas fa-times"></i>
        </button>
      `;
      
      // Adiciona evento de remoção
      const btnRemover = item.querySelector('.apt-btn-remover');
      if (btnRemover) {
        btnRemover.onclick = function() {
          item.remove();
        };
      }
      
      lista.appendChild(item);
    }
    
    // Função para abrir o modal de item personalizado
    function abrirModalItemPersonalizado(tipo) {
      const modal = document.getElementById('apt-modal');
      const titulo = document.getElementById('apt-modalTitle');
      const btnSalvar = document.getElementById('apt-btnSalvar');
      
      if (modal && titulo && btnSalvar) {
        titulo.textContent = `Adicionar ${tipo === 'aptidao' ? 'Aptidão' : 'Exame'} Personalizado`;
        btnSalvar.setAttribute('data-tipo', tipo);
        
        // Limpa os campos
        document.getElementById('apt-novoCodigo').value = '';
        document.getElementById('apt-novoNome').value = '';
        
        // Exibe o modal
        modal.style.display = 'flex';
      }
    }
    
    // Função para fechar o modal de item personalizado
    function fecharModalItemPersonalizado() {
      const modal = document.getElementById('apt-modal');
      if (modal) {
        modal.style.display = 'none';
      }
    }
    
    // Função para verificar se a aba de aptidões e exames está visível e inicializar componentes
    function checkAndInitializeAptidoesTab() {
      const aptidoesTab = document.querySelector('.tab[data-step="4"]');
      if (aptidoesTab && aptidoesTab.classList.contains('active')) {
        // Pequeno atraso para garantir que o conteúdo foi renderizado
        setTimeout(initializeAptidoesExames, 100);
      }
    }

    // Função para atualizar o resumo do laudo
    function atualizarResumoLaudo() {
      const resumoContainer = document.getElementById('resumo-laudo');
      if (!resumoContainer) return;
      
      // Obtém todos os dropdowns do laudo
      const dropdowns = document.querySelectorAll('.laudo-dropdown');
      const itensSelecionados = [];
      
      // Mapeia os itens selecionados
      dropdowns.forEach(dropdown => {
        const selectedText = dropdown.querySelector('.selected-text');
        const label = dropdown.closest('.laudo-dropdown-wrapper').querySelector('label').textContent;
        
        // Adiciona ao array apenas se não for a seleção padrão
        if (selectedText && selectedText.textContent !== 'Selecione') {
          itensSelecionados.push({
            label: label,
            value: selectedText.textContent.trim()
          });
        }
      });
      
      // Limpa o resumo atual
      resumoContainer.innerHTML = '';
      
      // Adiciona os itens selecionados ao resumo
      itensSelecionados.forEach(item => {
        if (item.value) {
          // Cria o elemento do item do resumo
          const itemElement = document.createElement('div');
          itemElement.className = 'resumo-item';
          
          // Adiciona o label
          const labelSpan = document.createElement('span');
          labelSpan.className = 'label';
          labelSpan.textContent = item.label + ':';
          
          // Adiciona o valor
          const valueSpan = document.createElement('span');
          valueSpan.className = 'value';
          valueSpan.textContent = item.value;
          
          // Monta a estrutura
          itemElement.appendChild(labelSpan);
          itemElement.appendChild(valueSpan);
          
          // Adiciona ao container
          resumoContainer.appendChild(itemElement);
        }
      });
    }
    
    // Função para salvar o kit
    function salvarKit() {
      // Desabilita o botão para evitar múltiplos cliques
      const saveButton = document.getElementById('nextBtn');
      const originalButtonHTML = saveButton.innerHTML;
      
      // Adiciona classe de carregamento e desabilita o botão
      saveButton.disabled = true;
      saveButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Salvando...';
      saveButton.style.opacity = '0.8';
      
      // Aqui você pode adicionar a lógica para validar os campos obrigatórios
      // antes de enviar o formulário
      if (!validarFormularioCompleto()) {
        // Restaura o botão
        saveButton.disabled = false;
        saveButton.innerHTML = originalButtonHTML;
        saveButton.style.opacity = '1';
        
        Swal.fire({
          icon: 'warning',
          title: 'Atenção',
          text: 'Por favor, preencha todos os campos obrigatórios antes de salvar.',
          confirmButtonColor: '#4a90e2'
        });
        return;
      }
      
      // Mostrar loading com mais detalhes
      Swal.fire({
        title: 'Salvando Kit',
        html: `
          <div style="text-align: center;">
            <div class="loading-spinner" style="font-size: 48px; margin-bottom: 20px; color: #4a90e2;">
              <i class="fas fa-spinner fa-spin"></i>
            </div>
            <p style="margin-bottom: 5px; font-weight: 500;">Estamos processando suas informações</p>
            <p style="color: #6c757d; font-size: 0.9em;">Isso pode levar alguns segundos...</p>
          </div>
        `,
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => {
          Swal.showLoading();
        }
      });
      
      // Simulando uma requisição assíncrona
      setTimeout(() => {
        // Aqui você pode adicionar a lógica para enviar os dados para o servidor
        // Exemplo:
        // const formData = new FormData();
        // formData.append('tipoExame', appState.selectedExam);
        // ... adicione outros campos do formulário
        
        // fetch('/api/salvar-kit', {
        //   method: 'POST',
        //   body: formData
        // })
        // .then(response => response.json())
        // .then(data => {
        //   // Em caso de sucesso
        //   mostrarSucessoSalvamento();
        // })
        // .catch(error => {
        //   console.error('Erro ao salvar o kit:', error);
        //   // Em caso de erro
        //   mostrarErroSalvamento();
        // })
        // .finally(() => {
        //   // Restaura o botão em ambos os casos
        //   restaurarBotaoSalvar();
        // });
        
        // Simulando sucesso (remova esta parte quando implementar a chamada real)
        mostrarSucessoSalvamento();
        restaurarBotaoSalvar();
      }, 1500);
      
      // Função para mostrar mensagem de sucesso
      function mostrarSucessoSalvamento() {
        Swal.fire({
          icon: 'success',
          title: '<span style="color: #28a745">Sucesso!</span>',
          html: `
            <div style="text-align: center;">
              <div style="font-size: 60px; color: #28a745; margin-bottom: 15px;">
                <i class="fas fa-check-circle"></i>
              </div>
              <h3 style="color: #28a745; margin-bottom: 10px;">Kit salvo com sucesso!</h3>
              <p style="color: #6c757d;">Seus dados foram armazenados com segurança.</p>
            </div>
          `,
          showConfirmButton: true,
          confirmButtonText: 'Continuar',
          confirmButtonColor: '#28a745',
          allowOutsideClick: false
        }).then((result) => {
          if (result.isConfirmed) {
            // Redirecionar para a página inicial ou fazer outra ação após salvar
            // window.location.href = '/inicio';
          }
        });
      }
      
      // Função para mostrar mensagem de erro
      function mostrarErroSalvamento() {
        Swal.fire({
          icon: 'error',
          title: '<span style="color: #dc3545">Erro ao salvar</span>',
          html: `
            <div style="text-align: center;">
              <div style="font-size: 60px; color: #dc3545; margin-bottom: 15px;">
                <i class="fas fa-exclamation-circle"></i>
              </div>
              <h3 style="color: #dc3545; margin-bottom: 10px;">Ocorreu um erro</h3>
              <p style="color: #6c757d; margin-bottom: 0;">Não foi possível salvar o kit no momento.</p>
              <p style="color: #6c757d;">Por favor, tente novamente mais tarde.</p>
            </div>
          `,
          showConfirmButton: true,
          confirmButtonText: 'Entendi',
          confirmButtonColor: '#dc3545',
          allowOutsideClick: false
        });
      }
      
      // Função para restaurar o botão de salvar
      function restaurarBotaoSalvar() {
        const saveButton = document.getElementById('nextBtn');
        if (saveButton) {
          saveButton.disabled = false;
          saveButton.innerHTML = '<i class="fas fa-save"></i> Salvar Kit';
          saveButton.style.opacity = '1';
        }
      }
    }
    
    // Função para validar todos os campos obrigatórios do formulário
    function validarFormularioCompleto() {
      // Validação do tipo de exame
      if (!appState.selectedExam) {
        mostrarErroValidacao('Por favor, selecione um tipo de exame.');
        return false;
      }
      
      // Validação dos campos da empresa (etapa 1)
      if (appState.currentStep >= 1) {
        const empresaSelecionada = document.getElementById('detalhesEmpresa')?.innerHTML?.trim();
        if (!empresaSelecionada) {
          mostrarErroValidacao('Por favor, selecione uma empresa.');
          return false;
        }
        
        const clinicaSelecionada = document.getElementById('detalhesClinica')?.innerHTML?.trim();
        if (!clinicaSelecionada) {
          mostrarErroValidacao('Por favor, selecione uma clínica.');
          return false;
        }
      }
      
      // Validação dos profissionais de medicina (etapa 2)
      if (appState.currentStep >= 2) {
        const profissionais = document.querySelectorAll('.profissional-selecionado');
        if (profissionais.length === 0) {
          mostrarErroValidacao('Por favor, adicione pelo menos um profissional de medicina.');
          return false;
        }
      }
      
      // Validação dos riscos ocupacionais (etapa 3)
      if (appState.currentStep >= 3) {
        const riscosSelecionados = document.querySelectorAll('.risco-selecionado');
        if (riscosSelecionados.length === 0) {
          mostrarErroValidacao('Por favor, adicione pelo menos um risco ocupacional.');
          return false;
        }
      }
      
      // Validação dos documentos selecionados (etapa 5)
      if (appState.currentStep >= 5) {
        const documentosSelecionados = document.querySelectorAll('.sm-checkbox:checked');
        if (documentosSelecionados.length === 0) {
          mostrarErroValidacao('Por favor, selecione pelo menos um documento para gerar.');
          return false;
        }
      }
      
      return true;
    }
    
    // Função para lidar com o evento de tecla
    function handleKeyDown(e) {
      if (e.key === 'Escape') {
        fecharMensagemValidacao();
      }
    }
    
    // Função para fechar a mensagem de validação
    function fecharMensagemValidacao() {
      const validationElement = document.getElementById('validation-message');
      if (validationElement) {
        // Adiciona a classe de fade out e aguarda a animação terminar
        validationElement.classList.add('fade-out');
        
        // Remove o elemento após a animação terminar
        setTimeout(() => {
          validationElement.style.display = 'none';
          validationElement.classList.remove('fade-out');
          
          // Remove o ouvinte de teclado quando a mensagem for fechada
          document.removeEventListener('keydown', handleKeyDown);
        }, 300);
        
        clearTimeout(window.validationTimeout);
      }
    }
    
    // Função para exibir mensagem de erro de validação
    function mostrarErroValidacao(mensagem) {
      // Rola a página para o topo para garantir que a mensagem seja visível
      window.scrollTo({ top: 0, behavior: 'smooth' });
      
      // Encontra os elementos da mensagem de validação
      const validationElement = document.getElementById('validation-message');
      const validationText = document.getElementById('validation-text');
      const closeButton = document.querySelector('.validation-close');
      
      // Rola até a mensagem de validação específica se for a primeira etapa
      if (appState.currentStep === 0) {
        const examValidation = document.getElementById('examValidation');
        if (examValidation) {
          examValidation.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
      }
      
      if (validationElement && validationText) {
        // Adiciona o ouvinte de evento de tecla
        document.addEventListener('keydown', handleKeyDown);
        // Atualiza o texto da mensagem
        validationText.textContent = mensagem;
        
        // Exibe a mensagem com animação
        validationElement.style.display = 'block';
        
        // Remove a mensagem após 10 segundos
        clearTimeout(window.validationTimeout);
        window.validationTimeout = setTimeout(fecharMensagemValidacao, 10000);
        
        // Remove eventos anteriores para evitar duplicação
        validationElement.removeEventListener('click', fecharMensagemValidacao);
        if (closeButton) {
          closeButton.removeEventListener('click', fecharMensagemValidacao);
        }
        
        // Adiciona evento de clique para fechar a mensagem
        if (closeButton) {
          closeButton.addEventListener('click', function(e) {
            e.stopPropagation(); // Evita que o clique no botão dispare o evento do container
            fecharMensagemValidacao();
          });
        } else {
          // Fallback: fecha ao clicar em qualquer lugar da mensagem
          validationElement.addEventListener('click', fecharMensagemValidacao);
        }
      } else {
        // Fallback para SweetAlert2 se o elemento não for encontrado
        Swal.fire({
          icon: 'warning',
          title: 'Atenção',
          text: mensagem,
          confirmButtonColor: '#4a90e2',
          confirmButtonText: 'Entendi',
          allowOutsideClick: false
        });
      }
    }
    
    // Função para gerenciar os treinamentos
    function gerenciarTreinamentos() {
      // Dados dos treinamentos
      const treinamentos = [
        { codigo: 'TR001', nome: 'NR-10 - Segurança em Instalações Elétricas', valor: '150,00' },
        { codigo: 'TR002', nome: 'NR-35 - Trabalho em Altura', valor: '180,00' },
        { codigo: 'TR003', nome: 'NR-33 - Espaços Confinados', valor: '220,00' },
        { codigo: 'TR004', nome: 'NR-11 - Operação de Empilhadeira', valor: '200,00' },
        { codigo: 'TR005', nome: 'NR-06 - EPI', valor: '120,00' },
        { codigo: 'TR006', nome: 'NR-23 - Prevenção e Combate a Incêndio', valor: '250,00' },
        { codigo: 'TR007', nome: 'NR-12 - Segurança em Máquinas e Equipamentos', valor: '190,00' },
        { codigo: 'TR008', nome: 'NR-18 - Condições e Meio Ambiente de Trabalho na Indústria da Construção', valor: '230,00' },
        { codigo: 'TR009', nome: 'NR-20 - Segurança e Saúde no Trabalho com Inflamáveis e Combustíveis', valor: '270,00' },
        { codigo: 'TR010', nome: 'NR-34 - Condições e Meio Ambiente de Trabalho na Indústria da Construção e Reparação Naval', valor: '210,00' }
      ];

      // Elementos do DOM
      const listaTreinamentos = document.getElementById('listaTreinamentos');
      const btnAplicar = document.getElementById('btnAplicarTreinamentos');
      const btnAddTreinamento = document.getElementById('btnAddTreinamento');
      const containerSelecionados = document.getElementById('treinamentosSelecionados');
      const totalElement = document.getElementById('totalTreinamentos');

      // Renderiza a lista de treinamentos
      function renderizarTreinamentos() {
        listaTreinamentos.innerHTML = treinamentos.map(treinamento => `
          <div class="treinamento-item" style="padding: 8px 12px; border-bottom: 1px solid #e9ecef; display: flex; align-items: center;">
            <input type="checkbox" value="${treinamento.codigo}" 
                   data-nome="${treinamento.nome}" 
                   data-valor="${treinamento.valor}" 
                   style="margin-right: 10px; cursor: pointer;">
            <div style="flex: 1; cursor: pointer;">
              <div style="font-weight: 500;">${treinamento.nome}</div>
              <div style="font-size: 12px; color: #6c757d;">
                Código: ${treinamento.codigo} - Valor: R$ ${treinamento.valor}
              </div>
            </div>
          </div>
        `).join('');
      }

      // Cria o banner de totais se não existir
      function createTotalBanner() {
        if (!document.getElementById('total-treinamentos-banner')) {
          const banner = document.createElement('div');
          banner.id = 'total-treinamentos-banner';
          banner.style.position = 'fixed';
          banner.style.top = '10px';
          banner.style.right = '10px';
          banner.style.backgroundColor = '#28a745';
          banner.style.border = 'none';
          banner.style.borderRadius = '6px';
          banner.style.padding = '10px 20px';
          banner.style.zIndex = '9998';
          banner.style.display = 'flex';
          banner.style.alignItems = 'center';
          banner.style.boxShadow = '0 2px 8px rgba(0,0,0,0.15)';
          banner.style.color = 'white';
          banner.style.fontFamily = 'Arial, sans-serif';
          banner.style.fontSize = '14px';
          banner.style.fontWeight = '600';
          banner.style.letterSpacing = '0.3px';
          banner.style.transition = 'all 0.3s ease';
          banner.innerHTML = `
            <i class="fas fa-graduation-cap" style="font-size: 16px; color: #ffffff; margin-right: 8px;"></i>
            <span style="color: #ffffff; text-shadow: 0 1px 1px rgba(0,0,0,0.1);">TREINAMENTOS: R$ 0,00</span>
          `;
          
          // Função para ajustar a posição baseada no banner do motorista
          function ajustarPosicao() {
            const motoristaBanner = document.getElementById('motorista-banner');
            if (motoristaBanner && window.getComputedStyle(motoristaBanner).display !== 'none') {
              banner.style.top = `${motoristaBanner.offsetTop + motoristaBanner.offsetHeight + 10}px`;
            } else {
              banner.style.top = '10px';
            }
          }
          
          // Observa mudanças no banner do motorista
          const motoristaBanner = document.getElementById('motorista-banner');
          if (motoristaBanner) {
            // Configura o MutationObserver para observar mudanças no estilo do banner do motorista
            const observer = new MutationObserver(ajustarPosicao);
            observer.observe(motoristaBanner, { attributes: true, attributeFilter: ['style'] });
            
            // Ajusta a posição inicial
            ajustarPosicao();
          } else {
            banner.style.top = '10px';
          }
          
          document.body.appendChild(banner);
        }
      }

      // Atualiza o banner de totais
      function updateTotalBanner(total) {
        let banner = document.getElementById('total-treinamentos-banner');
        if (!banner) {
          createTotalBanner();
          banner = document.getElementById('total-treinamentos-banner');
        }
        const totalFormatado = total.toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        banner.querySelector('span').textContent = `TREINAMENTOS: R$ ${totalFormatado}`;
      }

      // Atualiza a lista de treinamentos selecionados
      function atualizarSelecionados() {
        const checkboxes = document.querySelectorAll('#listaTreinamentos input[type="checkbox"]:checked');
        
        if (checkboxes.length === 0) {
          containerSelecionados.innerHTML = `
            <div style="color: #6c757d; font-style: italic; text-align: center; padding: 20px 0;">
              Nenhum treinamento selecionado
            </div>`;
          totalElement.textContent = 'Total: R$ 0,00';
          updateTotalBanner(0);
          return;
        }
        
        let html = '';
        let total = 0;
        
        checkboxes.forEach(checkbox => {
          const codigo = checkbox.value;
          const nome = checkbox.getAttribute('data-nome');
          const valor = parseFloat(checkbox.getAttribute('data-valor').replace('.', '').replace(',', '.'));
          
          if (!isNaN(valor)) {
            total += valor;
            
            html += `
              <div style="display: flex; justify-content: space-between; align-items: center; 
                         padding: 8px 0; border-bottom: 1px solid #e9ecef;">
                <div>
                  <div style="font-weight: 500; font-size: 14px;">${nome}</div>
                  <div style="font-size: 12px; color: #6c757d;">Código: ${codigo}</div>
                </div>
                <div style="font-weight: 600; color: #28a745;">
                  R$ ${valor.toFixed(2).replace('.', ',')}
                </div>
              </div>`;
          }
        });
        
        containerSelecionados.innerHTML = html;
        const totalFormatado = total.toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        totalElement.textContent = `Total: R$ ${totalFormatado}`;
        
        // Atualiza a variável global para o faturamento
        window.fatTotalTreinamentos = total;
        
        // Atualiza o banner de totais
        updateTotalBanner(total);
        
        // Atualiza o faturamento
        if (typeof fatAtualizarTotais === 'function') {
          fatAtualizarTotais();
        }
      }

      // Event Listeners
      function setupEventListeners() {
        // Verifica se os elementos existem antes de adicionar event listeners
        if (btnAplicar) {
          btnAplicar.addEventListener('click', atualizarSelecionados);
        } else {
          console.warn('Botão de aplicar treinamentos não encontrado');
        }
        
        // Adicionar novo treinamento (exemplo)
        if (btnAddTreinamento) {
          btnAddTreinamento.addEventListener('click', () => {
            alert('Funcionalidade para adicionar novo treinamento será implementada aqui.');
          });
        } else {
          console.warn('Botão de adicionar treinamento não encontrado');
        }
        
        // Marcar/desmarcar ao clicar em qualquer lugar do item
        if (listaTreinamentos) {
          listaTreinamentos.addEventListener('click', (e) => {
            const item = e.target.closest('.treinamento-item');
            if (item) {
              const checkbox = item.querySelector('input[type="checkbox"]');
              if (checkbox) {
                checkbox.checked = !checkbox.checked;
              }
            }
          });
        } else {
          console.warn('Lista de treinamentos não encontrada');
        }
      }

      // Inicialização
      function init() {
        renderizarTreinamentos();
        setupEventListeners();
        createTotalBanner(); // Cria o banner de totais ao carregar a página
      }

      return { init };
    }

    // Gerenciar o status de motorista
    function updateMotoristaStatus(isMotorista) {
      appState.motorista = isMotorista;
      const motoristaBanner = document.getElementById('motorista-banner');
      if (motoristaBanner) {
        motoristaBanner.style.display = isMotorista ? 'flex' : 'none';
      }
      
      // Atualizar o ícone do caminhão no questionário
      const truckIcon = document.querySelector('input[name="motorista"][value="sim"] + span .fa-truck-moving');
      if (truckIcon) {
        truckIcon.style.display = isMotorista ? 'inline-block' : 'none';
      }
    }
    
    // Adicionar banner de motorista no topo da página
    function createMotoristaBanner() {
      const banner = document.createElement('div');
      banner.id = 'motorista-banner';
      banner.style.display = 'none';
      banner.style.position = 'fixed';
      banner.style.top = '10px';
      banner.style.right = '10px';
      banner.style.backgroundColor = '#1e3c72';
      banner.style.border = 'none';
      banner.style.borderRadius = '6px';
      banner.style.padding = '12px 20px';
      banner.style.zIndex = '9999';
      banner.style.alignItems = 'center';
      banner.style.boxShadow = '0 4px 12px rgba(30, 60, 114, 0.3)';
      banner.style.color = 'white';
      banner.style.fontFamily = 'Arial, sans-serif';
      banner.style.fontWeight = 'bold';
      banner.innerHTML = `
        <i class="fas fa-truck-moving" style="font-size: 22px; color: #ffffff; margin-right: 10px;"></i>
        <span style="color: #ffffff; text-shadow: 0 1px 2px rgba(0,0,0,0.2);">MOTORISTA SELECIONADO</span>
      `;
      document.body.appendChild(banner);
    }
    
    // Inicializar banner e listeners
    document.addEventListener('DOMContentLoaded', function() {
      createMotoristaBanner();
      
      // Adicionar listener para mudanças no radio button
      document.addEventListener('change', function(e) {
        if (e.target.name === 'motorista') {
          updateMotoristaStatus(e.target.value === 'sim');
        }
      });
    });

    // Inicialização dos eventos do ECP
    document.addEventListener('DOMContentLoaded', function() {
      console.log('DOM carregado, definindo etapas...');
      
      // Verifica se já está na aba de riscos ou de aptidões
      checkAndInitializeRiscosTab();
      checkAndInitializeAptidoesTab();
      
      // Adiciona evento para inicializar treinamentos quando a aba de Riscos for clicada
      const riscosTab = document.querySelector('.tab[data-step="3"]');
      if (riscosTab) {
        riscosTab.addEventListener('click', function() {
          // Verifica se já foi inicializado
          if (!window.treinamentosInicializados) {
            setTimeout(() => {
              const treinamentos = gerenciarTreinamentos();
              treinamentos.init();
              window.treinamentosInicializados = true;
            }, 100);
          }
        });
      }
      
      // Adiciona observador de mutação para verificar quando as abas forem ativadas
      const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
          if (mutation.attributeName === 'class') {
            checkAndInitializeRiscosTab();
            checkAndInitializeAptidoesTab();
          }
        });
      });
      
      // Observa mudanças nas abas
      const tabs = document.querySelectorAll('.tab');
      tabs.forEach(tab => {
        observer.observe(tab, { attributes: true });
      });
      
      // Inicializa os dropdowns do laudo
      initializeLaudoDropdowns();
      
      // Conteúdo de Aptidões e Exames
      const aptidoesExamesContent = `
        <div class="apt-container" style="padding: 20px; font-family: inherit;">
          <div class="step-header" style="margin-bottom: 20px;">
            <div class="title-icon">
              <i class="fas fa-clipboard-check" style="font-size: 48px; color: #4a90e2;"></i>
            </div>
            <div class="step-title">
              <h2 style="font-family: 'Fustat', inherit; font-weight: 600; color: #1a1a1a; margin: 0 0 4px 0;">Aptidões e Exames</h2>
              <div class="step-subtitle" style="font-family: 'Fustat', inherit; color: #6b7280; margin: 0; font-size: 0.95rem;">Gerencie as aptidões e exames do colaborador</div>
            </div>
          </div>
          
          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <!-- Seção de Aptidões -->
            <div class="apt-card" style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">
              <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <h3 style="margin: 0; font-family: 'Fustat', inherit; font-size: 1.1rem; font-weight: 600; color: #2d3748;">Aptidões Extras</h3>
                <button id="apt-btnAddAptidao" class="btn" style="background-color: #22c55e; color: white; border: none; padding: 8px 16px; border-radius: 8px; cursor: pointer; display: flex; align-items: center; gap: 5px; font-family: inherit; font-size: 0.9rem; font-weight: 500; transition: background-color 0.2s;">
                  <i class="fas fa-plus"></i> Nova Aptidão
                </button>
              </div>
              <div id="apt-listaAptidoes" class="apt-lista" style="max-height: 300px; overflow-y: auto; border: 1px solid #eee; border-radius: 8px; padding: 10px; margin-bottom: 15px;">
                <div id="apt-checkbox-container" style="display: flex; flex-direction: column; gap: 8px;">
                  <!-- Checkboxes de aptidões serão inseridos aqui -->
                </div>
              </div>
              <div id="apt-listaAptidoesSelecionadas" class="apt-lista-selecionadas" style="min-height: 60px; border: 1px solid #e0e0e0; border-radius: 8px; padding: 10px; background-color: #f9f9f9;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
                  <div style="font-size: 12px; color: #666;">Aptidões selecionadas:</div>
                  <div id="apt-total-aptidoes" style="font-size: 14px; font-weight: 500; color: #1a73e8;">
                    Total: R$ 0,00
                  </div>
                </div>
                <div id="apt-selected-aptidoes" style="display: flex; flex-wrap: wrap; gap: 5px;">
                  <!-- Itens de aptidão selecionados serão mostrados aqui -->
                </div>
              </div>
            </div>
            
            <!-- Seção de Exames -->
            <div class="apt-card" style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">
              <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <h3 style="margin: 0; font-family: 'Fustat', inherit; font-size: 1.1rem; font-weight: 600; color: #2d3748;">Exames / Procedimentos</h3>
                <button id="apt-btnAddExame" class="btn" style="background-color: #22c55e; color: white; border: none; padding: 8px 16px; border-radius: 8px; cursor: pointer; display: flex; align-items: center; gap: 5px; font-family: inherit; font-size: 0.9rem; font-weight: 500; transition: background-color 0.2s;">
                  <i class="fas fa-plus"></i> Novo Exame
                </button>
              </div>
              <div id="apt-listaExames" class="apt-lista" style="max-height: 300px; overflow-y: auto; border: 1px solid #eee; border-radius: 8px; padding: 10px; margin-bottom: 15px;">
                <div id="apt-checkbox-container-exames" style="display: flex; flex-direction: column; gap: 8px;">
                  <!-- Checkboxes de exames serão inseridos aqui -->
                </div>
              </div>
              <div id="apt-listaExamesSelecionados" class="apt-lista-selecionadas" style="min-height: 60px; border: 1px solid #e0e0e0; border-radius: 8px; padding: 10px; background-color: #f9f9f9;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
                  <div style="font-size: 12px; color: #666;">Exames selecionados:</div>
                  <div id="apt-total-exames" style="font-size: 14px; font-weight: 500; color: #1a73e8;">
                    Total: R$ 0,00
                  </div>
                </div>
                <div id="apt-selected-exames" style="display: flex; flex-wrap: wrap; gap: 5px;">
                  <!-- Itens de exame selecionados serão mostrados aqui -->
                </div>
              </div>
            </div>
          </div>
          
          <!-- Modal para adicionar itens -->
          <div id="apt-modal" class="apt-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); justify-content: center; align-items: center; z-index: 1000;">
            <div class="apt-modal-content" style="background: white; padding: 20px; border-radius: 10px; min-width: 300px;">
              <h3 id="apt-modalTitle" style="margin-top: 0;">Adicionar</h3>
              <input type="text" id="apt-novoCodigo" placeholder="Código" style="width: 100%; padding: 8px; margin-bottom: 10px; border-radius: 6px; border: 1px solid #dee2e6;">
              <input type="text" id="apt-novoNome" placeholder="Nome" style="width: 100%; padding: 8px; margin-bottom: 10px; border-radius: 6px; border: 1px solid #dee2e6;">
              <input type="text" id="apt-novoValor" placeholder="Valor (ex: 50,00)" style="width: 100%; padding: 8px; margin-bottom: 15px; border-radius: 6px; border: 1px solid #dee2e6;">
              <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button id="apt-btnCancelar" class="btn" style="background-color: #6c757d; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer;">Cancelar</button>
                <button id="apt-btnSalvar" class="btn" style="background-color: #22c55e; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer;">Salvar</button>
              </div>
            </div>
          </div>
        </div>
      `;

      // Define as etapas depois que o DOM estiver carregado
      etapas = [
        document.getElementById('tabContent').innerHTML, // Etapa 0 - Seleção de Exame
        ecpContent,                                     // Etapa 1 - ECP
        profissionaisMedicinaContent,                   // Etapa 2 - Profissionais
        riscosContent,                                 // Etapa 3 - Riscos Ocupacionais
        aptidoesExamesContent,                         // Etapa 4 - Aptidões e Exames
        // Etapa 5 - Faturamento
        `
        <div class="fat-section">
          <h1 class="fat-header">#Faturamento N0254</h1>
          <h2 class="fat-subheader">Produtos</h2>
          
          <!-- Formulário para adicionar produtos -->
          <div class="fat-form-container">
            <div class="fat-form">
              <div class="fat-input-group fat-descricao">
                <label for="fat-descricao">Descrição</label>
                <input type="text" id="fat-descricao" class="fat-input" placeholder="Descrição do produto">
              </div>
              <div class="fat-input-group fat-quantidade">
                <label for="fat-quantidade">Quantidade</label>
                <input type="number" id="fat-quantidade" class="fat-input" placeholder="Qtd" min="1">
              </div>
              <div class="fat-input-group fat-valor">
                <label for="fat-valorUnit">Valor Unitário (R$)</label>
                <input type="number" id="fat-valorUnit" class="fat-input" placeholder="0,00" step="0.01" min="0">
              </div>
              <div class="fat-btn-group">
                <button class="fat-btn" onclick="fatAdicionarProduto()">
                  <i class="fas fa-plus"></i> Adicionar
                </button>
              </div>
            </div>
          </div>

          <!-- Lista de produtos -->
          <div id="fat-lista-produtos" class="fat-produtos-lista">
            <!-- Os produtos serão adicionados aqui dinamicamente -->
          </div>

          <!-- Resumo de totais -->
          <div class="fat-totals">
            <h3 class="fat-totals-title">Resumo do Faturamento</h3>
            <div id="fat-totais-container">
              <div class="fat-total-item">
                <span>EPI/EPC:</span>
                <span id="fat-total-epi">R$ 0,00</span>
              </div>
              <div class="fat-total-item">
                <span>Exames:</span>
                <span id="fat-total-exames">R$ 210,00</span>
              </div>
              <div class="fat-total-item">
                <span>Treinamentos:</span>
                <span id="fat-total-treinamentos">R$ 210,00</span>
              </div>
              <div class="fat-total-item" style="margin-top: 15px; padding-top: 15px; border-top: 2px solid #e2e8f0;">
                <span style="font-weight: 600; font-size: 16px; color: #2d3748;">Total Geral:</span>
                <span id="fat-total-geral" style="font-weight: 700; font-size: 18px; color: #2b6cb0;">R$ 420,00</span>
              </div>
            </div>
          </div>
        </div>
        </div>
        <div id="faturamento-script-placeholder"></div>
        <div id="faturamento-script-placeholder"></div>
        <!-- Seção de Modelos de Documentos -->
        <!-- Seção de Tipo de Orçamento -->
        <div class="sm-container" style="margin-top: 40px; margin-bottom: 2rem;">
          <h2 style="font-size: 24px; font-weight: 500; color: #111; margin-bottom: 20px;">Tipo de Orçamento</h2>
          <div style="background: white; border-radius: 0.75rem; border: 1px solid #e5e7eb; padding: 1.5rem;">
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(230px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
              <!-- Checkbox Exames e Procedimentos -->
              <label class="tipo-orcamento-label">
                <input type="checkbox" class="tipo-orcamento" value="exames">
                <div class="tipo-orcamento-card">
                  <i class="fas fa-stethoscope"></i>
                  <span>Exames e Procedimentos</span>
                </div>
              </label>
              
              <!-- Checkbox Treinamentos -->
              <label class="tipo-orcamento-label">
                <input type="checkbox" class="tipo-orcamento" value="treinamentos">
                <div class="tipo-orcamento-card">
                  <i class="fas fa-graduation-cap"></i>
                  <span>Treinamentos</span>
                </div>
              </label>
              
              <!-- Checkbox EPI/EPC -->
              <label class="tipo-orcamento-label">
                <input type="checkbox" class="tipo-orcamento" value="epi">
                <div class="tipo-orcamento-card">
                  <i class="fas fa-hard-hat"></i>
                  <span>EPI/EPC</span>
                </div>
              </label>
            </div>
            
            <!-- Opção de Assinatura -->
            <div style="padding-top: 1rem; border-top: 1px solid #e5e7eb; margin-top: 1rem;">
              <label style="display: flex; align-items: center; cursor: pointer; gap: 0.75rem;">
                <input type="checkbox" id="requer-assinatura" style="width: 1.25rem; height: 1.25rem; border-color: #d1d5db; border-radius: 0.375rem; cursor: pointer;">
                <div style="display: flex; align-items: center; gap: 0.5rem; font-weight: 500; color: #374151;">
                  <i class="fas fa-signature" style="color: #8b5cf6; font-size: 1.1rem;"></i>
                  <span>Assinar digitalmente</span>
                </div>
              </label>
            </div>
          </div>
        </div>

        <!-- Seção de Modelos de Documentos -->
        <div class="sm-container" style="margin-bottom: 2rem;">
          <h2 style="font-size: 24px; font-weight: 500; color: #111; margin-bottom: 20px;">Modelos de Documentos</h2>
          <p style="color: #6b7280; margin-bottom: 1.5rem;">Selecione os documentos que deseja gerar:</p>
          
          <style>
            .sm-container {
              font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            }
            .sm-grid {
              display: grid;
              grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
              gap: 1rem;
              margin-bottom: 2rem;
              align-items: stretch;
            }
            .sm-label {
              position: relative;
              cursor: pointer;
              margin: 0;
              transition: transform 0.2s ease;
              min-height: 1px; /* Evita que os labels colapsem */
            }
            .sm-label:hover {
              transform: translateY(-2px);
            }
            .sm-checkbox {
              position: absolute;
              opacity: 0;
              height: 0;
              width: 0;
            }
            .sm-card {
              display: flex;
              align-items: center;
              gap: 0.875rem;
              padding: 1rem 1.25rem;
              border-radius: 0.75rem;
              background: white;
              border: 1px solid #e5e7eb;
              box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
              transition: all 0.2s ease;
              min-height: 80px;
              cursor: pointer;
              box-sizing: border-box;
            }
            
            .sm-card:hover {
              transform: translateY(-2px);
              box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
              position: relative;
              z-index: 1;
            }
            .sm-card i {
              display: flex;
              align-items: center;
              justify-content: center;
              width: 2.25rem;
              height: 2.25rem;
              border-radius: 0.5rem;
              font-size: 1.1rem;
              flex-shrink: 0;
              background-color: #f3f4f6;
              color: #4b5563;
              transition: all 0.2s ease;
            }
            
            /* Cores específicas para cada ícone */
            .sm-card .fa-paper-plane { background-color: #dbeafe; color: #1e40af; }
            .sm-card .fa-clipboard-list { background-color: #d1fae5; color: #065f46; }
            .sm-card .fa-file-medical { background-color: #fef3c7; color: #92400e; }
            .sm-card .fa-eye { background-color: #fee2e2; color: #991b1b; }
            .sm-card .fa-users { background-color: #e0e7ff; color: #3730a3; }
            .sm-card .fa-exclamation-triangle { background-color: #fef3c7; color: #92400e; }
            .sm-card .fa-file-alt { background-color: #1e1b4b; color: white; }
            .sm-card .fa-dollar-sign { background-color: #ecfdf5; color: #065f46; }
            .sm-card span {
              font-size: 0.9375rem;
              font-weight: 500;
              color: #1f2937;
              line-height: 1.4;
            }
            .sm-checkbox:checked + .sm-card {
              border-color: #3b82f6;
              background-color: #f0f9ff;
              box-shadow: 0 4px 12px rgba(59, 130, 246, 0.1);
            }
            
            .sm-checkbox:checked + .sm-card i {
              transform: scale(1.1);
              box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }
            .sm-checkbox:focus-visible + .sm-card {
              outline: 2px solid #3b82f6;
              outline-offset: 2px;
            }
            @media (max-width: 1024px) {
              .sm-grid {
                grid-template-columns: repeat(2, 1fr);
              }
            }
            @media (max-width: 640px) {
              .sm-grid {
                grid-template-columns: 1fr;
              }
            }
          </style>
          
          <div class="sm-grid">
            <!-- Guia de Encaminhamento -->
            <label class="sm-label">
              <input type="checkbox" class="sm-checkbox">
              <div class="sm-card">
                <i class="fas fa-paper-plane"></i>
                <span>Guia de Encaminhamento</span>
              </div>
            </label>
            
            <!-- ASO -->
            <label class="sm-label">
              <input type="checkbox" class="sm-checkbox">
              <div class="sm-card">
                <i class="fas fa-clipboard-list"></i>
                <span>ASO - Atestado de Saúde Ocupacional</span>
              </div>
            </label>
            
            <!-- Prontuário -->
            <label class="sm-label">
              <input type="checkbox" class="sm-checkbox">
              <div class="sm-card">
                <i class="fas fa-file-medical"></i>
                <span>Prontuário Médico</span>
              </div>
            </label>
            
            <!-- Acuidade Visual -->
            <label class="sm-label">
              <input type="checkbox" class="sm-checkbox">
              <div class="sm-card">
                <i class="fas fa-eye"></i>
                <span>Acuidade Visual</span>
              </div>
            </label>
            
            <!-- Psico Social -->
            <label class="sm-label">
              <input type="checkbox" class="sm-checkbox">
              <div class="sm-card">
                <i class="fas fa-users"></i>
                <span>Psico Social</span>
              </div>
            </label>
            
            <!-- Toxicológico -->
            <label class="sm-label">
              <input type="checkbox" class="sm-checkbox">
              <div class="sm-card">
                <i class="fas fa-exclamation-triangle"></i>
                <span>Toxicológico</span>
              </div>
            </label>
            
            <!-- Resumo de Laudo -->
            <label class="sm-label">
              <input type="checkbox" class="sm-checkbox">
              <div class="sm-card">
                <i class="fas fa-file-alt"></i>
                <span>Resumo de Laudo</span>
              </div>
            </label>
            
            <!-- Faturamento -->
            <label class="sm-label">
              <input type="checkbox" class="sm-checkbox">
              <div class="sm-card">
                <i class="fas fa-dollar-sign"></i>
                <span>Faturamento</span>
              </div>
            </label>
          </div>
          
          <!-- Estilos para os cards de tipo de orçamento -->
          <style>
            .tipo-orcamento-label {
              display: block;
              cursor: pointer;
            }
            .tipo-orcamento {
              position: absolute;
              opacity: 0;
            }
            .tipo-orcamento-card {
              display: flex;
              align-items: center;
              gap: 0.75rem;
              padding: 1rem;
              border: 1px solid #e5e7eb;
              border-radius: 0.5rem;
              background: white;
              transition: all 0.2s ease;
              height: 100%;
            }
            .tipo-orcamento-card i {
              font-size: 1.25rem;
              width: 2rem;
              height: 2rem;
              display: flex;
              align-items: center;
              justify-content: center;
              border-radius: 0.375rem;
              background: #f9fafb;
            }
            .tipo-orcamento-card span {
              font-weight: 500;
              color: #374151;
            }
            .tipo-orcamento:checked + .tipo-orcamento-card {
              border-color: #3b82f6;
              background-color: #f0f7ff;
              box-shadow: 0 0 0 1px #3b82f6;
            }
            .tipo-orcamento:focus + .tipo-orcamento-card {
              box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
            }
          </style>
          
          <!-- Lista de Documentos Selecionados -->
          <div class="sm-selected-container">
            <h3 class="sm-selected-title">Documentos Selecionados</h3>
            <div id="sm-selected-list" class="sm-selected-list">
              <p class="sm-empty-message">Nenhum documento selecionado</p>
            </div>
            <style>
              .sm-selected-container {
                margin-top: 2.5rem;
                background: white;
                border-radius: 0.75rem;
                border: 1px solid #e5e7eb;
                overflow: hidden;
              }
              .sm-selected-title {
                font-size: 1.125rem;
                font-weight: 600;
                color: #111827;
                padding: 1rem 1.5rem;
                margin: 0;
                background: #f9fafb;
                border-bottom: 1px solid #e5e7eb;
              }
              .sm-selected-list {
                padding: 1rem 1.5rem;
                min-height: 80px;
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                align-items: center;
              }
              .sm-selected-item {
                display: inline-flex;
                align-items: center;
                justify-content: space-between;
                background: #f9fafb;
                padding: 8px 12px;
                border-radius: 6px;
                border: 1px solid rgba(0, 0, 0, 0.1);
                transition: all 0.2s ease;
                margin: 4px;
                font-size: 0.875rem;
                font-weight: 500;
                gap: 8px;
                max-width: 100%;
                box-sizing: border-box;
              }
              .sm-selected-item:hover {
                transform: translateY(-2px);
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
              }
              .sm-selected-item > div {
                display: flex;
                align-items: center;
                gap: 0.75rem;
              }
              .sm-selected-icon {
                width: 1.5rem;
                height: 1.5rem;
                border-radius: 4px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 0.875rem;
                flex-shrink: 0;
                margin-right: 4px;
              }
              .sm-selected-item span {
                font-size: 0.9375rem;
                color: inherit;
                font-weight: 500;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                max-width: 200px;
              }
              .remove-document {
                background: none;
                border: none;
                color: inherit;
                cursor: pointer;
                padding: 2px 6px;
                border-radius: 50%;
                transition: all 0.2s ease;
                opacity: 0.7;
                margin-left: 6px;
                font-size: 1.1rem;
                line-height: 1;
                display: flex;
                align-items: center;
                justify-content: center;
              }
              .remove-document:hover {
                background: rgba(0, 0, 0, 0.1);
                opacity: 1;
              }
              .sm-empty-message {
                color: #9ca3af;
                font-size: 0.9375rem;
                text-align: center;
                padding: 1.5rem 0;
                margin: 0;
              }
            </style>
          </div>
        </div>
          </div>
        </div>`
      ];
      
      // Função para atualizar a lista de selecionados
      function updateSelectedList() {
        const labels = document.querySelectorAll('.sm-label');
        const selectedList = document.getElementById('sm-selected-list');
        
        if (!selectedList) return;
        
        // Limpa a lista
        selectedList.innerHTML = '';
        
        // Adiciona cada item selecionado à lista
        labels.forEach(label => {
          const checkbox = label.querySelector('input[type="checkbox"]');
          const card = label.querySelector('.sm-card');
          const icon = card ? card.querySelector('i') : null;
          
          if (checkbox && checkbox.checked && card && icon) {
            // Cria o elemento do item selecionado
            const selectedItem = document.createElement('div');
            selectedItem.className = 'sm-selected-item';
            
            // Obtém a classe de cor baseada no ícone
            let bgColor = '#f3f4f6';
            let textColor = '#1f2937';
            
            if (icon.classList.contains('fa-paper-plane')) {
              bgColor = '#dbeafe';
              textColor = '#1e40af';
            } else if (icon.classList.contains('fa-clipboard-list')) {
              bgColor = '#d1fae5';
              textColor = '#065f46';
            } else if (icon.classList.contains('fa-file-medical')) {
              bgColor = '#fef3c7';
              textColor = '#92400e';
            } else if (icon.classList.contains('fa-eye')) {
              bgColor = '#fee2e2';
              textColor = '#991b1b';
            } else if (icon.classList.contains('fa-users')) {
              bgColor = '#e0e7ff';
              textColor = '#3730a3';
            } else if (icon.classList.contains('fa-exclamation-triangle')) {
              bgColor = '#fef3c7';
              textColor = '#92400e';
            } else if (icon.classList.contains('fa-file-alt')) {
              bgColor = '#1e1b4b';
              textColor = '#ffffff';
            } else if (icon.classList.contains('fa-dollar-sign')) {
              bgColor = '#ecfdf5';
              textColor = '#065f46';
            }
            
            // Aplica os estilos ao item
            selectedItem.style.backgroundColor = bgColor;
            selectedItem.style.color = textColor;
            
            // Adiciona o ícone
            const iconClone = icon.cloneNode(true);
            iconClone.className = 'sm-selected-icon';
            
            // Adiciona o texto
            const text = card.querySelector('span').textContent;
            const textNode = document.createTextNode(text);
            
            // Botão de remover
            const removeBtn = document.createElement('button');
            removeBtn.className = 'remove-document';
            removeBtn.innerHTML = '×';
            removeBtn.title = 'Remover';
            removeBtn.onclick = (e) => {
              e.stopPropagation();
              checkbox.checked = false;
              updateSelectedList();
            };
            
            // Monta o item
            selectedItem.appendChild(iconClone);
            selectedItem.appendChild(textNode);
            selectedItem.appendChild(removeBtn);
            
            // Adiciona o item à lista
            selectedList.appendChild(selectedItem);
          }
        });
        
        // Mostra mensagem se não houver itens selecionados
        if (selectedList.children.length === 0) {
          selectedList.innerHTML = '<p class="sm-empty-message">Nenhum documento selecionado</p>';
        }
      }
      
      // Inicializa a seleção de documentos
      function initDocumentSelection() {
        // Adiciona eventos de mudança aos checkboxes
        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
          // Configura o estado inicial
          const card = checkbox.nextElementSibling;
          if (card && card.classList.contains('sm-card')) {
            card.style.opacity = checkbox.checked ? '1' : '0.6';
            card.style.transform = checkbox.checked ? 'translateY(-2px)' : 'none';
            card.style.boxShadow = checkbox.checked 
              ? '0 8px 20px rgba(0,0,0,0.12)' 
              : '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)';
          }
          
          // Adiciona o evento de mudança
          checkbox.addEventListener('change', function() {
            const card = this.nextElementSibling;
            if (card && card.classList.contains('sm-card')) {
              card.style.opacity = this.checked ? '1' : '0.6';
              card.style.transform = this.checked ? 'translateY(-2px)' : 'none';
              card.style.boxShadow = this.checked 
                ? '0 8px 20px rgba(0,0,0,0.12)' 
                : '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)';
            }
            updateSelectedList();
          });
        });
        
        // Permite clicar em qualquer lugar no label para alternar o checkbox
        document.querySelectorAll('.sm-label').forEach(label => {
          label.addEventListener('click', function(e) {
            const checkbox = this.querySelector('input[type="checkbox"]');
            if (checkbox && !e.target.closest('button')) {
              checkbox.checked = !checkbox.checked;
              const event = new Event('change');
              checkbox.dispatchEvent(event);
            }
          });
        });
        
        // Inicializa a lista de selecionados
        updateSelectedList();
      }
      
      // Inicializa quando o DOM estiver pronto
      function initializeComponents() {
        initDocumentSelection();
        
        // Inicializa componentes específicos da aba atual
        if (appState.currentStep === 3) {
          setTimeout(initializeRiscosComponent, 100);
        } else if (appState.currentStep === 4) { // Índice 4 = Passo 5 (Aptidões e Exames)
          setTimeout(initializeAptidoesExames, 100);
        }
      }
      
      if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeComponents);
      } else {
        initializeComponents();
      }
      
      // Inicializa os componentes quando a aba for carregada
      document.addEventListener('tabChanged', function(e) {
        if (e.detail.step === 3) { // Índice 3 = Passo 4 (Riscos)
          // Pequeno atraso para garantir que o conteúdo foi carregado
          setTimeout(initializeRiscosComponent, 100);
        } else if (e.detail.step === 4) { // Índice 4 = Passo 5 (Aptidões e Exames)
          setTimeout(initializeAptidoesExames, 100);
        } else if (e.detail.step === 5) { // Índice 5 = Passo 6 (Documentos)
          // Pequeno atraso para garantir que o conteúdo foi carregado
          setTimeout(initDocumentSelection, 100);
        }
      });
      
      // Sobrescreve a função updateTab para configurar eventos após a troca de aba
      const originalUpdateTab = updateTab;
      updateTab = function(step) {
        originalUpdateTab(step);
        // Pequeno atraso para garantir que o DOM foi atualizado
        setTimeout(setupECPEvents, 50);
      };
    });
    
    // Função para inicializar o componente de Aptidões e Exames com checkboxes
    function initializeAptidoesExames() {
      console.log('Inicializando componente de Aptidões e Exames...');
      
      // Dados iniciais
      const aptDadosAptidoes = [
        { codigo: "0000", nome: "Trabalho em altura", valor: "58,23" },
        { codigo: "0001", nome: "Espaço confinado", valor: "86,92" },
        { codigo: "0002", nome: "NR10 Básico", valor: "12,56" },
        { codigo: "0003", nome: "NR12 Operação de Máquinas", valor: "15,45" },
        { codigo: "0004", nome: "Brigada de Incêndio", valor: "18,76" },
        { codigo: "0005", nome: "Direção defensiva", valor: "20,12" }
      ];

      const aptDadosExames = [
        { codigo: "0068", nome: "Acetilcolinesterase eritrocitária", valor: "12,56" },
        { codigo: "0109", nome: "Ácido hipúrico", valor: "15,45" },
        { codigo: "0116", nome: "Ácido Metil Hipúrico", valor: "18,76" },
        { codigo: "0120", nome: "Hemograma completo", valor: "20,12" },
        { codigo: "0135", nome: "Audiometria", valor: "22,34" },
        { codigo: "0141", nome: "Espirometria", valor: "25,67" }
      ];

      let aptExamesSelecionados = [];
      let aptAptidoesSelecionadas = [];
      
      // Elementos do DOM
      const listaAptidoes = document.getElementById('apt-listaAptidoes');
      const listaExames = document.getElementById('apt-listaExames');
      const checkboxContainerApt = document.getElementById('apt-checkbox-container');
      const checkboxContainerExames = document.getElementById('apt-checkbox-container-exames');
      const selectedAptidoesContainer = document.getElementById('apt-selected-aptidoes');
      const selectedExamesContainer = document.getElementById('apt-selected-exames');
      const modal = document.getElementById('apt-modal');
      const modalTitle = document.getElementById('apt-modalTitle');
      const btnAddAptidao = document.getElementById('apt-btnAddAptidao');
      const btnAddExame = document.getElementById('apt-btnAddExame');
      const btnSalvar = document.getElementById('apt-btnSalvar');
      const btnCancelar = document.getElementById('apt-btnCancelar');
      const inputCodigo = document.getElementById('apt-novoCodigo');
      const inputNome = document.getElementById('apt-novoNome');
      let modalTipoAtual = ''; // 'aptidao' ou 'exame'

      
      // Função para criar um elemento de checkbox
      function criarCheckbox(item, tipo) {
        // Verifica se o checkbox já existe para evitar duplicação
        const existingCheckbox = document.getElementById(`${tipo}-${item.codigo}`);
        if (existingCheckbox) {
          return existingCheckbox.parentElement;
        }
        
        const container = document.createElement('div');
        container.style.display = 'flex';
        container.style.alignItems = 'center';
        container.style.padding = '8px';
        container.style.borderRadius = '4px';
        container.style.transition = 'background-color 0.2s';
        container.style.cursor = 'pointer';
        container.style.userSelect = 'none';
        container.style.gap = '10px';
        
        container.innerHTML = `
          <input type="checkbox" id="${tipo}-${item.codigo}" value="${item.codigo}" 
                 style="width: 18px; height: 18px; cursor: pointer;">
          <label for="${tipo}-${item.codigo}" style="cursor: pointer; flex: 1;">
            <div style="font-weight: 500;">${item.codigo} - ${item.nome}</div>
          </label>
        `;
        
        // Adiciona hover effect
        const handleMouseEnter = () => {
          container.style.backgroundColor = '#f5f5f5';
        };
        
        const handleMouseLeave = () => {
          container.style.backgroundColor = '';
        };
        
        container.addEventListener('mouseenter', handleMouseEnter);
        container.addEventListener('mouseleave', handleMouseLeave);
        
        // Adiciona evento de clique no container inteiro
        const handleContainerClick = (e) => {
          if (e.target.tagName !== 'INPUT') {
            const checkbox = container.querySelector('input[type="checkbox"]');
            if (checkbox) {
              checkbox.checked = !checkbox.checked;
              const event = new Event('change');
              checkbox.dispatchEvent(event);
            }
          }
        };
        
        container.addEventListener('click', handleContainerClick);
        
        // Adiciona evento de mudança no checkbox
        const checkbox = container.querySelector('input[type="checkbox"]');
        if (checkbox) {
          const handleCheckboxChange = () => {
            atualizarSelecionados(checkbox, tipo);
          };
          
          // Remove event listeners antigos para evitar duplicação
          checkbox.removeEventListener('change', handleCheckboxChange);
          // Adiciona o novo listener
          checkbox.addEventListener('change', handleCheckboxChange);
        }
        
        // Armazena referências para os manipuladores para remoção posterior se necessário
        container._handlers = {
          mouseenter: handleMouseEnter,
          mouseleave: handleMouseLeave,
          click: handleContainerClick
        };
        
        return container;
      }
      
      // Função para atualizar os itens selecionados
      function atualizarSelecionados(checkbox, tipo) {
        const codigo = checkbox.value;
        const nome = checkbox.nextElementSibling.textContent.trim();
        
        // Encontra o item completo nos dados originais para obter o valor
        const dadosOriginais = tipo === 'aptidao' ? aptDadosAptidoes : aptDadosExames;
        const itemOriginal = dadosOriginais.find(item => item.codigo === codigo);
        
        // Cria o item com o valor, se disponível
        const item = { 
          codigo, 
          nome,
          valor: itemOriginal?.valor || '0,00'
        };
        
        if (tipo === 'aptidao') {
          if (checkbox.checked) {
            aptAptidoesSelecionadas.push(item);
          } else {
            const index = aptAptidoesSelecionadas.findIndex(a => a.codigo === codigo);
            if (index !== -1) {
              aptAptidoesSelecionadas.splice(index, 1);
            }
          }
          atualizarListaSelecionados(aptAptidoesSelecionadas, selectedAptidoesContainer, 'aptidao');
        } else {
          if (checkbox.checked) {
            aptExamesSelecionados.push(item);
          } else {
            const index = aptExamesSelecionados.findIndex(e => e.codigo === codigo);
            if (index !== -1) {
              aptExamesSelecionados.splice(index, 1);
            }
          }
          atualizarListaSelecionados(aptExamesSelecionados, selectedExamesContainer, 'exame');
        }
      }
      
      // Função para formatar valor monetário
      function formatarValor(valor) {
        // Converte string para número, trocando vírgula por ponto
        const numero = parseFloat(valor.toString().replace(',', '.')) || 0;
        // Formata para o padrão brasileiro com 2 casas decimais
        return numero.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
      }
      
      // Função para calcular o total de uma lista de itens
      function calcularTotal(itens) {
        return itens.reduce((total, item) => {
          // Remove pontos de milhar e substitui vírgula por ponto
          const valor = parseFloat((item.valor || '0')
            .toString()
            .replace(/\./g, '')
            .replace(',', '.')) || 0;
          return total + valor;
        }, 0);
      }
      
      // Cria o banner de totais para Aptidões e Exames se não existir
      function createAptExamesTotalBanner() {
        if (!document.getElementById('apt-exames-total-banner')) {
          const banner = document.createElement('div');
          banner.id = 'apt-exames-total-banner';
          banner.style.position = 'fixed';
          banner.style.top = '10px';
          banner.style.right = '10px';
          banner.style.backgroundColor = '#6f42c1';
          banner.style.border = 'none';
          banner.style.borderRadius = '6px';
          banner.style.padding = '10px 20px';
          banner.style.zIndex = '9997';
          banner.style.display = 'flex';
          banner.style.alignItems = 'center';
          banner.style.boxShadow = '0 2px 8px rgba(0,0,0,0.15)';
          banner.style.color = 'white';
          banner.style.fontFamily = 'Arial, sans-serif';
          banner.style.fontSize = '14px';
          banner.style.fontWeight = '600';
          banner.style.letterSpacing = '0.3px';
          banner.style.transition = 'all 0.3s ease';
          banner.innerHTML = `
            <i class="fas fa-clipboard-check" style="font-size: 16px; color: #ffffff; margin-right: 8px;"></i>
            <span style="color: #ffffff; text-shadow: 0 1px 1px rgba(0,0,0,0.1);">APTIDÕES/EXAMES: R$ 0,00</span>
          `;
          
          // Ajusta a posição baseada nos outros banners
          function ajustarPosicaoApt() {
            const banners = [
              document.getElementById('motorista-banner'),
              document.getElementById('total-treinamentos-banner')
            ];
            
            let topPosition = 10;
            
            // Percorre os banners e verifica quais estão visíveis
            banners.forEach(banner => {
              if (banner && window.getComputedStyle(banner).display !== 'none') {
                topPosition += banner.offsetHeight + 10;
              }
            });
            
            banner.style.top = `${topPosition}px`;
          }
          
          // Ajusta a posição inicial
          ajustarPosicaoApt();
          
          // Observa mudanças nos outros banners
          const banners = [
            document.getElementById('motorista-banner'),
            document.getElementById('total-treinamentos-banner')
          ];
          
          const observer = new MutationObserver(ajustarPosicaoApt);
          banners.forEach(banner => {
            if (banner) observer.observe(banner, { attributes: true, attributeFilter: ['style'] });
          });
          
          document.body.appendChild(banner);
        }
      }
      
      // Atualiza o banner de totais de Aptidões/Exames
      function updateAptExamesBanner(total) {
        let banner = document.getElementById('apt-exames-total-banner');
        if (!banner) {
          createAptExamesTotalBanner();
          banner = document.getElementById('apt-exames-total-banner');
        }
        const totalFormatado = formatarValor(total);
        banner.querySelector('span').textContent = `APTIDÕES/EXAMES: R$ ${totalFormatado}`;
      }

      // Função para atualizar os totais
      function atualizarTotais() {
        try {
          // Calcula os totais
          const totalAptidoes = calcularTotal(aptAptidoesSelecionadas);
          const totalExames = calcularTotal(aptExamesSelecionados);
          const totalGeral = totalAptidoes + totalExames;
          
          // Atualiza a variável global para o faturamento
          window.fatTotalExames = totalGeral;
          
          // Atualiza os totais na UI
          const totalAptElement = document.getElementById('apt-total-aptidoes');
          const totalExamElement = document.getElementById('apt-total-exames');
          
          if (totalAptElement) {
            totalAptElement.textContent = `Total: R$ ${formatarValor(totalAptidoes)}`;
          }
          
          if (totalExamElement) {
            totalExamElement.textContent = `Total: R$ ${formatarValor(totalExames)}`;
          }
          
          // Atualiza o banner de totais
          updateAptExamesBanner(totalGeral);
          
          // Atualiza o faturamento
          if (typeof fatAtualizarTotais === 'function') {
            fatAtualizarTotais();
          }
          
          return true;
        } catch (error) {
          console.error('Erro ao atualizar totais:', error);
          return false;
        }
      }
      
      // Função para atualizar a lista de itens selecionados
      function atualizarListaSelecionados(itens, container, tipo) {
        container.innerHTML = '';
        
        if (itens.length === 0) {
          container.innerHTML = '<div style="color: #6c757d; font-style: italic;">Nenhum item selecionado</div>';
          atualizarTotais();
          return;
        }
        
        itens.forEach(item => {
          const badge = document.createElement('div');
          badge.style.display = 'inline-flex';
          badge.style.alignItems = 'center';
          badge.style.backgroundColor = tipo === 'aptidao' ? '#e3f2fd' : '#e8f5e9';
          badge.style.color = tipo === 'aptidao' ? '#0d47a1' : '#1b5e20';
          badge.style.padding = '4px 10px';
          badge.style.borderRadius = '12px';
          badge.style.fontSize = '13px';
          badge.style.marginRight = '6px';
          badge.style.marginBottom = '4px';
          
          badge.innerHTML = `
            <div style="display: flex; flex-direction: column;">
              <div>${item.codigo} - ${item.nome}</div>
              ${item.valor ? `<div style="font-size: 0.9em; color: #555;">Valor: R$ ${item.valor}</div>` : ''}
            </div>
            <button class="btn-remover" style="background: none; border: none; color: inherit; margin-left: 6px; cursor: pointer; font-size: 14px; display: flex; align-items: center;">
              <i class="fas fa-times"></i>
            </button>
          `;
          
          // Adiciona evento para remover o item
          badge.querySelector('.btn-remover').addEventListener('click', (e) => {
            e.stopPropagation();
            const index = tipo === 'aptidao' 
              ? aptAptidoesSelecionadas.findIndex(a => a.codigo === item.codigo)
              : aptExamesSelecionados.findIndex(e => e.codigo === item.codigo);
            
            if (index !== -1) {
              if (tipo === 'aptidao') {
                aptAptidoesSelecionadas.splice(index, 1);
              } else {
                aptExamesSelecionados.splice(index, 1);
              }
              
              // Atualiza o checkbox correspondente
              const checkbox = document.querySelector(`#${tipo}-${item.codigo}`);
              if (checkbox) {
                checkbox.checked = false;
              }
              
              // Atualiza a lista de selecionados
              atualizarListaSelecionados(
                tipo === 'aptidao' ? aptAptidoesSelecionadas : aptExamesSelecionados,
                container,
                tipo
              );
            }
          });
          
          container.appendChild(badge);
        });
        
        // Atualiza os totais após atualizar a lista
        atualizarTotais();
      }
      
      // Função para renderizar as listas de checkboxes
      function renderizarCheckboxes() {
        // Salva os itens selecionados atuais
        const aptSelecionadas = [...aptAptidoesSelecionadas];
        const examesSelecionados = [...aptExamesSelecionados];
        
        // Limpa os containers
        if (checkboxContainerApt) {
          checkboxContainerApt.innerHTML = '';
          aptDadosAptidoes.forEach(item => {
            const checkbox = criarCheckbox(item, 'aptidao');
            // Marca como selecionado se estava na lista de selecionados
            if (aptSelecionadas.some(a => a.codigo === item.codigo)) {
              const input = checkbox.querySelector('input[type="checkbox"]');
              if (input) input.checked = true;
            }
            checkboxContainerApt.appendChild(checkbox);
          });
        }
        
        if (checkboxContainerExames) {
          checkboxContainerExames.innerHTML = '';
          aptDadosExames.forEach(item => {
            const checkbox = criarCheckbox(item, 'exame');
            // Marca como selecionado se estava na lista de selecionados
            if (examesSelecionados.some(e => e.codigo === item.codigo)) {
              const input = checkbox.querySelector('input[type="checkbox"]');
              if (input) input.checked = true;
            }
            checkboxContainerExames.appendChild(checkbox);
          });
        }
        
        // Atualiza as listas de selecionados
        atualizarListaSelecionados(aptAptidoesSelecionadas, selectedAptidoesContainer, 'aptidao');
        atualizarListaSelecionados(aptExamesSelecionados, selectedExamesContainer, 'exame');
      }
      
      // Função para abrir o modal de adição
      function abrirModalAdicionar(tipo) {
        modalTipoAtual = tipo;
        if (modal && modalTitle) {
          modalTitle.textContent = `Adicionar ${tipo === 'aptidao' ? 'Aptidão' : 'Exame'}`;
          modal.style.display = 'flex';
          if (inputCodigo) inputCodigo.value = '';
          if (inputNome) inputNome.value = '';
          const inputValor = document.getElementById('apt-novoValor');
          if (inputValor) inputValor.value = '';
          if (inputCodigo) inputCodigo.focus();
        }
      }
      
      // Função para fechar o modal
      function fecharModal() {
        if (modal) {
          modal.style.display = 'none';
        }
      }
      
      // Função para adicionar um novo item (aptidão ou exame)
      function adicionarNovoItem() {
        const codigo = inputCodigo ? inputCodigo.value.trim() : '';
        const nome = inputNome ? inputNome.value.trim() : '';
        const valor = document.getElementById('apt-novoValor') ? document.getElementById('apt-novoValor').value.trim() : '';
        
        if (!codigo || !nome) {
          alert('Preencha todos os campos obrigatórios');
          return;
        }
        
        // Valida o formato do valor (opcional, mas deve ser um número válido se preenchido)
        if (valor) {
          const valorNumerico = valor.replace(',', '.');
          if (isNaN(valorNumerico) || valorNumerico < 0) {
            alert('O valor deve ser um número válido');
            return;
          }
        }
        
        // Verifica se o código já existe
        const codigoExistente = [...aptDadosAptidoes, ...aptDadosExames]
          .some(item => item.codigo === codigo);
        
        if (codigoExistente) {
          alert('Já existe um item com este código');
          return;
        }
        
        // Cria o novo item com o valor formatado (se existir)
        const novoItem = { 
          codigo, 
          nome,
          valor: valor || '0,00' // Valor padrão se não informado
        };
        
        if (modalTipoAtual === 'aptidao') {
          aptDadosAptidoes.push(novoItem);
        } else {
          aptDadosExames.push(novoItem);
        }
        
        fecharModal();
        
        // Atualiza a lista de checkboxes para garantir consistência
        renderizarCheckboxes();
      }
      
      // Configura os eventos
      if (btnAddAptidao) {
        btnAddAptidao.addEventListener('click', () => abrirModalAdicionar('aptidao'));
      }
      
      if (btnAddExame) {
        btnAddExame.addEventListener('click', () => abrirModalAdicionar('exame'));
      }
      
      if (btnSalvar) {
        btnSalvar.addEventListener('click', adicionarNovoItem);
      }
      
      if (btnCancelar) {
        btnCancelar.addEventListener('click', fecharModal);
      }
      
      // Adiciona evento de tecla Enter nos campos do modal
      function setupEnterKeyHandler(element) {
        if (element) {
          element.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
              adicionarNovoItem();
            }
          });
        }
      }
      
      setupEnterKeyHandler(inputNome);
      setupEnterKeyHandler(inputCodigo);
      setupEnterKeyHandler(document.getElementById('apt-novoValor'));
      
      // Fecha o modal ao clicar fora
      if (modal) {
        modal.addEventListener('click', (e) => {
          if (e.target === modal) {
            fecharModal();
          }
        });
      }
      
      // Inicialização
      function init() {
        try {
          // Cria o banner de totais
          createAptExamesTotalBanner();
          
          // Renderiza as listas iniciais
          renderizarCheckboxes();
          
          // Função para abrir o modal de item personalizado
          function abrirModalItemPersonalizado(tipo) {
            const modal = document.getElementById('apt-modal');
            const modalTitle = document.getElementById('apt-modal-title');
            const itemCodigo = document.getElementById('apt-item-codigo');
            const itemNome = document.getElementById('apt-item-nome');
            const itemValor = document.getElementById('apt-item-valor');
            
            if (modal && modalTitle && itemCodigo && itemNome && itemValor) {
              // Configura o título do modal
              modalTitle.textContent = `Adicionar ${tipo === 'aptidao' ? 'Aptidão' : 'Exame'} Personalizado`;
              
              // Limpa os campos
              itemCodigo.value = '';
              itemNome.value = '';
              itemValor.value = '';
              
              // Configura o botão de salvar
              const btnSalvar = document.getElementById('apt-btnSalvarItem');
              if (btnSalvar) {
                // Remove event listeners antigos
                const newBtn = btnSalvar.cloneNode(true);
                btnSalvar.parentNode.replaceChild(newBtn, btnSalvar);
                
                // Adiciona novo event listener
                newBtn.onclick = function() {
                  const codigo = itemCodigo.value.trim();
                  const nome = itemNome.value.trim();
                  const valor = itemValor.value.trim();
                  
                  if (!codigo || !nome) {
                    alert('Por favor, preencha o código e o nome do item.');
                    return;
                  }
                  
                  // Cria o novo item
                  const novoItem = {
                    codigo,
                    nome,
                    valor: valor || '0,00'
                  };
                  
                  // Adiciona ao array apropriado
                  if (tipo === 'aptidao') {
                    aptDadosAptidoes.push(novoItem);
                    aptAptidoesSelecionadas.push({...novoItem});
                  } else {
                    aptDadosExames.push(novoItem);
                    aptExamesSelecionados.push({...novoItem});
                  }
                  
                  // Atualiza a interface
                  renderizarCheckboxes();
                  atualizarTotais();
                  
                  // Fecha o modal
                  modal.style.display = 'none';
                };
              }
              
              // Mostra o modal
              modal.style.display = 'flex';
              
              // Configura o botão de fechar
              const btnFechar = modal.querySelector('.apt-modal-close');
              if (btnFechar) {
                btnFechar.onclick = function() {
                  modal.style.display = 'none';
                };
              }
              
              // Fecha o modal ao clicar fora dele
              window.onclick = function(event) {
                if (event.target === modal) {
                  modal.style.display = 'none';
                }
              };
            }
          }
          
          // Configura os eventos do modal
          function configurarModal() {
            // Botão de adicionar aptidão
            const btnAddAptidao = document.getElementById('apt-btnAddAptidao');
            if (btnAddAptidao) {
              btnAddAptidao.addEventListener('click', () => abrirModalItemPersonalizado('aptidao'));
            }
            
            // Botão de adicionar exame
            const btnAddExame = document.getElementById('apt-btnAddExame');
            if (btnAddExame) {
              btnAddExame.addEventListener('click', () => abrirModalItemPersonalizado('exame'));
            }
          }
          
          configurarModal();
          
          // Atualiza os totais iniciais
          atualizarTotais();
          
          console.log('Componente de Aptidões e Exames inicializado com sucesso');
          return true;
        } catch (error) {
          console.error('Erro ao inicializar o componente de Aptidões e Exames:', error);
          return false;
        }
      }
      
      // Inicializa o componente quando o DOM estiver pronto
      if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
      } else {
        init();
      }
    }
    
    function initializeRiscosComponent() {
      console.log('Inicializando componente de riscos...');
      

      
      // Dados dos riscos (pode ser movido para um arquivo JSON separado posteriormente)
      const risksData = {
        ergonomicos: {
          name: "Riscos Ergonômicos",
          risks: [
            { code: "04.01.001", name: "Trabalho em posturas incômodas ou pouco confortáveis por longos períodos" },
            { code: "04.01.002", name: "Trabalhos com pacientes individuais" },
            { code: "04.01.003", name: "Trabalhos com pacientes individuais" },
            { code: "04.01.004", name: "Trabalhos com pacientes individuais" },
            { code: "04.01.005", name: "Trabalhos com pacientes individuais" },
            { code: "04.01.999", name: "Outros", isOther: true }
          ]
        },
        "acidentes-mecanicos": {
          name: "Riscos Acidentes - Mecânicos",
          risks: [
            { code: "01.01.001", name: "Quedas em mesmo nível" },
            { code: "01.01.002", name: "Quedas de altura" },
            { code: "01.01.003", name: "Queda de objetos" },
            { code: "01.01.999", name: "Outros", isOther: true }
          ]
        },
        fisicos: {
          name: "Riscos Físicos",
          risks: [
            { code: "03.01.001", name: "Exposição a ruído excessivo" },
            { code: "03.01.002", name: "Exposição a vibrações" },
            { code: "03.01.003", name: "Temperaturas extremas" },
            { code: "03.01.004", name: "Radiações ionizantes e não ionizantes" },
            { code: "03.01.999", name: "Outros", isOther: true }
          ]
        },
        quimicos: {
          name: "Riscos Químicos",
          risks: [
            { code: "02.01.001", name: "Exposição a produtos químicos" },
            { code: "02.01.002", name: "Inalação de vapores tóxicos" },
            { code: "02.01.003", name: "Contato com substâncias corrosivas" },
            { code: "02.01.999", name: "Outros", isOther: true }
          ]
        },
        biologicos: {
          name: "Riscos Biológicos",
          risks: [
            { code: "05.01.002", name: "Exposição a agentes biológicos" },
            { code: "05.01.003", name: "Contato com fluidos corporais" },
            { code: "05.01.006", name: "Manuseio de materiais contaminados" },
            { code: "05.01.999", name: "Outros", isOther: true }
          ]
        },
        outros: {
          name: "Outros Riscos",
          risks: [
            { code: "99.01.001", name: "Estresse ocupacional" },
            { code: "99.01.002", name: "Assédio moral" },
            { code: "99.01.003", name: "Jornada de trabalho excessiva" },
            { code: "99.01.999", name: "Outros", isOther: true }
          ]
        }
      };

      // Elementos do DOM
      const groupSelect = document.getElementById('group-select');
      const searchBox = document.getElementById('riscos-search-box');
      const searchResults = document.getElementById('riscos-search-results');
      const selectedRisksContainer = document.getElementById('selected-risks-container');
      const customRiskModal = document.getElementById('custom-risk-modal');
      const customRiskName = document.getElementById('custom-risk-name');
      const confirmCustomRiskBtn = document.getElementById('confirm-custom-risk');
      const cancelCustomRiskBtn = document.getElementById('cancel-custom-risk');
      
      console.log('Elementos do DOM:', { groupSelect, searchBox, searchResults, selectedRisksContainer, customRiskModal });
      
      // Variáveis de estado
      let selectedGroups = ['ergonomicos'];
      let selectedRisks = {};
      let currentOtherRisk = null;
      
      // Inicialização
      updateSearchPlaceholder();
      
      // Função para atualizar as seleções
      function updateSelectedGroups() {
        const checkboxes = document.querySelectorAll('#group-select-container input[type="checkbox"]');
        selectedGroups = Array.from(checkboxes)
          .filter(checkbox => checkbox.checked)
          .map(checkbox => checkbox.value);
        
        // Se nenhum estiver selecionado, mantém o primeiro selecionado
        if (selectedGroups.length === 0 && checkboxes.length > 0) {
          checkboxes[0].checked = true;
          selectedGroups = [checkboxes[0].value];
        }
        
        updateSearchPlaceholder();
        
        if (searchBox && searchBox.value) {
          performSearch(searchBox.value);
        }
      }
      
      // Event Listeners para os checkboxes
      const groupSelectContainer = document.getElementById('group-select-container');
      if (groupSelectContainer) {
        groupSelectContainer.addEventListener('change', function(e) {
          if (e.target.type === 'checkbox') {
            updateSelectedGroups();
          }
        });
        
        // Inicializa as seleções
        updateSelectedGroups();
      }
      if (searchBox) {
        searchBox.addEventListener('input', function(e) {
          console.log('Input event:', e.target.value);
          performSearch(e.target.value);
        });
        
        searchBox.addEventListener('focus', function() {
          console.log('Search box focused');
          if (this.value && this.value.trim() !== '') {
            performSearch(this.value);
          }
        });
      }
      
      if (confirmCustomRiskBtn) {
        confirmCustomRiskBtn.addEventListener('click', function() {
          const riskName = customRiskName.value.trim();
          if (riskName && currentOtherRisk) {
            addSelectedRisk(currentOtherRisk.code, riskName, currentOtherRisk.group);
            customRiskName.value = '';
            customRiskModal.style.display = 'none';
            currentOtherRisk = null;
          }
        });
      }
      
      if (cancelCustomRiskBtn) {
        cancelCustomRiskBtn.addEventListener('click', function() {
          customRiskName.value = '';
          customRiskModal.style.display = 'none';
          currentOtherRisk = null;
        });
      }
      
      // Fechar modal ao clicar fora
      window.addEventListener('click', function(event) {
        if (event.target === customRiskModal) {
          customRiskName.value = '';
          customRiskModal.style.display = 'none';
          currentOtherRisk = null;
        }
      });
      
      // Funções
      function updateSearchPlaceholder() {
        if (!searchBox) return;
        
        if (selectedGroups.length === 0) {
          searchBox.placeholder = "Selecione pelo menos um grupo para buscar";
          searchBox.disabled = true;
        } else {
          const groupNames = selectedGroups.map(group => {
            return risksData[group] ? risksData[group].name : group;
          });
          
          searchBox.placeholder = `Busca em: ${groupNames.join(', ')}`;
          searchBox.disabled = false;
        }
      }
      
      function performSearch(term) {
        console.log('performSearch called with term:', term);
        if (!searchResults) {
          console.error('searchResults element not found');
          return;
        }
        
        term = term ? term.toLowerCase().trim() : '';
        searchResults.innerHTML = '';
        
        if (selectedGroups.length === 0) {
          console.log('Nenhum grupo selecionado');
          searchResults.style.display = 'none';
          return;
        }
        
        if (term === '') {
          console.log('Termo de busca vazio');
          searchResults.style.display = 'none';
          return;
        }
        
        // Coletar todos os riscos dos grupos selecionados
        let allRisks = [];
        selectedGroups.forEach(group => {
          if (risksData[group]) {
            risksData[group].risks.forEach(risk => {
              allRisks.push({
                ...risk,
                group: group,
                groupName: risksData[group].name
              });
            });
          }
        });
        
        // Filtrar riscos pelo termo de busca e remover já selecionados
        const filteredRisks = allRisks.filter(risk => {
          return (risk.name.toLowerCase().includes(term) || 
                 risk.code.toLowerCase().includes(term)) &&
                 !selectedRisks[risk.code]; // Não mostrar riscos já selecionados
        });
        
        // Exibir resultados
        if (filteredRisks.length > 0) {
          filteredRisks.forEach(risk => {
            const riskElement = document.createElement('div');
            riskElement.className = 'risk-item';
            riskElement.innerHTML = `
              <div style="display: flex; flex-direction: column; width: 100%;">
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 2px;">
                  <span style="font-weight: 500; font-size: 0.85em;">${risk.code}</span>
                  <span style="font-size: 0.8em; color: #666;">${risk.groupName}</span>
                </div>
                <span class="risk-name" style="font-size: 0.9em;">${risk.name}</span>
              </div>
            `;
            
            riskElement.addEventListener('click', function() {
              console.log('Risco clicado:', risk);
              if (risk.isOther) {
                currentOtherRisk = risk;
                customRiskName.value = '';
                if (customRiskModal) customRiskModal.style.display = 'flex';
                if (customRiskName) customRiskName.focus();
              } else {
                addSelectedRisk(risk.code, risk.name, risk.group);
                if (searchResults) searchResults.style.display = 'none';
                if (searchBox) searchBox.value = '';
              }
            });
            
            searchResults.appendChild(riskElement);
          });
          
          searchResults.style.display = 'block';
        } else {
          const noResults = document.createElement('div');
          noResults.className = 'no-results';
          noResults.textContent = 'Nenhum risco encontrado';
          searchResults.appendChild(noResults);
          searchResults.style.display = 'block';
        }
      }
      
      function addSelectedRisk(code, name, group) {
        if (!selectedRisks[code]) {
          selectedRisks[code] = { name, group };
          updateSelectedRisksDisplay();
          // Atualiza a busca para remover o item adicionado
          if (searchBox && searchBox.value.trim() !== '') {
            performSearch(searchBox.value);
          }
        }
      }
      
      function updateSelectedRisksDisplay() {
        if (!selectedRisksContainer) return;
        
        selectedRisksContainer.innerHTML = '';
        
        // Se não houver riscos selecionados, exibe uma mensagem
        if (Object.keys(selectedRisks).length === 0) {
          const emptyMessage = document.createElement('div');
          emptyMessage.className = 'no-risks';
          emptyMessage.textContent = 'Nenhum risco selecionado';
          selectedRisksContainer.appendChild(emptyMessage);
          return;
        }
        
        // Agrupar riscos por categoria
        const risksByGroup = {};
        
        for (const [code, risk] of Object.entries(selectedRisks)) {
          const group = risk.group;
          if (!risksByGroup[group]) {
            risksByGroup[group] = [];
          }
          risksByGroup[group].push({ code, name: risk.name });
        }
        
        // Criar elementos agrupados
        for (const [group, risks] of Object.entries(risksByGroup)) {
          const groupName = risksData[group] ? risksData[group].name : group;
          
          const groupElement = document.createElement('div');
          groupElement.className = 'risk-group';
          
          const groupHeader = document.createElement('div');
          groupHeader.className = 'risk-group-header';
          groupHeader.textContent = groupName;
          
          const groupContent = document.createElement('div');
          groupContent.className = 'risk-group-content';
          
          risks.forEach(risk => {
            const riskElement = document.createElement('div');
            riskElement.className = 'selected-risk';
            riskElement.innerHTML = `
              <span style="font-size: 0.85em;">${risk.code} - ${risk.name}</span>
              <span class="remove-risk" data-code="${risk.code}" title="Remover" style="font-size: 0.9em;">×</span>
            `;
            groupContent.appendChild(riskElement);
          });
          
          groupElement.appendChild(groupHeader);
          groupElement.appendChild(groupContent);
          selectedRisksContainer.appendChild(groupElement);
        }
        
        // Adicionar eventos de remoção
        document.querySelectorAll('.remove-risk').forEach(btn => {
          btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const codeToRemove = this.getAttribute('data-code');
            delete selectedRisks[codeToRemove];
            updateSelectedRisksDisplay();
            // Atualiza a busca para mostrar o item removido, se aplicável
            if (searchBox && searchBox.value.trim() !== '') {
              performSearch(searchBox.value);
            }
          });
        });
      }
      
      // Fechar resultados ao clicar fora
      document.addEventListener('click', function(e) {
        if (searchBox && searchResults && !searchBox.contains(e.target) && !searchResults.contains(e.target)) {
          searchResults.style.display = 'none';
        }
      });
      
      // Inicializa os dropdowns do laudo
      initializeLaudoDropdowns();
    }
  </script>

  <!-- Script de Faturamento -->
  <script>
    // Inicializa o formatter de moeda
    const fatFormatter = new Intl.NumberFormat('pt-BR', {
      style: 'currency',
      currency: 'BRL',
    });

    // Adiciona estilos globais para o faturamento
    const faturamentoStyles = document.createElement('style');
    faturamentoStyles.id = 'faturamento-global-styles';
    faturamentoStyles.textContent = `
      /* Container principal do formulário */
      .fat-form-container {
        width: 100%;
        margin-bottom: 20px;
      }
      
      /* Linha do formulário */
      .fat-form {
        display: grid !important;
        grid-template-columns: 1fr 100px 150px 120px;
        gap: 15px !important;
        align-items: end;
        width: 100% !important;
      }
      
      /* Grupos de input */
      .fat-input-group {
        display: flex !important;
        flex-direction: column !important;
        width: 100% !important;
      }
      
      /* Ajustes específicos para cada coluna */
      .fat-descricao {
        grid-column: 1;
      }
      
      .fat-quantidade {
        grid-column: 2;
      }
      
      .fat-valor {
        grid-column: 3;
      }
      
      .fat-btn-group {
        grid-column: 4;
        padding-bottom: 2px; /* Alinha com os inputs */
      }
      
      /* Reset de estilos globais */
      #faturamento input[type="text"],
      #faturamento input[type="number"] {
        all: initial;
        font-family: inherit;
        font-size: 14px;
        line-height: 1.5;
        color: #495057;
      }
      
      /* Estilo dos inputs */
      .fat-form-container .fat-input {
        box-sizing: border-box;
        width: 100% !important;
        padding: 8px 12px !important;
        margin: 0 !important;
        border: 1px solid #ced4da !important;
        border-radius: 4px !important;
        background-color: #fff;
        transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
      }
      
      .fat-form-container .fat-input:focus {
        border-color: #80bdff !important;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25) !important;
      }
      
      .fat-input-group label {
        display: block;
        margin-bottom: 6px;
        font-weight: 500;
        color: #4a5568;
        font-size: 14px;
      }
      .fat-input {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        font-size: 14px;
        transition: all 0.2s ease;
        color: #2d3748;
      }
      .fat-input:focus {
        outline: none;
        border-color: #4299e1;
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
      }
      .fat-btn {
        background-color: #4299e1;
        color: white;
        border: none;
        border-radius: 6px;
        padding: 10px 16px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s ease;
      }
      .fat-btn:hover {
        background-color: #3182ce;
        transform: translateY(-1px);
      }
      .fat-btn i {
        font-size: 14px;
      }
      .fat-btn-secondary {
        background-color: #e2e8f0;
        color: #4a5568;
      }
      .fat-btn-secondary:hover {
        background-color: #cbd5e0;
      }
      .fat-header {
        font-size: 24px;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #e2e8f0;
      }
      .fat-section {
        background-color: white;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
      }
      .fat-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 20px;
      }
      .fat-totals {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #e2e8f0;
      }
      .fat-total-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 15px;
        color: #4a5568;
      }
      .fat-total-item:last-child {
        font-weight: 600;
        font-size: 16px;
        color: #2d3748;
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid #e2e8f0;
      }
      
      /* Estilo para o toast de notificação */
      .fat-toast {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background-color: #48bb78;
        color: white;
        padding: 12px 24px;
        border-radius: 4px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        z-index: 1000;
        transform: translateY(100px);
        opacity: 0;
        transition: all 0.3s ease;
      }
      
      .fat-toast.show {
        transform: translateY(0);
        opacity: 1;
      }
    `;
    document.head.appendChild(faturamentoStyles);

    // Variáveis de estado
    let fatTotalEPI = 0;
    let fatTotalExames = 0; // Será atualizado dinamicamente
    let fatTotalTreinamentos = 0; // Será atualizado dinamicamente

    // Função para adicionar produto
    window.fatAdicionarProduto = function() {
      const descricao = document.getElementById('fat-descricao')?.value.trim();
      const quantidade = parseInt(document.getElementById('fat-quantidade')?.value);
      const valorUnit = parseFloat(document.getElementById('fat-valorUnit')?.value);
  
      if (!descricao || isNaN(quantidade) || isNaN(valorUnit)) {
        alert('Preencha todos os campos corretamente.');
        return;
      }
  
      const valorTotal = quantidade * valorUnit;
      
      // Atualiza o total global de EPI/EPC
      window.fatTotalEPI = (window.fatTotalEPI || 0) + valorTotal;
      console.log('Produto adicionado. Novo total EPI/EPC:', window.fatTotalEPI);
  
      // Adiciona estilos CSS para a lista de produtos
      const style = document.createElement('style');
      if (!document.getElementById('fat-styles')) {
        style.id = 'fat-styles';
        style.textContent = `
          .fat-produto-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 12px 15px;
            color: #2d3748;
            font-size: 14px;
            border-bottom: 1px solid #e2e8f0;
            transition: all 0.2s ease;
            background-color: white;
            border-radius: 8px;
            margin-bottom: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
          }
          .fat-produto-item:hover {
            background-color: #f8fafc;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
          }
          .fat-produto-item > div {
            padding: 4px 8px;
          }
          .fat-produto-descricao {
            flex: 3;
            font-weight: 500;
            color: #1a365d;
          }
          .fat-produto-quantidade, .fat-produto-valor-unit, .fat-produto-total {
            flex: 1;
            text-align: center;
            color: #4a5568;
          }
          .fat-produto-total {
            font-weight: 600;
            color: #2b6cb0;
          }
          .fat-produto-acoes {
            flex: 0.8;
            text-align: center;
          }
          .btn-remover {
            background-color: #fff;
            color: #e53e3e;
            border: 1px solid #fed7d7;
            border-radius: 6px;
            padding: 6px 12px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: all 0.2s ease;
          }
          .btn-remover:hover {
            background-color: #feb2b2;
            color: #9b2c2c;
            transform: translateY(-1px);
          }
          .btn-remover i {
            font-size: 14px;
          }
        `;
        document.head.appendChild(style);
      }

      const linha = document.createElement('div');
      linha.className = 'fat-produto-item';
      
      const html = [
        `<div class="fat-produto-descricao">${descricao}</div>`,
        `<div class="fat-produto-quantidade">${quantidade}</div>`,
        `<div class="fat-produto-valor-unit">${fatFormatter.format(valorUnit)}</div>`,
        `<div class="fat-produto-total">${fatFormatter.format(valorTotal)}</div>`,
        '<div class="fat-produto-acoes">',
        `  <button class="btn-remover" onclick="fatRemoverProduto(this, ${valorTotal})">`,
        '    <i class="fas fa-trash-alt"></i> Remover',
        '  </button>',
        '</div>'
      ].join('');
      
      linha.innerHTML = html;
  
      // Adiciona à lista de produtos
      document.getElementById('fat-lista-produtos').appendChild(linha);

      // Limpa os campos
      document.getElementById('fat-descricao').value = '';
      document.getElementById('fat-quantidade').value = '1';
      document.getElementById('fat-valorUnit').value = '';
      
      // Atualiza os totais exibidos
      if (typeof window.fatAtualizarTotais === 'function') {
        window.fatAtualizarTotais();
      }
    };
  
    // Função para remover produto
    window.fatRemoverProduto = function(botao, valorTotal) {
      // Cria um elemento de confirmação estilizado
      const linha = botao.closest('.fat-produto-item');
      
      // Adiciona animação de destaque antes de remover
      linha.style.backgroundColor = '#fff5f5';
      linha.style.borderLeft = '3px solid #e53e3e';
      
      // Usa o SweetAlert2 para confirmar a remoção
      Swal.fire({
        title: 'Remover item',
        text: 'Deseja realmente remover este item?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e53e3e',
        cancelButtonColor: '#718096',
        confirmButtonText: 'Sim, remover',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          // Adiciona animação de saída
          linha.style.transition = 'all 0.3s ease';
          linha.style.opacity = '0';
          linha.style.transform = 'translateX(100%)';
          
          // Remove o item após a animação
          setTimeout(() => {
            linha.remove();
            
            // Atualiza o total global de EPI/EPC
            window.fatTotalEPI = Math.max(0, (window.fatTotalEPI || 0) - valorTotal);
            console.log('Produto removido. Novo total EPI/EPC:', window.fatTotalEPI);
            
            // Atualiza os totais exibidos
            if (typeof window.fatAtualizarTotais === 'function') {
              window.fatAtualizarTotais();
            }
            
            // Mostra feedback visual
            const toast = document.createElement('div');
            toast.className = 'fat-toast';
            toast.textContent = 'Item removido com sucesso';
            document.body.appendChild(toast);
            
            // Remove o toast após 3 segundos
            setTimeout(() => {
              toast.classList.add('show');
              setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 300);
              }, 2000);
            }, 100);
          }, 300);
        } else {
          // Remove os estilos de destaque se o usuário cancelar
          linha.style.backgroundColor = '';
          linha.style.borderLeft = '';
        }
      });
    };
  
    // Função para atualizar totais
    function fatAtualizarTotais() {
      try {
        console.log('=== Iniciando fatAtualizarTotais ===');
        
        // Garante que as variáveis globais estão definidas
        window.fatTotalEPI = window.fatTotalEPI || 0;
        window.fatTotalExames = window.fatTotalExames || 0;
        window.fatTotalTreinamentos = window.fatTotalTreinamentos || 0;
        
        // Inicializa o formatter se não existir
        if (!window.fatFormatter) {
          window.fatFormatter = new Intl.NumberFormat('pt-BR', {
            style: 'currency',
            currency: 'BRL',
          });
        }
        
        // Calcula o total geral
        const totalGeral = window.fatTotalEPI + window.fatTotalExames + window.fatTotalTreinamentos;
        
        console.log('Valores atuais dos totais:', {
          fatTotalExames: window.fatTotalExames,
          fatTotalTreinamentos: window.fatTotalTreinamentos,
          fatTotalEPI: window.fatTotalEPI,
          totalGeral: totalGeral,
          fatFormatter: window.fatFormatter ? 'Disponível' : 'Indisponível'
        });
        
        // Função auxiliar para atualizar o conteúdo de um elemento se ele existir
        const updateElementIfExists = (id, value) => {
          try {
            const element = document.getElementById(id);
            if (!element) {
              console.warn(`Elemento não encontrado: ${id}`);
              return false;
            }
            
            // Formata o valor
            let formattedValue;
            try {
              formattedValue = window.fatFormatter.format(value);
            } catch (e) {
              console.warn(`Erro ao formatar valor ${value} para ${id}, usando fallback`, e);
              formattedValue = `R$ ${value.toFixed(2).replace('.', ',')}`;
            }
            
            // Atualiza o elemento
            if (element.textContent !== formattedValue) {
              element.textContent = formattedValue;
              console.log(`Elemento ${id} atualizado para:`, formattedValue);
            }
            return true;
          } catch (error) {
            console.error(`Erro ao atualizar o elemento ${id}:`, error);
            return false;
          }
        };
        
        // Atualiza os totais individuais
        const elementsUpdated = [
          updateElementIfExists('fat-total-epi', window.fatTotalEPI),
          updateElementIfExists('fat-total-exames', window.fatTotalExames),
          updateElementIfExists('fat-total-treinamentos', window.fatTotalTreinamentos),
          updateElementIfExists('fat-total-geral', totalGeral)
        ];
        
        // Se algum elemento não foi encontrado, tenta atualizar o container completo
        if (elementsUpdated.some(updated => !updated)) {
          console.log('Alguns elementos não foram encontrados, tentando atualizar o container completo...');
          const totaisContainer = document.getElementById('fat-totais-container');
          if (totaisContainer) {
            console.log('Atualizando container de totais...');
            totaisContainer.innerHTML = `
              <div class="fat-total-item">
                <span>EPI/EPC:</span>
                <span id="fat-total-epi">${window.fatFormatter.format(window.fatTotalEPI)}</span>
              </div>
              <div class="fat-total-item">
                <span>Exames:</span>
                <span id="fat-total-exames">${window.fatFormatter.format(window.fatTotalExames)}</span>
              </div>
              <div class="fat-total-item">
                <span>Treinamentos:</span>
                <span id="fat-total-treinamentos">${window.fatFormatter.format(window.fatTotalTreinamentos)}</span>
              </div>
              <div class="fat-total-item" style="margin-top: 15px; padding-top: 15px; border-top: 2px solid #e2e8f0;">
                <span style="font-weight: 600; font-size: 16px; color: #2d3748;">Total Geral:</span>
                <span id="fat-total-geral" style="font-weight: 700; font-size: 18px; color: #2b6cb0;">
                  ${window.fatFormatter.format(totalGeral)}
                </span>
              </div>
            `;
          } else {
            console.warn('Container de totais não encontrado no DOM');
          }
        }
        
        // Dispara evento de atualização de totais
        const event = new CustomEvent('totaisAtualizados', { 
          detail: { 
            totalEPI: window.fatTotalEPI,
            totalExames: window.fatTotalExames,
            totalTreinamentos: window.fatTotalTreinamentos,
            totalGeral: totalGeral
          } 
        });
        document.dispatchEvent(event);
        
      } catch (error) {
        console.error('Erro ao atualizar totais:', error);
      }
      
      console.log('=== Finalizando fatAtualizarTotais ===');
    }

    // Torna a função disponível globalmente
    window.fatAtualizarTotais = fatAtualizarTotais;
    
    // Inicializa os eventos quando a página carregar
    document.addEventListener('DOMContentLoaded', function() {
      // Adiciona evento de tecla Enter nos campos de entrada
      const descricaoInput = document.getElementById('fat-descricao');
      const quantidadeInput = document.getElementById('fat-quantidade');
      const valorUnitInput = document.getElementById('fat-valorUnit');
      
      if (descricaoInput) {
        descricaoInput.addEventListener('keypress', function(e) {
          if (e.key === 'Enter') {
            e.preventDefault();
            quantidadeInput?.focus();
          }
        });
      }
      
      if (quantidadeInput) {
        quantidadeInput.addEventListener('keypress', function(e) {
          if (e.key === 'Enter') {
            e.preventDefault();
            valorUnitInput?.focus();
          }
        });
      }
      
      if (valorUnitInput) {
        valorUnitInput.addEventListener('keypress', function(e) {
          if (e.key === 'Enter') {
            e.preventDefault();
            window.fatAdicionarProduto();
          }
        });
      }
    });
  </script>
  
  <!-- Adiciona uma margem no final da página -->
  <div style="height: 50px;"></div>
  
</body>
</html