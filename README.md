# SENN AI-X

### Plataforma Inteligente de Gestão Logística e Otimização de Entregas

O **SENN AI-X** é uma plataforma web desenvolvida para otimizar a gestão logística de entregas de última milha, integrando gerenciamento de frota, monitoramento de pedidos, análise de desempenho e inteligência artificial.

O sistema busca facilitar o planejamento das operações, reduzir atrasos, melhorar a utilização dos veículos e apoiar a tomada de decisões por meio de dados e indicadores logísticos.

## Objetivo do projeto

Desenvolver uma solução tecnológica capaz de centralizar as informações logísticas de uma empresa, permitindo acompanhar entregas, gerenciar motoristas e veículos, monitorar rotas e identificar possíveis problemas operacionais.

## Funcionalidades

### 1. Dashboard
- Visualização dos principais indicadores logísticos.
- Quantidade de entregas concluídas, pendentes e atrasadas.
- Monitoramento da disponibilidade dos veículos.
- Gráficos de desempenho e produtividade.
- Resumo de alertas e recomendações.

### 2. Gestão de entregas
- Cadastro, edição e consulta de pedidos.
- Identificação do destinatário e endereço de entrega.
- Definição de prioridades e prazos.
- Acompanhamento dos status das entregas.
- Pesquisa e filtragem de pedidos.

### 3. Gestão de veículos
- Cadastro de veículos e placas.
- Registro da capacidade de carga e volume.
- Controle de disponibilidade.
- Acompanhamento de manutenção e autonomia.

### 4. Gestão de motoristas
- Cadastro de motoristas.
- Registro da categoria e validade da CNH.
- Controle de disponibilidade.
- Associação entre motoristas e veículos.

### 5. Rastreamento e rotas
- Visualização de veículos em mapa interativo.
- Acompanhamento das rotas e paradas.
- Identificação de possíveis desvios.
- Planejamento de rotas conforme distância, capacidade e prazos.

### 6. Inteligência artificial
- Análise de riscos de atraso.
- Sugestões para otimização de rotas.
- Previsão de demanda para 7 e 30 dias.
- Análise de custos e desempenho operacional.
- Assistente virtual para consultas sobre a operação logística.

### 7. Relatórios e indicadores
- Taxa de entregas realizadas no prazo.
- Custo por entrega.
- Quilômetros percorridos.
- Ocupação da frota.
- Desempenho por região.
- Exportação de relatórios em PDF e Excel.

### 8. Alertas e notificações
- Avisos de entregas atrasadas.
- Alertas de veículos parados ou fora da rota.
- Notificações de manutenção.
- Avisos sobre vencimento da CNH.

### 9. Comprovantes de entrega
- Registro da data e hora.
- Armazenamento de evidências da entrega.
- Registro da localização, quando disponível.
- Histórico de atualização dos pedidos.

### 10. Importação de pedidos
- Importação de pedidos por arquivos CSV.
- Validação dos dados importados.
- Identificação de registros inválidos.
- Apresentação de erros antes da conclusão da importação.

## Tecnologias utilizadas

| Tecnologia | Finalidade |
|---|---|
| HTML5 | Estrutura das páginas |
| CSS3 | Estilização e identidade visual |
| JavaScript | Interatividade da interface |
| PHP | Processamento e regras de negócio |
| MySQL | Armazenamento dos dados |
| PDO | Comunicação segura com o banco de dados |
| Google Maps API | Mapas e recursos de localização |
| Chart.js | Criação de gráficos |
| API de inteligência artificial | Análise de dados e recomendações |

As integrações externas dependem de configuração e credenciais válidas. As funcionalidades que ainda não estiverem conectadas deverão ser identificadas como demonstrações.

## Identidade visual

A interface do SENN AI-X utiliza uma identidade visual moderna, com predominância de tons de roxo e lilás, combinados com fundos claros e elementos de destaque.

**Cores principais:**

- Roxo: `#6C3BCE`
- Roxo escuro: `#241344`
- Lilás: `#A78BFA`
- Fundo claro: `#F7F6FC`
- Branco: `#FFFFFF`

O layout é planejado para oferecer navegação intuitiva, organização das informações e adaptação a computadores, tablets e celulares.

## Perfis de acesso

O sistema prevê diferentes níveis de permissão:

- **Administrador:** gerencia usuários, permissões e configurações.
- **Gestor de frota:** acompanha veículos, motoristas, manutenção e indicadores.
- **Despachante:** administra pedidos, entregas e rotas.
- **Motorista:** consulta entregas atribuídas e registra seu andamento.

O acesso a cada funcionalidade deve ser validado no backend, e não apenas ocultado na interface.

## Estrutura do projeto

Uma possível organização dos arquivos é:

```text
SENN-AI-X/
├── config/
│   └── database.php
├── controllers/
├── models/
├── views/
│   ├── dashboard/
│   ├── entregas/
│   ├── veiculos/
│   ├── motoristas/
│   ├── relatorios/
│   └── auth/
├── public/
│   ├── css/
│   │   └── style.css
│   ├── js/
│   │   └── app.js
│   └── images/
├── routes/
├── database/
│   └── database.sql
├── .env.example
├── .gitignore
├── index.php
└── README.md
```

A estrutura poderá ser adaptada conforme a implementação efetiva do sistema.

## Instalação e execução

### Pré-requisitos

- PHP compatível com o projeto.
- MySQL ou MariaDB.
- XAMPP instalado.
- Navegador atualizado.
- Chaves de API, caso sejam utilizadas integrações externas.

### 1. Clonar o repositório

```bash
git clone URL_DO_REPOSITORIO
```

Entre na pasta do projeto:

```bash
cd SENN-AI-X
```

Substitua `URL_DO_REPOSITORIO` pelo endereço real do repositório.

### 2. Configurar o banco de dados

1. Abra o XAMPP.
2. Inicie o Apache e o MySQL.
3. Acesse `http://localhost/phpmyadmin`.
4. Crie o banco de dados conforme o nome definido na configuração do projeto.
5. Importe o arquivo `database/database.sql`, caso ele já tenha sido criado.

### 3. Configurar a conexão

Configure as credenciais do MySQL no arquivo de configuração ou nas variáveis de ambiente utilizadas pelo projeto.

Exemplo de configuração:

```php
<?php

$host = 'localhost';
$dbname = 'senn_aix';
$user = 'root';
$password = '';

$pdo = new PDO(
    "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
    $user,
    $password,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
);
```

Esse exemplo pressupõe uma instalação local do XAMPP sem senha para o usuário `root`. Ajuste as credenciais conforme o seu ambiente e não utilize essa configuração sem proteção em produção.

### 4. Executar o sistema

Coloque a pasta do projeto dentro do diretório `htdocs` do XAMPP.

Exemplo no Windows:

```text
C:\xampp\htdocs\SENN-AI-X
```

Com o Apache e o MySQL iniciados, acesse:

```text
http://localhost/SENN-AI-X/
```

O endereço e o arquivo inicial podem variar de acordo com a estrutura implementada.

## Segurança

O projeto deve adotar as seguintes medidas:

- Consultas preparadas com PDO para reduzir riscos de SQL Injection.
- Validação e sanitização adequada dos dados.
- Proteção contra XSS e CSRF.
- Senhas armazenadas com `password_hash()` e verificadas com `password_verify()`.
- Controle de sessão e autorização no backend.
- Proteção de arquivos e credenciais.
- Chaves de API armazenadas em variáveis de ambiente.
- Cuidados com os dados pessoais conforme a Lei Geral de Proteção de Dados (LGPD).

## Inteligência artificial e otimização

A integração com inteligência artificial deverá ocorrer pelo backend, por meio de uma API configurável.

A plataforma poderá utilizar os dados disponíveis para produzir recomendações sobre rotas, prazos, custos, demanda e desempenho. A otimização deverá considerar restrições como capacidade dos veículos, prioridades e janelas de entrega.

Quando uma integração externa não estiver configurada, o sistema deverá informar que a resposta ou recomendação é demonstrativa. Resultados simulados não devem ser apresentados como previsões reais.

## Benefícios esperados

- Centralização das informações logísticas.
- Maior visibilidade do andamento das entregas.
- Melhor organização da frota e dos motoristas.
- Identificação antecipada de possíveis atrasos.
- Apoio à tomada de decisões por meio de indicadores.
- Potencial redução de custos e melhoria da eficiência operacional.

Esses benefícios são objetivos do projeto e dependem da implementação, da qualidade dos dados e da validação em uso real.

## Status do projeto

**Projeto em desenvolvimento.**

As funcionalidades devem ser consideradas disponíveis somente quando estiverem implementadas e testadas. Integrações com mapas, inteligência artificial, notificações e exportação de relatórios podem exigir configurações adicionais.

## Autoria

**Projeto:** SENN AI-X  
**Área:** Desenvolvimento de Sistemas e Logística Inteligente  
**Objetivo:** Aplicar tecnologias web e inteligência artificial para apoiar a gestão logística e a otimização de entregas.

---

*O SENN AI-X busca unir tecnologia, dados e inteligência artificial para tornar as operações logísticas mais organizadas, eficientes e inteligentes.*