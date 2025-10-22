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
    
    /* Estilos para os resultados da busca de riscos */
    .risk-result {
      padding: 10px 15px;
      border-bottom: 1px solid #e2e8f0;
      cursor: pointer;
      transition: background-color 0.2s;
      display: flex;
      flex-direction: column;
    }
    
    .risk-result:hover {
      background-color: #f8fafc;
    }
    
    .risk-code {
      font-weight: 600;
      color: #1e40af;
      margin-bottom: 3px;
      font-size: 0.9em;
    }
    
    .risk-name {
      font-size: 0.95em;
      color: #1f2937;
      margin-bottom: 2px;
    }
    
    .risk-group {
      font-size: 0.8em;
      color: #6b7280;
      font-style: italic;
    }
    
    .no-results {
      padding: 15px;
      text-align: center;
      color: #6b7280;
      font-style: italic;
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
      <div class="tab" data-step="2"><i class="fas fa-user-md"></i> Profissionais da Medicina<div class="step-annotation">(Passo 3)</div></div>
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
      <div class="exam-card" data-exam="exame_laudo" style="margin-bottom: 10px;">
        <img src="./img/svg/exame_laudo.svg" alt="Exame com Laudo" width="60" height="60">
        <h3>Exame com Laudo</h3>
        <p>Exames que requerem análise detalhada</p>
      </div>
    </div>

    <!-- Mensagem de sucesso -->
    <div class="success-message" id="exame-gravado" style="display: none; position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background-color: #4CAF50; color: white; padding: 15px 25px; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.2); z-index: 1000; text-align: center;">
    </div>

    <div class="success-message" id="cadastro-rapido-empresa-gravada" style="display: none; position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background-color: #4CAF50; color: white; padding: 15px 25px; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.2); z-index: 1000; text-align: center;">
    </div>
  </div>

  <div class="navigation-buttons">
    <button class="btn-nav" id="prevBtn"><i class="fas fa-arrow-left"></i> Anterior</button>
    <button class="btn-nav" id="nextBtn">Próximo <i class="fas fa-arrow-right"></i></button>
  </div>
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
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

    // Estado global e funções auxiliares para persistir/restaurar ECP
    window.ecpState = window.ecpState || {
      empresa: null,    // { id, display, detalhesHtml }
      clinica: null,    // { id, display, detalhesHtml, nome }
      colaborador: null,// { id, display, detalhesHtml }
      cargo: null,      // { id, display, detalhesHtml }
      motorista: null,  // 'sim' | 'nao'
      profissionais: { coordenador: null, medico: null }
    };

    function bindEcpInputsOnce() {
      // Evita rebinds em cada troca de aba
      const tryBind = (id, tipo, resultadoId, chave) => {
        const el = document.getElementById(id);
        if (!el || el._ecpBound) return;
        el.addEventListener('keyup', () => buscarECP(tipo, id, resultadoId, chave));
        el.addEventListener('focus', () => buscarECP(tipo, id, resultadoId, chave));
        el._ecpBound = true;
      };
      tryBind('inputEmpresa', 'empresas', 'resultEmpresa', 'nome');
      tryBind('inputClinica', 'clinicas', 'resultClinica', 'nome');
      tryBind('inputColaborador', 'colaboradores', 'resultColaborador', 'nome');
      tryBind('inputCargo', 'cargos', 'resultCargo', 'titulo');

      // Rádios de motorista
      const truckIcon = document.querySelector('.blink-truck');
      const radios = document.querySelectorAll('input[name="motorista"]');
      radios.forEach(r => {
        if (r._ecpBound) return;
        r.addEventListener('change', () => {
          window.ecpState.motorista = r.value;
          if (truckIcon) {
            truckIcon.style.display = (r.value === 'sim' && r.checked) ? 'inline-block' : 'none';
          }
        });
        r._ecpBound = true;
      });
    }

    function applyEcpStateToUI() {
      try {
        const st = window.ecpState || {};
        // Inputs e detalhes
        if (st.empresa) {
          const inp = document.getElementById('inputEmpresa');
          const det = document.getElementById('detalhesEmpresa');
          if (inp) inp.value = st.empresa.display || '';
          if (det && st.empresa.detalhesHtml) { det.innerHTML = st.empresa.detalhesHtml; det.style.display = 'block'; }
        }
        if (st.clinica) {
          const inp = document.getElementById('inputClinica');
          const det = document.getElementById('detalhesClinica');
          if (inp) inp.value = st.clinica.display || '';
          if (det && st.clinica.detalhesHtml) { det.innerHTML = st.clinica.detalhesHtml; det.style.display = 'block'; }
        }
        if (st.colaborador) {
          const inp = document.getElementById('inputColaborador');
          const det = document.getElementById('detalhesColaborador');
          if (inp) inp.value = st.colaborador.display || '';
          if (det && st.colaborador.detalhesHtml) { det.innerHTML = st.colaborador.detalhesHtml; det.style.display = 'block'; }
        }
        if (st.cargo) {
          const inp = document.getElementById('inputCargo');
          const det = document.getElementById('detalhesCargo');
          if (inp) inp.value = st.cargo.display || '';
          if (det && st.cargo.detalhesHtml) { det.innerHTML = st.cargo.detalhesHtml; det.style.display = 'block'; }
        }
        // Profissionais resumidos dentro dos detalhes de Empresa/Clínica
        applyProfissionaisToEcpDetails();
        // Motorista
        if (st.motorista) {
          const radios = document.querySelectorAll('input[name="motorista"]');
          const truckIcon = document.querySelector('.blink-truck');
          radios.forEach(r => { r.checked = (r.value === st.motorista); });
          if (truckIcon) {
            truckIcon.style.display = (st.motorista === 'sim') ? 'inline-block' : 'none';
          }
        }
      } catch (e) { /* noop */ }
    }

    // Salva profissional selecionado em estado global
    function saveProfissional(tipo, data) {
      if (!window.ecpState) window.ecpState = {};
      if (!window.ecpState.profissionais) window.ecpState.profissionais = { coordenador: null, medico: null };
      const resolvedId = (data && (data.medico_id || data.id)) ? (data.medico_id || data.id) : null;
      const resolvedNome = data && (data.nome || data.nome_medico) ? (data.nome || data.nome_medico) : (typeof data === 'string' ? data : '');
      const resolvedCpf = data && (data.cpf || data.cpf_medico) ? (data.cpf || data.cpf_medico) : null;
      // medicoClinicaId: prioriza campo explicito; se não houver e "data.id" representa a relação, quem chama deve já ter enviado em medico_clinica_id
      const medicoClinicaId = data && (data.medico_clinica_id || data.relId || data.rel_id) ? (data.medico_clinica_id || data.relId || data.rel_id) : null;
      const payload = { id: resolvedId, nome: resolvedNome };
      if (resolvedCpf) payload.cpf = resolvedCpf;
      if (medicoClinicaId) payload.medicoClinicaId = Number(medicoClinicaId);
      if (tipo === 'coordenador') window.ecpState.profissionais.coordenador = payload;
      if (tipo === 'medico') {
        window.ecpState.profissionais.medico = payload;
        debugger;
        // Se tivermos IDs do médico e da clínica, associa no backend
        try {
          const clinicaId = window.ecpState && window.ecpState.clinica ? window.ecpState.clinica.id : null;
          if (payload.id && clinicaId) {
            associateMedicoClinica(payload.id, clinicaId);
          }
          // Se já tivermos o ID da relação médico_clínica na própria seleção, grava no KIT via função existente
          if (payload.medicoClinicaId && typeof window.grava_medico_clinica_kit === 'function') {
            window.grava_medico_clinica_kit({ id: Number(payload.medicoClinicaId) });
          }
        } catch (e) { /* noop */ }
      }
      // Reflete no ECP
      try { applyProfissionaisToEcpDetails(); } catch (e) { /* noop */ }
      // Atualiza UI da própria aba Médicos (chips) — exceto para médico emitente, que usa card detalhado
      try { if (tipo !== 'medico') renderResultadoProfissional(tipo); } catch (e) { /* noop */ }
      // Dispara evento para possíveis persistências externas
      try { document.dispatchEvent(new CustomEvent('profissionalChanged', { detail: { tipo, profissional: payload } })); } catch (e) { /* noop */ }
    }

    // Associa médico à clínica no backend (se IDs válidos)
    async function associateMedicoClinica(medicoId, clinicaId) {
      try {
        debugger;
        const resp = await fetch('api/add/medico_clinica.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ medicos: [Number(medicoId)], clinica_id: Number(clinicaId) })
        });
        const data = await resp.json().catch(() => ({}));
        if (!resp.ok || (data && data.status === 'error')) {
          console.warn('Falha ao associar médico à clínica:', data && data.message ? data.message : resp.statusText);
          return false;
        }
        console.log('Médico associado à clínica com sucesso:', data);
        // Se a resposta trouxer o ID da relação, grava no KIT
        if (data && data.data && data.data.medico_clinica_id) {
          window.grava_medico_clinica_kit({ id: Number(data.data.medico_clinica_id) });
        }
        return true;
      } catch (err) {
        console.error('Erro ao associar médico à clínica:', err);
        return false;
      }
    }

    // Remove profissional selecionado (limpa estado e UI) e notifica
    function removeProfissional(tipo) {
      if (!window.ecpState) return;
      if (!window.ecpState.profissionais) return;
      if (tipo === 'coordenador') window.ecpState.profissionais.coordenador = null;
      if (tipo === 'medico') window.ecpState.profissionais.medico = null;
      // Limpa input
      const inputId = tipo === 'coordenador' ? 'inputCoordenador' : 'inputMedico';
      const resId = tipo === 'coordenador' ? 'resultadoCoordenador' : 'resultadoMedico';
      const inp = document.getElementById(inputId);
      if (inp) inp.value = '';
      const res = document.getElementById(resId);
      if (res) res.innerHTML = '';
      // Reflete nas seções de ECP
      try { applyProfissionaisToEcpDetails(); } catch (e) { /* noop */ }
      // Notifica alteração para possíveis gravações no kit
      try { document.dispatchEvent(new CustomEvent('profissionalRemoved', { detail: { tipo } })); } catch (e) { /* noop */ }
    }

    // Renderiza chip do profissional no container de resultado
    function renderResultadoProfissional(tipo) {
      const resId = tipo === 'coordenador' ? 'resultadoCoordenador' : 'resultadoMedico';
      const st = window.ecpState || {};
      const prof = (st.profissionais || {})[tipo];
      const container = document.getElementById(resId);
      if (!container) return;
      container.innerHTML = '';
      if (!prof || !prof.nome) return;
      const chip = document.createElement('div');
      chip.style.display = 'inline-flex';
      chip.style.alignItems = 'center';
      chip.style.gap = '8px';
      chip.style.background = '#e2e8f0';
      chip.style.color = '#0f172a';
      chip.style.borderRadius = '999px';
      chip.style.padding = '6px 10px';
      chip.style.marginTop = '6px';
      chip.style.fontSize = '14px';
      const cpfHtml = prof.cpf ? `<small style="color:#334155;opacity:.8; margin-left:6px;">CPF: ${prof.cpf}</small>` : '';
      chip.innerHTML = `<i class="fas fa-user-md" style="color:#2563eb"></i> <span>${prof.nome}</span>${cpfHtml}`;
      const btn = document.createElement('button');
      btn.type = 'button';
      btn.setAttribute('aria-label', 'Remover');
      btn.style.border = 'none';
      btn.style.background = 'transparent';
      btn.style.cursor = 'pointer';
      btn.style.color = '#334155';
      btn.innerHTML = '<i class="fas fa-times"></i>';
      btn.addEventListener('click', () => removeProfissional(tipo));
      chip.appendChild(btn);
      container.appendChild(chip);
    }

// Remove profissional selecionado (limpa estado e UI) e notifica
function removeProfissional(tipo) {
  if (!window.ecpState) return;
  if (!window.ecpState.profissionais) return;
  if (tipo === 'coordenador') window.ecpState.profissionais.coordenador = null;
  if (tipo === 'medico') window.ecpState.profissionais.medico = null;
  // Limpa input
  const inputId = tipo === 'coordenador' ? 'inputCoordenador' : 'inputMedico';
  const resId = tipo === 'coordenador' ? 'resultadoCoordenador' : 'resultadoMedico';
  const inp = document.getElementById(inputId);
  if (inp) inp.value = '';
  const res = document.getElementById(resId);
  if (res) res.innerHTML = '';
  // Reflete nas seções de ECP
  try { applyProfissionaisToEcpDetails(); } catch (e) { /* noop */ }
  // Notifica alteração para possíveis gravações no kit
  try { document.dispatchEvent(new CustomEvent('profissionalRemoved', { detail: { tipo } })); } catch (e) { /* noop */ }
}

// Renderiza chip do profissional no container de resultado
function renderResultadoProfissional(tipo) {
  const resId = tipo === 'coordenador' ? 'resultadoCoordenador' : 'resultadoMedico';
  const st = window.ecpState || {};
  const prof = (st.profissionais || {})[tipo];
  const container = document.getElementById(resId);
  if (!container) return;
  container.innerHTML = '';
  if (!prof || !prof.nome) return;
  const chip = document.createElement('div');
  chip.style.display = 'inline-flex';
  chip.style.alignItems = 'center';
  chip.style.gap = '8px';
  chip.style.background = '#e2e8f0';
  chip.style.color = '#0f172a';
  chip.style.borderRadius = '999px';
  chip.style.padding = '6px 10px';
  chip.style.marginTop = '6px';
  chip.style.fontSize = '14px';
  const cpfHtml = prof.cpf ? `<small style="color:#334155;opacity:.8; margin-left:6px;">CPF: ${prof.cpf}</small>` : '';
  chip.innerHTML = `<i class="fas fa-user-md" style="color:#2563eb"></i> <span>${prof.nome}</span>${cpfHtml}`;
  const btn = document.createElement('button');
  btn.type = 'button';
  btn.setAttribute('aria-label', 'Remover');
  btn.style.border = 'none';
  btn.style.background = 'transparent';
  btn.style.cursor = 'pointer';
  btn.style.color = '#334155';
  btn.innerHTML = '<i class="fas fa-times"></i>';
  btn.addEventListener('click', () => removeProfissional(tipo));
  chip.appendChild(btn);
  container.appendChild(chip);
}

    // Restaura os campos da aba Médicos a partir do estado salvo
    function applyMedicosStateToUI() {
      try {
        const st = window.ecpState || {};
        const prof = st.profissionais || {};
        // Restaura inputs
        const inpCoord = document.getElementById('inputCoordenador');
        if (inpCoord) inpCoord.value = (prof.coordenador && prof.coordenador.nome) ? prof.coordenador.nome : '';
        const inpMed = document.getElementById('inputMedico');
        if (inpMed) inpMed.value = (prof.medico && prof.medico.nome) ? prof.medico.nome : '';

        // Renderiza chip do coordenador
        try { renderResultadoProfissional('coordenador'); } catch (e) { /* noop */ }

        // Renderiza cartão/chip do médico
        const areaMed = document.getElementById('resultadoMedico');
        if (areaMed) areaMed.innerHTML = '';
        if (areaMed && prof.medico && prof.medico.nome) {
          if (typeof window.renderizarPessoa === 'function') {
            // Remove prefixos repetidos (Dr./Dra.) para evitar "Dr. Dra. Nome"
            const nomeBruto = String(prof.medico.nome || '').trim();
            const nomeSemTitulo = nomeBruto.replace(/^(?:\s*(?:Dr\.?|Dra\.?))+\s+/i, '').trim();
            const payload = {
              id: (prof.medico.medicoClinicaId || prof.medico.id || null),
              nome: nomeSemTitulo
            };
            if (prof.medico.cpf) {
              payload.cpf = prof.medico.cpf;
              payload.cpf_medico = prof.medico.cpf; // compat para renderizadores que esperam outro campo
            }
            try { window.renderizarPessoa('medico', payload, areaMed); } catch (e) { /* fallback abaixo */ }
          }
          if (!areaMed.hasChildNodes()) {
            try { renderResultadoProfissional('medico'); } catch (e) { /* noop */ }
          }
        }
      } catch (e) { /* noop */ }
    }

      // Delegação de clique nas listas de autocomplete (se existirem)
      const bindAuto = (listaId, inputId, tipo) => {
        const lista = document.getElementById(listaId);
        const input = document.getElementById(inputId);
        if (!lista || lista._mdAutoBound) return;
        lista.addEventListener('click', (ev) => {
          debugger;
          const item = ev.target.closest('[data-medico-id], [data-medico-clinica-id], [data-id], [data-nome-medico], [data-nome]') || ev.target.closest('div,li');
          if (!item) return;
          let medicoId = null;
          let relId = null;
          if (item.dataset) {
            // medicoId específico, se presente
            if (item.dataset.medicoId) medicoId = Number(item.dataset.medicoId);
            // Caso a lista traga tanto medico_id quanto id, trate id como relação
            if (item.dataset.medicoClinicaId) relId = Number(item.dataset.medicoClinicaId);
            else if (medicoId && item.dataset.id) relId = Number(item.dataset.id);
            else if (!medicoId && item.dataset.id) medicoId = Number(item.dataset.id);
          }
          let nome = '';
          if (item.dataset) {
            nome = item.dataset.nomeMedico || item.dataset.nome || '';
          }
          const cpf = (item.dataset && (item.dataset.cpf || item.dataset.cpfMedico || item.dataset.cpf_medico)) ? (item.dataset.cpf || item.dataset.cpfMedico || item.dataset.cpf_medico) : '';
          if (!nome) nome = (item.textContent || '').trim();
          if (!nome) return;
          if (input) input.value = nome;
          // Salva conforme o tipo selecionado
          try {
            if (tipo === 'medico' && typeof window.grava_medico_clinica_kit === 'function') {
              window.grava_medico_clinica_kit({
                id: relId || medicoId || null,
                medico_id: medicoId || null,
                medico_clinica_id: relId || null,
                nome,
                cpf
              });
            }
            if (tipo === 'coordenador' && typeof window.grava_medico_coordenador_kit === 'function') {
              window.grava_medico_coordenador_kit({
                id: medicoId || null,
                medico_id: medicoId || null,
                nome,
                cpf
              });
            }
            // Atualiza estado global e UI imediatamente
            try {
              const payload = { id: medicoId || null, medico_id: medicoId || null, nome, cpf };
              if (relId) payload.medico_clinica_id = relId;
              saveProfissional(tipo, payload);
              applyMedicosStateToUI();
            } catch(e) { /* noop */ }
          } catch (e) { /* noop */ }
          // Limpa a lista de autocomplete após a seleção
          try { lista.innerHTML = ''; } catch (e) {}
        });
        // marca para não rebindar
        lista._mdAutoBound = true;
      }
      // Tenta (re)ligar os handlers das listas de profissionais quando o DOM da aba existir
      function bindMedicosInputsOnce() {
        try {
          // Chamar bindAuto é seguro e idempotente: ele verifica _mdAutoBound em cada lista
          bindAuto('listaCoordenador', 'inputCoordenador', 'coordenador');
          bindAuto('listaMedico', 'inputMedico', 'medico');
        } catch(e) { /* noop */ }
      }
      bindAuto('listaCoordenador', 'inputCoordenador', 'coordenador');
      bindAuto('listaMedico', 'inputMedico', 'medico');
    
    function applyMedicosHeaderFromEcp() {
      try {
        const st = window.ecpState || {};
        const el = document.getElementById('exibi-clinica-selecionada');
        if (el && st.clinica && (st.clinica.nome || st.clinica.display)) {
          el.textContent = st.clinica.nome || st.clinica.display || '';
        }
      } catch (e) { /* noop */ }
    }

    function repopular_empresa() {
          debugger;

          // Verifica se os dados da empresa foram carregados
          const itemObj = window.kit_empresa;
          const detalhes = document.getElementById('detalhesEmpresa');

          if (!detalhes) {
            console.warn("Elemento 'detalhesEmpresa' não encontrado na página.");
            return;
          }

          if (!itemObj) {
            console.warn("Nenhum dado de empresa encontrado em window.kit_empresa.");
            detalhes.style.display = 'none';
            return;
          }

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

            console.log('Empresa repopulada (exibida):', itemObj.nome);
          } else {
            detalhes.style.display = 'none';
            console.warn("Os dados da empresa não possuem nome ou CNPJ.");
          }
        }

//        function repopular_dados_clinica(inputId, chave) {
//         debugger;
//   const resultEl = document.getElementById(inputId);

//   // Verifica se window.kit_clinica tem dados válidos
//   if (window.kit_clinica && typeof window.kit_clinica === 'object' && Object.keys(window.kit_clinica).length > 0) {
//     const item = window.kit_clinica;

//     if (item.cbo) {
//               displayText = `${item[chave]} (CBO: ${item.cbo})`;
//             } else if (item.cpf) {
//               displayText = `${item[chave]} (CPF: ${item.cpf})`;
//             } else if (item.nome_fantasia) {
//               displayText = item.nome_fantasia;
//             } else {
//               displayText = item[chave] || 'Sem nome';
//             }

//     // Monta o HTML com o mesmo estilo solicitado
//     const html = `
//       <div class="ecp-result-item" 
//                    onclick="selecionarECP('${inputId}', '${resultadoId}', ${JSON.stringify(item).replace(/"/g, '&quot;')}, '${chave}')"
//                    style="cursor: pointer; padding: 8px 12px; border-bottom: 1px solid #eee;">
//                 ${displayText}
//                 ${item.cnpj ? `<div style="font-size: 0.8em; color: #666;">CNPJ: ${item.cnpj}</div>` : ''}
//                 ${item.cpf ? `<div style="font-size: 0.8em; color: #666;">CPF: ${item.cpf}</div>` : ''}
//               </div>
//     `;

//     // Exibe na tela
//     resultEl.innerHTML = html;
//     resultEl.style.display = 'block';
//   } else {
//     // Caso não tenha dados → limpa e esconde
//     resultEl.innerHTML = '';
//     resultEl.style.display = 'none';
//   }
// }

function repopular_dados_clinica(tipo, inputId, resultadoId, chave) {
  debugger;
  const resultEl = document.getElementById(resultadoId);

  // Garante que é do tipo "clinicas" e que há dados válidos
  if (
    tipo === 'clinicas' &&
    window.kit_clinica &&
    typeof window.kit_clinica === 'object' &&
    Object.keys(window.kit_clinica).length > 0
  ) {
    const detalhes = document.getElementById('detalhesClinica'); 
    const item = window.kit_clinica;

    detalhes.className = 'ecp-details';
    detalhes.style.display = 'block';
    detalhes.innerHTML = `
    <strong>${item.nome_fantasia || ''}</strong>
    <div>${item.cnpj || ''}</div>
    `;

    // if (item.cbo) {
    //           displayText = `${item[chave]} (CBO: ${item.cbo})`;
    //         } else if (item.cpf) {
    //           displayText = `${item[chave]} (CPF: ${item.cpf})`;
    //         } else if (item.nome_fantasia) {
    //           displayText = item.nome_fantasia;
    //         } else {
    //           displayText = item[chave] || 'Sem nome';
    //         }
    

    // // Monta o HTML com o mesmo estilo solicitado
    // const html = `
    //   <div class="ecp-result-item" 
    //                onclick="selecionarECP('${inputId}', '${resultadoId}', ${JSON.stringify(item).replace(/"/g, '&quot;')}, '${chave}')"
    //                style="cursor: pointer; padding: 8px 12px; border-bottom: 1px solid #eee;">
    //             ${displayText}
    //             ${item.cnpj ? `<div style="font-size: 0.8em; color: #666;">CNPJ: ${item.cnpj}</div>` : ''}
    //             ${item.cpf ? `<div style="font-size: 0.8em; color: #666;">CPF: ${item.cpf}</div>` : ''}
    //           </div>
    // `;

    // // Exibe na tela
    // resultEl.innerHTML = html;
    // resultEl.style.display = 'block';
  } else {
    // Se não houver dados válidos, limpa e esconde
    resultEl.innerHTML = '';
    resultEl.style.display = 'none';
  }
}

let resposta_empresa_pessoa = null;
let resposta_clinica_pessoa = null;
window.resposta_cargo_pessoa = null;

async function repopular_dados_pessoa() {
  debugger;
  
  try {
    // if (!itemObj || !itemObj.id) {
    //   console.warn("❌ Objeto da pessoa inválido:", itemObj);
    //   return;
    // }

    // 🔹 Requisita os kits e guarda globalmente
    window.kits = await requisitarKits(window.kit_tipo_exame.pessoa_id);
    const resposta_kits = window.kits || [];

    

    // 🔹 Requisita dados da empresa (se houver)
    if (window.kit_tipo_exame.empresa_id) {
      resposta_empresa_pessoa = await requisitarEmpresaPessoa(window.kit_tipo_exame.empresa_id);
    }

    // 🔹 Requisita dados da clínica (se houver)
    if (window.kit_tipo_exame.clinica_id) {
      resposta_clinica_pessoa = await requisitarClinicaPessoa(window.kit_tipo_exame.clinica_id);
    }

    if(window.kit_tipo_exame.pessoa_id){
      window.resposta_cargo_pessoa = await requisitarDadosCargo(window.kit_tipo_exame.pessoa_id);
    }

    // 🔹 Monta estrutura de kits por CPF
    let kitsColaboradores = {};

    if (window.kit_pessoa?.cpf && resposta_kits.length > 0) {
      const cpfLimpo = window.kit_pessoa.cpf.replace(/[.\-]/g, "");

      kitsColaboradores[cpfLimpo] = [];

      resposta_kits.forEach(kit => {
        kitsColaboradores[cpfLimpo].push({
          id: kit.id || "",
          data: kit.data_geracao || "",
          empresa: resposta_empresa_pessoa?.nome || "Não informado",
          colaborador: window.kit_pessoa.nome || "Não informado",
          status: kit.status || "Não informado",
          tipo_exame: kit.tipo_exame,
          clinica: resposta_clinica_pessoa?.nome_fantasia || "Não informado"
        });
      });
    }

    // 🔹 Atualiza detalhes do colaborador e exibe kits
    const detalhes = document.getElementById('detalhesColaborador');
    if (window.kit_pessoa.nome || window.kit_pessoa.cpf) {

      detalhes.className = 'ecp-details';
      detalhes.style.display = 'block';

      let html = `
        <div style="background: white; padding: 1rem; border-radius: 0.5rem; border: 1px solid #f3f4f6; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);">
          <div style="display: flex; align-items: center; margin-bottom: 0.75rem;">
            <div style="width: 3rem; height: 3rem; border-radius: 9999px; background-color: #dbeafe; display: flex; align-items: center; justify-content: center; margin-right: 0.75rem; flex-shrink: 0;">
              <i class="fas fa-user" style="color: #2563eb; font-size: 1.25rem;"></i>
            </div>
            <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0; line-height: 1.2;">
              ${window.kit_pessoa.nome || 'Nome não informado'}
            </h3>
          </div>
          <div style="margin-left: 3.75rem;">
            <div style="display: flex; align-items: center; margin-bottom: 0.25rem; font-size: 0.875rem; color: #6b7280;">
              <i class="far fa-id-card" style="margin-right: 0.375rem; color: #9ca3af; width: 1rem; text-align: center;"></i>
              <span>${window.kit_pessoa.cpf ? window.kit_pessoa.cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4') : 'CPF não informado'}</span>
            </div>
            ${window.resposta_cargo_pessoa.titulo_cargo ? `
            <div style="display: flex; align-items: center; font-size: 0.875rem; color: #6b7280;">
              <i class="fas fa-briefcase" style="margin-right: 0.375rem; color: #9ca3af; width: 1rem; text-align: center;"></i>
              <span>${window.resposta_cargo_pessoa.titulo_cargo}</span>
            </div>` : ''}
          </div>
        </div>
      `;

      const cpf = window.kit_pessoa.cpf ? window.kit_pessoa.cpf.replace(/[^\d]/g, '') : '';
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
        const kitsOrdenados = [...kitsDoColaborador].sort((a, b) =>
          new Date(b.data.split('/').reverse().join('-')) - new Date(a.data.split('/').reverse().join('-'))
        );

        const kitsParaExibir = kitsOrdenados.slice(0, 5);

        html += `
          <div style="display: grid; gap: 0.75rem;">
            ${kitsParaExibir.map(kit => {
              const statusConfig = {
                'FINALIZADO': { bg: '#dcfce7', text: '#166534', icon: 'fa-check-circle' },
                'RASCUNHO': { bg: '#fef3c7', text: '#92400e', icon: 'fa-clock' },
                'default': { bg: '#fee2e2', text: '#991b1b', icon: 'fa-times-circle' }
              };
              const status = kit.status || 'RASCUNHO';
              const config = statusConfig[status] || statusConfig.default;

              return `
                <div style="background: white; padding: 1rem; border: 1px solid #e5e7eb; border-radius: 0.5rem; cursor: pointer; transition: all 0.2s ease;"
                     onclick="abrirDetalhesKit(${JSON.stringify(kit).replace(/"/g, '&quot;')}, '${window.kit_pessoa.nome ? window.kit_pessoa.nome.replace(/'/g, "\\'") : 'Colaborador'}','${window.resposta_cargo_pessoa.titulo_cargo}')">
                  <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div style="flex: 1; min-width: 0;">
                      <div style="display: flex; align-items: center; margin-bottom: 0.25rem;">
                        <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 500; background-color: ${config.bg}; color: ${config.text};">
                          <i class="fas ${config.icon} mr-1" style="margin-inline: 5px;"></i>${status}
                        </span>
                      </div>
                      <div style="font-size: 0.875rem; color: #4b5563; margin-bottom: 0.25rem;">
                        <span style="font-weight: 500;">${kit.empresa || 'Sem empresa'}</span>
                        ${kit.cargo ? `<span style="margin: 0 0.25rem; color: #d1d5db;">•</span><span>${kit.cargo}</span>` : ''}
                      </div>
                      ${kit.tipo_exame ? `<div style="font-size: 0.813rem; color: #374151; font-weight: 500; margin-top: 0.15rem;">🧾 ${kit.tipo_exame}</div>` : ''}
                    </div>
                    <div style="display: flex; align-items: center; margin-left: 0.5rem; color: #9ca3af; font-size: 0.875rem; white-space: nowrap;">
                      <i class="far fa-calendar-alt mr-1"></i>${new Date(kit.data).toLocaleDateString('pt-BR')}
                    </div>
                  </div>
                </div>`;
            }).join('')}
          </div>
        `;

        if (kitsDoColaborador.length > 5) {
          html += `
            <div style="margin-top: 1rem; text-align: center;">
              <button style="background: none; border: none; color: #3b82f6; font-size: 0.875rem; cursor: pointer; display: inline-flex; align-items: center;"
                      onclick="this.parentElement.previousElementSibling.querySelectorAll('div').forEach(el => el.style.display = 'block'); this.remove()">
                <i class="fas fa-chevron-down mr-1"></i>
                Mostrar mais ${kitsDoColaborador.length - 5} kits
              </button>
            </div>`;
        }
      } else {
        html += `
          <div style="text-align: center; padding: 1.5rem 1rem; background-color: #f9fafb; border-radius: 0.5rem; border: 1px dashed #e5e7eb; margin-top: 0.5rem;">
            <i class="fas fa-inbox" style="font-size: 1.5rem; color: #9ca3af;"></i>
            <p style="font-size: 0.875rem; color: #6b7280; margin-top: 0.5rem; margin-bottom: 0;">Nenhum kit encontrado para este colaborador</p>
          </div>`;
      }

      html += `</div>`;
      detalhes.innerHTML = html;
    } else {
      detalhes.style.display = 'none';
    }

  } catch (e) {
    console.error("⚠️ Erro ao repopular dados da pessoa:", e);
  }
}

function repopular_dados_cargo() {
  debugger;
  const detalhes = document.getElementById('detalhesCargo');
  const itemObj = window.kit_cargo;

  if (detalhes) {
    if (itemObj && (itemObj.titulo_cargo || itemObj.codigo_cargo)) {
      detalhes.className = 'ecp-details';
      detalhes.style.display = 'block';
      detalhes.innerHTML = `
        <div style="background: white; padding: 1rem; border-radius: 0.5rem; border: 1px solid #e5e7eb; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);">
          <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem;">
            <h3 style="font-size: 1rem; font-weight: 600; color: #111827; margin: 0; line-height: 1.2;">
              ${itemObj.titulo_cargo || 'Cargo não especificado'}
            </h3>
            ${itemObj.codigo_cargo ? `
              <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.5rem; border-radius: 0.25rem; 
                        font-size: 0.75rem; font-weight: 500; background-color: #e0f2fe; color: #0369a1;">
                CBO: ${itemObj.codigo_cargo}
              </span>
            ` : ''}
          </div>
          ${itemObj.descricao_cargo ? `
            <div style="font-size: 0.875rem; color: #4b5563; line-height: 1.5; margin-top: 0.75rem; padding-top: 0.75rem; border-top: 1px solid #f3f4f6;">
              <h4 style="font-size: 0.875rem; font-weight: 600; color: #374151; margin: 0 0 0.5rem 0;">Descrição:</h4>
              <p style="margin: 0;">${itemObj.descricao_cargo}</p>
            </div>
          ` : ''}
        </div>
      `;
    } else {
      detalhes.style.display = 'none';
    }
  }
}

function repopular_dados_motorista() {
  debugger;
  // Obtém o valor do motorista salvo em window.kit_tipo_exame
  const motoristaValue = window.kit_tipo_exame?.motorista;

  // Verifica se o valor é "SIM"
  const isMotorista = motoristaValue === "SIM";

  console.log("Repopulando dados do motorista:", motoristaValue);

  // Atualiza o estado global do app (se existir)
  if (typeof appState !== "undefined") {
    appState.motorista = isMotorista;
  }

  // Exibe ou oculta o banner de motorista
  const motoristaBanner = document.getElementById('motorista-banner');
  if (motoristaBanner) {
    motoristaBanner.style.display = isMotorista ? 'flex' : 'none';
  }

  // Atualiza o ícone do caminhão
  const truckIcon = document.querySelector('input[name="motorista"][value="sim"] + span .fa-truck-moving');
  if (truckIcon) {
    truckIcon.style.display = isMotorista ? 'inline-block' : 'none';
  }

  // 🔹 Marca o rádio "Sim" ou "Não"
  const radioSim = document.querySelector('input[name="motorista"][value="sim"]');
  const radioNao = document.querySelector('input[name="motorista"][value="nao"]');

  if (radioSim && radioNao) {
    if (isMotorista) {
      radioSim.checked = true;
      radioNao.checked = false;
    } else {
      radioSim.checked = false;
      radioNao.checked = true;
    }
  }
}

  function repopular_dados_medico_coordenador() {
    debugger;
  const dados = window.kit_medico_coordenador;

  if (!dados || Object.keys(dados).length === 0) {
    console.warn('Nenhum dado encontrado para médico coordenador.');
    return;
  }

  const container = document.getElementById('resultadoCoordenador');
  if (!container) return;

  // 🔹 Limpa o container antes de renderizar novamente
  container.innerHTML = '';

  if (!dados.nome) return;

  // 🔹 Cria o chip visual
  const chip = document.createElement('div');
  chip.style.display = 'inline-flex';
  chip.style.alignItems = 'center';
  chip.style.gap = '8px';
  chip.style.background = '#e2e8f0';
  chip.style.color = '#0f172a';
  chip.style.borderRadius = '999px';
  chip.style.padding = '6px 10px';
  chip.style.marginTop = '6px';
  chip.style.fontSize = '14px';

  const cpfHtml = dados.cpf
    ? `<small style="color:#334155;opacity:.8; margin-left:6px;">CPF: ${dados.cpf}</small>`
    : '';

  chip.innerHTML = `<i class="fas fa-user-md" style="color:#2563eb"></i> <span>${dados.nome}</span>${cpfHtml}`;

  // 🔹 Botão de remoção
  const btn = document.createElement('button');
  btn.type = 'button';
  btn.setAttribute('aria-label', 'Remover');
  btn.style.border = 'none';
  btn.style.background = 'transparent';
  btn.style.cursor = 'pointer';
  btn.style.color = '#334155';
  btn.innerHTML = '<i class="fas fa-times"></i>';
  btn.addEventListener('click', () => removeProfissional('coordenador'));

  chip.appendChild(btn);
  container.appendChild(chip);
}

function repopular_dados_medico_examinador(pessoa, area) {
  //debugger;
  if (!pessoa) return;

  area.className = 'ecp-details';
  area.style.display = 'block';

  // Adiciona prefixo 'Dr.' apenas se ainda não houver
  let titulo = pessoa.nome || '';
  if (!/^Dr\.?\s/i.test(titulo)) {
    titulo = `Dr. ${titulo}`;
  }

  // CPF e CRM sempre visíveis
  const linhaCpf = `CPF: ${pessoa.cpf}${pessoa.crm ? ` | CRM: ${pessoa.crm}` : ''}`;

  // Monta o HTML principal
  area.innerHTML = `
    <div class="font-medium">${titulo}</div>
    <div class="text-sm text-gray-500">${linhaCpf}</div>
    ${renderAssinatura_examinador(pessoa)}
    <button class="ecp-button-cancel mt-2" type="button" onclick="removerPessoa('assinatura-${pessoa.cpf}')">
      ✖ Remover
    </button>
  `;
}


// 🔹 Function específica para assinatura do médico examinador
function renderAssinatura_examinador(pessoa) {
  debugger;
  let html = `
    <div class="mt-2">
      <label class="ecp-label">Enviar Assinatura</label>
      <input 
        type="file" 
        id="assinatura-${pessoa.cpf}" 
        class="ecp-input" 
        accept="image/*" 
        onchange="handleAssinaturaUpload(this, '${pessoa.id}','${pessoa.cpf}')"
      >
      <div class="ecp-questionario-note">
        Formatos aceitos: JPG, PNG, GIF. Tamanho máximo: 2MB
      </div>
    </div>
  `;

  // Se já existir assinatura, exibe a imagem atual
  if (pessoa.imagem_assinatura) {
    html += `
      <div class="mt-2">
        <label class="ecp-label">Assinatura atual</label>
        <img src="cadastros/documentos/assinaturas/${pessoa.imagem_assinatura}" alt="Assinatura" 
          style="max-width: 200px; max-height: 100px; border: 1px solid #ddd; border-radius: 4px;">
      </div>
      <div id="preview-assinatura-${pessoa.cpf}" class="mt-2"></div>
    `;
  }

  return html;
}


// 🔹 Função assíncrona que aguarda o processamento completo
async function popular_medico_relacionados_empresa_edicao() {
  debugger;

  const empresaId = window.kit_tipo_exame?.empresa_id;
  if (!empresaId) {
    console.warn("❗ Nenhuma empresa definida em window.kit_tipo_exame.empresa_id");
    return;
  }

  await new Promise((resolve, reject) => {
    $.ajax({
      url: "cadastros/processa_medico.php",
      method: "GET",
      dataType: "json",
      data: {
        processo_medico: "buscar_medicos_associados_empresa",
        valor_codigo_empresa_medicos_associados: empresaId,
      },
      success: function (resposta_medicos) {
        debugger;
        console.log("✅ Médicos associados retornados:", resposta_medicos);

        if (Array.isArray(resposta_medicos) && resposta_medicos.length > 0) {
          const medicos_relacionados_empresa = [];

          for (const medico of resposta_medicos) {
            medicos_relacionados_empresa.push({
              id: medico.medico_id,
              nome: medico.nome_medico,
              cpf: medico.cpf,
            });
          }

          // 🔹 Atualiza variável global ou objeto existente
          if (typeof profissionaisMedicinaData !== "undefined") {
            profissionaisMedicinaData.coordenadores = medicos_relacionados_empresa;
          }
        }

        resolve(); // ✅ sinaliza que terminou
      },
      error: function (xhr, status, error) {
        console.error("❌ Falha ao buscar médicos:", error);
        reject(error);
      },
    });
  });
}


// 🔹 Função assíncrona que aguarda o processamento completo
async function popular_medico_relacionados_clinica_edicao() {
  debugger;

  // Obtém o ID da clínica do objeto global
  const clinicaId = window.kit_tipo_exame?.clinica_id;

  if (!clinicaId) {
    console.warn("❗ Nenhuma clínica definida em window.kit_tipo_exame.clinica_id — função não será executada.");
    return;
  }

  await new Promise((resolve, reject) => {
    $.ajax({
      url: "cadastros/processa_medico.php",
      method: "GET",
      dataType: "json",
      data: {
        processo_medico: "buscar_medicos_associados_clinica",
        valor_codigo_clinica_medicos_associados: clinicaId,
      },
      success: function (resposta_medicos) {
        debugger;
        console.log("✅ Médicos relacionados à clínica retornados:", resposta_medicos);

        if (Array.isArray(resposta_medicos) && resposta_medicos.length > 0) {
          const medicos_relacionados_clinica = [];

          for (const medico of resposta_medicos) {
            medicos_relacionados_clinica.push({
              id: medico.id,
              nome: medico.nome_medico,
              cpf: medico.cpf,
            });
          }

          // 🔹 Atualiza o objeto global
          if (typeof profissionaisMedicinaData !== "undefined") {
            profissionaisMedicinaData.medicos = medicos_relacionados_clinica;
          }
        }

        resolve(); // ✅ sinaliza que terminou
      },
      error: function (xhr, status, error) {
        console.error("❌ Falha ao buscar médicos da clínica:", error);
        reject(error);
      },
    });
  });
}



    // Restaura UI ao trocar de aba e mantém cabeçalho dos Médicos sincronizado
    document.addEventListener('tabChanged', function(e){
      const step = e && e.detail ? e.detail.step : undefined;
      // Passo 2 (index 1): ECP
      if (step === 1) {
        try { bindEcpInputsOnce(); } catch (err) { /* noop */ }
        try { applyEcpStateToUI(); } catch (err) { /* noop */ }
        // ✅ Repopula o tipo de exame gravado anteriormente
        try { repopular_empresa(); } catch (err) { console.error(err); }
        try { repopular_dados_clinica("clinicas","inputClinica","resultClinica","nome"); } catch (err) { console.error(err); }
        try { if(window.kit_tipo_exame){ repopular_dados_pessoa(); } } catch (err) { console.error(err); }
        try { repopular_dados_cargo(); } catch (err) { console.error(err); }
        try { repopular_dados_motorista(); } catch (err) { console.error(err); }
      }
      // Passo 3 (index 2): Profissionais da Medicina
      if (step === 2) {
        try { applyMedicosHeaderFromEcp(); } catch (err) { /* noop */ }
        // Garante binds e restaura seleção dos profissionais (ligeiro atraso para DOM assentar)
        setTimeout(async () => {
          try { bindMedicosInputsOnce(); } catch (e) { /* noop */ }
          try { applyMedicosStateToUI(); } catch (e) { /* noop */ }
          // 🔹 Chama depois que o estado foi aplicado
          try {
            if (window.kit_tipo_exame?.empresa_id) {
              await popular_medico_relacionados_empresa_edicao();
              console.log("🔹 Médicos carregados e processados com sucesso.");
            }
              // segue o código normalmente...
          } catch (err) {
            console.error("Erro ao popular médicos:", err);
          }

          try {
              if (window.kit_tipo_exame?.clinica_id) {
                await popular_medico_relacionados_clinica_edicao();
                console.log("🔹 Médicos da clínica carregados e processados com sucesso.");
              } else {
                console.warn("⚠️ Nenhuma clínica selecionada — função não chamada.");
            }

                // ➜ segue o restante do código aqui
            } catch (err) {
                 console.error("Erro ao popular médicos da clínica:", err);
            }

          try { repopular_dados_medico_coordenador(); } catch (err) { /* noop */ }
          try { repopular_dados_medico_examinador(window.kit_medico_examinador, document.getElementById('resultadoMedico')); } catch (err) { /* noop */ }

          if(window.kit_clinica && window.kit_clinica !== "")
          {
            $("#exibi-clinica-selecionada").html(window.kit_clinica.nome_fantasia);
          }
        }, 50);
      }
    });

    // Atualização do KIT quando há mudança de profissionais (se houver hook disponível)
    document.addEventListener('profissionalChanged', function(ev) {
      try {
        if (window && typeof window.atualizarKitProfissionais === 'function') {
          window.atualizarKitProfissionais(ev.detail || {});
        } else {
          // Marca sujo para eventual gravação posterior
          window._kitDirtyProfessionals = true;
        }
      } catch (e) { /* noop */ }
    });
    document.addEventListener('profissionalRemoved', function(ev) {
      try {
        if (window && typeof window.atualizarKitProfissionais === 'function') {
          window.atualizarKitProfissionais({ removed: true, ...(ev.detail || {}) });
        } else {
          window._kitDirtyProfessionals = true;
        }
      } catch (e) { /* noop */ }
    });

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
            <input id="inputEmpresa" type="text" class="ecp-input" placeholder="Buscar por nome, CPF ou CNPJ da empresa..." />
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
          <label>Estado:</label>
          <select id="novaEmpresaEstado" class="ecp-modal-input"></select>
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
            <div class="step-subtitle">Profissionais Relacionados à clínica <strong id="exibi-clinica-selecionada"></strong></div>
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
                  <!-- Comentado para não exibir o total
                  <div id="totalTreinamentos" style="font-weight: 600; color: #0056b3;">Total: R$ 0,00</div>
                  -->
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

//     // Estrutura global para armazenar o estado dos dados bancários
// window.dadosBancariosEstado = {
//     tipoSelecionado: null,      // 'pix', 'agencia-conta', 'qrcode'
//     chavePix: null,             // Valor da chave PIX selecionada
//     textoPix: null,             // Texto exibido da chave PIX
//     agenciaConta: null,         // Valor da agência/conta
//     textoAgenciaConta: null,    // Texto exibido da agência/conta
//     qrcodeSelecionado: false    // Se o QR Code está selecionado
// };

function requisitarExameKITEspecifico(codigo_kit) {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: "cadastros/processa_geracao_kit.php",
          method: "GET",
          dataType: "json",
          data: { processo_geracao_kit: "buscar_kit",valor_id_kit: codigo_kit},
          success: function(resposta) {
            console.log("KITs retornados:", resposta);
            resolve(resposta);
          },
          error: function(xhr, status, error) {
            reject(error);
          }
        });
      });
    }

    function requisitarEmpresaKITEspecifico(codigo_kit) {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: "cadastros/processa_geracao_kit.php",
          method: "GET",
          dataType: "json",
          data: { processo_geracao_kit: "buscar_empresa_kit",valor_id_empresa_kit: codigo_kit},
          success: function(resposta) {
            console.log("KITs retornados:", resposta);
            resolve(resposta);
          },
          error: function(xhr, status, error) {
            reject(error);
          }
        });
      });
    }

    function requisitarClinicaKITEspecifico(codigo_kit) {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: "cadastros/processa_geracao_kit.php",
          method: "GET",
          dataType: "json",
          data: { processo_geracao_kit: "busca_clinica_kit",valor_id_clinica_kit: codigo_kit},
          success: function(resposta) {
            console.log("KITs retornados:", resposta);
            resolve(resposta);
          },
          error: function(xhr, status, error) {
            reject(error);
          }
        });
      });
    }

    function requisitarPessoaKITEspecifico(codigo_kit) {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: "cadastros/processa_geracao_kit.php",
          method: "GET",
          dataType: "json",
          data: { processo_geracao_kit: "busca_pessoa_kit",valor_id_pessoa_kit: codigo_kit},
          success: function(resposta) {
            console.log("KITs retornados:", resposta);
            resolve(resposta);
          },
          error: function(xhr, status, error) {
            reject(error);
          }
        });
      });
    }

    function requisitarCargoKITEspecifico(codigo_kit) {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: "cadastros/processa_geracao_kit.php",
          method: "GET",
          dataType: "json",
          data: { processo_geracao_kit: "busca_cargo_kit",valor_id_cargo_kit: codigo_kit},
          success: function(resposta) {
            console.log("KITs retornados:", resposta);
            resolve(resposta);
          },
          error: function(xhr, status, error) {
            reject(error);
          }
        });
      });
    }

    function requisitarMedicoCoordenadorKITEspecifico(codigo_kit) {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: "cadastros/processa_geracao_kit.php",
          method: "GET",
          dataType: "json",
          data: { processo_geracao_kit: "buscar_medico_coordenador_kit",valor_id_medico_coordenador_kit: codigo_kit},
          success: function(resposta) {
            console.log("KITs retornados:", resposta);
            resolve(resposta);
          },
          error: function(xhr, status, error) {
            reject(error);
          }
        });
      });
    }

    function requisitarMedicoExaminadorKITEspecifico(codigo_kit) {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: "cadastros/processa_geracao_kit.php",
          method: "GET",
          dataType: "json",
          data: { processo_geracao_kit: "busca_medico_examinador_kit",valor_id_medico_examinador_kit: codigo_kit},
          success: function(resposta) {
            console.log("KITs retornados:", resposta);
            resolve(resposta);
          },
          error: function(xhr, status, error) {
            reject(error);
          }
        });
      });
    }

    function requisitarDadosPessoaKITEspecifico(codigo_kit) {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: "cadastros/processa_geracao_kit.php",
          method: "GET",
          dataType: "json",
          data: { processo_geracao_kit: "busca_pessoa_kit",valor_id_pessoa_kit: codigo_kit},
          success: function(resposta) {
            console.log("KITs retornados:", resposta);
            resolve(resposta);
          },
          error: function(xhr, status, error) {
            reject(error);
          }
        });
      });
    }

    

    // ==========================================
// 🔹 VARIÁVEIS GLOBAIS (SEM CONFLITO)
// ==========================================
window._snapshotRiscosGrupos = [];
window._snapshotRiscosDetalhes = [];
window._snapshotRiscosSelecionados = [];
window._snapshotRiscosCodes = [];
window.kit_riscos = window.kit_riscos || [];

// ==========================================
// 🔹 NOMES DOS GRUPOS
// ==========================================
const nomesGrupos = {
  "ergonomico": "Riscos Ergonômicos",
  "acidente_mecanico": "Riscos Acidentes - Mecânicos",
  "fisico": "Riscos Físicos",
  "quimico": "Riscos Químicos",
  "biologico": "Riscos Biológicos",
  "outro": "Outros Riscos"
};

// ================================
// Função: repopularGruposRiscosSelecionados (versão final robusta)
// ================================
function repopularGruposRiscosSelecionados() {
  debugger;
  try {
    let kit = window.kit_riscos;

    // 🔹 Normaliza para array (caso venha como JSON string ou objeto simples)
    if (typeof kit === 'string') {
      try {
        kit = JSON.parse(kit);
      } catch (e) {
        console.warn('repopularGruposRiscosSelecionados: window.kit_riscos é string inválida JSON:', e);
        return;
      }
    }

    if (!Array.isArray(kit)) {
      // Se for um objeto (ex: mapa chave=>valor)
      if (kit && typeof kit === 'object') {
        kit = Object.entries(kit).map(([key, val]) => ({
          codigo: val?.codigo || key || '',
          descricao: val?.descricao || val?.name || val?.nome || '',
          grupo: val?.grupo || val?.group || ''
        }));
      } else {
        console.warn("repopularGruposRiscosSelecionados: formato inesperado de window.kit_riscos.");
        return;
      }
    }

    if (!kit.length) {
      console.warn("repopularGruposRiscosSelecionados: nenhum risco disponível em kit_riscos.");
      return;
    }

    const tempRisksData = {};
    const gruposMarcados = new Set();

    kit.forEach(item => {
      const grupo = (item.grupo || '').trim();
      const codigo = (item.codigo || '').trim();
      const descricao = (item.descricao || '').trim();

      if (!grupo || !codigo || !descricao) return;

      if (!tempRisksData[grupo]) {
        tempRisksData[grupo] = {
          name: (window.nomesGrupos && window.nomesGrupos[grupo]) || grupo,
          risks: []
        };
      }

      tempRisksData[grupo].risks.push({
        code: codigo,
        name: descricao,
        isOther: descricao.toLowerCase() === "outros"
      });

      gruposMarcados.add(grupo);
    });

    // 🔹 Se risksData estiver vazio, atribuimos tudo
    if (!window.risksData || Object.keys(window.risksData).length === 0) {
      window.risksData = tempRisksData;
    } else {
      // 🔹 Caso já exista, apenas mescla novos grupos sem sobrescrever
      Object.keys(tempRisksData).forEach(g => {
        if (!window.risksData[g]) window.risksData[g] = tempRisksData[g];
      });
    }

    // 🔹 Mantém snapshot independente (não interfere na edição em andamento)
    window._snapshotRiscosGrupos = Array.from(gruposMarcados);
    window.riscosGruposEstadoSalvo = window.riscosGruposEstadoSalvo || window._snapshotRiscosGrupos.slice();

    // 🔹 Reaplica UI se disponível
    if (typeof window.reaplicarGruposSelecionadosUI === 'function') {
      try {
        window.reaplicarGruposSelecionadosUI();
      } catch (e) {
        console.warn('Falha ao reaplicarGruposSelecionadosUI():', e);
      }
    }

    console.log('✅ repopularGruposRiscosSelecionados executada com sucesso:', window._snapshotRiscosGrupos);
  } catch (e) {
    console.error('Erro em repopularGruposRiscosSelecionados:', e);
  }
}

function repopularDetalhesRiscosSelecionados() {
  debugger;
  try {
    let riscosFonte = [];

    // 🔍 Detecta modo de operação
    const isEdicao = window.recebe_acao === 'editar';

    // ==============================
    // 1️⃣ MODO EDIÇÃO (sempre usar window.kit_riscos)
    // ==============================
    if (isEdicao && window.kit_riscos) {
      let kitRiscosArray = window.kit_riscos;

      if (typeof kitRiscosArray === "string") {
        try {
          kitRiscosArray = JSON.parse(kitRiscosArray);
        } catch (err) {
          console.error("❌ Erro ao converter window.kit_riscos:", err);
          kitRiscosArray = [];
        }
      }

      if (Array.isArray(kitRiscosArray) && kitRiscosArray.length > 0) {
        riscosFonte = kitRiscosArray.map(item => ({
          codigo: item.codigo?.trim() || '',
          descricao: item.descricao?.trim() || '',
          grupo: item.grupo?.trim() || ''
        }));
        console.log("🔵 Edição: usando window.kit_riscos");
      }
    }

    // ==============================
    // 2️⃣ MODO NORMAL (variáveis globais da sessão)
    // ==============================
    else if (
      window.riscosEstadoSalvoDetalhes &&
      Object.keys(window.riscosEstadoSalvoDetalhes).length > 0
    ) {
      riscosFonte = Object.entries(window.riscosEstadoSalvoDetalhes).map(([codigo, info]) => ({
        codigo: codigo || '',
        descricao: info?.name || '',
        grupo: info?.group || ''
      }));
      console.log("🟡 Usando variáveis globais (riscosEstadoSalvoDetalhes)");
    }

    // ==============================
    // 3️⃣ CADASTRO/NOVO (window.kit_riscos)
    // ==============================
    else if (window.kit_riscos) {
      let kitRiscosArray = window.kit_riscos;

      if (typeof kitRiscosArray === "string") {
        try {
          kitRiscosArray = JSON.parse(kitRiscosArray);
        } catch (err) {
          console.error("❌ Erro ao converter window.kit_riscos:", err);
          kitRiscosArray = [];
        }
      }

      if (Array.isArray(kitRiscosArray) && kitRiscosArray.length > 0) {
        riscosFonte = kitRiscosArray.map(item => ({
          codigo: item.codigo?.trim() || '',
          descricao: item.descricao?.trim() || '',
          grupo: item.grupo?.trim() || ''
        }));
        console.log("🔵 Novo cadastro: usando window.kit_riscos");
      }
    }

    // ==============================
    // 4️⃣ Caso não haja riscos
    // ==============================
    if (!riscosFonte.length) {
      console.warn("⚠️ Nenhum risco encontrado para repopular detalhes.");

      // 🔹 Limpa variáveis de estado
      window._snapshotRiscosSelecionados = [];
      window._snapshotRiscosDetalhes = [];
      window._snapshotRiscosCodes = [];
      window.riscosEstadoSalvoDetalhes = {};
      window.selectedRisks = {};

      if (typeof updateSelectedRisksDisplay === "function") {
        updateSelectedRisksDisplay();
      }
      return;
    }

    // ==============================
    // 5️⃣ Reconstrói estado local
    // ==============================
    const selectedRisksLocal = {};
    riscosFonte.forEach(item => {
      const { codigo, descricao, grupo } = item;
      if (!codigo || !descricao || !grupo) return;
      selectedRisksLocal[codigo] = { name: descricao, group: grupo };
    });

    // ==============================
    // 6️⃣ Atualiza snapshots globais
    // ==============================
    window._snapshotRiscosDetalhes = riscosFonte.slice();
    window._snapshotRiscosSelecionados = Object.entries(selectedRisksLocal).map(([codigo, info]) => ({
      codigo,
      descricao: info.name,
      grupo: info.group
    }));
    window._snapshotRiscosCodes = window._snapshotRiscosSelecionados.map(r => r.codigo);

    // ==============================
    // 7️⃣ Atualiza variáveis de sessão (somente se não for edição)
    // ==============================
    if (!isEdicao && (!window.selectedRisks || Object.keys(window.selectedRisks).length === 0)) {
      window.selectedRisks = selectedRisksLocal;
      window.riscosEstadoSalvoDetalhes = selectedRisksLocal;
    }

    // ==============================
    // 8️⃣ Atualiza UI
    // ==============================
    if (typeof reaplicarRiscosSelecionadosUI === "function") {
      window.riscos_selecionados = window._snapshotRiscosSelecionados;
      window.riscosEstadoSalvoCodes = window._snapshotRiscosCodes;
      reaplicarRiscosSelecionadosUI();
    }

    console.log("✅ Detalhes de riscos repopulados:", window._snapshotRiscosSelecionados);
  } catch (e) {
    console.error("❌ Erro ao repopular detalhes dos riscos:", e);
  }
}




// function repopularDetalhesRiscosSelecionados() {
//   debugger;
//   try {
//     let riscosFonte = [];

//     // 1️⃣ Prioriza edição (_snapshot)
//     if (Array.isArray(window._snapshotRiscosSelecionados) && window._snapshotRiscosSelecionados.length > 0) {
//       riscosFonte = window._snapshotRiscosSelecionados.map(r => ({
//         codigo: r.codigo || '',
//         descricao: r.descricao || '',
//         grupo: r.grupo || ''
//       }));
//       console.log("🟢 Usando variáveis de edição (_snapshotRiscosSelecionados)");
//     }
//     // 2️⃣ Caso contrário, usa gravação se existir e não estiver vazio
//     else if (window.riscosEstadoSalvoDetalhes && Object.keys(window.riscosEstadoSalvoDetalhes).length > 0) {
//       riscosFonte = Object.entries(window.riscosEstadoSalvoDetalhes).map(([codigo, info]) => ({
//         codigo: codigo || '',
//         descricao: info?.name || '',
//         grupo: info?.group || ''
//       }));
//       console.log("🟡 Usando variáveis de gravação (riscosEstadoSalvoDetalhes)");
//     }
//     // 3️⃣ Caso contrário, usa window.kit_riscos
//     else if (window.kit_riscos) {
//       let kitRiscosArray = window.kit_riscos;

//       if (typeof kitRiscosArray === "string") {
//         try { kitRiscosArray = JSON.parse(kitRiscosArray); } 
//         catch (err) { 
//           console.error("❌ Erro ao converter window.kit_riscos de string para array:", err); 
//           kitRiscosArray = []; 
//         }
//       }

//       if (Array.isArray(kitRiscosArray) && kitRiscosArray.length > 0) {
//         riscosFonte = kitRiscosArray.map(item => ({
//           codigo: item.codigo?.trim() || '',
//           descricao: item.descricao?.trim() || '',
//           grupo: item.grupo?.trim() || ''
//         }));
//         console.log("🔵 Usando window.kit_riscos do cadastro");
//       }
//     }

//     if (!riscosFonte.length) {
//       console.warn("⚠️ Nenhum risco encontrado para repopular detalhes.");
//       return;
//     }

//     // Prepara selectedRisksLocal
//     const selectedRisksLocal = {};
//     riscosFonte.forEach(item => {
//       const { codigo, descricao, grupo } = item;
//       if (!codigo || !descricao || !grupo) return;
//       selectedRisksLocal[codigo] = { name: descricao, group: grupo };
//     });

//     // Atualiza snapshots globais
//     window._snapshotRiscosDetalhes = riscosFonte.slice();
//     window._snapshotRiscosSelecionados = Object.entries(selectedRisksLocal).map(([codigo, info]) => ({
//       codigo,
//       descricao: info.name,
//       grupo: info.group
//     }));
//     window._snapshotRiscosCodes = window._snapshotRiscosSelecionados.map(r => r.codigo);

//     // Só altera selectedRisks se não houver edição em andamento
//     if (!window.selectedRisks || Object.keys(window.selectedRisks).length === 0) {
//       window.selectedRisks = selectedRisksLocal;
//     }

//     // Atualiza UI se função disponível
//     if (typeof reaplicarRiscosSelecionadosUI === "function") {
//       window.riscos_selecionados = window._snapshotRiscosSelecionados;
//       window.riscosEstadoSalvoCodes = window._snapshotRiscosCodes;
//       window.riscosEstadoSalvoDetalhes = window._snapshotRiscosDetalhes;
//       reaplicarRiscosSelecionadosUI();
//     }

//     console.log("✅ Detalhes de riscos repopulados com segurança:", window._snapshotRiscosSelecionados);
//   } catch (e) {
//     console.error("❌ Erro ao repopular detalhes dos riscos:", e);
//   }
// }

async function repopular_treinamentos() {
  debugger;
  try {
    // 1️⃣ Busca todos os treinamentos disponíveis
    const response = await buscar_treinamentos();

    // Verifica se retornou algo válido
    const todosTreinamentos = Array.isArray(response) ? response : [];

    // 2️⃣ Renderiza a lista completa
    const listaTreinamentos = document.getElementById('listaTreinamentos');
    if (!listaTreinamentos) {
      console.error("Elemento 'listaTreinamentos' não encontrado.");
      return;
    }

    if (todosTreinamentos.length === 0) {
      listaTreinamentos.innerHTML = `
        <div style="text-align: center; padding: 40px 20px; color: #6c757d; font-style: italic; background: #fff; border-radius: 6px;">
          <i class="fas fa-info-circle" style="margin-right: 5px; font-size: 18px;"></i>
          <div style="margin-top: 8px;">Nenhum treinamento cadastrado</div>
        </div>`;
      
      const btnAplicar = document.getElementById('btnAplicarTreinamentos');
      if (btnAplicar) btnAplicar.style.display = 'none';
      return;
    }

    // Mostra o botão de aplicar
    const btnAplicar = document.getElementById('btnAplicarTreinamentos');
    if (btnAplicar) btnAplicar.style.display = 'inline-flex';

    // Limpa antes de renderizar
    listaTreinamentos.innerHTML = '';

    // Cria o HTML de todos os treinamentos
    const htmlTreinamentos = todosTreinamentos.map(t => `
      <div class="treinamento-item" style="padding: 8px 12px; border-bottom: 1px solid #e9ecef; display: flex; align-items: center;">
        <input type="checkbox" class="chkTreinamento" value="${t.codigo_treinamento_capacitacao}"
               data-nome="${t.nome}" 
               data-valor="${t.valor}" 
               style="margin-right: 10px; cursor: pointer;">
        <div style="flex: 1; cursor: pointer;">
          <div style="font-weight: 500;">${t.nome}</div>
          <div style="font-size: 12px; color: #6c757d;">Código: ${t.codigo_treinamento_capacitacao}</div>
        </div>
      </div>
    `).join('');

    listaTreinamentos.innerHTML = htmlTreinamentos;

    // 3️⃣ Marca automaticamente os treinamentos que vieram de window.treinamentos (edição)
    let treinamentosMarcados = [];
    try {
      treinamentosMarcados = JSON.parse(window.treinamentos);
      if (!Array.isArray(treinamentosMarcados)) treinamentosMarcados = [];
    } catch (e) {
      console.warn("window.treinamentos não é um JSON válido:", e);
      treinamentosMarcados = [];
    }

    // Aguarda a renderização do DOM antes de marcar
    await new Promise(resolve => requestAnimationFrame(resolve));

    // Marca e espera o término
    await marcarTreinamentosSalvos(treinamentosMarcados, listaTreinamentos);

    console.log("✅ Treinamentos renderizados e marcados corretamente.");

    return true; // sinaliza que terminou
  } catch (error) {
    console.error("Erro ao repopular treinamentos:", error);
    throw error;
  }
}


async function marcarTreinamentosSalvos(treinamentosMarcados, listaTreinamentos) {
  if (!Array.isArray(treinamentosMarcados) || treinamentosMarcados.length === 0) return;

  // Usa Promise para aguardar até que a marcação realmente termine
  await new Promise(resolve => {
    const marcar = () => {
      treinamentosMarcados.forEach(t => {
        const checkbox = listaTreinamentos.querySelector(`input[type="checkbox"][value="${t.codigo}"]`);
        if (checkbox) checkbox.checked = true;
      });
    };

    marcar();
    // Faz uma segunda verificação 200ms depois e resolve
    setTimeout(() => {
      marcar();
      resolve(true);
    }, 200);
  });
}



async function repopular_treinamentos_selecionados() {
  try {
    debugger;
    const container = document.getElementById('treinamentosSelecionados');
    const listaTreinamentos = document.getElementById('listaTreinamentos');

    if (!container) {
      console.warn('Container de treinamentos não encontrado.');
      return;
    }

    // 🔹 Converte JSON string em array, se necessário
    if (typeof window.treinamentos === 'string') {
      try {
        window.treinamentos = JSON.parse(window.treinamentos);
      } catch (err) {
        console.warn('Falha ao converter window.treinamentos:', err);
        window.treinamentos = [];
      }
    }

    // 🔹 Caso não haja treinamentos
    if (!Array.isArray(window.treinamentos) || window.treinamentos.length === 0) {
      container.innerHTML = `
        <div style="color: #6c757d; font-style: italic; text-align: center; padding: 20px 0;">
          Nenhum treinamento selecionado
        </div>`;
      window.fatTotalTreinamentos = 0;
      if (typeof fatAtualizarTotais === 'function') fatAtualizarTotais();
      return;
    }

    // 🔹 Marca os checkboxes e monta o HTML
    let html = '';
    let total = 0;

    for (const t of window.treinamentos) {
      const codigo = String(t.codigo);
      const nome = t.descricao || `Treinamento ${codigo}`;
      const valorStr = t.valor || '0';
      const valor = parseFloat(valorStr.replace('.', '').replace(',', '.')) || 0;
      total += valor;

      // Marca o checkbox correspondente (se existir)
      const checkbox = listaTreinamentos?.querySelector(`input[type="checkbox"][value="${codigo}"]`);
      if (checkbox) {
        checkbox.checked = true;
        checkbox.dataset.nome = nome;
        checkbox.dataset.valor = valorStr;
      }

      // Monta o HTML de exibição
      html += `
        <div class="treinamento-selecionado" 
             style="padding: 8px 0; border-bottom: 1px solid #e9ecef; display: flex; 
                    align-items: center; justify-content: space-between; gap: 8px;">
          <div>
            <div style="font-weight: 500; font-size: 14px; margin-bottom: 4px;">${nome}</div>
            <div style="font-size: 12px; color: #6c757d;">Código: ${codigo}</div>
          </div>
          <button type="button" title="Remover" data-acao="remover-treinamento" data-codigo="${codigo}" 
                  style="border: none; background: transparent; color: #dc3545; cursor: pointer; padding: 4px;">
            <i class="fas fa-trash"></i>
          </button>
        </div>`;
    }

    // 🔹 Aguarda um tick de renderização antes de atualizar o DOM (garante exibição fluida)
    await new Promise(requestAnimationFrame);

    // 🔹 Atualiza o container com os treinamentos
    container.innerHTML = html;

    // 🔹 Atualiza o total global
    window.fatTotalTreinamentos = Number(total.toFixed(2));

    // 🔹 Atualiza totais gerais, se a função existir
    if (typeof fatAtualizarTotais === 'function') fatAtualizarTotais();

    // 🔹 Resolve após tudo ser exibido corretamente
    return true;
  } catch (e) {
    console.error("Erro ao repopular treinamentos selecionados:", e);
    throw e;
  }
}

    function marcarDropdownsLaudo() {
  // Mapa entre o label e a variável global correspondente
  const mapaValores = {
    'insalubridade': window.insalubridade,
    'porcentagem': window.porcentagem,
    'periculosidade 30%': window.periculosidade,
    'aposent. especial': window.aposent_especial,
    'agente nocivo': window.agente_nocivo,
    'ocorrência gfip': window.ocorrencia_gfip
  };

  document.querySelectorAll('.laudo-dropdown-wrapper').forEach(wrapper => {
    const label = wrapper.querySelector('label');
    const dropdown = wrapper.querySelector('.laudo-dropdown');
    if (!label || !dropdown) return;

    const chave = label.textContent.trim().toLowerCase();
    const valorBruto = mapaValores[chave];
    if (!valorBruto) return;

    const valor = valorBruto.toString().trim().toLowerCase();

    const selectedText = dropdown.querySelector('.selected-text');
    const options = dropdown.querySelectorAll('.dropdown-option');
    let encontrou = false;

    options.forEach(option => {
      const textoOption = option.textContent.trim().toLowerCase();

      // Comparação direta (ex: "10%", "sim", "01", etc)
      if (textoOption === valor) {
        selectedText.textContent = option.textContent.trim();
        encontrou = true;

        // Garante que só essa fique ativa
        options.forEach(opt => opt.classList.remove('active'));
        option.classList.add('active');
      }
    });

    // Se não encontrar, mantém como "Selecione"
    if (!encontrou) {
      selectedText.textContent = 'Selecione';
      options.forEach(opt => opt.classList.remove('active'));
    }
  });
}

// Exemplo de uso:
// window.insalubridade = "Sim";
// window.porcentagem = "20%";
// window.periculosidade = "Não";
// window.aposent_especial = "Sim";
// window.agente_nocivo = "Ruído";
// window.ocorrencia_gfip = "01";
// marcarDropdownsLaudo();

// Função para repopular os dropdowns e o resumo do laudo
function repopular_laudos() {
  debugger;
  const resumoContainer = document.getElementById('resumo-laudo');
  if (!resumoContainer) return;

  // Mapeia os valores vindos das variáveis globais
  const valoresGlobais = {
    'Insalubridade': window.insalubridade,
    'Porcentagem': window.porcentagem,
    'Periculosidade 30%': window.periculosidade,
    'Aposent. Especial': window.aposent_especial,
    'Agente Nocivo': window.agente_nocivo,
    'Ocorrência GFIP': window.ocorrencia_gfip
  };

  const itensSelecionados = [];

  // Atualiza cada dropdown conforme o valor global
  document.querySelectorAll('.laudo-dropdown-wrapper').forEach(wrapper => {
    const labelEl = wrapper.querySelector('label');
    const dropdown = wrapper.querySelector('.laudo-dropdown');
    if (!labelEl || !dropdown) return;

    const label = labelEl.textContent.trim();
    const valor = valoresGlobais[label];

    // Se houver valor salvo, ajusta o dropdown
    if (valor && valor !== '' && valor !== 'Selecione') {
      const selectedText = dropdown.querySelector('.selected-text');
      selectedText.textContent = valor;

      // Marca visualmente a opção selecionada
      dropdown.querySelectorAll('.dropdown-option').forEach(opt => {
        if (opt.textContent.trim() === valor) {
          opt.classList.add('selected');
        } else {
          opt.classList.remove('selected');
        }
      });

      // Adiciona ao resumo
      itensSelecionados.push({
        label: label,
        value: valor
      });
    }
  });

  // Limpa o resumo atual
  resumoContainer.innerHTML = '';

  // Gera o HTML do resumo
  itensSelecionados.forEach(item => {
    const itemElement = document.createElement('div');
    itemElement.className = 'resumo-item';

    const labelSpan = document.createElement('span');
    labelSpan.className = 'label';
    labelSpan.textContent = `${item.label}:`;

    const valueSpan = document.createElement('span');
    valueSpan.className = 'value';
    valueSpan.textContent = item.value;

    itemElement.appendChild(labelSpan);
    itemElement.appendChild(valueSpan);
    resumoContainer.appendChild(itemElement);
  });

  console.log('Laudos repopulados:', itensSelecionados);
}





    async function updateTab(step) {
      debugger;

      let parametros = new URLSearchParams(window.location.search);

      // Obtém o valor do parâmetro "id"
      window.recebe_id_kit = parametros.get("id");

      window.recebe_acao = parametros.get("acao");

      window.kit_tipo_exame = await requisitarExameKITEspecifico(window.recebe_id_kit);

      // Confirma se veio o parâmetro
      if (window.recebe_id_kit) {
        console.log("ID recebido:", window.recebe_id_kit);

        
        window.kit_empresa = await requisitarEmpresaKITEspecifico(window.kit_tipo_exame.empresa_id);
        window.kit_clinica = await requisitarClinicaKITEspecifico(window.kit_tipo_exame.clinica_id);
        window.kit_pessoa = await requisitarPessoaKITEspecifico(window.kit_tipo_exame.pessoa_id);
        window.kit_cargo = await requisitarCargoKITEspecifico(window.kit_tipo_exame.cargo_id);
        window.kit_medico_coordenador = await requisitarMedicoCoordenadorKITEspecifico(window.kit_tipo_exame.medico_coordenador_id);
        window.kit_medico_examinador = await requisitarMedicoExaminadorKITEspecifico(window.kit_tipo_exame.medico_clinica_id);
        window.kit_riscos = window.kit_tipo_exame.riscos_selecionados;
        window.treinamentos = window.kit_tipo_exame.treinamentos_selecionados;
        window.insalubridade = window.kit_tipo_exame.insalubridade;
        window.porcentagem = window.kit_tipo_exame.porcentagem;
        window.periculosidade = window.kit_tipo_exame.periculosidade;
        window.aposent_especial = window.kit_tipo_exame.aposentado_especial;
        window.agente_nocivo = window.kit_tipo_exame.agente_nocivo;
        window.ocorrencia_gfip = window.kit_tipo_exame.ocorrencia_gfip;
        window.aptidoes = window.kit_tipo_exame.aptidoes_selecionadas;
        window.exames = window.kit_tipo_exame.exames_selecionados;
        window.produtos = await requisitarProdutos(window.kit_tipo_exame.id);
        window.tipo_orcamento = window.kit_tipo_exame.tipo_orcamento;
        window.assinatura_digital = window.kit_tipo_exame.assinatura_digital;
        window.tipo_dado_bancario = window.kit_tipo_exame.tipo_dado_bancario;
        window.dado_bancario_agencia_conta = window.kit_tipo_exame.dado_bancario_agencia_conta;
        window.dado_bancario_pix = window.kit_tipo_exame.dado_bancario_pix;
        window.modelos_documentos = window.kit_tipo_exame.modelos_selecionados;

        console.log(window.insalubridade + " - " + window.porcentagem + " - " + window.periculosidade + "- "
         + window.aposent_especial + " - " + window.agente_nocivo + " - " + window.ocorrencia_gfip);

         console.log(window.produtos);
      } else {
        console.log("Nenhum parâmetro 'id' foi recebido.");
      }

      console.log('Atualizando para a aba:', step, 'Conteúdo:', etapas[step] ? 'disponível' : 'indisponível');
      // Controle ao trocar de abas envolvendo Riscos (etapa 3)
      try {
        const fromStep = appState.currentStep;
        // Ao sair da aba Riscos: grava apenas se houver mudanças pendentes
        if (fromStep === 3 && step !== 3) {
          if (window && window._riscosDirty) {
            console.log('Saindo da aba Riscos com alterações pendentes. Gravando...');
            if (typeof window.gravar_riscos_selecionados === 'function') {
              try { window.gravar_riscos_selecionados(); } catch (e) { console.warn('Falha ao gravar na saída da aba Riscos:', e); }
            }
          }
        }
      } catch (e) { /* ignore */ }

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

        function repopular_tipo_exame() {
            debugger;
            const examCards = document.querySelectorAll('.exam-card');
            const tipoExameSelecionado = window.kit_tipo_exame?.tipo_exame;

            if (!examCards.length) {
              console.warn('Nenhum card de exame encontrado.');
              return;
            }

            if (!tipoExameSelecionado) {
              console.warn('Nenhum tipo de exame encontrado em window.kit_tipo_exame.');
              return;
            }

            // Marca apenas o tipo de exame que já foi salvo no kit
            examCards.forEach(card => {
              const tipo = card.dataset.exam;

              if (tipo === tipoExameSelecionado) {
                card.classList.add('active'); // Destaca visualmente o card
                console.log('Exame repopulado (marcado):', tipo);
              } else {
                card.classList.remove('active');
              }
            });
        }

        
        // Configurar os cards de exame
        setTimeout(() => {
          verifica_selecao_exame();
          // Restaurar a seleção do exame se existir
          if (appState.selectedExam) {
            const selectedCard = document.querySelector(`.exam-card[data-exam="${appState.selectedExam}"]`);
            if (selectedCard) {
              document.querySelectorAll('.exam-card').forEach(card => card.classList.remove('active'));
              selectedCard.classList.add('active');
            }
          }

          if(window.kit_tipo_exame)
          {
            repopular_tipo_exame();
          }
        }, 0);
      } else if (step === 3) {
        debugger;
        // Renderiza o conteúdo da etapa 3 (Riscos) antes de inicializar
        if (etapas[3] && content.innerHTML.trim() !== (etapas[3] || '').trim()) {
          content.innerHTML = etapas[3];
        } else if (!etapas[3]) {
          console.warn('Conteúdo da etapa 3 indisponível');
          content.innerHTML = '';
        }
        // Inicializa o componente de riscos após o DOM da aba estar presente
        setTimeout(() => {
          debugger;
          // if (typeof tryInitRiscos === 'function') {
          //   debugger;
          //   tryInitRiscos();
          // } else if (typeof initializeRiscosComponent === 'function') {

          // } else {
          //   console.error('Inicializador de riscos indisponível');
          // }
          initializeRiscosComponent();
          try { 
  window.reaplicarRiscosSelecionadosUI(); 
} catch (e) { 
  console.warn('Falha ao reaplicar UI de riscos:', e); 
}

try { 
  window.reaplicarGruposSelecionadosUI(); 
} catch (e) { 
  console.warn('Falha ao reaplicar grupos de riscos:', e); 
}

// ✅ Repopula dados após reabrir a aba
try { 
  repopularGruposRiscosSelecionados(); 
} catch (e) { 
  console.warn('Falha ao repopular grupos de riscos:', e); 
}

try { 
  repopularDetalhesRiscosSelecionados(); 
} catch (e) { 
  console.warn('Falha ao repopular detalhes de riscos:', e); 
}

// ✅ Executa novamente após 150ms para garantir atualização visual
setTimeout(async () => {
  if (typeof window.reaplicarRiscosSelecionadosUI === 'function') {
    try { window.reaplicarRiscosSelecionadosUI(); } 
    catch (e) { console.warn('Falha ao reaplicar UI de riscos:', e); }
  }

  if (typeof window.reaplicarGruposSelecionadosUI === 'function') {
    try { window.reaplicarGruposSelecionadosUI(); } 
    catch (e) { console.warn('Falha ao reaplicar grupos de riscos:', e); }
  }

  try { repopularGruposRiscosSelecionados(); } 
  catch (e) { console.warn('Falha ao repopular grupos de riscos (timeout):', e); }

  try { repopularDetalhesRiscosSelecionados(); } 
  catch (e) { console.warn('Falha ao repopular detalhes de riscos (timeout):', e); }

  try {
  await repopular_treinamentos();
  console.log("✅ Treinamentos exibidos corretamente.");

  
} catch (e) {
  console.warn("Falha ao repopular detalhes de riscos (timeout):", e);
}


  try {
  await repopular_treinamentos_selecionados();
  console.log('✅ Treinamentos repopulados com sucesso.');
} catch (e) {
  console.warn('Falha ao repopular detalhes de riscos (timeout):', e);
}

try {
  marcarDropdownsLaudo();
  console.log('✅ Treinamentos repopulados com sucesso.');
} catch (e) {
  console.warn('Falha ao repopular detalhes de riscos (timeout):', e);
}

try {
  repopular_laudos();

  console.log('✅ Treinamentos repopulados com sucesso.');
} catch (e) {
  console.warn('Falha ao repopular detalhes de riscos (timeout):', e);
}
}, 150);



        }, 100);

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
                    
                    // (re)inicializa o live search da descrição após montar a UI de faturamento
                    if (typeof initFatDescricaoLiveSearch === 'function') {
                      setTimeout(() => { try { initFatDescricaoLiveSearch(); } catch (e) { console.warn('Falha ao inicializar live search:', e); } }, 0);
                    }
                    
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

        // Garante que o botão "+ Adicionar" da etapa de faturamento chame a função corretamente
        if (step === 5) {
          try {
            const addBtn = content.querySelector('.fat-btn-group button');
            if (addBtn && !addBtn.dataset.boundAdd) {
              addBtn.addEventListener('click', function(e){
                e.preventDefault();
                if (typeof window.fatAdicionarProduto === 'function') {
                  window.fatAdicionarProduto();
                }
              });
              addBtn.dataset.boundAdd = '1';
            }
          } catch (e) { /* noop */ }
        }
        
        // Fallback: garante inicialização do live search ao entrar na etapa 5,
        // mesmo que o container de totais ainda não tenha sido detectado
        if (step === 5 && typeof initFatDescricaoLiveSearch === 'function') {
          setTimeout(() => {
            try { initFatDescricaoLiveSearch(); } catch (e) { console.warn('Falha ao inicializar live search (fallback):', e); }
          }, 0);
        }
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
      
      // Se for a aba de aptidões (etapa 4), carrega as aptidões extras
      if (step === 4 && typeof carregar_aptidoes_extras === 'function') {
        console.log('Aba de aptidões selecionada, carregando aptidões extras...');
        carregar_aptidoes_extras();
        carregar_exames();

  //       setTimeout(async () => {
  //   try {
  //     // 1️⃣ Inicializa os componentes necessários
  //     // if (typeof initializeAptidoesExames === 'function') {
  //     //   initializeAptidoesExames();
  //     // }

  //     // 2️⃣ Aguarda a repopulação completa das aptidões
      
  //       await repopular_aptidoes();
      

  //     console.log('Passo 5 concluído: Aptidões e Exames carregados');
  //   } catch (error) {
  //     console.error('Erro ao executar repopular_aptidoes:', error);
  //   }
  // }, 100);

  //       setTimeout(async () => {
  //   try {
  //     // 1️⃣ Inicializa os componentes necessários
  //     if (typeof initializeAptidoesExames === 'function') {
  //       initializeAptidoesExames();
  //     }

  //     // 2️⃣ Aguarda a repopulação completa das aptidões
  //     if (typeof repopular_aptidoes === 'function') {
  //       await repopular_aptidoes();
  //     }

  //     console.log('Passo 5 concluído: Aptidões e Exames carregados');
  //   } catch (error) {
  //     console.error('Erro ao executar repopular_aptidoes:', error);
  //   }
  // }, 100);
      }
      
      // Se for a aba de faturamento (etapa 5), atualiza os totais e inicializa a conta bancária
      if (step === 5) {
        window.fatProdutosGlobais = window.fatProdutosGlobais || [];

        // ============================================================
        // 🔹 VARIÁVEIS GLOBAIS (inicialização segura)
        // ===========================================================
        
        console.log('=== Aba de faturamento aberta (etapa 5) ===');

        carregarAsChavesPIX();
        carregarAgenciasContas();
        repopular_produtos();
        restaurar_tipo_orcamento();
        restaurarModelosSelecionados();
        repopular_assinatura();
        repopular_dados_bancarios();

        if (typeof tratar_modelos_orcamentos === 'function') {
  tratar_modelos_orcamentos();
}

        function repopular_dados_bancarios() {
    debugger;

    // 🔹 Garante que o valor de tipo_dado_bancario seja um array válido
    let tipos = [];

    try {
        if (typeof window.tipo_dado_bancario === 'string') {
            // Converte string JSON para array
            tipos = JSON.parse(window.tipo_dado_bancario);
        } else if (Array.isArray(window.tipo_dado_bancario)) {
            tipos = window.tipo_dado_bancario;
        } else {
            console.warn('Formato inesperado em window.tipo_dado_bancario:', window.tipo_dado_bancario);
            return;
        }
    } catch (e) {
        console.error('Erro ao converter tipo_dado_bancario:', e);
        return;
    }

    // 🔹 Monta o estado bancário global baseado nos valores vindos do banco
    window.dadosBancariosEstado = {
        agenciaConta: window.dado_bancario_agencia_conta ?? null,
        agenciaContaSelecionado: window.tipo_dado_bancario.includes('agencia-conta'),
        chavePix: window.dado_bancario_pix ?? null,
        pixSelecionado: window.tipo_dado_bancario.includes('pix'),
        qrcodeSelecionado: window.tipo_dado_bancario.includes('qrcode'),
        textoAgenciaConta: window.dado_bancario_agencia_conta ?? null,
        textoPix: window.dado_bancario_pix ?? null
    };

    console.log('✅ Estado bancário montado:', window.dadosBancariosEstado);

    // 🔹 Chama a função que restaura a interface com base nesse estado
    restaurarEstadoBancario();
}

// function gravar_tipo_dado_bancario(tipo_dado_bancario) {
//             debugger;
//             try {
//               console.group('Conta Bancária > gravar_tipo_dado_bancario');
//               console.log('Valor recebido para gravação:', tipo_dado_bancario);
//               console.groupEnd();
//             } catch (e) { /* noop */ }
//             $.ajax({
//               url: "cadastros/processa_geracao_kit.php",
//               type: "POST",
//               dataType: "json",
//               async: false,
//               data: {
//                 processo_geracao_kit: "incluir_valores_kit",
//                 valor_tipo_dado_bancario: tipo_dado_bancario,
//               },
//               success: function(retorno_exame_geracao_kit) {
//                 debugger;
//                 try {
//                   console.group('AJAX > sucesso inclusão valor kit');
//                   console.log('Retorno:', retorno_exame_geracao_kit);
//                   console.groupEnd();
//                 } catch(e) { /* noop */ }

//                 const mensagemSucesso = `
//                       <div id="exame-gravado" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
//                         <div style="display: flex; align-items: center; justify-content: center;">
                          
//                           <div>
                            
//                             <div>Exame cadastrado com sucesso.</div>
//                           </div>
//                         </div>
//                       </div>
//                 `;

//                 // Remove mensagem anterior se existir
//                 $("#exame-gravado").remove();
                    
//                 // Adiciona a nova mensagem acima das abas
//                 $(".tabs-container").before(mensagemSucesso);

//                 // Configura o fade out após 5 segundos
//                 setTimeout(function() {
//                   $("#exame-gravado").fadeOut(500, function() {
//                   $(this).remove();
//                   });
//                 }, 5000);


//                 $("#exame-gravado").html(retorno_exame_geracao_kit);
//                 $("#exame-gravado").show();
//                 $("#exame-gravado").fadeOut(4000);
//                 console.log(retorno_exame_geracao_kit);
//                 ajaxEmExecucao = false; // libera para nova requisição
//               },
//               error: function(xhr, status, error) {
//                 console.log("Falha ao incluir exame: " + error);
//                 ajaxEmExecucao = false; // libera para tentar de novo
//               },
//               complete: function() {
//                 try {
//                   console.log('AJAX > inclusão valor kit finalizado');
//                 } catch(e) { /* noop */ }
//               }
//             });
//           }

function gravar_tipo_dado_bancario(tipo_dado_bancario) {
      debugger;
      if(window.recebe_acao && window.recebe_acao === "editar")
        {
          try {
        console.group('Conta Bancária > gravar_tipo_dado_bancario');
        console.log('Valor recebido para gravação:', tipo_dado_bancario);
        console.groupEnd();
      } catch (e) { /* noop */ }
      $.ajax({
        url: "cadastros/processa_geracao_kit.php",
        type: "POST",
        dataType: "json",
        async: false,
        beforeSend: function() {
          try {
            console.group('AJAX > inclusão valor kit (beforeSend)');
            console.log('Processo:', 'atualizar_kit');
            console.log('valor_tipo_dado_bancario:', tipo_dado_bancario);
            console.groupEnd();
          } catch(e) { /* noop */ }
        },
        data: {
          processo_geracao_kit: "atualizar_kit",
          valor_tipo_dado_bancario: tipo_dado_bancario,
          valor_id_kit:window.recebe_id_kit
        },
        success: function(retorno_exame_geracao_kit) {
          debugger;
          try {
            console.group('AJAX > sucesso inclusão valor kit');
            console.log('Retorno:', retorno_exame_geracao_kit);
            console.groupEnd();
          } catch(e) { /* noop */ }

          const mensagemSucesso = `
                <div id="exame-gravado" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
                  <div style="display: flex; align-items: center; justify-content: center;">
                    
                    <div>
                      
                      <div>Exame cadastrado com sucesso.</div>
                    </div>
                  </div>
                </div>
          `;

          // Remove mensagem anterior se existir
          $("#exame-gravado").remove();
              
          // Adiciona a nova mensagem acima das abas
          $(".tabs-container").before(mensagemSucesso);

          // Configura o fade out após 5 segundos
          setTimeout(function() {
            $("#exame-gravado").fadeOut(500, function() {
            $(this).remove();
            });
          }, 5000);


          $("#exame-gravado").html(retorno_exame_geracao_kit);
          $("#exame-gravado").show();
          $("#exame-gravado").fadeOut(4000);
          console.log(retorno_exame_geracao_kit);
          ajaxEmExecucao = false; // libera para nova requisição
        },
        error: function(xhr, status, error) {
          console.log("Falha ao incluir exame: " + error);
          ajaxEmExecucao = false; // libera para tentar de novo
        },
        complete: function() {
          try {
            console.log('AJAX > inclusão valor kit finalizado');
          } catch(e) { /* noop */ }
        }
      });
        }else{
try {
        console.group('Conta Bancária > gravar_tipo_dado_bancario');
        console.log('Valor recebido para gravação:', tipo_dado_bancario);
        console.groupEnd();
      } catch (e) { /* noop */ }
      $.ajax({
        url: "cadastros/processa_geracao_kit.php",
        type: "POST",
        dataType: "json",
        async: false,
        beforeSend: function() {
          try {
            console.group('AJAX > inclusão valor kit (beforeSend)');
            console.log('Processo:', 'incluir_valores_kit');
            console.log('valor_tipo_dado_bancario:', tipo_dado_bancario);
            console.groupEnd();
          } catch(e) { /* noop */ }
        },
        data: {
          processo_geracao_kit: "incluir_valores_kit",
          valor_tipo_dado_bancario: tipo_dado_bancario,
        },
        success: function(retorno_exame_geracao_kit) {
          debugger;
          try {
            console.group('AJAX > sucesso inclusão valor kit');
            console.log('Retorno:', retorno_exame_geracao_kit);
            console.groupEnd();
          } catch(e) { /* noop */ }

          const mensagemSucesso = `
                <div id="exame-gravado" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
                  <div style="display: flex; align-items: center; justify-content: center;">
                    
                    <div>
                      
                      <div>Exame cadastrado com sucesso.</div>
                    </div>
                  </div>
                </div>
          `;

          // Remove mensagem anterior se existir
          $("#exame-gravado").remove();
              
          // Adiciona a nova mensagem acima das abas
          $(".tabs-container").before(mensagemSucesso);

          // Configura o fade out após 5 segundos
          setTimeout(function() {
            $("#exame-gravado").fadeOut(500, function() {
            $(this).remove();
            });
          }, 5000);


          $("#exame-gravado").html(retorno_exame_geracao_kit);
          $("#exame-gravado").show();
          $("#exame-gravado").fadeOut(4000);
          console.log(retorno_exame_geracao_kit);
          ajaxEmExecucao = false; // libera para nova requisição
        },
        error: function(xhr, status, error) {
          console.log("Falha ao incluir exame: " + error);
          ajaxEmExecucao = false; // libera para tentar de novo
        },
        complete: function() {
          try {
            console.log('AJAX > inclusão valor kit finalizado');
          } catch(e) { /* noop */ }
        }
      });
        }
    }


//         function repopular_assinatura() {
//     debugger;

//     try {
//         const checkbox = document.getElementById('requer-assinatura');
//         if (!checkbox) {
//             console.warn('Checkbox de assinatura não encontrado.');
//             return;
//         }

//         // Verifica se o valor global existe
//         if (typeof window.assinatura_digital !== 'undefined' && window.assinatura_digital !== null) {
//             // Converte o valor ("Sim"/"Nao") em booleano
//             const deveMarcar = String(window.assinatura_digital).trim().toLowerCase() === 'sim';

//             // Marca ou desmarca o checkbox conforme o valor
//             checkbox.checked = deveMarcar;

//             // Salva o estado atual (caso você use isso em outras funções)
//             window.assinaturaDigitalEstado = deveMarcar;

//             console.log('Assinatura digital repopulada:', window.assinatura_digital);
//         } else {
//             console.warn('Variável global window.assinatura_digital não possui valor definido.');
//         }
//     } catch (e) {
//         console.error('Erro ao repopular assinatura digital:', e);
//     }
// }

function repopular_assinatura() {
    debugger;

    try {
        const checkbox = document.getElementById('requer-assinatura');
        if (!checkbox) {
            console.warn('Checkbox de assinatura não encontrado.');
            return;
        }

        let deveMarcar = false;

        // 🔹 Verifica o modo de ação
        if (window.recebe_acao === 'editar') {
            // Valor vem de window.assinatura_digital (geralmente "Sim" ou "Nao")
            if (typeof window.assinatura_digital !== 'undefined' && window.assinatura_digital !== null) {
                deveMarcar = String(window.assinatura_digital).trim().toLowerCase() === 'sim';
            } else {
                console.warn('Variável window.assinatura_digital não possui valor definido no modo edição.');
            }
        } else {
            // Valor vem de window.assinaturaDigitalEstado (boolean)
            if (typeof window.assinaturaDigitalEstado !== 'undefined') {
                deveMarcar = !!window.assinaturaDigitalEstado;
            } else {
                console.warn('Variável window.assinaturaDigitalEstado não possui valor definido no modo normal.');
            }
        }

        // 🔸 Marca ou desmarca o checkbox conforme o valor detectado
        checkbox.checked = deveMarcar;

        // 🔸 Atualiza a variável global com o estado atual
        window.assinaturaDigitalEstado = deveMarcar;

        console.log('🔁 Assinatura digital repopulada. Estado atual:', deveMarcar);
    } catch (e) {
        console.error('❌ Erro ao repopular assinatura digital:', e);
    }
}


        window._tiposOrcamentoSelecionados = window._tiposOrcamentoSelecionados || [];
        window._modelosSelecionados = window._modelosSelecionados || [];
        window.assinaturaDigitalEstado = window.assinaturaDigitalEstado || "";
        

        // ============================================================
// 🔹 FUNÇÃO: Restaurar Tipos de Orçamento
// ============================================================
// function restaurar_tipo_orcamento() {
//   debugger;

//   let tipos = [];

//   // 🔸 Detecta origem (modo edição ou normal)
//   if (window.recebe_acao === 'editar') {
//     try {
//       if (typeof window.tipo_orcamento === 'string') {
//         tipos = JSON.parse(window.tipo_orcamento);
//       } else if (Array.isArray(window.tipo_orcamento)) {
//         tipos = window.tipo_orcamento;
//       }
//     } catch (err) {
//       console.error('Erro ao parsear window.tipo_orcamento:', err);
//       tipos = [];
//     }
//   } else {
//     tipos = [...(window._tiposOrcamentoSelecionados || [])];
//   }

//   // Normaliza os tipos para comparação
//   const tiposNormalizados = tipos.map(t => String(t).toLowerCase().trim());

//   const cards = document.querySelectorAll('.tipo-orcamento-card');
//   if (!cards.length) {
//     console.warn('Nenhum .tipo-orcamento-card encontrado.');
//     return;
//   }

//   cards.forEach(card => {
//     // Busca o checkbox de forma segura
//     const checkbox = card.querySelector('input[type="checkbox"]');
//     if (!checkbox) {
//       console.warn('Checkbox não encontrado no card:', card);
//       return; // pula para o próximo card
//     }

//     const spanText = card.querySelector('span')?.textContent?.trim() || '';
//     const dataValue = card.getAttribute('data-value') || '';

//     // Normaliza todas as fontes possíveis para comparação
//     const fontes = [spanText, dataValue, checkbox.value || '']
//       .map(s => s.toLowerCase().trim())
//       .filter(Boolean);

//     // Verifica se algum valor bate com os tipos selecionados
//     const match = tiposNormalizados.some(tipo => fontes.includes(tipo));

//     // Marca ou desmarca o checkbox
//     checkbox.checked = match;

//     // Adiciona ou remove classe visual
//     if (match) card.classList.add('selected');
//     else card.classList.remove('selected');
//   });

//   // Atualiza variável global de tipos selecionados
//   window._tiposOrcamentoSelecionados = Array.from(
//     document.querySelectorAll('.tipo-orcamento-card input[type="checkbox"]:checked')
//   )
//     .map(cb => cb.closest('.tipo-orcamento-card')?.querySelector('span')?.textContent?.trim())
//     .filter(Boolean);

//   // Atualiza lista visual, se existir função
//   if (typeof updateSelectedList === 'function') updateSelectedList();
// }


function restaurar_tipo_orcamento() {
  debugger;
  // 🔹 Obtém os tipos que já estavam selecionados
  let tipos = [];
  if (window.recebe_acao === 'editar') {
    try {
      if (typeof window.tipo_orcamento === 'string') {
        tipos = JSON.parse(window.tipo_orcamento);
      } else if (Array.isArray(window.tipo_orcamento)) {
        tipos = window.tipo_orcamento;
      }
    } catch (err) {
      console.error('Erro ao parsear window.tipo_orcamento:', err);
      tipos = [];
    }
  } else {
    tipos = [...(window._tiposOrcamentoSelecionados || [])];
  }

  // Normaliza os tipos para comparação
  const tiposNormalizados = tipos.map(t => String(t).toLowerCase().trim());

  // 🔹 Percorre todos os labels e marca os checkboxes que correspondem
  document.querySelectorAll('.tipo-orcamento-label').forEach(label => {
    const card = label.querySelector('.tipo-orcamento-card');
    const checkbox = label.querySelector('input[type="checkbox"]');

    if (card && checkbox) {
      const spanText = card.querySelector('span')?.textContent?.trim() || '';
      const dataValue = card.getAttribute('data-value') || '';

      const fontes = [spanText, dataValue, checkbox.value || '']
        .map(s => s.toLowerCase().trim())
        .filter(Boolean);

      const match = fontes.some(f => tiposNormalizados.includes(f));

      checkbox.checked = match;

      if (match) card.classList.add('selected');
      else card.classList.remove('selected');
    }
  });

  // Atualiza variável global para refletir a seleção atual
  window._tiposOrcamentoSelecionados = tipos;

  // Atualiza lista visual se existir função
  if (typeof updateSelectedList === 'function') updateSelectedList();
}






        // Função para repopular produtos apenas para exibição
// function repopular_produtos() {
//   debugger;
//   const container = document.getElementById('fat-lista-produtos');
//   if (!container) {
//     console.error('Container de produtos não encontrado');
//     return;
//   }

//   // Limpa a lista antes de repopular
//   container.innerHTML = '';

//   // Aplica o CSS se ainda não tiver sido aplicado
//   if (!document.getElementById('fat-styles')) {
//     const style = document.createElement('style');
//     style.id = 'fat-styles';
//     style.textContent = `
//       .fat-produto-item {
//         display: flex;
//         align-items: center;
//         gap: 15px;
//         padding: 12px 15px;
//         color: #2d3748;
//         font-size: 14px;
//         border-bottom: 1px solid #e2e8f0;
//         transition: all 0.2s ease;
//         background-color: white;
//         border-radius: 8px;
//         margin-bottom: 8px;
//         box-shadow: 0 1px 3px rgba(0,0,0,0.05);
//       }
//       .fat-produto-item:hover {
//         background-color: #f8fafc;
//         transform: translateY(-1px);
//         box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
//       }
//       .fat-produto-item > div {
//         padding: 4px 8px;
//       }
//       .fat-produto-descricao {
//         flex: 3;
//         font-weight: 500;
//         color: #1a365d;
//       }
//       .fat-produto-quantidade, .fat-produto-valor-unit, .fat-produto-total {
//         flex: 1;
//         text-align: center;
//         color: #4a5568;
//       }
//       .fat-produto-total {
//         font-weight: 600;
//         color: #2b6cb0;
//       }
//       .fat-produto-acoes {
//         flex: 0.8;
//         text-align: center;
//       }
//       .btn-remover {
//         background-color: #fff;
//         color: #e53e3e;
//         border: 1px solid #fed7d7;
//         border-radius: 6px;
//         padding: 6px 12px;
//         font-size: 13px;
//         font-weight: 500;
//         cursor: pointer;
//         display: inline-flex;
//         align-items: center;
//         gap: 4px;
//         transition: all 0.2s ease;
//       }
//       .btn-remover:hover {
//         background-color: #feb2b2;
//         color: #9b2c2c;
//         transform: translateY(-1px);
//       }
//       .btn-remover i {
//         font-size: 14px;
//       }
//     `;
//     document.head.appendChild(style);
//   }

//   if (!Array.isArray(window.produtos) || window.produtos.length === 0) {
//     container.innerHTML = `<div style="color: #6c757d; font-style: italic; text-align: center; padding: 20px 0;">
//       Nenhum produto disponível
//     </div>`;
//     return;
//   }

//   // Percorre os produtos e adiciona na lista
//   window.produtos.forEach(prod => {
//     const valorTotal = prod.quantidade * prod.valorunit;
//     const linha = document.createElement('div');
//     linha.className = 'fat-produto-item';
//     linha.innerHTML = [
//       `<div class="fat-produto-descricao">${prod.nome}</div>`,
//       `<div class="fat-produto-quantidade">${prod.quantidade}</div>`,
//       `<div class="fat-produto-valor-unit">${fatFormatter.format(prod.valor)}</div>`,
//       `<div class="fat-produto-total">${fatFormatter.format(prod.valor)}</div>`,
//       '<div class="fat-produto-acoes">',
//       `  <button class="btn-remover" onclick="fatRemoverProduto(this, ${prod.id}, ${prod.valor})">`,
//       '    <i class="fas fa-trash-alt"></i> Remover',
//       '  </button>',
//       '</div>'
//     ].join('');
//     container.appendChild(linha);
//   });
// }

//verificando repopulação
// =============================
// 🔹 Função para repopular produtos
// =============================
// function repopular_produtos() {
//   debugger;
//   const container = document.getElementById('fat-lista-produtos');
//   if (!container) {
//     console.error('Container de produtos não encontrado');
//     return;
//   }

//   // Limpa a lista antes de repopular
//   container.innerHTML = '';

//   // Aplica o CSS se ainda não tiver sido aplicado
//   if (!document.getElementById('fat-styles')) {
//     const style = document.createElement('style');
//     style.id = 'fat-styles';
//     style.textContent = `
//       .fat-produto-item {
//         display: flex;
//         align-items: center;
//         gap: 15px;
//         padding: 12px 15px;
//         color: #2d3748;
//         font-size: 14px;
//         border-bottom: 1px solid #e2e8f0;
//         transition: all 0.2s ease;
//         background-color: white;
//         border-radius: 8px;
//         margin-bottom: 8px;
//         box-shadow: 0 1px 3px rgba(0,0,0,0.05);
//       }
//       .fat-produto-item:hover {
//         background-color: #f8fafc;
//         transform: translateY(-1px);
//         box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
//       }
//       .fat-produto-item > div {
//         padding: 4px 8px;
//       }
//       .fat-produto-descricao {
//         flex: 3;
//         font-weight: 500;
//         color: #1a365d;
//       }
//       .fat-produto-quantidade, .fat-produto-valor-unit, .fat-produto-total {
//         flex: 1;
//         text-align: center;
//         color: #4a5568;
//       }
//       .fat-produto-total {
//         font-weight: 600;
//         color: #2b6cb0;
//       }
//       .fat-produto-acoes {
//         flex: 0.8;
//         text-align: center;
//       }
//       .btn-remover {
//         background-color: #fff;
//         color: #e53e3e;
//         border: 1px solid #fed7d7;
//         border-radius: 6px;
//         padding: 6px 12px;
//         font-size: 13px;
//         font-weight: 500;
//         cursor: pointer;
//         display: inline-flex;
//         align-items: center;
//         gap: 4px;
//         transition: all 0.2s ease;
//       }
//       .btn-remover:hover {
//         background-color: #feb2b2;
//         color: #9b2c2c;
//         transform: translateY(-1px);
//       }
//       .btn-remover i {
//         font-size: 14px;
//       }
//     `;
//     document.head.appendChild(style);
//   }

//   if (!Array.isArray(window.produtos) || window.produtos.length === 0) {
//     container.innerHTML = `<div style="color: #6c757d; font-style: italic; text-align: center; padding: 20px 0;">
//       Nenhum produto disponível
//     </div>`;
//     window.fatTotalEPI = 0;
//     return;
//   }

//   // 🔹 Calcula o total geral dos produtos
//   let totalProdutos = 0;

//   // Percorre os produtos e adiciona na lista
//   window.produtos.forEach(prod => {
//     const valorUnit = parseFloat(prod.valorunit || prod.valor || 0);
//     const quantidade = parseFloat(prod.quantidade || 1);
//     const valorTotal = valorUnit * quantidade;
//     totalProdutos += valorTotal;

//     const linha = document.createElement('div');
//     linha.className = 'fat-produto-item';
//     linha.innerHTML = [
//       `<div class="fat-produto-descricao">${prod.nome}</div>`,
//       `<div class="fat-produto-quantidade">${quantidade}</div>`,
//       `<div class="fat-produto-valor-unit">${fatFormatter.format(valorUnit)}</div>`,
//       `<div class="fat-produto-total">${fatFormatter.format(valorTotal)}</div>`,
//       '<div class="fat-produto-acoes">',
//       `  <button class="btn-remover" onclick="fatRemoverProduto(this, ${prod.id}, ${valorTotal})">`,
//       '    <i class="fas fa-trash-alt"></i> Remover',
//       '  </button>',
//       '</div>'
//     ].join('');
//     container.appendChild(linha);
//   });

//   // 🔸 Armazena o total global de produtos
//   window.fatTotalEPI = totalProdutos;
// }

// ============================================================
// 🔹 Função para repopular produtos
// ============================================================
function repopular_produtos() {
  debugger;
  const container = document.getElementById('fat-lista-produtos');
  if (!container) {
    console.error('Container de produtos não encontrado');
    return;
  }

  container.innerHTML = ''; // limpa antes

  // Define a fonte de dados conforme o modo
  const isEdicao = window.recebe_acao === 'editar';
  const produtosFonte = isEdicao
    ? window.produtos
    : window.fatProdutosGlobais;

  if (!Array.isArray(produtosFonte) || produtosFonte.length === 0) {
    container.innerHTML = `<div style="color:#6c757d;font-style:italic;text-align:center;padding:20px 0;">
      Nenhum produto disponível
    </div>`;
    window.fatTotalEPI = 0;
    return;
  }

  // Calcula total geral
  let totalProdutos = 0;

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

  produtosFonte.forEach(prod => {
    const valorUnit = parseFloat(prod.valorunit || prod.valor || 0);
    const quantidade = parseFloat(prod.quantidade || 1);
    const valorTotal = valorUnit * quantidade;
    totalProdutos += valorTotal;

    const linha = document.createElement('div');
    linha.className = 'fat-produto-item';
    linha.innerHTML = [
      `<div class="fat-produto-descricao">${prod.nome}</div>`,
      `<div class="fat-produto-quantidade">${quantidade}</div>`,
      `<div class="fat-produto-valor-unit">${fatFormatter.format(valorUnit)}</div>`,
      `<div class="fat-produto-total">${fatFormatter.format(valorTotal)}</div>`,
      '<div class="fat-produto-acoes">',
      `  <button class="btn-remover" onclick="fatRemoverProduto(this, ${prod.id || 0}, ${valorTotal})">`,
      '    <i class="fas fa-trash-alt"></i> Remover',
      '  </button>',
      '</div>'
    ].join('');
    container.appendChild(linha);
  });

  // Atualiza total global
  window.fatTotalEPI = totalProdutos;
  console.log('Total de produtos atualizado:', window.fatTotalEPI);
}



        function carregarAsChavesPIX()
        {
          const pixKeySelect = document.getElementById('pix-key-select');
    if (!pixKeySelect) return;

    // Limpa as opções exceto a primeira
    while (pixKeySelect.options.length > 1) {
        pixKeySelect.remove(1);
    }

    // Faz a requisição para buscar as chaves PIX
    $.ajax({
        url: 'cadastros/processa_conta_bancaria.php',
        method: 'GET',
        dataType: 'json',
        data: { 
            processo_conta_bancaria: 'buscar_contas_bancarias' 
        },
        success: function(res) {
          debugger;
            try {
                if (Array.isArray(res) && res.length) {
                    const vistos = new Set();
                    res.forEach(item => {
                        const tipo = String(item.tipo_pix || '').trim();
                        const valor = String(item.valor_pix || '').trim();
                        if (!tipo || !valor) return;
                        
                        const chave = `${tipo}|${valor}`;
                        if (vistos.has(chave)) return;
                        vistos.add(chave);
                        
                        const opt = document.createElement('option');
                        opt.value = valor;
                        opt.textContent = `${tipo.toUpperCase()}: ${valor}`;
                        pixKeySelect.appendChild(opt);
                    });
                }
            } catch(e) {
                console.error('Erro ao processar chaves PIX:', e);
            }
        },
        error: function(xhr, status, error) {
            console.error('Erro ao carregar chaves PIX:', error);
        }
    });
        }

        function carregarAgenciasContas()
        {
          // Carrega Agência/Conta do backend (apenas agência e conta)
            $.ajax({
              url: 'cadastros/processa_conta_bancaria.php',
              method: 'GET',
              dataType: 'json',
              data: { processo_conta_bancaria: 'buscar_contas_bancarias' },
              success: function(res){
                debugger;
                try {
                  const sel = document.getElementById('agencia-conta-select');
                  if (!sel) return;
                  // Limpa mantendo o placeholder
                  while (sel.options.length > 1) sel.remove(1);
                  let adicionou = false;
                  if (Array.isArray(res)) {
                    const vistos = new Set();
                    res.forEach(it => {
                      const agencia = String(it.agencia || '').trim();
                      const conta = String(it.conta || '').trim();
                      if (!agencia || !conta) return;
                      const value = `${agencia}|${conta}`;
                      if (vistos.has(value)) return;
                      vistos.add(value);
                      const opt = document.createElement('option');
                      opt.value = value;
                      opt.textContent = `Ag ${agencia} • C/C ${conta}`;
                      sel.appendChild(opt);
                      adicionou = true;
                    });
                  }
                  // Se não veio nada do backend, mantém o fallback de exemplos (abaixo)
                  if (!adicionou) {
                    // não faz nada aqui; o bloco acPopularExemplos() cuidará
                  }
                } catch(e){ console.warn('Falha ao popular Agência/Conta via AJAX:', e); }
              },
              error: function(xhr, status, error){
                console.warn('Erro ao buscar contas bancárias:', status, error);
                // Em caso de erro, o fallback de exemplos (abaixo) será usado
              }
            });
        }

        

        // ============================================================
// 🔹 FUNÇÃO: Restaurar Modelos Selecionados
// ============================================================
function restaurarModelosSelecionados() {
  debugger;

  let modelos = [];

  // 🔸 Detecta origem dos dados
  if (window.recebe_acao === 'editar') {
    try {
      if (Array.isArray(window.modelos_documentos)) {
        modelos = window.modelos_documentos.slice();
      } else if (typeof window.modelos_documentos === 'string') {
        const parsed = JSON.parse(window.modelos_documentos);
        modelos = Array.isArray(parsed) ? parsed : [window.modelos_documentos];
      }
    } catch (err) {
      console.warn('Erro ao interpretar modelos_documentos:', err);
      modelos = [];
    }
  } else {
    modelos = [...(window._modelosSelecionados || [])];
  }

  const modelosNorm = modelos.map(m => String(m).toLowerCase().trim());

  document.querySelectorAll('.sm-label').forEach(label => {
    const card = label.querySelector('.sm-card');
    const checkbox = label.querySelector('input[type="checkbox"]');
    const text = card?.querySelector('span')?.textContent?.trim().toLowerCase() || '';

    if (checkbox) {
      checkbox.checked = modelosNorm.includes(text);
    }
  });

  // Atualiza variável global
  window._modelosSelecionados = Array.from(
    document.querySelectorAll('.sm-card input[type="checkbox"]:checked')
  ).map(cb => cb.closest('.sm-card').querySelector('span')?.textContent?.trim())
   .filter(Boolean);

  if (typeof updateSelectedList === 'function') updateSelectedList();
}




        // const pixKeySelect = document.getElementById('pix-key-select');
        // if (!pixKeySelect) return;

        // let chavesExemplo = [];

        // // Adiciona as chaves ao select
        // chavesExemplo.forEach(chave => {
        //   const option = document.createElement('option');
        //   option.value = chave.chave;
        //   option.textContent = `${chave.tipo}: ${chave.chave} (${chave.banco} - Ag ${chave.agencia} C/C ${chave.conta})`;
        //   pixKeySelect.appendChild(option);
        // });


        // $.ajax({
        //       url: 'cadastros/processa_conta_bancaria.php',
        //       method: 'GET',
        //       dataType: 'json',
        //       data: { processo_conta_bancaria: 'buscar_contas_bancarias' },
        //       success: function(res){
        //         debugger;
        //         try {
        //           const pixKeySelect = document.getElementById('pix-key-select');
        //           if (!pixKeySelect) return;
        //           // Limpa as opções exceto a primeira (placeholder)
        //           while (pixKeySelect.options.length > 1) {
        //             pixKeySelect.remove(1);
        //           }
        //           if (Array.isArray(res) && res.length) {
        //             const vistos = new Set();
        //             res.forEach(item => {
        //               const tipo = String(item.tipo_pix || '').trim();
        //               const valor = String(item.valor_pix || '').trim();
        //               if (!tipo || !valor) return;
        //               const chave = `${tipo}|${valor}`;
        //               if (vistos.has(chave)) return;
        //               vistos.add(chave);
        //               const opt = document.createElement('option');
        //               opt.value = valor;
        //               opt.textContent = `${tipo.toUpperCase()}: ${valor}`;
        //               pixKeySelect.appendChild(opt);
        //             });
        //           }
        //         } catch(e) {
        //           console.warn('Falha ao popular chaves PIX:', e);
        //         }
        //       },
        //       error:function(xhr,status,error)
        //       {

        //       },
        //     });

        // Restaura os produtos da variável global
        if (window.fatProdutosSelecionados && window.fatProdutosSelecionados.length > 0) {
          console.log('Restaurando produtos da memória:', window.fatProdutosSelecionados);
          
          // Pequeno atraso para garantir que o DOM foi completamente renderizado
          setTimeout(() => {
            debugger;
            const listaProdutos = document.getElementById('fat-lista-produtos');
            if (listaProdutos) {
              // Limpa a lista atual
              listaProdutos.innerHTML = '';
              
              // Recria os itens da lista
              window.fatProdutosSelecionados.forEach(produto => {
                const linha = document.createElement('div');
                linha.className = 'fat-produto-item';
                
                const html = [
                  `<div class="fat-produto-descricao">${produto.descricao || ''}</div>`,
                  `<div class="fat-produto-quantidade">${produto.quantidade || 0}</div>`,
                  `<div class="fat-produto-valor-unit">${window.fatFormatter ? window.fatFormatter.format(produto.valorunit || 0) : (produto.valorunit || 0)}</div>`,
                  `<div class="fat-produto-total">${window.fatFormatter ? window.fatFormatter.format((produto.valorunit || 0) * (produto.quantidade || 0)) : ((produto.valorunit || 0) * (produto.quantidade || 0))}</div>`,
                  '<div class="fat-produto-acoes">',
                  `  <button class="btn-remover" onclick="fatRemoverProduto(this, ${produto.id || 0}, ${(produto.valorunit || 0) * (produto.quantidade || 0)})">`,
                  '    <i class="fas fa-trash-alt"></i> Remover',
                  '  </button>',
                  '</div>'
                ].join('');
                
                linha.innerHTML = html;
                listaProdutos.appendChild(linha);
              });
              
              // Atualiza os totais
              if (typeof window.fatAtualizarTotais === 'function') {
                window.fatAtualizarTotais();
              }
            }
          }, 100);
        }

        // Restaura os tipos de orçamento selecionados
if ((window.smDocumentosSelecionadosNomes && window.smDocumentosSelecionadosNomes.length > 0) || 
    (window.smDocumentosSelecionadosBackup && window.smDocumentosSelecionadosBackup.length > 0)) {
      debugger;
  
  const tiposParaRestaurar = window.smDocumentosSelecionadosNomes.length > 0 ? 
    window.smDocumentosSelecionadosNomes : window.smDocumentosSelecionadosBackup;
  
  console.log('Restaurando tipos de orçamento selecionados:', tiposParaRestaurar);
  
  // Pequeno atraso para garantir que o DOM foi completamente renderizado
  setTimeout(() => {
    debugger;
    const tipoOrcamentoLabels = document.querySelectorAll('.tipo-orcamento-label');
    
    tipoOrcamentoLabels.forEach(label => {
      const checkbox = label.querySelector('input[type="checkbox"]');
      const card = label.querySelector('.tipo-orcamento-card');
      
      if (checkbox && card) {
        const text = card.querySelector('span')?.textContent?.trim() || '';
        
        // Verifica se este tipo de orçamento está na lista de selecionados
        const isSelected = tiposParaRestaurar.some(nome => 
          nome.toLowerCase() === text.toLowerCase()
        );
        
        // Atualiza o estado do checkbox
        if (isSelected) {
          checkbox.checked = true;
          card.classList.add('selected');
          // Garante que o nome está na lista global
          if (!window.smDocumentosSelecionadosNomes.includes(text)) {
            window.smDocumentosSelecionadosNomes.push(text);
          }
        } else {
          checkbox.checked = false;
          card.classList.remove('selected');
        }
      }
    });
    
    // Atualiza a lista de selecionados
    if (typeof updateSelectedList === 'function') {
      updateSelectedList();
    }
  }, 300);
}

// Adiciona o event listener para futuras mudanças
        $(document).off('change', '#requer-assinatura').on('change', '#requer-assinatura', function() {
          debugger;
            window.assinaturaDigitalEstado = $(this).is(':checked');
            console.log('Estado da assinatura atualizado para:', window.assinaturaDigitalEstado);
            atualizarEstadoAssinatura($(this).is(':checked'));
        });

        function atualizarEstadoAssinatura(assinatura)
{
  debugger;
  window.assinaturaDigitalEstado = assinatura;
}

      setTimeout(() => {
        debugger;
    const checkbox = document.getElementById('requer-assinatura');
    if (checkbox) {
        // Verifica se existe um estado salvo
        if (typeof window.assinaturaDigitalEstado !== 'undefined') {
            // Define o estado do checkbox com o valor salvo
            checkbox.checked = Boolean(window.assinaturaDigitalEstado);
            console.log('Estado da assinatura restaurado:', window.assinaturaDigitalEstado);
        }
        
    }
}, 100);

setTimeout(restaurarEstadoBancario, 200);

function restaurarEstadoBancario() {
    debugger;
    const estado = window.dadosBancariosEstado;
    if (!estado) return;

    console.log('Restaurando estado bancário:', estado);

    // Função auxiliar para marcar um checkbox
    const marcarCheckbox = (valor, tipo) => {
        const input = document.querySelector(`input[value="${tipo}"]`);
        if (input) {
            input.checked = valor;
            input.dispatchEvent(new Event('change'));
        }
    };

    // Restaura os checkboxes
    marcarCheckbox(estado.pixSelecionado, 'pix');
    marcarCheckbox(estado.agenciaContaSelecionado, 'agencia-conta');
    marcarCheckbox(estado.qrcodeSelecionado, 'qrcode');

    // Restaura os valores dos selects
setTimeout(() => {
    // Função para normalizar PIX (apenas números)
    const formatarPix = (pix) => pix.replace(/\D/g, '');

    // Função para normalizar Agência/Conta ("Ag XXXX • C/C XXXXX-X" -> "XXXX|XXXXX-X")
    const formatarAgenciaConta = (ac) => ac
        .replace(/Ag\s*/, '')        // Remove "Ag " do início
        .replace(/• C\/C\s*/, '|')   // Substitui "• C/C " por "|"
        .replace(/\s+/g, '')          // Remove espaços extras
        .trim();

    // Restaura PIX
    if (estado.chavePix) {
        const pixSelect = document.getElementById('pix-key-select');
        const pixContainer = document.getElementById('pix-selector-container');

        if (pixSelect && pixContainer) {
            let valorPix = estado.chavePix;

            if (window.recebe_acao === 'editar') {
                valorPix = formatarPix(valorPix);
            }

            pixSelect.value = valorPix;
            pixContainer.style.display = 'block';
            pixSelect.dispatchEvent(new Event('change'));
        }
    }

    // Restaura Agência/Conta
    if (estado.agenciaConta) {
        const acSelect = document.getElementById('agencia-conta-select');
        const acContainer = document.getElementById('agencia-selector-container');

        if (acSelect && acContainer) {
            let valorAC = estado.agenciaConta;

            if (window.recebe_acao === 'editar') {
                valorAC = formatarAgenciaConta(valorAC);
            }

            acSelect.value = valorAC;
            acContainer.style.display = 'block';
            acSelect.dispatchEvent(new Event('change'));
        }
    }

    // Força a atualização da UI
    if (typeof atualizarVisibilidadePix === 'function') {
        atualizarVisibilidadePix();
    }
}, 100);

}
        
        // Pequeno atraso para garantir que o DOM foi atualizado
        setTimeout(() => {
          console.log('=== Inicializando módulo de Conta Bancária ===');
          
          // Elementos da interface
          const tipoContaInputs = document.querySelectorAll('input[name="tipo-conta"]');
          const pixSelectorContainer = document.getElementById('pix-selector-container');
          const btnAdicionarPix = document.getElementById('btn-adicionar-pix');
          const btnAdicionarPixOutside = document.getElementById('btn-adicionar-pix-outside');
          const modalContaBancaria = document.getElementById('modal-conta-bancaria');

          // Captura o valor selecionado no momento e grava antes de seguir
          // try {
          //   const selecionadoEtapa5 = document.querySelector('input[name="tipo-conta"]:checked');
          //   const tipoValorInicialEtapa5 = selecionadoEtapa5 ? selecionadoEtapa5.value : '';
          //   if (tipoValorInicialEtapa5) {
          //     gravar_tipo_dado_bancario(tipoValorInicialEtapa5);
          //   }
          // } catch (e) { /* noop */ }

          // Verificar se os elementos necessários existem
          if (!tipoContaInputs.length || !pixSelectorContainer || !modalContaBancaria) {
            console.warn('Elementos necessários para o módulo de Conta Bancária não encontrados');
            return;
          }
          
          // Verificar se o módulo já foi inicializado
          if (window.contaBancariaInicializada) {
            console.log('Módulo de Conta Bancária já foi inicializado');
            return;
          }
          
          // Marcar como inicializado
          window.contaBancariaInicializada = true;
          
          // Verificar se o tipo PIX já está selecionado
          const pixRadio = document.querySelector('input[value="pix"]');
          if (pixRadio && pixRadio.checked) {
            pixSelectorContainer.style.display = 'block';
          }
          
          // Mostrar/ocultar seletor de chave PIX quando PIX for selecionado
          function atualizarVisibilidadePix() {
            const pixSelecionado = Array.from(tipoContaInputs).some(
              input => input.value === 'pix' && input.checked
            );
            
            pixSelectorContainer.style.display = pixSelecionado ? 'block' : 'none';
          }

          // Função para atualizar o estado global dos dados bancários
function atualizarEstadoBancario(tipo, valor, texto) {
    debugger;

    // Inicializa o objeto se não existir
    window.dadosBancariosEstado = window.dadosBancariosEstado || {
        pixSelecionado: false,
        agenciaContaSelecionado: false,
        qrcodeSelecionado: false,
        chavePix: null,
        textoPix: null,
        agenciaConta: null,
        textoAgenciaConta: null,
        __dadosCarregados: false
    };

    // Garante que a flag exista mesmo se o objeto já existia
    if (typeof window.dadosBancariosEstado.__dadosCarregados === 'undefined') {
        window.dadosBancariosEstado.__dadosCarregados = false;
    }

    // 🔹 Se estiver em modo edição, carrega uma vez os dados gravados
    if (window.recebe_acao === 'editar' && !window.dadosBancariosEstado.__dadosCarregados) {
        console.log('Modo edição detectado. Carregando dados bancários existentes...');

        const dadosGravados = window.dadosBancariosEstado || {};

        // ---------------- PIX ----------------
        if (dadosGravados.chavePix) {
            window.dadosBancariosEstado.pixSelecionado = true;
            window.dadosBancariosEstado.chavePix = dadosGravados.chavePix;
            window.dadosBancariosEstado.textoPix = dadosGravados.textoPix || dadosGravados.chavePix;

            const pixSelect = document.getElementById('pix-key-select');
            if (pixSelect) {
                // Verifica se é <select> ou conjunto de <input type="radio">
                if (pixSelect.tagName === 'SELECT') {
                  
                    // Percorre opções e seleciona a que corresponde
                    for (const opt of pixSelect.options) {
                      // Remove tudo que não for número
const chaveFormatada = dadosGravados.chavePix.replace(/\D/g, '');
                        if (opt.value === chaveFormatada) {
                            opt.selected = true;
                            break;
                        }
                    }
                } else {
                    // Caso seja checkbox ou radio
                    const pixOptions = document.querySelectorAll('#pix-key-select input[type="radio"], #pix-key-select input[type="checkbox"]');
                    pixOptions.forEach(opt => {
                        if (opt.value === dadosGravados.chavePix) {
                            opt.checked = true;
                        }
                    });
                }
            }
        }

        // ---------------- AGÊNCIA / CONTA ----------------
        if (dadosGravados.agenciaConta) {
            window.dadosBancariosEstado.agenciaContaSelecionado = true;
            window.dadosBancariosEstado.agenciaConta = dadosGravados.agenciaConta;
            window.dadosBancariosEstado.textoAgenciaConta = dadosGravados.textoAgenciaConta || dadosGravados.agenciaConta;

            const acSelect = document.getElementById('agencia-conta-select');
            if (acSelect) {
                if (acSelect.tagName === 'SELECT') {
                    for (const opt of acSelect.options) {
                      // Converte dadosGravados.chavePix para o formato do opt.value
const chaveFormatada = dadosGravados.agenciaConta
    .replace(/Ag\s*/, '')        // Remove "Ag " do início
    .replace(/• C\/C\s*/, '|')   // Substitui "• C/C " por "|"
    .replace(/\s+/g, '')          // Remove todos os espaços restantes
    .trim();

if (opt.value === chaveFormatada) {
    opt.selected = true;
    break;
}

                        if (opt.value === chaveFormatada) {
                            opt.selected = true;
                            break;
                        }
                    }
                } else {
                    const acOptions = document.querySelectorAll('#agencia-conta-select input[type="radio"], #agencia-conta-select input[type="checkbox"]');
                    acOptions.forEach(opt => {
                        if (opt.value === dadosGravados.agenciaConta) {
                            opt.checked = true;
                        }
                    });
                }
            }
        }

        // ---------------- QRCODE ----------------
        if (dadosGravados.qrcodeSelecionado !== undefined) {
            window.dadosBancariosEstado.qrcodeSelecionado = dadosGravados.qrcodeSelecionado;

            const qrCheckbox = document.getElementById('qrcode-check');
            if (qrCheckbox) {
                qrCheckbox.checked = Boolean(dadosGravados.qrcodeSelecionado);
            }
        }

        // Marca que os dados já foram carregados (para não recarregar em cada chamada)
        window.dadosBancariosEstado.__dadosCarregados = true;

        console.log('Dados bancários carregados para edição:', window.dadosBancariosEstado);

        // ⚠️ Sai da função — não executa atualização normal
        return;
    }

    // 🔹 Caso contrário (não está em edição), executa atualização normal
    if (window.recebe_acao !== 'editar') {
        console.log('Atualizando estado bancário (modo gravação):', { tipo, valor, texto });

        if (tipo === 'pix') {
            window.dadosBancariosEstado.pixSelecionado = valor !== null;
            if (valor !== null) {
                window.dadosBancariosEstado.chavePix = valor;
                window.dadosBancariosEstado.textoPix = texto;
            }
        } 
        else if (tipo === 'agencia-conta') {
            window.dadosBancariosEstado.agenciaContaSelecionado = valor !== null;
            if (valor !== null) {
                window.dadosBancariosEstado.agenciaConta = valor;
                window.dadosBancariosEstado.textoAgenciaConta = texto;
            }
        } 
        else if (tipo === 'qrcode') {
            window.dadosBancariosEstado.qrcodeSelecionado = valor;
        }

        console.log('Estado bancário atualizado:', window.dadosBancariosEstado);
    }
}

// ============================================================
// 🔹 Controle inicial
// ============================================================
window._habilitarGravacaoBancaria = false;  // só ativa após clique real
window._carregandoAbaBancaria = false;      // true somente se for setado manualmente

// ============================================================
// 🔹 Função para tratar seleção do tipo bancário pelo usuário
// ============================================================
// function tratarSelecaoTipoBancario(input) {
//   debugger;

//   const tipo = input.value;
//   const estaMarcado = input.checked;

//   // 🟢 Ativa gravação na primeira ação real
//   if (!window._habilitarGravacaoBancaria) {
//     console.log('🟢 Usuário interagiu com dados bancários — gravação habilitada.');
//     window._habilitarGravacaoBancaria = true;
//   }

//   if (tipo === 'pix' && estaMarcado) {
//     atualizarEstadoBancario('pix', null, null);
//   } else if (tipo === 'agencia-conta' && estaMarcado) {
//     atualizarEstadoBancario('agencia-conta', null, null);
//   } else if (tipo === 'qrcode') {
//     atualizarEstadoBancario('qrcode', estaMarcado, null);
//   }

//   if (pixSelectorContainer) {
//     const algumPixMarcado = Array.from(tipoContaInputs).some(i => i.value === 'pix' && i.checked);
//     pixSelectorContainer.style.display = algumPixMarcado ? 'block' : 'none';
//   }

//   const selecionados = Array.from(tipoContaInputs)
//     .filter(i => i.checked)
//     .map(i => i.value);

//   console.group('💾 Tipo bancário selecionado');
//   console.log('Selecionados:', selecionados);
//   console.groupEnd();

//   // ✅ Só grava se o usuário tiver interagido (flag true)
//   if (window._habilitarGravacaoBancaria) {
//     gravar_tipo_dado_bancario(JSON.stringify(selecionados));
//   } else {
//     console.warn('⏸️ Gravação ignorada — interação do usuário ainda não detectada.');
//   }
// }

// ============================================================
// 🔹 Função para tratar seleção do tipo bancário pelo usuário
// ============================================================
function tratarSelecaoTipoBancario(input) {
  debugger;

  const tipo = input.value;
  const estaMarcado = input.checked;
  const emEdicao = window.recebe_acao === 'editar';

  // 🟢 Marca que o usuário interagiu (habilita gravação)
  if (!window._habilitarGravacaoBancaria) {
    console.log('🟢 Interação detectada — gravação habilitada.');
    window._habilitarGravacaoBancaria = true;
  }

  // Garante que o estado global existe
  window.dadosBancariosEstado = window.dadosBancariosEstado || {
    pixSelecionado: false,
    agenciaContaSelecionado: false,
    qrcodeSelecionado: false,
    chavePix: null,
    textoPix: null,
    agenciaConta: null,
    textoAgenciaConta: null,
    __dadosCarregados: false
  };

  // =======================================================
  // 🔹 Atualiza ou limpa estado conforme o tipo e marcação
  // =======================================================
  if (tipo === 'pix') {
    if (estaMarcado) {
      atualizarEstadoBancario('pix', window.dadosBancariosEstado.chavePix, window.dadosBancariosEstado.textoPix);
      window.dadosBancariosEstado.pixSelecionado = true;
    } else {
      // 🔴 Desmarcado — limpa dados PIX
      window.dadosBancariosEstado.pixSelecionado = false;
      window.dadosBancariosEstado.chavePix = null;
      window.dadosBancariosEstado.textoPix = null;

      // 🔹 Atualiza banco (zera PIX)
      if (emEdicao) {
        gravar_pix(""); // modo edição — envia vazio e atualizar_kit
      } else {
        gravar_pix(""); // modo gravação normal — envia vazio e incluir_valores_kit
      }
    }
  } 
  else if (tipo === 'agencia-conta') {
    if (estaMarcado) {
      atualizarEstadoBancario('agencia-conta', window.dadosBancariosEstado.agenciaConta, window.dadosBancariosEstado.textoAgenciaConta);
      window.dadosBancariosEstado.agenciaContaSelecionado = true;
    } else {
      // 🔴 Desmarcado — limpa dados Agência/Conta
      window.dadosBancariosEstado.agenciaContaSelecionado = false;
      window.dadosBancariosEstado.agenciaConta = null;
      window.dadosBancariosEstado.textoAgenciaConta = null;

      // 🔹 Atualiza banco (zera Agência/Conta)
      if (emEdicao) {
        gravar_agencia_conta(""); // modo edição — envia vazio e atualizar_kit
      } else {
        gravar_agencia_conta(""); // modo gravação normal — envia vazio e incluir_valores_kit
      }
    }
  } 
  else if (tipo === 'qrcode') {
    window.dadosBancariosEstado.qrcodeSelecionado = estaMarcado;
    atualizarEstadoBancario('qrcode', estaMarcado, null);
  }

  // =======================================================
  // 🔹 Controle visual dos containers (PIX e Agência)
  // =======================================================
  const pixSelectorContainer = document.getElementById('pix-selector-container');
  const agenciaSelectorContainer = document.getElementById('agencia-selector-container');
  const tipoContaInputs = document.querySelectorAll('input[name="tipo-conta"]');

  if (pixSelectorContainer) {
    const algumPixMarcado = Array.from(tipoContaInputs)
      .some(i => i.value === 'pix' && i.checked);
    pixSelectorContainer.style.display = algumPixMarcado ? 'block' : 'none';
  }

  if (agenciaSelectorContainer) {
    const algumaAgenciaMarcada = Array.from(tipoContaInputs)
      .some(i => i.value === 'agencia-conta' && i.checked);
    agenciaSelectorContainer.style.display = algumaAgenciaMarcada ? 'block' : 'none';
  }

  // =======================================================
  // 🔹 Monta a lista de tipos atualmente marcados
  // =======================================================
  const selecionados = Array.from(tipoContaInputs)
    .filter(i => i.checked)
    .map(i => i.value);

  console.group('💾 Tipos bancários selecionados (atualizados)');
  console.log('Selecionados:', selecionados);
  console.groupEnd();

  // =======================================================
  // 🔹 Atualiza o estado global com os tipos selecionados
  // =======================================================
  if (selecionados.includes('pix')) {
    atualizarEstadoBancario('pix', window.dadosBancariosEstado.chavePix, window.dadosBancariosEstado.textoPix);
  }
  if (selecionados.includes('agencia-conta')) {
    atualizarEstadoBancario('agencia-conta', window.dadosBancariosEstado.agenciaConta, window.dadosBancariosEstado.textoAgenciaConta);
  }
  if (selecionados.includes('qrcode')) {
    atualizarEstadoBancario('qrcode', true, null);
  }

  // =======================================================
  // 🔹 Envia para gravação (edição ou nova criação)
  // =======================================================
  if (emEdicao || window._habilitarGravacaoBancaria) {
    console.log('💾 Enviando para gravar_tipo_dado_bancario:', selecionados);
    gravar_tipo_dado_bancario(JSON.stringify(selecionados));
  } else {
    console.warn('⏸️ Gravação ignorada — interação do usuário ainda não detectada.');
  }
}

function gravar_pix(pix) {
  debugger;
  const emEdicao = window.recebe_acao === 'editar';

  $.ajax({
    url: "cadastros/processa_geracao_kit.php",
    type: "POST",
    dataType: "json",
    async: false,
    data: emEdicao ? {
      processo_geracao_kit: "atualizar_kit",
      valor_pix: pix,
      valor_id_kit: window.recebe_id_kit
    } : {
      processo_geracao_kit: "incluir_valores_kit",
      valor_pix: pix
    },
    success: function(ret) { 
      const mensagemSucesso = `
                <div id="dados-pix-gravado" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
                  <div style="display: flex; align-items: center; justify-content: center;">
                    
                    <div>
                      
                      <div>KIT atualizado com sucesso.</div>
                    </div>
                  </div>
                </div>
          `;

          // Remove mensagem anterior se existir
          $("#dados-pix-gravado").remove();
              
          // Adiciona a nova mensagem acima das abas
          $(".tabs-container").before(mensagemSucesso);

          // Configura o fade out após 5 segundos
          setTimeout(function() {
            $("#dados-pix-gravado").fadeOut(500, function() {
            $(this).remove();
            });
          }, 5000);


          // $("#exame-gravado").html(retorno_exame_geracao_kit);
          // $("#exame-gravado").show();
          // $("#exame-gravado").fadeOut(4000);
     },
    error: function(xhr, status, error) { console.log("Erro:", error); }
  });
}

function gravar_agencia_conta(agencia_conta) {
  debugger;
  const emEdicao = window.recebe_acao === 'editar';

  $.ajax({
    url: "cadastros/processa_geracao_kit.php",
    type: "POST",
    dataType: "json",
    async: false,
    data: emEdicao ? {
      processo_geracao_kit: "atualizar_kit",
      valor_agencia_conta: agencia_conta,
      valor_id_kit: window.recebe_id_kit
    } : {
      processo_geracao_kit: "incluir_valores_kit",
      valor_agencia_conta: agencia_conta
    },
    success: function(ret) { 
      const mensagemSucesso = `
                <div id="dados-agencia-conta-gravado" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
                  <div style="display: flex; align-items: center; justify-content: center;">
                    
                    <div>
                      
                      <div>KIT atualizado com sucesso.</div>
                    </div>
                  </div>
                </div>
          `;

          // Remove mensagem anterior se existir
          $("#dados-agencia-conta-gravado").remove();
              
          // Adiciona a nova mensagem acima das abas
          $(".tabs-container").before(mensagemSucesso);

          // Configura o fade out após 5 segundos
          setTimeout(function() {
            $("#dados-agencia-conta-gravado").fadeOut(500, function() {
            $(this).remove();
            });
          }, 5000);


          // $("#exame-gravado").html(retorno_exame_geracao_kit);
          // $("#exame-gravado").show();
          // $("#exame-gravado").fadeOut(4000);

     },
    error: function(xhr, status, error) { console.log("Erro:", error); }
  });
}


// ============================================================
// 🔹 Associação de eventos — apenas clique real do usuário
// ============================================================
tipoContaInputs.forEach(input => {
  // Remove eventuais listeners antigos (segurança)
  input.replaceWith(input.cloneNode(true));
});

// document.querySelectorAll('input[name="tipo-conta"]').forEach(input => {
//   debugger;
//   input.addEventListener('click', function () {
//     // 🚫 Se estiver carregando aba, ignora
//     if (window._carregandoAbaBancaria) {
//       console.log('⏸️ Clique ignorado — aba bancária ainda carregando.');
//       return;
//     }

//     // ✅ Chama tratamento somente em clique do usuário
//     tratarSelecaoTipoBancario(this);
//   });
// });

// Marca se o usuário clicou manualmente
window._mudancaManualTipoConta = false;

// Detecta clique manual
document.querySelectorAll('input[name="tipo-conta"]').forEach(input => {
  debugger;
  input.addEventListener('mousedown', () => window._mudancaManualTipoConta = true);
  input.addEventListener('keydown', () => window._mudancaManualTipoConta = true);
  input.addEventListener('click', () => window._carregandoAbaBancaria = false);
  input.addEventListener('click', () => window._mudancaManualTipoConta = true);

  input.addEventListener('click', function () {
    debugger;
    try {
      // 🚫 Ignora clique se a aba bancária ainda estiver carregando
      if (window._carregandoAbaBancaria) {
        console.log('⏸️ Clique ignorado — aba bancária ainda carregando.');
        return;
      }

      // 🚫 Ignora se não foi uma interação manual
      if (!window._mudancaManualTipoConta) {
        console.log('⏸️ Clique ignorado — não foi interação manual.');
        return;
      }

      // ✅ Executa a função de tratamento
      tratarSelecaoTipoBancario(this);

    } catch (e) {
      console.error('❌ Erro no clique de tipo-conta:', e);
    } finally {
      // 🔹 Reseta a flag após o uso
      window._mudancaManualTipoConta = false;
    }
  });
});


          
          // Mostrar/ocultar seletor de chave PIX quando PIX for selecionado
  // Modifique o evento change dos inputs de tipo de conta
// tipoContaInputs.forEach(input => {
//     input.addEventListener('change', function() {
//       debugger;
//         const tipo = this.value;
//         const estaMarcado = this.checked;
        
//         // Atualiza o estado global
//         if (tipo === 'pix' && estaMarcado) {
//             atualizarEstadoBancario('pix', estaMarcado, null);
//         } else if (tipo === 'agencia-conta' && estaMarcado) {
//             atualizarEstadoBancario('agencia-conta', estaMarcado, null);
//         } else if (tipo === 'qrcode') {
//             atualizarEstadoBancario('qrcode', estaMarcado, null);
//         }

//         // Verifica se algum checkbox de PIX está marcado
//         if (pixSelectorContainer) {
//             const algumPixMarcado = Array.from(tipoContaInputs).some(i => i.value === 'pix' && i.checked);
//             pixSelectorContainer.style.display = algumPixMarcado ? 'block' : 'none';
//         }

//         try {
//             console.group('Conta Bancária > tipo-conta change');
//             console.log('Input clicado:', this);
//             console.log('Valor selecionado:', this.value);
//             console.groupEnd();
//         } catch (e) { /* noop */ }

//         // Grava imediatamente todas as opções selecionadas como array JSON
//         const selecionados = Array.from(tipoContaInputs)
//             .filter(i => i.checked)
//             .map(i => i.value);
        
//         // Atualiza o estado global com os tipos selecionados
//         if (selecionados.includes('pix')) {
//             atualizarEstadoBancario('pix', window.dadosBancariosEstado.chavePix, window.dadosBancariosEstado.textoPix);
//         }
//         if (selecionados.includes('agencia-conta')) {
//             atualizarEstadoBancario('agencia-conta', window.dadosBancariosEstado.agenciaConta, window.dadosBancariosEstado.textoAgenciaConta);
//         }
//         if (selecionados.includes('qrcode')) {
//             atualizarEstadoBancario('qrcode', true, null);
//         }

//         gravar_tipo_dado_bancario(JSON.stringify(selecionados));
//     });
// });
          
          // Função para abrir o modal de cadastro de chave PIX
          function abrirModalChavePix() {
            // Marcar o radio de PIX se ainda não estiver marcado
            const radioPix = document.querySelector('input[value="pix"]');
            if (radioPix && !radioPix.checked) {
              radioPix.checked = true;
              atualizarVisibilidadePix();
            }
            
            // Mostrar o modal
            modalContaBancaria.style.display = 'block';
            
            // Focar no primeiro campo do modal
            const primeiroCampo = document.getElementById('banco');
            if (primeiroCampo) primeiroCampo.focus();
          }
          
          // Fechar modal
          function fecharModal() {
            modalContaBancaria.style.display = 'none';
          }
          
          // Configurar eventos
          if (btnAdicionarPix) {
            btnAdicionarPix.addEventListener('click', abrirModalChavePix);
          }
          
          if (btnAdicionarPixOutside) {
            btnAdicionarPixOutside.addEventListener('click', abrirModalChavePix);
          }
          
          const closeModal = document.querySelector('.close');
          if (closeModal) {
            closeModal.addEventListener('click', fecharModal);
          }
          
          const btnCancelar = document.getElementById('btn-cancelar');
          if (btnCancelar) {
            btnCancelar.addEventListener('click', fecharModal);
          }
          
          // Fechar modal ao clicar fora
          window.addEventListener('click', (event) => {
            if (event.target === modalContaBancaria) {
              fecharModal();
            }
          });
          
          // Fechar com ESC
          document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && modalContaBancaria.style.display === 'block') {
              fecharModal();
            }
          });
          
          // Salvar conta
          const btnSalvarConta = document.getElementById('btn-salvar-conta');
          if (btnSalvarConta) {
            btnSalvarConta.addEventListener('click', () => {

              debugger;
              const banco = document.getElementById('banco')?.value.trim() || '';
              const agencia = document.getElementById('agencia')?.value.trim() || '';
              const conta = document.getElementById('conta')?.value.trim() || '';
              const tipoChaveSelect = document.getElementById('tipo-chave');
              const tipoChave = tipoChaveSelect?.value || '';
              const chavePix = document.getElementById('chave-pix')?.value.trim() || '';
              const pixKeySelect = document.getElementById('pix-key-select');
              
              // Validação
              if (!tipoChave || !chavePix) {
                Swal.fire({
                  title: 'Atenção!',
                  text: 'Por favor, preencha todos os campos obrigatórios.',
                  icon: 'warning',
                  confirmButtonColor: '#3b82f6'
                });
                return;
              }
              
              // Verificar se a chave já existe
              if (pixKeySelect) {
                const chaveExistente = Array.from(pixKeySelect.options).some(
                  option => option.value === chavePix
                );
                
                if (chaveExistente) {
                  Swal.fire({
                    title: 'Atenção!',
                    text: 'Esta chave PIX já está cadastrada.',
                    icon: 'warning',
                    confirmButtonColor: '#3b82f6'
                  });
                  return;
                }
                
                // Adicionar nova opção
                const option = document.createElement('option');
                option.value = chavePix;
                // option.textContent = `${tipoChave.toUpperCase()}: ${chavePix} (${banco} - Ag ${agencia} C/C ${conta})`;
                option.textContent = `${tipoChave.toUpperCase()}: ${chavePix}`;
                pixKeySelect.appendChild(option);
                option.selected = true;

                let recebe_pix_kit = `${tipoChave.toUpperCase()}: ${chavePix}`;

                $.ajax({
          url: "cadastros/processa_conta_bancaria.php",
          type: "POST",
          dataType: "json",
          data: {
            processo_conta_bancaria: "inserir_conta_bancaria",
            valor_tipo_pix_conta_bancaria: tipoChave,
            valor_pix_conta_bancaria: chavePix,
          },
          success: function(retorno_conta_bancaria) {
            debugger;
            console.log(retorno_conta_bancaria);
            if (retorno_conta_bancaria) {
              const mensagemSucesso = `
                  <div id="pix-rapido-gravado" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
                    <div style="display: flex; align-items: center; justify-content: center;">
                    <div>
                    <div>PIX cadastrado com sucesso.</div>
                    </div>
                   </div>
                  </div>
                  `;

            // Remove mensagem anterior se existir
            $("#pix-rapido-gravado").remove();
                         
            // Adiciona a nova mensagem acima das abas
            $(".tabs-container").before(mensagemSucesso);

            // Configura o fade out após 5 segundos
            setTimeout(function() {
              $("#pix-rapido-gravado").fadeOut(500, function() {
              $(this).remove();
              });
            }, 5000);
            }
          },
          error: function(xhr, status, error) {
            console.log("Falha ao inserir empresa:" + error);
          },
        });

        $.ajax({
          url: "cadastros/processa_geracao_kit.php",
          type: "POST",
          dataType: "json",
          async: false,
          data: {
             processo_geracao_kit: "incluir_valores_kit",
             valor_pix: recebe_pix_kit,
          },
          success: function(retorno_exame_geracao_kit) {
            debugger;
            try {
               console.group('AJAX > sucesso inclusão valor kit');
               console.log('Retorno:', retorno_exame_geracao_kit);
               console.groupEnd();
            } catch(e) { /* noop */ }

            const mensagemSucesso = `
             <div id="pix-gravado-kit" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
                <div style="display: flex; align-items: center; justify-content: center;">
                  <div>
                  <div>KIT Atualizado com com sucesso.</div>
                  </div>
                </div>
              </div>
             `;

            // Remove mensagem anterior se existir
            $("#pix-gravado-kit").remove();
                          
            // Adiciona a nova mensagem acima das abas
            $(".tabs-container").before(mensagemSucesso);

            // Configura o fade out após 5 segundos
            setTimeout(function() {
            $("#pix-gravado-kit").fadeOut(500, function() {
               $(this).remove();
            });
            }, 5000);


            // $("#exame-gravado").html(retorno_exame_geracao_kit);
            // $("#exame-gravado").show();
            // $("#exame-gravado").fadeOut(4000);
            console.log(retorno_exame_geracao_kit);
            ajaxEmExecucao = false; // libera para nova requisição
           },
           error: function(xhr, status, error) {
              console.log("Falha ao incluir exame: " + error);
              ajaxEmExecucao = false; // libera para tentar de novo
           },
           complete: function() {
              try {
                console.log('AJAX > inclusão valor kit finalizado');
              } catch(e) { /* noop */ }
            }
          });
                
                // Fechar e limpar o formulário
                fecharModal();
                
                // Limpar campos
                // document.getElementById('banco').value = '';
                // document.getElementById('agencia').value = '';
                // document.getElementById('conta').value = '';
                document.getElementById('chave-pix').value = '';
                if (tipoChaveSelect) tipoChaveSelect.value = 'cpf';
                
                // Mensagem de sucesso
                Swal.fire({
                  title: 'Sucesso!',
                  text: 'Chave PIX cadastrada com sucesso!',
                  icon: 'success',
                  confirmButtonColor: '#3b82f6'
                });
              }
            });
          }

          // Carregar chaves PIX existentes (exemplo)
          function carregarChavesPix() {

            // $.ajax({
            //   url: 'cadastros/processa_conta_bancaria.php',
            //   method: 'GET',
            //   dataType: 'json',
            //   data: { processo_conta_bancaria: 'buscar_contas_bancarias' },
            //   success: function(res){
            //     debugger;
            //     try {
            //       const pixKeySelect = document.getElementById('pix-key-select');
            //       if (!pixKeySelect) return;
            //       // Limpa as opções exceto a primeira (placeholder)
            //       while (pixKeySelect.options.length > 1) {
            //         pixKeySelect.remove(1);
            //       }
            //       if (Array.isArray(res) && res.length) {
            //         const vistos = new Set();
            //         res.forEach(item => {
            //           const tipo = String(item.tipo_pix || '').trim();
            //           const valor = String(item.valor_pix || '').trim();
            //           if (!tipo || !valor) return;
            //           const chave = `${tipo}|${valor}`;
            //           if (vistos.has(chave)) return;
            //           vistos.add(chave);
            //           const opt = document.createElement('option');
            //           opt.value = valor;
            //           opt.textContent = `${tipo.toUpperCase()}: ${valor}`;
            //           pixKeySelect.appendChild(opt);
            //         });
            //       }
            //     } catch(e) {
            //       console.warn('Falha ao popular chaves PIX:', e);
            //     }
            //   },
            //   error:function(xhr,status,error)
            //   {

            //   },
            // });

            const pixKeySelect = document.getElementById('pix-key-select');
            // if (!pixKeySelect) return;
            
            // // Limpa as opções exceto a primeira
            // while (pixKeySelect.options.length > 1) {
            //   pixKeySelect.remove(1);
            // }

            // function gravar_pix(pix) {
            //   debugger;
            //   try {
            //     console.group('Conta Bancária > gravar_pix');
            //     console.log('Valor recebido para gravação:', pix);
            //     console.groupEnd();
            //   } catch (e) { /* noop */ }
            //   $.ajax({
            //     url: "cadastros/processa_geracao_kit.php",
            //     type: "POST",
            //     dataType: "json",
            //     async: false,
            //     data: {
            //       processo_geracao_kit: "incluir_valores_kit",
            //       valor_pix: pix,
            //     },
            //     success: function(retorno_exame_geracao_kit) {
            //       debugger;
            //       try {
            //         console.group('AJAX > sucesso inclusão valor kit');
            //         console.log('Retorno:', retorno_exame_geracao_kit);
            //         console.groupEnd();
            //       } catch(e) { /* noop */ }

            //       const mensagemSucesso = `
            //             <div id="exame-gravado" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
            //               <div style="display: flex; align-items: center; justify-content: center;">
                            
            //                 <div>
                              
            //                   <div>Exame cadastrado com sucesso.</div>
            //                 </div>
            //               </div>
            //             </div>
            //       `;

            //       // Remove mensagem anterior se existir
            //       $("#exame-gravado").remove();
                      
            //       // Adiciona a nova mensagem acima das abas
            //       $(".tabs-container").before(mensagemSucesso);

            //       // Configura o fade out após 5 segundos
            //       setTimeout(function() {
            //         $("#exame-gravado").fadeOut(500, function() {
            //         $(this).remove();
            //         });
            //       }, 5000);


            //       $("#exame-gravado").html(retorno_exame_geracao_kit);
            //       $("#exame-gravado").show();
            //       $("#exame-gravado").fadeOut(4000);
            //       console.log(retorno_exame_geracao_kit);
            //       ajaxEmExecucao = false; // libera para nova requisição
            //     },
            //     error: function(xhr, status, error) {
            //       console.log("Falha ao incluir exame: " + error);
            //       ajaxEmExecucao = false; // libera para tentar de novo
            //     },
            //     complete: function() {
            //       try {
            //         console.log('AJAX > inclusão valor kit finalizado');
            //       } catch(e) { /* noop */ }
            //     }
            //   });
            // }

            function gravar_pix(pix) {
  debugger;
  const emEdicao = window.recebe_acao === 'editar';

  $.ajax({
    url: "cadastros/processa_geracao_kit.php",
    type: "POST",
    dataType: "json",
    async: false,
    data: emEdicao ? {
      processo_geracao_kit: "atualizar_kit",
      valor_pix: pix,
      valor_id_kit: window.recebe_id_kit
    } : {
      processo_geracao_kit: "incluir_valores_kit",
      valor_pix: pix
    },
    success: function(ret) { /* ... mesmo conteúdo ... */ },
    error: function(xhr, status, error) { console.log("Erro:", error); }
  });
}
            
            // Opções agora são preenchidas pelo AJAX acima
            // Depuração: capturar valor ao selecionar item no PIX
            try {
              // pixKeySelect.addEventListener('change', function() {
              //   debugger;
              //   try {
              //     const val = this.value;
              //     const text = this.options[this.selectedIndex]?.text || '';
              //     console.group('PIX > pix-key-select change');
              //     console.log('Valor selecionado:', val);
              //     console.log('Texto selecionado:', text);

              //     atualizarEstadoBancario('pix', val, text);

              //     gravar_pix(text);
              //     console.groupEnd();
              //   } catch (e) { /* noop */ }
              // });
// // // Marca que a aba está carregando (bloqueia execução inicial)
// window._carregandoAbaBancaria = true;

// // // ============================================================
// // // 🔹 Função auxiliar para liberar aba bancária se ativa
// // // ============================================================
// // function liberarAbaBancariaSeAberta() {
// //   debugger;
// //   const abaAtiva = document.querySelector('.tab.active');
// //   if (abaAtiva && abaAtiva.dataset.step === '5') {
// //     window._carregandoAbaBancaria = false;
// //     console.log('✅ Aba bancária liberada (data-step=5).');
// //   }
// // }

// // document.addEventListener('DOMContentLoaded', liberarAbaBancariaSeAberta());


// // Assim que a aba "Modelos e Faturas" termina de carregar, libera os eventos
// document.addEventListener('DOMContentLoaded', function () {
//   // aguarda um pequeno tempo para garantir que o DOM e selects estejam prontos
//   setTimeout(() => {
//     window._carregandoAbaBancaria = false;
//     console.log('✅ Aba bancária carregada — eventos liberados.');
//   }, 500);
// });

// // Escuta a mudança de chave PIX
// document.querySelector('#pix-key-select').addEventListener('change', function () {
//   debugger;
//   if (window._carregandoAbaBancaria) {
//     console.log('⏸️ Mudança de PIX ignorada — aba ainda carregando.');
//     return;
//   }

//   const val = this.value;
//   const text = this.options[this.selectedIndex]?.text || '';

//   if (val && val.trim() !== '') {
//     window._habilitarGravacaoBancaria = true;
//     console.group('PIX > pix-key-select change');
//     console.log('Valor selecionado:', val);
//     console.log('Texto selecionado:', text);
//     console.groupEnd();

//     atualizarEstadoBancario('pix', val, text);

//     // 🔥 Agora só grava quando o usuário realmente seleciona
//     gravar_pix(text);
//   } else {
//     console.warn('⚠️ Nenhum PIX selecionado — gravação ignorada.');
//   }
// });

// ============================================================
// 🔹 Controle de carregamento da aba
// ============================================================
window._carregandoAbaBancaria = true;

// 🔹 Libera após o carregamento do DOM
document.addEventListener('DOMContentLoaded', function () {
  setTimeout(() => {
    window._carregandoAbaBancaria = false;
    console.log('✅ Aba bancária carregada — eventos liberados.');
  }, 500);
});

// ============================================================
// 🔹 Controle de mudança manual (somente se o usuário interagir)
// ============================================================
window._mudancaManualPix = false;

const pixSelect = document.querySelector('#pix-key-select');
if (pixSelect) {
  debugger;
  pixSelect.addEventListener('mousedown', () => window._mudancaManualPix = true);
  pixSelect.addEventListener('keydown', () => window._mudancaManualPix = true);
  pixSelect.addEventListener('change', () => window._carregandoAbaBancaria = false);

  pixSelect.addEventListener('change', function () {
debugger;
    if (window._carregandoAbaBancaria) {
      console.log('⏸️ Mudança de PIX ignorada — aba ainda carregando.');
      return;
    }

    if (!window._mudancaManualPix) {
      console.log('⏸️ Mudança de PIX ignorada — alteração automática.');
      return;
    }

    const val = this.value;
    const text = this.options[this.selectedIndex]?.text || '';

    if (val && val.trim() !== '') {
      window._habilitarGravacaoBancaria = true;
      console.group('PIX > pix-key-select change');
      console.log('Valor selecionado:', val);
      console.log('Texto selecionado:', text);
      console.groupEnd();

      atualizarEstadoBancario('pix', val, text);
      gravar_pix(text);
    } else {
      console.warn('⚠️ Nenhum PIX selecionado — gravação ignorada.');
    }

    // reseta a flag após o uso
    window._mudancaManualPix = false;
  });
}


            } catch (e) { /* noop */ }
          }
          // Chama o carregador de chaves PIX
          carregarChavesPix();

          // Elementos de Agência/Conta
          try {
            const acSelector = document.getElementById('agencia-selector-container');
            const acBtnAdd = document.getElementById('btn-adicionar-agencia-conta');
            const acModal = document.getElementById('modal-agencia-conta');
            const acClose = document.querySelector('.close-agencia');
            const acBtnCancel = document.getElementById('btn-cancelar-agencia');
            const acBtnSave = document.getElementById('btn-salvar-agencia');

            function acAtualizarVisibilidade() {
              const agSelecionado = Array.from(tipoContaInputs).some(i => i.value === 'agencia-conta' && i.checked);
              if (acSelector) acSelector.style.display = agSelecionado ? 'block' : 'none';
            }
            tipoContaInputs.forEach(i => i.addEventListener('change', acAtualizarVisibilidade));
            acAtualizarVisibilidade();

            function acAbrirModal() {
              const radioAg = document.querySelector('input[value="agencia-conta"]');
              if (radioAg && !radioAg.checked) { radioAg.checked = true; acAtualizarVisibilidade(); }
              if (acModal) {
                acModal.style.display = 'block';
                const agCampo = document.getElementById('agencia-rapida');
                if (agCampo) agCampo.focus();
              }
            }
            if (acBtnAdd) acBtnAdd.addEventListener('click', acAbrirModal);
            if (acClose && acModal) acClose.addEventListener('click', () => { acModal.style.display = 'none'; });
            if (acBtnCancel && acModal) acBtnCancel.addEventListener('click', () => { acModal.style.display = 'none'; });
            window.addEventListener('click', (ev) => { if (ev.target === acModal) acModal.style.display = 'none'; });
            document.addEventListener('keydown', (ev) => { if (ev.key === 'Escape' && acModal && acModal.style.display === 'block') acModal.style.display = 'none'; });

            // // Carrega Agência/Conta do backend (apenas agência e conta)
            // $.ajax({
            //   url: 'cadastros/processa_conta_bancaria.php',
            //   method: 'GET',
            //   dataType: 'json',
            //   data: { processo_conta_bancaria: 'buscar_contas_bancarias' },
            //   success: function(res){
            //     debugger;
            //     try {
            //       const sel = document.getElementById('agencia-conta-select');
            //       if (!sel) return;
            //       // Limpa mantendo o placeholder
            //       while (sel.options.length > 1) sel.remove(1);
            //       let adicionou = false;
            //       if (Array.isArray(res)) {
            //         const vistos = new Set();
            //         res.forEach(it => {
            //           const agencia = String(it.agencia || '').trim();
            //           const conta = String(it.conta || '').trim();
            //           if (!agencia || !conta) return;
            //           const value = `${agencia}|${conta}`;
            //           if (vistos.has(value)) return;
            //           vistos.add(value);
            //           const opt = document.createElement('option');
            //           opt.value = value;
            //           opt.textContent = `Ag ${agencia} • C/C ${conta}`;
            //           sel.appendChild(opt);
            //           adicionou = true;
            //         });
            //       }
            //       // Se não veio nada do backend, mantém o fallback de exemplos (abaixo)
            //       if (!adicionou) {
            //         // não faz nada aqui; o bloco acPopularExemplos() cuidará
            //       }
            //     } catch(e){ console.warn('Falha ao popular Agência/Conta via AJAX:', e); }
            //   },
            //   error: function(xhr, status, error){
            //     console.warn('Erro ao buscar contas bancárias:', status, error);
            //     // Em caso de erro, o fallback de exemplos (abaixo) será usado
            //   }
            // });

            // Popular exemplos no select se ainda não existirem
            (function acPopularExemplos(){
              const sel = document.getElementById('agencia-conta-select');
              if (!sel) return;
              if (sel.options.length > 1) return;
              [
                { banco: 'Banco do Brasil', agencia: '1234', conta: '56789-0' },
                { banco: 'Itaú', agencia: '9876', conta: '12345-6' },
                { banco: 'Bradesco', agencia: '4567', conta: '78901-2' }
              ].forEach(item => {
                const opt = document.createElement('option');
                opt.value = `${item.agencia}|${item.conta}`;
                opt.textContent = `${item.banco} - Ag ${item.agencia} • C/C ${item.conta}`;
                sel.appendChild(opt);
              });
            })();

          //   function gravar_agencia_conta(agencia_conta) {
          //     debugger;
          //     try {
          //       console.group('Conta Bancária > gravar_agencia_conta');
          //       console.log('Valor recebido para gravação:', agencia_conta);
          //       console.groupEnd();
          //     } catch (e) { /* noop */ }
          //     $.ajax({
          //       url: "cadastros/processa_geracao_kit.php",
          //       type: "POST",
          //       dataType: "json",
          //       async: false,
          //       data: {
          //         processo_geracao_kit: "incluir_valores_kit",
          //         valor_agencia_conta: agencia_conta,
          //       },
          //       success: function(retorno_exame_geracao_kit) {
          //         debugger;
          //         try {
          //           console.group('AJAX > sucesso inclusão valor kit');
          //           console.log('Retorno:', retorno_exame_geracao_kit);
          //           console.groupEnd();
          //         } catch(e) { /* noop */ }

          //         const mensagemSucesso = `
          //               <div id="exame-gravado" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
          //                 <div style="display: flex; align-items: center; justify-content: center;">
                            
          //                   <div>
                              
          //                     <div>Exame cadastrado com sucesso.</div>
          //                   </div>
          //                 </div>
          //               </div>
          //         `;

          //         // Remove mensagem anterior se existir
          //         $("#exame-gravado").remove();
                      
          //         // Adiciona a nova mensagem acima das abas
          //         $(".tabs-container").before(mensagemSucesso);

          //         // Configura o fade out após 5 segundos
          //         setTimeout(function() {
          //           $("#exame-gravado").fadeOut(500, function() {
          //           $(this).remove();
          //           });
          //         }, 5000);


          //         $("#exame-gravado").html(retorno_exame_geracao_kit);
          //         $("#exame-gravado").show();
          //         $("#exame-gravado").fadeOut(4000);
          //         console.log(retorno_exame_geracao_kit);
          //         ajaxEmExecucao = false; // libera para nova requisição
          //       },
          //       error: function(xhr, status, error) {
          //         console.log("Falha ao incluir exame: " + error);
          //         ajaxEmExecucao = false; // libera para tentar de novo
          //       },
          //       complete: function() {
          //         try {
          //           console.log('AJAX > inclusão valor kit finalizado');
          //         } catch(e) { /* noop */ }
          //       }
          //     });
          // }

          function gravar_agencia_conta(agencia_conta) {
  debugger;
  const emEdicao = window.recebe_acao === 'editar';

  $.ajax({
    url: "cadastros/processa_geracao_kit.php",
    type: "POST",
    dataType: "json",
    async: false,
    data: emEdicao ? {
      processo_geracao_kit: "atualizar_kit",
      valor_agencia_conta: agencia_conta,
      valor_id_kit: window.recebe_id_kit
    } : {
      processo_geracao_kit: "incluir_valores_kit",
      valor_agencia_conta: agencia_conta
    },
    success: function(ret) { /* ... mesmo conteúdo ... */ },
    error: function(xhr, status, error) { console.log("Erro:", error); }
  });
}

            // Depuração: capturar valor ao selecionar item no Agência/Conta
            try {
              const acSelect = document.getElementById('agencia-conta-select');
              if (acSelect) {
                // 🔹 Marca se o usuário interagiu manualmente
                window._mudancaManualAgenciaConta = false;
                window._carregandoAbaBancaria = true;

                acSelect.addEventListener('mousedown', () => window._mudancaManualAgenciaConta = true);
                acSelect.addEventListener('keydown', () => window._mudancaManualAgenciaConta = true);
                acSelect.addEventListener('change', () => window._carregandoAbaBancaria = false);

                acSelect.addEventListener('change', function() {
                  debugger;
                  try {
                    // 🔹 Evita execução durante o carregamento
                    if (window._carregandoAbaBancaria) {
                      console.log('⏸️ Mudança de Agência/Conta ignorada — aba ainda carregando.');
                      return;
                    }

                    // 🔹 Evita execução automática (sem interação do usuário)
                    if (!window._mudancaManualAgenciaConta) {
                      console.log('⏸️ Mudança de Agência/Conta ignorada — alteração automática.');
                      return;
                    }

                    const val = this.value;
                    const text = this.options[this.selectedIndex]?.text || '';

                    if (val && val.trim() !== '') {
                      console.group('🏦 Agência/Conta > change');
                      console.log('Valor selecionado:', val);
                      console.log('Texto selecionado:', text);

                      atualizarEstadoBancario('agencia-conta', val, text);
                      gravar_agencia_conta(text);

                      console.groupEnd();
                    } else {
                      console.warn('⚠️ Nenhuma Agência/Conta selecionada — gravação ignorada.');
                    }

                  } catch (e) {
                    console.error('❌ Erro no evento de mudança de Agência/Conta:', e);
                  } finally {
                    // 🔹 Reseta a flag após o uso
                    window._mudancaManualAgenciaConta = false;
                  }
                });
              }
            } catch (e) {
              console.error('❌ Erro ao inicializar evento de Agência/Conta:', e);
            }


            if (acBtnSave) {
              acBtnSave.addEventListener('click', () => {
                debugger;
                const agencia = document.getElementById('agencia-rapida')?.value.trim() || '';
                const conta = document.getElementById('conta-rapida')?.value.trim() || '';
                const sel = document.getElementById('agencia-conta-select');
                if (!agencia || !conta) { alert('Por favor, informe Agência e Conta.'); return; }
                if (sel) {
                  const value = `${agencia}|${conta}`;
                  const existe = Array.from(sel.options).some(o => o.value === value);
                  if (existe) { alert('Esta Agência/Conta já está cadastrada.'); return; }
                  const opt = document.createElement('option');
                  opt.value = value;
                  opt.textContent = `Ag ${agencia} • C/C ${conta}`;
                  sel.appendChild(opt);
                  opt.selected = true;

                  let recebe_agencia_conta = `Ag ${agencia} • C/C ${conta}`;

                  $.ajax({
                      url: "cadastros/processa_conta_bancaria.php",
                      type: "POST",
                      dataType: "json",
                      data: {
                        processo_conta_bancaria: "inserir_conta_bancaria",
                        valor_agencia_conta_bancaria: agencia,
                        valor_conta_bancaria: conta,
                      },
                      success: function(retorno_conta_bancaria) {
                        debugger;

                        console.log(retorno_conta_bancaria);

                        if (retorno_conta_bancaria) {
                            const mensagemSucesso = `
                            <div id="agencia-conta-rapido-gravado" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
                              <div style="display: flex; align-items: center; justify-content: center;">
                                
                                <div>
                                  
                                  <div>Agencia e conta cadastrado com sucesso.</div>
                                </div>
                              </div>
                            </div>
                            `;

                          // Remove mensagem anterior se existir
                          $("#agencia-conta-rapido-gravado").remove();
                              
                          // Adiciona a nova mensagem acima das abas
                          $(".tabs-container").before(mensagemSucesso);

                          // Configura o fade out após 5 segundos
                          setTimeout(function() {
                            $("#agencia-conta-rapido-gravado").fadeOut(500, function() {
                            $(this).remove();
                            });
                          }, 5000);
                        }
                      },
                      error: function(xhr, status, error) {
                        console.log("Falha ao inserir agencia e conta:" + error);
                      },
                  });

                    $.ajax({
                        url: "cadastros/processa_geracao_kit.php",
                        type: "POST",
                        dataType: "json",
                        async: false,
                        data: {
                          processo_geracao_kit: "incluir_valores_kit",
                          valor_agencia_conta: recebe_agencia_conta,
                    },
                    success: function(retorno_exame_geracao_kit) {
                      debugger;
                      try {
                        console.group('AJAX > sucesso inclusão valor kit');
                        console.log('Retorno:', retorno_exame_geracao_kit);
                        console.groupEnd();
                      } catch(e) { /* noop */ }

                        const mensagemSucesso = `
                              <div id="agencia-conta-gravado-kit" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
                                <div style="display: flex; align-items: center; justify-content: center;">
                                  
                                  <div>
                                    
                                    <div>KIT Atualizado com com sucesso.</div>
                                  </div>
                                </div>
                              </div>
                        `;

                      // Remove mensagem anterior se existir
                      $("#exame-gravado").remove();
                          
                      // Adiciona a nova mensagem acima das abas
                      $(".tabs-container").before(mensagemSucesso);

                      // Configura o fade out após 5 segundos
                      setTimeout(function() {
                        $("#agencia-conta-gravado-kit").fadeOut(500, function() {
                        $(this).remove();
                        });
                      }, 5000);


                      // $("#exame-gravado").html(retorno_exame_geracao_kit);
                      // $("#exame-gravado").show();
                      // $("#exame-gravado").fadeOut(4000);
                      console.log(retorno_exame_geracao_kit);
                      ajaxEmExecucao = false; // libera para nova requisição
                    },
                    error: function(xhr, status, error) {
                      console.log("Falha ao incluir exame: " + error);
                      ajaxEmExecucao = false; // libera para tentar de novo
                    },
                    complete: function() {
                      try {
                        console.log('AJAX > inclusão valor kit finalizado');
                      } catch(e) { /* noop */ }
                    }
                  });

                }

                if (acModal) acModal.style.display = 'none';
                const agCampo = document.getElementById('agencia-rapida');
                const ccCampo = document.getElementById('conta-rapida');
                if (agCampo) agCampo.value = '';
                if (ccCampo) ccCampo.value = '';
              });
            }
          } catch(e) { /* silencioso para não quebrar PIX */ }

          console.log('Módulo de Conta Bancária inicializado com sucesso');
        }, 100); // Pequeno atraso para garantir que o DOM foi completamente renderizado
        
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


    function initializeRiscosComponent() {
      debugger;
      console.log('Inicializando componente de riscos...');
      
      // Inicialização do componente de riscos
      
      
      // Dados dos riscos (pode ser movido para um arquivo JSON separado posteriormente)
      // const risksData = {
      //   ergonomico: {
      //     name: "Riscos Ergonômicos",
      //     risks: [
      //       { code: "04.01.001", name: "Trabalho em posturas incômodas ou pouco confortáveis por longos períodos" },
      //       { code: "04.01.002", name: "Trabalhos com pacientes individuais" },
      //       { code: "04.01.003", name: "Trabalhos com pacientes individuais" },
      //       { code: "04.01.004", name: "Trabalhos com pacientes individuais" },
      //       { code: "04.01.005", name: "Trabalhos com pacientes individuais" },
      //       { code: "04.01.999", name: "Outros", isOther: true }
      //     ]
      //   },
      //   "acidentes_mecanico": {
      //     name: "Riscos Acidentes - Mecânicos",
      //     risks: [
      //       { code: "01.01.001", name: "Quedas em mesmo nível" },
      //       { code: "01.01.002", name: "Quedas de altura" },
      //       { code: "01.01.003", name: "Queda de objetos" },
      //       { code: "01.01.999", name: "Outros", isOther: true }
      //     ]
      //   },
      //   fisico: {
      //     name: "Riscos Físicos",
      //     risks: [
      //       { code: "03.01.001", name: "Exposição a ruído excessivo" },
      //       { code: "03.01.002", name: "Exposição a vibrações" },
      //       { code: "03.01.003", name: "Temperaturas extremas" },
      //       { code: "03.01.004", name: "Radiações ionizantes e não ionizantes" },
      //       { code: "03.01.999", name: "Outros", isOther: true }
      //     ]
      //   },
      //   quimico: {
      //     name: "Riscos Químicos",
      //     risks: [
      //       { code: "02.01.001", name: "Exposição a produtos químicos" },
      //       { code: "02.01.002", name: "Inalação de vapores tóxicos" },
      //       { code: "02.01.003", name: "Contato com substâncias corrosivas" },
      //       { code: "02.01.999", name: "Outros", isOther: true }
      //     ]
      //   },
      //   biologico: {
      //     name: "Riscos Biológicos",
      //     risks: [
      //       { code: "05.01.002", name: "Exposição a agentes biológicos" },
      //       { code: "05.01.003", name: "Contato com fluidos corporais" },
      //       { code: "05.01.006", name: "Manuseio de materiais contaminados" },
      //       { code: "05.01.999", name: "Outros", isOther: true }
      //     ]
      //   },
      //   outro: {
      //     name: "Outros Riscos",
      //     risks: [
      //       { code: "99.01.001", name: "Estresse ocupacional" },
      //       { code: "99.01.002", name: "Assédio moral" },
      //       { code: "99.01.003", name: "Jornada de trabalho excessiva" },
      //       { code: "99.01.999", name: "Outros", isOther: true }
      //     ]
      //   }
      // };

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
      
      // Rede de segurança: captura global para garantir clique no primeiro render (sem relistar)
      if (searchResults && !searchResults._safetyCaptureBound) {
        const safetyCapture = function(e) {
          const item = e.target.closest('.risk-item');
          if (!item || !searchResults.contains(item)) return;
          if (item.dataset && item.dataset.selectedOnce === '1') return; // já tratado pelo handler direto
          // Extrai dados
          const code = item.getAttribute('data-code') || (item.querySelector('.risk-code')?.textContent || '').trim();
          const name = item.getAttribute('data-name') || (item.querySelector('.risk-name')?.textContent || '').trim();
          const group = item.getAttribute('data-group') || (selectedGroups && selectedGroups[0]) || '';
          if (!code || !name) return;
          if (typeof e.preventDefault === 'function') e.preventDefault();
          if (typeof e.stopPropagation === 'function') e.stopPropagation();
          if (typeof e.stopImmediatePropagation === 'function') e.stopImmediatePropagation();
          try {
            if (typeof addSelectedRisk === 'function') {
              addSelectedRisk(code, name, group);
            } else if (typeof window.addSelectedRisk === 'function') {
              window.addSelectedRisk(code, name, group);
            } else {
              console.error('addSelectedRisk não está disponível no escopo');
            }
            if (item.dataset) item.dataset.selectedOnce = '1';
          } catch (err) {
            console.error('Falha ao selecionar risco (safetyCapture):', err);
          }
        };
        document.addEventListener('pointerdown', safetyCapture, true);
        document.addEventListener('click', safetyCapture, true);
        searchResults._safetyCaptureBound = true;
      }
      
      // Variáveis de estado
      // Não impor default aqui; será definido via snapshot salvo ou escolha do usuário
      let selectedGroups = [];
      let selectedRisks = {};
      // Se existir snapshot global previamente salvo, restaura o estado visual sem gravar
      if (window && window.riscosEstadoSalvoDetalhes && typeof window.riscosEstadoSalvoDetalhes === 'object') {
        try {
          selectedRisks = { ...window.riscosEstadoSalvoDetalhes };
          window._riscosDirty = false;
          // Deriva grupos a partir dos riscos restaurados SOMENTE se não houver snapshot prévio
          try {
            const gruposDerivados = Array.from(new Set(Object.values(selectedRisks || {}).map(r => r.group).filter(Boolean)));
            if ((!Array.isArray(window.riscosGruposEstadoSalvo) || window.riscosGruposEstadoSalvo.length === 0) && gruposDerivados.length) {
              window.riscosGruposEstadoSalvo = gruposDerivados;
            }
          } catch (e) { /* ignore */ }
        } catch (e) { /* ignore */ }
      }
      // Controle de execução e persistência
      window._riscosRenderRunning = window._riscosRenderRunning || false; // evita reentrância de render
      window._riscosDirty = window._riscosDirty || false; // marca que houve alteração desde a última persistência
      window.riscosEstadoSalvoCodes = Array.isArray(window.riscosEstadoSalvoCodes) ? window.riscosEstadoSalvoCodes : []; // snapshot último persistido
      let currentOtherRisk = null;
      let isSelectingRisk = false; // evita reabertura da lista durante seleção
      let lastSearchKey = ''; // garante uma única renderização por filtro (termo+grupos)

      
      
      // Inicialização
      updateSearchPlaceholder();
      
      // Função para atualizar as seleções
      function updateSelectedGroups() {
        debugger;
        const checkboxes = document.querySelectorAll('#group-select-container input[type="checkbox"]');
        selectedGroups = Array.from(checkboxes)
          .filter(checkbox => checkbox.checked)
          .map(checkbox => checkbox.value);
        // Não selecionar automaticamente o primeiro grupo; manter vazio se usuário não marcou

        try { window.riscosGruposEstadoSalvo = selectedGroups.slice(); } catch (e) { /* ignore */ }

        updateSearchPlaceholder();
        // Se o usuário não digitou nada, exibe os grupos selecionados no input
        try {
          if (searchBox && !searchBox.value) {
            const groupNames = selectedGroups.map(group => risksData[group] ? risksData[group].name : group);
            searchBox.value = groupNames.length ? `Busca em: ${groupNames.join(', ')}` : '';
          }
        } catch (e) { /* ignore */ }

        if (searchBox && searchBox.value && !/^\s*Busca em:/i.test(searchBox.value)) {
          performSearch(searchBox.value);
        }
      }
      
      // Event Listeners para os checkboxes (bind uma única vez)
      const groupSelectContainer = document.getElementById('group-select-container');
      if (groupSelectContainer && !groupSelectContainer._changeBound) {
        groupSelectContainer.addEventListener('change', function(e) {
          if (e.target.type === 'checkbox') {
            updateSelectedGroups();
          }
        });
        groupSelectContainer._changeBound = true;
        // Inicializa as seleções: se há snapshot salvo, reaplica; senão, usa o estado atual
        if (Array.isArray(window.riscosGruposEstadoSalvo) && window.riscosGruposEstadoSalvo.length) {
          // reaplicarGruposSelecionadosUI();
        } else {
          updateSelectedGroups();
        }
      }


      function reaplicarGruposSelecionadosUI() {
  debugger;
  try {
    const checkboxes = document.querySelectorAll('#group-select-container input[type="checkbox"]');

    // 🔍 Vai determinar a lista de grupos que devemos marcar (gruposSalvos)
    let gruposSalvos = null;

    // =========================
    // 1) Se estivermos em EDIÇÃO, prioriza window.kit_riscos
    // =========================
    if (window.recebe_acao === 'editar') {
      if (window.kit_riscos) {
        let kit = window.kit_riscos;
        if (typeof kit === 'string') {
          try {
            kit = JSON.parse(kit);
          } catch (err) {
            console.warn('reaplicarGruposSelecionadosUI: window.kit_riscos é string inválida JSON', err);
            kit = [];
          }
        }

        if (Array.isArray(kit) && kit.length) {
          // extrai os grupos únicos do kit_riscos
          const gruposSet = new Set();
          kit.forEach(item => {
            const g = (item.grupo || '').toString().trim();
            if (g) gruposSet.add(g);
          });
          gruposSalvos = Array.from(gruposSet);
          console.log("🟢 modo 'editar' — grupos carregados de window.kit_riscos:", gruposSalvos);
        } else {
          console.log("🟢 modo 'editar' — window.kit_riscos vazio ou em formato inesperado.");
          gruposSalvos = [];
        }
      } else {
        console.log("🟢 modo 'editar' — window.kit_riscos não definida.");
        gruposSalvos = [];
      }
    }

    // =========================
    // 2) Se NÃO for edição, prioriza snapshots / estado salvo
    // =========================
    if (window.recebe_acao !== 'editar') {
      if (Array.isArray(window._snapshotRiscosGrupos) && window._snapshotRiscosGrupos.length > 0) {
        gruposSalvos = window._snapshotRiscosGrupos.slice();
        console.log("🟢 usando _snapshotRiscosGrupos da repopulação");
      } else if (Array.isArray(window.riscosGruposEstadoSalvo) && window.riscosGruposEstadoSalvo.length > 0) {
        gruposSalvos = window.riscosGruposEstadoSalvo.slice();
        console.log("🟢 usando riscosGruposEstadoSalvo da sessão atual");
      }
    }

    // =========================
    // 3) Se ainda não temos grupos e HOUVER checkboxes, reconstruir a partir dos checkboxes
    //    (apenas quando NÃO estivermos em edição — pois em edição já usamos kit_riscos)
    // =========================
    if ((!gruposSalvos || !gruposSalvos.length) && checkboxes.length && window.recebe_acao !== 'editar') {
      gruposSalvos = Array.from(checkboxes)
        .filter(cb => cb.checked)
        .map(cb => cb.value);
      if (gruposSalvos.length) {
        window.riscosGruposEstadoSalvo = gruposSalvos.slice();
        console.log("⚙️ reconstruído a partir dos checkboxes marcados.");
      }
    }

    // =========================
    // 4) Se ainda não há nada para aplicar -> encerra
    // =========================
    if (!gruposSalvos || !gruposSalvos.length) {
      console.warn("⚠️ Nenhum grupo salvo encontrado para reaplicar.");
      return;
    }

    // =========================
    // 5) Aplica os grupos marcados nos checkboxes da interface
    // =========================
    checkboxes.forEach(cb => {
      // cb.value deve corresponder ao nome/código do grupo salvo
      try {
        cb.checked = gruposSalvos.includes(cb.value);
      } catch (err) {
        // fallback seguro
        cb.checked = !!gruposSalvos.find(g => String(g) === String(cb.value));
      }
    });

    // 🔄 Atualiza estado interno sem disparar gravação
    window.selectedGroups = gruposSalvos.slice();
    if (typeof updateSearchPlaceholder === "function") {
      try { updateSearchPlaceholder(); } catch (e) { /* ignore */ }
    }

    // 🧭 Atualiza o campo de busca com os nomes dos grupos (se existir risksData)
    const risksDataGlobal =
      (typeof window.risksData === "object" && Object.keys(window.risksData).length > 0)
        ? window.risksData
        : (typeof risksData === "object" ? risksData : {});

    const groupNames = gruposSalvos.map(group =>
      risksDataGlobal[group] ? risksDataGlobal[group].name : group
    );

    if (window.searchBox) {
      window.searchBox.value = groupNames.length
        ? `Busca em: ${groupNames.join(', ')}`
        : '';
      window.searchBox.disabled = false;
    }

    console.log("✅ reaplicarGruposSelecionadosUI concluído:", gruposSalvos);
  } catch (e) {
    console.error("Erro em reaplicarGruposSelecionadosUI:", e);
  }
}

      
      // ============================================
// Função segura: reaplicarGruposSelecionadosUI()
// - Usa variáveis globais de repopulação se existirem
// - Mantém compatibilidade com o fluxo normal (gravação/edição)
// ============================================
// function reaplicarGruposSelecionadosUI() {
//   debugger;
//   try {
//     const checkboxes = document.querySelectorAll('#group-select-container input[type="checkbox"]');

//     // 🔍 Tenta pegar o snapshot dos grupos marcados (preferência pelas variáveis globais de repopular)
//     let gruposSalvos = null;

//     if (Array.isArray(window._snapshotRiscosGrupos) && window._snapshotRiscosGrupos.length > 0) {
//       gruposSalvos = window._snapshotRiscosGrupos.slice();
//       console.log("🟢 usando _snapshotRiscosGrupos da repopulação");
//     } else if (Array.isArray(window.riscosGruposEstadoSalvo) && window.riscosGruposEstadoSalvo.length > 0) {
//       gruposSalvos = window.riscosGruposEstadoSalvo.slice();
//       console.log("🟢 usando riscosGruposEstadoSalvo da sessão atual");
//     }

//     // 🔁 Se ainda não há grupos, tenta reconstruir com base nos checkboxes marcados
//     if ((!gruposSalvos || !gruposSalvos.length) && checkboxes.length) {
//       gruposSalvos = Array.from(checkboxes)
//         .filter(cb => cb.checked)
//         .map(cb => cb.value);
//       if (gruposSalvos.length) {
//         window.riscosGruposEstadoSalvo = gruposSalvos.slice();
//         console.log("⚙️ reconstruído a partir dos checkboxes marcados.");
//       }
//     }

//     // 🚫 Se ainda não há nada, apenas sai
//     if (!gruposSalvos || !gruposSalvos.length) {
//       console.warn("⚠️ Nenhum grupo salvo encontrado para reaplicar.");
//       return;
//     }

//     // 🧩 Aplica os grupos marcados nos checkboxes da interface
//     checkboxes.forEach(cb => {
//       cb.checked = gruposSalvos.includes(cb.value);
//     });

//     // 🔄 Atualiza estado interno sem disparar gravação
//     window.selectedGroups = gruposSalvos.slice();
//     if (typeof updateSearchPlaceholder === "function") {
//       updateSearchPlaceholder();
//     }

//     // 🧭 Atualiza o campo de busca
//     const risksDataGlobal =
//       (typeof window.risksData === "object" && Object.keys(window.risksData).length > 0)
//         ? window.risksData
//         : (typeof risksData === "object" ? risksData : {});

//     const groupNames = gruposSalvos.map(group =>
//       risksDataGlobal[group] ? risksDataGlobal[group].name : group
//     );

//     if (window.searchBox) {
//       window.searchBox.value = groupNames.length
//         ? `Busca em: ${groupNames.join(', ')}`
//         : '';
//       window.searchBox.disabled = false;
//     }

//     console.log("✅ reaplicarGruposSelecionadosUI concluído:", gruposSalvos);
//   } catch (e) {
//     console.error("Erro em reaplicarGruposSelecionadosUI:", e);
//   }
// }

      // Event Listeners do campo de busca (bind uma única vez)
      if (searchBox) {
        if (!searchBox._inputBound) {
          searchBox.addEventListener('input', function(e) {
            console.log('Input event:', e.target.value);
            if (searchBox._debTimer) clearTimeout(searchBox._debTimer);
            searchBox._debTimer = setTimeout(function(){
              performSearch(e.target.value);
            }, 200);
          });
          searchBox._inputBound = true;
        }
        if (!searchBox._focusBound) {
          searchBox.addEventListener('focus', function() {
            console.log('Search box focused');
            // Limpa o placeholder ao focar para não atrapalhar a digitação
            try { this._prevPlaceholder = this.placeholder; } catch(e) { /* noop */ }
            this.placeholder = '';
            const val = (this.value || '').trim();
            // Se o campo contém o texto informativo ("Busca em: ..."), limpa para digitação
            if (/^\s*Busca em:/i.test(val)) {
              this.value = '';
            }
            if (val && !/^\s*Busca em:/i.test(val)) {
              performSearch(val);
            }
          });
          searchBox._focusBound = true;
        }
        // Restaura placeholder no blur apenas se o campo estiver vazio
        if (!searchBox._blurPlaceholderBound) {
          searchBox.addEventListener('blur', function() {
            try {
              if (!this.value) {
                if (typeof updateSearchPlaceholder === 'function') {
                  updateSearchPlaceholder();
                } else {
                  this.placeholder = this._prevPlaceholder || this.placeholder || '';
                }
              }
            } catch(e) { /* noop */ }
          });
          searchBox._blurPlaceholderBound = true;
        }
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
        debugger;
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
        //debugger
        console.log('performSearch called with term:', term);
        if (!searchResults) {
          console.error('searchResults element not found');
          return;
        }
        
        term = term ? term.toLowerCase().trim() : '';
        // chave única do filtro atual
        const groupsKey = selectedGroups.slice().sort().join(',');
        const key = term + '|' + groupsKey;
        // Se já renderizado para esta chave e já há itens, não re-renderiza
        if (searchResults.dataset && searchResults.dataset.key === key && searchResults.childElementCount > 0) {
          console.log('Ignorando re-render: mesma chave de busca', key);
          searchResults.style.display = 'block';
          // Conforme solicitado: pega os valores do item e chama a função diretamente
          const item = searchResults.querySelector('.risk-item');
          if (item) {
            const code = item.getAttribute('data-code') || (item.querySelector('.risk-code')?.textContent || '').trim();
            const name = item.getAttribute('data-name') || (item.querySelector('.risk-name')?.textContent || '').trim();
            const group = item.getAttribute('data-group') || (selectedGroups && selectedGroups[0]) || '';
            if (code && name) {
              debugger;
              if (typeof addSelectedRisk === 'function') {
                addSelectedRisk(code, name, group);
              } else if (typeof window.addSelectedRisk === 'function') {
                window.addSelectedRisk(code, name, group);
              } else {
                console.error('addSelectedRisk não está disponível no escopo');
              }
            }
          }
          return;
        }
        // Limpa e marca chave atual
        searchResults.innerHTML = '';
        if (searchResults.dataset) searchResults.dataset.key = key;
        lastSearchKey = key;
        
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
            debugger;
            const riskElement = document.createElement('div');
            riskElement.className = 'risk-item';
            // Garante que pode receber clique
            riskElement.style.pointerEvents = 'auto';
            // Data attributes para delegation e fallback
            riskElement.setAttribute('data-code', risk.code);
            riskElement.setAttribute('data-name', risk.name);
            riskElement.setAttribute('data-group', risk.group);
            riskElement.innerHTML = `
              <div style="display: flex; flex-direction: column; width: 100%;">
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 2px;">
                  <span class="risk-code" style="font-weight: 500; font-size: 0.85em;">${risk.code}</span>
                  <span style="font-size: 0.8em; color: #666;">${risk.groupName}</span>
                </div>
                <span class="risk-name" style="font-size: 0.9em;">${risk.name}</span>
              </div>
            `;

            const onSelect = function(e) {
              if (e && typeof e.preventDefault === 'function') e.preventDefault();
              if (e && typeof e.stopPropagation === 'function') e.stopPropagation();
              if (e && typeof e.stopImmediatePropagation === 'function') e.stopImmediatePropagation();
              console.log('Risco clicado:', risk);
              if (risk.isOther) {
                // Mantém fluxo do "Outros": abre modal e não adiciona automaticamente
                currentOtherRisk = risk;
                if (customRiskName) customRiskName.value = '';
                if (customRiskModal) customRiskModal.style.display = 'flex';
                if (customRiskName) customRiskName.focus();
                return;
              }
              // Chama addSelectedRisk imediatamente
              if (typeof addSelectedRisk === 'function') {
                debugger;
                addSelectedRisk(risk.code, risk.name, risk.group);
              } else if (typeof window.addSelectedRisk === 'function') {
                window.addSelectedRisk(risk.code, risk.name, risk.group);
              } else {
                console.error('addSelectedRisk não está disponível no escopo');
              }
              if (riskElement && riskElement.dataset) riskElement.dataset.selectedOnce = '1';
              // Não reexecuta performSearch aqui; listagem é única e handlers já estão nos itens
            };
            // Registra listeners em captura e bolha para garantir execução mesmo se outro código interromper
            riskElement.addEventListener('pointerdown', onSelect, true);
            riskElement.addEventListener('mousedown', onSelect, true);
            riskElement.addEventListener('click', onSelect, true);
            riskElement.addEventListener('touchstart', onSelect, { capture: true, passive: false });
            riskElement.addEventListener('mousedown', onSelect, false);
            riskElement.addEventListener('click', onSelect, false);
            riskElement.addEventListener('touchstart', onSelect, { capture: false, passive: false });

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

        // debugger;
        // console.log('performSearch called with term:', term);
        // if (!searchResults) {
        //   console.error('searchResults element not found');
        //   return;
        // }
        // // Evita re-render durante seleção para não reabrir lista
        // if (isSelectingRisk) {
        //   console.log('Skipping performSearch during selection');
        //   searchResults.style.display = 'none';
        //   return;
        // }
        
        // term = term ? term.toLowerCase().trim() : '';
        // searchResults.innerHTML = '';
        
        // if (selectedGroups.length === 0) {
        //   console.log('Nenhum grupo selecionado');
        //   searchResults.style.display = 'none';
        //   return;
        // }
        
        // if (term === '') {
        //   console.log('Termo de busca vazio');
        //   searchResults.style.display = 'none';
        //   return;
        // }
        
        // // Coletar todos os riscos dos grupos selecionados
        // let allRisks = [];
        // selectedGroups.forEach(group => {
        //   if (risksData[group]) {
        //     risksData[group].risks.forEach(risk => {
        //       allRisks.push({
        //         ...risk,
        //         group: group,
        //         groupName: risksData[group].name
        //       });
        //     });
        //   }
        // });
        
        // // Filtrar riscos pelo termo de busca e remover já selecionados
        // const filteredRisks = allRisks.filter(risk => {
        //   return (risk.name.toLowerCase().includes(term) || 
        //          risk.code.toLowerCase().includes(term)) &&
        //          !selectedRisks[risk.code]; // Não mostrar riscos já selecionados
        // });
        
        // // Exibir resultados
        // if (filteredRisks.length > 0) {
        //   filteredRisks.forEach(risk => {
        //     debugger;
        //     const riskElement = document.createElement('div');
        //     riskElement.className = 'risk-item';
        //     // Data attributes para delegation
        //     riskElement.setAttribute('data-code', risk.code);
        //     riskElement.setAttribute('data-name', risk.name);
        //     riskElement.setAttribute('data-group', risk.group);
        //     riskElement.innerHTML = `
        //       <div style="display: flex; flex-direction: column; width: 100%;">
        //         <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 2px;">
        //           <span style="font-weight: 500; font-size: 0.85em;">${risk.code}</span>
        //           <span style="font-size: 0.8em; color: #666;">${risk.groupName}</span>
        //         </div>
        //         <span class="risk-name" style="font-size: 0.9em;">${risk.name}</span>
        //       </div>
        //     `;
        //     addSelectedRisk(risk.code, risk.name, risk.group);
        //     // Handlers diretos (mantidos)
        //     const onSelect = function(e) {
        //       debugger;
        //       if (e && typeof e.preventDefault === 'function') e.preventDefault();
        //       if (e && typeof e.stopPropagation === 'function') e.stopPropagation();
        //       isSelectingRisk = true;
        //       console.log('Risco clicado:', risk);

              
        //       if (risk.isOther) {
        //         currentOtherRisk = risk;
        //         customRiskName.value = '';
        //         if (customRiskModal) customRiskModal.style.display = 'flex';
        //         if (customRiskName) customRiskName.focus();
        //       } else {
        //         if (searchBox) searchBox.value = '';
        //         if (searchResults) searchResults.style.display = 'none';
        //         addSelectedRisk(risk.code, risk.name, risk.group);
        //         setTimeout(function(){ isSelectingRisk = false; }, 0);
        //       }
        //     };
        //     riskElement.addEventListener('click', onSelect, false);
        //     riskElement.addEventListener('mousedown', onSelect, false);

        //     searchResults.appendChild(riskElement);
        //   });
          
        //   // Se estamos em seleção, não reabrir
        //   searchResults.style.display = isSelectingRisk ? 'none' : 'block';
        // } else {
        //   const noResults = document.createElement('div');
        //   noResults.className = 'no-results';
        //   noResults.textContent = 'Nenhum risco encontrado';
        //   searchResults.appendChild(noResults);
        //   searchResults.style.display = isSelectingRisk ? 'none' : 'block';
        // }
      }
      
      // function addSelectedRisk(code, name, group) {
      //   debugger;
      //   console.log('addSelectedRisk chamado:', { code, name, group });
      //   if (!selectedRisks[code]) {
      //     selectedRisks[code] = { name, group };
      //     // marca como alterado para possíveis gravações condicionais ao sair/voltar da aba
      //     window._riscosDirty = true;
      //     updateSelectedRisksDisplay();
      //     // Não reexecuta performSearch; mantém a listagem atual (renderizada uma única vez)
      //   }
      // }
      
      // // Expõe globalmente para qualquer handler legado acessar
      // try {
      //   window.addSelectedRisk = addSelectedRisk;
      //   window.reaplicarRiscosSelecionadosUI = reaplicarRiscosSelecionadosUI;
      //   window.updateSelectedGroups = updateSelectedGroups;
      //   window.getSelectedRiskCodes = function() { return Object.keys(selectedRisks || {}); };
      //   window.reaplicarGruposSelecionadosUI = reaplicarGruposSelecionadosUI;
      // } catch (e) { /* ignore */ }

      function addSelectedRisk(code, name, group) {
  debugger;
  console.log('addSelectedRisk chamado:', { code, name, group });

  // garante que o objeto global existe
  if (!window.selectedRisks) window.selectedRisks = {};

  if (!window.selectedRisks[code]) {
    window.selectedRisks[code] = { name, group };
    window._riscosDirty = true;

    // atualiza a UI
    updateSelectedRisksDisplay();

    // Não reexecuta performSearch; mantém a listagem atual
  }
}

// expõe globalmente
try {
  window.addSelectedRisk = addSelectedRisk;
  window.reaplicarRiscosSelecionadosUI = reaplicarRiscosSelecionadosUI;
  window.updateSelectedGroups = updateSelectedGroups;
  window.getSelectedRiskCodes = function() { return Object.keys(window.selectedRisks || {}); };
  window.reaplicarGruposSelecionadosUI = reaplicarGruposSelecionadosUI;
} catch (e) { /* ignore */ }

      
      let riscos_selecionados = [];
      let json_riscos;

      async function updateSelectedRisksDisplay() {
  if (window._riscosRenderRunning) return;
  window._riscosRenderRunning = true;

  try {
    // Reconstrói array de riscos
    const riscos_selecionados = Object.entries(window.selectedRisks || {}).map(([codigo, info]) => ({
      codigo,
      descricao: info.name,
      grupo: info.group,
    }));

    console.log('Riscos selecionados (array):', riscos_selecionados);
    json_riscos = JSON.stringify(riscos_selecionados);

    // Persistência assíncrona
    try {
      await gravar_riscos_selecionados();
      window.riscosEstadoSalvoCodes = riscos_selecionados.map(r => String(r.codigo));
      window.riscosEstadoSalvoDetalhes = { ...window.selectedRisks };
      window._riscosDirty = false;
    } catch (err) {
      console.warn('Falha ao gravar riscos selecionados:', err);
    }

    const container = document.getElementById('selected-risks-container');
    if (!container) return;

    // ==============================
    // 2️⃣ Delegação de remoção (bind uma vez)
    // ==============================
    if (!container._removeDelegationBound) {
      container.addEventListener('click', function (e) {
        const btn = e.target?.closest('.remove-risk');
        if (!btn || !container.contains(btn)) return;

        e.stopPropagation?.();
        e.preventDefault?.();

        const codeToRemove = btn.getAttribute('data-code');
        if (codeToRemove && window.selectedRisks?.[codeToRemove]) {
          delete window.selectedRisks[codeToRemove];
          window._riscosDirty = true;

          // chama atualização após remover
          updateSelectedRisksDisplay();
          if (window.searchBox?.value.trim() !== '') {
            try { performSearch(window.searchBox.value); } catch (_) {}
          }
        }
      });
      container._removeDelegationBound = true;
    }

    // Limpa container
    container.innerHTML = '';

    if (riscos_selecionados.length === 0) {
      const empty = document.createElement('div');
      empty.className = 'no-risks';
      empty.textContent = 'Nenhum risco selecionado';
      container.appendChild(empty);
      return;
    }

    // Agrupa e renderiza riscos
    const risksByGroup = {};
    for (const { codigo, descricao, grupo } of riscos_selecionados) {
      if (!risksByGroup[grupo]) risksByGroup[grupo] = [];
      risksByGroup[grupo].push({ code: codigo, name: descricao });
    }

    for (const [group, risks] of Object.entries(risksByGroup)) {
      const groupName = risksData[group]?.name || group;
      const groupEl = document.createElement('div');
      groupEl.className = 'risk-group';

      const header = document.createElement('div');
      header.className = 'risk-group-header';
      header.textContent = groupName;

      const content = document.createElement('div');
      content.className = 'risk-group-content';

      risks.forEach(risk => {
        const riskEl = document.createElement('div');
        riskEl.className = 'selected-risk';
        riskEl.innerHTML = `
          <span style="font-size: 0.85em;">${risk.code} - ${risk.name}</span>
          <span class="remove-risk" data-code="${risk.code}" title="Remover" style="font-size: 0.9em;">×</span>
        `;
        content.appendChild(riskEl);
      });

      groupEl.appendChild(header);
      groupEl.appendChild(content);
      container.appendChild(groupEl);
    }

  } finally {
    window._riscosRenderRunning = false;
  }
}


      // async function updateSelectedRisksDisplay() {
      //   debugger;
      //   if (window._riscosRenderRunning) return;
      //   window._riscosRenderRunning = true;

      //   try {
      //     // Reconstrói o array consolidado a partir do objeto selectedRisks (sem duplicar, reflete remoções)
      //     riscos_selecionados = Object.entries(selectedRisks).map(([codigo, info]) => ({
      //       codigo,
      //       descricao: info.name,
      //       grupo: info.group,
      //     }));

      //     console.log('Riscos selecionados (array):', riscos_selecionados);
      //     json_riscos = JSON.stringify(riscos_selecionados);

      //     // Não alterar seleção de grupos aqui; grupos são controlados apenas pelos checkboxes

      //     // Persistência assíncrona imediata (mantém comportamento atual ao selecionar/remover)
      //     try {
      //       const ret = await gravar_riscos_selecionados();
      //       // Atualiza snapshot de persistência e limpa dirty
      //       window.riscosEstadoSalvoCodes = riscos_selecionados.map(r => String(r.codigo));
      //       // Salva também detalhes para reidratar na reentrada da aba
      //       window.riscosEstadoSalvoDetalhes = { ...selectedRisks };
      //       window._riscosDirty = false;
      //       // Não reaplicar grupos aqui para não desmarcar a escolha do usuário
      //     } catch (err) {
      //       console.warn('Falha ao gravar riscos selecionados (não bloqueante):', err);
      //     }

      //     // Renderização de UI
      //     const selectedRisksContainer = document.getElementById('selected-risks-container');
      //     if (!selectedRisksContainer) return;

      //     // Delegação de eventos para remover risco (bind uma vez)
      //     if (!selectedRisksContainer._removeDelegationBound) {
      //       selectedRisksContainer.addEventListener('click', function(e) {
      //         const btn = e.target && e.target.closest ? e.target.closest('.remove-risk') : null;
      //         if (!btn || !selectedRisksContainer.contains(btn)) return;
      //         if (typeof e.stopPropagation === 'function') e.stopPropagation();
      //         if (typeof e.preventDefault === 'function') e.preventDefault();
      //         const codeToRemove = btn.getAttribute('data-code');
      //         if (codeToRemove && selectedRisks[codeToRemove]) {
      //           delete selectedRisks[codeToRemove];
      //           window._riscosDirty = true;
      //           updateSelectedRisksDisplay();
      //           if (searchBox && searchBox.value && searchBox.value.trim() !== '') {
      //             try { performSearch(searchBox.value); } catch (e) { /* ignore */ }
      //           }
      //         }
      //       });
      //       selectedRisksContainer._removeDelegationBound = true;
      //     }

      //     selectedRisksContainer.innerHTML = '';

      //     if (riscos_selecionados.length === 0) {
      //       const emptyMessage = document.createElement('div');
      //       emptyMessage.className = 'no-risks';
      //       emptyMessage.textContent = 'Nenhum risco selecionado';
      //       selectedRisksContainer.appendChild(emptyMessage);
      //       return;
      //     }

      //     // Agrupar riscos por categoria
      //     const risksByGroup = {};
      //     for (const { codigo, descricao, grupo } of riscos_selecionados) {
      //       if (!risksByGroup[grupo]) risksByGroup[grupo] = [];
      //       risksByGroup[grupo].push({ code: codigo, name: descricao });
      //     }

      //     for (const [group, risks] of Object.entries(risksByGroup)) {
      //       const groupName = risksData[group] ? risksData[group].name : group;
      //       const groupElement = document.createElement('div');
      //       groupElement.className = 'risk-group';
      //       const groupHeader = document.createElement('div');
      //       groupHeader.className = 'risk-group-header';
      //       groupHeader.textContent = groupName;
      //       const groupContent = document.createElement('div');
      //       groupContent.className = 'risk-group-content';
      //       risks.forEach(risk => {
      //         const riskElement = document.createElement('div');
      //         riskElement.className = 'selected-risk';
      //         riskElement.innerHTML = `
      //           <span style="font-size: 0.85em;">${risk.code} - ${risk.name}</span>
      //           <span class="remove-risk" data-code="${risk.code}" title="Remover" style="font-size: 0.9em;">×</span>
      //         `;
      //         groupContent.appendChild(riskElement);
      //       });
      //       groupElement.appendChild(groupHeader);
      //       groupElement.appendChild(groupContent);
      //       selectedRisksContainer.appendChild(groupElement);
      //     }

      //     // Removido binding direto por querySelectorAll('.remove-risk');
      //     // Agora a remoção é tratada via delegação no container 'selected-risks-container'.
      //   } finally {
      //     window._riscosRenderRunning = false;
      //   }
      // }

      function reaplicarRiscosSelecionadosUI() {
  debugger;
  if (window._riscosRenderRunning) return;
  window._riscosRenderRunning = true;

  try {
    const selectedRisksContainer = document.getElementById('selected-risks-container');
    if (!selectedRisksContainer) return;

    // ==============================
    // 1️⃣ Determina a fonte dos riscos
    // ==============================
    let riscosFonte = [];

    // 🔹 Caso 1: Edição (dados vindos do banco)
    if (window.recebe_acao === "editar" && window.kit_riscos) {
      let kitRiscosArray = window.kit_riscos;

      // Se vier como string, converte para array
      if (typeof kitRiscosArray === "string") {
        try { 
          kitRiscosArray = JSON.parse(kitRiscosArray); 
        } catch (e) { 
          console.error("Erro ao parsear window.kit_riscos:", e);
          kitRiscosArray = []; 
        }
      }

      // Só processa se realmente for array
      if (Array.isArray(kitRiscosArray) && kitRiscosArray.length > 0) {
        riscosFonte = kitRiscosArray.map(r => ({
          codigo: r.codigo || '',
          descricao: r.descricao || '',
          grupo: r.grupo || ''
        }));
        console.log("🟢 Modo edição: riscos carregados do banco (window.kit_riscos)");
      }
    }

    // 🔹 Caso 2: Snapshot (usuário trocou de aba)
    else if (Array.isArray(window._snapshotRiscosSelecionados) && window._snapshotRiscosSelecionados.length > 0) {
      riscosFonte = window._snapshotRiscosSelecionados.map(r => ({
        codigo: r.codigo || '',
        descricao: r.descricao || '',
        grupo: r.grupo || ''
      }));
      console.log("🟠 Usando snapshot da navegação entre abas (_snapshotRiscosSelecionados)");
    }
    // 🔹 Caso 3: Sessão atual (usuário marcou riscos manualmente)
    else if (typeof window.selectedRisks === 'object' && Object.keys(window.selectedRisks).length > 0) {
      riscosFonte = Object.entries(window.selectedRisks).map(([codigo, info]) => ({
        codigo,
        descricao: info.name,
        grupo: info.group
      }));
      console.log("🟡 Usando riscos da sessão atual (selectedRisks)");
    }

    // ==============================
    // 2️⃣ Garante listener de remoção
    // ==============================
    if (!selectedRisksContainer._removeDelegationBound) {
      selectedRisksContainer.addEventListener('click', function (e) {
        const btn = e.target && e.target.closest ? e.target.closest('.remove-risk') : null;
        if (!btn || !selectedRisksContainer.contains(btn)) return;

        e.stopPropagation?.();
        e.preventDefault?.();

        const codeToRemove = btn.getAttribute('data-code');
        if (codeToRemove && window.selectedRisks && window.selectedRisks[codeToRemove]) {
          delete window.selectedRisks[codeToRemove];
          window._riscosDirty = true;
          updateSelectedRisksDisplay?.();

          if (window.searchBox && window.searchBox.value.trim() !== '') {
            try { performSearch(window.searchBox.value); } catch (_) {}
          }
        }
      });
      selectedRisksContainer._removeDelegationBound = true;
    }

    // ==============================
    // 3️⃣ Atualiza exibição dos riscos
    // ==============================
    selectedRisksContainer.innerHTML = '';

    if (!riscosFonte.length) {
      const emptyMessage = document.createElement('div');
      emptyMessage.className = 'no-risks';
      emptyMessage.textContent = 'Nenhum risco selecionado';
      selectedRisksContainer.appendChild(emptyMessage);
      return;
    }

    // Agrupa os riscos por grupo
    const risksByGroup = {};
    riscosFonte.forEach(({ codigo, descricao, grupo }) => {
      if (!grupo) return;
      if (!risksByGroup[grupo]) risksByGroup[grupo] = [];
      risksByGroup[grupo].push({ code: codigo, name: descricao });
    });

    // Fonte de nomes de grupo (usa global se existir)
    const risksDataGlobal =
      (typeof window.risksData === "object" && Object.keys(window.risksData).length > 0)
        ? window.risksData
        : {};

    // Monta o HTML
    for (const [group, risks] of Object.entries(risksByGroup)) {
      const groupName = risksDataGlobal[group]?.name || group;
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

    // ==============================
    // 4️⃣ Atualiza globais no final
    // ==============================
    window.selectedRisks = {};
    riscosFonte.forEach(r => {
      if (!r.codigo) return;
      window.selectedRisks[r.codigo] = { name: r.descricao, group: r.grupo };
    });
    window._snapshotRiscosSelecionados = riscosFonte.slice();

    console.log("✅ reaplicarRiscosSelecionadosUI concluído:", riscosFonte.length, "riscos reaplicados.");
  } catch (e) {
    console.error("Erro em reaplicarRiscosSelecionadosUI:", e);
  } finally {
    window._riscosRenderRunning = false;
  }
}


//       function reaplicarRiscosSelecionadosUI() {
//   debugger;
//   if (window._riscosRenderRunning) return;
//   window._riscosRenderRunning = true;

//   try {
//     const selectedRisksContainer = document.getElementById('selected-risks-container');
//     if (!selectedRisksContainer) return;

//     // ==============================
//     // 1️⃣ Determina a fonte dos riscos
//     // ==============================
//     let riscosFonte = [];

//     // ✅ 1. Se estamos na edição e existem variáveis globais de snapshot preenchidas
//     if (Array.isArray(window._snapshotRiscosSelecionados) && window._snapshotRiscosSelecionados.length > 0) {
//       riscosFonte = window._snapshotRiscosSelecionados.map(r => ({
//         codigo: r.codigo || '',
//         descricao: r.descricao || '',
//         grupo: r.grupo || ''
//       }));
//       console.log("🟢 Usando riscos da edição (_snapshotRiscosSelecionados)");
//     }
//     // ✅ 2. Caso contrário, se há dados de repopulação do banco (cadastrando)
//     else if (Array.isArray(window.kit_riscos) && window.kit_riscos.length > 0) {
//       // Se vier como string JSON, tenta converter
//       let kitRiscosArray = window.kit_riscos;
//       if (typeof kitRiscosArray === "string") {
//         try { kitRiscosArray = JSON.parse(kitRiscosArray); } 
//         catch { kitRiscosArray = []; }
//       }
//       riscosFonte = kitRiscosArray.map(r => ({
//         codigo: r.codigo || '',
//         descricao: r.descricao || '',
//         grupo: r.grupo || ''
//       }));
//       console.log("🟡 Usando riscos da repopulação do cadastro (window.kit_riscos)");
//     }
//     // ✅ 3. Caso contrário, usa selectedRisks da sessão atual
//     else if (typeof window.selectedRisks === 'object' && Object.keys(window.selectedRisks).length > 0) {
//       riscosFonte = Object.entries(window.selectedRisks).map(([codigo, info]) => ({
//         codigo,
//         descricao: info.name,
//         grupo: info.group
//       }));
//       console.log("🟠 Usando riscos da sessão atual (selectedRisks)");
//     }

//     // ==============================
//     // 2️⃣ Garante listener de remoção
//     // ==============================
//     if (!selectedRisksContainer._removeDelegationBound) {
//       selectedRisksContainer.addEventListener('click', function (e) {
//         const btn = e.target && e.target.closest ? e.target.closest('.remove-risk') : null;
//         if (!btn || !selectedRisksContainer.contains(btn)) return;

//         e.stopPropagation?.();
//         e.preventDefault?.();

//         const codeToRemove = btn.getAttribute('data-code');
//         if (codeToRemove && window.selectedRisks && window.selectedRisks[codeToRemove]) {
//           delete window.selectedRisks[codeToRemove];
//           window._riscosDirty = true;
//           updateSelectedRisksDisplay?.();

//           if (window.searchBox && window.searchBox.value.trim() !== '') {
//             try { performSearch(window.searchBox.value); } catch (_) {}
//           }
//         }
//       });
//       selectedRisksContainer._removeDelegationBound = true;
//     }

//     // ==============================
//     // 3️⃣ Atualiza exibição dos riscos
//     // ==============================
//     selectedRisksContainer.innerHTML = '';

//     if (!riscosFonte.length) {
//       const emptyMessage = document.createElement('div');
//       emptyMessage.className = 'no-risks';
//       emptyMessage.textContent = 'Nenhum risco selecionado';
//       selectedRisksContainer.appendChild(emptyMessage);
//       return;
//     }

//     // Agrupa os riscos por grupo
//     const risksByGroup = {};
//     riscosFonte.forEach(({ codigo, descricao, grupo }) => {
//       if (!grupo) return;
//       if (!risksByGroup[grupo]) risksByGroup[grupo] = [];
//       risksByGroup[grupo].push({ code: codigo, name: descricao });
//     });

//     // Fonte de nomes de grupo (usa global se existir)
//     const risksDataGlobal =
//       (typeof window.risksData === "object" && Object.keys(window.risksData).length > 0)
//         ? window.risksData
//         : {};

//     // Monta o HTML
//     for (const [group, risks] of Object.entries(risksByGroup)) {
//       const groupName = risksDataGlobal[group]?.name || group;
//       const groupElement = document.createElement('div');
//       groupElement.className = 'risk-group';

//       const groupHeader = document.createElement('div');
//       groupHeader.className = 'risk-group-header';
//       groupHeader.textContent = groupName;

//       const groupContent = document.createElement('div');
//       groupContent.className = 'risk-group-content';

//       risks.forEach(risk => {
//         const riskElement = document.createElement('div');
//         riskElement.className = 'selected-risk';
//         riskElement.innerHTML = `
//           <span style="font-size: 0.85em;">${risk.code} - ${risk.name}</span>
//           <span class="remove-risk" data-code="${risk.code}" title="Remover" style="font-size: 0.9em;">×</span>
//         `;
//         groupContent.appendChild(riskElement);
//       });

//       groupElement.appendChild(groupHeader);
//       groupElement.appendChild(groupContent);
//       selectedRisksContainer.appendChild(groupElement);
//     }

//     console.log("✅ reaplicarRiscosSelecionadosUI concluído:", riscosFonte.length, "riscos reaplicados.");
//   } catch (e) {
//     console.error("Erro em reaplicarRiscosSelecionadosUI:", e);
//   } finally {
//     window._riscosRenderRunning = false;
//   }
// }



      function gravar_riscos_selecionados()
      {
        if(window.recebe_acao && window.recebe_acao === "editar")
        {
          return new Promise((resolve, reject) => {
              $.ajax({
                url: "cadastros/processa_geracao_kit.php",
                type: "POST",
                dataType: "json",
                data: {
                  processo_geracao_kit: "atualizar_kit",
                  valor_riscos: json_riscos,
                  valor_id_kit:window.recebe_id_kit
                },
                success: function (retorno_exame_geracao_kit) {
                  debugger;

                  const mensagemSucesso = `
                    <div id="riscos-gravado" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
                      <div style="display: flex; align-items: center; justify-content: center;">
                        <div>
                          <div>KIT atualizado com sucesso.</div>
                        </div>
                      </div>
                    </div>
                  `;

                  // Remove mensagem anterior se existir
                  $("#riscos-gravado").remove();

                  // Adiciona a nova mensagem acima das abas
                  $(".tabs-container").before(mensagemSucesso);

                  // Configura o fade out após 5 segundos
                  setTimeout(function () {
                    $("#riscos-gravado").fadeOut(500, function () {
                      $(this).remove();
                    });
                  }, 5000);

                  console.log(retorno_exame_geracao_kit);
                  // Snapshot global após sucesso (caso chamado externamente)
                  try {
                    if (Array.isArray(riscos_selecionados)) {
                      window.riscosEstadoSalvoCodes = riscos_selecionados.map(r => String(r.codigo));
                    }
                    if (typeof selectedRisks === 'object') {
                      window.riscosEstadoSalvoDetalhes = { ...selectedRisks };
                    }
                    window._riscosDirty = false;
                  } catch (e) { /* ignore */ }
                  resolve(retorno_exame_geracao_kit);
                },
                error: function (xhr, status, error) {
                  console.log("Falha ao incluir exame: " + error);
                  reject(error);
                },
              });
            });
        }else
        {
            return new Promise((resolve, reject) => {
              $.ajax({
                url: "cadastros/processa_geracao_kit.php",
                type: "POST",
                dataType: "json",
                data: {
                  processo_geracao_kit: "incluir_valores_kit",
                  valor_riscos: json_riscos,
                },
                success: function (retorno_exame_geracao_kit) {
                  debugger;

                  const mensagemSucesso = `
                    <div id="riscos-gravado" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
                      <div style="display: flex; align-items: center; justify-content: center;">
                        <div>
                          <div>KIT atualizado com sucesso.</div>
                        </div>
                      </div>
                    </div>
                  `;

                  // Remove mensagem anterior se existir
                  $("#riscos-gravado").remove();

                  // Adiciona a nova mensagem acima das abas
                  $(".tabs-container").before(mensagemSucesso);

                  // Configura o fade out após 5 segundos
                  setTimeout(function () {
                    $("#riscos-gravado").fadeOut(500, function () {
                      $(this).remove();
                    });
                  }, 5000);

                  console.log(retorno_exame_geracao_kit);
                  // Snapshot global após sucesso (caso chamado externamente)
                  try {
                    if (Array.isArray(riscos_selecionados)) {
                      window.riscosEstadoSalvoCodes = riscos_selecionados.map(r => String(r.codigo));
                    }
                    if (typeof selectedRisks === 'object') {
                      window.riscosEstadoSalvoDetalhes = { ...selectedRisks };
                    }
                    window._riscosDirty = false;
                  } catch (e) { /* ignore */ }
                  resolve(retorno_exame_geracao_kit);
                },
                error: function (xhr, status, error) {
                  console.log("Falha ao incluir exame: " + error);
                  reject(error);
                },
              });
            });
        }
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

    let recebe_exame_selecionado;
    let ajaxEmExecucao = false; // evita chamadas duplicadas

    function verifica_selecao_exame() {
      debugger;
      const examCards = document.querySelectorAll('.exam-card');

      examCards.forEach(card => {
        //debugger;
        card.addEventListener('click', function() {
          // Remove active de todos
          examCards.forEach(c => c.classList.remove('active'));
          this.classList.add('active');

          // Define o exame selecionado
          recebe_exame_selecionado = this.dataset.exam;
          appState.selectedExam = recebe_exame_selecionado;
          appState.validation.examSelected = true;

          // Remove validação visível
          document.getElementById('examValidation').classList.remove('validation-visible');

          console.log('Exame selecionado:', appState.selectedExam);

          // Só chama o AJAX se não estiver em execução
          if (!ajaxEmExecucao) {
            debugger;
            ajaxEmExecucao = true;
            gravar_selecao_exame(recebe_exame_selecionado);
          }
        });
      });
    }

    function gravar_selecao_exame(valorExame) {
      debugger;

      if(window.recebe_acao && window.recebe_acao === "editar")
      {
          $.ajax({
          url: "cadastros/processa_geracao_kit.php",
          type: "POST",
          dataType: "json",
          data: {
            processo_geracao_kit: "atualizar_kit",
            valor_exame: valorExame,
            valor_id_kit:window.recebe_id_kit
          },
          success: function(retorno_exame_geracao_kit) {
            debugger;

            const mensagemSucesso = `
                  <div id="exame-gravado" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
                    <div style="display: flex; align-items: center; justify-content: center;">
                      
                      <div>
                        
                        <div>Exame cadastrado com sucesso.</div>
                      </div>
                    </div>
                  </div>
            `;

            // Remove mensagem anterior se existir
            $("#exame-gravado").remove();
                
            // Adiciona a nova mensagem acima das abas
            $(".tabs-container").before(mensagemSucesso);

            // Configura o fade out após 5 segundos
            setTimeout(function() {
              $("#exame-gravado").fadeOut(500, function() {
              $(this).remove();
              });
            }, 5000);


            $("#exame-gravado").html(retorno_exame_geracao_kit);
            $("#exame-gravado").show();
            $("#exame-gravado").fadeOut(4000);
            console.log(retorno_exame_geracao_kit);
            ajaxEmExecucao = false; // libera para nova requisição
          },
          error: function(xhr, status, error) {
            console.log("Falha ao incluir exame: " + error);
            ajaxEmExecucao = false; // libera para tentar de novo
          },
        });
      }else{
        $.ajax({
        url: "cadastros/processa_geracao_kit.php",
        type: "POST",
        dataType: "json",
        data: {
          processo_geracao_kit: "incluir_valores_kit",
          valor_exame: valorExame,
        },
        success: function(retorno_exame_geracao_kit) {
          debugger;

          const mensagemSucesso = `
                <div id="exame-gravado" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
                  <div style="display: flex; align-items: center; justify-content: center;">
                    
                    <div>
                      
                      <div>Exame cadastrado com sucesso.</div>
                    </div>
                  </div>
                </div>
          `;

          // Remove mensagem anterior se existir
          $("#exame-gravado").remove();
              
          // Adiciona a nova mensagem acima das abas
          $(".tabs-container").before(mensagemSucesso);

          // Configura o fade out após 5 segundos
          setTimeout(function() {
            $("#exame-gravado").fadeOut(500, function() {
            $(this).remove();
            });
          }, 5000);


          $("#exame-gravado").html(retorno_exame_geracao_kit);
          $("#exame-gravado").show();
          $("#exame-gravado").fadeOut(4000);
          console.log(retorno_exame_geracao_kit);
          ajaxEmExecucao = false; // libera para nova requisição
        },
        error: function(xhr, status, error) {
          console.log("Falha ao incluir exame: " + error);
          ajaxEmExecucao = false; // libera para tentar de novo
        },
      }); 
      }     
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
      verifica_selecao_exame();
      
      // Restaurar a seleção do exame se existir
      if (appState.selectedExam) {
        const selectedCard = document.querySelector(`.exam-card[data-exam="${appState.selectedExam}"]`);
        if (selectedCard) {
          selectedCard.click();
        }
      }
    });

    let empresas = [];
    let clinicas = [];
    let pessoas = [];
    let cargos = [];

    

    $(document).ready(async function(e){
      debugger;

      



      $("#exame-gravado").hide();
      
      // Adiciona evento de input para busca de empresas
      // Adiciona o evento de mudança para os checkboxes
      const $groupContainer = $('#group-select-container');
      $groupContainer.off('change', 'input[type="checkbox"]') // Remove eventos anteriores para evitar duplicação
             .on('change', 'input[type="checkbox"]', function() {
                console.log('Checkbox alterado:', $(this).val(), $(this).prop('checked'));
                if (typeof window.updateSelectedGroups === 'function') {
                  window.updateSelectedGroups();
                } else {
                  console.error('Função updateSelectedGroups não encontrada no escopo global');
                }
             });
      
      // Inicializa os grupos selecionados
      if (typeof updateSelectedGroups === 'function') {
        updateSelectedGroups();
      } 
      
      $("#inputEmpresa").on('input', function() {
        console.log('Input empresa alterado, valor:', $(this).val());
        buscarECP('empresas', 'inputEmpresa', 'resultEmpresa', 'nome');
      });
      
      // Adiciona evento de input para busca de clínicas
      $("#inputClinica").on('input', function() {
        console.log('Input clínica alterado, valor:', $(this).val());
        buscarECP('clinicas', 'inputClinica', 'resultClinica', 'nome');
      });
      
      // Força a busca inicial para testar
      console.log('Forçando busca inicial de empresas...');
      buscarECP('empresas', 'inputEmpresa', 'resultEmpresa', 'nome');
      
      console.log('Forçando busca inicial de clínicas...');
      buscarECP('clinicas', 'inputClinica', 'resultClinica', 'nome');

      if(window.recebe_acao === "editar")
      {
        if (!$('#kit-toast-style').length) {
            $('head').append('<style id="kit-toast-style">\n              #kit-toast {\n                position: fixed;\n                top: 10px;\n                right: 10px;\n                background: #28a745; /* verde similar ao totalizador */\n                color: #fff;\n                padding: 8px 16px;\n                border-radius: 4px;\n                font-weight: 600;\n                z-index: 9999;\n                display: none;\n                box-shadow: 0 2px 6px rgba(0,0,0,.2);\n              }\n            </style>');
          }

          // Cria (ou reusa) o banner
          let $toast = $('#kit-toast');
          if (!$toast.length) {
            $toast = $('<div id="kit-toast"></div>').appendTo('body');
          }
          $toast.text('Edição do kit iniciada').stop(true, true).fadeIn(200).delay(5000).fadeOut(1000);
      }else
      {
        $.ajax({
        url: "cadastros/processa_geracao_kit.php",
        type: "POST",
        dataType: "json",
        data: {
          processo_geracao_kit: "geracao_kit_sessao",
        },
        beforeSend: function(xhr) {
          console.log('[KIT] Enviando requisição de sessão...');
        },
        success: function(retorno_exame_geracao_kit, textStatus, xhr) {
          debugger; // sucesso JSON parseado
          console.log('[KIT][SUCCESS] status:', textStatus);
          console.log('[KIT][SUCCESS] objeto:', retorno_exame_geracao_kit);
          try { console.log('[KIT][SUCCESS] bruto:', xhr && xhr.responseText); } catch(_) {}
          // Injeta estilo do banner apenas uma vez
          if (!$('#kit-toast-style').length) {
            $('head').append('<style id="kit-toast-style">\n              #kit-toast {\n                position: fixed;\n                top: 10px;\n                right: 10px;\n                background: #28a745; /* verde similar ao totalizador */\n                color: #fff;\n                padding: 8px 16px;\n                border-radius: 4px;\n                font-weight: 600;\n                z-index: 9999;\n                display: none;\n                box-shadow: 0 2px 6px rgba(0,0,0,.2);\n              }\n            </style>');
          }

          // Cria (ou reusa) o banner
          let $toast = $('#kit-toast');
          if (!$toast.length) {
            $toast = $('<div id="kit-toast"></div>').appendTo('body');
          }
          $toast.text('Gravação do kit iniciada').stop(true, true).fadeIn(200).delay(5000).fadeOut(1000);
        },
        error: function(xhr, status, error) {
          debugger; // erro retornado pelo PHP ou falha de parse JSON
          console.error('[KIT][ERROR] status:', status, 'error:', error);
          try { console.error('[KIT][ERROR] bruto:', xhr && xhr.responseText); } catch(_) {}
        },
        complete: function(xhr, status) {
          // Sempre mostra o retorno bruto para depuração
          console.log('[KIT][COMPLETE] status:', status);
          try { console.log('[KIT][COMPLETE] bruto:', xhr && xhr.responseText); } catch(_) {}
          try { console.log('[KIT][COMPLETE] headers:', xhr && xhr.getAllResponseHeaders && xhr.getAllResponseHeaders()); } catch(_) {}
        }
      });
      }


      console.log('Iniciando carregamento de empresas...');
      $.ajax({
        url: "cadastros/processa_empresa.php",
        method: "GET",
        dataType: "json",
        data: { processo_empresa: "buscar_empresas" },
        success: async function(resposta_empresa) {
          console.log('Resposta bruta da API de empresas:', resposta_empresa);
          try {
            if (resposta_empresa && resposta_empresa.length > 0) {
              for (let i = 0; i < resposta_empresa.length; i++) {
                const emp = resposta_empresa[i];
                let nomeCidade = '';
                let nomeEstado = '';

                // Consulta cidade
                await $.ajax({
                  url: `https://servicodados.ibge.gov.br/api/v1/localidades/municipios/${emp.id_cidade}`,
                  method: "GET",
                  dataType: "json",
                  success: function(cidadeResp){
                    // debugger;
                    nomeCidade = cidadeResp && cidadeResp.nome ? cidadeResp.nome : '';
                  },
                  error: function(){ console.error('Erro ao buscar cidade ID:', emp.id_cidade); }
                });

                // Consulta estado
                await $.ajax({
                  url: `https://servicodados.ibge.gov.br/api/v1/localidades/estados/${emp.id_estado}`,
                  method: "GET",
                  dataType: "json",
                  success: function(estadoResp){
                    // debugger;
                    nomeEstado = estadoResp && estadoResp.nome ? estadoResp.nome : '';
                  },
                  error: function(){ console.error('Erro ao buscar estado ID:', emp.id_estado); }
                });

                empresas.push({
                  id: emp.id,
                  nome: emp.nome,
                  cnpj:emp.cnpj,
                  endereco: emp.endereco,
                  complemento: emp.complemento,
                  bairro: emp.bairro,
                  cidade: nomeCidade,
                  estado: nomeEstado,
                  cep: emp.cep,
                  ativo: true,
                  quantidadeVidas: 10,
                  quantidadeClinicas: 5
                });
              }

              // Atualiza o array de empresas no ecpData
              if (ecpData) {
                ecpData.empresas = [...empresas]; // Cria uma cópia do array
                console.log('Empresas carregadas no ecpData:', ecpData.empresas);
                
                // Testa a busca após carregar as empresas
                if (ecpData.empresas.length > 0) {
                  console.log('Testando busca com primeira empresa:', ecpData.empresas[0].nome);
                  buscarECP('empresas', 'inputEmpresa', 'resultEmpresa', 'nome');
                }
              }
            }
          } catch(err) {
            console.error('Erro no processamento das empresas:', err);
          }
        },
        error: function(xhr, status, error){
          console.error("Erro na requisição empresas:", error);
        }
      });


      $.ajax({
        url: "api/list/clinicas.php?per_page=1000", // Endpoint da API
        method: "GET",
        dataType: "json",
        // data: { processo_empresa: "buscar_empresas" },
        success: async function(resposta_clinicas) {
          console.log('Clínicas retornadas:', resposta_clinicas);

          const listaClinicas = resposta_clinicas && resposta_clinicas.data && Array.isArray(resposta_clinicas.data.clinicas)
            ? resposta_clinicas.data.clinicas
            : [];

          if (listaClinicas.length > 0) {
            for (let c = 0; c < listaClinicas.length; c++) {
              clinicas.push({
                id:listaClinicas[c].id,
                nome: listaClinicas[c].nome_fantasia,
                cnpj: listaClinicas[c].cnpj,
              });
            }

            if (typeof ecpData !== 'undefined') {
              ecpData.clinicas = clinicas;
            }

            console.log('Clínicas carregadas:', clinicas);
          } else {
            console.warn('Nenhuma clínica encontrada na resposta.');
          }
        },
        error:function(xhr,status,error)
        {

        },
      });

      $.ajax({
          url: "cadastros/processa_pessoa.php", // Endpoint da API
          method: "GET",
          dataType: "json",
          data: {
            "processo_pessoa": "buscar_pessoas"
          },
          success: function(resposta_pessoa) 
          {
            // debugger;

            if(resposta_pessoa.length > 0)
            {
              for (let p = 0; p < resposta_pessoa.length; p++) 
              {
                pessoas.push({
                  id:resposta_pessoa[p].id,
                  nome:resposta_pessoa[p].nome,
                  cpf:resposta_pessoa[p].cpf,
                  cargo:"Analista de Segurança",
                  empresa:resposta_pessoa[p].empresa_id
                });
              }

              if (typeof ecpData !== 'undefined') {
              ecpData.colaboradores = pessoas;
              }

            console.log('Pessoas carregadas:', pessoas);
            }
          },
          error:function(xhr,status,error)
          {

          },
      });

      $.ajax({
          url: "cadastros/processa_cargo.php", // Endpoint da API
          method: "GET",
          dataType: "json",
          data: {
            "processo_cargo": "buscar_cargos"
          },
          success: function(resposta_cargo) 
          {
            // debugger;

            if(resposta_cargo.length > 0)
            {
              for (let c = 0; c < resposta_cargo.length; c++) 
              {
                cargos.push({
                  id:resposta_cargo[c].id,
                  titulo:resposta_cargo[c].titulo_cargo,
                  cbo:resposta_cargo[c].codigo_cargo,
                  descricao:resposta_cargo[c].descricao_cargo
                });
              }

              if (typeof ecpData !== 'undefined') {
              ecpData.cargos = cargos;
              }

            console.log('Pessoas carregadas:', cargos);
            }
          },
          error:function(xhr,status,error)
          {

          },
      });

      // $.ajax({
      //   url: "cadastros/processa_geracao_kit.php", // Endpoint da API
      //   method: "GET",
      //   dataType: "json",
      //   data: { processo_geracao_kit: "buscar_kits_empresa" },
      //   success: async function(resposta_kits) {
      //     debugger;
      //     console.log('KITs retornados:', resposta_kits);

      //     // const listaClinicas = resposta_clinicas && resposta_clinicas.data && Array.isArray(resposta_clinicas.data.clinicas)
      //     //   ? resposta_clinicas.data.clinicas
      //     //   : [];

      //     // if (listaClinicas.length > 0) {
      //     //   for (let c = 0; c < listaClinicas.length; c++) {
      //     //     clinicas.push({
      //     //       id:listaClinicas[c].id,
      //     //       nome: listaClinicas[c].nome_fantasia,
      //     //       cnpj: listaClinicas[c].cnpj,
      //     //     });
      //     //   }

      //     //   if (typeof ecpData !== 'undefined') {
      //     //     ecpData.clinicas = clinicas;
      //     //   }

      //     //   console.log('Clínicas carregadas:', clinicas);
      //     // } else {
      //     //   console.warn('Nenhuma clínica encontrada na resposta.');
      //     // }
      //   },
      //   error:function(xhr,status,error)
      //   {

      //   },
      // });
    });

    // Funções do ECP
    const ecpData = {
      empresas: [], // Inicializa como array vazio para evitar undefined
      //   { 
      //     id: 1, 
      //     nome: 'Empresa A', 
      //     cnpj: '00.000.000/0001-00',
      //     endereco: 'Rua das Flores, 123',
      //     complemento: 'Sala 42',
      //     bairro: 'Centro',
      //     cidade: 'São Paulo',
      //     estado: 'SP',
      //     cep: '01001-000',
      //     ativo: true,
      //     quantidadeVidas: 150,
      //     quantidadeClinicas: 5
      //   },
      //   { 
      //     id: 2, 
      //     nome: 'Empresa B', 
      //     cnpj: '00.000.000/0001-01',
      //     endereco: 'Av. Paulista, 1000',
      //     complemento: '10º andar',
      //     bairro: 'Bela Vista',
      //     cidade: 'São Paulo',
      //     estado: 'SP',
      //     cep: '01310-100',
      //     ativo: true,
      //     quantidadeVidas: 320,
      //     quantidadeClinicas: 8
      //   },
      // ],
      // clinicas: [
      //   { nome: "Clínica Vida", cnpj: "45.987.654/0001-01" }
      // ],
      // colaboradores: [
      //   { nome: "João da Silva", cpf: "123.456.789-00", cargo: "Analista de Segurança" },
      //   { nome: "Maria Oliveira", cpf: "987.654.321-00", cargo: "Técnico de Segurança" },
      //   { nome: "Carlos Eduardo", cpf: "456.123.789-11", cargo: "Engenheiro de Segurança" },
      //   { nome: "Ana Paula Santos", cpf: "789.123.456-22", cargo: "Enfermeira do Trabalho" },
      //   { nome: "Roberto Almeida", cpf: "321.654.987-33", cargo: "Técnico em Enfermagem" },
      //   { nome: "Fernanda Lima", cpf: "654.987.321-44", cargo: "Médica do Trabalho" },
      //   { nome: "Ricardo Pereira", cpf: "159.753.486-55", cargo: "Técnico em Segurança" }
      // ],
      // cargos: [
      //   { titulo: "Motorista de Caminhão", cbo: "7823-10", descricao: "Conduz caminhão para transporte de cargas, realizando operações de carga e descarga, manutenção preventiva e cumprindo normas de trânsito e segurança." },
      //   { titulo: "Auxiliar de Enfermagem", cbo: "3222-40", descricao: "Realiza atividades de assistência de enfermagem, como curativos, administração de medicamentos e acompanhamento do estado de saúde dos pacientes." },
      //   { titulo: "Técnico em Segurança do Trabalho", cbo: "3516-10", descricao: "Fiscaliza o cumprimento das normas de segurança, realiza inspeções, treinamentos e elabora relatórios de segurança no trabalho." },
      //   { titulo: "Eletricista de Manutenção", cbo: "7411-10", descricao: "Executa manutenção corretiva e preventiva em instalações elétricas, seguindo normas técnicas e de segurança." },
      //   { titulo: "Auxiliar Administrativo", cbo: "4110-10", descricao: "Auxilia nos serviços de escritório, como atendimento, arquivamento, organização de documentos e apoio às atividades administrativas." }
      // ]
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
    //debugger;
    console.log('buscarECP chamada com parâmetros:', {tipo, inputId, resultadoId, chave});
    console.log('ecpData no início da busca:', ecpData);
    console.log('Dados disponíveis para busca:', ecpData[tipo]);
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
        if (!ecpData) {
          console.error('ecpData não está definido');
          return;
        }
        
        if (!ecpData[tipo]) {
          console.error(`Tipo de busca '${tipo}' não encontrado em ecpData. Tipos disponíveis:`, Object.keys(ecpData));
          return;
        }
        
        console.log('Buscando', tipo, 'com termo:', valor, '| Valor normalizado:', valorBusca);
        
        // Filtra os itens baseado no tipo de busca
        let resultados = [];
        console.log(`Buscando em ${tipo} por:`, valorBusca, '(nome) ou', valorNumerico, '(CPF/CNPJ)');
        
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
        } else if (tipo === 'empresas') {
          console.log(`Buscando em ${ecpData.empresas.length} empresas`);
          // Busca em empresas (nome, CNPJ ou CPF)
          resultados = ecpData[tipo].filter(item => {
            if (!item) return false;
            
            try {
              // Busca por nome (insensível a acentos e case)
              const nome = removerAcentos(item[chave] || '').toLowerCase();
              const nomeMatch = nome.includes(valorBusca) || 
                              nome.split(' ').some(palavra => palavra.startsWith(valorBusca));
              
              // Busca por CNPJ/CPF (busca parcial)
              const cnpjCpf = (item.cnpj || item.cpf || '').replace(/[^\d]/g, '');
              const cnpjCpfMatch = valorNumerico && cnpjCpf.includes(valorNumerico);
              
              if (nomeMatch || cnpjCpfMatch) {
                console.log('Item encontrado:', {
                  nome: item[chave],
                  cnpj: item.cnpj,
                  cpf: item.cpf,
                  busca: valorBusca,
                  nomeMatch,
                  cnpjCpfMatch
                });
                return true;
              }
              return false;
            } catch (error) {
              console.error('Erro ao processar empresa:', item, error);
              return false;
            }
          });
        } else if (tipo === 'clinicas') {
          console.log(`Buscando em ${ecpData.clinicas.length} clínicas`);
          // Busca em clínicas (nome, CNPJ ou CPF)
          resultados = ecpData[tipo].filter(item => {
            if (!item) return false;
            
            try {
              // Busca por nome (insensível a acentos e case)
              const nome = removerAcentos(item.nome || '').toLowerCase();
              const nomeMatch = nome.includes(valorBusca) || 
                              nome.split(' ').some(palavra => palavra.startsWith(valorBusca));
              
              // Busca por CNPJ/CPF (busca parcial)
              const cnpjCpf = (item.cnpj || item.cpf || '').replace(/[^\d]/g, '');
              const cnpjCpfMatch = valorNumerico && cnpjCpf.includes(valorNumerico);
              
              if (nomeMatch || cnpjCpfMatch) {
                console.log('Clínica encontrada:', {
                  nome: item.nome,
                  cnpj: item.cnpj,
                  cpf: item.cpf,
                  busca: valorBusca,
                  nomeMatch,
                  cnpjCpfMatch
                });
                return true;
              }
              return false;
            } catch (error) {
              console.error('Erro ao processar clínica:', item, error);
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
          const html = resultados.map(item => {
            // Formata o texto de exibição
            let displayText = '';
            
            if (item.cbo) {
              displayText = `${item[chave]} (CBO: ${item.cbo})`;
            } else if (item.cpf) {
              displayText = `${item[chave]} (CPF: ${item.cpf})`;
            } else if (item.nome) {
              displayText = item.nome;
            } else {
              displayText = item[chave] || 'Sem nome';
            }
            
            // Cria o item de resultado com evento de clique
            const itemHtml = `
              <div class="ecp-result-item" 
                   onclick="selecionarECP('${inputId}', '${resultadoId}', ${JSON.stringify(item).replace(/"/g, '&quot;')}, '${chave}')"
                   style="cursor: pointer; padding: 8px 12px; border-bottom: 1px solid #eee;">
                ${displayText}
                ${item.cnpj ? `<div style="font-size: 0.8em; color: #666;">CNPJ: ${item.cnpj}</div>` : ''}
                ${item.cpf ? `<div style="font-size: 0.8em; color: #666;">CPF: ${item.cpf}</div>` : ''}
              </div>
            `;
            return itemHtml;
          }).join('');
          
          resultEl.innerHTML = html;
          resultEl.style.display = 'block';
          console.log('Resultados exibidos no elemento:', resultEl);
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

    let recebe_codigo_empresa_selecionada;

    let recebe_codigo_clinica_selecionada;

    let recebe_nome_clinica_selecionado;

    function requisitarKits(codigo_pessoa) {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: "cadastros/processa_geracao_kit.php",
          method: "GET",
          dataType: "json",
          data: { processo_geracao_kit: "buscar_kits_empresa",valor_pessoa_id: codigo_pessoa},
          success: function(resposta) {
            console.log("KITs retornados:", resposta);
            resolve(resposta);
          },
          error: function(xhr, status, error) {
            reject(error);
          }
        });
      });
    }

    function requisitarEmpresaPessoa(codigo_empresa) {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: "cadastros/processa_geracao_kit.php",
          method: "GET",
          dataType: "json",
          data: { processo_geracao_kit: "buscar_empresa_pessoa",valor_id_empresa: codigo_empresa},
          success: function(resposta) {
            console.log("Empresa retornada:", resposta);
            resolve(resposta);
          },
          error: function(xhr, status, error) {
            reject(error);
          }
        });
      });
    }

    function requisitarClinicaPessoa(codigo_clinica)
    {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: "cadastros/processa_geracao_kit.php",
          method: "GET",
          dataType: "json",
          data: { processo_geracao_kit: "busca_clinica_pessoa",valor_id_clinica: codigo_clinica},
          success: function(resposta) {
            console.log("Clinica retornada:", resposta);
            resolve(resposta);
          },
          error: function(xhr, status, error) {
            reject(error);
          }
        });
      });
    }

    function requisitarPessoa(codigo_pessoa)
    {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: "cadastros/processa_geracao_kit.php",
          method: "GET",
          dataType: "json",
          data: { processo_geracao_kit: "busca_pessoa",valor_id_pessoa: codigo_pessoa},
          success: function(resposta) {
            console.log("Pessoa retornada:", resposta);
            resolve(resposta);
          },
          error: function(xhr, status, error) {
            reject(error);
          }
        });
      });
    }

    function requisitarEmpresaPrimeiroKIT() {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: "cadastros/processa_geracao_kit.php",
          method: "GET",
          dataType: "json",
          data: { processo_geracao_kit: "buscar_empresa_primeiro_kit"},
          success: function(resposta) {
            console.log("Empresa retornada:", resposta);
            resolve(resposta);
          },
          error: function(xhr, status, error) {
            reject(error);
          }
        });
      });
    }

    let kitsColaboradores = {};

    let recebe_codigo_empresa_pessoa;
    let recebe_codigo_clinica_pessoa;
    let recebe_codigo_pessoa;
    let recebe_codigo_cargo;
    // let resposta_empresa_pessoa;
    // let resposta_clinica_pessoa;
    // let resposta_cargo_pessoa;
    let resposta_pessoa;
    let resposta_kits;

    async function selecionarECP(inputId, resultadoId, item, chave,situacao) {
      debugger;

  if (inputId === "inputColaborador") {
    // 🔹 requisita kits da pessoa
    if (item && item.id && item.id !== "") {
      resposta_kits = await requisitarKits(item.id);
    }


    // Se retornou kits, pega a empresa_id do primeiro
    if (resposta_kits && resposta_kits.length > 0) {
      if (recebe_codigo_empresa_pessoa === "" || recebe_codigo_empresa_pessoa == null) {
        recebe_codigo_empresa_pessoa = resposta_kits[0]["empresa_id"];
      }
  
      if (recebe_codigo_clinica_pessoa === "" || recebe_codigo_clinica_pessoa == null) {
        recebe_codigo_clinica_pessoa = resposta_kits[0]["clinica_id"];
      }

      if(recebe_codigo_pessoa === "" || recebe_codigo_pessoa == null)
      {
        recebe_codigo_pessoa = resposta_kits[0]["pessoa_id"];
      }

      if(recebe_codigo_cargo === "" || recebe_codigo_cargo == null)
      {
        recebe_codigo_cargo = resposta_kits[0]["cargo_id"];
      }
    }

    // 🔹 requisita dados da empresa (se existir empresa_id)
    if (recebe_codigo_empresa_pessoa) {
      resposta_empresa_pessoa = await requisitarEmpresaPessoa(recebe_codigo_empresa_pessoa);
    }else{
      //resposta_empresa_pessoa = await requisitarEmpresaPrimeiroKIT();
    }

    if(recebe_codigo_clinica_pessoa)
    {
      resposta_clinica_pessoa = await requisitarClinicaPessoa(recebe_codigo_clinica_pessoa);
    }

    if(recebe_codigo_pessoa){
      resposta_pessoa = await requisitarPessoa(recebe_codigo_pessoa);
    }else{
      resposta_pessoa = await requisitarPessoa(item.id);
    }

    if(recebe_codigo_cargo){
      resposta_cargo_pessoa = await requisitarDadosCargo(resposta_pessoa.id);
    }else{
      resposta_cargo_pessoa = await requisitarDadosCargo(item.id);
    }

    console.log("Resposta final de kits:", resposta_kits);
    console.log("Empresa:", resposta_empresa_pessoa?.nome);
  }

  // 🔹 Monta no formato do exemplo
  if (item?.cpf && resposta_kits && resposta_kits.length > 0) {
    // 🔹 Remove pontos e traços do CPF
    const cpfLimpo = item.cpf.replace(/[.\-]/g, "");

    kitsColaboradores = [];

    // Se não existir entrada para o CPF, cria array vazio
    if (!kitsColaboradores[cpfLimpo]) {
      kitsColaboradores[cpfLimpo] = [];
    }

    // Adiciona cada kit ao array do CPF
    resposta_kits.forEach(kit => {
      kitsColaboradores[cpfLimpo].push({
        id: kit.id || "",                                     // código do kit
        data: kit.data_geracao || "",                             // data de geração
        empresa: resposta_empresa_pessoa?.nome || "Não informado", // nome da empresa
        colaborador: resposta_pessoa.nome || "Não informado",                     // cargo da pessoa
        status: kit.status || "Não informado",                 // status do kit
        tipo_exame:kit.tipo_exame,
        clinica:resposta_clinica_pessoa.nome_fantasia
      });
    });
}


  console.log("kitsColaboradores:", kitsColaboradores);


    //   const kitsColaboradores = {
    //   '02763134106': [
    //     { id: 'KIT001', data: '15/10/2023', empresa: 'Indústria ABC Ltda', cargo: 'Analista de Segurança', status: 'Concluído' },
    //     { id: 'KIT002', data: '20/09/2023', empresa: 'Indústria ABC Ltda', cargo: 'Analista de Segurança', status: 'Pendente' },
    //     { id: 'KIT003', data: '10/08/2023', empresa: 'Comércio XYZ S/A', cargo: 'Técnico de Segurança', status: 'Concluído' },
    //     { id: 'KIT010', data: '05/07/2023', empresa: 'Indústria ABC Ltda', cargo: 'Analista de Segurança', status: 'Concluído' },
    //     { id: 'KIT011', data: '22/06/2023', empresa: 'Serviços Gama', cargo: 'Analista de Segurança', status: 'Cancelado' }
    //   ],
    //   '99867702115': [
    //     { id: 'KIT004', data: '05/11/2023', empresa: 'Construtora Delta', cargo: 'Engenheiro de Segurança', status: 'Concluído' },
    //     { id: 'KIT005', data: '28/10/2023', empresa: 'Construtora Delta', cargo: 'Engenheiro de Segurança', status: 'Cancelado' },
    //     { id: 'KIT012', data: '15/09/2023', empresa: 'Indústria ABC Ltda', cargo: 'Engenheiro de Segurança', status: 'Concluído' }
    //   ],
    //   '45612378911': [
    //     { id: 'KIT006', data: '12/11/2023', empresa: 'Tecnologia Inova', cargo: 'Engenheiro de Segurança', status: 'Concluído' },
    //     { id: 'KIT007', data: '30/10/2023', empresa: 'Tecnologia Inova', cargo: 'Engenheiro de Segurança', status: 'Concluído' },
    //     { id: 'KIT013', data: '18/09/2023', empresa: 'Comércio XYZ S/A', cargo: 'Engenheiro de Segurança', status: 'Pendente' },
    //     { id: 'KIT014', data: '05/08/2023', empresa: 'Tecnologia Inova', cargo: 'Engenheiro de Segurança', status: 'Concluído' }
    //   ],
    //   '78912345622': [
    //     { id: 'KIT008', data: '08/11/2023', empresa: 'Saúde Total', cargo: 'Enfermeira do Trabalho', status: 'Concluído' },
    //     { id: 'KIT015', data: '22/10/2023', empresa: 'Saúde Total', cargo: 'Enfermeira do Trabalho', status: 'Concluído' },
    //     { id: 'KIT016', data: '14/09/2023', empresa: 'Clínica Vida', cargo: 'Enfermeira do Trabalho', status: 'Concluído' }
    //   ],
    //   '32165498733': [
    //     { id: 'KIT009', data: '03/11/2023', empresa: 'Hospital Esperança', cargo: 'Técnico em Enfermagem', status: 'Pendente' },
    //     { id: 'KIT017', data: '19/10/2023', empresa: 'Hospital Esperança', cargo: 'Técnico em Enfermagem', status: 'Concluído' },
    //     { id: 'KIT018', data: '07/09/2023', empresa: 'Clínica Saúde', cargo: 'Técnico em Enfermagem', status: 'Concluído' }
    //   ]
    // };

      // Se o item for uma string, faz o parse do JSON
      const itemObj = typeof item === 'string' ? JSON.parse(item) : item;
    
      if(situacao !== "gravando")
      {
        if(inputId === "inputEmpresa")
        {
          await grava_ecp_kit("empresa",itemObj.id);

          recebe_codigo_empresa_selecionada = itemObj.id;

          if(window.recebe_acao !== "editar")
          {
            busca_medicos_relacionados_empresa();
          }
        }else if(inputId === "inputClinica")
        {
          await grava_ecp_kit("clinica",itemObj.id);

          recebe_codigo_clinica_selecionada = itemObj.id;

          busca_medicos_relacionados_clinica();

          recebe_nome_clinica_selecionado = itemObj.nome;
        }else if(inputId === "inputColaborador")
        {
          await grava_ecp_kit("colaborador",itemObj.id);
        }else if(inputId === "inputCargo")
        {
          await grava_ecp_kit("cargo",itemObj.id);
        }
      }
      
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
          
          await grava_ecp_kit("empresa",itemObj.id);

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

          await grava_ecp_kit("clinica",itemObj.id);

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

          await grava_ecp_kit("colaborador",itemObj.id);

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
                ${resposta_cargo_pessoa.titulo_cargo ? `
                <div style="display: flex; align-items: center; font-size: 0.875rem; color: #6b7280;">
                  <i class="fas fa-briefcase" style="margin-right: 0.375rem; color: #9ca3af; width: 1rem; text-align: center;"></i>
                  <span>${resposta_cargo_pessoa.titulo_cargo}</span>
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
                    'FINALIZADO': { bg: '#dcfce7', text: '#166534', icon: 'fa-check-circle' },
                    'RASCUNHO': { bg: '#fef3c7', text: '#92400e', icon: 'fa-clock' },
                    'default': { bg: '#fee2e2', text: '#991b1b', icon: 'fa-times-circle' }
                  };
                  
                  const status = kit.status || 'RASCUNHO';
                  const config = statusConfig[status] || statusConfig.default;
                  
                  return `
  <div style="background: white; padding: 1rem; border: 1px solid #e5e7eb; border-radius: 0.5rem; 
              cursor: pointer; transition: all 0.2s ease;"
       onclick="abrirDetalhesKit(${JSON.stringify(kit).replace(/"/g, '&quot;')}, '${itemObj.nome ? itemObj.nome.replace(/'/g, "\\'") : 'Colaborador'}','${resposta_cargo_pessoa.titulo_cargo}',${resposta_pessoa.empresa_id})">
    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
      <div style="flex: 1; min-width: 0;">
        <div style="display: flex; align-items: center; margin-bottom: 0.25rem;">
          <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.5rem; border-radius: 0.25rem; 
                        font-size: 0.75rem; font-weight: 500; background-color: ${config.bg}; color: ${config.text};">
            <i class="fas ${config.icon} mr-1" style="margin-inline: 5px;"></i>
            ${status}
          </span>
        </div>

        <!-- Empresa e Cargo -->
        <div style="font-size: 0.875rem; color: #4b5563; margin-bottom: 0.25rem;">
          <span style="font-weight: 500;">${kit.empresa || 'Sem empresa'}</span>
          ${kit.cargo ? `<span style="margin: 0 0.25rem; color: #d1d5db;">•</span><span>${kit.cargo}</span>` : ''}
        </div>

        <!-- Tipo de Exame -->
        ${kit.tipo_exame ? `
          <div style="font-size: 0.813rem; color: #374151; font-weight: 500; margin-top: 0.15rem;">
            🧾 ${kit.tipo_exame}
          </div>
        ` : ''}

      </div>

      <!-- Data -->
      <div style="display: flex; align-items: center; margin-left: 0.5rem; color: #9ca3af; font-size: 0.875rem; white-space: nowrap;">
        <i class="far fa-calendar-alt mr-1"></i>
        ${new Date(kit.data).toLocaleDateString('pt-BR')}
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

          await grava_ecp_kit("cargo",itemObj.id);

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
      
      // Salva a seleção no estado global (window.ecpState)
      try {
        const display = itemObj.nome || itemObj.titulo || (inputElement ? inputElement.value : '');
        if (inputId === 'inputEmpresa') {
          const det = document.getElementById('detalhesEmpresa');
          window.ecpState.empresa = {
            id: itemObj.id,
            display: display || '',
            detalhesHtml: det ? det.innerHTML : ''
          };
        } else if (inputId === 'inputClinica') {
          const det = document.getElementById('detalhesClinica');
          window.ecpState.clinica = {
            id: itemObj.id,
            display: display || '',
            nome: itemObj.nome || display || '',
            detalhesHtml: det ? det.innerHTML : ''
          };
          // Atualiza imediatamente o cabeçalho da aba Médicos, se presente
          try { applyMedicosHeaderFromEcp(); } catch (e) { /* noop */ }
        } else if (inputId === 'inputColaborador') {
          const det = document.getElementById('detalhesColaborador');
          window.ecpState.colaborador = {
            id: itemObj.id,
            display: display || '',
            detalhesHtml: det ? det.innerHTML : ''
          };
        } else if (inputId === 'inputCargo') {
          const det = document.getElementById('detalhesCargo');
          window.ecpState.cargo = {
            id: itemObj.id,
            display: display || '',
            detalhesHtml: det ? det.innerHTML : ''
          };
        }
      } catch (e) { /* noop */ }
      
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

    function grava_ecp_kit(tipo,valores)
    {
      debugger;

      if(tipo === "empresa")
      {
          if(window.recebe_acao && window.recebe_acao === "editar")
          {
            $.ajax({
              url: "cadastros/processa_geracao_kit.php",
              type: "POST",
              dataType: "json",
              data: {
                processo_geracao_kit: "atualizar_kit",
                valor_empresa: valores,
                valor_id_kit:window.recebe_id_kit
              },
              success: function(retorno_exame_geracao_kit) {
                debugger;

                const mensagemSucesso = `
                      <div id="empresa-gravado" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
                        <div style="display: flex; align-items: center; justify-content: center;">
                          
                          <div>
                            
                            <div>KIT atualizado com sucesso.</div>
                          </div>
                        </div>
                      </div>
                `;

                // Remove mensagem anterior se existir
                $("#empresa-gravado").remove();
                    
                // Adiciona a nova mensagem acima das abas
                $(".tabs-container").before(mensagemSucesso);

                // Configura o fade out após 5 segundos
                setTimeout(function() {
                  $("#empresa-gravado").fadeOut(500, function() {
                  $(this).remove();
                  });
                }, 5000);


                // $("#exame-gravado").html(retorno_exame_geracao_kit);
                // $("#exame-gravado").show();
                // $("#exame-gravado").fadeOut(4000);
                console.log(retorno_exame_geracao_kit);
                // ajaxEmExecucao = false; // libera para nova requisição
              },
              error: function(xhr, status, error) {
                console.log("Falha ao incluir exame: " + error);
                // ajaxEmExecucao = false; // libera para tentar de novo
              },
          });
          }else
          {
              $.ajax({
              url: "cadastros/processa_geracao_kit.php",
              type: "POST",
              dataType: "json",
              data: {
                processo_geracao_kit: "incluir_valores_kit",
                valor_empresa: valores,
              },
              success: function(retorno_exame_geracao_kit) {
                debugger;

                const mensagemSucesso = `
                      <div id="empresa-gravado" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
                        <div style="display: flex; align-items: center; justify-content: center;">
                          
                          <div>
                            
                            <div>KIT atualizado com sucesso.</div>
                          </div>
                        </div>
                      </div>
                `;

                // Remove mensagem anterior se existir
                $("#empresa-gravado").remove();
                    
                // Adiciona a nova mensagem acima das abas
                $(".tabs-container").before(mensagemSucesso);

                // Configura o fade out após 5 segundos
                setTimeout(function() {
                  $("#empresa-gravado").fadeOut(500, function() {
                  $(this).remove();
                  });
                }, 5000);


                // $("#exame-gravado").html(retorno_exame_geracao_kit);
                // $("#exame-gravado").show();
                // $("#exame-gravado").fadeOut(4000);
                console.log(retorno_exame_geracao_kit);
                // ajaxEmExecucao = false; // libera para nova requisição
              },
              error: function(xhr, status, error) {
                console.log("Falha ao incluir exame: " + error);
                // ajaxEmExecucao = false; // libera para tentar de novo
              },
          });
          }
      }else if(tipo === "clinica")
      {
        if(window.recebe_acao && window.recebe_acao === "editar")
        {
          $.ajax({
          url: "cadastros/processa_geracao_kit.php",
          type: "POST",
          dataType: "json",
          data: {
            processo_geracao_kit: "atualizar_kit",
            valor_clinica: valores,
            valor_id_kit:window.recebe_id_kit
          },
          success: function(retorno_exame_geracao_kit) {
            // debugger;

            const mensagemSucesso = `
                  <div id="clinica-gravado" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
                    <div style="display: flex; align-items: center; justify-content: center;">
                      
                      <div>
                        
                        <div>KIT atualizado com sucesso.</div>
                      </div>
                    </div>
                  </div>
            `;

            // Remove mensagem anterior se existir
            $("#clinica-gravado").remove();
                
            // Adiciona a nova mensagem acima das abas
            $(".tabs-container").before(mensagemSucesso);

            // Configura o fade out após 5 segundos
            setTimeout(function() {
              $("#clinica-gravado").fadeOut(500, function() {
              $(this).remove();
              });
            }, 5000);


            // $("#exame-gravado").html(retorno_exame_geracao_kit);
            // $("#exame-gravado").show();
            // $("#exame-gravado").fadeOut(4000);
            console.log(retorno_exame_geracao_kit);
            // ajaxEmExecucao = false; // libera para nova requisição
          },
          error: function(xhr, status, error) {
            console.log("Falha ao incluir exame: " + error);
            // ajaxEmExecucao = false; // libera para tentar de novo
          },
        });
        }else{
          $.ajax({
          url: "cadastros/processa_geracao_kit.php",
          type: "POST",
          dataType: "json",
          data: {
            processo_geracao_kit: "incluir_valores_kit",
            valor_clinica: valores,
          },
          success: function(retorno_exame_geracao_kit) {
            // debugger;

            const mensagemSucesso = `
                  <div id="clinica-gravado" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
                    <div style="display: flex; align-items: center; justify-content: center;">
                      
                      <div>
                        
                        <div>KIT atualizado com sucesso.</div>
                      </div>
                    </div>
                  </div>
            `;

            // Remove mensagem anterior se existir
            $("#clinica-gravado").remove();
                
            // Adiciona a nova mensagem acima das abas
            $(".tabs-container").before(mensagemSucesso);

            // Configura o fade out após 5 segundos
            setTimeout(function() {
              $("#clinica-gravado").fadeOut(500, function() {
              $(this).remove();
              });
            }, 5000);


            // $("#exame-gravado").html(retorno_exame_geracao_kit);
            // $("#exame-gravado").show();
            // $("#exame-gravado").fadeOut(4000);
            console.log(retorno_exame_geracao_kit);
            // ajaxEmExecucao = false; // libera para nova requisição
          },
          error: function(xhr, status, error) {
            console.log("Falha ao incluir exame: " + error);
            // ajaxEmExecucao = false; // libera para tentar de novo
          },
        });
        }
      }else if(tipo === "colaborador")
      {
        if(window.recebe_acao && window.recebe_acao === "editar")
        {
          $.ajax({
          url: "cadastros/processa_geracao_kit.php",
          type: "POST",
          dataType: "json",
          data: {
            processo_geracao_kit: "atualizar_kit",
            valor_colaborador: valores,
            valor_id_kit:window.recebe_id_kit
          },
          success: function(retorno_exame_geracao_kit) {
            // debugger;

            const mensagemSucesso = `
                  <div id="colaborador-gravado" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
                    <div style="display: flex; align-items: center; justify-content: center;">
                      
                      <div>
                        
                        <div>KIT atualizado com sucesso.</div>
                      </div>
                    </div>
                  </div>
            `;

            // Remove mensagem anterior se existir
            $("#colaborador-gravado").remove();
                
            // Adiciona a nova mensagem acima das abas
            $(".tabs-container").before(mensagemSucesso);

            // Configura o fade out após 5 segundos
            setTimeout(function() {
              $("#colaborador-gravado").fadeOut(500, function() {
              $(this).remove();
              });
            }, 5000);


            // $("#exame-gravado").html(retorno_exame_geracao_kit);
            // $("#exame-gravado").show();
            // $("#exame-gravado").fadeOut(4000);
            console.log(retorno_exame_geracao_kit);
            // ajaxEmExecucao = false; // libera para nova requisição
          },
          error: function(xhr, status, error) {
            console.log("Falha ao incluir exame: " + error);
            // ajaxEmExecucao = false; // libera para tentar de novo
          },
        });
        }else
        {
          $.ajax({
          url: "cadastros/processa_geracao_kit.php",
          type: "POST",
          dataType: "json",
          data: {
            processo_geracao_kit: "incluir_valores_kit",
            valor_colaborador: valores,
          },
          success: function(retorno_exame_geracao_kit) {
            // debugger;

            const mensagemSucesso = `
                  <div id="colaborador-gravado" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
                    <div style="display: flex; align-items: center; justify-content: center;">
                      
                      <div>
                        
                        <div>KIT atualizado com sucesso.</div>
                      </div>
                    </div>
                  </div>
            `;

            // Remove mensagem anterior se existir
            $("#colaborador-gravado").remove();
                
            // Adiciona a nova mensagem acima das abas
            $(".tabs-container").before(mensagemSucesso);

            // Configura o fade out após 5 segundos
            setTimeout(function() {
              $("#colaborador-gravado").fadeOut(500, function() {
              $(this).remove();
              });
            }, 5000);


            // $("#exame-gravado").html(retorno_exame_geracao_kit);
            // $("#exame-gravado").show();
            // $("#exame-gravado").fadeOut(4000);
            console.log(retorno_exame_geracao_kit);
            // ajaxEmExecucao = false; // libera para nova requisição
          },
          error: function(xhr, status, error) {
            console.log("Falha ao incluir exame: " + error);
            // ajaxEmExecucao = false; // libera para tentar de novo
          },
        });
        }
      }else if(tipo === "cargo")
      {
        if(window.recebe_acao && window.recebe_acao === "editar")
        {
          $.ajax({
          url: "cadastros/processa_geracao_kit.php",
          type: "POST",
          dataType: "json",
          data: {
            processo_geracao_kit: "atualizar_kit",
            valor_cargo: valores,
            valor_id_kit:window.recebe_id_kit
          },
          success: function(retorno_exame_geracao_kit) {
            // debugger;

            const mensagemSucesso = `
                  <div id="cargo-gravado" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
                    <div style="display: flex; align-items: center; justify-content: center;">
                      
                      <div>
                        
                        <div>KIT atualizado com sucesso.</div>
                      </div>
                    </div>
                  </div>
            `;

            // Remove mensagem anterior se existir
            $("#cargo-gravado").remove();
                
            // Adiciona a nova mensagem acima das abas
            $(".tabs-container").before(mensagemSucesso);

            // Configura o fade out após 5 segundos
            setTimeout(function() {
              $("#cargo-gravado").fadeOut(500, function() {
              $(this).remove();
              });
            }, 5000);


            // $("#exame-gravado").html(retorno_exame_geracao_kit);
            // $("#exame-gravado").show();
            // $("#exame-gravado").fadeOut(4000);
            console.log(retorno_exame_geracao_kit);
            // ajaxEmExecucao = false; // libera para nova requisição
          },
          error: function(xhr, status, error) {
            console.log("Falha ao incluir exame: " + error);
            // ajaxEmExecucao = false; // libera para tentar de novo
          },
        });
        }else{
          $.ajax({
          url: "cadastros/processa_geracao_kit.php",
          type: "POST",
          dataType: "json",
          data: {
            processo_geracao_kit: "incluir_valores_kit",
            valor_cargo: valores,
          },
          success: function(retorno_exame_geracao_kit) {
            // debugger;

            const mensagemSucesso = `
                  <div id="cargo-gravado" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
                    <div style="display: flex; align-items: center; justify-content: center;">
                      
                      <div>
                        
                        <div>KIT atualizado com sucesso.</div>
                      </div>
                    </div>
                  </div>
            `;

            // Remove mensagem anterior se existir
            $("#cargo-gravado").remove();
                
            // Adiciona a nova mensagem acima das abas
            $(".tabs-container").before(mensagemSucesso);

            // Configura o fade out após 5 segundos
            setTimeout(function() {
              $("#cargo-gravado").fadeOut(500, function() {
              $(this).remove();
              });
            }, 5000);


            // $("#exame-gravado").html(retorno_exame_geracao_kit);
            // $("#exame-gravado").show();
            // $("#exame-gravado").fadeOut(4000);
            console.log(retorno_exame_geracao_kit);
            // ajaxEmExecucao = false; // libera para nova requisição
          },
          error: function(xhr, status, error) {
            console.log("Falha ao incluir exame: " + error);
            // ajaxEmExecucao = false; // libera para tentar de novo
          },
        });
        }
      }
    }

    // Função para carregar os estados do IBGE
    async function carregarEstados() {
      // debugger;
      const selectEstado = document.getElementById('novaEmpresaEstado');
      if (!selectEstado) return;
      
      try {
        selectEstado.innerHTML = '<option value="">Carregando estados...</option>';
        
        const response = await fetch('https://servicodados.ibge.gov.br/api/v1/localidades/estados?orderBy=nome');
        const estados = await response.json();
        
        selectEstado.innerHTML = '<option value="">Selecione um estado</option>';
        
        estados.forEach(estado => {
          const option = document.createElement('option');
          option.value = estado.sigla;
          option.textContent = estado.nome;
          option.setAttribute('data-id', estado.id);
          selectEstado.appendChild(option);
        });
        
        // Adiciona o evento de mudança para carregar as cidades
        selectEstado.addEventListener('change', carregarCidades);
        
      } catch (error) {
        console.error('Erro ao carregar estados:', error);
        selectEstado.innerHTML = '<option value="">Erro ao carregar estados</option>';
      }
    }
    
    // Objeto para armazenar os dados das cidades
    const cidadesData = {};
    
    // Função para carregar as cidades do estado selecionado
    async function carregarCidades() {
      // debugger;
      const selectEstado = document.getElementById('novaEmpresaEstado');
      const inputCidade = document.getElementById('novaEmpresaCidade');
      
      if (!selectEstado || !inputCidade) return;
      
      const estadoSelecionado = selectEstado.options[selectEstado.selectedIndex];
      const estadoId = estadoSelecionado.getAttribute('data-id');
      
      if (!estadoId) {
        inputCidade.disabled = true;
        inputCidade.placeholder = 'Selecione um estado primeiro';
        return;
      }
      
      inputCidade.disabled = true;
      inputCidade.placeholder = 'Carregando cidades...';
      inputCidade.value = '';
      
      // Remove o datalist existente, se houver
      const datalistExistente = document.getElementById('cidadesList');
      if (datalistExistente) {
        datalistExistente.remove();
      }
      
      try {
        const response = await fetch(`https://servicodados.ibge.gov.br/api/v1/localidades/estados/${estadoId}/municipios?orderBy=nome`);
        const cidades = await response.json();
        
        // Armazena os dados das cidades no objeto global
        cidadesData[estadoId] = cidades;
        
        // Cria um datalist para o autocomplete
        const datalist = document.createElement('datalist');
        datalist.id = 'cidadesList';
        
        // Adiciona as cidades como opções no datalist
        cidades.forEach(cidade => {
          const option = document.createElement('option');
          option.value = cidade.nome;
          option.setAttribute('data-id', cidade.id);
          datalist.appendChild(option);
        });
        
        // Adiciona o datalist ao documento
        document.body.appendChild(datalist);
        
        // Configura o input para usar o datalist
        inputCidade.setAttribute('list', 'cidadesList');
        inputCidade.disabled = false;
        inputCidade.placeholder = 'Digite o nome da cidade';
        
      } catch (error) {
        console.error('Erro ao carregar cidades:', error);
        inputCidade.placeholder = 'Erro ao carregar cidades';
      }
    }
    
    // Função para abrir a modal de empresa
    function abrirModalEmpresa() {
      const modal = document.getElementById('modalEmpresa');
      if (!modal) return;
      
      // Limpa os campos
      document.getElementById('novaEmpresaNome').value = '';
      document.getElementById('novaEmpresaEndereco').value = '';
      document.getElementById('novaEmpresaCidade').value = '';
      document.getElementById('novaEmpresaCnpj').value = '';
      
      // Carrega os estados
      carregarEstados();
      
      // Mostra a modal
      modal.style.display = 'flex';
    }
    
    // Substitui a função abrirModal original para a modal de empresa
    document.addEventListener('DOMContentLoaded', function() {
      // Encontra o botão que abre a modal de empresa e substitui o evento
      const btnAbrirModalEmpresa = document.querySelector('button[onclick*="abrirModal(\'modalEmpresa\')"]');
      if (btnAbrirModalEmpresa) {
        btnAbrirModalEmpresa.setAttribute('onclick', 'abrirModalEmpresa()');
      }
      
      // Fecha a modal ao clicar fora
      window.addEventListener('click', function(event) {
        const modal = document.getElementById('modalEmpresa');
        if (event.target === modal) {
          fecharModal('modalEmpresa');
        }
      });
    });
    
    function abrirModal(id) {
      // Se for a modal de empresa, usa a função específica
      if (id === 'modalEmpresa') {
        abrirModalEmpresa();
        return;
      }
      
      // Para outras modais, mantém o comportamento original
      const modal = document.getElementById(id);
      if (modal) {
        modal.style.display = 'flex';
      }
    }

    window.recebe_empresa_id_pessoa;
    
    async function abrirDetalhesKit(kit, nomeColaborador,cargo,empresa_id_pessoa) {
      debugger;
      window.recebe_empresa_id_pessoa = empresa_id_pessoa;
      console.log(empresa_id_pessoa);

      // Configurações de status
      // const statusConfig = {
      //   'Concluído': { bg: '#dcfce7', text: '#166534', icon: 'fa-check-circle' },
      //   'Pendente': { bg: '#fef3c7', text: '#92400e', icon: 'fa-clock' },
      //   'default': { bg: '#fee2e2', text: '#991b1b', icon: 'fa-times-circle' }
      // };

      const statusConfig = {
        'FINALIZADO': { bg: '#dcfce7', text: '#166534', icon: 'fa-check-circle' },
        'RASCUNHO': { bg: '#fef3c7', text: '#92400e', icon: 'fa-clock' },
        'default': { bg: '#fee2e2', text: '#991b1b', icon: 'fa-times-circle' }
      };
      const status = kit.status || 'RASCUNHO';
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
            <i class="fas ${statusInfo.icon} mr-1.5" style="margin-inline-end: 5px;"></i>
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
              ${cargo || 'Cargo não informado'}
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
            <div style="font-size: 0.9375rem; color: #111827;">
              ${kit.data ? new Date(kit.data.replace(' ', 'T')).toLocaleDateString('pt-BR') : 'Não informada'}
            </div>
          </div>
        </div>

        <!-- Tipo de Exame -->
        ${kit.tipo_exame ? `
          <div style="margin-top: 16px;">
            <div style="font-size: 0.75rem; color: #6b7280; margin-bottom: 4px;">Tipo de Exame</div>
            <div style="font-size: 0.9375rem; color: #1f2937; font-weight: 500; display: flex; align-items: center; gap: 6px;">
              <i class="fas fa-stethoscope" style="color: #2563eb;"></i>
              ${kit.tipo_exame}
            </div>
          </div>
        ` : ''}
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
          <button onclick="visualizarKit('${kit.id}','${kit.tipo_exame}','${kit.status}','${kit.empresa}','${kit.clinica}','${kit.colaborador}','${kit.data}')" style="
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
            <span style="font-size: 0.75rem; font-weight: 500; color: #4b5563;">Visualizar KIT Completo</span>
          </button>
        </div>

        <!-- Mensagem oculta -->
        <div id="mensagemDuplicado" style="
          display: none;
          margin-top: 14px;
          padding: 10px 14px;
          background-color: #dcfce7;
          color: #166534;
          border-radius: 6px;
          font-size: 0.875rem;
          text-align: center;
          font-weight: 500;
        ">
          ✅ KIT duplicado com sucesso!
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

    function requisitarEmpresaPrincipalPessoa(codigo_empresa) {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: "cadastros/processa_geracao_kit.php",
          method: "GET",
          dataType: "json",
          data: { processo_geracao_kit: "buscar_empresa_principal_pessoa",valor_empresa_id_pessoa: codigo_empresa},
          success: function(resposta) {
            console.log("Empresa retornada:", resposta);
            resolve(resposta);
          },
          error: function(xhr, status, error) {
            reject(error);
          }
        });
      });
    }

    async function duplicarKit(id)
    {
      debugger;

      console.log(kitsColaboradores);

      console.log(id);

      let recebe_dados_kit_especifico = await requisitarDadosKITEspecifico(id);

      let recebe_empresa_principal_pessoa = await requisitarEmpresaPrincipalPessoa(window.recebe_empresa_id_pessoa);

      if(recebe_dados_kit_especifico.empresa_id_principal === window.recebe_empresa_id_pessoa)
      {
        alert("KIT já existente");
      }

      console.log(recebe_dados_kit_especifico);

      console.log(recebe_empresa_principal_pessoa);

      $.ajax({
        url: "cadastros/processa_geracao_kit.php",
        type: "POST",
        dataType: "json",
        data: {
          processo_geracao_kit: "duplicar_kit",
          valores_kit: recebe_dados_kit_especifico,
        },
        success: function(retorno_duplicar_kit)
        {
          debugger;
          console.log(retorno_duplicar_kit);

          if (retorno_duplicar_kit === true) {
            const mensagem = document.getElementById("mensagemDuplicado");
            if (mensagem) {
              mensagem.style.display = "block"; // Mostra a mensagem
              mensagem.textContent = "✅ KIT duplicado com sucesso!";

              // Opcional: esconder automaticamente depois de alguns segundos
              setTimeout(() => {
                mensagem.style.display = "none";
              }, 4000);
            }
          }
        },
        error:function(xhr,status,error)
        {

        },
      });
    }
    
    function editarKit(kitId) {
      debugger;
      // Implementar lógica de edição
      //alert(`Editando kit ${kitId}...`);

      let url = window.location.href;

      // Remove qualquer parâmetro anterior de id e acao (se existirem)
      url = url
        .replace(/(&|\?)id=\d+/g, '')
        .replace(/(&|\?)acao=editar/g, '')
        .replace(/[?&]+$/, ''); // remove ? ou & sobrando no final

      // Adiciona os novos parâmetros corretamente
      if (url.includes("?")) {
        window.location.href = `${url}&id=${kitId}&acao=editar`;
      } else {
        window.location.href = `${url}?id=${kitId}&acao=editar`;
      }

      //fecharModal('modalDetalhesKit');
    }

    function requisitarDadosKITEspecifico(codigo_kit) {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: "cadastros/processa_geracao_kit.php",
          method: "GET",
          dataType: "json",
          data: { processo_geracao_kit: "buscar_kit",valor_id_kit: codigo_kit},
          success: function(resposta) {
            console.log("KIT retornado:", resposta);
            resolve(resposta);
          },
          error: function(xhr, status, error) {
            reject(error);
          }
        });
      });
    }

    function requisitarDadosCargo(codigo_cargo)
    {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: "cadastros/processa_geracao_kit.php",
          method: "GET",
          dataType: "json",
          data: { processo_geracao_kit: "buscar_cargo_kit",valor_id_cargo_kit: codigo_cargo},
          success: function(resposta) {
            console.log("Cargo retornado:", resposta);
            resolve(resposta);
          },
          error: function(xhr, status, error) {
            reject(error);
          }
        });
      });
    }

    function requisitarMedicoCoordenador(codigo_medico_coordenador)
    {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: "cadastros/processa_geracao_kit.php",
          method: "GET",
          dataType: "json",
          data: { processo_geracao_kit: "buscar_medico_coordenador",valor_id_medico_coordenador: codigo_medico_coordenador},
          success: function(resposta) {
            console.log("Médico coordenador retornado:", resposta);
            resolve(resposta);
          },
          error: function(xhr, status, error) {
            reject(error);
          }
        });
      });
    }

    function requisitarMedicoExaminador(codigo_medico_examinador)
    {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: "cadastros/processa_geracao_kit.php",
          method: "GET",
          dataType: "json",
          data: { processo_geracao_kit: "busca_medico_examinador",valor_id_medico_examinador: codigo_medico_examinador},
          success: function(resposta) {
            console.log("Médico examinador retornado:", resposta);
            resolve(resposta);
          },
          error: function(xhr, status, error) {
            reject(error);
          }
        });
      });
    }

    function requisitarProdutos(codigo_kit)
    {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: "cadastros/processa_geracao_kit.php",
          method: "GET",
          dataType: "json",
          data: { processo_geracao_kit: "busca_produtos",valor_id_kit_produtos: codigo_kit},
          success: function(resposta) {
            console.log("Produtos retornado:", resposta);
            resolve(resposta);
          },
          error: function(xhr, status, error) {
            reject(error);
          }
        });
      });
    }
    
    async function visualizarKit(id, tipo_exame, status, empresa, clinica, colaborador, data) {
      debugger;
  try {
    let recebe_kit = await requisitarDadosKITEspecifico(id);
    //let recebe_cargo = await requisitarDadosCargo(resposta_pessoa.id);
    let recebe_medico_coordenador = await requisitarMedicoCoordenador(recebe_kit.medico_coordenador_id);
    let recebe_medico_examinador = await requisitarMedicoExaminador(recebe_kit.medico_clinica_id);
    let recebe_produto_kit = await requisitarProdutos(recebe_kit.id);


    // Define as informações do kit
    const kitInfo = {
      tipoExame: tipo_exame ?? "Não informado",
      status: status ?? "Não informado",
      empresa: empresa ?? "Não informada",
      clinica: clinica ?? "Não informada",
      colaborador: colaborador ?? "Não informado",
      data: data ?? "Não informada",
      cargo: window.resposta_cargo_pessoa.titulo_cargo ?? "Não informada",
      motorista: recebe_kit.motorista ?? "Não informado",
      medico_coordenador: recebe_medico_coordenador.nome ?? "Não informado",
      medico_examinador: recebe_medico_examinador.nome ?? "Não informado",
      riscos:recebe_kit.riscos_selecionados ?? "Não informado",
      treinamentos:recebe_kit.treinamentos_selecionados ?? "Não informado",
      insalubridade:recebe_kit.insalubridade ?? "Não informado",
      porcentagem:recebe_kit.porcentagem ?? "Não informado",
      periculosidade:recebe_kit.periculosidade ?? "Não informado",
      aposentado_especial:recebe_kit.aposentado_especial ?? "Não informado",
      agente_nocivo:recebe_kit.agente_nocivo ?? "Não informado",
      ocorrencia_gfip:recebe_kit.ocorrencia_gfip ?? "Não informado",
      aptidoes:recebe_kit.aptidoes_selecionadas ?? "Não informado",
      exames:recebe_kit.exames_selecionados ?? "Não informado",
      produtos:recebe_produto_kit ?? "Não informado",
      tipo_orcamento:recebe_kit.tipo_orcamento ?? "Não informado",
      tipo_dado_bancario:recebe_kit.tipo_dado_bancario ?? "Não informado",
      dado_bancario_agencia_conta:recebe_kit.dado_bancario_agencia_conta ?? "Não informado",
      dado_bancario_pix:recebe_kit.dado_bancario_pix ?? "Não informado",
      modelos_selecionados:recebe_kit.modelos_selecionados ?? "Não informado"
    };

    // Remove modal anterior se existir
    const existente = document.getElementById("modalDadosRapidosKit");
    if (existente) existente.remove();

    // Travar rolagem da página de fundo
    document.body.style.overflow = "hidden";

    const modal = document.createElement("div");
    modal.id = "modalDadosRapidosKit";
    modal.style.cssText = `
      position: fixed;
      inset: 0;
      background: rgba(0,0,0,0.55);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 9999;
      padding: 20px;
      box-sizing: border-box;
    `;

    modal.innerHTML = `
      <div style="
        background: #fff;
        border-radius: 18px;
        width: 95%;
        max-width: 1400px;
        padding: 50px 60px;
        box-shadow: 0 15px 45px rgba(0,0,0,0.4);
        font-family: Arial, sans-serif;
        max-height: calc(100vh - 60px);
        overflow-y: auto; /* ROLAGEM INTERNA */
        box-sizing: border-box;
      ">
        <h2 style="margin-top:0; text-align:center; font-size:30px; color:#333;">
          Detalhes do Kit ${kitInfo.tipoExame.charAt(0).toUpperCase() + kitInfo.tipoExame.slice(1).toLowerCase()}
        </h2>

        <table style="width:100%; margin-top:30px; border-collapse:collapse; font-size:18px;">
          <tr>
            <td style="font-weight:bold; padding:12px; width:155px;">Tipo do Exame:</td>
            <td>${kitInfo.tipoExame}</td>
            <td style="font-weight:bold; padding:12px; width:16%;">Empresa:</td>
            <td style="width: 30%;">${kitInfo.empresa}</td>
          </tr>
          <tr>
            <td style="font-weight:bold; padding:12px;">Clínica:</td><td>${kitInfo.clinica}</td>
            <td style="font-weight:bold; padding:12px;">Colaborador:</td><td>${kitInfo.colaborador}</td>
          </tr>
          <tr>
            <td style="font-weight:bold; padding:12px;">Cargo:</td><td>${kitInfo.cargo}</td>
            <td style="font-weight:bold; padding:12px;">Motorista:</td><td>${kitInfo.motorista}</td>
          </tr>
          <tr>
            <td style="font-weight:bold; padding:12px;">Médico Coordenador:</td><td>${kitInfo.medico_coordenador}</td>
            <td style="font-weight:bold; padding:12px;">Médico Examinador:</td><td>${kitInfo.medico_examinador}</td>
          </tr>

          <tr>
              <td colspan="4" style="padding:12px; vertical-align:top;">
                <div style="font-weight:bold; margin-bottom:6px;">Riscos:</div>
                ${(() => {
                  let riscos = kitInfo.riscos;

                  // Se vier como string, converte para array
                  if (typeof riscos === 'string') {
                    try {
                      riscos = JSON.parse(riscos);
                    } catch (e) {
                      riscos = [];
                    }
                  }

                  // Se for array, monta tabela
                  if (Array.isArray(riscos) && riscos.length > 0) {
                    let html = `
                      <table style="width:100%; border-collapse:collapse; font-size:13px; margin-top:4px;">
                        <tr style="background:#f2f2f2; font-weight:bold;">
                          <td style="padding:6px; border:1px solid #ccc;">Código</td>
                          <td style="padding:6px; border:1px solid #ccc;">Descrição</td>
                          <td style="padding:6px; border:1px solid #ccc;">Grupo</td>
                        </tr>
                    `;

                    for (const r of riscos) {
                      html += `
                        <tr>
                          <td style="padding:6px; border:1px solid #ccc;">${r.codigo || '-'}</td>
                          <td style="padding:6px; border:1px solid #ccc;">${r.descricao || '-'}</td>
                          <td style="padding:6px; border:1px solid #ccc;">${r.grupo || '-'}</td>
                        </tr>
                      `;
                    }

                    html += '</table>';
                    return html;
                  }

                  return '<span style="color:#888;">Nenhum risco informado.</span>';
                })()}
              </td>
          </tr>

          <tr>
            <td colspan="4" style="padding:12px; vertical-align:top;">
              <div style="font-weight:bold; margin-bottom:6px;">Treinamentos:</div>
              ${(() => {
                let treinamentos = kitInfo.treinamentos; // ou substitua por kitInfo.treinamentos se houver

                // Se vier como string, converte para array
                if (typeof treinamentos === 'string') {
                  try {
                    treinamentos = JSON.parse(treinamentos);
                  } catch (e) {
                    treinamentos = [];
                  }
                }

                // Função para formatar valor em padrão brasileiro
                function formatarValor(valor) {
                  if (valor === null || valor === undefined || valor === '') {
                    return '-';
                  }

                  // Se for número direto
                  if (typeof valor === 'number') {
                    return valor.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                  }

                  // Se for string, tenta converter para número
                  if (typeof valor === 'string') {
                    // Remove possíveis separadores e converte
                    const num = parseFloat(valor.replace(/\./g, '').replace(',', '.'));
                    if (!isNaN(num)) {
                      return num.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                    }
                  }

                  return '-';
                }


                // Se for array, monta tabela
                if (Array.isArray(treinamentos) && treinamentos.length > 0) {
                  let html = `
                    <table style="width:100%; border-collapse:collapse; font-size:13px; margin-top:4px;">
                      <tr style="background:#f2f2f2; font-weight:bold;">
                        <td style="padding:6px; border:1px solid #ccc;">Código</td>
                        <td style="padding:6px; border:1px solid #ccc;">Descrição</td>
                        <td style="padding:6px; border:1px solid #ccc;">Valor</td>
                      </tr>
                  `;

                  for (const t of treinamentos) {
                    html += `
                      <tr>
                        <td style="padding:6px; border:1px solid #ccc;">${t.codigo || '-'}</td>
                        <td style="padding:6px; border:1px solid #ccc;">${t.descricao || '-'}</td>
                        <td style="padding:6px; border:1px solid #ccc;">${formatarValor(t.valor)}</td>
                      </tr>
                    `;
                  }

                  html += '</table>';
                  return html;
                }

                return '<span style="color:#888;">Nenhum treinamento informado.</span>';
              })()}
            </td>
          </tr>

          <tr>
          <td colspan="4" style="padding:12px;">
            <table style="width:100%; border-collapse:collapse; font-size:16px;">
              <tr>
                <td style="font-weight:bold; padding:8px; width:8%; white-space:nowrap;">Insalubridade:</td>
                <td style="width:8%;">${kitInfo.insalubridade}</td>

                <td style="font-weight:bold; padding:8px; width:8%; white-space:nowrap;">Porcentagem:</td>
                <td style="width:8%;">${kitInfo.porcentagem}</td>

                <td style="font-weight:bold; padding:8px; width:8%; white-space:nowrap;">Periculosidade 30%:</td>
                <td style="width:8%;">${kitInfo.periculosidade}</td>

                <td style="font-weight:bold; padding:8px; width:8%; white-space:nowrap;">Aposent. Especial:</td>
                <td style="width:8%;">${kitInfo.aposentado_especial}</td>

                <td style="font-weight:bold; padding:8px; width:8%; white-space:nowrap;">Agente Nocivo:</td>
                <td style="width:8%;">${kitInfo.agente_nocivo}</td>

                <td style="font-weight:bold; padding:8px; width:8%; white-space:nowrap;">Ocorrência GFIP:</td>
                <td style="width:8%;">${kitInfo.ocorrencia_gfip}</td>
              </tr>
            </table>
          </td>
        </tr>

        <tr>
          <td colspan="4" style="padding:12px; vertical-align:top;">
            <div style="font-weight:bold; margin-bottom:6px;">Aptidões:</div>
            ${(() => {
              let aptidoes = kitInfo.aptidoes;

              // Se vier como string, converte para array
              if (typeof aptidoes === 'string') {
                try {
                  aptidoes = JSON.parse(aptidoes);
                } catch (e) {
                  aptidoes = [];
                }
              }

              // Função para formatar valor em padrão brasileiro
              function formatarValor(valor) {
                if (valor === null || valor === undefined || valor === '') {
                  return '-';
                }

                if (typeof valor === 'number') {
                  return valor.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                }

                if (typeof valor === 'string') {
                  const num = parseFloat(valor.replace(/\./g, '').replace(',', '.'));
                  if (!isNaN(num)) {
                    return num.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                  }
                }

                return '-';
              }

              // Se for array, monta tabela
              if (Array.isArray(aptidoes) && aptidoes.length > 0) {
                let html = `
                  <table style="width:100%; border-collapse:collapse; font-size:13px; margin-top:4px;">
                    <tr style="background:#f2f2f2; font-weight:bold;">
                      <td style="padding:6px; border:1px solid #ccc;">Código</td>
                      <td style="padding:6px; border:1px solid #ccc;">Nome</td>
                      <td style="padding:6px; border:1px solid #ccc;">Valor</td>
                    </tr>
                `;

                for (const a of aptidoes) {
                  html += `
                    <tr>
                      <td style="padding:6px; border:1px solid #ccc;">${a.codigo || '-'}</td>
                      <td style="padding:6px; border:1px solid #ccc;">${a.nome || '-'}</td>
                      <td style="padding:6px; border:1px solid #ccc;">${formatarValor(a.valor)}</td>
                    </tr>
                  `;
                }

                html += '</table>';
                return html;
              }

              return '<span style="color:#888;">Nenhuma aptidão informada.</span>';
            })()}
          </td>
        </tr>

        <tr>
          <td colspan="4" style="padding:12px; vertical-align:top;">
            <div style="font-weight:bold; margin-bottom:6px;">Exames:</div>
            ${(() => {
              let exames = kitInfo.exames;

              // Se vier como string, converte para array
              if (typeof exames === 'string') {
                try {
                  exames = JSON.parse(exames);
                } catch (e) {
                  exames = [];
                }
              }

              // Função para formatar valor em padrão brasileiro
              function formatarValor(valor) {
                if (valor === null || valor === undefined || valor === '') {
                  return '-';
                }

                if (typeof valor === 'number') {
                  return valor.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                }

                if (typeof valor === 'string') {
                  const num = parseFloat(valor.replace(/\./g, '').replace(',', '.'));
                  if (!isNaN(num)) {
                    return num.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                  }
                }

                return '-';
              }

              // Se for array, monta tabela
              if (Array.isArray(exames) && exames.length > 0) {
                let html = `
                  <table style="width:100%; border-collapse:collapse; font-size:13px; margin-top:4px;">
                    <tr style="background:#f2f2f2; font-weight:bold;">
                      <td style="padding:6px; border:1px solid #ccc;">Código</td>
                      <td style="padding:6px; border:1px solid #ccc;">Nome</td>
                      <td style="padding:6px; border:1px solid #ccc;">Valor</td>
                    </tr>
                `;

                for (const a of exames) {
                  html += `
                    <tr>
                      <td style="padding:6px; border:1px solid #ccc;">${a.codigo || '-'}</td>
                      <td style="padding:6px; border:1px solid #ccc;">${a.nome || '-'}</td>
                      <td style="padding:6px; border:1px solid #ccc;">${formatarValor(a.valor)}</td>
                    </tr>
                  `;
                }

                html += '</table>';
                return html;
              }

              return '<span style="color:#888;">Nenhuma aptidão informada.</span>';
            })()}
          </td>
        </tr>

        <tr>
          <td colspan="4" style="padding:12px; vertical-align:top;">
            <div style="font-weight:bold; margin-bottom:6px;">Faturamento:</div>
            ${(() => {
              let produtos = kitInfo.produtos;
              let aptidoes = kitInfo.aptidoes;
              let exames = kitInfo.exames;
              let tipo_orcamento = kitInfo.tipo_orcamento ?? "Não informado";
              let tipo_dado_bancario = kitInfo.tipo_dado_bancario ?? "Não informado";
              let dado_bancario_agencia_conta = kitInfo.dado_bancario_agencia_conta ?? "Não informado";
              let dado_bancario_pix = kitInfo.dado_bancario_pix ?? "Não informado";

              // Função para garantir conversão segura para array
              function toArray(dado) {
                if (typeof dado === 'string') {
                  try {
                    return JSON.parse(dado);
                  } catch {
                    return [];
                  }
                }
                return Array.isArray(dado) ? dado : [];
              }

              produtos = toArray(produtos);
              aptidoes = toArray(aptidoes);
              exames = toArray(exames);
              tipo_dado_bancario = toArray(tipo_dado_bancario);

              // Trata tipo de orçamento (pode vir como JSON ou string)
              if (typeof tipo_orcamento === 'string') {
                try {
                  const parsed = JSON.parse(tipo_orcamento);
                  tipo_orcamento = Array.isArray(parsed) ? parsed : [tipo_orcamento];
                } catch {
                  tipo_orcamento = [tipo_orcamento];
                }
              }

              // Função para formatar valor R$
              function formatarValor(valor) {
                if (valor === null || valor === undefined || valor === '') return '-';
                if (typeof valor === 'number') return valor.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                if (typeof valor === 'string') {
                  const num = parseFloat(valor.replace(/\./g, '').replace(',', '.'));
                  if (!isNaN(num)) return num.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                }
                return '-';
              }

              // Soma total geral
              let total = 0;
              function somarValores(arr) {
                for (const item of arr) {
                  const valor = parseFloat((item.valor || '0').toString().replace(/\./g, '').replace(',', '.'));
                  if (!isNaN(valor)) total += valor;
                }
              }

              somarValores(produtos);
              somarValores(aptidoes);
              somarValores(exames);

              // Monta tabela principal
              let html = `
                <table style="width:100%; border-collapse:collapse; font-size:13px; margin-top:4px;">
                  <tr style="background:#f2f2f2; font-weight:bold;">
                    <td style="padding:6px; border:1px solid #ccc;">Itens do Faturamento</td>
                  </tr>
              `;

              // Adiciona seções de itens
              function adicionarLinhas(arr, titulo) {
                if (arr.length > 0) {
                  html += `
                    <tr style="background:#fafafa;">
                      <td style="padding:6px; border:1px solid #ccc; font-weight:bold;">${titulo}</td>
                    </tr>
                  `;
                  for (const item of arr) {
                    html += `
                      <tr>
                        <td style="padding:6px; border:1px solid #ccc;">${item.nome || '-'}</td>
                      </tr>
                    `;
                  }
                }
              }

              adicionarLinhas(produtos, 'Produtos');
              adicionarLinhas(aptidoes, 'Aptidões');
              adicionarLinhas(exames, 'Exames');

              // Linha com tipo de orçamento
              html += `
                <tr style="background:#fafafa;">
                  <td style="padding:6px; border:1px solid #ccc; font-weight:bold;">
                    Tipo de Orçamento: ${tipo_orcamento.join(', ') || 'Não informado'}
                  </td>
                </tr>
              `;

              // Linha com dados bancários
              html += `
                <tr style="background:#fafafa;">
                  <td style="padding:8px; border:1px solid #ccc;">
                    <div style="font-weight:bold; margin-bottom:4px;">Dados Bancários:</div>
                    ${tipo_dado_bancario.includes('agencia-conta') ? `<div>Agência/Conta: ${dado_bancario_agencia_conta}</div>` : ''}
                    ${tipo_dado_bancario.includes('pix') ? `<div>PIX: ${dado_bancario_pix}</div>` : ''}
                    ${tipo_dado_bancario.includes('qrcode') ? `<div>Chave QRCode disponível</div>` : ''}
                    ${tipo_dado_bancario.length === 0 ? '<div>Não informado</div>' : ''}
                  </td>
                </tr>
              `;

              // Linha final com total geral
              html += `
                <tr style="background:#f2f2f2; font-weight:bold;">
                  <td style="padding:6px; border:1px solid #ccc; text-align:right;">
                    Total Geral: ${formatarValor(total)}
                  </td>
                </tr>
              `;

              html += '</table>';
              return html;
            })()}
          </td>
        </tr>


        <tr>
  <td colspan="4" style="padding:12px; vertical-align:top;">
    <div style="font-weight:bold; margin-bottom:6px;">Modelos Selecionados:</div>
    ${(() => {
      let modelos = kitInfo.modelos_selecionados;

      // Se vier como string, converte para array
      if (typeof modelos === 'string') {
        try {
          modelos = JSON.parse(modelos);
        } catch (e) {
          modelos = [];
        }
      }

      // Verifica se há modelos válidos
      if (Array.isArray(modelos) && modelos.length > 0) {
        let html = `
          <table style="width:100%; border-collapse:collapse; font-size:13px; margin-top:4px;">
            <tr style="background:#f2f2f2; font-weight:bold;">
              <td style="padding:6px; border:1px solid #ccc;">Nome do Modelo</td>
            </tr>
        `;

        for (const m of modelos) {
          html += `
            <tr>
              <td style="padding:6px; border:1px solid #ccc;">${m}</td>
            </tr>
          `;
        }

        html += '</table>';
        return html;
      }

      return '<span style="color:#888;">Nenhum modelo selecionado.</span>';
    })()}
  </td>
</tr>


          <tr>
              <td style="font-weight:bold; padding:12px;">Status do Kit:</td>
              <td>${kitInfo.status.charAt(0).toUpperCase() + kitInfo.status.slice(1).toLowerCase()}</td>
              <td style="font-weight:bold; padding:12px;">Data:</td>
              <td>${kitInfo.data ? kitInfo.data.split(' ')[0].split('-').reverse().join('/') : 'Não informada'}</td>
          </tr>
        </table>

        <div style="text-align:center; margin-top:40px;">
          <button onclick="fecharModal('modalDadosRapidosKit')" style="
            background:#fd9203;
            color:white;
            border:none;
            padding:14px 45px;
            border-radius:10px;
            cursor:pointer;
            font-size:18px;
            transition: background 0.3s;
          "
          onmouseover="this.style.background='#e68100'"
          onmouseout="this.style.background='#fd9203'">
            Fechar
          </button>
        </div>
      </div>
    `;

    // Adiciona a modal ao corpo
    document.body.appendChild(modal);

  } catch (error) {
    console.log(`Erro ao visualizar kit: ${error.message}`, "error");
  }
}



    function fecharModal(modalId) {
      const modal = document.getElementById(modalId);
      if (modal) {
        // Adiciona animação de fade out
        modal.style.opacity = '0';
        modal.style.pointerEvents = 'none';
        
        // Remove o modal após a animação
        setTimeout(() => {
          if (modal && modal.parentNode) {
            // Verifica se o modal ainda está no documento antes de remover
            if (document.body.contains(modal)) {
              modal.parentNode.removeChild(modal);
            }
            
            // Reativa a rolagem da página
            document.body.style.overflow = '';
            
            // Retorna o foco para o elemento que abriu o modal, se existir
            const lastFocusedElement = document.activeElement;
            if (lastFocusedElement && lastFocusedElement !== document.body) {
              lastFocusedElement.focus();
            }
          }
        }, 300);
      }
      
      // Retorna o foco para o elemento que abriu o modal
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
      try {
        // debugger;
        // Obtém os valores dos campos do formulário
        const nome = document.getElementById('novaEmpresaNome').value.trim();
        const endereco = document.getElementById('novaEmpresaEndereco').value.trim();
        const cidadeInput = document.getElementById('novaEmpresaCidade');
        const cidade = cidadeInput.value.trim();
        const cnpj = document.getElementById('novaEmpresaCnpj').value.trim();
        
        // Validação dos campos obrigatórios
        if (!nome || !cnpj) {
          alert('Por favor, preencha todos os campos obrigatórios.');
          return;
        }
        
        // Obtém o estado selecionado e seu ID
        const selectEstado = document.getElementById('novaEmpresaEstado');
        if (!selectEstado || !selectEstado.options || selectEstado.selectedIndex < 0) {
          alert('Por favor, selecione um estado.');
          return;
        }
        
        const estadoSelecionado = selectEstado.options[selectEstado.selectedIndex];
        const estadoId = estadoSelecionado.getAttribute('data-id');
        const estadoSigla = estadoSelecionado.value;
        const estadoNome = estadoSelecionado.text;
        
        if (!estadoId) {
          console.error('ID do estado não encontrado');
          alert('Erro ao obter informações do estado. Por favor, tente novamente.');
          return;
        }
        
        // Obtém o ID da cidade selecionada
        let cidadeId = '';
        
        // Busca o ID da cidade no objeto cidadesData
        if (cidadesData[estadoId]) {
          const cidadeEncontrada = cidadesData[estadoId].find(c => c.nome === cidade);
          if (cidadeEncontrada) {
            cidadeId = cidadeEncontrada.id;
          }
        }
        
        // Cria o objeto com os dados da empresa no formato correto
        const novaEmpresaObj = {
          id: 'temp_' + Date.now(), // ID temporário
          nome: nome,
          cnpj: cnpj,
          endereco: endereco,
          complemento: '', // Pode ser preenchido se necessário
          bairro: '',     // Pode ser preenchido se necessário
          cidade: cidade,
          estado: estadoSigla,
          cep: '',        // Pode ser preenchido se necessário
          ativo: true,
          quantidadeVidas: 10,
          quantidadeClinicas: 5
        };
        
        // Garante que ecpData.empresas existe
        if (!ecpData.empresas) {
          ecpData.empresas = [];
        }
        
        // Adiciona a nova empresa ao array de empresas
        ecpData.empresas.push(novaEmpresaObj);
        
        // Fecha a modal e limpa os campos
        fecharModal('modalEmpresa');
        limparCampos(['novaEmpresaNome', 'novaEmpresaEndereco', 'novaEmpresaCidade', 'novaEmpresaCnpj']);
        
        // Envia os dados para o servidor
        $.ajax({
          url: 'cadastros/processa_empresa.php',
          type: 'POST',
          dataType: 'json',
          data: {
            valor_nome_fantasia_empresa: nome,
            valor_endereco_empresa: endereco,
            valor_id_cidade: cidadeId,
            valor_cnpj_empresa: cnpj,
            valor_id_estado: estadoId,
            processo_empresa: 'inserir_empresa'
          },
          success: function(response) {
            // debugger;
            console.log('Resposta do servidor:', response);
            if (response > 0) {
              // Exibe a mensagem de sucesso centralizada acima das abas
              // const mensagemSucesso = `
              //   <div id="empresa-gravada" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
              //     <div style="display: flex; align-items: center; justify-content: center;">
              //       <i class="fas fa-check-circle" style="font-size: 24px; margin-right: 12px; color: #28a745;"></i>
              //       <div>
              //         <strong style="font-size: 16px;">Sucesso!</strong>
              //         <div>Empresa cadastrada com sucesso.</div>
              //       </div>
              //     </div>
              //   </div>
              // `;

              const mensagemSucesso = `
                <div id="empresa-gravada" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
                  <div style="display: flex; align-items: center; justify-content: center;">
                    
                    <div>
                    
                      <div>Empresa cadastrada com sucesso.</div>
                    </div>
                  </div>
                </div>
              `;
              
              // Remove mensagem anterior se existir
              $("#empresa-gravada").remove();
              
              // Adiciona a nova mensagem acima das abas
              $(".tabs-container").before(mensagemSucesso);
              
              // Configura o fade out após 5 segundos
              setTimeout(function() {
                $("#empresa-gravada").fadeOut(500, function() {
                  $(this).remove();
                });
              }, 5000);
              
              // Atualiza o ID temporário para o ID real retornado pelo servidor
              const empresaIndex = ecpData.empresas.findIndex(emp => emp.id === novaEmpresaObj.id);
              if (empresaIndex !== -1) {
                ecpData.empresas[empresaIndex].id = response;
              }

              // Chama a função selecionarECP para atualizar a interface
              selecionarECP('inputEmpresa', 'resultadoEmpresa', novaEmpresaObj, 'nome',"gravando");
            }
          },
          error: function(xhr, status, error) {
            console.error('Erro na requisição AJAX:', status, error);
            alert('Erro ao conectar ao servidor. Por favor, verifique sua conexão e tente novamente.');
          }
        });
      } catch (error) {
        console.error('Erro ao salvar nova empresa:', error);
        alert('Ocorreu um erro inesperado. Por favor, tente novamente.');
      }
    }
    function salvarNovaClinica() {
      // debugger;
      const nova = {
        id:'temp_' + Date.now(),
        nome: document.getElementById('novaClinicaNome').value,
        cnpj: document.getElementById('novaClinicaCnpj').value
      };
      
      ecpData.clinicas.push(nova);

      fecharModal('modalClinica');
      limparCampos(['novaClinicaNome', 'novaClinicaCnpj']);

      // Envia os dados para o servidor
      $.ajax({
        url: 'cadastros/pro_cli_json.php?pg=pro_cli&acao=cadastrar&tipo=insert',
        type: 'POST',
        dataType: 'json',
        data: {
          nome_fantasia: nova.nome,
          cnpj: nova.cnpj,
        },
        success: function(retorno_grava_rapido_clinica) 
        {
          debugger;

          console.log(retorno_grava_rapido_clinica);

          const mensagemSucesso = `
           <div id="clinica-gravada" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
             <div style="display: flex; align-items: center; justify-content: center;">
              <div>
                  <div>Clínica cadastrada com sucesso.</div>
                  </div>
              </div>
             </div>
              `;
              
              // Remove mensagem anterior se existir
              $("#clinica-gravada").remove();
              
              // Adiciona a nova mensagem acima das abas
              $(".tabs-container").before(mensagemSucesso);
              
              // Configura o fade out após 5 segundos
              setTimeout(function() {
                $("#clinica-gravada").fadeOut(500, function() {
                  $(this).remove();
                });
              }, 5000);

            // Atualiza o ID temporário para o ID real retornado pelo servidor
            const clinicaIndex = ecpData.clinicas.findIndex(c => c.id === nova.id);
            if (clinicaIndex !== -1) {
              ecpData.clinicas[clinicaIndex].id = retorno_grava_rapido_clinica;
            }

            selecionarECP('inputClinica', 'resultadoClinica', nova, 'nome',"gravando");
        },
        error:function(xhr,status,error)
        {
          console.log(error);
        },
      });
      
      document.getElementById('inputClinica').value = nova.nome;
      document.getElementById('detalhesClinica').innerHTML = `
        <strong>Clínica:</strong> ${nova.nome}<br>
        <strong>CNPJ:</strong> ${nova.cnpj}`;
    }

    function salvarNovoColaborador() {
      debugger;
      const novo = {
        id:'temp_' + Date.now(),
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

      $.ajax({
        url: "cadastros/processa_pessoa.php",
        type: "POST",
        dataType: "json",
        data: {
          processo_pessoa: "inserir_pessoa",
          valor_nome_pessoa: novo.nome,
          valor_cpf_pessoa: novo.cpf,
        },
        success: function(retorno_pessoa) {
          debugger;
          console.log(retorno_pessoa);
            if (retorno_pessoa > 0) {

              const mensagemSucesso = `
                <div id="pessoa-gravada" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
                  <div style="display: flex; align-items: center; justify-content: center;">
                    
                    <div>
                    
                      <div>Pessoa cadastrada com sucesso.</div>
                    </div>
                  </div>
                </div>
              `;
              
              // Remove mensagem anterior se existir
              $("#pessoa-gravada").remove();
              
              // Adiciona a nova mensagem acima das abas
              $(".tabs-container").before(mensagemSucesso);
              
              // Configura o fade out após 5 segundos
              setTimeout(function() {
                $("#pessoa-gravada").fadeOut(500, function() {
                  $(this).remove();
                });
              }, 5000);

              // Atualiza o ID temporário para o ID real retornado pelo servidor
              const pessoaIndex = ecpData.colaboradores.findIndex(c => c.id === novo.id);
              if (pessoaIndex !== -1) {
                ecpData.colaboradores[pessoaIndex].id = retorno_pessoa;
              }

              console.log("Pessoa cadastrada com sucesso");

              // Chama a função selecionarECP para atualizar a interface
              selecionarECP('inputColaborador', 'resultadoPessoa', novo, 'nome',"gravando");
            }
          },
        error: function(xhr, status, error) {
         console.log("Falha ao inserir empresa:" + error);
        },
      });
    }

    function salvarNovoCargo() {
      debugger;
      const titulo = document.getElementById('novoCargoTitulo').value.trim();
      const cbo = document.getElementById('novoCargoCBO').value.trim();
      const descricao = document.getElementById('novoCargoDescricao').value.trim();
      
      if (!titulo) {
        alert('Por favor, preencha o título do cargo');
        return;
      }
      
      const novo = {
        id:'temp_' + Date.now(),
        titulo: titulo,
        cbo: cbo,
        descricao: descricao
      };
      
      ecpData.cargos.push(novo);
      fecharModal('modalCargo');
      limparCampos(['novoCargoTitulo', 'novoCargoCBO', 'novoCargoDescricao']);
      
      // // Atualiza o input e mostra os detalhes
      // const inputCargo = document.getElementById('inputCargo');
      // if (inputCargo) {
      //   inputCargo.value = titulo;
      //   const detalhes = document.getElementById('detalhesCargo');
      //   if (detalhes) {
      //     detalhes.innerHTML = `
      //       <div class="font-medium">${titulo}</div>
      //       ${cbo ? `<div class="text-sm text-gray-500">CBO: ${cbo}</div>` : ''}
      //       ${descricao ? `<div class="mt-2 text-sm">${descricao}</div>` : ''}
      //     `;
      //   }
      // }

      $.ajax({
        url: "cadastros/processa_cargo.php",
        type: "POST",
        dataType: "json",
        data: {
          processo_cargo: "inserir_cargo",
          valor_titulo_cargo: novo.titulo,
          valor_codigo_cargo: novo.cbo,
          valor_descricao_cargo:novo.descricao,
        },
        success: function(retorno_cargo) {
          debugger;
          console.log(retorno_cargo);
            if (retorno_cargo > 0) {

              const mensagemSucesso = `
                <div id="cargo-gravada" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
                  <div style="display: flex; align-items: center; justify-content: center;">
                    
                    <div>
                    
                      <div>Cargo cadastrado com sucesso.</div>
                    </div>
                  </div>
                </div>
              `;
              
              // Remove mensagem anterior se existir
              $("#cargo-gravada").remove();
              
              // Adiciona a nova mensagem acima das abas
              $(".tabs-container").before(mensagemSucesso);
              
              // Configura o fade out após 5 segundos
              setTimeout(function() {
                $("#cargo-gravada").fadeOut(500, function() {
                  $(this).remove();
                });
              }, 5000);

              // Atualiza o ID temporário para o ID real retornado pelo servidor
              const cargoIndex = ecpData.cargos.findIndex(c => c.id === novo.id);
              if (cargoIndex !== -1) {
                ecpData.cargos[cargoIndex].id = retorno_cargo;
              }

              // Chama a função selecionarECP para atualizar a interface
              selecionarECP('inputCargo', 'resultCargo', novo, 'nome',"gravando");

              console.log("Pessoa cadastrada com sucesso");
            }
          },
        error: function(xhr, status, error) {
         console.log("Falha ao inserir empresa:" + error);
        },
      });
    }

    $.ajax({
        url: "cadastros/processa_geracao_kit.php", // Endpoint da API
        method: "GET",
        dataType: "json",
        data: { processo_geracao_kit: "buscar_kits_empresa" },
        success: async function(resposta_kits) {
          console.log('Clínicas retornadas:', resposta_clinicas);

          // const listaClinicas = resposta_clinicas && resposta_clinicas.data && Array.isArray(resposta_clinicas.data.clinicas)
          //   ? resposta_clinicas.data.clinicas
          //   : [];

          // if (listaClinicas.length > 0) {
          //   for (let c = 0; c < listaClinicas.length; c++) {
          //     clinicas.push({
          //       id:listaClinicas[c].id,
          //       nome: listaClinicas[c].nome_fantasia,
          //       cnpj: listaClinicas[c].cnpj,
          //     });
          //   }

          //   if (typeof ecpData !== 'undefined') {
          //     ecpData.clinicas = clinicas;
          //   }

          //   console.log('Clínicas carregadas:', clinicas);
          // } else {
          //   console.warn('Nenhuma clínica encontrada na resposta.');
          // }
        },
        error:function(xhr,status,error)
        {

        },
      });

    // Dados dos Kits relacionados aos colaboradores
    // const kitsColaboradores = {
    //   '02763134106': [
    //     { id: 'KIT001', data: '15/10/2023', empresa: 'Indústria ABC Ltda', cargo: 'Analista de Segurança', status: 'Concluído' },
    //     { id: 'KIT002', data: '20/09/2023', empresa: 'Indústria ABC Ltda', cargo: 'Analista de Segurança', status: 'Pendente' },
    //     { id: 'KIT003', data: '10/08/2023', empresa: 'Comércio XYZ S/A', cargo: 'Técnico de Segurança', status: 'Concluído' },
    //     { id: 'KIT010', data: '05/07/2023', empresa: 'Indústria ABC Ltda', cargo: 'Analista de Segurança', status: 'Concluído' },
    //     { id: 'KIT011', data: '22/06/2023', empresa: 'Serviços Gama', cargo: 'Analista de Segurança', status: 'Cancelado' }
    //   ],
    //   '99867702115': [
    //     { id: 'KIT004', data: '05/11/2023', empresa: 'Construtora Delta', cargo: 'Engenheiro de Segurança', status: 'Concluído' },
    //     { id: 'KIT005', data: '28/10/2023', empresa: 'Construtora Delta', cargo: 'Engenheiro de Segurança', status: 'Cancelado' },
    //     { id: 'KIT012', data: '15/09/2023', empresa: 'Indústria ABC Ltda', cargo: 'Engenheiro de Segurança', status: 'Concluído' }
    //   ],
    //   '45612378911': [
    //     { id: 'KIT006', data: '12/11/2023', empresa: 'Tecnologia Inova', cargo: 'Engenheiro de Segurança', status: 'Concluído' },
    //     { id: 'KIT007', data: '30/10/2023', empresa: 'Tecnologia Inova', cargo: 'Engenheiro de Segurança', status: 'Concluído' },
    //     { id: 'KIT013', data: '18/09/2023', empresa: 'Comércio XYZ S/A', cargo: 'Engenheiro de Segurança', status: 'Pendente' },
    //     { id: 'KIT014', data: '05/08/2023', empresa: 'Tecnologia Inova', cargo: 'Engenheiro de Segurança', status: 'Concluído' }
    //   ],
    //   '78912345622': [
    //     { id: 'KIT008', data: '08/11/2023', empresa: 'Saúde Total', cargo: 'Enfermeira do Trabalho', status: 'Concluído' },
    //     { id: 'KIT015', data: '22/10/2023', empresa: 'Saúde Total', cargo: 'Enfermeira do Trabalho', status: 'Concluído' },
    //     { id: 'KIT016', data: '14/09/2023', empresa: 'Clínica Vida', cargo: 'Enfermeira do Trabalho', status: 'Concluído' }
    //   ],
    //   '32165498733': [
    //     { id: 'KIT009', data: '03/11/2023', empresa: 'Hospital Esperança', cargo: 'Técnico em Enfermagem', status: 'Pendente' },
    //     { id: 'KIT017', data: '19/10/2023', empresa: 'Hospital Esperança', cargo: 'Técnico em Enfermagem', status: 'Concluído' },
    //     { id: 'KIT018', data: '07/09/2023', empresa: 'Clínica Saúde', cargo: 'Técnico em Enfermagem', status: 'Concluído' }
    //   ]
    // };

    function busca_medicos_relacionados_empresa()
    {
      debugger;
      let medicos_relacionados_empresa = [];
      $.ajax({
          url: "cadastros/processa_medico.php",
          method: "GET",
          dataType: "json",
          data: {
              "processo_medico": "buscar_medicos_associados_empresa",
              valor_codigo_empresa_medicos_associados: recebe_codigo_empresa_selecionada || (window.kit_tipo_exame ? window.kit_tipo_exame.empresa_id : null),
          },
          success: function(resposta_medicos) {
            debugger;
            console.log(resposta_medicos);

            if(resposta_medicos.length > 0)
            {
              for (let mempresa = 0; mempresa < resposta_medicos.length; mempresa++) 
              {
                medicos_relacionados_empresa.push({
                  id:resposta_medicos[mempresa].medico_id,
                  nome:resposta_medicos[mempresa].nome_medico,
                  cpf:resposta_medicos[mempresa].cpf
                }); 
              }

              if(typeof profissionaisMedicinaData !== undefined)
              {
                profissionaisMedicinaData.coordenadores = medicos_relacionados_empresa;
              }
            }

            // if (resposta_medicos.length > 0) {
            //     verifica_vinculacao_medico_empresa = true;
            //     let recebe_tabela_associar_medico_empresa = document.querySelector(
            //     "#tabela-medico-associado-coordenador tbody"
            //     );

            //     $("#tabela-medico-associado-coordenador tbody").html("");

            //     for (let indice = 0; indice < resposta_medicos.length; indice++) {
            //       let recebe_botao_desvincular_medico_empresa;
            //       if (resposta_medicos[indice].id !== "" && resposta_medicos[indice].medico_id !== "") {
            //         recebe_botao_desvincular_medico_empresa = "<td style='text-align:center;'><i class='fas fa-trash' title='Desvincular Médico' id='exclui-medico-ja-associado'" +
            //         " data-codigo-medico-empresa='" + resposta_medicos[indice].id + "' data-codigo-medico='" + resposta_medicos[indice].medico_id + "'></i></td>";
            //       }

            //       recebe_tabela_associar_medico_empresa +=
            //       "<tr>" +
            //         "<td>" + resposta_medicos[indice].nome_medico + "</td>" +
            //           recebe_botao_desvincular_medico_empresa +
            //       "</tr>";
            //     }
            //     $("#tabela-medico-associado-coordenador tbody").append(recebe_tabela_associar_medico_empresa);
            // } else {
            //     verifica_vinculacao_medico_empresa = false;
            //     $("#tabela-medico-associado-coordenador tbody").html("");
            // }

              //  resolve(); // sinaliza que terminou
            },
            error: function(xhr, status, error) {
               console.log("Falha ao buscar médicos:" + error);
               reject(error);
            },
        });
    }

    function busca_medicos_relacionados_clinica()
    {

      let medicos_relacionados_clinica = [];

      $.ajax({
           url: "cadastros/processa_medico.php",
           method: "GET",
           dataType: "json",
           data: {
             "processo_medico": "buscar_medicos_associados_clinica",
              valor_codigo_clinica_medicos_associados: recebe_codigo_clinica_selecionada,
           },
           success: function(resposta_medicos) {
            //  debugger;
             console.log(resposta_medicos);
             if (resposta_medicos.length > 0) {
               for (let mclinica = 0; mclinica < resposta_medicos.length; mclinica++) 
              {
                medicos_relacionados_clinica.push({
                 id:resposta_medicos[mclinica].id,
                 nome:resposta_medicos[mclinica].nome_medico,
                 cpf:resposta_medicos[mclinica].cpf
                });
               }


               if(typeof profissionaisMedicinaData !== undefined)
                {
                  profissionaisMedicinaData.medicos = medicos_relacionados_clinica;
                }



                // let recebe_tabela_associar_medico_clinica = document.querySelector(
                // "#tabela-medico-associado tbody"
                //  );

                //  $("#tabela-medico-associado tbody").html("");

                //  let htmlContent = "";
                //  ids_medicos_associados_existentes = resposta_medicos.map(m => String(m.medico_id));
                //  for (let indice = 0; indice < resposta_medicos.length; indice++) {
                //    htmlContent +=
                //     '<tr>' +
                //       '<td>' + resposta_medicos[indice].nome_medico + '</td>' +
                //       '<td><i class="fas fa-trash" id="exclui-medico-ja-associado"' +
                //       ' data-codigo-medico-clinica="' + resposta_medicos[indice].id + '" data-codigo-medico="' + resposta_medicos[indice].medico_id + '"></i></td>' +
                //     '</tr>';
                //   }
                //   $("#tabela-medico-associado tbody").html(htmlContent);
               } else {
                  // $("#tabela-medico-associado tbody").html("");
               }
                //  resolve(); // sinaliza que terminou
                },
                error: function(xhr, status, error) {
                    console.log("Falha ao buscar médicos:" + error);
                    reject(error);
                },
            });
    }

    // Dados dos Profissionais de Medicina
    // const profissionaisMedicinaData = {
    //   // coordenadores: [
    //   //   { nome: "Carlos Almeida Silva", cpf: "665.985.754-98" }
    //   // ],
    //   // medicos: [
    //   //   { nome: "Marcia Candida", cpf: "558.587.887-98" },
    //   //   { nome: "João Martins", cpf: "789.456.123-77", assinatura: "./assinatura_valida.png" }
    //   // ]
    // };

    const profissionaisMedicinaData = {
      coordenadores: [],
      medicos: []
    };

    const tipoMapeado = {
      coordenador: 'coordenadores',
      medico: 'medicos'
    };

    function mostrarListaProfissionais(tipo) {
      // debugger;
      const inputElement = document.getElementById(`input${capitalize(tipo)}`);
      const input = (inputElement && inputElement.value ? inputElement.value : '').toLowerCase();
      const lista = profissionaisMedicinaData[tipoMapeado[tipo]] || [];
      const container = document.getElementById(`lista${capitalize(tipo)}`);
      if (!container) return;

      if (input.trim() === '') {
        container.style.display = 'none';
        container.innerHTML = '';
        return;
      }

      container.style.display = 'block';
      container.innerHTML = '';

      lista
        .filter(p => ((p && (p.nome || p.nome_medico)) ? (p.nome || p.nome_medico) : '').toLowerCase().includes(input))
        .forEach(p => {
          const div = document.createElement('div');
          div.className = 'ecp-result-item';

          // Normaliza campos possíveis vindos do backend
          const nome = p && (p.nome || p.nome_medico) ? (p.nome || p.nome_medico) : '';
          const cpf = p && (p.cpf || p.cpf_medico) ? (p.cpf || p.cpf_medico) : '';

          // Para 'medico', p.id tende a ser da relação medico_clinica e p.medico_id o id do médico
          // Para 'coordenador', p.id tende a ser o id do médico
          if (tipo === 'medico') {
            if (p && p.id != null) div.dataset.medicoClinicaId = p.id; // relação
            if (p && p.medico_id != null) div.dataset.medicoId = p.medico_id; // id do médico
          } else if (tipo === 'coordenador') {
            if (p && p.id != null) div.dataset.medicoId = p.id; // id do médico
          }

          // Sempre prover nomes esperados pelo handler
          if (nome) {
            div.dataset.nomeMedico = nome;
            div.dataset.nome = nome;
          }
          if (cpf) div.dataset.cpf = cpf;

          div.innerHTML = `
            <div class="font-medium">${nome}</div>
            <div class="text-sm text-gray-500">CPF: ${cpf}</div>
          `;
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

    let recebe_codigo_medico_coordenador_apos_gravar_rapido;

    async function confirmarAdicaoProfissional(tipo) {
      debugger;
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
        id:'temp_' + Date.now(),
        nome, 
        cpf: cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4'),
        ...(tipo === 'medico' && crm && { crm })
      };

      profissionaisMedicinaData[tipoMapeado[tipo]].push(novo);

      if(tipo === "coordenador")
      {
        // Aguarda o retorno do ID do AJAX
        let idretornadomedicocoordenador = await gravar_medico_coordenador(novo);

        // Chama a função de gravar kit passando o ID real
        grava_medico_coordenador_kit(idretornadomedicocoordenador);
      }else{
        let idretornadomedicoclinica = await gravar_medico(novo);

        grava_medico_clinica_kit(idretornadomedicoclinica);
      }
      
      renderizarPessoa(tipo, novo, document.getElementById(`resultado${capitalize(tipo)}`));
      fecharModal(`modal${capitalize(tipo)}`);
      
      // Limpar campos
      nomeInput.value = '';
      cpfInput.value = '';
      if (crmInput) crmInput.value = '';
    }


    function gravar_medico_coordenador(valores) {
      debugger;
      return new Promise((resolve, reject) => {
          $.ajax({
              url: "cadastros/processa_medico.php",
              type: "POST",
              dataType: "json",
              data: {
                  processo_medico: "inserir_medico",
                  valor_nome_medico: valores.nome,
                  valor_cpf_medico: valores.cpf,
              },
              success: function (retorno_medico) {
                  // debugger;
                  console.log(retorno_medico);

                  if (retorno_medico) {
                      const mensagemSucesso = `
                        <div id="medico-coordenador-gravado" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
                          <div style="display: flex; align-items: center; justify-content: center;">
                            <div>
                              <div>Médico coordenador cadastrado com sucesso.</div>
                            </div>
                          </div>
                        </div>
                      `;

                      // Remove mensagem anterior se existir
                      $("#medico-coordenador-gravado").remove();

                      // Adiciona a nova mensagem acima das abas
                      $(".tabs-container").before(mensagemSucesso);

                      // Configura o fade out após 5 segundos
                      setTimeout(function () {
                          $("#medico-coordenador-gravado").fadeOut(500, function () {
                              $(this).remove();
                          });
                      }, 5000);

                      // Atualiza o ID temporário para o ID real retornado pelo servidor
                      const medicoCoordenadorIndex = profissionaisMedicinaData.coordenadores.findIndex(
                          mc => mc.id === valores.id
                      );

                      if (medicoCoordenadorIndex !== -1) {
                          profissionaisMedicinaData.coordenadores[medicoCoordenadorIndex].id = retorno_medico; // usa retorno do servidor
                      }
                      
                      resolve(retorno_medico); // <-- resolve a Promise com o ID
                  } else {
                      reject("Erro: retorno inválido do servidor");
                  }
              },
              error: function (xhr, status, error) {
                  console.log("Falha ao inserir empresa:" + error);
                  reject(error); // <-- rejeita a Promise em caso de erro
              },
          });
      });
    }


    function gravar_medico(valores)
    {
      return new Promise((resolve, reject) => {

        $.ajax({
              url: "cadastros/processa_medico.php",
              type: "POST",
              dataType: "json",
              data: {
                  processo_medico: "inserir_medico",
                  valor_nome_medico: valores.nome,
                  valor_cpf_medico: valores.cpf,
                  valor_crm_medico:valores.crm
                },
              success: function(retorno_medico) {
                  // debugger;

                  console.log(retorno_medico);

                if (retorno_medico) {

                  const mensagemSucesso = `
                  <div id="medico-gravado" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
                    <div style="display: flex; align-items: center; justify-content: center;">
                      
                      <div>
                      
                        <div>Médico cadastrado com sucesso.</div>
                      </div>
                    </div>
                  </div>
                `;
                  console.log("Médico cadastrada com sucesso");

                // Remove mensagem anterior se existir
                $("#medico-gravado").remove();
              
                // Adiciona a nova mensagem acima das abas
                $(".tabs-container").before(mensagemSucesso);
              
                // Configura o fade out após 5 segundos
                setTimeout(function() {
                  $("#medico-gravado").fadeOut(500, function() {
                    $(this).remove();
                  });
                }, 5000);

                // Atualiza o ID temporário para o ID real retornado pelo servidor
                const medicoIndex = profissionaisMedicinaData.medicos.findIndex(m => m.id === valores.id);
                if (medicoIndex !== -1) {
                  profissionaisMedicinaData.medicos[medicoIndex].id = retorno_medico;
                }
                  resolve(retorno_medico); // <-- resolve a Promise com o ID
                }
              },
              error: function(xhr, status, error) {
                console.log("Falha ao inserir empresa:" + error);
                reject(error); // <-- rejeita a Promise em caso de erro
              },
          });
        });
      }



    function renderizarPessoa(tipo, pessoa, area) {
      if(tipo === "coordenador")
      {
        grava_medico_coordenador_kit(pessoa);
      }else{

      }

      area.className = 'ecp-details';
      area.style.display = 'block';
      // Título com prefixo 'Dr.' apenas se ainda não houver
      let titulo = pessoa.nome || '';
      if (tipo === 'medico') {
        if (!/^Dr\.?\s/i.test(titulo)) {
          titulo = `Dr. ${titulo}`;
        }
      }
      // Sempre mostrar CPF no cartão detalhado do médico (a área com assinatura)
      const linhaCpf = `CPF: ${pessoa.cpf}${pessoa.crm ? ` | CRM: ${pessoa.crm}` : ''}`;
      area.innerHTML = `
        <div class="font-medium">${titulo}</div>
        <div class="text-sm text-gray-500">${linhaCpf}</div>
        ${tipo === 'medico' ? renderAssinatura(pessoa) : ''}
        <button class="ecp-button-cancel mt-2" type="button" onclick="removerPessoa('assinatura-${pessoa.cpf}')">✖ Remover</button>
      `;
    }

    function grava_medico_coordenador_kit(valores)
    {
        debugger;

        if(window.recebe_acao && window.recebe_acao === "editar")
        {
          let recebe_id;
          if(valores.id !== undefined)
          {
            recebe_id = valores.id;
          }else{
            recebe_id = valores;
          }

          console.log(valores);
          $.ajax({
            url: "cadastros/processa_geracao_kit.php",
            type: "POST",
            dataType: "json",
            data: {
              processo_geracao_kit: "atualizar_kit",
              valor_medico_coordenador_id: recebe_id,
              valor_id_kit:window.recebe_id_kit
            },
            success: function(retorno_exame_geracao_kit) {
              // debugger;

              const mensagemSucesso = `
                    <div id="medico-coordenador-gravado" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
                      <div style="display: flex; align-items: center; justify-content: center;">
                        
                        <div>
                          
                          <div>KIT atualizado com sucesso.</div>
                        </div>
                      </div>
                    </div>
              `;

              // Remove mensagem anterior se existir
              $("#medico-coordenador-gravado").remove();
                  
              // Adiciona a nova mensagem acima das abas
              $(".tabs-container").before(mensagemSucesso);

              // Configura o fade out após 5 segundos
              setTimeout(function() {
                $("#medico-coordenador-gravado").fadeOut(500, function() {
                $(this).remove();
                });
              }, 5000);


              // $("#exame-gravado").html(retorno_exame_geracao_kit);
              // $("#exame-gravado").show();
              // $("#exame-gravado").fadeOut(4000);
              console.log(retorno_exame_geracao_kit);
              // ajaxEmExecucao = false; // libera para nova requisição
            },
            error: function(xhr, status, error) {
              console.log("Falha ao incluir exame: " + error);
              // ajaxEmExecucao = false; // libera para tentar de novo
            },
          });
        }else{
          let recebe_id;
          if(valores.id !== undefined)
          {
            recebe_id = valores.id;
          }else{
            recebe_id = valores;
          }

          console.log(valores);
          $.ajax({
            url: "cadastros/processa_geracao_kit.php",
            type: "POST",
            dataType: "json",
            data: {
              processo_geracao_kit: "incluir_valores_kit",
              valor_medico_coordenador_id: recebe_id,
            },
            success: function(retorno_exame_geracao_kit) {
              // debugger;

              const mensagemSucesso = `
                    <div id="medico-coordenador-gravado" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
                      <div style="display: flex; align-items: center; justify-content: center;">
                        
                        <div>
                          
                          <div>KIT atualizado com sucesso.</div>
                        </div>
                      </div>
                    </div>
              `;

              // Remove mensagem anterior se existir
              $("#medico-coordenador-gravado").remove();
                  
              // Adiciona a nova mensagem acima das abas
              $(".tabs-container").before(mensagemSucesso);

              // Configura o fade out após 5 segundos
              setTimeout(function() {
                $("#medico-coordenador-gravado").fadeOut(500, function() {
                $(this).remove();
                });
              }, 5000);


              // $("#exame-gravado").html(retorno_exame_geracao_kit);
              // $("#exame-gravado").show();
              // $("#exame-gravado").fadeOut(4000);
              console.log(retorno_exame_geracao_kit);
              // ajaxEmExecucao = false; // libera para nova requisição
            },
            error: function(xhr, status, error) {
              console.log("Falha ao incluir exame: " + error);
              // ajaxEmExecucao = false; // libera para tentar de novo
            },
          });
        }
    }

    function grava_medico_clinica_kit(valores)
    {
        debugger;

        if(window.recebe_acao && window.recebe_acao === "editar")
        {
          console.log(valores);

          let recebe_id;
          if(valores.id !== undefined)
          {
            recebe_id = valores.id;
          }else{
            recebe_id = valores;
          }
          $.ajax({
            url: "cadastros/processa_geracao_kit.php",
            type: "POST",
            dataType: "json",
            data: {
              processo_geracao_kit: "atualizar_kit",
              valor_medico_clinica_id: recebe_id,
              valor_id_kit:window.recebe_id_kit
            },
            success: function(retorno_exame_geracao_kit) {
              debugger;

              const mensagemSucesso = `
                    <div id="medico-clinica-gravado" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
                      <div style="display: flex; align-items: center; justify-content: center;">
                        
                        <div>
                          
                          <div>KIT atualizado com sucesso.</div>
                        </div>
                      </div>
                    </div>
              `;

              // Remove mensagem anterior se existir
              $("#medico-clinica-gravado").remove();
                  
              // Adiciona a nova mensagem acima das abas
              $(".tabs-container").before(mensagemSucesso);

              // Configura o fade out após 5 segundos
              setTimeout(function() {
                $("#medico-clinica-gravado").fadeOut(500, function() {
                $(this).remove();
                });
              }, 5000);


              // $("#exame-gravado").html(retorno_exame_geracao_kit);
              // $("#exame-gravado").show();
              // $("#exame-gravado").fadeOut(4000);
              console.log(retorno_exame_geracao_kit);
              // ajaxEmExecucao = false; // libera para nova requisição
            },
            error: function(xhr, status, error) {
              console.log("Falha ao incluir exame: " + error);
              // ajaxEmExecucao = false; // libera para tentar de novo
            },
          });
        }else
        {
          console.log(valores);

          let recebe_id;
          if(valores.id !== undefined)
          {
            recebe_id = valores.id;
          }else{
            recebe_id = valores;
          }
          $.ajax({
            url: "cadastros/processa_geracao_kit.php",
            type: "POST",
            dataType: "json",
            data: {
              processo_geracao_kit: "incluir_valores_kit",
              valor_medico_clinica_id: recebe_id,
            },
            success: function(retorno_exame_geracao_kit) {
              debugger;

              const mensagemSucesso = `
                    <div id="medico-clinica-gravado" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
                      <div style="display: flex; align-items: center; justify-content: center;">
                        
                        <div>
                          
                          <div>KIT atualizado com sucesso.</div>
                        </div>
                      </div>
                    </div>
              `;

              // Remove mensagem anterior se existir
              $("#medico-clinica-gravado").remove();
                  
              // Adiciona a nova mensagem acima das abas
              $(".tabs-container").before(mensagemSucesso);

              // Configura o fade out após 5 segundos
              setTimeout(function() {
                $("#medico-clinica-gravado").fadeOut(500, function() {
                $(this).remove();
                });
              }, 5000);


              // $("#exame-gravado").html(retorno_exame_geracao_kit);
              // $("#exame-gravado").show();
              // $("#exame-gravado").fadeOut(4000);
              console.log(retorno_exame_geracao_kit);
              // ajaxEmExecucao = false; // libera para nova requisição
            },
            error: function(xhr, status, error) {
              console.log("Falha ao incluir exame: " + error);
              // ajaxEmExecucao = false; // libera para tentar de novo
            },
          });
        }
    }

    function renderAssinatura(pessoa) {
      debugger;

      let html = `
        <div class="mt-2">
          <label class="ecp-label">Enviar Assinatura</label>
          <input 
            type="file" 
            id="assinatura-${pessoa.cpf}" 
            class="ecp-input" 
            accept="image/*" 
            onchange="handleAssinaturaUpload(this, '${pessoa.cpf}')"
          >
          <div class="ecp-questionario-note">
            Formatos aceitos: JPG, PNG, GIF. Tamanho máximo: 2MB
          </div>
        </div>
        <div class="mt-2">
            <label class="ecp-label">Assinatura atual</label>
              <img src="${pessoa.assinatura}" alt="Assinatura" 
              style="max-width: 200px; max-height: 100px; border: 1px solid #ddd; border-radius: 4px;">
          </div>
        <div id="preview-assinatura-${pessoa.cpf}" class="mt-2"></div>
      `;

      if (pessoa.assinatura) {
        return html;
      }
      return `
        <div class="mt-2">
          <label class="ecp-label">Enviar Assinatura</label>
          <input 
            type="file" 
            id="assinatura-${pessoa.cpf}" 
            class="ecp-input" 
            accept="image/*" 
            onchange="handleAssinaturaUpload(this, '${pessoa.id}','${pessoa.cpf}')"
          >
          <div class="ecp-questionario-note">Formatos aceitos: JPG, PNG, GIF. Tamanho máximo: 2MB</div>
        </div>
      `;
    }
    
    // Variável global para armazenar o nome da última assinatura selecionada
    let assinaturaSelecionadaNome = null;

    async function handleAssinaturaUpload(input, id,cpf) {
      debugger;
      const file = input.files[0];
      if (!file) return;

      // Guardar o nome do arquivo em variável global
      assinaturaSelecionadaNome = file.name;

      // Validar o tipo do arquivo
      const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
      if (!validTypes.includes(file.type)) {
        alert('Por favor, selecione um arquivo de imagem válido (JPG, PNG ou GIF)');
        input.value = '';
        assinaturaSelecionadaNome = null; // limpa a variável caso inválido
        return;
      }

      // Validar o tamanho do arquivo (2MB)
      if (file.size > 2 * 1024 * 1024) {
        alert('O arquivo é muito grande. O tamanho máximo permitido é 2MB.');
        input.value = '';
        assinaturaSelecionadaNome = null; // limpa a variável caso inválido
        return;
      }

      await grava_assinatura_medico(file,id);

      // Criar uma URL para visualização da imagem
      const reader = new FileReader();
      reader.onload = function(e) {
        // Encontrar o médico correspondente e atualizar a assinatura
        const medico = profissionaisMedicinaData.medicos.find(m => m.cpf === cpf);
        if (medico) {
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

    async function grava_assinatura_medico(arquivo, id_medico) {
      debugger;

      var dados_assinatura_medico = new FormData();
      dados_assinatura_medico.append("processo_medico", "alterar_medico");
      dados_assinatura_medico.append("valor_arquivo_assinatura_medico", arquivo); // se "arquivo" for File ou Blob
      dados_assinatura_medico.append("valor_id_medico", id_medico);
      dados_assinatura_medico.append("valor_acao_alteracao_medico", "selecao_medico_examinador_kit");

      return new Promise((resolve, reject) => {
        $.ajax({
          type: "POST",
          enctype: "multipart/form-data",
          dataType: "json",
          // url: "http://localhost/software-medicos/api/ProtocolosAPI.php",
          url: "cadastros/processa_medico.php",
          cache: false,
          processData: false,
          contentType: false,
          data: dados_assinatura_medico,
          success: function(retorno_grava_medico_assinatura) {
            debugger;

            const mensagemSucesso = `
              <div id="medico-assinatura-gravado" class="alert alert-success" 
                  style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
                <div style="display: flex; align-items: center; justify-content: center;">
                  <div>
                    <div>Assinatura gravada com sucesso.</div>
                  </div>
                </div>
              </div>
            `;

            // Remove mensagem anterior se existir
            $("#medico-assinatura-gravado").remove();

            // Adiciona a nova mensagem acima das abas
            $(".tabs-container").before(mensagemSucesso);

            // Configura o fade out após 5 segundos
            setTimeout(function() {
              $("#medico-assinatura-gravado").fadeOut(500, function() {
                $(this).remove();
              });
            }, 5000);

            resolve(retorno_grava_medico_assinatura);
          },
          error: function(xhr, status, error) {
            console.log("Falha ao incluir exame: " + error);
            reject(error);
          },
        });
      });
    }

    // function removerPessoa(id) {
    //   debugger;
    //   const inputFile = document.getElementById(id);
    //   if (inputFile) {
    //       inputFile.value = '';
    //   }
    // }

    function removerPessoa(id) {
      debugger;
      // Limpa o input file
      // const inputFile = document.getElementById(id);
      // if (inputFile) {
      //     inputFile.value = '';
      // }

    // Encontra e remove a prévia da assinatura
    // O ID do input é algo como "assinatura-123.456.789-00"
    // const cpf = id.replace('assinatura-', '');
    // const previewImg = document.querySelector(`img[alt="Assinatura"]`);
    // if (previewImg) {
    //     previewImg.src = ''; // Remove a imagem
    //     previewImg.style.display = 'none'; // Esconde o elemento
    // }
    }

    // function removerPessoa(id) {
    //   debugger;
    //   // document.getElementById(id).innerHTML = '';

    //   const el = document.getElementById(id);
    //   el.value = '';
    //   // if (!el) return;

    //   // Se o elemento for um input[type=file], apenas limpa o arquivo selecionado
    //   // if (el.tagName === 'INPUT' && el.type === 'file') {
    //   //   el.value = '';
    //   //   return;
    //   // }

    //   // Caso contrário, procura um input[type=file] dentro do elemento e limpa
    //   // const fileInput = el.querySelector ? el.querySelector('input[type="file"]') : null;
    //   // if (fileInput) {
    //   //   fileInput.value = '';
    //   // }
    // }

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
        debugger;
        if(recebe_nome_clinica_selecionado !== "")
        {
          $("#exibi-clinica-selecionada").html(recebe_nome_clinica_selecionado);
        }
        coordenadorInput.addEventListener('input', () => mostrarListaProfissionais('coordenador'));
      }
      if (medicoInput) {
        medicoInput.addEventListener('input', () => mostrarListaProfissionais('medico'));
      }
    };

    let recebe_select_laudo_selecionado;
    let recebe_valor_select_laudo_selecionado;
    // Função para inicializar os dropdowns do laudo
    async function initializeLaudoDropdowns() {
      // debugger;
      // Remove event listeners antigos para evitar duplicação
      const dropdowns = document.querySelectorAll('.laudo-dropdown');
      
      dropdowns.forEach(dropdown => {
        // debugger;
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
          option.addEventListener('click', async (e) => {
            e.stopPropagation();
            debugger;
            recebe_valor_select_laudo_selecionado = option.textContent.trim();
            const selectedText = newDropdown.querySelector('.selected-text');
            
            // Obtém o label do dropdown atual
            recebe_select_laudo_selecionado = newDropdown.previousElementSibling ? 
                                 newDropdown.previousElementSibling.textContent.trim() : 'Dropdown sem label';
            
            // Loga qual dropdown foi selecionado e seu valor
            console.log(`Dropdown selecionado: ${recebe_select_laudo_selecionado} | Valor selecionado: ${recebe_valor_select_laudo_selecionado}`);

            try {
              await grava_insalubridade_laudo();
            } catch (error) {
              console.error('Erro ao gravar insalubridade:', error);
            }
            
            if (selectedText) {
              selectedText.textContent = recebe_valor_select_laudo_selecionado;
            } else {
              const newSelected = document.createElement('span');
              newSelected.className = 'selected-text';
              newSelected.textContent = recebe_valor_select_laudo_selecionado;
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
            // Salva estado após atualização
            try { saveLaudoState(); } catch(_) {}
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
      
      // Salva o estado dos dropdowns no window.laudoState
      const saveLaudoState = () => {
        const dropdowns = document.querySelectorAll('.laudo-dropdown');
        const laudoState = {};
        dropdowns.forEach(dropdown => {
          const selectedText = dropdown.querySelector('.selected-text');
          if (selectedText) {
            laudoState[dropdown.previousElementSibling.textContent.trim()] = selectedText.textContent.trim();
          }
        });
        window.laudoState = laudoState;
      };

      // Aplica o estado dos dropdowns do window.laudoState
      const applyLaudoState = () => {
        const dropdowns = document.querySelectorAll('.laudo-dropdown');
        if (window.laudoState) {
          dropdowns.forEach(dropdown => {
            const label = dropdown.previousElementSibling.textContent.trim();
            const selectedText = dropdown.querySelector('.selected-text');
            if (window.laudoState[label]) {
              selectedText.textContent = window.laudoState[label];
            }
          });
        }
      };

      // Aplica o estado salvo antes de atualizar o resumo
      applyLaudoState();
      atualizarResumoLaudo();
    }

    function grava_insalubridade_laudo()
    {
      debugger;
      if(window.recebe_acao && window.recebe_acao === "editar")
      {
        return new Promise((resolve, reject) => {
          $.ajax({
            url: "cadastros/processa_geracao_kit.php",
            method: "POST",
            dataType: "json",
            data: {
              processo_geracao_kit: "atualizar_kit",
              valor_laudo_selecionado:recebe_select_laudo_selecionado.toLowerCase(),
              valor_selecionado:recebe_valor_select_laudo_selecionado.toLowerCase(),
              valor_id_kit:window.recebe_id_kit
            },
            success: function(resposta) {
              debugger;

              const mensagemSucesso = `
                        <div id="laudo-gravado" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
                          <div style="display: flex; align-items: center; justify-content: center;">
                            <div>
                              <div>KIT atualizado com sucesso.</div>
                            </div>
                          </div>
                        </div>
                      `;

                      // Remove mensagem anterior se existir
                      $("#laudo-gravado").remove();

                      // Adiciona a nova mensagem acima das abas
                      $(".tabs-container").before(mensagemSucesso);

                      // Configura o fade out após 5 segundos
                      setTimeout(function () {
                          $("#laudo-gravado").fadeOut(500, function () {
                              $(this).remove();
                          });
                      }, 5000);

              console.log(resposta);
              resolve(resposta);
            },
            error:function(xhr,status,error)
            {
              reject(error);
            },
          });
        });
      }else{
        return new Promise((resolve, reject) => {
          $.ajax({
            url: "cadastros/processa_geracao_kit.php",
            method: "POST",
            dataType: "json",
            data: {
              processo_geracao_kit: "incluir_valores_kit",
              valor_laudo_selecionado:recebe_select_laudo_selecionado.toLowerCase(),
              valor_selecionado:recebe_valor_select_laudo_selecionado.toLowerCase()
            },
            success: function(resposta) {
              debugger;

              const mensagemSucesso = `
                        <div id="laudo-gravado" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
                          <div style="display: flex; align-items: center; justify-content: center;">
                            <div>
                              <div>KIT atualizado com sucesso.</div>
                            </div>
                          </div>
                        </div>
                      `;

                      // Remove mensagem anterior se existir
                      $("#laudo-gravado").remove();

                      // Adiciona a nova mensagem acima das abas
                      $(".tabs-container").before(mensagemSucesso);

                      // Configura o fade out após 5 segundos
                      setTimeout(function () {
                          $("#laudo-gravado").fadeOut(500, function () {
                              $(this).remove();
                          });
                      }, 5000);

              console.log(resposta);
              resolve(resposta);
            },
            error:function(xhr,status,error)
            {
              reject(error);
            },
          });
        });
      }
      
    }

    // Função para verificar se a aba de riscos está visível e inicializar componentes
    function checkAndInitializeRiscosTab() {
      // debugger;
      const riscosTab = document.querySelector('.tab[data-step="3"]');
      if (riscosTab && riscosTab.classList.contains('active')) {
        buscar_riscos();
        // Pequeno atraso para garantir que o conteúdo foi renderizado
        setTimeout(initializeLaudoDropdowns, 100);
        
        // Sempre recarrega a lista de treinamentos ao entrar na aba de Riscos
        try {
          if (typeof buscar_treinamentos === 'function') {
            buscar_treinamentos();
          }
        } catch (e) {
          console.warn('buscar_treinamentos não disponível:', e);
        }

        // Inicializa/atualiza os treinamentos sempre que a aba estiver ativa
        const initTreinamentos = () => {
          // Verifica se o container de treinamentos está no DOM
          const containerTreinamentos = document.getElementById('secao-treinamentos');
          if (!containerTreinamentos) {
            console.log('Aguardando container de treinamentos ser carregado...');
            setTimeout(initTreinamentos, 100);
            return;
          }
          
          try {
            const treinamentos = (typeof gerenciarTreinamentos === 'function') ? gerenciarTreinamentos() : null;
            // Se existir um método de refresh, use-o sempre
            if (treinamentos && typeof treinamentos.refresh === 'function') {
              treinamentos.refresh();
              console.log('Treinamentos atualizados via refresh');
            } else if (treinamentos && typeof treinamentos.init === 'function') {
              // Caso contrário, inicializa sem controle booleano
              treinamentos.init();
              console.log('Treinamentos inicializados');
            }
          } catch (error) {
            console.error('Erro ao inicializar/atualizar treinamentos:', error);
            // Tenta novamente após um atraso em caso de erro
            setTimeout(initTreinamentos, 200);
          }
        };
        
        // Inicia o processo de inicialização/atualização
        setTimeout(initTreinamentos, 200);
      }
    }

    let risksData = {}; // variável global

function buscar_riscos() {
  // debugger removed

  const container = $("#group-select-container");
  container.html('<div class="loading-riscos" style="padding: 10px; text-align: center; color: #666;">Carregando grupos de risco...</div>');

  $.ajax({
    url: "cadastros/processa_risco.php",
    method: "GET",
    dataType: "json",
    data: {
      "processo_risco": "buscar_todos"
    },
    success: function(resposta) {
      // debugger removed

      const nomesGrupos = {
        "ergonomico": "Riscos Ergonômicos",
        "acidente_mecanico": "Riscos Acidentes - Mecânicos",
        "fisico": "Riscos Físicos",
        "quimico": "Riscos Químicos",
        "biologico": "Riscos Biológicos",
        "outro": "Outros Riscos"
      };

      // Limpa variável antes de popular
      risksData = {};

      resposta.forEach(item => {
        let grupo = item.grupo_risco?.trim();
        let codigo = item.codigo?.trim();
        let nome = item.descricao_grupo_risco?.trim();

        // Ignora grupo inválido
        if (!grupo || grupo === "selecione") return;

        // Garante que o grupo exista no objeto
        if (!risksData[grupo]) {
          risksData[grupo] = {
            name: nomesGrupos[grupo] || grupo,
            risks: []
          };
        }

        // Adiciona o risco no array do grupo
        risksData[grupo].risks.push({
          code: codigo,
          name: nome,
          isOther: nome?.toLowerCase() === "outros"
        });
      });

      console.log("RisksData montado:", risksData);

      // ----- Aqui segue sua lógica atual de montar checkboxes -----
      container.empty();
      // Debug antes de montar/checar os grupos
      try {
        console.log('DEBUG grupos antes de montar:', {
          snapshot: Array.isArray(window.riscosGruposEstadoSalvo) ? window.riscosGruposEstadoSalvo : [],
          gruposDisponiveis: Object.keys(risksData || {})
        });
      } catch(e) {}
      debugger;
      for (const [codigo, dados] of Object.entries(risksData)) {
        const deveMarcar = Array.isArray(window.riscosGruposEstadoSalvo) && window.riscosGruposEstadoSalvo.includes(codigo);
        const checkboxHtml = `
          <label class="group-option" style="display: block; padding: 5px 0;">
            
            <input type="checkbox" value="${codigo}">
            ${dados.name}
          </label>
        `;
        container.append(checkboxHtml);
      }

      // Após reconstruir os grupos, reaplica sempre o estado salvo (grupos e input)
      setTimeout(function(){
        try {
          if (typeof window.reaplicarGruposSelecionadosUI === 'function') {
            window.reaplicarGruposSelecionadosUI();
          }
          if (typeof window.reaplicarRiscosSelecionadosUI === 'function') {
            window.reaplicarRiscosSelecionadosUI();
          }
        } catch (e) { console.warn('Falha ao reaplicar estado de riscos após buscar_riscos:', e); }
      }, 0);

      // Observação: Listeners de busca e de checkboxes são inicializados em initializeRiscosComponent().
      // Evitamos duplicar handlers aqui para não gerar duas listagens/fluxos diferentes.

      // Garante inicialização única do componente principal após carregar os grupos
      setTimeout(function() {
        try {
          if (!window.riscosComponentInitialized && typeof window.initializeRiscosComponent === 'function') {
            window.initializeRiscosComponent();
            window.riscosComponentInitialized = true;
            console.log('RiscosComponent inicializado após carregar grupos.');
          }
        } catch (e) {
          console.error('Falha ao inicializar RiscosComponent após carregar grupos:', e);
        }
      }, 0);

      // Após montar os riscos, também atualiza a seção de Treinamentos
      try {
        if (typeof buscar_treinamentos === 'function') {
          buscar_treinamentos();
        }
      } catch (e) {
        console.warn('buscar_treinamentos não disponível após buscar_riscos:', e);
      }

      // Aguarda o DOM e tenta refresh/init do módulo de treinamentos
      setTimeout(function(){
        try {
          const treinamentos = (typeof gerenciarTreinamentos === 'function') ? gerenciarTreinamentos() : null;
          if (treinamentos && typeof treinamentos.refresh === 'function') {
            treinamentos.refresh();
          } else if (treinamentos && typeof treinamentos.init === 'function') {
            treinamentos.init();
          }
        } catch(e) {
          console.error('Falha ao atualizar/inicializar treinamentos após buscar_riscos:', e);
        }
      }, 200);
    },
    error: function(xhr, status, error) {
      console.error('Erro ao buscar riscos:', error);
      container.html('<div class="error-riscos" style="padding: 10px; text-align: center; color: #dc3545;">Erro ao carregar grupos de risco. Tente novamente.</div>');
    }
  });
}


  // Chama a função quando a aba de riscos for aberta
  $(document).on('click', '.tab[data-step="3"]', function() {
    buscar_riscos();
    // Garante dropdowns do laudo
    setTimeout(function(){
      try { if (typeof initializeLaudoDropdowns === 'function') initializeLaudoDropdowns(); } catch(e) {}
    }, 100);

    // Sempre recarrega treinamentos ao entrar/retornar à aba
    try {
      if (typeof buscar_treinamentos === 'function') {
        buscar_treinamentos();
      }
    } catch (e) {
      console.warn('buscar_treinamentos não disponível no click da aba:', e);
    }

    // Tenta atualizar/inicializar o módulo de treinamentos
    setTimeout(function(){
      try {
        const treinamentos = (typeof gerenciarTreinamentos === 'function') ? gerenciarTreinamentos() : null;
        if (treinamentos && typeof treinamentos.refresh === 'function') {
          treinamentos.refresh();
        } else if (treinamentos && typeof treinamentos.init === 'function') {
          treinamentos.init();
        }
      } catch(e) {
        console.error('Falha ao atualizar/inicializar treinamentos no click da aba:', e);
      }
    }, 200);
  });

  // Função para atualizar os grupos de risco selecionados
  window.updateSelectedGroups = function() {
    // Deprecated: UI agora é controlada por initializeRiscosComponent()
    console.warn('Deprecated: window.updateSelectedGroups foi chamado. Delegando para listeners internos.');
    try {
      const searchBox = document.getElementById('riscos-search-box');
      if (searchBox) {
        searchBox.dispatchEvent(new Event('input'));
      }
    } catch (e) {}
  };

  // Função para atualizar o placeholder da busca com base nos grupos selecionados
  function updateSearchPlaceholder(selectedGroups) {
    // Deprecated: placeholder é atualizado pelo componente interno
    console.warn('Deprecated: updateSearchPlaceholder externo chamado. Ignorando.');
  }

  // Função para realizar a busca de riscos
  function performSearch(term, groups) {
    // Deprecated: utilize a busca do componente interno (input event)
    console.warn('Deprecated: performSearch externo chamado. Disparando evento de input para delegar.');
    try {
      const searchBox = document.getElementById('riscos-search-box');
      if (searchBox) {
        // Ajusta o valor se fornecido
        if (typeof term === 'string') {
          searchBox.value = term;
        }
        searchBox.dispatchEvent(new Event('input'));
      }
    } catch (e) {}
  }
  
  // Função para exibir os resultados da busca
  function displaySearchResults(results) {
    // Deprecated: renderização de resultados é feita apenas pelo componente interno
    console.warn('Deprecated: displaySearchResults externo chamado. Ignorando.');
    return;
  }

  // Reaplica checkbox marcados a partir do estado global
  function reaplicarSelecoes() {
    const codesMarcados = new Set((window.treinamentosSelecionados || []).map(x => x.codigo));
    document.querySelectorAll('#listaTreinamentos input[type="checkbox"]').forEach(inp => {
      inp.checked = codesMarcados.has(inp.value);
    });
  }
  
  // Mantém um estado temporário dos selecionados a partir do DOM (não persiste no backend)
  function syncTempSelecionadosFromDOM() {
    debugger;
    const checkboxes = document.querySelectorAll('#listaTreinamentos input[type="checkbox"]:checked');
    const selecionadosTemporarios = Array.from(checkboxes).map(cb => ({
      codigo: cb.value,
      descricao: cb.getAttribute('data-nome') || cb.dataset?.nome || '',
      valor: cb.getAttribute('data-valor') || cb.dataset?.valor || '0'
    }));
    window.treinamentosSelecionados = selecionadosTemporarios;
  }
  
  // Reconstrói UI dos selecionados (lado direito) com base nos checados do DOM (não salva)
  function rebuildSelecionadosUIFromChecked() {
    debugger;
    if (!containerSelecionados) return;
    const checkboxes = document.querySelectorAll('#listaTreinamentos input[type="checkbox"]:checked');

    if (!checkboxes.length) {
      containerSelecionados.innerHTML = `
        <div style="color: #6c757d; font-style: italic; text-align: center; padding: 20px 0;">Nenhum treinamento selecionado</div>`;
      if (totalElement) totalElement.textContent = 'Total: R$ 0,00';
      return;
    }
    let html = '';
    let soma = 0.0;
    checkboxes.forEach(cb => {
      const codigo = cb.value;
      const nome = cb.getAttribute('data-nome') || '';
      const valorStr = (cb.getAttribute('data-valor') || '0').replace('.', '').replace(',', '.');
      const valor = parseFloat(valorStr) || 0;
      soma += valor;
      html += `
        <div style="padding: 8px 0; border-bottom: 1px solid #e9ecef;">
          <div style="font-weight: 500; font-size: 14px; margin-bottom: 4px;">${nome}</div>
          <div style="font-size: 12px; color: #6c757d;">Código: ${codigo}</div>
        </div>`;
    });
    containerSelecionados.innerHTML = html;
    // Mantido oculto o total no UI, mas atualiza variável global de faturamento
    window.fatTotalTreinamentos = soma.toFixed(2);
    if (typeof fatAtualizarTotais === 'function') {
      fatAtualizarTotais();
    }
  }

  // Salva (via AJAX) somente se houve alteração em relação ao último estado salvo
  async function atualizarSelecionados() {
    // debugger;
    const checkboxes = Array.from(document.querySelectorAll('#listaTreinamentos input[type="checkbox"]:checked'));

    // Monta objetos selecionados atuais (estado do DOM agora)
    const selecionadosAtuais = checkboxes.map(input => ({
      codigo: input.value,
      descricao: input.dataset.nome,
      valor: input.dataset.valor
    }));

    // Mantém estado temporário global atualizado para persistir entre trocas de abas
    window.treinamentosSelecionados = selecionadosAtuais.slice();

    const codesAtuais = selecionadosAtuais.map(x => x.codigo).sort();
    const codesSalvos = (window.treinamentosEstadoSalvoCodes || []).slice().sort();

    // Atualiza painel da direita e totais (independente de salvar ou não)
    rebuildSelecionadosUIFromChecked();

    // Descobre apenas ADIÇÕES para salvar no kit (não reenvia os já salvos)
    const setSalvos = new Set(window.treinamentosEstadoSalvoCodes || []);
    const apenasNovos = selecionadosAtuais.filter(x => !setSalvos.has(x.codigo));

    if (apenasNovos.length === 0) {
      console.log('Nenhum treinamento novo para salvar.');
      return;
    }

    // Persiste apenas os novos no backend
    const json_cursos_selecionados = JSON.stringify(apenasNovos);
    try {
      await new Promise((resolve, reject) => {
        $.ajax({
          url: "cadastros/processa_geracao_kit.php",
          type: "POST",
          dataType: "json",
          data: {
            processo_geracao_kit: "incluir_valores_kit",
            valor_treinamentos: json_cursos_selecionados,
          },
          success: function(resp) { resolve(resp); },
          error: function(xhr, status, error) { reject(error); }
        });
      });

      // Atualiza estado global após salvar
      const novosCodigos = apenasNovos.map(x => x.codigo);
      const uniao = Array.from(new Set([...(window.treinamentosEstadoSalvoCodes || []), ...novosCodigos]));
      window.treinamentosEstadoSalvoCodes = uniao;
      window.treinamentosSelecionados = selecionadosAtuais;
      window.treinamentosJaMarcados = window.treinamentosSelecionados.length > 0;

      if (typeof fatAtualizarTotais === 'function') {
        fatAtualizarTotais();
      }
    } catch (e) {
      console.error('Falha ao salvar treinamentos selecionados:', e);
    }
  }

  function initializeAptidoesExames() {
    console.log('Inicializando componente de Aptidões e Exames...');
      // ... (restante do código permanece o mesmo)
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
      debugger;
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
    async function salvarKit() {
      debugger;
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

      await gravar_final_kit();
      
      
      
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
        // mostrarSucessoSalvamento();
        restaurarBotaoSalvar();
      }, 1500);
      
      // Função para mostrar mensagem de sucesso
      // function mostrarSucessoSalvamento() {
        
      // }
      
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

    window.smDocumentosSelecionadosJSON = window.smDocumentosSelecionadosJSON || [];

    function gravar_final_kit()
    {
      if(window.recebe_acao && window.recebe_acao === "editar")
      {
        return new Promise((resolve, reject) => {
          $.ajax({
            url: "cadastros/processa_geracao_kit.php",
            type: "POST",
            dataType: "json",
            data: {
              processo_geracao_kit: "atualizar_kit",
              valor_tipo_orcamento: window.tiposOrcamentoSelecionadosJSON,
              valor_documento: window.smDocumentosSelecionadosJSON,
              valor_total: window.total_final,
              valor_finalizamento: "finalizando kit",
              valor_id_kit:window.recebe_id_kit,
              requer_assinatura: (function(){ var el = document.getElementById('requer-assinatura'); return !!(el && el.checked); })()
            },
            success: function (retorno_final_kit) {
              debugger;

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
                confirmButtonText: 'Visualizar',
                confirmButtonColor: '#28a745',
                allowOutsideClick: false
              }).then((result) => {
                if (result.isConfirmed) {
                  debugger;
                  // Cria formulário oculto
                  let form = document.createElement("form");
                  form.method = "POST";
                  // form.action = "cadastros/processa_geracao_kit.php";
                  form.action = "cadastros/documentos/geracao.php";
                  form.target = "_blank"; // abre em nova aba

                  // Adiciona input hidden "acao"
                  let input = document.createElement("input");
                  input.type = "hidden";
                  input.name = "processo_geracao";
                  // input.value = window.smDocumentosSelecionadosNomes;
                  input.value = window.todosSelecionados;
                  form.appendChild(input);

                  // 🔹 Envia o campo "valor_id_kit"
                  let inputIdKit = document.createElement("input");
                  inputIdKit.type = "hidden";
                  inputIdKit.name = "valor_id_kit";
                  inputIdKit.value = window.recebe_id_kit;
                  form.appendChild(inputIdKit);

                  // Adiciona o form ao body e envia
                  document.body.appendChild(form);
                  form.submit();

                  // Remove o form depois de enviar (boa prática)
                  document.body.removeChild(form);
                }
              });

              console.log(retorno_final_kit);
              resolve(retorno_final_kit);
            },
            error: function (xhr, status, error) {
              console.log("Falha ao incluir exame: " + error);
              reject(error);
            },
          });
        });
      }else
      {
        return new Promise((resolve, reject) => {
          $.ajax({
            url: "cadastros/processa_geracao_kit.php",
            type: "POST",
            dataType: "json",
            data: {
              processo_geracao_kit: "incluir_valores_kit",
              valor_tipo_orcamento: window.tiposOrcamentoSelecionadosJSON,
              valor_documento: window.smDocumentosSelecionadosJSON,
              valor_total: window.total_final,
              valor_finalizamento: "finalizando kit",
              requer_assinatura: (function(){ var el = document.getElementById('requer-assinatura'); return !!(el && el.checked); })()
            },
            success: function (retorno_final_kit) {
              debugger;

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
                confirmButtonText: 'Visualizar',
                confirmButtonColor: '#28a745',
                allowOutsideClick: false
              }).then((result) => {
                if (result.isConfirmed) {
                  debugger;
                  // Cria formulário oculto
                  let form = document.createElement("form");
                  form.method = "POST";
                  // form.action = "cadastros/processa_geracao_kit.php";
                  form.action = "cadastros/documentos/geracao.php";
                  form.target = "_blank"; // abre em nova aba

                  // Adiciona input hidden "acao"
                  let input = document.createElement("input");
                  input.type = "hidden";
                  input.name = "processo_geracao";
                  // input.value = window.smDocumentosSelecionadosNomes;
                  input.value = window.todosSelecionados;
                  form.appendChild(input);

                  // Adiciona o form ao body e envia
                  document.body.appendChild(form);
                  form.submit();

                  // Remove o form depois de enviar (boa prática)
                  document.body.removeChild(form);
                }
              });

              console.log(retorno_final_kit);
              resolve(retorno_final_kit);
            },
            error: function (xhr, status, error) {
              console.log("Falha ao incluir exame: " + error);
              reject(error);
            },
          });
        });
      }
      }
    
    // Função para validar todos os campos obrigatórios do formulário
    // function validarFormularioCompleto() {
    //   debugger;
    //   // Validação do tipo de exame
    //   if (!appState.selectedExam) {
    //     mostrarErroValidacao('Por favor, selecione um tipo de exame.');
    //     return false;
    //   }
      
    //   // Validação dos campos da empresa (etapa 1)
    //   if (appState.currentStep >= 1) {
    //     // Usa estado global/variável para validar seleção, pois o elemento pode não estar no DOM neste momento
    //     const empresaSelecionadaId = (window.ecpState && window.ecpState.empresa && window.ecpState.empresa.id)
    //       || (typeof recebe_codigo_empresa_selecionada !== 'undefined' ? recebe_codigo_empresa_selecionada : null)
    //       || null;
    //     if (!empresaSelecionadaId) {
    //       mostrarErroValidacao('Por favor, selecione uma empresa.');
    //       return false;
    //     } else {
    //       // Confirmação não intrusiva para depuração
    //       try { console.log('Uma empresa foi selecionada. ID:', empresaSelecionadaId); } catch (e) { /* noop */ }
    //     }

    //     // Usa estado global/variável para validar a clínica, pois o elemento pode não estar no DOM
    //     const clinicaSelecionadaId = (window.ecpState && window.ecpState.clinica && window.ecpState.clinica.id)
    //       || (typeof recebe_codigo_clinica_selecionada !== 'undefined' ? recebe_codigo_clinica_selecionada : null)
    //       || null;
    //     if (!clinicaSelecionadaId) {
    //       mostrarErroValidacao('Por favor, selecione uma clínica.');
    //       return false;
    //     } else {
    //       // Confirmação não intrusiva para depuração
    //       try { console.log('Uma clínica foi selecionada. ID:', clinicaSelecionadaId); } catch (e) { /* noop */ }
    //     }
    //   }
      
    //   // Validação do colaborador (etapa 2)
    //   if (appState.currentStep >= 2) {
    //     // Usa o estado global salvo em selecionarECP() para confirmar o colaborador selecionado
    //     const colaboradorSelecionadoId = (window.ecpState && window.ecpState.colaborador && window.ecpState.colaborador.id) || null;
    //     if (!colaboradorSelecionadoId) {
    //       mostrarErroValidacao('Por favor, selecione um colaborador.');
    //       return false;
    //     } else {
    //       // Confirmação não intrusiva para depuração
    //       try { console.log('Um colaborador foi selecionado. ID:', colaboradorSelecionadoId); } catch (e) { /* noop */ }
    //     }
    //   }
      
    //   // // Validação dos riscos ocupacionais (etapa 3)
    //   // if (appState.currentStep >= 3) {
    //   //   // Usa o estado global de riscos acumulado via addSelectedRisk
    //   //   let riskCodes = (typeof window.getSelectedRiskCodes === 'function')
    //   //     ? window.getSelectedRiskCodes()
    //   //     : (typeof selectedRisks !== 'undefined' ? Object.keys(selectedRisks || {}) : []);
    //   //   // Fallback: se vazio, tenta riscos persistidos em window.riscosEstadoSalvoDetalhes
    //   //   if (!riskCodes || riskCodes.length === 0) {
    //   //     try {
    //   //       const persistidos = (window.riscosEstadoSalvoDetalhes && typeof window.riscosEstadoSalvoDetalhes === 'object')
    //   //         ? Object.keys(window.riscosEstadoSalvoDetalhes)
    //   //         : [];
    //   //       if (persistidos && persistidos.length > 0) {
    //   //         riskCodes = persistidos;
    //   //       }
    //   //     } catch (e) { /* noop */ }
    //   //   }
    //   //   if (!riskCodes || riskCodes.length === 0) {
    //   //     mostrarErroValidacao('Por favor, adicione pelo menos um risco ocupacional.');
    //   //     return false;
    //   //   } else {
    //   //     // Confirmação não intrusiva
    //   //     try { console.log('Riscos selecionados:', riskCodes); } catch (e) { /* noop */ }
    //   //   }
    //   // }
      
    //   // Validação dos documentos selecionados (etapa 5)
    //   if (appState.currentStep >= 5) {
    //     // Usa variável global que armazena os nomes dos documentos selecionados
    //     let documentosSelecionadosCount = 0;
    //     try {
    //       if (Array.isArray(window.smDocumentosSelecionadosNomes)) {
    //         documentosSelecionadosCount = window.smDocumentosSelecionadosNomes.length;
    //       } else if (window.smDocumentosSelecionadosNomes && typeof window.smDocumentosSelecionadosNomes === 'object') {
    //         documentosSelecionadosCount = Object.keys(window.smDocumentosSelecionadosNomes).length;
    //       }
    //     } catch (e) { /* noop */ }
    //     // Fallback: caso a variável global não esteja disponível, usa os checkboxes marcados
    //     if (!documentosSelecionadosCount) {
    //       const documentosSelecionados = document.querySelectorAll('.sm-checkbox:checked');
    //       documentosSelecionadosCount = documentosSelecionados ? documentosSelecionados.length : 0;
    //     }
    //     if (!documentosSelecionadosCount) {
    //       mostrarErroValidacao('Por favor, selecione pelo menos um documento para gerar.');
    //       return false;
    //     } else {
    //       try { console.log('Documentos selecionados (quantidade):', documentosSelecionadosCount); } catch (e) { /* noop */ }
    //     }
    //   }
      
    //   return true;
    // }

    // Função para validar todos os campos obrigatórios do formulário
    function validarFormularioCompleto() {
      debugger;
      // Validação do tipo de exame
      // if (!appState.selectedExam) {
      //   mostrarErroValidacao('Por favor, selecione um tipo de exame.');
      //   return false;
      // }

      // 🔹 Validação do tipo de exame selecionado
      let tipoExameSelecionado = null;

      if (window.recebe_acao === "editar") {
        // 👉 Em modo de edição, pode vir do kit ou do estado do app
        tipoExameSelecionado =
          window.kit_tipo_exame?.tipo_exame ||
          appState.selectedExam ||
          null;
      } else {
        // 👉 Fora do modo de edição, apenas do estado do app
        tipoExameSelecionado = appState.selectedExam || null;
      }

      // 🔸 Validação
      if (!tipoExameSelecionado) {
        mostrarErroValidacao('Por favor, selecione um tipo de exame.');
        return false;
      } else {
        // 🔸 Log informativo para depuração
        try {
          const fonte =
            window.recebe_acao === "editar" && window.kit_tipo_exame?.tipo_exame
              ? kit_tipo_exame.tipo_exame
              : appState.selectedExam;

          console.log(`✅ Tipo de exame selecionado com sucesso (${fonte}):`, tipoExameSelecionado);
        } catch (e) {
          /* noop */
        }
      }


      
      // Validação dos campos da empresa (etapa 1)
      if (appState.currentStep >= 1) {
        // 🔸 Define o ID da empresa com base no modo atual (edição ou não)
        let empresaSelecionadaId = null;

        if (window.recebe_acao === "editar") {
          // 👉 Em edição, tenta pegar primeiro do kit da empresa
          empresaSelecionadaId =
          window.kit_empresa?.id ||
          (typeof recebe_codigo_empresa_selecionada !== 'undefined' ? recebe_codigo_empresa_selecionada : null) ||
          null;
        } else {
          // 👉 Fora do modo de edição, tenta buscar das variáveis padrão
          empresaSelecionadaId =
            (window.ecpState?.empresa?.id) ||
            (typeof recebe_codigo_empresa_selecionada !== 'undefined' ? recebe_codigo_empresa_selecionada : null) ||
            null;
        }

        // 🔸 Validação
        if (!empresaSelecionadaId) {
          mostrarErroValidacao('Por favor, selecione uma empresa.');
          return false;
        } else {
          // 🔸 Log informativo (não interrompe a execução)
          try {
            console.log('✅ Empresa selecionada com sucesso. ID:', empresaSelecionadaId);
          } catch (e) {
            /* noop */
          }
        }

        // 🔹 Validação da clínica selecionada
        // Usa estado global/variável para validar a clínica, pois o elemento pode não estar no DOM
        let clinicaSelecionadaId = null;

        if (window.recebe_acao === "editar") {
          // 👉 Em modo de edição, tenta primeiro o kit da clínica, mas faz fallback para outras fontes
          clinicaSelecionadaId =
            window.kit_clinica?.id ||
            window.ecpState?.clinica?.id ||
            (typeof recebe_codigo_clinica_selecionada !== 'undefined' ? recebe_codigo_clinica_selecionada : null) ||
            null;
        } else {
          // 👉 Fora do modo de edição, tenta buscar de onde estiver disponível
          clinicaSelecionadaId =
            window.ecpState?.clinica?.id ||
            window.kit_clinica?.id ||
            (typeof recebe_codigo_clinica_selecionada !== 'undefined' ? recebe_codigo_clinica_selecionada : null) ||
            null;
        }

        // 🔸 Validação
        if (!clinicaSelecionadaId) {
          mostrarErroValidacao('Por favor, selecione uma clínica.');
          return false;
        } else {
          // 🔸 Log informativo para depuração
          try {
            console.log('✅ Clínica selecionada com sucesso. ID:', clinicaSelecionadaId);
          } catch (e) {
            /* noop */
          }
        }
      }
      
      // Validação do colaborador (etapa 2)
      if (appState.currentStep >= 2) {
        // 🔹 Validação do colaborador selecionado
        // Usa o estado global salvo em selecionarECP() para confirmar o colaborador selecionado
        let colaboradorSelecionadoId = null;

        if (window.recebe_acao === "editar") {
          // 👉 Em modo de edição, tenta primeiro o kit da pessoa, mas faz fallback para outras fontes
          colaboradorSelecionadoId =
            window.kit_pessoa?.id ||
            window.ecpState?.colaborador?.id ||
            (typeof recebe_codigo_pessoa !== 'undefined' ? recebe_codigo_pessoa : null) ||
            null;
        } else {
          // 👉 Fora do modo de edição, tenta buscar de onde estiver disponível
          colaboradorSelecionadoId =
            window.ecpState?.colaborador?.id ||
            window.kit_pessoa?.id ||
            (typeof recebe_codigo_pessoa !== 'undefined' ? recebe_codigo_pessoa : null) ||
            null;
        }

        // 🔸 Validação
        if (!colaboradorSelecionadoId) {
          mostrarErroValidacao('Por favor, selecione um colaborador.');
          return false;
        } else {
          // 🔸 Log informativo para depuração
          try {
            console.log('✅ Colaborador selecionado com sucesso. ID:', colaboradorSelecionadoId);
          } catch (e) {
            /* noop */
          }
        }
      }
      
      // // Validação dos riscos ocupacionais (etapa 3)
      // if (appState.currentStep >= 3) {
      //   // Usa o estado global de riscos acumulado via addSelectedRisk
      //   let riskCodes = (typeof window.getSelectedRiskCodes === 'function')
      //     ? window.getSelectedRiskCodes()
      //     : (typeof selectedRisks !== 'undefined' ? Object.keys(selectedRisks || {}) : []);
      //   // Fallback: se vazio, tenta riscos persistidos em window.riscosEstadoSalvoDetalhes
      //   if (!riskCodes || riskCodes.length === 0) {
      //     try {
      //       const persistidos = (window.riscosEstadoSalvoDetalhes && typeof window.riscosEstadoSalvoDetalhes === 'object')
      //         ? Object.keys(window.riscosEstadoSalvoDetalhes)
      //         : [];
      //       if (persistidos && persistidos.length > 0) {
      //         riskCodes = persistidos;
      //       }
      //     } catch (e) { /* noop */ }
      //   }
      //   if (!riskCodes || riskCodes.length === 0) {
      //     mostrarErroValidacao('Por favor, adicione pelo menos um risco ocupacional.');
      //     return false;
      //   } else {
      //     // Confirmação não intrusiva
      //     try { console.log('Riscos selecionados:', riskCodes); } catch (e) { /* noop */ }
      //   }
      // }
      
      // Validação dos documentos selecionados (etapa 5)
      if (appState.currentStep >= 5) {
        // 🔹 Validação dos documentos selecionados
let documentosSelecionadosCount = 0;

try {
  if (window.recebe_acao === "editar") {
    // 👉 Em modo de edição: o valor vem do banco como um array de strings, ex: ["Audiometria"]
    if (Array.isArray(window.modelos_documentos)) {
      documentosSelecionadosCount = window.modelos_documentos.length;
    } else if (typeof window.modelos_documentos === 'string') {
      // Caso venha em formato de string JSON
      try {
        const parsed = JSON.parse(window.modelos_documentos);
        if (Array.isArray(parsed)) documentosSelecionadosCount = parsed.length;
      } catch (e) {
        console.warn('⚠️ modeloss_documentos não é um array válido:', e);
      }
    }
  } else {
    // 👉 Fora do modo de edição: usa as variáveis globais normais
    if (Array.isArray(window.smDocumentosSelecionadosNomes)) {
      documentosSelecionadosCount = window.smDocumentosSelecionadosNomes.length;
    } else if (window.smDocumentosSelecionadosNomes && typeof window.smDocumentosSelecionadosNomes === 'object') {
      documentosSelecionadosCount = Object.keys(window.smDocumentosSelecionadosNomes).length;
    }
  }
} catch (e) {
  console.warn('⚠️ Erro ao contar documentos selecionados:', e);
}

// 🔸 Fallback: caso nada tenha sido encontrado, usa os checkboxes
if (!documentosSelecionadosCount) {
  const documentosSelecionados = document.querySelectorAll('.sm-checkbox:checked');
  documentosSelecionadosCount = documentosSelecionados ? documentosSelecionados.length : 0;
}

// 🔸 Validação final
if (!documentosSelecionadosCount) {
  mostrarErroValidacao('Por favor, selecione pelo menos um documento para gerar.');
  return false;
} else {
  try {
    console.log('✅ Documentos selecionados (quantidade):', documentosSelecionadosCount);
  } catch (e) {
    /* noop */
  }
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

    function buscar_treinamentos() {
      let resultado = null;
      
      // Realiza a requisição síncrona para buscar os treinamentos
      $.ajax({
        url: "cadastros/processa_treinamento_capacitacao.php",
        method: "GET",
        dataType: "json",
        async: false, // Torna a requisição síncrona
        data: {
          "processo_treinamento_capacitacao": "busca_treinamento_capacitacao"
        },
        success: function(resposta) {
          // debugger;
          if (resposta && resposta.length > 0) {
            resultado = resposta;
          } else {
            console.warn('Nenhum treinamento encontrado na resposta');
            resultado = [];
          }
        },
        error: function(xhr, status, error) {
          console.error('Erro na requisição de treinamentos:', error);
          resultado = [];
        }
      });
      
      return resultado;
    }
    
    // Função para gerenciar os treinamentos
    function gerenciarTreinamentos() {
      debugger;
      // Array que irá armazenar os treinamentos
      const treinamentos = [];
      
      // Busca os treinamentos do banco de dados
      try {
        console.log('Iniciando busca de treinamentos...');
        // Chama a função buscar_treinamentos que faz a requisição AJAX
        const response = buscar_treinamentos();
        console.log('Resposta recebida:', response);
        
        if (response && Array.isArray(response) && response.length > 0) {
          // Formata os dados para o formato esperado pelo sistema
          response.forEach(function(treinamento) {
            // debugger;
            treinamentos.push({
              codigo: treinamento.codigo_treinamento_capacitacao,
              nome: treinamento.nome,
              valor: treinamento.valor
            });
          });
        } else {
          console.warn('Nenhum treinamento encontrado no banco de dados');
          // Exibe mensagem de nenhum registro encontrado
          console.log('Tentando exibir mensagem de nenhum registro...');
          const listaTreinamentos = document.getElementById('listaTreinamentos');
          console.log('Elemento listaTreinamentos encontrado?', !!listaTreinamentos);
          if (listaTreinamentos) {
            console.log('Atualizando HTML da lista de treinamentos...');
            // Limpa a lista de treinamentos
            listaTreinamentos.innerHTML = `
              <div style="text-align: center; padding: 40px 20px; color: #6c757d; font-style: italic; background: #fff; border-radius: 6px;">
                <i class="fas fa-info-circle" style="margin-right: 5px; font-size: 18px;"></i>
                <div style="margin-top: 8px;">Nenhum treinamento cadastrado</div>
              </div>`;
            
            // Esconde o botão de aplicar seleção
            const btnAplicar = document.getElementById('btnAplicarTreinamentos');
            if (btnAplicar) {
              btnAplicar.style.display = 'none';
            }
            
            // Limpa a lista de selecionados
            const containerSelecionados = document.getElementById('treinamentosSelecionados');
            if (containerSelecionados) {
              containerSelecionados.innerHTML = `
                <div style="color: #6c757d; font-style: italic; text-align: center; padding: 20px 0;">
                  Nenhum treinamento selecionado
                </div>`;
            }
            
            // Código de exibição do total comentado conforme solicitado
            // const totalElement = document.getElementById('totalTreinamentos');
            // if (totalElement) {
            //   totalElement.textContent = 'Total: R$ 0,00';
            // }
            
            // Atualização do banner de totais comentada conforme solicitado
            // updateTotalBanner(0);
          }
        }
      } catch (error) {
        console.error('Erro ao buscar treinamentos:', error);
        // Exibe mensagem de erro na busca
        const listaTreinamentos = document.getElementById('listaTreinamentos');
        if (listaTreinamentos) {
          listaTreinamentos.innerHTML = `
            <div style="text-align: center; padding: 20px; color: #dc3545;">
              <i class="fas fa-exclamation-triangle" style="margin-right: 5px;"></i>
              Erro ao carregar treinamentos. Tente novamente mais tarde.
            </div>`;
        }
      }

      // Elementos do DOM
      const listaTreinamentos = document.getElementById('listaTreinamentos');
      const btnAplicar = document.getElementById('btnAplicarTreinamentos');
      const btnAddTreinamento = document.getElementById('btnAddTreinamento');
      const containerSelecionados = document.getElementById('treinamentosSelecionados');
      const totalElement = document.getElementById('totalTreinamentos');

      // Renderiza a lista de treinamentos
      function renderizarTreinamentos() {
        debugger;
        if (treinamentos.length === 0) {
          listaTreinamentos.innerHTML = `
            <div style="text-align: center; padding: 40px 20px; color: #6c757d; font-style: italic; background: #fff; border-radius: 6px;">
              <i class="fas fa-info-circle" style="margin-right: 5px; font-size: 18px;"></i>
              <div style="margin-top: 8px;">Nenhum treinamento cadastrado</div>
            </div>`;
          
          // Esconde o botão de aplicar seleção
          const btnAplicar = document.getElementById('btnAplicarTreinamentos');
          if (btnAplicar) {
            btnAplicar.style.display = 'none';
          }
        } else {
          // Mostra o botão de aplicar seleção
          const btnAplicar = document.getElementById('btnAplicarTreinamentos');
          if (btnAplicar) {
            btnAplicar.style.display = 'inline-flex';
          }

          //console.log("valor treinamento:",treinamento);

          
          
          // 🔹 Garante que o container existe
// if (typeof listaTreinamentos !== 'undefined' && listaTreinamentos !== null) {

//     // 🔹 Verifica se 'treinamento' existe e é um array com itens
//     if (typeof treinamento !== 'undefined' && Array.isArray(treinamento) && treinamento.length > 0) {
//         listaTreinamentos.innerHTML = treinamento.map(item => `
//             <div class="treinamento-item" style="padding: 8px 12px; border-bottom: 1px solid #e9ecef; display: flex; align-items: center;">
//                 <input type="checkbox" value="${item.codigo}" 
//                        data-nome="${item.nome}" 
//                        data-valor="${item.valor}" 
//                        style="margin-right: 10px; cursor: pointer;">
//                 <div style="flex: 1; cursor: pointer;">
//                     <div style="font-weight: 500;">${item.nome}</div>
//                     <div style="font-size: 12px; color: #6c757d;">
//                         Código: ${item.codigo}
//                     </div>
//                 </div>
//             </div>
//         `).join('');
//     } else {
//         // 🔹 Caso 'treinamento' não exista ou esteja vazio
//         listaTreinamentos.innerHTML = `
//             <div style="padding: 10px; color: #777;">
//                 Nenhum treinamento disponível.
//             </div>
//         `;
//     }

// } else {
//     console.warn("Elemento listaTreinamentos não encontrado no DOM.");
// }

// listaTreinamentos.innerHTML = treinamentos.map(treinamento => `
//             <div class="treinamento-item" style="padding: 8px 12px; border-bottom: 1px solid #e9ecef; display: flex; align-items: center;">
//                 <input type="checkbox" value="${treinamento.codigo}" 
//                        data-nome="${treinamento.nome}" 
//                        data-valor="${treinamento.valor}" 
//                        style="margin-right: 10px; cursor: pointer;">
//                 <div style="flex: 1; cursor: pointer;">
//                     <div style="font-weight: 500;">${treinamento.nome}</div>
//                     <div style="font-size: 12px; color: #6c757d;">
//                         Código: ${treinamento.codigo}
//                     </div>
//                 </div>
//             </div>
//         `).join('');

if (listaTreinamentos !== null && Array.isArray(treinamentos) && treinamentos.length > 0) {
    listaTreinamentos.innerHTML = treinamentos.map(treinamento => `
        <div class="treinamento-item" style="padding: 8px 12px; border-bottom: 1px solid #e9ecef; display: flex; align-items: center;">
            <input type="checkbox" value="${treinamento.codigo}" 
                   data-nome="${treinamento.nome}" 
                   data-valor="${treinamento.valor}" 
                   style="margin-right: 10px; cursor: pointer;">
            <div style="flex: 1; cursor: pointer;">
                <div style="font-weight: 500;">${treinamento.nome}</div>
                <div style="font-size: 12px; color: #6c757d;">
                    Código: ${treinamento.codigo}
                </div>
            </div>
        </div>
    `).join('');
} else if (listaTreinamentos !== null) {
    // Caso não haja dados, exibe mensagem amigável
    listaTreinamentos.innerHTML = `
        <div style="padding: 10px; color: #777;">
            Nenhum treinamento disponível.
        </div>
    `;
}


        }
      }

      // Cria o banner de totais se não existir
      function createTotalBanner() {
        if (!document.getElementById('total-treinamentos-banner')) {
          const banner = document.createElement('div');
          // banner.id = 'total-treinamentos-banner';
          // banner.style.position = 'fixed';
          // banner.style.top = '10px';
          // banner.style.right = '10px';
          // banner.style.backgroundColor = '#28a745';
          // banner.style.border = 'none';
          // banner.style.borderRadius = '6px';
          // banner.style.padding = '10px 20px';
          // banner.style.zIndex = '9998';
          // banner.style.display = 'flex';
          // banner.style.alignItems = 'center';
          // banner.style.boxShadow = '0 2px 8px rgba(0,0,0,0.15)';
          // banner.style.color = 'white';
          // banner.style.fontFamily = 'Arial, sans-serif';
          // banner.style.fontSize = '14px';
          // banner.style.fontWeight = '600';
          // banner.style.letterSpacing = '0.3px';
          // banner.style.transition = 'all 0.3s ease';
          // banner.innerHTML = `
          //   <i class="fas fa-graduation-cap" style="font-size: 16px; color: #ffffff; margin-right: 8px;"></i>
          //   <span style="color: #ffffff; text-shadow: 0 1px 1px rgba(0,0,0,0.1);">TREINAMENTOS: R$ 0,00</span>
          // `;
          
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

      // ===================== Treinamentos: Estado e Funções =====================
      // Estados globais mantidos entre trocas de aba
      window.treinamentosSelecionados = window.treinamentosSelecionados || [];
      window.treinamentosEstadoSalvoCodes = window.treinamentosEstadoSalvoCodes || [];
      window.recebe_valores_treinamentos_selecionados = window.recebe_valores_treinamentos_selecionados || [];

      // Normaliza qualquer formato inesperado para sempre trabalhar com Array
      function normalizeTreinamentosSelecionados(val) {
        try {
          if (Array.isArray(val)) return val;
          if (val == null) return [];
          if (typeof val === 'string') {
            const parsed = JSON.parse(val);
            return Array.isArray(parsed) ? parsed : [];
          }
          if (typeof val === 'object') {
            // Pode vir como objeto/dicionário -> usa os valores
            const arr = Object.values(val);
            return Array.isArray(arr) ? arr : [];
          }
          return [];
        } catch (e) {
          console.warn('normalizeTreinamentosSelecionados falhou, retornando array vazio:', e);
          return [];
        }
      }

      // Lê os checkboxes marcados e sincroniza os arrays globais temporários (execução única)
      function syncTempSelecionadosFromDOM() {
        // debugger;
        if (window._syncTreinamentosRunning) return;
        window._syncTreinamentosRunning = true;
        try {
          const marcados = document.querySelectorAll('#listaTreinamentos input[type="checkbox"]:checked');
          const lista = [];
          const listaValores = [];
          marcados.forEach(input => {
            const codigo = String(input.value);
            const nome = input.getAttribute('data-nome') || input.dataset?.nome || '';
            const valor = input.getAttribute('data-valor') || input.dataset?.valor || '0';
            lista.push({
              codigo: codigo,
              descricao: nome,
              valor: valor
            });
            listaValores.push({
              codigo: codigo,
              valor: valor
            });
          });
          window.treinamentosSelecionados = lista;
          window.recebe_valores_treinamentos_selecionados = listaValores;
        } finally {
          // Libera no próximo tick para agrupar múltiplos eventos no mesmo ciclo
          setTimeout(() => { window._syncTreinamentosRunning = false; }, 0);
        }
      }

      // Marca checkboxes conforme o estado temporário global
      function reaplicarSelecoes() {
        window.treinamentosSelecionados = normalizeTreinamentosSelecionados(window.treinamentosSelecionados);
        const marcados = new Set(window.treinamentosSelecionados.map(t => String(t.codigo)));
        document.querySelectorAll('#listaTreinamentos input[type="checkbox"]').forEach(cb => {
          cb.checked = marcados.has(String(cb.value));
        });
      }

      // Reconstrói o painel da direita e atualiza o total global com base no estado ATUAL (checkboxes marcados)
      function rebuildSelecionadosUIFromChecked() {
        debugger;
        // Evita reentrância (fatAtualizarTotais pode disparar eventos que voltam aqui)
        if (window._rebuildTreinamentosRunning) return;
        window._rebuildTreinamentosRunning = true;

        try {
          const container = document.getElementById('treinamentosSelecionados');
          const totalElement = document.getElementById('totalTreinamentos');
          if (!container) return;

          const marcados = Array.from(document.querySelectorAll('#listaTreinamentos input[type="checkbox"]:checked'));

          if (marcados.length === 0) {
            container.innerHTML = `
              <div style="color: #6c757d; font-style: italic; text-align: center; padding: 20px 0;">
                Nenhum treinamento selecionado
              </div>`;
            if (totalElement) totalElement.textContent = 'Total: R$ 0,00';
            window.fatTotalTreinamentos = 0;
            if (typeof fatAtualizarTotais === 'function') fatAtualizarTotais();
            return;
          }

          let html = '';
          let total = 0;
          marcados.forEach(cb => {
            const codigo = String(cb.value);
            const nome = cb.getAttribute('data-nome') || cb.dataset?.nome || `Treinamento ${codigo}`;
            const valorStr = cb.getAttribute('data-valor') || cb.dataset?.valor || '0';
            const valor = parseFloat((valorStr || '0').replace('.', '').replace(',', '.')) || 0;
            total += valor;
            html += `
              <div class="treinamento-selecionado" style="padding: 8px 0; border-bottom: 1px solid #e9ecef; display: flex; align-items: center; justify-content: space-between; gap: 8px;">
                <div>
                  <div style=\"font-weight: 500; font-size: 14px; margin-bottom: 4px;\">${nome}</div>
                  <div style=\"font-size: 12px; color: #6c757d;\">Código: ${codigo}</div>
                </div>
                <button type=\"button\" title=\"Remover\" data-acao=\"remover-treinamento\" data-codigo=\"${codigo}\" style=\"border: none; background: transparent; color: #dc3545; cursor: pointer; padding: 4px;\">
                  <i class=\"fas fa-trash\"></i>
                </button>
              </div>`;
          });

          container.innerHTML = html;
          window.fatTotalTreinamentos = Number(total.toFixed(2));
          if (typeof fatAtualizarTotais === 'function') fatAtualizarTotais();
        } finally {
          window._rebuildTreinamentosRunning = false;
        }
      }

      // Salva apenas os novos itens ao clicar em Aplicar (execução única)
      async function atualizarSelecionadosTreinamentos() {
        debugger;
        if (window._aplicarTreinamentosRunning) return;
        window._aplicarTreinamentosRunning = true;
        try {
          
          syncTempSelecionadosFromDOM();

          // Normaliza estados antes de usar
          window.treinamentosSelecionados = normalizeTreinamentosSelecionados(window.treinamentosSelecionados);
          // Envia TODOS os itens atualmente selecionados como array
          const novosDetalhes = Array.isArray(window.treinamentosSelecionados)
            ? window.treinamentosSelecionados
            : [];

          if (novosDetalhes.length === 0) {
            console.log('Nenhum novo treinamento para salvar.');
            return;
          }

          // Envia apenas os novos
          json_cursos_selecionados = JSON.stringify(novosDetalhes);
          await gravar_treinamentos_selecionados();

          // Atualiza o estado salvo para refletir EXATAMENTE o que foi enviado
          window.treinamentosEstadoSalvoCodes = Array.from(new Set(
            novosDetalhes.map(t => String(t.codigo))
          ));

          rebuildSelecionadosUIFromChecked();
        } catch (err) {
          console.error('Falha ao salvar treinamentos selecionados:', err);
        } finally {
          window._aplicarTreinamentosRunning = false;
        }
      }

      // Supondo que você já tenha todos os inputs selecionados
      let cursosSelecionados = [];
      let json_cursos_selecionados;

      let recebe_valores_treinamentos_selecionados = [];
      // Atualiza a lista de treinamentos selecionados
      async function atualizarSelecionados() {
        debugger;
        const checkboxes = document.querySelectorAll('#listaTreinamentos input[type="checkbox"]:checked');

        document.querySelectorAll('#listaTreinamentos input[type="checkbox"]:checked').forEach(input => {
  
        // Evita duplicados
        const jaExiste = cursosSelecionados.some(curso => curso.codigo === input.value);
        let jaExisteSomaTreinamento = recebe_valores_treinamentos_selecionados.some(treinamento => treinamento.codigo === input.value);
        
        if (!jaExiste) {
            cursosSelecionados.push({
              codigo: input.value,
              descricao: input.dataset.nome,
              valor: input.dataset.valor
            });
          }

        if (!jaExisteSomaTreinamento) {
            debugger;
            recebe_valores_treinamentos_selecionados.push({
              codigo: input.value,
              valor: input.dataset.valor
            });
          }
        });

        console.log("Treinamentos com valor para somar:",recebe_valores_treinamentos_selecionados);

        // Converte para JSON para enviar via AJAX
        json_cursos_selecionados = JSON.stringify(cursosSelecionados);

        console.log(json_cursos_selecionados);

        await gravar_treinamentos_selecionados();
        
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
        let total = recebe_valores_treinamentos_selecionados
    .reduce((soma, item) => soma + parseFloat((item.valor || "0").replace(",", ".")), 0)
    .toFixed(2);

console.log(total); // Exemplo: "180.10"

        
        checkboxes.forEach(checkbox => {
          const codigo = checkbox.value;
          const nome = checkbox.getAttribute('data-nome');
          // const valor = parseFloat(checkbox.getAttribute('data-valor').replace('.', '').replace(',', '.'));

          html += `
              <div style="padding: 8px 0; border-bottom: 1px solid #e9ecef;">
                <div style="font-weight: 500; font-size: 14px; margin-bottom: 4px;">${nome}</div>
                <div style="font-size: 12px; color: #6c757d;">Código: ${codigo}</div>
              </div>`;
          
          // if (!isNaN(valor)) {
          //   // total += valor;
            
          //   html += `
          //     <div style="padding: 8px 0; border-bottom: 1px solid #e9ecef;">
          //       <div style="font-weight: 500; font-size: 14px; margin-bottom: 4px;">${nome}</div>
          //       <div style="font-size: 12px; color: #6c757d;">Código: ${codigo}</div>
          //     </div>`;
          // }
        });
        
        containerSelecionados.innerHTML = html;
        // Comentado para não exibir o total
        // const totalFormatado = total.toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        // totalElement.textContent = `Total: R$ ${totalFormatado}`;
        
        // Atualiza a variável global para o faturamento
        window.fatTotalTreinamentos = total;
        
        // Comentado para não exibir o banner de totais
        // updateTotalBanner(total);
        
        // Atualiza o faturamento
        if (typeof fatAtualizarTotais === 'function') {
          fatAtualizarTotais();
        }
      }

      function gravar_treinamentos_selecionados()
      {
        if(window.recebe_acao && window.recebe_acao === "editar")
        {
          $.ajax({
              url: "cadastros/processa_geracao_kit.php",
              type: "POST",
              dataType: "json",
              data: {
                processo_geracao_kit: "atualizar_kit",
                valor_treinamentos: json_cursos_selecionados,
                valor_id_kit:window.recebe_id_kit
              },
              success: function (retorno_exame_geracao_kit) {
                debugger;

                const mensagemSucesso = `
                  <div id="treinamento-gravado" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
                    <div style="display: flex; align-items: center; justify-content: center;">
                      <div>
                        <div>KIT atualizado com sucesso.</div>
                      </div>
                    </div>
                  </div>
                `;

                // Remove mensagem anterior se existir
                $("#treinamento-gravado").remove();

                // Adiciona a nova mensagem acima das abas
                $(".tabs-container").before(mensagemSucesso);

                // Configura o fade out após 5 segundos
                setTimeout(function () {
                  $("#treinamento-gravado").fadeOut(500, function () {
                    $(this).remove();
                  });
                }, 5000);

                console.log(retorno_exame_geracao_kit);
                // Atualiza snapshot persistido após sucesso
                try {
                  if (Array.isArray(riscos_selecionados)) {
                    window.riscosEstadoSalvoCodes = riscos_selecionados.map(r => String(r.codigo));
                  }
                  window._riscosDirty = false;
                } catch (e) { /* ignore */ }
                
                resolve(retorno_exame_geracao_kit);
              },
              error: function (xhr, status, error) {
                console.log("Falha ao incluir exame: " + error);
                reject(error);
              },
            });
        }else{
          return new Promise((resolve, reject) => {
            $.ajax({
              url: "cadastros/processa_geracao_kit.php",
              type: "POST",
              dataType: "json",
              data: {
                processo_geracao_kit: "incluir_valores_kit",
                valor_treinamentos: json_cursos_selecionados,
              },
              success: function (retorno_exame_geracao_kit) {
                debugger;

                const mensagemSucesso = `
                  <div id="treinamento-gravado" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
                    <div style="display: flex; align-items: center; justify-content: center;">
                      <div>
                        <div>KIT atualizado com sucesso.</div>
                      </div>
                    </div>
                  </div>
                `;

                // Remove mensagem anterior se existir
                $("#treinamento-gravado").remove();

                // Adiciona a nova mensagem acima das abas
                $(".tabs-container").before(mensagemSucesso);

                // Configura o fade out após 5 segundos
                setTimeout(function () {
                  $("#treinamento-gravado").fadeOut(500, function () {
                    $(this).remove();
                  });
                }, 5000);

                console.log(retorno_exame_geracao_kit);
                // Atualiza snapshot persistido após sucesso
                try {
                  if (Array.isArray(riscos_selecionados)) {
                    window.riscosEstadoSalvoCodes = riscos_selecionados.map(r => String(r.codigo));
                  }
                  window._riscosDirty = false;
                } catch (e) { /* ignore */ }
                
                resolve(retorno_exame_geracao_kit);
              },
              error: function (xhr, status, error) {
                console.log("Falha ao incluir exame: " + error);
                reject(error);
              },
            });
          });
        }
      }

      // Salva imediatamente o estado ATUAL dos treinamentos selecionados (persistência no PHP)
      async function salvarTreinamentosSelecionadosEstadoAtual() {
        debugger;
        try {
          // Garante que o estado temporário está sincronizado com o DOM
          if (typeof syncTempSelecionadosFromDOM === 'function') syncTempSelecionadosFromDOM();
          const listaAtual = Array.isArray(window.treinamentosSelecionados) ? window.treinamentosSelecionados : [];
          // Reaproveita a mesma variável utilizada pela função de gravação
          json_cursos_selecionados = JSON.stringify(listaAtual);
        } catch (e) {
          console.warn('Falha ao preparar JSON de treinamentos para salvar imediatamente:', e);
        }
        // Chama o mesmo endpoint já usado no botão Aplicar
        return gravar_treinamentos_selecionados();
      }

      // Liga eventos do botão Aplicar e da lista de treinamentos
      function setupEventListeners() {
        debugger;
        // Sempre resolve elementos mais recentes do DOM (após render)
        const btnAplicar = document.getElementById('btnAplicarTreinamentos');
        const listaTreinamentos = document.getElementById('listaTreinamentos');

        // Handler preferencial: salvar apenas ao aplicar; fallback mantém compatibilidade
        const handlerAplicar = (typeof atualizarSelecionadosTreinamentos === 'function')
          ? atualizarSelecionadosTreinamentos
          : (typeof atualizarSelecionados === 'function' ? atualizarSelecionados : null);

        if (btnAplicar && handlerAplicar) {
          // Evita duplicação simples
          btnAplicar.replaceWith(btnAplicar.cloneNode(true));
          const novoBtn = document.getElementById('btnAplicarTreinamentos');
          if (novoBtn) novoBtn.addEventListener('click', (e) => { debugger; handlerAplicar(e); });
        }

        if (listaTreinamentos) {
          // Clique na linha alterna o checkbox
          listaTreinamentos.addEventListener('click', (e) => {
            // Se o clique foi diretamente no checkbox, não faça nada aqui
            if (e.target && e.target.matches('input[type="checkbox"]')) return;
            const item = e.target.closest('.treinamento-item');
            if (item) {
              const checkbox = item.querySelector('input[type="checkbox"]');
              if (checkbox) {
                // Alterna visualmente e dispara apenas UM ciclo via evento change
                checkbox.checked = !checkbox.checked;
                // Deixe a sincronização para o handler de 'change'
                const evt = new Event('change', { bubbles: true });
                checkbox.dispatchEvent(evt);
              }
            }
          });

          // Mudança direta no checkbox
          listaTreinamentos.addEventListener('change', (e) => {
            if (e.target && e.target.matches('input[type="checkbox"]')) {
              // debugger;
              window.treinamentosJaMarcados = true;
              if (typeof syncTempSelecionadosFromDOM === 'function') syncTempSelecionadosFromDOM();
              if (typeof rebuildSelecionadosUIFromChecked === 'function') rebuildSelecionadosUIFromChecked();
            }
          });
        }

        // Remoção via ícone de lixeira no painel de selecionados (agora PERSISTE imediatamente)
        const selecionadosContainer = document.getElementById('treinamentosSelecionados');
        if (selecionadosContainer) {
          selecionadosContainer.addEventListener('click', async (e) => {
            debugger;
            const btn = e.target.closest('[data-acao="remover-treinamento"]');
            if (!btn) return;
            e.preventDefault();
            const codigo = String(btn.getAttribute('data-codigo') || '');
            const cb = document.querySelector('#listaTreinamentos input[type="checkbox"][value="' + codigo + '"]');
            if (cb) {
              cb.checked = false;
              // Atualiza estados temporários e reconstrói painel/total
              if (typeof syncTempSelecionadosFromDOM === 'function') syncTempSelecionadosFromDOM();
              if (typeof rebuildSelecionadosUIFromChecked === 'function') rebuildSelecionadosUIFromChecked();
              // Persiste imediatamente no backend (PHP)
              debugger;
              try {
                await salvarTreinamentosSelecionadosEstadoAtual();
              } catch (err) {
                console.error('Falha ao salvar remoção de treinamento imediatamente:', err);
              }
            }
          });
        }
      }

      // Inicialização
      function init() {
        renderizarTreinamentos();
        // Garante formato correto antes de manipular
        window.treinamentosSelecionados = normalizeTreinamentosSelecionados(window.treinamentosSelecionados);
        // Ao entrar na aba, re-aplica o que estava marcado e reconstrói o painel
        reaplicarSelecoes();
        rebuildSelecionadosUIFromChecked();
        setupEventListeners();
        createTotalBanner(); // Cria o banner de totais ao carregar a página
      }

      return { init };
    }

    // Gerenciar o status de motorista
    function updateMotoristaStatus(isMotorista) {
      debugger;

      console.log("Verificando motorista:",isMotorista);

      let recebe_motorista;

      if(isMotorista)
      {
        grava_motorista_kit("SIM");
      }else{
        grava_motorista_kit("NAO");
      }

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

    function grava_motorista_kit(valor)
    {
      if(window.recebe_acao && window.recebe_acao === "editar")
        {
          $.ajax({
          url: "cadastros/processa_geracao_kit.php",
          type: "POST",
          dataType: "json",
          data: {
            processo_geracao_kit: "atualizar_kit",
            valor_motorista: valor,
            valor_id_kit:window.recebe_id_kit
          },
          success: function(retorno_exame_geracao_kit) {
            debugger;

            const mensagemSucesso = `
                  <div id="motorista-gravado" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
                    <div style="display: flex; align-items: center; justify-content: center;">
                      
                      <div>
                        
                        <div>KIT atualizado com sucesso.</div>
                      </div>
                    </div>
                  </div>
            `;

            // Remove mensagem anterior se existir
            $("#motorista-gravado").remove();
                
            // Adiciona a nova mensagem acima das abas
            $(".tabs-container").before(mensagemSucesso);

            // Configura o fade out após 5 segundos
            setTimeout(function() {
              $("#motorista-gravado").fadeOut(500, function() {
              $(this).remove();
              });
            }, 5000);


            // $("#exame-gravado").html(retorno_exame_geracao_kit);
            // $("#exame-gravado").show();
            // $("#exame-gravado").fadeOut(4000);
            console.log(retorno_exame_geracao_kit);
            // ajaxEmExecucao = false; // libera para nova requisição
          },
          error: function(xhr, status, error) {
            console.log("Falha ao incluir exame: " + error);
            // ajaxEmExecucao = false; // libera para tentar de novo
          },
        });
        }else{
          $.ajax({
          url: "cadastros/processa_geracao_kit.php",
          type: "POST",
          dataType: "json",
          data: {
            processo_geracao_kit: "incluir_valores_kit",
            valor_motorista: valor,
          },
          success: function(retorno_exame_geracao_kit) {
            debugger;

            const mensagemSucesso = `
                  <div id="motorista-gravado" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
                    <div style="display: flex; align-items: center; justify-content: center;">
                      
                      <div>
                        
                        <div>KIT atualizado com sucesso.</div>
                      </div>
                    </div>
                  </div>
            `;

            // Remove mensagem anterior se existir
            $("#motorista-gravado").remove();
                
            // Adiciona a nova mensagem acima das abas
            $(".tabs-container").before(mensagemSucesso);

            // Configura o fade out após 5 segundos
            setTimeout(function() {
              $("#motorista-gravado").fadeOut(500, function() {
              $(this).remove();
              });
            }, 5000);


            // $("#exame-gravado").html(retorno_exame_geracao_kit);
            // $("#exame-gravado").show();
            // $("#exame-gravado").fadeOut(4000);
            console.log(retorno_exame_geracao_kit);
            // ajaxEmExecucao = false; // libera para nova requisição
          },
          error: function(xhr, status, error) {
            console.log("Falha ao incluir exame: " + error);
            // ajaxEmExecucao = false; // libera para tentar de novo
          },
        });
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
          // Re-inicializa sempre que a aba for clicada; os handlers internos deduplicam binds
          setTimeout(() => {
            const treinamentos = gerenciarTreinamentos();
            if (treinamentos && typeof treinamentos.init === 'function') {
              treinamentos.init();
            }
          }, 100);
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
        
       

        <!-- Seção de Conta Bancária -->
          <div class="sm-container" style="margin-top: 40px; margin-bottom: 2rem;">
            <h2 style="font-size: 24px; font-weight: 500; color: #111; margin-bottom: 20px;">Conta Bancária</h2>
            <div style="background: white; border-radius: 0.75rem; border: 1px solid #e5e7eb; padding: 1.5rem;">
              <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(230px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
                <!-- QR Code -->
                <label class="conta-bancaria-label">
                  <input type="checkbox" name="tipo-conta" class="conta-bancaria" value="qrcode">
                  <div class="conta-bancaria-card">
                    <i class="fas fa-qrcode"></i>
                    <span>QR Code</span>
                  </div>
                </label>
                
                <!-- Agência e Conta -->
                <label class="conta-bancaria-label">
                  <input type="checkbox" name="tipo-conta" class="conta-bancaria" value="agencia-conta">
                  <div class="conta-bancaria-card">
                    <i class="fas fa-university"></i>
                    <span>Agência e Conta</span>
                  </div>
                </label>
                
                <!-- PIX -->
                <label class="conta-bancaria-label">
                  <input type="checkbox" name="tipo-conta" class="conta-bancaria" value="pix">
                  <div class="conta-bancaria-card">
                    <i class="fas fa-mobile-alt"></i>
                    <span>PIX</span>
                  </div>
                </label>
              </div>
              
              <!-- Seletor de Chave PIX -->
              <div id="pix-selector-container" style="display: none; margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #e5e7eb;">
                <div style="display: flex; gap: 1rem; align-items: center;">
                  <div style="flex: 1;">
                    <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">Chave PIX</label>
                    <select id="pix-key-select" class="form-control" style="width: 100%; height: 40px; padding: 8px 12px; border: 1px solid #e5e7eb; border-radius: 8px; background: #ffffff; color: #111827; box-shadow: 0 1px 2px rgba(0,0,0,0.03);">
                      <option value="">Selecione uma chave PIX</option>
                    </select>
                  </div>
                  <button type="button" id="btn-adicionar-pix" class="btn btn-primary" style="margin-top: 1.5rem; padding: 0.5rem 1rem; border: none; border-radius: 0.375rem; background-color: #3b82f6; color: white; cursor: pointer; font-weight: 500; display: inline-flex; align-items: center; gap: 0.5rem; white-space: nowrap;">
                    <i class="fas fa-plus"></i> Adicionar Chave PIX
                  </button>
                </div>
              </div>
              
              <!-- Modal de Cadastro Rápido de Conta -->
              <div id="modal-conta-bancaria" class="modal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);">
                <div style="background-color: #fefefe; margin: 5% auto; padding: 20px; border: 1px solid #888; width: 90%; max-width: 500px; border-radius: 8px;">
                  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px solid #eee;">
                    <h3 style="margin: 0;">Cadastrar PIX</h3>
                    <span class="close" style="font-size: 24px; cursor: pointer;">&times;</span>
                  </div>
                  <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 500;">Tipo de Chave PIX</label>
                    <select id="tipo-chave" class="form-control" style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 4px; font-size: 14px; margin-bottom: 15px;">
                      <option value="cpf">CPF</option>
                      <option value="email">E-mail</option>
                      <option value="telefone">Telefone</option>
                      <option value="aleatoria">Chave Aleatória</option>
                    </select>
                  </div>
                  <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 500;">Chave PIX</label>
                    <input type="text" id="chave-pix" class="form-control" placeholder="Sua chave PIX" style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 4px; font-size: 14px;">
                  </div>
                  <div style="display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" id="btn-cancelar" class="btn btn-secondary" style="padding: 8px 16px; border: none; border-radius: 4px; background-color: #e5e7eb; color: #374151; cursor: pointer; font-weight: 500;">Cancelar</button>
                    <button type="button" id="btn-salvar-conta" class="btn btn-primary" style="padding: 8px 16px; border: none; border-radius: 4px; background-color: #3b82f6; color: white; cursor: pointer; font-weight: 500;">Salvar Conta</button>
                  </div>
                </div>
              </div>
              
              <!-- Seletor de Agência/Conta -->
              <div id="agencia-selector-container" style="display: none; margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #e5e7eb;">
                <div style="display: flex; gap: 1rem; align-items: center;">
                  <div style="flex: 1;">
                    <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">Agência e Conta</label>
                    <select id="agencia-conta-select" class="form-control" style="width: 100%; height: 40px; padding: 8px 12px; border: 1px solid #e5e7eb; border-radius: 8px; background: #ffffff; color: #111827; box-shadow: 0 1px 2px rgba(0,0,0,0.03);">
                      <option value="">Selecione uma Agência/Conta</option>
                    </select>
                  </div>
                  <button type="button" id="btn-adicionar-agencia-conta" class="btn btn-primary" style="margin-top: 1.5rem; padding: 0.5rem 1rem; border: none; border-radius: 0.375rem; background-color: #3b82f6; color: white; cursor: pointer; font-weight: 500; display: inline-flex; align-items: center; gap: 0.5rem; white-space: nowrap;">
                    <i class="fas fa-plus"></i> Adicionar Agência/Conta
                  </button>
                </div>
              </div>

              <!-- Modal de Cadastro Rápido de Agência/Conta -->
              <div id="modal-agencia-conta" class="modal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);">
                <div style="background-color: #fefefe; margin: 5% auto; padding: 20px; border: 1px solid #888; width: 90%; max-width: 500px; border-radius: 8px;">
                  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px solid #eee;">
                    <h3 style="margin: 0;">Cadastrar Agência/Conta</h3>
                    <span class="close-agencia" style="font-size: 24px; cursor: pointer;">&times;</span>
                  </div>
                  <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                      <label style="display: block; margin-bottom: 5px; font-weight: 500;">Agência</label>
                      <input type="text" id="agencia-rapida" class="form-control" placeholder="Número da Agência" style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                      <label style="display: block; margin-bottom: 5px; font-weight: 500;">Conta</label>
                      <input type="text" id="conta-rapida" class="form-control" placeholder="Número da Conta" style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 4px; font-size: 14px;">
                    </div>
                  </div>
                  <div style="display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" id="btn-cancelar-agencia" class="btn btn-secondary" style="padding: 8px 16px; border: none; border-radius: 4px; background-color: #e5e7eb; color: #374151; cursor: pointer; font-weight: 500;">Cancelar</button>
                    <button type="button" id="btn-salvar-agencia" class="btn btn-primary" style="padding: 8px 16px; border: none; border-radius: 4px; background-color: #3b82f6; color: white; cursor: pointer; font-weight: 500;">Salvar</button>
                  </div>
                </div>
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

            <!-- Audiometria -->
            <label class="sm-label">
              <input type="checkbox" class="sm-checkbox">
              <div class="sm-card">
                <i class="fas fa-assistive-listening-systems"></i>
                <span>Audiometria</span>
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

            <!-- Teste de Romberg -->
            <label class="sm-label">
              <input type="checkbox" class="sm-checkbox">
              <div class="sm-card">
                <i class="fas fa-shoe-prints"></i>
                <span>Teste de Romberg</span>
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
            
            /* Estilos para a seção de Conta Bancária */
            .conta-bancaria-label {
              display: block;
              cursor: pointer;
              margin: 0;
              transition: transform 0.2s ease;
            }
            .conta-bancaria {
              position: absolute;
              opacity: 0;
              height: 0;
              width: 0;
            }
            .conta-bancaria-card {
              display: flex;
              flex-direction: column;
              align-items: center;
              justify-content: center;
              gap: 0.75rem;
              padding: 1.5rem 1rem;
              border: 1px solid #e5e7eb;
              border-radius: 0.5rem;
              background: white;
              transition: all 0.2s ease;
              height: 100%;
              text-align: center;
            }
            .conta-bancaria-card i {
              font-size: 1.75rem;
              color: #3b82f6;
              transition: all 0.2s ease;
            }
            .conta-bancaria-card span {
              font-size: 0.9375rem;
              font-weight: 500;
              color: #374151;
            }
            .conta-bancaria:checked + .conta-bancaria-card {
              border-color: #3b82f6;
              background-color: #f0f7ff;
              box-shadow: 0 0 0 1px #3b82f6;
            }
            .conta-bancaria:focus + .conta-bancaria-card {
              box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
            }
            .conta-bancaria-card:hover {
              transform: translateY(-2px);
              box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            }
            .conta-bancaria:checked + .conta-bancaria-card i {
              transform: scale(1.1);
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
        </div>`]


// ============================================================
// 🔹 Associação de eventos — apenas clique real do usuário
// ============================================================
tipoContaInputs.forEach(input => {
  // Remove eventuais listeners antigos (segurança)
  input.replaceWith(input.cloneNode(true));
});

document.querySelectorAll('input[name="tipo-conta"]').forEach(input => {
  debugger;
  input.addEventListener('click', function () {
    // 🚫 Se estiver carregando aba, ignora
    if (window._carregandoAbaBancaria) {
      console.log('⏸️ Clique ignorado — aba bancária ainda carregando.');
      return;
    }

    // ✅ Chama tratamento somente em clique do usuário
    tratarSelecaoTipoBancario(this);
  });
});

// Script para controle da seção de Conta Bancária
document.addEventListener('DOMContentLoaded', function() {
  debugger;
  // Elementos da interface
  const tipoContaInputs = document.querySelectorAll('input[name="tipo-conta"]');
  const pixSelectorContainer = document.getElementById('pix-selector-container');
  const btnAdicionarPix = document.getElementById('btn-adicionar-pix');
  const btnAdicionarPixOutside = document.getElementById('btn-adicionar-pix-outside');
  const modalContaBancaria = document.getElementById('modal-conta-bancaria');
  const btnCancelar = document.getElementById('btn-cancelar');
  const btnSalvarConta = document.getElementById('btn-salvar-conta');
  const closeModal = document.querySelector('.close');

  // A gravação agora ocorre somente no clique/troca (listener de change abaixo)

  function gravar_tipo_dado_bancario(tipo_dado_bancario) {
      debugger;
      if(window.recebe_acao && window.recebe_acao === "editar")
        {
          try {
        console.group('Conta Bancária > gravar_tipo_dado_bancario');
        console.log('Valor recebido para gravação:', tipo_dado_bancario);
        console.groupEnd();
      } catch (e) { /* noop */ }
      $.ajax({
        url: "cadastros/processa_geracao_kit.php",
        type: "POST",
        dataType: "json",
        async: false,
        beforeSend: function() {
          try {
            console.group('AJAX > inclusão valor kit (beforeSend)');
            console.log('Processo:', 'atualizar_kit');
            console.log('valor_tipo_dado_bancario:', tipo_dado_bancario);
            console.groupEnd();
          } catch(e) { /* noop */ }
        },
        data: {
          processo_geracao_kit: "atualizar_kit",
          valor_tipo_dado_bancario: tipo_dado_bancario,
          valor_id_kit:window.recebe_id_kit
        },
        success: function(retorno_exame_geracao_kit) {
          debugger;
          try {
            console.group('AJAX > sucesso inclusão valor kit');
            console.log('Retorno:', retorno_exame_geracao_kit);
            console.groupEnd();
          } catch(e) { /* noop */ }

          const mensagemSucesso = `
                <div id="exame-gravado" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
                  <div style="display: flex; align-items: center; justify-content: center;">
                    
                    <div>
                      
                      <div>Exame cadastrado com sucesso.</div>
                    </div>
                  </div>
                </div>
          `;

          // Remove mensagem anterior se existir
          $("#exame-gravado").remove();
              
          // Adiciona a nova mensagem acima das abas
          $(".tabs-container").before(mensagemSucesso);

          // Configura o fade out após 5 segundos
          setTimeout(function() {
            $("#exame-gravado").fadeOut(500, function() {
            $(this).remove();
            });
          }, 5000);


          $("#exame-gravado").html(retorno_exame_geracao_kit);
          $("#exame-gravado").show();
          $("#exame-gravado").fadeOut(4000);
          console.log(retorno_exame_geracao_kit);
          ajaxEmExecucao = false; // libera para nova requisição
        },
        error: function(xhr, status, error) {
          console.log("Falha ao incluir exame: " + error);
          ajaxEmExecucao = false; // libera para tentar de novo
        },
        complete: function() {
          try {
            console.log('AJAX > inclusão valor kit finalizado');
          } catch(e) { /* noop */ }
        }
      });
        }else{
try {
        console.group('Conta Bancária > gravar_tipo_dado_bancario');
        console.log('Valor recebido para gravação:', tipo_dado_bancario);
        console.groupEnd();
      } catch (e) { /* noop */ }
      $.ajax({
        url: "cadastros/processa_geracao_kit.php",
        type: "POST",
        dataType: "json",
        async: false,
        beforeSend: function() {
          try {
            console.group('AJAX > inclusão valor kit (beforeSend)');
            console.log('Processo:', 'incluir_valores_kit');
            console.log('valor_tipo_dado_bancario:', tipo_dado_bancario);
            console.groupEnd();
          } catch(e) { /* noop */ }
        },
        data: {
          processo_geracao_kit: "incluir_valores_kit",
          valor_tipo_dado_bancario: tipo_dado_bancario,
        },
        success: function(retorno_exame_geracao_kit) {
          debugger;
          try {
            console.group('AJAX > sucesso inclusão valor kit');
            console.log('Retorno:', retorno_exame_geracao_kit);
            console.groupEnd();
          } catch(e) { /* noop */ }

          const mensagemSucesso = `
                <div id="exame-gravado" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
                  <div style="display: flex; align-items: center; justify-content: center;">
                    
                    <div>
                      
                      <div>Exame cadastrado com sucesso.</div>
                    </div>
                  </div>
                </div>
          `;

          // Remove mensagem anterior se existir
          $("#exame-gravado").remove();
              
          // Adiciona a nova mensagem acima das abas
          $(".tabs-container").before(mensagemSucesso);

          // Configura o fade out após 5 segundos
          setTimeout(function() {
            $("#exame-gravado").fadeOut(500, function() {
            $(this).remove();
            });
          }, 5000);


          $("#exame-gravado").html(retorno_exame_geracao_kit);
          $("#exame-gravado").show();
          $("#exame-gravado").fadeOut(4000);
          console.log(retorno_exame_geracao_kit);
          ajaxEmExecucao = false; // libera para nova requisição
        },
        error: function(xhr, status, error) {
          console.log("Falha ao incluir exame: " + error);
          ajaxEmExecucao = false; // libera para tentar de novo
        },
        complete: function() {
          try {
            console.log('AJAX > inclusão valor kit finalizado');
          } catch(e) { /* noop */ }
        }
      });
        }
    }
  
  // Verificar se o tipo PIX já está selecionado ao carregar a página
  const pixRadio = document.querySelector('input[value="pix"]');
  if (pixRadio && pixRadio.checked && pixSelectorContainer) {
    pixSelectorContainer.style.display = 'block';
  }
  
  // Mostrar/ocultar seletor de chave PIX quando PIX for selecionado
  // Modifique o evento change dos inputs de tipo de conta
tipoContaInputs.forEach(input => {
  debugger;
    input.addEventListener('change', function() {
      debugger;
        const tipo = this.value;
        const estaMarcado = this.checked;
        
        // Atualiza o estado global
        if (tipo === 'pix' && estaMarcado) {
            atualizarEstadoBancario('pix', null, null);
        } else if (tipo === 'agencia-conta' && estaMarcado) {
            atualizarEstadoBancario('agencia-conta', null, null);
        } else if (tipo === 'qrcode') {
            atualizarEstadoBancario('qrcode', estaMarcado, null);
        }

        // Verifica se algum checkbox de PIX está marcado
        if (pixSelectorContainer) {
            const algumPixMarcado = Array.from(tipoContaInputs).some(i => i.value === 'pix' && i.checked);
            pixSelectorContainer.style.display = algumPixMarcado ? 'block' : 'none';
        }

        try {
            console.group('Conta Bancária > tipo-conta change');
            console.log('Input clicado:', this);
            console.log('Valor selecionado:', this.value);
            console.groupEnd();
        } catch (e) { /* noop */ }

        // Grava imediatamente todas as opções selecionadas como array JSON
        const selecionados = Array.from(tipoContaInputs)
            .filter(i => i.checked)
            .map(i => i.value);
        
        // Atualiza o estado global com os tipos selecionados
        if (selecionados.includes('pix')) {
            atualizarEstadoBancario('pix', window.dadosBancariosEstado.chavePix, window.dadosBancariosEstado.textoPix);
        }
        if (selecionados.includes('agencia-conta')) {
            atualizarEstadoBancario('agencia-conta', window.dadosBancariosEstado.agenciaConta, window.dadosBancariosEstado.textoAgenciaConta);
        }
        if (selecionados.includes('qrcode')) {
            atualizarEstadoBancario('qrcode', true, null);
        }

        //gravar_tipo_dado_bancario(JSON.stringify(selecionados));
    });
});
  
  // Função para abrir o modal de cadastro de chave PIX
  function abrirModalChavePix() {
    if (modalContaBancaria) {
      // Marcar o radio de PIX se ainda não estiver marcado
      const radioPix = document.querySelector('input[value="pix"]');
      if (radioPix && !radioPix.checked) {
        radioPix.checked = true;
        // Disparar evento de mudança para mostrar o seletor de chave PIX
        const event = new Event('change');
        radioPix.dispatchEvent(event);
      }
      
      // Mostrar o modal
      modalContaBancaria.style.display = 'block';
      
      // Focar no primeiro campo do modal
      const primeiroCampo = document.getElementById('banco');
      if (primeiroCampo) primeiroCampo.focus();
    }
  }
  
  // Abrir modal ao clicar em Adicionar chave PIX (dentro da seção de PIX)
  if (btnAdicionarPix) {
    btnAdicionarPix.addEventListener('click', abrirModalChavePix);
  }
  
  // Abrir modal ao clicar em Adicionar Chave PIX (botão fora da seção)
  if (btnAdicionarPixOutside) {
    btnAdicionarPixOutside.addEventListener('click', abrirModalChavePix);
  }
  
  // Fechar modal
  function closeModalFunc() {
    if (modalContaBancaria) {
      modalContaBancaria.style.display = 'none';
    }
  }
  
  if (closeModal) {
    closeModal.addEventListener('click', closeModalFunc);
  }
  
  if (btnCancelar) {
    btnCancelar.addEventListener('click', closeModalFunc);
  }
  
  // Fechar modal ao clicar fora dele
  window.addEventListener('click', function(event) {
    if (event.target === modalContaBancaria) {
      closeModalFunc();
    }
  });
  
  // Fechar modal com a tecla ESC
  document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape' && modalContaBancaria && modalContaBancaria.style.display === 'block') {
      closeModalFunc();
    }
  });
  
  // Salvar nova conta
  if (btnSalvarConta) {
    btnSalvarConta.addEventListener('click', function() {
      debugger;
      const banco = document.getElementById('banco')?.value || '';
      const agencia = document.getElementById('agencia')?.value || '';
      const conta = document.getElementById('conta')?.value || '';
      const tipoChaveSelect = document.getElementById('tipo-chave');
      const tipoChave = tipoChaveSelect ? tipoChaveSelect.value : '';
      const chavePix = document.getElementById('chave-pix')?.value || '';
      const pixKeySelect = document.getElementById('pix-key-select');
      // Logs estruturados para depuração
      try {
        const payload = {
          banco,
          agencia,
          conta,
          tipoChave,
          chavePix,
          pixKeySelectExists: !!pixKeySelect,
          pixOptionsCount: pixKeySelect ? pixKeySelect.options.length : 0
        };
        window.__pixDebugPayload = payload; // disponível no console para inspeção
        console.group('PIX > Salvar nova conta - Payload recebido');
        console.table(payload);
        console.log('Elementos brutos:', {
          bancoEl: document.getElementById('banco'),
          agenciaEl: document.getElementById('agencia'),
          contaEl: document.getElementById('conta'),
          tipoChaveSelect,
          chavePixEl: document.getElementById('chave-pix'),
          pixKeySelect
        });
        console.groupEnd();
      } catch(e) { console.warn('Falha ao logar payload PIX:', e); }
      debugger;
      // Validação básica
      if (!chavePix) {
        alert('Por favor, preencha todos os campos obrigatórios.');
        return;
      }
      
      // Validação do tipo de chave PIX
      if (!tipoChave) {
        alert('Por favor, selecione o tipo de chave PIX.');
        return;
      }
      
      // Adiciona a opção ao select
      if (pixKeySelect) {
        // Verifica se a chave já existe
        const chaveExistente = Array.from(pixKeySelect.options).some(
          option => option.value === chavePix
        );
        
        if (chaveExistente) {
          alert('Esta chave PIX já está cadastrada.');
          return;
        }
        
        const option = document.createElement('option');
        option.value = chavePix;
        // option.textContent = `${tipoChave.toUpperCase()}: ${chavePix} (${banco} - Ag ${agencia} C/C ${conta})`;
        option.textContent = `${tipoChave.toUpperCase()}: ${chavePix}`;
        pixKeySelect.appendChild(option);

        
        
        // Seleciona a opção recém-adicionada
        option.selected = true;
      }
      
      // Fecha o modal e limpa os campos
      closeModalFunc();
      
      // Limpa os campos
      const campos = ['banco', 'agencia', 'conta', 'chave-pix'];
      campos.forEach(id => {
        const campo = document.getElementById(id);
        if (campo) campo.value = '';
      });
      
      // Reseta o select de tipo de chave
      if (tipoChaveSelect) {
        tipoChaveSelect.value = 'cpf';
      }
      
      // Mostra mensagem de sucesso
      Swal.fire({
        title: 'Sucesso!',
        text: 'Conta cadastrada com sucesso!',
        icon: 'success',
        confirmButtonText: 'OK',
        confirmButtonColor: '#3b82f6'
      });
    });
  }
  
  // Carregar chaves PIX existentes (exemplo)
  function carregarChavesPix() {
    const pixKeySelect = document.getElementById('pix-key-select');
    if (!pixKeySelect) return;
    
    // Limpa as opções exceto a primeira
    while (pixKeySelect.options.length > 1) {
      pixKeySelect.remove(1);
    }
    
    // Exemplo de chaves PIX (substitua por dados reais do banco de dados)
    const chavesExemplo = [
      { tipo: 'CPF', chave: '123.456.789-00', banco: 'Banco do Brasil', agencia: '1234', conta: '56789-0' },
      { tipo: 'E-mail', chave: 'empresa@exemplo.com', banco: 'Itaú', agencia: '9876', conta: '12345-6' },
      { tipo: 'Telefone', chave: '(11) 99999-9999', banco: 'Bradesco', agencia: '4567', conta: '78901-2' }
    ];
    
    // Adiciona as chaves ao select
    chavesExemplo.forEach(chave => {
      const option = document.createElement('option');
      option.value = chave.chave;
      option.textContent = `${chave.tipo}: ${chave.chave} (${chave.banco} - Ag ${chave.agencia} C/C ${chave.conta})`;
      pixKeySelect.appendChild(option);
    });
  }
  
  // Carrega as chaves PIX ao carregar a página
  carregarChavesPix();

  if (document.getElementById('requer-assinatura')) {
    configurarEventoAssinatura();
  }

  $(document).on('change', '#requer-assinatura', function() {
  debugger;
    atualizarEstadoAssinatura($(this).is(':checked'));
});
});

// Adiciona o event listener para o checkbox de assinatura
function configurarEventoAssinatura() {
  debugger;
  const checkboxAssinatura = document.getElementById('requer-assinatura');
  
  // Remove event listeners anteriores para evitar duplicação
  const novoCheckbox = checkboxAssinatura.cloneNode(true);
  checkboxAssinatura.parentNode.replaceChild(novoCheckbox, checkboxAssinatura);
  
  // Adiciona o novo event listener
  novoCheckbox.addEventListener('change', function() {
    atualizarEstadoAssinatura(this.checked);
    console.log('Estado da assinatura alterado para:', this.checked);
  });
  
  return novoCheckbox;
}

// Chame esta função quando o DOM estiver pronto e quando a aba for carregada
document.addEventListener('DOMContentLoaded', function() {
  // Configura o evento uma vez quando a página carregar
  if (document.getElementById('requer-assinatura')) {
    configurarEventoAssinatura();
  }
});

function atualizarEstadoAssinatura(assinatura)
{
  debugger;
  window.assinaturaDigitalEstado = assinatura;
}

$(document).on('change', '#requer-assinatura', function() {
  debugger;
    atualizarEstadoAssinatura($(this).is(':checked'));
});



     // Função para atualizar a lista de selecionados
// function updateSelectedList() {
//   debugger;
//   if (window._smDocUpdating) return;
//   window._smDocUpdating = true;

//   try {
//     const selectedList = document.getElementById('sm-selected-list');
//     if (!selectedList) return;

//     // Salva os modelos de documentos selecionados
//     const modelosSelecionados = [];
//     document.querySelectorAll('.sm-label').forEach(label => {
//       const card = label.querySelector('.sm-card');
//       const checkbox = label.querySelector('input[type="checkbox"]');
//       if (card && checkbox && checkbox.checked) {
//         const text = card.querySelector('span')?.textContent?.trim();
//         if (text) {
//           modelosSelecionados.push(text);
//         }
//       }
//     });

//     // Salva os tipos de orçamento selecionados antes de limpar
//     const tiposOrcamentoSelecionados = [];
//     document.querySelectorAll('.tipo-orcamento-label').forEach(label => {
//       const card = label.querySelector('.tipo-orcamento-card');
//       const checkbox = label.querySelector('input[type="checkbox"]');
//       if (card && checkbox && checkbox.checked) {
//         const text = card.querySelector('span')?.textContent?.trim();
//         if (text) {
//           tiposOrcamentoSelecionados.push(text);
//         }
//       }
//     });

//     // Limpa a lista
//     selectedList.innerHTML = '';

//     // Atualiza o backup com os tipos de orçamento atualmente selecionados
//     // Atualiza os backups
//     window.smDocumentosSelecionadosBackup = [...new Set(tiposOrcamentoSelecionados)];
//     window.smModelosDocumentosSelecionados = [...new Set(modelosSelecionados)];

//     // Atualiza a lista global com os valores do backup
//     window.smDocumentosSelecionadosNomes = [...(window.smDocumentosSelecionadosBackup || [])];
//     // Zera array global
//     window.smDocumentosSelecionadosNomes = [];

//     // Seleciona documentos (.sm-label) e orçamentos (.tipo-orcamento-label)
//     const labels = document.querySelectorAll('.sm-label, .tipo-orcamento-label');

//     labels.forEach(label => {
//       const checkbox = label.querySelector('input[type="checkbox"]');
//       const card = label.querySelector('.sm-card, .tipo-orcamento-card');
//       const icon = card ? card.querySelector('i') : null;

//       if (checkbox && checkbox.checked && card) {
//         // Sempre armazena o nome no array global
//         const text = card.querySelector('span')?.textContent || '';
//         try { window.smDocumentosSelecionadosNomes.push(text.trim()); } catch (e) {}

//         // Identifica se é um item de orçamento
//         const isOrcamento = label.classList.contains('tipo-orcamento-label')
//           || (card && card.classList.contains('tipo-orcamento-card'));

//         // Se for orçamento, não renderiza no sm-selected-list (apenas armazena)
//         if (isOrcamento) {
//           return;
//         }

//         // Armazena no array apropriado
//         if (isOrcamento) {
//           try { 
//             window.smDocumentosSelecionadosNomes = [...new Set([...window.smDocumentosSelecionadosNomes || [], text.trim()])];
//           } catch (e) { console.error(e); }
//           return;
//         } else {
//           try {
//             window.smModelosDocumentosSelecionados = [...new Set([...window.smModelosDocumentosSelecionados || [], text.trim()])];
//           } catch (e) { console.error(e); }
//         }

//         // Renderização visual apenas para itens que não são orçamento
//         const selectedItem = document.createElement('div');
//         selectedItem.className = 'sm-selected-item';

//         let bgColor = '#f3f4f6';
//         let textColor = '#1f2937';

//         if (icon) {
//           if (icon.classList.contains('fa-paper-plane')) {
//             bgColor = '#dbeafe'; textColor = '#1e40af';
//           } else if (icon.classList.contains('fa-clipboard-list')) {
//             bgColor = '#d1fae5'; textColor = '#065f46';
//           } else if (icon.classList.contains('fa-file-medical')) {
//             bgColor = '#fef3c7'; textColor = '#92400e';
//           } else if (icon.classList.contains('fa-eye')) {
//             bgColor = '#fee2e2'; textColor = '#991b1b';
//           } else if (icon.classList.contains('fa-users')) {
//             bgColor = '#e0e7ff'; textColor = '#3730a3';
//           } else if (icon.classList.contains('fa-exclamation-triangle')) {
//             bgColor = '#fef3c7'; textColor = '#92400e';
//           } else if (icon.classList.contains('fa-file-alt')) {
//             bgColor = '#1e1b4b'; textColor = '#ffffff';
//           } else if (icon.classList.contains('fa-dollar-sign')) {
//             bgColor = '#ecfdf5'; textColor = '#065f46';
//           } else if (icon.classList.contains('fa-stethoscope')) {
//             bgColor = '#f3e8ff'; textColor = '#6d28d9';
//           } else if (icon.classList.contains('fa-graduation-cap')) {
//             bgColor = '#fff7ed'; textColor = '#9a3412';
//           } else if (icon.classList.contains('fa-hard-hat')) {
//             bgColor = '#fef9c3'; textColor = '#854d0e';
//           }
//         }

//         selectedItem.style.backgroundColor = bgColor;
//         selectedItem.style.color = textColor;

//         // Ícone
//         if (icon) {
//           const iconClone = icon.cloneNode(true);
//           iconClone.className = 'sm-selected-icon';
//           selectedItem.appendChild(iconClone);
//         }

//         // Texto
//         const textNode = document.createTextNode(text);

//         // Botão remover
//         const removeBtn = document.createElement('button');
//         removeBtn.className = 'remove-document';
//         removeBtn.innerHTML = '×';
//         removeBtn.title = 'Remover';
//         removeBtn.onclick = (e) => {
//           e.stopPropagation();
//           checkbox.checked = false;
//           window._smDocUpdating = false;
//           updateSelectedList();
//         };

//         selectedItem.appendChild(textNode);
//         selectedItem.appendChild(removeBtn);

//         selectedList.appendChild(selectedItem);
//       }
//     });

//     // Remove duplicatas
//     try { 
//       window.smDocumentosSelecionadosNomes = Array.from(new Set(window.smDocumentosSelecionadosNomes));
//     } catch (e) {}

//     // JSON global
//     window.smDocumentosSelecionadosJSON = JSON.stringify(window.smDocumentosSelecionadosNomes || []);

//     if (selectedList.children.length === 0) {
//       selectedList.innerHTML = '<p class="sm-empty-message">Nenhum item selecionado</p>';
//     }
//   } finally {
//     window._smDocUpdating = true;
//   }
// }

      
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
            // Libera a execução para esta nova interação do usuário
            window._smDocUpdating = false;
            updateSelectedList();
          });
        });
        
        // Permite clicar em qualquer lugar no label para alternar o checkbox
        document.querySelectorAll('.sm-label').forEach(label => {
          label.addEventListener('click', function(e) {
            const checkbox = this.querySelector('input[type="checkbox"]');
            if (checkbox && !e.target.closest('button')) {
              // Evita o clique nativo do label que também dispara change
              e.preventDefault();
              e.stopPropagation();
              checkbox.checked = !checkbox.checked;
              const event = new Event('change');
              checkbox.dispatchEvent(event);
            }
          });
        });
        
        // Inicializa a lista de selecionados
        // Garante que a primeira renderização ocorra
        window._smDocUpdating = false;
        updateSelectedList();
      }
      
      // Inicializador robusto para o componente de riscos
      // function tryInitRiscos() {
      //   const container = document.getElementById('selected-risks-container');
      //   if (!container) {
      //     // Aguarda até o container existir
      //     return setTimeout(tryInitRiscos, 100);
      //   }
      //   if (typeof window !== 'undefined' && typeof window.initializeRiscosComponent === 'function') {
      //     window.initializeRiscosComponent();
      //     console.log('initializeRiscosComponent chamado via tryInitRiscos');
      //   } else {
      //     console.error('initializeRiscosComponent não está disponível no window');
      //   }
      // }
      
      // Inicializa quando o DOM estiver pronto
      function initializeComponents() {
        initDocumentSelection();
        
        debugger;
        // Inicializa componentes específicos da aba atual
        if (appState.currentStep === 3) {
          // setTimeout(tryInitRiscos, 100);
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
          // setTimeout(tryInitRiscos, 100);
        } else if (e.detail.step === 4) { // Índice 4 = Passo 5 (Aptidões e Exames)
  setTimeout(() => {
    if (typeof initializeAptidoesExames === 'function') {
      initializeAptidoesExames();
    }
    // if (typeof repopular_aptidoes === 'function') {
    //   repopular_aptidoes();
    // }
  }, 100);
}
 else if (e.detail.step === 5) { // Índice 5 = Passo 6 (Documentos)
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

    // Define o array global para armazenar as aptidões
    window.aptDadosAptidoes = [];
    
    // Carrega as aptidões e exames quando o DOM estiver pronto
    document.addEventListener('DOMContentLoaded', function() {
      // Verifica se estamos na aba de aptidões e exames
      if (document.getElementById('apt-checkbox-container')) {
        carregar_aptidoes_extras();
        carregar_exames();
      }
    });
    
    function carregar_aptidoes_extras() {
      console.log('Iniciando carregamento de aptidões extras...');
      // Mostra um indicador de carregamento se o container existir
      const container = document.getElementById('apt-checkbox-container');
      if (container) {
        container.innerHTML = '<div style="padding: 20px; text-align: center; color: #666;">Carregando aptidões...</div>';
      } else {
        console.warn('Container de aptidões não encontrado no DOM');
      }
      
      console.log('Fazendo requisição AJAX para buscar aptidões...');
      $.ajax({
        url: "cadastros/processa_aptidao_extra.php",
        method: "GET",
        dataType: "json",
        data: {
            "processo_aptidao_extra": "busca_aptidao_extra"
        },
        success: function(resposta_aptidao) {
          console.log('Resposta bruta do servidor:', resposta_aptidao);
          debugger;
            try {
                // Verifica se a resposta é um array e tem itens
                if (Array.isArray(resposta_aptidao) && resposta_aptidao.length > 0) {
                    // Mapeia os dados da resposta para o formato esperado (sem o campo valor)
                    window.aptDadosAptidoes = resposta_aptidao.map(function(item) {
                        // Usa codigo_aptidao se existir, senão usa id como fallback
                        const codigo = item.codigo_aptidao !== undefined ? 
                            String(item.codigo_aptidao).trim() : 
                            (item.id ? String(item.id).trim() : "");
                            
                        return {
                            codigo: codigo,
                            nome: item.nome ? String(item.nome).trim() : ""
                        };
                    });
                    
                    // Filtra itens sem nome (caso existam)
                    window.aptDadosAptidoes = window.aptDadosAptidoes.filter(item => item.nome);
                    
                    console.log('Aptidões carregadas com sucesso:', window.aptDadosAptidoes);
                } else {
                    console.warn('Nenhuma aptidão encontrada ou formato de resposta inválido');
                    window.aptDadosAptidoes = []; // Garante que o array esteja vazio em caso de erro
                }
            } catch (error) {
                console.error('Erro ao processar as aptidões:', error);
                window.aptDadosAptidoes = [];
            } finally {
                // Inicializa o componente após carregar as aptidões
                if (typeof initializeAptidoesExames === 'function') {
                    initializeAptidoesExames();
                }
            }
        },
        error: function(xhr, status, error) {
          console.error('Erro ao carregar aptidões:', status, error);
          // Em caso de erro, limpa o array
          window.aptDadosAptidoes = [];
          
          // Tenta inicializar mesmo com erro
          if (typeof initializeAptidoesExames === 'function') {
            initializeAptidoesExames();
          }
        }
      });
    }

    function carregar_exames() {
      console.log('Iniciando carregamento de exames...');
      
      // Mostra um indicador de carregamento se o container existir
      const container = document.getElementById('apt-checkbox-container-exames');
      if (container) {
        container.innerHTML = '<div style="padding: 20px; text-align: center; color: #666;">Carregando exames...</div>';
      } else {
        console.warn('Container de exames não encontrado no DOM');
      }
      
      console.log('Fazendo requisição AJAX para buscar exames...');
      
      // // Dados de exemplo para fallback
      // const examesFallback = [
      //   { codigo: "0068", nome: "Acetilcolinesterase eritrocitária", recebe_apenas_nome: "Acetilcolinesterase eritrocitária" },
      //   { codigo: "0109", nome: "Ácido hipúrico", recebe_apenas_nome: "Ácido hipúrico" },
      //   { codigo: "0116", nome: "Ácido Metil Hipúrico", recebe_apenas_nome: "Ácido Metil Hipúrico" },
      //   { codigo: "0130", nome: "Ácido Trans-Transmucônico", recebe_apenas_nome: "Ácido Trans-Transmucônico" },
      //   { codigo: "9999", nome: "Outros procedimentos diagnósticos não descritos anteriormente", recebe_apenas_nome: "Outros procedimentos diagnósticos não descritos anteriormente" }
      // ];
      
      // Tenta carregar os exames do servidor
      $.ajax({
        url: 'cadastros/processa_exames_procedimentos.php',
        type: 'GET',
        dataType: 'json',
        data: {
          processo_exame_procedimento: 'buscar_exames_procedimentos'
        },
        success: function(response) {
          debugger;
          console.log('Resposta bruta do servidor (exames):', response);
          
          try {
            // Verifica se a resposta é um array e tem itens
            if (Array.isArray(response) && response.length > 0) {
              // Mapeia os dados da resposta para o formato esperado
              window.aptDadosExames = response.map(function(item) {
                debugger;
                return {
                  codigo: item.codigo ? String(item.codigo).trim() : '',
                  nome: item.procedimento ? String(item.procedimento).trim() : '',
                  valor:item.valor,
                  // recebe_apenas_nome: item.nome ? String(item.nome).trim() : ''
                };
              });
              
              // Filtra itens sem nome (caso existam)
              window.aptDadosExames = window.aptDadosExames.filter(item => item.nome);
              
              console.log('Exames carregados com sucesso:', window.aptDadosExames);
              
              // Se não encontrou exames válidos, usa o fallback
              if (window.aptDadosExames.length === 0) {
                console.warn('Nenhum exame válido encontrado, usando dados de exemplo');
                window.aptDadosExames = examesFallback.map(item => ({ ...item }));
              }
            } else {
              console.warn('Nenhum exame encontrado ou formato de resposta inválido');
              window.aptDadosExames = examesFallback.map(item => ({ ...item }));
            }
          } catch (error) {
            console.error('Erro ao processar os exames:', error);
            window.aptDadosExames = examesFallback.map(item => ({ ...item }));
          } finally {
            // Inicializa o componente após carregar os exames
            if (typeof initializeAptidoesExames === 'function') {
              console.log('Chamando initializeAptidoesExames após carregar exames');
              initializeAptidoesExames();
            } else {
              console.warn('Função initializeAptidoesExames não encontrada');
            }
          }
        },
        error: function(xhr, status, error) {
          console.error('Erro ao carregar exames:', status, error);
          // Em caso de erro, usa os dados de fallback
          window.aptDadosExames = examesFallback.map(item => ({ ...item }));
          
          // Tenta inicializar mesmo com erro
          if (typeof initializeAptidoesExames === 'function') {
            initializeAptidoesExames();
          }
        }
      });
    }

    let aptExamesSelecionados = [];
    let aptAptidoesSelecionadas = [];
    
    // Função para inicializar o componente de Aptidões e Exames com checkboxes
    function initializeAptidoesExames() {
      debugger;
      // carregar_exames();
      console.log('Inicializando componente de Aptidões e Exames...');
      console.log('Dados de aptidões disponíveis (window.aptDadosAptidoes):', window.aptDadosAptidoes);
      
      // Dados de exemplo (mantidos como fallback)
      // const dadosExemploAptidoes = [
      //   { codigo: "0000", nome: "Trabalho em altura" },
      //   { codigo: "0001", nome: "Espaço confinado" },
      //   { codigo: "0002", nome: "NR10 Básico" },
      //   { codigo: "0003", nome: "NR12 Operação de Máquinas" },
      //   { codigo: "0004", nome: "Brigada de Incêndio" },
      //   { codigo: "0005", nome: "Direção defensiva" }
      // ];
      
      console.log('Inicializando componente de Aptidões e Exames...');

  // 🔹 Caso esteja em modo de edição (já existem dados gravados)
  const temEdicao = (window.aptidoes && window.aptidoes.length > 0) || (window.exames && window.exames.length > 0);

  if (temEdicao) {
    console.log('🟢 Detectado modo de edição: preparando dados existentes...');
    try {
      // 🧩 Trata o caso de vir como string JSON
      if (typeof window.aptidoes === "string") {
        try {
          window.aptidoes = JSON.parse(window.aptidoes);
        } catch (e) {
          console.error("Erro ao converter aptidões JSON:", e);
          window.aptidoes = [];
        }
      }
      if (typeof window.exames === "string") {
        try {
          window.exames = JSON.parse(window.exames);
        } catch (e) {
          console.error("Erro ao converter exames JSON:", e);
          window.exames = [];
        }
      }

      // ✅ Garante arrays
      if (!Array.isArray(window.aptidoes)) window.aptidoes = [];
      if (!Array.isArray(window.exames)) window.exames = [];

      // ✅ Prepara arrays de trabalho
      window.aptAptidoesSelecionadas = window.aptidoes.map(item => ({
        codigo: item.codigo,
        recebe_apenas_nome: item.nome || item.recebe_apenas_nome || "",
        valor: item.valor || ""
      }));
      window.aptExamesSelecionados = window.exames.map(item => ({
        codigo: item.codigo,
        recebe_apenas_nome: item.nome || item.recebe_apenas_nome || "",
        valor: item.valor || ""
      }));

      // ✅ Garante que as bases de dados de todos os checkboxes já estejam carregadas
      if (!Array.isArray(window.aptDadosAptidoes)) window.aptDadosAptidoes = [];
      if (!Array.isArray(window.aptDadosExames)) window.aptDadosExames = [];

      // ✅ Renderiza os checkboxes normalmente (usa a função original)
      console.log('🟢 Chamando renderizarCheckboxes() no modo edição...');
      //renderizarCheckboxes();

      console.log('✅ Aptidões e exames marcados com sucesso (modo edição).');
      //return; // ✅ sai aqui — não executa o restante do fluxo
    } catch (error) {
      console.error('❌ Erro ao repopular dados em modo de edição:', error);
    }
  }


  // 🔸 Se não está em edição (modo gravação)
console.log('🟠 Modo gravação (sem dados prévios) - comportamento original.');

// 🟢 NOVO - restaurar seleções se existirem variáveis globais
if ((window.aptAptidoesSelecionadas && window.aptAptidoesSelecionadas.length > 0) ||
    (window.aptExamesSelecionados && window.aptExamesSelecionados.length > 0)) {
  console.log('🔁 Restaurando seleções anteriores salvas globalmente...');
  aptAptidoesSelecionadas = [...(window.aptAptidoesSelecionadas || [])];
  aptExamesSelecionados = [...(window.aptExamesSelecionados || [])];
  //renderizarCheckboxes();
  console.log('✅ Aptidões e exames restaurados a partir das variáveis globais.');
  //return;
}


  // 🔸 Se não está em edição (modo gravação), mantém o comportamento original
  console.log('🟠 Modo gravação (sem dados prévios) - comportamento original.');
  
  // (mantém tudo o que já existe depois disso)
  console.log('Dados de aptidões disponíveis (window.aptDadosAptidoes):', window.aptDadosAptidoes);
  
  const aptDadosAptidoes = window.aptDadosAptidoes && window.aptDadosAptidoes.length > 0 
    ? window.aptDadosAptidoes 
    : dadosExemploAptidoes;
    
  console.log('Aptidões que serão usadas:', aptDadosAptidoes);

      // const aptDadosExames = [
      //   { codigo: "0068", nome: "Acetilcolinesterase eritrocitária" },
      //   { codigo: "0109", nome: "Ácido hipúrico" },
      //   { codigo: "0116", nome: "Ácido Metil Hipúrico" },
      //   { codigo: "0120", nome: "Hemograma completo" },
      //   { codigo: "0135", nome: "Audiometria" },
      //   { codigo: "0141", nome: "Espirometria" }
      // ];

      
      
      // Elementos do DOM
      console.log('Buscando elementos do DOM...');
      const listaAptidoes = document.getElementById('apt-listaAptidoes');
      console.log('listaAptidoes:', listaAptidoes);
      
      const listaExames = document.getElementById('apt-listaExames');
      console.log('listaExames:', listaExames);
      
      const checkboxContainerApt = document.getElementById('apt-checkbox-container');
      console.log('checkboxContainerApt:', checkboxContainerApt);
      
      const checkboxContainerExames = document.getElementById('apt-checkbox-container-exames');
      console.log('checkboxContainerExames:', checkboxContainerExames);
      
      const selectedAptidoesContainer = document.getElementById('apt-selected-aptidoes');
      console.log('selectedAptidoesContainer:', selectedAptidoesContainer);
      
      const selectedExamesContainer = document.getElementById('apt-selected-exames');
      console.log('selectedExamesContainer:', selectedExamesContainer);
      
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
        // debugger;
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
          <input type="checkbox" id="${tipo}-${item.codigo}" value="${item.codigo}" data-valor="${(item && item.valor) !== undefined ? item.valor : ''}" 
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
          // Evita duplo toggle quando o clique é no LABEL (o LABEL já alterna o checkbox por padrão)
          if (e.target.tagName === 'INPUT') return;
          if (e.target.tagName === 'LABEL' || (e.target.closest && e.target.closest('label'))) return;
          const checkbox = container.querySelector('input[type="checkbox"]');
          if (checkbox) {
            checkbox.checked = !checkbox.checked;
            const event = new Event('change');
            checkbox.dispatchEvent(event);
          }
        };
        
        container.addEventListener('click', handleContainerClick);
        
        // Adiciona evento de mudança no checkbox
        const checkbox = container.querySelector('input[type="checkbox"]');
        if (checkbox) {
          // Evita propagação do clique do input para o container (previne toggle duplo)
          checkbox.addEventListener('click', (e) => { e.stopPropagation(); });
          const handleCheckboxChange = () => {
            // Ignora eventos disparados por atualizações programáticas
            if (emAtualizacaoProgramatica) return;
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

      let aptidoes_selecionadas = [];
      let json_aptidoes;
      let exames_selecionados = [];
      let json_exames;
      // Flag global para distinguir mudanças do usuário x programáticas
      let emAtualizacaoProgramatica = false;
      // Flag para impedir reentrância durante processamento de seleção
      let emProcessamentoSelecao = false;
      // Flags de sujidade: indicam que houve mudança real do usuário e precisamos persistir
      let precisaSalvarAptidoes = false;
      let precisaSalvarExames = false;

      
     async function atualizarListaSelecionados(itens, container, tipo, devePersistir = false) {
  debugger;

  if (!container) {
    console.error('Erro: Container não encontrado para o tipo:', tipo);
    return;
  }

  // 🔹 Se não há itens, limpa container
  container.innerHTML = '';
  if (!Array.isArray(itens) || itens.length === 0) {
    container.innerHTML = '<div style="color: #6c757d; font-style: italic;">Nenhum item selecionado</div>';
    if (tipo === "aptidao") {
      aptidoes_selecionadas = [];
      json_aptidoes = JSON.stringify(aptidoes_selecionadas);
      if (devePersistir && precisaSalvarAptidoes) {
        await gravar_aptidoes_selecionadas();
        precisaSalvarAptidoes = false;
      }
    } else {
      exames_selecionados = [];
      json_exames = JSON.stringify(exames_selecionados);
      if (devePersistir && precisaSalvarExames) {
        await gravar_exames_selecionadas();
        precisaSalvarExames = false;
      }
    }
    return;
  }

  // 🔹 Seleciona array de base conforme modo (edição ou gravação)
  let baseArray =
    tipo === "aptidao"
      ? (Array.isArray(window.aptidoes) && window.aptidoes.length > 0
          ? window.aptidoes
          : itens)
      : (Array.isArray(window.exames) && window.exames.length > 0
          ? window.exames
          : itens);

  // 🔹 Atualiza variáveis principais e JSON
  if (tipo === "aptidao") {
    aptidoes_selecionadas = baseArray.map(item => ({
      codigo: item.codigo,
      nome: item.recebe_apenas_nome || item.nome,
      valor: item.valor
    }));
    aptidoes_selecionadas = [...new Map(aptidoes_selecionadas.map(i => [i.codigo, i])).values()];
    json_aptidoes = JSON.stringify(aptidoes_selecionadas);
    console.log("Aptidões selecionadas:", aptidoes_selecionadas);
    if (devePersistir && precisaSalvarAptidoes) {
      await gravar_aptidoes_selecionadas();
      precisaSalvarAptidoes = false;
    }
  } else {
    exames_selecionados = baseArray.map(item => ({
      codigo: item.codigo,
      nome: item.recebe_apenas_nome || item.nome,
      valor: item.valor
    }));
    exames_selecionados = [...new Map(exames_selecionados.map(i => [i.codigo, i])).values()];
    json_exames = JSON.stringify(exames_selecionados);
    console.log("Exames selecionados:", exames_selecionados);
    if (devePersistir && precisaSalvarExames) {
      await gravar_exames_selecionadas();
      precisaSalvarExames = false;
    }
  }

  // 🔹 Atualiza variáveis principais e JSON
if (tipo === "aptidao") {
  aptidoes_selecionadas = baseArray.map(item => ({
    codigo: item.codigo,
    nome: item.recebe_apenas_nome || item.nome,
    valor: item.valor
  }));
  aptidoes_selecionadas = [...new Map(aptidoes_selecionadas.map(i => [i.codigo, i])).values()];
  json_aptidoes = JSON.stringify(aptidoes_selecionadas);
  console.log("Aptidões selecionadas:", aptidoes_selecionadas);

  // 🟠 NOVO - se for gravação (step 4), salva globalmente
  if (window.recebe_acao !== "edicao") {
    window.aptAptidoesSelecionadas = [...aptidoes_selecionadas];
  }

  if (devePersistir && precisaSalvarAptidoes) {
    await gravar_aptidoes_selecionadas();
    precisaSalvarAptidoes = false;
  }
} else {
  exames_selecionados = baseArray.map(item => ({
    codigo: item.codigo,
    nome: item.recebe_apenas_nome || item.nome,
    valor: item.valor
  }));
  exames_selecionados = [...new Map(exames_selecionados.map(i => [i.codigo, i])).values()];
  json_exames = JSON.stringify(exames_selecionados);
  console.log("Exames selecionados:", exames_selecionados);

  // 🟠 NOVO - se for gravação (step 4), salva globalmente
  if (window.recebe_acao !== "edicao") {
    window.aptExamesSelecionados = [...exames_selecionados];
  }

  if (devePersistir && precisaSalvarExames) {
    await gravar_exames_selecionadas();
    precisaSalvarExames = false;
  }
}


  // 🔹 Cálculo do total de exames (somente no modo de edição)
  if (tipo === "exame" && Array.isArray(window.exames) && window.exames.length > 0) {
    const total = window.exames.reduce((soma, item) => {
      let v = item?.valor ?? "0";
      if (typeof v === "string") v = v.replace(",", ".");
      const num = parseFloat(v);
      return soma + (isNaN(num) ? 0 : num);
    }, 0);

    window.fatTotalExames = Number(total.toFixed(2));
    console.log("💰 Total de exames (edição):", window.fatTotalExames);
  } else if (tipo === "exame") {
    // Caso não esteja no modo edição, usa o array recebido normalmente
    const total = baseArray.reduce((soma, item) => {
      let v = item?.valor ?? "0";
      if (typeof v === "string") v = v.replace(",", ".");
      const num = parseFloat(v);
      return soma + (isNaN(num) ? 0 : num);
    }, 0);
    window.fatTotalExames = Number(total.toFixed(2));
  }

  // 🔹 Renderiza badges na interface
  baseArray.forEach(item => {
    debugger;
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
      <div style="display: flex; align-items: center;">
        <span>${item.codigo} - ${item.recebe_apenas_nome || item.nome}</span>
        <button class="btn-remover" style="background: none; border: none; color: inherit; margin-left: 6px; cursor: pointer; font-size: 14px; display: flex; align-items: center;">
          <i class="fas fa-times"></i>
        </button>
      </div>`;

    badge.querySelector('.btn-remover').addEventListener('click', async (e) => {
      e.stopPropagation();
      const arrayAlvo = tipo === 'aptidao'
        ? (window.aptAptidoesSelecionadas || aptAptidoesSelecionadas)
        : (window.aptExamesSelecionados || aptExamesSelecionados);

      const index = arrayAlvo.findIndex(a => a.codigo === item.codigo);
      if (index !== -1) arrayAlvo.splice(index, 1);

      const checkbox = document.querySelector(`#${tipo}-${item.codigo}`);
      if (checkbox) {
        emAtualizacaoProgramatica = true;
        checkbox.checked = false;
        emAtualizacaoProgramatica = false;
      }

      if (tipo === 'aptidao') precisaSalvarAptidoes = true;
      else precisaSalvarExames = true;

      await atualizarListaSelecionados(arrayAlvo, container, tipo, true);
    });

    container.appendChild(badge);
  });
}


      function gravar_aptidoes_selecionadas()
      {
        if(window.recebe_acao && window.recebe_acao === "editar")
        {
          return new Promise((resolve, reject) => {
            $.ajax({
              url: "cadastros/processa_geracao_kit.php",
              type: "POST",
              dataType: "json",
              data: {
                processo_geracao_kit: "atualizar_kit",
                valor_aptidoes: json_aptidoes,
                valor_id_kit:window.recebe_id_kit
              },
              success: function (retorno_exame_geracao_kit) {
                debugger;

                const mensagemSucesso = `
                  <div id="aptidao-gravado" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
                    <div style="display: flex; align-items: center; justify-content: center;">
                      <div>
                        <div>KIT atualizado com sucesso.</div>
                      </div>
                    </div>
                  </div>
                `;

                // Remove mensagem anterior se existir
                $("#aptidao-gravado").remove();

                // Adiciona a nova mensagem acima das abas
                $(".tabs-container").before(mensagemSucesso);

                // Configura o fade out após 5 segundos
                setTimeout(function () {
                  $("#aptidao-gravado").fadeOut(500, function () {
                    $(this).remove();
                  });
                }, 5000);

                console.log(retorno_exame_geracao_kit);

                resolve(retorno_exame_geracao_kit);
              },
              error: function (xhr, status, error) {
                console.log("Falha ao incluir exame: " + error);
                reject(error);
              },
            });
          });
        }else{
          return new Promise((resolve, reject) => {
            $.ajax({
              url: "cadastros/processa_geracao_kit.php",
              type: "POST",
              dataType: "json",
              data: {
                processo_geracao_kit: "incluir_valores_kit",
                valor_aptidoes: json_aptidoes,
              },
              success: function (retorno_exame_geracao_kit) {
                debugger;

                const mensagemSucesso = `
                  <div id="aptidao-gravado" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
                    <div style="display: flex; align-items: center; justify-content: center;">
                      <div>
                        <div>KIT atualizado com sucesso.</div>
                      </div>
                    </div>
                  </div>
                `;

                // Remove mensagem anterior se existir
                $("#aptidao-gravado").remove();

                // Adiciona a nova mensagem acima das abas
                $(".tabs-container").before(mensagemSucesso);

                // Configura o fade out após 5 segundos
                setTimeout(function () {
                  $("#aptidao-gravado").fadeOut(500, function () {
                    $(this).remove();
                  });
                }, 5000);

                console.log(retorno_exame_geracao_kit);

                resolve(retorno_exame_geracao_kit);
              },
              error: function (xhr, status, error) {
                console.log("Falha ao incluir exame: " + error);
                reject(error);
              },
            });
          });
        }
      }

      function gravar_exames_selecionadas()
      {
        if(window.recebe_acao && window.recebe_acao === "editar")
        {
          return new Promise((resolve, reject) => {
            $.ajax({
              url: "cadastros/processa_geracao_kit.php",
              type: "POST",
              dataType: "json",
              data: {
                processo_geracao_kit: "atualizar_kit",
                valor_exames_selecionados: json_exames,
                valor_id_kit:window.recebe_id_kit
              },
              success: function (retorno_exame_geracao_kit) {
                debugger;

                const mensagemSucesso = `
                  <div id="exame-quarta-etapa-gravado" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
                    <div style="display: flex; align-items: center; justify-content: center;">
                      <div>
                        <div>KIT atualizado com sucesso.</div>
                      </div>
                    </div>
                  </div>
                `;

                // Remove mensagem anterior se existir
                $("#exame-quarta-etapa-gravado").remove();

                // Adiciona a nova mensagem acima das abas
                $(".tabs-container").before(mensagemSucesso);

                // Configura o fade out após 5 segundos
                setTimeout(function () {
                  $("#exame-quarta-etapa-gravado").fadeOut(500, function () {
                    $(this).remove();
                  });
                }, 5000);

                console.log(retorno_exame_geracao_kit);

                resolve(retorno_exame_geracao_kit);
              },
              error: function (xhr, status, error) {
                console.log("Falha ao incluir exame: " + error);
                reject(error);
              },
            });
          });
        }else{
          return new Promise((resolve, reject) => {
            $.ajax({
              url: "cadastros/processa_geracao_kit.php",
              type: "POST",
              dataType: "json",
              data: {
                processo_geracao_kit: "incluir_valores_kit",
                valor_exames_selecionados: json_exames,
              },
              success: function (retorno_exame_geracao_kit) {
                debugger;

                const mensagemSucesso = `
                  <div id="exame-quarta-etapa-gravado" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
                    <div style="display: flex; align-items: center; justify-content: center;">
                      <div>
                        <div>KIT atualizado com sucesso.</div>
                      </div>
                    </div>
                  </div>
                `;

                // Remove mensagem anterior se existir
                $("#exame-quarta-etapa-gravado").remove();

                // Adiciona a nova mensagem acima das abas
                $(".tabs-container").before(mensagemSucesso);

                // Configura o fade out após 5 segundos
                setTimeout(function () {
                  $("#exame-quarta-etapa-gravado").fadeOut(500, function () {
                    $(this).remove();
                  });
                }, 5000);

                console.log(retorno_exame_geracao_kit);

                resolve(retorno_exame_geracao_kit);
              },
              error: function (xhr, status, error) {
                console.log("Falha ao incluir exame: " + error);
                reject(error);
              },
            });
          });
        }
        
      }
      
      let recebe_valores_exames_selecionados = [];
let bloqueioRenderizacaoSelecao = false;

async function atualizarSelecionados(checkbox, tipo) {
  debugger;

  // Ignora se atualização for automática
  if (emAtualizacaoProgramatica || emProcessamentoSelecao) return;

  const estadoInicialMarcado = !!checkbox.checked;
  const codigo = checkbox.value;
  const nome = checkbox.nextElementSibling.textContent.trim();
  const valor = checkbox.getAttribute('data-valor') || checkbox.value;
  const recebe_apenas_nome = nome.split('-')[1]?.trim() || nome;

  const dadosOriginais = tipo === 'aptidao' ? aptDadosAptidoes : aptDadosExames;
  const itemOriginal = dadosOriginais.find(item => item.codigo === codigo);
  const item = { codigo, recebe_apenas_nome, valor };

  // 🔹 Usa arrays de edição (globais) se existirem e contiverem dados
  const arraySelecionado =
    tipo === 'aptidao'
      ? (Array.isArray(aptAptidoesSelecionadas) && aptAptidoesSelecionadas.length > 0
          ? aptAptidoesSelecionadas
          : (Array.isArray(window.aptAptidoesSelecionadas) ? window.aptAptidoesSelecionadas : []))
      : (Array.isArray(aptExamesSelecionados) && aptExamesSelecionados.length > 0
          ? aptExamesSelecionados
          : (Array.isArray(window.aptExamesSelecionados) ? window.aptExamesSelecionados : []));

  const container = tipo === 'aptidao' ? selectedAptidoesContainer : selectedExamesContainer;

  bloqueioRenderizacaoSelecao = true;
  emProcessamentoSelecao = true;

  if (estadoInicialMarcado) {
    // Adiciona se não existir
    if (!arraySelecionado.some(a => a.codigo === codigo)) {
      arraySelecionado.push(item);
    }

    if (!recebe_valores_exames_selecionados.some(ex => ex.codigo === codigo)) {
      recebe_valores_exames_selecionados.push({ codigo, valor });
    }
  } else {
    // Remove se existir
    const index = arraySelecionado.findIndex(a => a.codigo === codigo);
    if (index !== -1) arraySelecionado.splice(index, 1);

    const idxValor = recebe_valores_exames_selecionados.findIndex(a => a.codigo === codigo);
    if (idxValor !== -1) recebe_valores_exames_selecionados.splice(idxValor, 1);
  }

  console.log("Exames com valor para somar:", recebe_valores_exames_selecionados);

  const total = recebe_valores_exames_selecionados
    .reduce((soma, item) => soma + parseFloat((item.valor || "0").replace(",", ".")), 0);

  window.fatTotalExames = total;

  try {
    if (tipo === 'aptidao') precisaSalvarAptidoes = true;
    else precisaSalvarExames = true;

    await atualizarListaSelecionados(arraySelecionado, container, tipo, true);
  } finally {
    // Garante o estado do checkbox conforme o clique original
    if (checkbox.checked !== estadoInicialMarcado) {
      emAtualizacaoProgramatica = true;
      checkbox.checked = estadoInicialMarcado;
      emAtualizacaoProgramatica = false;
    }

    bloqueioRenderizacaoSelecao = false;
    emProcessamentoSelecao = false;
  }
}


      
  
  // Função para renderizar as listas de checkboxes
function renderizarCheckboxes() {
  debugger;
  console.log('Iniciando renderização dos checkboxes...');
  console.log('Dados de aptidões para renderizar:', window.aptDadosAptidoes);

  // Verifica se os containers existem
  console.log('Container de aptidões:', checkboxContainerApt);
  console.log('Container de exames:', checkboxContainerExames);

  // Se não há dados de aptidões, mostra aviso
  if (!window.aptDadosAptidoes || window.aptDadosAptidoes.length === 0) {
    console.warn('Nenhum dado de aptidão disponível para renderizar');
    if (checkboxContainerApt) {
      checkboxContainerApt.innerHTML = '<div class="alert alert-info">Nenhuma aptidão disponível</div>';
    }
    return;
  }

  // 🔹 Usa os arrays com dados — prioridade: local > global
  const aptSelecionadas = (Array.isArray(aptAptidoesSelecionadas) && aptAptidoesSelecionadas.length > 0)
    ? [...aptAptidoesSelecionadas]
    : (Array.isArray(window.aptAptidoesSelecionadas) ? [...window.aptAptidoesSelecionadas] : []);

  const examesSelecionados = (Array.isArray(aptExamesSelecionados) && aptExamesSelecionados.length > 0)
    ? [...aptExamesSelecionados]
    : (Array.isArray(window.aptExamesSelecionados) ? [...window.aptExamesSelecionados] : []);

  // Limpa e renderiza checkboxes de aptidões
  if (checkboxContainerApt) {
    checkboxContainerApt.innerHTML = '';
    aptDadosAptidoes.forEach(item => {
      const checkbox = criarCheckbox(item, 'aptidao');
      const input = checkbox.querySelector('input[type="checkbox"]');
      if (aptSelecionadas.some(a => a.codigo === item.codigo)) {
        emAtualizacaoProgramatica = true;
        input.checked = true;
        emAtualizacaoProgramatica = false;
      }
      checkboxContainerApt.appendChild(checkbox);
    });
  }

  // Limpa e renderiza checkboxes de exames
  if (checkboxContainerExames) {
    checkboxContainerExames.innerHTML = '';
    aptDadosExames.forEach(item => {
      const checkbox = criarCheckbox(item, 'exame');
      const input = checkbox.querySelector('input[type="checkbox"]');
      if (examesSelecionados.some(e => e.codigo === item.codigo)) {
        emAtualizacaoProgramatica = true;
        input.checked = true;
        emAtualizacaoProgramatica = false;
      }
      checkboxContainerExames.appendChild(checkbox);
    });
  }

  // 🔸 Escolhe os arrays corretos para atualizar listas visuais
  const aptParaAtualizar = (Array.isArray(aptAptidoesSelecionadas) && aptAptidoesSelecionadas.length > 0)
    ? aptAptidoesSelecionadas
    : (Array.isArray(window.aptAptidoesSelecionadas) ? window.aptAptidoesSelecionadas : []);

  const examesParaAtualizar = (Array.isArray(aptExamesSelecionados) && aptExamesSelecionados.length > 0)
    ? aptExamesSelecionados
    : (Array.isArray(window.aptExamesSelecionados) ? window.aptExamesSelecionados : []);

  // 🔹 Atualiza as listas de selecionados corretamente (sem perder marcações)
  atualizarListaSelecionados(aptParaAtualizar, selectedAptidoesContainer, 'aptidao');
  atualizarListaSelecionados(examesParaAtualizar, selectedExamesContainer, 'exame');

  console.log('✅ renderizarCheckboxes finalizado com controle de gravação/edição.');
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
    if (!modal) return;
    
    // Esconde o modal primeiro
    modal.style.display = 'none';
    
    // Limpa os campos após um pequeno atraso para evitar problemas de foco
    setTimeout(() => {
      if (inputCodigo) inputCodigo.value = '';
      if (inputNome) inputNome.value = '';
      const inputValor = document.getElementById('apt-novoValor');
      if (inputValor) inputValor.value = '';
      
      // Remove o foco dos campos para evitar que o evento de tecla Enter dispare novamente
      if (document.activeElement) {
        document.activeElement.blur();
      }
    }, 100);
  }

  let recebe_nome_aptidao;
  let recebe_codigo_aptidao;
  let recebe_nome_exame;
  let recebe_codigo_exame;
  let emProcessamentoAptidao = false;
  let emProcessamentoExame = false;
  let novoItem;
  let arrayAlvo;
  
  // Função para adicionar um novo item (aptidão ou exame)
  async function adicionarNovoItem() {
    debugger;
    // Se já estiver processando, não faz nada
    if (window.adicionandoItem || emProcessamentoAptidao || emProcessamentoExame) {
      console.log('Já existe uma operação em andamento');
      return;
    }
    
    // Verifica se o modal está visível
    const modal = document.getElementById('apt-modal');
    if (!modal || modal.style.display !== 'flex') {
      console.log('Modal não está visível');
      return;
    }
    
    try {
      // Obtém os valores dos campos
      const inputCodigo = document.getElementById('apt-novoCodigo');
      const inputNome = document.getElementById('apt-novoNome');
      const codigo = inputCodigo ? inputCodigo.value.trim() : '';
      const nome = inputNome ? inputNome.value.trim() : '';
      
      // Verifica campos obrigatórios
      if (codigo === '' || nome === '') {
        if (!window.camposObrigatoriosMostrado) {
          alert('Preencha todos os campos obrigatórios');
          window.camposObrigatoriosMostrado = true;
          setTimeout(() => { window.camposObrigatoriosMostrado = false; }, 1000);
        }
        return;
      }
      
      // Marca que está processando
      window.adicionandoItem = true;
      
      // Define as variáveis globais
      recebe_nome_aptidao = nome;
      recebe_codigo_aptidao = codigo;

      recebe_nome_exame = nome;
      recebe_codigo_exame = codigo;
      
      // Verifica se o código já existe no array apropriado
      arrayAlvo = modalTipoAtual === 'aptidao' ? window.aptDadosAptidoes : window.aptDadosExames;
      const codigoExistente = arrayAlvo.some(item => item.codigo === codigo);
      
      if (codigoExistente) {
        if (!window.ultimoAlerta || (Date.now() - window.ultimoAlerta > 1000)) {
          window.ultimoAlerta = Date.now();
          alert('Já existe um item com este código');
        }
        return;
      }

      // Cria o novo item
      novoItem = {
        // id:'temp_' + Date.now(),
        codigo, 
        nome,
        // recebe_apenas_nome: nome
      };
      
      // Adiciona ao array apropriado
      arrayAlvo.push(novoItem);

      // Se for aptidão, chama a função de gravar
      if (modalTipoAtual === 'aptidao') {
        console.log('Chamando gravar_aptidao_extra para aptidão');
        await gravar_aptidao_extra();
      }else if(modalTipoAtual === "exame")
      {
        console.log('Chamando gravar_aptidao_extra para aptidão');
        await gravar_exame();
      }
      
      // Fecha o modal
      fecharModal();
      
      // Limpa os campos
      if (inputCodigo) inputCodigo.value = '';
      if (inputNome) inputNome.value = '';
      
    } catch (error) {
      console.error('Erro ao adicionar item:', error);
      alert('Ocorreu um erro ao adicionar o item: ' + error.message);
    } finally {
      // Libera para a próxima execução
      window.adicionandoItem = false;
      emProcessamentoAptidao = false;
      emProcessamentoExame = false;
    }
  }

  function gravar_aptidao_extra() {
    return new Promise((resolve, reject) => {
      // Verifica se já está processando
      if (emProcessamentoAptidao) {
        console.log('Já existe uma gravação de aptidão em andamento');
        return;
      }

      emProcessamentoAptidao = true;
      
      console.log('Iniciando gravação de aptidão extra:', {
        codigo: recebe_codigo_aptidao,
        nome: recebe_nome_aptidao
      });

      $.ajax({
        url: "cadastros/processa_aptidao_extra.php",
        type: "POST",
        dataType: "json",
        data: {
          processo_aptidao_extra: "inserir_aptidao_extra",
          valor_codigo_aptidao_extra: recebe_codigo_aptidao,
          valor_nome_aptidao_extra: recebe_nome_aptidao,
        },
        success: function(retorno_aptidao_extra) {
          debugger;
          console.log('Resposta do servidor:', retorno_aptidao_extra);

          const mensagemSucesso = `
            <div id="aptidao-extra-gravado" class="alert alert-success" 
                 style="text-align: center; margin: 0 auto 20px; max-width: 600px; 
                        display: block; background-color: #d4edda; color: #155724; 
                        padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
              <div style="display: flex; align-items: center; justify-content: center;">
                <div>
                  <div>Aptidão extra cadastrada com sucesso.</div>
                </div>
              </div>
            </div>`;

          // Remove mensagem anterior se existir
          $("#aptidao-extra-gravado").remove();

          // Adiciona a nova mensagem acima das abas
          $(".tabs-container").before(mensagemSucesso);

          // Configura o fade out após 5 segundos
          setTimeout(function() {
            $("#aptidao-extra-gravado").fadeOut(500, function() {
              $(this).remove();
            });
          }, 5000);


          // // Atualiza o ID temporário para o ID real retornado pelo servidor
          // const aptidaoIndex = window.aptDadosAptidoes.findIndex(
          //     ap => ap.id === novoItem.id
          // );

          // if (aptidaoIndex !== -1) {
          //     window.aptDadosAptidoes[aptidaoIndex].id = retorno_aptidao_extra; // usa retorno do servidor
          // }

          // Atualiza a interface
          const container = modalTipoAtual === 'aptidao' ? 
          document.getElementById('apt-checkbox-container') : 
          document.getElementById('apt-checkbox-container-exames');

          
          if (container && typeof criarCheckbox === 'function') {
            const checkbox = criarCheckbox(novoItem, modalTipoAtual);
            if (checkbox) {
              container.appendChild(checkbox);
            }
          }
          
          resolve(retorno_aptidao_extra);
        },
        error: function(xhr, status, error) {
          console.error("Erro ao inserir aptidão extra:", {
            status: status,
            error: error,
            responseText: xhr.responseText
          });
          alert('Erro ao salvar a aptidão. Verifique o console para mais detalhes.');
          reject(error);
        },
        complete: function() {
          emProcessamentoAptidao = false;
        }
      });
    });
  }

  function gravar_exame() {
    return new Promise((resolve, reject) => {
      // Verifica se já está processando
      if (emProcessamentoExame) {
        console.log('Já existe uma gravação de exame em andamento');
        return;
      }

      emProcessamentoExame = true;
      
      console.log('Iniciando gravação de aptidão extra:', {
        codigo: recebe_codigo_aptidao,
        nome: recebe_nome_aptidao
      });

      $.ajax({
        url: "cadastros/processa_exames_procedimentos.php",
        type: "POST",
        dataType: "json",
        data: {
          processo_exame_procedimento: "inserir_exame_procedimento",
          valor_codigo_exame_procedimento: recebe_codigo_exame,
          valor_procedimento: recebe_nome_exame,
          // valor_exame_procedimento: recebe_valor_procedimento
        },
        success: function(retorno_exame) {
          debugger;
          console.log('Resposta do servidor:', retorno_exame);

          const mensagemSucesso = `
            <div id="exame-procedimento-gravado" class="alert alert-success" 
                 style="text-align: center; margin: 0 auto 20px; max-width: 600px; 
                        display: block; background-color: #d4edda; color: #155724; 
                        padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
              <div style="display: flex; align-items: center; justify-content: center;">
                <div>
                  <div>Exame cadastrado com sucesso.</div>
                </div>
              </div>
            </div>`;

          // Remove mensagem anterior se existir
          $("#exame-procedimento-gravado").remove();

          // Adiciona a nova mensagem acima das abas
          $(".tabs-container").before(mensagemSucesso);

          // Configura o fade out após 5 segundos
          setTimeout(function() {
            $("#exame-procedimento-gravado").fadeOut(500, function() {
              $(this).remove();
            });
          }, 5000);


          // // Atualiza o ID temporário para o ID real retornado pelo servidor
          // const aptidaoIndex = window.aptDadosAptidoes.findIndex(
          //     ap => ap.id === novoItem.id
          // );

          // if (aptidaoIndex !== -1) {
          //     window.aptDadosAptidoes[aptidaoIndex].id = retorno_aptidao_extra; // usa retorno do servidor
          // }

          // Atualiza a interface
          const container = modalTipoAtual === 'aptidao' ? 
          document.getElementById('apt-checkbox-container') : 
          document.getElementById('apt-checkbox-container-exames');

          
          if (container && typeof criarCheckbox === 'function') {
            const checkbox = criarCheckbox(novoItem, modalTipoAtual);
            if (checkbox) {
              container.appendChild(checkbox);
            }
          }
          
          resolve(retorno_exame);
        },
        error: function(xhr, status, error) {
          console.error("Erro ao inserir aptidão extra:", {
            status: status,
            error: error,
            responseText: xhr.responseText
          });
          alert('Erro ao salvar a aptidão. Verifique o console para mais detalhes.');
          reject(error);
        },
        complete: function() {
          emProcessamentoExame = false;
        }
      });
    });
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
  
  // Renderiza os checkboxes iniciais
  renderizarCheckboxes();
  
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
      console.log('Iniciando inicialização do componente de Aptidões e Exames...');
      console.log('Dados iniciais de aptidões:', window.aptDadosAptidoes);
      
      // Verifica se o container de aptidões existe no DOM
      const containerApt = document.getElementById('apt-checkbox-container');
      console.log('Container de aptidões encontrado no DOM:', containerApt);
      
      if (!containerApt) {
        console.error('Erro: Container de aptidões não encontrado no DOM');
        return false;
      }
      
      // Adiciona evento de clique na aba de aptidões para forçar o carregamento
      const abaAptidoes = document.querySelector('a[href="#tab-aptidoes"]');
      if (abaAptidoes) {
        console.log('Adicionando evento de clique na aba de aptidões');
        abaAptidoes.addEventListener('click', function() {
          console.log('Aba de aptidões clicada, forçando carregamento...');
          if (!window.aptDadosAptidoes || window.aptDadosAptidoes.length === 0 || !window.aptDadosExames || window.aptDadosExames.length === 0) {
            console.log('Nenhum dado de aptidão carregado, buscando do servidor...');
            carregar_aptidoes_extras();
            carregar_exames();
          } else {
            console.log('Dados de aptidão já carregados, renderizando...');
            renderizarCheckboxes();
          }
        });
      } else {
        console.warn('Aba de aptidões não encontrada no DOM');
      }
      
      // Renderiza as listas iniciais
      renderizarCheckboxes();
      
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
    
    
    
    // Expõe a função no escopo global para chamadas externas (ex.: setTimeout/handlers fora deste bloco)
    // if (typeof window !== 'undefined') {
    //   window.initializeRiscosComponent = initializeRiscosComponent;
    // }
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
    // let fatTotalEPI = 0;
    // let fatTotalExames = 0; // Será atualizado dinamicamente
    // let fatTotalTreinamentos = 0; // Será atualizado dinamicamente

    // let recebe_nome_produto;
    // let recebe_valor_produto;
    // let recebe_quantidade_produto;

    // ============================================================
// 🔹 Função para adicionar produto
// ============================================================
// window.fatAdicionarProduto = async function() {
//   debugger;
//   const descricao = document.getElementById('fat-descricao')?.value.trim();
//   const quantidade = parseInt(document.getElementById('fat-quantidade')?.value);
//   const valorUnit = parseFloat(document.getElementById('fat-valorUnit')?.value);

//   if (!descricao || isNaN(quantidade) || isNaN(valorUnit)) {
//     alert('Preencha todos os campos corretamente.');
//     return;
//   }

//   // Armazena dados do produto atual
//   const produtoAtual = {
//     nome: descricao,
//     quantidade: quantidade,
//     valorunit: valorUnit
//   };

//   // 🔹 Salva em variáveis individuais (se quiser manter compatibilidade)
//   window.recebe_nome_produto = descricao;
//   window.recebe_valor_produto = valorUnit;
//   window.recebe_quantidade_produto = quantidade;

//   recebe_nome_produto = descricao;
//   recebe_valor_produto = valorUnit;
//   recebe_quantidade_produto = valorUnit;

//   // 🔹 Grava produto e obtém retorno do servidor
//   const retorno = await grava_produto();
//   const codigoProduto = retorno ?? null;

//   if (!codigoProduto) {
//     alert('Não foi possível obter o código do produto cadastrado.');
//     return;
//   }

//   // Inclui código retornado do backend
//   produtoAtual.id = codigoProduto;

//   // Adiciona produto ao array global
//   window.fatProdutosGlobais.push(produtoAtual);
//   console.log('Produto armazenado globalmente:', window.fatProdutosGlobais);

//   const valorTotal = quantidade * valorUnit;

//   // Atualiza total global de EPI/EPC
//   window.fatTotalEPI = (window.fatTotalEPI || 0) + valorTotal;
//   console.log('Produto adicionado. Novo total EPI/EPC:', window.fatTotalEPI);

//   // Aplica estilos caso não existam
//   const style = document.createElement('style');
//   if (!document.getElementById('fat-styles')) {
//     style.id = 'fat-styles';
//     style.textContent = `
//       .fat-produto-item {
//         display: flex;
//         align-items: center;
//         gap: 15px;
//         padding: 12px 15px;
//         color: #2d3748;
//         font-size: 14px;
//         border-bottom: 1px solid #e2e8f0;
//         transition: all 0.2s ease;
//         background-color: white;
//         border-radius: 8px;
//         margin-bottom: 8px;
//         box-shadow: 0 1px 3px rgba(0,0,0,0.05);
//       }
//       .fat-produto-item:hover {
//         background-color: #f8fafc;
//         transform: translateY(-1px);
//         box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 
//                     0 2px 4px -1px rgba(0, 0, 0, 0.06);
//       }
//       .fat-produto-item > div { padding: 4px 8px; }
//       .fat-produto-descricao { flex: 3; font-weight: 500; color: #1a365d; }
//       .fat-produto-quantidade, .fat-produto-valor-unit, .fat-produto-total {
//         flex: 1; text-align: center; color: #4a5568;
//       }
//       .fat-produto-total { font-weight: 600; color: #2b6cb0; }
//       .fat-produto-acoes { flex: 0.8; text-align: center; }
//       .btn-remover {
//         background-color: #fff;
//         color: #e53e3e;
//         border: 1px solid #fed7d7;
//         border-radius: 6px;
//         padding: 6px 12px;
//         font-size: 13px;
//         font-weight: 500;
//         cursor: pointer;
//         display: inline-flex;
//         align-items: center;
//         gap: 4px;
//         transition: all 0.2s ease;
//       }
//       .btn-remover:hover {
//         background-color: #feb2b2;
//         color: #9b2c2c;
//         transform: translateY(-1px);
//       }
//       .btn-remover i { font-size: 14px; }
//     `;
//     document.head.appendChild(style);
//   }

//   // Cria elemento visual do produto
//   const linha = document.createElement('div');
//   linha.className = 'fat-produto-item';
//   linha.innerHTML = [
//     `<div class="fat-produto-descricao">${descricao}</div>`,
//     `<div class="fat-produto-quantidade">${quantidade}</div>`,
//     `<div class="fat-produto-valor-unit">${fatFormatter.format(valorUnit)}</div>`,
//     `<div class="fat-produto-total">${fatFormatter.format(valorTotal)}</div>`,
//     '<div class="fat-produto-acoes">',
//     `  <button class="btn-remover" onclick="fatRemoverProduto(this, ${codigoProduto}, ${valorTotal})">`,
//     '    <i class="fas fa-trash-alt"></i> Remover',
//     '  </button>',
//     '</div>'
//   ].join('');
  
//   // Adiciona na lista
//   document.getElementById('fat-lista-produtos').appendChild(linha);

//   // Limpa campos
//   document.getElementById('fat-descricao').value = '';
//   document.getElementById('fat-quantidade').value = '1';
//   document.getElementById('fat-valorUnit').value = '';

//   // Atualiza totais
//   if (typeof window.fatAtualizarTotais === 'function') {
//     window.fatAtualizarTotais();
//   }
// };

    // ============================================================
// 🔹 Variável global para armazenar produtos adicionados
// ============================================================
// window.fatProdutosGlobais = []; // será usada quando não estiver em modo edição

// // ============================================================
// // 🔹 Função para adicionar produto
// // ============================================================
// window.fatAdicionarProduto = async function() {
//   debugger;
//   const descricao = document.getElementById('fat-descricao')?.value.trim();
//   const quantidade = parseInt(document.getElementById('fat-quantidade')?.value);
//   const valorUnit = parseFloat(document.getElementById('fat-valorUnit')?.value);

//   if (!descricao || isNaN(quantidade) || isNaN(valorUnit)) {
//     alert('Preencha todos os campos corretamente.');
//     return;
//   }

//   // Armazena dados do produto atual
//   const produtoAtual = {
//     nome: descricao,
//     quantidade: quantidade,
//     valorunit: valorUnit
//   };

//   // 🔹 Salva em variáveis individuais (se quiser manter compatibilidade)
//   window.recebe_nome_produto = descricao;
//   window.recebe_valor_produto = valorUnit;
//   window.recebe_quantidade_produto = quantidade;

//   // 🔹 Grava produto e obtém retorno do servidor
//   const retorno = await grava_produto();
//   const codigoProduto = retorno?.codigo_produto ?? null;

//   if (!codigoProduto) {
//     alert('Não foi possível obter o código do produto cadastrado.');
//     return;
//   }

//   // Inclui código retornado do backend
//   produtoAtual.id = codigoProduto;

//   // Adiciona produto ao array global
//   window.fatProdutosGlobais.push(produtoAtual);
//   console.log('Produto armazenado globalmente:', window.fatProdutosGlobais);

//   const valorTotal = quantidade * valorUnit;

//   // Atualiza total global de EPI/EPC
//   window.fatTotalEPI = (window.fatTotalEPI || 0) + valorTotal;
//   console.log('Produto adicionado. Novo total EPI/EPC:', window.fatTotalEPI);

//   // Aplica estilos caso não existam
//   const style = document.createElement('style');
//   if (!document.getElementById('fat-styles')) {
//     style.id = 'fat-styles';
//     style.textContent = `
//       .fat-produto-item {
//         display: flex;
//         align-items: center;
//         gap: 15px;
//         padding: 12px 15px;
//         color: #2d3748;
//         font-size: 14px;
//         border-bottom: 1px solid #e2e8f0;
//         transition: all 0.2s ease;
//         background-color: white;
//         border-radius: 8px;
//         margin-bottom: 8px;
//         box-shadow: 0 1px 3px rgba(0,0,0,0.05);
//       }
//       .fat-produto-item:hover {
//         background-color: #f8fafc;
//         transform: translateY(-1px);
//         box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 
//                     0 2px 4px -1px rgba(0, 0, 0, 0.06);
//       }
//       .fat-produto-item > div { padding: 4px 8px; }
//       .fat-produto-descricao { flex: 3; font-weight: 500; color: #1a365d; }
//       .fat-produto-quantidade, .fat-produto-valor-unit, .fat-produto-total {
//         flex: 1; text-align: center; color: #4a5568;
//       }
//       .fat-produto-total { font-weight: 600; color: #2b6cb0; }
//       .fat-produto-acoes { flex: 0.8; text-align: center; }
//       .btn-remover {
//         background-color: #fff;
//         color: #e53e3e;
//         border: 1px solid #fed7d7;
//         border-radius: 6px;
//         padding: 6px 12px;
//         font-size: 13px;
//         font-weight: 500;
//         cursor: pointer;
//         display: inline-flex;
//         align-items: center;
//         gap: 4px;
//         transition: all 0.2s ease;
//       }
//       .btn-remover:hover {
//         background-color: #feb2b2;
//         color: #9b2c2c;
//         transform: translateY(-1px);
//       }
//       .btn-remover i { font-size: 14px; }
//     `;
//     document.head.appendChild(style);
//   }

//   // Cria elemento visual do produto
//   const linha = document.createElement('div');
//   linha.className = 'fat-produto-item';
//   linha.innerHTML = [
//     `<div class="fat-produto-descricao">${descricao}</div>`,
//     `<div class="fat-produto-quantidade">${quantidade}</div>`,
//     `<div class="fat-produto-valor-unit">${fatFormatter.format(valorUnit)}</div>`,
//     `<div class="fat-produto-total">${fatFormatter.format(valorTotal)}</div>`,
//     '<div class="fat-produto-acoes">',
//     `  <button class="btn-remover" onclick="fatRemoverProduto(this, ${codigoProduto}, ${valorTotal})">`,
//     '    <i class="fas fa-trash-alt"></i> Remover',
//     '  </button>',
//     '</div>'
//   ].join('');
  
//   // Adiciona na lista
//   document.getElementById('fat-lista-produtos').appendChild(linha);

//   // Limpa campos
//   document.getElementById('fat-descricao').value = '';
//   document.getElementById('fat-quantidade').value = '1';
//   document.getElementById('fat-valorUnit').value = '';

//   // Atualiza totais
//   if (typeof window.fatAtualizarTotais === 'function') {
//     window.fatAtualizarTotais();
//   }
// };


    // Função para remover produto
    window.fatRemoverProduto = async function(botao, codigo,valorTotal) {
      debugger;
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
      }).then(async (result) => {
        if (result.isConfirmed) {
          debugger;

          await exclui_produto();

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

    function grava_produto()
    {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: "cadastros/processa_produto.php",
          type: "POST",
          dataType: "json",
          data: {
           processo_produto: "inserir_produto",
           valor_descricao_produto: recebe_nome_produto,
           valor_produto: recebe_valor_produto,
           valor_quantidade_produto:recebe_quantidade_produto
          },
          success: function(retorno_produto) {
            debugger;
            console.log(retorno_produto);

            const mensagemSucesso = `
                <div id="produto-gravado" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
                  <div style="display: flex; align-items: center; justify-content: center;">
                    <div>
                      <div>Produto cadastrado com sucesso.</div>
                    </div>
                  </div>
                </div>
              `;

              // Remove mensagem anterior se existir
              $("#produto-gravado").remove();

              // Adiciona a nova mensagem acima das abas
              $(".tabs-container").before(mensagemSucesso);

              // Configura o fade out após 5 segundos
              setTimeout(function () {
                $("#produto-gravado").fadeOut(500, function () {
                  $(this).remove();
                });
              }, 5000);

            // Resolve a Promise para permitir a continuação do fluxo
            try { resolve(retorno_produto); } catch(e) { resolve(); }
          },
          error: function(xhr, status, error) {
            console.log("Falha ao inserir produto:" + error);
            // Rejeita a Promise para que o chamador possa tratar
            reject(error || status || 'erro_desconhecido');
          },
        });
      });
    }

    function exclui_produto()
    {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: "cadastros/processa_produto.php",
          type: "POST",
          dataType: "json",
          data: {
           processo_produto: "deletar_produto",
           valor_codigo_produto: window.recebe_codigo_produto,
          },
          success: function(retorno_produto) {
            debugger;
            console.log(retorno_produto);

            // const mensagemSucesso = `
            //     <div id="produto-gravado" class="alert alert-success" style="text-align: center; margin: 0 auto 20px; max-width: 600px; display: block; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
            //       <div style="display: flex; align-items: center; justify-content: center;">
            //         <div>
            //           <div>Produto cadastrado com sucesso.</div>
            //         </div>
            //       </div>
            //     </div>
            //   `;

            //   // Remove mensagem anterior se existir
            //   $("#produto-gravado").remove();

            //   // Adiciona a nova mensagem acima das abas
            //   $(".tabs-container").before(mensagemSucesso);

            //   // Configura o fade out após 5 segundos
            //   setTimeout(function () {
            //     $("#produto-gravado").fadeOut(500, function () {
            //       $(this).remove();
            //     });
            //   }, 5000);

            // Resolve a Promise para permitir a continuação do fluxo
            try { resolve(retorno_produto); } catch(e) { resolve(); }
          },
          error: function(xhr, status, error) {
            console.log("Falha ao inserir produto:" + error);
            // Rejeita a Promise para que o chamador possa tratar
            reject(error || status || 'erro_desconhecido');
          },
        });
      });
    }

    // ==============================
    // Captura global: Tipo de Orçamento
    // ==============================
    // Armazena os valores selecionados (pode haver múltiplos checkboxes marcados)
    window.tiposOrcamentoSelecionados = window.tiposOrcamentoSelecionados || [];
    // Snapshot em JSON dos tipos de orçamento selecionados (estado inicial)
    window.tiposOrcamentoSelecionadosJSON = JSON.stringify(window.tiposOrcamentoSelecionados || []);

    // ==============================
    // Captura global: Produtos adicionados/selecionados
    // ==============================
    // Armazena objetos no formato { descricao, quantidade, valorunit }
    window.fatProdutosSelecionados = window.fatProdutosSelecionados || [];
    // Snapshot em JSON dos produtos selecionados (estado inicial)
    window.fatProdutosSelecionadosJSON = JSON.stringify(window.fatProdutosSelecionados || []);

    // Função utilitária para sincronizar o JSON global de produtos
    function fatSyncProdutosJSON() {
      debugger;
      try {
        window.fatProdutosSelecionadosJSON = JSON.stringify(window.fatProdutosSelecionados || []);
        alert(window.fatProdutosSelecionadosJSON);
      } catch(e) {
        console.warn('Falha ao serializar produtos selecionados:', e);
      }
    }

//     function updateSelectedList() {
//   debugger;
//   try {
//     // 🔒 Evita execução duplicada
//     if (window._smDocUpdating) return;
//     window._smDocUpdating = true;

//     const selectedList = document.getElementById('sm-selected-list');
//     const modelosSelecionados = [];
//     const tiposOrcamentoSelecionados = [];

//     // ============================================================
//     // 🔹 Captura modelos de documentos selecionados
//     // ============================================================
//     document.querySelectorAll('.sm-label').forEach(label => {
//       const card = label.querySelector('.sm-card');
//       const checkbox = label.querySelector('input[type="checkbox"]');
//       if (card && checkbox && checkbox.checked) {
//         const text = card.querySelector('span')?.textContent?.trim();
//         if (text) modelosSelecionados.push(text);
//       }
//     });

//     // ============================================================
//     // 🔹 Captura tipos de orçamento selecionados
//     // ============================================================
//     document.querySelectorAll('.tipo-orcamento-label').forEach(label => {
//       const card = label.querySelector('.tipo-orcamento-card');
//       const checkbox = label.querySelector('input[type="checkbox"]');
//       if (card && checkbox && checkbox.checked) {
//         const text = card.querySelector('span')?.textContent?.trim();
//         if (text) tiposOrcamentoSelecionados.push(text);
//       }
//     });

//     // ============================================================
//     // 🔹 Atualiza variáveis globais
//     // ============================================================
//     window._modelosSelecionados = window._modelosSelecionados || [];
//     window._tiposOrcamentoSelecionados = window._tiposOrcamentoSelecionados || [];

//     // Atualiza os dois arrays com base no estado atual
//     window._modelosSelecionados = [...new Set(modelosSelecionados)];
//     window._tiposOrcamentoSelecionados = [...new Set(tiposOrcamentoSelecionados)];

//     // 🔹 Une os dois em uma lista única para exibição
//     window.todosSelecionados = [...window._modelosSelecionados, ...window._tiposOrcamentoSelecionados];

//     // ============================================================
//     // 🔹 Atualiza a interface
//     // ============================================================
//     if (!selectedList) {
//       console.warn('⚠️ Elemento #sm-selected-list não encontrado — apenas variáveis globais foram atualizadas.');
//       window._smDocUpdating = false;
//       return;
//     }

//     selectedList.innerHTML = '';

//     // ============================================================
//     // 🔹 Função para definir cores de ícones
//     // ============================================================
//     const getColorsForText = text => {
//       if (!text) return { bg: '#f3f4f6', fg: '#1f2937' };
//       if (text.toLowerCase().includes('orcamento')) return { bg: '#dbeafe', fg: '#1e40af' };
//       if (text.toLowerCase().includes('modelo')) return { bg: '#d1fae5', fg: '#065f46' };
//       return { bg: '#f3f4f6', fg: '#1f2937' };
//     };

//     // ============================================================
//     // 🔹 Renderiza todos os selecionados (modelos + tipos)
//     // ============================================================
//     todosSelecionados.forEach(text => {
//       const selectedItem = document.createElement('div');
//       selectedItem.className = 'sm-selected-item';

//       const { bg, fg } = getColorsForText(text);
//       selectedItem.style.backgroundColor = bg;
//       selectedItem.style.color = fg;
//       selectedItem.style.display = 'flex';
//       selectedItem.style.alignItems = 'center';
//       selectedItem.style.justifyContent = 'space-between';
//       selectedItem.style.gap = '8px';
//       selectedItem.style.padding = '6px 8px';
//       selectedItem.style.borderRadius = '8px';
//       selectedItem.style.marginBottom = '6px';

//       const textNode = document.createElement('span');
//       textNode.textContent = text;
//       textNode.style.flex = '1';
//       selectedItem.appendChild(textNode);

//       // ============================================================
//       // 🔹 Botão remover (funciona para modelos e tipos)
//       // ============================================================
//       const removeBtn = document.createElement('button');
//       removeBtn.className = 'remove-document';
//       removeBtn.innerHTML = '×';
//       removeBtn.title = 'Remover';
//       removeBtn.onclick = (e) => {
//         e.stopPropagation();

//         // Desmarca o checkbox correspondente
//         document.querySelectorAll('label').forEach(label => {
//           const span = label.querySelector('span');
//           const checkbox = label.querySelector('input[type="checkbox"]');
//           if (span && checkbox && span.textContent.trim() === text) {
//             checkbox.checked = false;
//           }
//         });

//         // Remove o item das variáveis globais
//         window._modelosSelecionados = (window._modelosSelecionados || []).filter(m => m !== text);
//         window._tiposOrcamentoSelecionados = (window._tiposOrcamentoSelecionados || []).filter(t => t !== text);

//         // Atualiza exibição
//         window._smDocUpdating = false;
//         updateSelectedList();
//       };

//       selectedItem.appendChild(removeBtn);
//       selectedList.appendChild(selectedItem);
//     });

//     if (todosSelecionados.length === 0) {
//       selectedList.innerHTML = '<p class="sm-empty-message">Nenhum item selecionado</p>';
//     }

//     // ============================================================
//     // 🔹 Gera JSONs para uso posterior
//     // ============================================================
//     window.smDocumentosSelecionadosJSON = JSON.stringify(window._modelosSelecionados || []);
//     window.tiposOrcamentoSelecionadosJSON = JSON.stringify(window._tiposOrcamentoSelecionados || []);

//     console.log('✅ updateSelectedList → modelos:', window._modelosSelecionados, 'tipos:', window._tiposOrcamentoSelecionados);

//   } catch (err) {
//     console.error('❌ Erro em updateSelectedList:', err);
//   } finally {
//     window._smDocUpdating = false;
//   }
// }


function updateSelectedList() {
  debugger;
  try {
    if (window._smDocUpdating) return;
    window._smDocUpdating = true;

    const selectedList = document.getElementById('sm-selected-list');
    if (!selectedList) {
      console.warn('⚠️ Elemento #sm-selected-list não encontrado.');
      window._smDocUpdating = false;
      return;
    }

    const modelosSelecionados = [];
    const tiposOrcamentoSelecionados = [];

    // 🔹 Coleta modelos selecionados
    document.querySelectorAll('.sm-label').forEach(label => {
      const card = label.querySelector('.sm-card');
      const checkbox = label.querySelector('input[type="checkbox"]');
      if (card && checkbox && checkbox.checked) {
        const text = card.querySelector('span')?.textContent?.trim();
        if (text) modelosSelecionados.push({ text, card, checkbox });
      }
    });

    // 🔹 Coleta tipos de orçamento selecionados (armazenamento apenas)
    document.querySelectorAll('.tipo-orcamento-label').forEach(label => {
      const checkbox = label.querySelector('input[type="checkbox"]');
      const text = label.querySelector('span')?.textContent?.trim();
      if (checkbox && checkbox.checked && text) {
        tiposOrcamentoSelecionados.push(text);
      }
    });

    // 🔹 Atualiza variáveis globais
    window._modelosSelecionados = [...new Set(modelosSelecionados.map(m => m.text))];
    window._tiposOrcamentoSelecionados = [...new Set(tiposOrcamentoSelecionados)];

    // 🔹 Armazena todos os selecionados (modelos + tipos)
    window.todosSelecionados = [...window._modelosSelecionados, ...window._tiposOrcamentoSelecionados];

    // 🔹 Limpa exibição anterior
    selectedList.innerHTML = '';

    // 🎨 Função para definir cores com base no ícone
    const colorsFromIcon = (icon) => {
      let bgColor = '#f3f4f6';
      let textColor = '#1f2937';

      if (icon) {
        if (icon.classList.contains('fa-paper-plane')) {
          bgColor = '#dbeafe'; textColor = '#1e40af';
        } else if (icon.classList.contains('fa-clipboard-list')) {
          bgColor = '#d1fae5'; textColor = '#065f46';
        } else if (icon.classList.contains('fa-file-medical')) {
          bgColor = '#fef3c7'; textColor = '#92400e';
        } else if (icon.classList.contains('fa-eye')) {
          bgColor = '#fee2e2'; textColor = '#991b1b';
        } else if (icon.classList.contains('fa-users')) {
          bgColor = '#e0e7ff'; textColor = '#3730a3';
        } else if (icon.classList.contains('fa-exclamation-triangle')) {
          bgColor = '#fef3c7'; textColor = '#92400e';
        } else if (icon.classList.contains('fa-file-alt')) {
          bgColor = '#1e1b4b'; textColor = '#ffffff';
        } else if (icon.classList.contains('fa-dollar-sign')) {
          bgColor = '#ecfdf5'; textColor = '#065f46';
        } else if (icon.classList.contains('fa-stethoscope')) {
          bgColor = '#f3e8ff'; textColor = '#6d28d9';
        } else if (icon.classList.contains('fa-graduation-cap')) {
          bgColor = '#fff7ed'; textColor = '#9a3412';
        } else if (icon.classList.contains('fa-hard-hat')) {
          bgColor = '#fef9c3'; textColor = '#854d0e';
        }
      }

      return { bgColor, textColor };
    };

    // 🔸 Exibe apenas os modelos
    modelosSelecionados.forEach(({ text, card, checkbox }) => {
      const selectedItem = document.createElement('div');
      selectedItem.className = 'sm-selected-item';
      selectedItem.style.display = 'flex';
      selectedItem.style.alignItems = 'center';
      selectedItem.style.justifyContent = 'space-between';
      selectedItem.style.gap = '8px';
      selectedItem.style.padding = '6px 8px';
      selectedItem.style.borderRadius = '8px';
      selectedItem.style.marginBottom = '6px';

      // Aplica cores conforme o ícone
      const icon = card ? card.querySelector('i') : null;
      const { bgColor, textColor } = colorsFromIcon(icon);
      selectedItem.style.backgroundColor = bgColor;
      selectedItem.style.color = textColor;

      // Clona ícone (se existir)
      if (icon) {
        const iconClone = icon.cloneNode(true);
        iconClone.classList.add('sm-selected-icon');
        selectedItem.appendChild(iconClone);
      }

      // Texto do modelo
      const textNode = document.createElement('span');
      textNode.textContent = text;
      textNode.style.flex = '1';
      selectedItem.appendChild(textNode);

      // Botão remover
      const removeBtn = document.createElement('button');
      removeBtn.className = 'remove-document';
      removeBtn.innerHTML = '×';
      removeBtn.title = 'Remover';
      removeBtn.style.cursor = 'pointer';
      removeBtn.style.border = 'none';
      removeBtn.style.background = 'transparent';
      removeBtn.style.fontSize = '18px';
      removeBtn.style.lineHeight = '1';
      removeBtn.style.padding = '2px 6px';

      removeBtn.onclick = (e) => {
        e.stopPropagation();

        // Desmarca o checkbox
        if (checkbox) checkbox.checked = false;

        // Remove das variáveis globais
        window._modelosSelecionados = (window._modelosSelecionados || []).filter(m => m !== text);

        // Atualiza exibição
        window._smDocUpdating = false;
        updateSelectedList();
      };

      selectedItem.appendChild(removeBtn);
      selectedList.appendChild(selectedItem);
    });

    // 🔸 Mensagem quando não houver modelos
    if (window._modelosSelecionados.length === 0) {
      selectedList.innerHTML = '<p class="sm-empty-message">Nenhum modelo selecionado</p>';
    }

    console.log('✅ Modelos:', window._modelosSelecionados, 'Tipos:', window._tiposOrcamentoSelecionados);

    window.smDocumentosSelecionadosJSON = JSON.stringify(window._modelosSelecionados || []);
    window.tiposOrcamentoSelecionadosJSON = JSON.stringify(window._tiposOrcamentoSelecionados || []);
  } catch (err) {
    console.error('❌ Erro em updateSelectedList:', err);
  } finally {
    window._smDocUpdating = false;
  }
}


    // Função auxiliar para atualizar a lista global a partir do DOM
    function atualizarTiposOrcamentoSelecionados() {
      // debugger;
      // try {
      //   const selecionados = Array.from(document.querySelectorAll('input.tipo-orcamento:checked'))
      //     .map(el => el.value);
      //   window.tiposOrcamentoSelecionados = selecionados;
      //   // Mantém o snapshot JSON sempre sincronizado após cada atualização
      //   window.tiposOrcamentoSelecionadosJSON = JSON.stringify(window.tiposOrcamentoSelecionados || []);
      //   console.log('Tipos de orçamento selecionados:', window.tiposOrcamentoSelecionados);
      // } catch (e) {
      //   console.warn('Falha ao atualizar tipos de orçamento selecionados:', e);
      // }

      tratar_modelos_orcamentos();
    }

    function tratar_modelos_orcamentos() {
  try { window._smDocUpdating = false; } catch (e) {}
  if (typeof updateSelectedList === 'function') {
    updateSelectedList();
  } else {
    console.warn('updateSelectedList() ainda não está disponível.');
  }
}

    // Delegação de eventos: funciona mesmo com conteúdo dinâmico da aba
    // document.addEventListener('change', function(e) {
    //   if (e.target && e.target.matches('input.tipo-orcamento')) {
    //     atualizarTiposOrcamentoSelecionados();
    //   }
    // });

    // Delegação de eventos: funciona mesmo com conteúdo dinâmico da aba
document.addEventListener('change', function(e) {
  const t = e && e.target ? e.target : null;
  if (!t || !t.matches) return;

  const isTipoOrcamento = t.matches('input.tipo-orcamento');
  const isModeloSelecionado = t.matches('.sm-label input.sm-checkbox') || t.matches('.sm-checkbox');

  if (isTipoOrcamento || isModeloSelecionado) {
    tratar_modelos_orcamentos();
  }
});

    // Inicializa a variável global com o estado atual quando o DOM estiver pronto
    // if (document.readyState === 'loading') {
    //   document.addEventListener('DOMContentLoaded', atualizarTiposOrcamentoSelecionados);
    // } else {
    //   atualizarTiposOrcamentoSelecionados();
    // }

    // Inicializa a lista quando o DOM estiver pronto
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', tratar_modelos_orcamentos);
} else {
  tratar_modelos_orcamentos();
}

// Busca incremental (live search) para #fat-descricao usando $.ajax (GET)
function initFatDescricaoLiveSearch(){
  debugger;
  const $input = $('#fat-descricao');
  if ($input.length === 0) return false; // não encontrou ainda
  if ($input.data('lsBound') === true) return true; // já inicializado

  // Container de sugestões
  let $container = $input.closest('.fat-input-group');
  if ($container.length === 0) {
    $container = $input.parent();
  }
  if ($container.length === 0) {
    $container = $('body');
  }
  if ($container.css('position') === 'static') {
    $container.css('position', 'relative');
  }
  let $list = $('#fat-suggestions');
  if ($list.length === 0) {
    $list = $('<div id="fat-suggestions" />').css({
      position: 'absolute',
      top: '100%',
      left: 0,
      width: '100%',
      background: '#fff',
      border: '1px solid #e2e8f0',
      borderTop: 'none',
      borderRadius: '0 0 6px 6px',
      boxShadow: '0 6px 16px rgba(0,0,0,0.08)',
      zIndex: 1000,
      display: 'none',
      maxHeight: '240px',
      overflowY: 'auto'
    });
    $container.append($list);
  }

  const debounce = function(fn, wait){
    let t; return function(){ clearTimeout(t); const args = arguments; t = setTimeout(function(){ fn.apply(null, args); }, wait); };
  };

  function renderSuggestions(produtos){
    debugger;
    if (!Array.isArray(produtos) || produtos.length === 0) { $list.hide().empty(); return; }
    const html = produtos.map(p => {
      const nome = p && (p.nome || p.NOME || p.descricao || p.DESCRICAO) ? (p.nome || p.NOME || p.descricao || p.DESCRICAO) : '';
      return `
            <div class="fat-suggestion-item" data-nome="${String(nome).replace(/"/g,'&quot;')}">
          <i class="fas fa-box" style="color:#4a5568;margin-right:8px;"></i>
          <span>${nome}</span>
        </div>`;
    }).join('');

    $list.html(html).show();
    // estilo dos itens
    $list.find('.fat-suggestion-item').css({
      padding: '8px 10px',
      cursor: 'pointer',
      display: 'flex',
      alignItems: 'center'
    }).off('mouseenter mouseleave click')
      .on('mouseenter', function(){ $(this).css('background', '#f7fafc'); })
      .on('mouseleave', function(){ $(this).css('background', '#fff'); })
      .on('click', function(){
        debugger;
        const nome = $(this).data('nome') || '';
        $input.val(nome);
        $list.hide().empty();
        $input.trigger('change');

        // Tenta armazenar no array global se quantidade e valor unitário forem válidos no momento da seleção
        try {
          const qtdEl = document.getElementById('fat-quantidade');
          const vuEl = document.getElementById('fat-valorUnit');
          const q = parseInt(qtdEl && qtdEl.value);
          const vu = parseFloat(vuEl && vuEl.value);
          if (!isNaN(q) && !isNaN(vu)) {
            window.fatProdutosSelecionados = window.fatProdutosSelecionados || [];
            window.fatProdutosSelecionados.push({ descricao: nome, quantidade: q, valorunit: vu });
            fatSyncProdutosJSON();
          } else {
            // Se ainda não há quantidade/valor, apenas sincroniza o JSON atual (sem inserir incompleto)
            fatSyncProdutosJSON();
          }
        } catch(e) { console.warn('Não foi possível registrar seleção do produto no array global:', e); }
      });
  }

  const doSearch = debounce(function(term){
    term = (term || '').trim();
    if (!term) { $list.hide().empty(); return; }
    $.ajax({
      url: 'cadastros/processa_produto.php',
      method: 'GET',
      dataType: 'json',
      data: {
        processo_produto: 'buscar_produto_nome',
        valor_descricao_produto: term
      },
      success: function(data){
        debugger;
        try { renderSuggestions(data); } catch(e) { console.error('Falha ao renderizar sugestões:', e); }
      },
      error: function(xhr, status, error){
        console.warn('Falha ao buscar produtos:', status, error);
        $list.hide().empty();
      }
    });
  }, 300);

  $input.on('input', function(){ doSearch(this.value); });
  // Oculta ao clicar fora
  $(document).on('click', function(e){
    if (!$.contains($container.get(0), e.target)) { $list.hide(); }
  });
  // Mostra lista se houver conteúdo ao focar
  $input.on('focus', function(){ if ($list.children().length > 0) $list.show(); });
  // Esc para fechar
  $input.on('keydown', function(ev){ if (ev.key === 'Escape') { $list.hide(); } });
  // marca como inicializado para evitar bind duplicado
  $input.data('lsBound', true);
  return true;
}
  let codigoProduto;

  // Variáveis de estado
    let fatTotalEPI = 0;
    let fatTotalExames = 0; // Será atualizado dinamicamente
    let fatTotalTreinamentos = 0; // Será atualizado dinamicamente

    let recebe_nome_produto;
    let recebe_valor_produto;
    let recebe_quantidade_produto;
  // Função para adicionar produto (assíncrona, com gravação)
  window.fatAdicionarProduto = async function() {
  debugger;
  if (window._fatSaving) return;
  window._fatSaving = true;

  try {
    const descricao = document.getElementById('fat-descricao')?.value.trim();
    const quantidade = parseInt(document.getElementById('fat-quantidade')?.value);
    const valorUnit = parseFloat(document.getElementById('fat-valorUnit')?.value);

    if (!descricao || isNaN(quantidade) || isNaN(valorUnit)) {
      alert('Preencha todos os campos corretamente.');
      return;
    }

    const produtoAtual = {
      nome: descricao,
      quantidade: quantidade,
      valorunit: valorUnit
    };

    recebe_nome_produto = descricao;
    recebe_valor_produto = valorUnit;
    recebe_quantidade_produto = quantidade;

    const retorno = await grava_produto();
    const codigoProduto = retorno ?? null;
    produtoAtual.id = codigoProduto;

    window.fatProdutosGlobais = window.fatProdutosGlobais || [];
    window.fatProdutosGlobais.push(produtoAtual);

    const valorTotal = quantidade * valorUnit;
    window.fatTotalEPI = (window.fatTotalEPI || 0) + valorTotal;

    console.log('Produto adicionado. Novo total EPI/EPC:', window.fatTotalEPI);

    // 🔹 Cria os estilos apenas uma vez
    if (!document.getElementById('fat-styles')) {
      const style = document.createElement('style');
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
          box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1),
                      0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .fat-produto-item > div { padding: 4px 8px; }
        .fat-produto-descricao { flex: 3; font-weight: 500; color: #1a365d; }
        .fat-produto-quantidade, .fat-produto-valor-unit, .fat-produto-total {
          flex: 1;
          text-align: center;
          color: #4a5568;
        }
        .fat-produto-total { font-weight: 600; color: #2b6cb0; }
        .fat-produto-acoes { flex: 0.8; text-align: center; }
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
        .btn-remover i { font-size: 14px; }
      `;
      document.head.appendChild(style);
    }

    // 🔹 Seleciona a lista de produtos
    const listaProdutos = document.getElementById('fat-lista-produtos');
    if (!listaProdutos) {
      console.error('Elemento #fat-lista-produtos não encontrado.');
      return;
    }

    listaProdutos.innerHTML = ''; // <- aqui limpa tudo, incluindo "Nenhum produto disponível"

    // 🔹 Remove qualquer mensagem de “Nenhum produto disponível”
    // const mensagens = listaProdutos.querySelectorAll('.fat-sem-produtos, div[style*="Nenhum produto disponível"]');
    // mensagens.forEach(msg => msg.remove());

    // // 🔹 Cria a linha do novo produto
    // const linha = document.createElement('div');
    // linha.className = 'fat-produto-item';
    // linha.innerHTML = `
    //   <div class="fat-produto-descricao">${descricao}</div>
    //   <div class="fat-produto-quantidade">${quantidade}</div>
    //   <div class="fat-produto-valor-unit">${fatFormatter.format(valorUnit)}</div>
    //   <div class="fat-produto-total">${fatFormatter.format(valorTotal)}</div>
    //   <div class="fat-produto-acoes">
    //     <button class="btn-remover" onclick="fatRemoverProduto(this, ${codigoProduto}, ${valorTotal})">
    //       <i class="fas fa-trash-alt"></i> Remover
    //     </button>
    //   </div>
    // `;

    // // 🔹 Adiciona o produto à lista
    // listaProdutos.appendChild(linha);

    // 🔹 Renderiza novamente todos os produtos atuais
    window.fatProdutosGlobais.forEach(p => {
      const valorTotalItem = p.quantidade * p.valorunit;

      const linha = document.createElement('div');
      linha.className = 'fat-produto-item';
      linha.innerHTML = `
        <div class="fat-produto-descricao">${p.nome}</div>
        <div class="fat-produto-quantidade">${p.quantidade}</div>
        <div class="fat-produto-valor-unit">${fatFormatter.format(p.valorunit)}</div>
        <div class="fat-produto-total">${fatFormatter.format(valorTotalItem)}</div>
        <div class="fat-produto-acoes">
          <button class="btn-remover" onclick="fatRemoverProduto(this, ${p.id}, ${valorTotalItem})">
            <i class="fas fa-trash-alt"></i> Remover
          </button>
        </div>
      `;
      listaProdutos.appendChild(linha);
    });

    // 🔹 Atualiza o array global e sincroniza JSON
    try {
      window.fatProdutosSelecionados = window.fatProdutosSelecionados || [];
      window.fatProdutosSelecionados.push({ descricao, quantidade, valorunit: valorUnit });
      fatSyncProdutosJSON();
    } catch (e) {
      console.warn('Falha ao registrar produto no array global:', e);
    }

    // 🔹 Limpa os campos
    document.getElementById('fat-descricao').value = '';
    document.getElementById('fat-quantidade').value = '1';
    document.getElementById('fat-valorUnit').value = '';

    // 🔹 Atualiza totais se a função existir
    if (typeof window.fatAtualizarTotais === 'function') {
      window.fatAtualizarTotais();
    }

  } catch (e) {
    console.error('Erro ao adicionar produto:', e);
  } finally {
    window._fatSaving = false;
  }
};




  // ============================================================
// 🔹 Função para adicionar produto
// ============================================================
// window.fatAdicionarProduto = async function() {
//   debugger;
//   const descricao = document.getElementById('fat-descricao')?.value.trim();
//   const quantidade = parseInt(document.getElementById('fat-quantidade')?.value);
//   const valorUnit = parseFloat(document.getElementById('fat-valorUnit')?.value);

//   if (!descricao || isNaN(quantidade) || isNaN(valorUnit)) {
//     alert('Preencha todos os campos corretamente.');
//     return;
//   }

//   // Armazena dados do produto atual
//   const produtoAtual = {
//     nome: descricao,
//     quantidade: quantidade,
//     valorunit: valorUnit
//   };

//   // 🔹 Salva em variáveis individuais (se quiser manter compatibilidade)
//   window.recebe_nome_produto = descricao;
//   window.recebe_valor_produto = valorUnit;
//   window.recebe_quantidade_produto = quantidade;

//   recebe_nome_produto = descricao;
//   recebe_valor_produto = valorUnit;
//   recebe_quantidade_produto = quantidade;

//   // 🔹 Grava produto e obtém retorno do servidor
//   const retorno = await grava_produto();
//   const codigoProduto = retorno?.codigo_produto ?? null;

//   if (!codigoProduto) {
//     alert('Não foi possível obter o código do produto cadastrado.');
//     return;
//   }

//   // Inclui código retornado do backend
//   produtoAtual.id = codigoProduto;

//   // Adiciona produto ao array global
//   window.fatProdutosGlobais.push(produtoAtual);
//   console.log('Produto armazenado globalmente:', window.fatProdutosGlobais);

//   const valorTotal = quantidade * valorUnit;

//   // Atualiza total global de EPI/EPC
//   window.fatTotalEPI = (window.fatTotalEPI || 0) + valorTotal;
//   console.log('Produto adicionado. Novo total EPI/EPC:', window.fatTotalEPI);

//   // Aplica estilos caso não existam
//   const style = document.createElement('style');
//   if (!document.getElementById('fat-styles')) {
//     style.id = 'fat-styles';
//     style.textContent = `
//       .fat-produto-item {
//         display: flex;
//         align-items: center;
//         gap: 15px;
//         padding: 12px 15px;
//         color: #2d3748;
//         font-size: 14px;
//         border-bottom: 1px solid #e2e8f0;
//         transition: all 0.2s ease;
//         background-color: white;
//         border-radius: 8px;
//         margin-bottom: 8px;
//         box-shadow: 0 1px 3px rgba(0,0,0,0.05);
//       }
//       .fat-produto-item:hover {
//         background-color: #f8fafc;
//         transform: translateY(-1px);
//         box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 
//                     0 2px 4px -1px rgba(0, 0, 0, 0.06);
//       }
//       .fat-produto-item > div { padding: 4px 8px; }
//       .fat-produto-descricao { flex: 3; font-weight: 500; color: #1a365d; }
//       .fat-produto-quantidade, .fat-produto-valor-unit, .fat-produto-total {
//         flex: 1; text-align: center; color: #4a5568;
//       }
//       .fat-produto-total { font-weight: 600; color: #2b6cb0; }
//       .fat-produto-acoes { flex: 0.8; text-align: center; }
//       .btn-remover {
//         background-color: #fff;
//         color: #e53e3e;
//         border: 1px solid #fed7d7;
//         border-radius: 6px;
//         padding: 6px 12px;
//         font-size: 13px;
//         font-weight: 500;
//         cursor: pointer;
//         display: inline-flex;
//         align-items: center;
//         gap: 4px;
//         transition: all 0.2s ease;
//       }
//       .btn-remover:hover {
//         background-color: #feb2b2;
//         color: #9b2c2c;
//         transform: translateY(-1px);
//       }
//       .btn-remover i { font-size: 14px; }
//     `;
//     document.head.appendChild(style);
//   }

//   // Cria elemento visual do produto
//   const linha = document.createElement('div');
//   linha.className = 'fat-produto-item';
//   linha.innerHTML = [
//     `<div class="fat-produto-descricao">${descricao}</div>`,
//     `<div class="fat-produto-quantidade">${quantidade}</div>`,
//     `<div class="fat-produto-valor-unit">${fatFormatter.format(valorUnit)}</div>`,
//     `<div class="fat-produto-total">${fatFormatter.format(valorTotal)}</div>`,
//     '<div class="fat-produto-acoes">',
//     `  <button class="btn-remover" onclick="fatRemoverProduto(this, ${codigoProduto}, ${valorTotal})">`,
//     '    <i class="fas fa-trash-alt"></i> Remover',
//     '  </button>',
//     '</div>'
//   ].join('');
  
//   // Adiciona na lista
//   document.getElementById('fat-lista-produtos').appendChild(linha);

//   // Limpa campos
//   document.getElementById('fat-descricao').value = '';
//   document.getElementById('fat-quantidade').value = '1';
//   document.getElementById('fat-valorUnit').value = '';

//   // Atualiza totais
//   if (typeof window.fatAtualizarTotais === 'function') {
//     window.fatAtualizarTotais();
//   }
// };

  // Função para remover produto
    window.fatRemoverProduto = async function(botao, codigo,valorTotal) {
      debugger;
      window.recebe_codigo_produto = codigo;
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
      }).then(async (result) => {
        if (result.isConfirmed) {
          debugger;

          await exclui_produto();

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

//     function fatAtualizarTotais() {
//   debugger;

//   const isEdicao = window.recebe_acao === 'editar';

//   // ================================
//   // 🧭 Conversor seguro para número BR
//   // ================================
//   const toNumberBR = (val) => {
//     if (val === null || val === undefined) return 0;
//     if (typeof val === 'number') return isFinite(val) ? val : 0;
//     if (typeof val === 'string') {
//       const limpo = val
//         .replace(/[^0-9,.-]/g, '')
//         .replace(/\.(?=\d{3}(\D|$))/g, '')
//         .replace(',', '.');
//       const n = parseFloat(limpo);
//       return isNaN(n) ? 0 : n;
//     }
//     if (typeof val === 'object' && val !== null && 'valor' in val) {
//       return toNumberBR(val.valor);
//     }
//     return 0;
//   };

//   // 🔹 Formatter BR (único global)
//   if (!window.fatFormatter) {
//     window.fatFormatter = new Intl.NumberFormat('pt-BR', {
//       style: 'currency',
//       currency: 'BRL',
//     });
//   }

//   // ================================
//   // 🔸 Modo de edição
//   // ================================
//   if (isEdicao) {
//     console.log('🟠 Modo edição detectado — totais serão atualizados com base em dados existentes');

//     // 🔹 Trata EXAMES (string JSON ou array)
//     try {
//       const examesLista = Array.isArray(window.exames)
//         ? window.exames
//         : JSON.parse(window.exames || '[]');

//       window.fatTotalExames = examesLista.reduce(
//         (acc, ex) => acc + (toNumberBR(ex.valor) || 0),
//         0
//       );
//     } catch {
//       window.fatTotalExames = 0;
//     }

//     // 🔹 Trata TREINAMENTOS (string JSON ou array)
//     try {
//       const treinLista = Array.isArray(window.treinamentos)
//         ? window.treinamentos
//         : JSON.parse(window.treinamentos || '[]');

//       window.fatTotalTreinamentos = treinLista.reduce(
//         (acc, tr) => acc + (toNumberBR(tr.valor) || 0),
//         0
//       );
//     } catch {
//       window.fatTotalTreinamentos = 0;
//     }

//     // 🧮 Usa o total de produtos já definido por repopular_produtos
//     window.fatTotalEPI = parseFloat(window.fatTotalEPI) || 0;
//   }

//   // ================================
//   // 🔸 Quando NÃO for edição
//   // ================================
//   else {
//     console.log('🟢 Modo inclusão — garantindo existência das variáveis globais');

//     // Garante existência sem sobrescrever
//     window.fatTotalExames = window.fatTotalExames || 0;
//     window.fatTotalTreinamentos = window.fatTotalTreinamentos || 0;
//     window.fatTotalEPI = window.fatTotalEPI || 0;

//     // 🔹 Converte e soma EXAMES
//     try {
//       const examesLista = Array.isArray(window.exames)
//         ? window.exames
//         : JSON.parse(window.exames || '[]');

//       window.fatTotalExames = examesLista.reduce(
//         (acc, ex) => acc + (toNumberBR(ex.valor) || 0),
//         0
//       );
//     } catch {
//       window.fatTotalExames = 0;
//     }

//     // 🔹 Converte e soma TREINAMENTOS
//     try {
//       const treinLista = Array.isArray(window.treinamentos)
//         ? window.treinamentos
//         : JSON.parse(window.treinamentos || '[]');

//       window.fatTotalTreinamentos = treinLista.reduce(
//         (acc, tr) => acc + (toNumberBR(tr.valor) || 0),
//         0
//       );
//     } catch {
//       window.fatTotalTreinamentos = 0;
//     }

//     // ⚙️ EPI (já vem de repopular_produtos)
//   }

//   // ================================
//   // 🧾 Cálculo total geral
//   // ================================
//   const totalEPI = toNumberBR(window.fatTotalEPI);
//   const totalExames = toNumberBR(window.fatTotalExames);
//   const totalTreinamentos = toNumberBR(window.fatTotalTreinamentos);
//   const totalGeral = totalEPI + totalExames + totalTreinamentos;
//   window.total_final = totalGeral;

//   console.log('💰 Valores atuais dos totais:', {
//     fatTotalExames: totalExames,
//     fatTotalTreinamentos: totalTreinamentos,
//     fatTotalEPI: totalEPI,
//     totalGeral: totalGeral,
//   });

//   // ================================
//   // 🧩 Atualiza visualmente no DOM
//   // ================================
//   const updateElementIfExists = (id, value) => {
//     try {
//       const element = document.getElementById(id);
//       if (!element) return false;

//       const numeric = toNumberBR(value);
//       const formattedValue = window.fatFormatter.format(numeric);

//       if (element.textContent !== formattedValue) {
//         element.textContent = formattedValue;
//       }
//       return true;
//     } catch (error) {
//       console.error(`Erro ao atualizar o elemento ${id}:`, error);
//       return false;
//     }
//   };

//   const elementsUpdated = [
//     updateElementIfExists('fat-total-epi', totalEPI),
//     updateElementIfExists('fat-total-exames', totalExames),
//     updateElementIfExists('fat-total-treinamentos', totalTreinamentos),
//     updateElementIfExists('fat-total-geral', totalGeral),
//   ];

//   // Caso os elementos individuais não existam, atualiza container completo
//   if (elementsUpdated.some((u) => !u)) {
//     const container = document.getElementById('fat-totais-container');
//     if (container) {
//       container.innerHTML = `
//         <div class="fat-total-item">
//           <span>EPI/EPC:</span>
//           <span id="fat-total-epi">${window.fatFormatter.format(totalEPI)}</span>
//         </div>
//         <div class="fat-total-item">
//           <span>Exames:</span>
//           <span id="fat-total-exames">${window.fatFormatter.format(totalExames)}</span>
//         </div>
//         <div class="fat-total-item">
//           <span>Treinamentos:</span>
//           <span id="fat-total-treinamentos">${window.fatFormatter.format(totalTreinamentos)}</span>
//         </div>
//         <div class="fat-total-item" style="margin-top: 15px; padding-top: 15px; border-top: 2px solid #e2e8f0;">
//           <span style="font-weight: 600; font-size: 16px; color: #2d3748;">Total Geral:</span>
//           <span id="fat-total-geral" style="font-weight: 700; font-size: 18px; color: #2b6cb0;">
//             ${window.fatFormatter.format(totalGeral)}
//           </span>
//         </div>
//       `;
//     }
//   }

//   // ================================
//   // 🔔 Dispara evento de atualização
//   // ================================
//   const event = new CustomEvent('totaisAtualizados', {
//     detail: { totalEPI, totalExames, totalTreinamentos, totalGeral },
//   });
//   document.dispatchEvent(event);
// }

function fatAtualizarTotais() {
  debugger;

  const isEdicao = window.recebe_acao === 'editar';

  // ================================
  // 🧭 Conversor seguro para número BR
  // ================================
  const toNumberBR = (val) => {
    if (val === null || val === undefined) return 0;
    if (typeof val === 'number') return isFinite(val) ? val : 0;
    if (typeof val === 'string') {
      const limpo = val.replace(/[^0-9,.-]/g, '').replace(/\.(?=\d{3}(\D|$))/g, '').replace(',', '.');
      const n = parseFloat(limpo);
      return isNaN(n) ? 0 : n;
    }
    if (typeof val === 'object' && val !== null && 'valor' in val) {
      return toNumberBR(val.valor);
    }
    return 0;
  };

  // 🔹 Formatter BR (global)
  if (!window.fatFormatter) {
    window.fatFormatter = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' });
  }

  // ================================
  // 🔹 Função auxiliar para somar lista
  // ================================
  const somarLista = (lista, valorPadrao = 0) => {
    try {
      const arr = Array.isArray(lista) ? lista : JSON.parse(lista || '[]');
      return arr.reduce((acc, item) => acc + (toNumberBR(item.valor) || 0), 0);
    } catch {
      return valorPadrao;
    }
  };

  // ================================
  // 🔸 Atualiza totais
  // ================================
  if (isEdicao) {
    console.log('🟠 Modo edição — recalculando totais a partir dos dados existentes');
    window.fatTotalExames = somarLista(window.exames);
    window.fatTotalTreinamentos = somarLista(window.treinamentos);
    window.fatTotalEPI = parseFloat(window.fatTotalEPI) || 0;
  } else {
    console.log('🟢 Modo inclusão — usando valores existentes das variáveis globais');

    // Usa os valores existentes ou calcula se ainda não houver
    window.fatTotalExames = window.fatTotalExames || somarLista(window.exames, 0);
    window.fatTotalTreinamentos = window.fatTotalTreinamentos || somarLista(window.treinamentos, 0);
    window.fatTotalEPI = window.fatTotalEPI || 0;
  }

  // ================================
  // 🧾 Cálculo total geral
  // ================================
  const totalEPI = toNumberBR(window.fatTotalEPI);
  const totalExames = toNumberBR(window.fatTotalExames);
  const totalTreinamentos = toNumberBR(window.fatTotalTreinamentos);
  const totalGeral = totalEPI + totalExames + totalTreinamentos;
  window.total_final = totalGeral;

  console.log('💰 Totais atualizados:', { totalEPI, totalExames, totalTreinamentos, totalGeral });

  // ================================
  // 🧩 Atualiza visualmente no DOM
  // ================================
  const updateElementIfExists = (id, value) => {
    try {
      const element = document.getElementById(id);
      if (!element) return false;
      const numeric = toNumberBR(value);
      const formattedValue = window.fatFormatter.format(numeric);
      if (element.textContent !== formattedValue) element.textContent = formattedValue;
      return true;
    } catch (error) {
      console.error(`Erro ao atualizar ${id}:`, error);
      return false;
    }
  };

  const elementsUpdated = [
    updateElementIfExists('fat-total-epi', totalEPI),
    updateElementIfExists('fat-total-exames', totalExames),
    updateElementIfExists('fat-total-treinamentos', totalTreinamentos),
    updateElementIfExists('fat-total-geral', totalGeral),
  ];

  // Atualiza container completo se algum elemento individual não existir
  if (elementsUpdated.some(u => !u)) {
    const container = document.getElementById('fat-totais-container');
    if (container) {
      container.innerHTML = `
        <div class="fat-total-item">
          <span>EPI/EPC:</span>
          <span id="fat-total-epi">${window.fatFormatter.format(totalEPI)}</span>
        </div>
        <div class="fat-total-item">
          <span>Exames:</span>
          <span id="fat-total-exames">${window.fatFormatter.format(totalExames)}</span>
        </div>
        <div class="fat-total-item">
          <span>Treinamentos:</span>
          <span id="fat-total-treinamentos">${window.fatFormatter.format(totalTreinamentos)}</span>
        </div>
        <div class="fat-total-item" style="margin-top:15px; padding-top:15px; border-top:2px solid #e2e8f0;">
          <span style="font-weight:600; font-size:16px; color:#2d3748;">Total Geral:</span>
          <span id="fat-total-geral" style="font-weight:700; font-size:18px; color:#2b6cb0;">
            ${window.fatFormatter.format(totalGeral)}
          </span>
        </div>
      `;
    }
  }

  // ================================
  // 🔔 Dispara evento de atualização
  // ================================
  document.dispatchEvent(new CustomEvent('totaisAtualizados', {
    detail: { totalEPI, totalExames, totalTreinamentos, totalGeral },
  }));
}



  
        // Função para atualizar totais
        // function fatAtualizarTotais() {
        //   debugger;
        //   try {
        //     console.log('=== Iniciando fatAtualizarTotais ===');
            
        //     // Garante que as variáveis globais estão definidas
        //     window.fatTotalEPI = window.fatTotalEPI || 0;
        //     window.fatTotalExames = window.fatTotalExames || 0;
        //     window.fatTotalTreinamentos = window.fatTotalTreinamentos || 0;
            
        //     // Utilitário: converte string/valor em número no padrão pt-BR (remove R$, pontos de milhar e usa vírgula como decimal)
        //     const toNumberBR = (val) => {
        //       if (val === null || val === undefined) return 0;
        //       if (typeof val === 'number') return isFinite(val) ? val : 0;
        //       if (typeof val === 'string') {
        //         // Mantém apenas dígitos, vírgula, ponto, sinal; remove "R$", espaços e outros
        //         const limpo = val.replace(/[^0-9,.-]/g, '')
        //                          .replace(/\.(?=\d{3}(\D|$))/g, '') // remove pontos de milhar
        //                          .replace(',', '.'); // usa ponto como separador decimal
        //         const n = parseFloat(limpo);
        //         return isNaN(n) ? 0 : n;
        //       }
        //       // Suporta objetos com propriedade "valor"
        //       if (typeof val === 'object' && val !== null && 'valor' in val) {
        //         return toNumberBR(val.valor);
        //       }
        //       return 0;
        //     };

        //     // Inicializa o formatter se não existir
        //     if (!window.fatFormatter) {
        //       window.fatFormatter = new Intl.NumberFormat('pt-BR', {
        //         style: 'currency',
        //         currency: 'BRL',
        //       });
        //     }
            
        //     // Normaliza valores e calcula o total geral (evita NaN)
        //     const totalEPI = toNumberBR(window.fatTotalEPI);
        //     const totalExames = toNumberBR(window.fatTotalExames);
        //     const totalTreinamentos = toNumberBR(window.fatTotalTreinamentos);
        //     const totalGeral = totalEPI + totalExames + totalTreinamentos;
            
        //     window.total_final = totalGeral;

        //     console.log('Valores atuais dos totais:', {
        //       fatTotalExames: totalExames,
        //       fatTotalTreinamentos: totalTreinamentos,
        //       fatTotalEPI: totalEPI,
        //       totalGeral: totalGeral,
        //       fatFormatter: window.fatFormatter ? 'Disponível' : 'Indisponível'
        //     });
            
        //     // Função auxiliar para atualizar o conteúdo de um elemento se ele existir
        //     const updateElementIfExists = (id, value) => {
        //       try {
        //         const element = document.getElementById(id);
        //         if (!element) {
        //           console.warn(`Elemento não encontrado: ${id}`);
        //           return false;
        //         }
                
        //         // Formata o valor
        //         let formattedValue;
        //         try {
        //           const numeric = toNumberBR(value);
        //           formattedValue = window.fatFormatter.format(numeric);
        //         } catch (e) {
        //           console.warn(`Erro ao formatar valor ${value} para ${id}, usando fallback`, e);
        //           const numeric = toNumberBR(value);
        //           formattedValue = `R$ ${numeric.toFixed(2).replace('.', ',')}`;
        //         }
                
        //         // Atualiza o elemento
        //         if (element.textContent !== formattedValue) {
        //           element.textContent = formattedValue;
        //           console.log(`Elemento ${id} atualizado para:`, formattedValue);
        //         }
        //         return true;
        //       } catch (error) {
        //         console.error(`Erro ao atualizar o elemento ${id}:`, error);
        //         return false;
        //       }
        //     };
            
        //     // Atualiza os totais individuais
        //     const elementsUpdated = [
        //       updateElementIfExists('fat-total-epi', totalEPI),
        //       updateElementIfExists('fat-total-exames', totalExames),
        //       updateElementIfExists('fat-total-treinamentos', totalTreinamentos),
        //       updateElementIfExists('fat-total-geral', totalGeral)
        //     ];
            
        //     // Se algum elemento não foi encontrado, tenta atualizar o container completo
        //     if (elementsUpdated.some(updated => !updated)) {
        //       console.log('Alguns elementos não foram encontrados, tentando atualizar o container completo...');
        //       const totaisContainer = document.getElementById('fat-totais-container');
        //       if (totaisContainer) {
        //         console.log('Atualizando container de totais...');
        //         totaisContainer.innerHTML = `
        //           <div class="fat-total-item">
        //             <span>EPI/EPC:</span>
        //             <span id="fat-total-epi">${window.fatFormatter.format(totalEPI)}</span>
        //           </div>
        //           <div class="fat-total-item">
        //             <span>Exames:</span>
        //             <span id="fat-total-exames">${window.fatFormatter.format(totalExames)}</span>
        //           </div>
        //           <div class="fat-total-item">
        //             <span>Treinamentos:</span>
        //             <span id="fat-total-treinamentos">${window.fatFormatter.format(totalTreinamentos)}</span>
        //           </div>
        //           <div class="fat-total-item" style="margin-top: 15px; padding-top: 15px; border-top: 2px solid #e2e8f0;">
        //             <span style="font-weight: 600; font-size: 16px; color: #2d3748;">Total Geral:</span>
        //             <span id="fat-total-geral" style="font-weight: 700; font-size: 18px; color: #2b6cb0;">
        //               ${window.fatFormatter.format(totalGeral)}
        //             </span>
        //           </div>
        //         `;
        //       } else {
        //         console.warn('Container de totais não encontrado no DOM');
        //       }
        //     }
            
        //     // Dispara evento de atualização de totais
        //     const event = new CustomEvent('totaisAtualizados', { 
        //       detail: { 
        //         totalEPI: totalEPI,
        //         totalExames: totalExames,
        //         totalTreinamentos: totalTreinamentos,
        //         totalGeral: totalGeral
        //       } 
        //     });
        //     document.dispatchEvent(event);
            
        //   } catch (error) {
        //     console.error('Erro ao atualizar totais:', error);
        //   }
          
        //   console.log('=== Finalizando fatAtualizarTotais ===');
        // }

        // Torna a função disponível globalmente
        window.fatAtualizarTotais = fatAtualizarTotais;
        
        // Inicializa os eventos quando a página carregar
        document.addEventListener('DOMContentLoaded', function() {
          // Adiciona evento de tecla Enter nos campos de entrada
          const descricaoInput = document.getElementById('fat-descricao');
          const quantidadeInput = document.getElementById('fat-quantidade');
          const valorUnitInput = document.getElementById('fat-valorUnit');
          // Bind defensivo do botão Adicionar (caso a etapa já esteja montada)
          try {
            const addBtn = document.querySelector('.fat-btn-group button');
            if (addBtn && !addBtn.dataset.boundAdd) {
              addBtn.addEventListener('click', function(e){
                e.preventDefault();
                if (typeof window.fatAdicionarProduto === 'function') {
                  window.fatAdicionarProduto();
                }
              });
              addBtn.dataset.boundAdd = '1';
            }
          } catch(e) { /* noop */ }

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
  
  <!-- Scripts adicionais podem ser incluídos aqui -->
  
</body>
</html>