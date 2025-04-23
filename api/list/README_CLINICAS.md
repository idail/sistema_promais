# API de Listagem de Clínicas

## Descrição Geral
Este endpoint permite listar clínicas com recursos avançados de filtragem, paginação e detalhamento.

## Endpoint
`GET http://localhost/promais/api/list/clinicas.php`

## Autenticação
- Requer sessão de usuário válida
- Verifica expiração do plano do usuário
- Valida variáveis de sessão específicas

### Variáveis de Sessão Obrigatórias
- `user_id`
- `user_name`
- `user_plan`
- `user_expire`
- `user_access_level`
- `empresa_id`
- `empresa_nome`
- `empresa_cnpj`

## Parâmetros de Consulta

### Filtragem
- `status`: Filtra clínicas por status
  - Valores possíveis: 'Ativo', 'Inativo'
- `cidade_id`: Filtra por ID da cidade (numérico)
- `busca`: Termo de busca para:
  - Nome fantasia
  - Razão social
  - CNPJ

### Paginação
- `page`: Número da página (padrão: 1)
- `per_page`: Resultados por página
  - Mínimo: 1
  - Máximo: 100
  - Padrão: 20

## Estrutura de Resposta

### Detalhes da Clínica
- `id`: Identificador único
- `codigo`: Código da clínica
- `nome_fantasia`: Nome fantasia
- `razao_social`: Razão social
- `cnpj`: CNPJ
- `endereco`: Endereço
- `numero`: Número
- `complemento`: Complemento
- `bairro`: Bairro
- `cep`: CEP
- `email`: E-mail
- `telefone`: Telefone
- `status`: Status da clínica
- `cidade_nome`: Nome da cidade
- `cidade_estado`: Estado
- `total_medicos`: Total de médicos ativos

### Médicos Associados
Para cada clínica, lista de médicos:
- `id`: ID do médico
- `nome`: Nome
- `especialidade`: Especialidade
- `crm`: CRM
- `pcmso`: PCMSO
- `contato`: Contato
- `status`: Status
- `data_associacao`: Data de associação

## Tratamento de Erros

### Possíveis Respostas de Erro
1. Sessão inválida ou expirada
   - Código de status: Erro
   - Mensagem: "Sessão inválida ou expirada. Por favor, faça login novamente."

2. Plano expirado
   - Código de status: Erro
   - Mensagem: "Seu plano expirou. Por favor, renove sua assinatura."

## Exemplo de Uso

### Requisição
```bash
curl "http://localhost/promais/api/list/clinicas.php?status=Ativo&cidade_id=123&busca=Clinica&page=1&per_page=20"
```

### Considerações de Segurança
- CORS habilitado
- Codificação UTF-8
- Validação de sessão
- Consultas parametrizadas
- Sanitização de entrada

## Dependências
- PHP com suporte a PDO
- Banco de dados MySQL
- Sessão PHP configurada

## Notas Técnicas
- Ordenação padrão: Nome fantasia (ascendente)
- Suporta caracteres UTF-8
- Registra logs de depuração em caso de erros
