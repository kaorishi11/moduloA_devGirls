# SENN AI-X — Plataforma de Logística Inteligente

O **SENN AI-X** é um sistema web para gestão logística e otimização de entregas de última milha. A plataforma conta com dashboard analítico, rastreamento em mapa, assistente de Inteligência Artificial, relatórios exportáveis e controle de permissões por perfil de usuário.

## Pré-requisitos

Antes de iniciar a instalação, certifique-se de que possui:

- **XAMPP** instalado, com PHP 8.1 ou superior e MySQL.
- Extensões do PHP ativadas no `php.ini`: `pdo_mysql`, `curl`, `mbstring` e `fileinfo`.
- Navegador moderno, como Google Chrome, Microsoft Edge ou Mozilla Firefox.
- Conexão com a internet para configurar e utilizar APIs externas, quando necessário.

## Passo a Passo de Instalação

### 1. Copiar os arquivos do projeto

Coloque a pasta do projeto dentro do diretório do XAMPP:

```text
C:\xampp\htdocs\senn-ai-x
```

### 2. Criar o banco de dados

1. Abra o painel de controle do XAMPP.
2. Inicie os serviços **Apache** e **MySQL**.
3. Acesse o phpMyAdmin pelo navegador:

   `http://localhost/phpmyadmin`

4. Clique na aba **Importar**.
5. Selecione o arquivo `database/schema.sql`, localizado na pasta do projeto.
6. Clique em **Executar** para criar o banco de dados e as tabelas.

O banco de dados utilizado pela aplicação será `senn_aix`, conforme definido no arquivo SQL.

### 3. Popular o banco de dados

Abra o Prompt de Comando e execute:

```bash
cd C:\xampp\htdocs\senn-ai-x
php scripts/init_demo.php
```

Caso o comando `php` não seja reconhecido, utilize o caminho completo do executável do PHP:

```bash
C:\xampp\php\php.exe scripts/init_demo.php
```

Esse script cria os usuários e os dados iniciais de demonstração definidos pelo projeto.

### 4. Configurar o arquivo `.env`

Na raiz do projeto, copie o arquivo `.env.example` e renomeie a cópia para `.env`.

O arquivo deve ficar neste caminho:

```text
C:\xampp\htdocs\senn-ai-x\.env
```

Abra o arquivo e configure as credenciais do banco de dados e as chaves das APIs que deseja utilizar. Consulte a seção [Configuração do arquivo `.env`](#configuração-do-arquivo-env).

### 5. Acessar o sistema

Após concluir as etapas anteriores, abra o navegador e acesse:

`http://localhost/senn-ai-x/public`

## Credenciais de Acesso

As credenciais abaixo são destinadas ao ambiente de demonstração, desde que os usuários correspondentes sejam criados pelo script `scripts/init_demo.php`.

| Perfil | E-mail | Senha |
|---|---|---|
| Administrador | `admin@senn.local` | `admin123` |
| Gestor de Frota | `gestor@senn.local` | `gestor123` |
| Despachante | `despachante@senn.local` | `desp123` |
| Motorista | `motorista@senn.local` | `moto123` |

**Importante:** essas credenciais são apenas para demonstração. Altere as senhas antes de utilizar o sistema em qualquer ambiente real.

## Configuração do arquivo `.env`

O arquivo `.env` centraliza as configurações da aplicação, incluindo o endereço do sistema, as credenciais do banco de dados e as chaves de serviços externos.

Exemplo de configuração:

```dotenv
# CONFIGURAÇÕES DA APLICAÇÃO
APP_NAME="SENN AI-X"
APP_ENV=development
APP_URL=http://localhost/senn-ai-x/public
APP_KEY=coloque_uma_string_aleatoria_aqui

# BANCO DE DADOS
DB_HOST=127.0.0.1
DB_PORT=3306
DB_NAME=senn_aix
DB_USER=root
DB_PASS=

# GOOGLE MAPS (OPCIONAL)
GOOGLE_MAPS_API_KEY=

# INTELIGÊNCIA ARTIFICIAL (OPCIONAL)
AI_API_ENDPOINT=https://api.groq.com/openai/v1/chat/completions
AI_API_KEY=
AI_MODEL=llama-3.3-70b-versatile
```

### Configurações importantes

- `APP_NAME`: nome da aplicação.
- `APP_ENV`: ambiente de execução, como desenvolvimento.
- `APP_URL`: endereço utilizado para acessar a aplicação.
- `APP_KEY`: chave aleatória utilizada conforme a implementação da aplicação.
- `DB_HOST`: endereço do servidor do banco de dados.
- `DB_PORT`: porta de conexão com o MySQL.
- `DB_NAME`: nome do banco de dados.
- `DB_USER`: usuário de conexão com o banco.
- `DB_PASS`: senha do usuário do banco de dados.
- `GOOGLE_MAPS_API_KEY`: chave da API do Google Maps.
- `AI_API_ENDPOINT`: endereço do endpoint da API de Inteligência Artificial.
- `AI_API_KEY`: chave de autenticação da API de IA.
- `AI_MODEL`: identificador do modelo utilizado.

**Atenção:** não adicione o arquivo `.env` ao repositório Git, pois ele pode conter credenciais e chaves privadas. Utilize o `.env.example` para compartilhar apenas o modelo de configuração, sem segredos reais.

## Configuração do Google Maps

O Google Maps pode ser utilizado para exibir mapas e apoiar o acompanhamento das entregas, desde que essa funcionalidade esteja implementada e configurada no projeto.

Para configurar:

1. Acesse o [Google Cloud Console](https://console.cloud.google.com/).
2. Crie ou selecione um projeto.
3. Ative a **Maps JavaScript API**.
4. Configure o faturamento, caso seja solicitado.
5. Gere uma chave de API.
6. Configure as restrições de uso da chave.
7. Adicione a chave ao arquivo `.env`:

```dotenv
GOOGLE_MAPS_API_KEY=sua_chave_aqui
```

Para desenvolvimento local, configure as restrições de referenciador HTTP para os endereços locais necessários, como:

```text
http://localhost/*
http://127.0.0.1/*
```

Ajuste as restrições conforme a configuração do seu ambiente e as recomendações do Google Cloud.

## Configuração da Inteligência Artificial

O SENN AI-X pode ser integrado a uma API de Inteligência Artificial compatível com o formato de requisições da OpenAI.

Como exemplo, pode ser utilizada a API da [Groq](https://console.groq.com/), que disponibiliza modelos de linguagem por meio de uma API.

### Como configurar

1. Acesse o console da Groq.
2. Crie uma conta, caso ainda não possua.
3. Acesse a área de chaves de API.
4. Gere uma nova chave.
5. Configure as seguintes variáveis no arquivo `.env`:

```dotenv
AI_API_ENDPOINT=https://api.groq.com/openai/v1/chat/completions
AI_API_KEY=sua_chave_aqui
AI_MODEL=llama-3.3-70b-versatile
```

Utilize um identificador de modelo que esteja disponível na sua conta e seja compatível com a API.

**Modo simulado:** caso a chave de API não esteja configurada, o sistema poderá utilizar respostas simuladas com base nos dados disponíveis no banco de dados, desde que esse comportamento esteja implementado na aplicação.

**Segurança:** a chave de API deve permanecer no backend. Não exponha esse segredo em arquivos JavaScript públicos, no HTML ou no repositório Git.

## Estrutura do Projeto

A estrutura prevista para o projeto é organizada da seguinte forma:

```text
senn-ai-x/
│
├── .env
├── .env.example
├── README.md
│
├── database/
│   └── schema.sql
│
├── scripts/
│   └── init_demo.php
│
├── public/
│   ├── index.php
│   ├── .htaccess
│   ├── assets/
│   └── uploads/
│
└── app/
    ├── config/
    ├── core/
    ├── controllers/
    ├── models/
    └── views/
```

### Descrição dos diretórios

| Diretório ou arquivo | Responsabilidade |
|---|---|
| `.env` | Configurações locais e credenciais privadas. |
| `.env.example` | Modelo de configuração para outros ambientes. |
| `README.md` | Documentação do projeto e instruções de instalação. |
| `database/schema.sql` | Criação do banco de dados e das tabelas. |
| `scripts/init_demo.php` | Inicialização dos dados de demonstração. |
| `public/index.php` | Ponto de entrada e roteador principal da aplicação. |
| `public/.htaccess` | Regras de reescrita de URLs do Apache. |
| `public/assets/` | Arquivos CSS, JavaScript e imagens. |
| `public/uploads/` | Armazenamento de comprovantes enviados, conforme a implementação. |
| `app/config/` | Configurações e conexão com o banco de dados. |
| `app/core/` | Componentes centrais, como roteamento, autenticação e proteção CSRF. |
| `app/controllers/` | Controladores responsáveis pelas requisições e regras de aplicação. |
| `app/models/` | Modelos responsáveis pelo acesso e gerenciamento dos dados. |
| `app/views/` | Telas e componentes visuais da aplicação. |

## Perfis e Permissões

O sistema prevê quatro perfis de acesso, com diferentes níveis de autorização.

| Funcionalidade | Administrador | Gestor | Despachante | Motorista |
|---|---|---|---|---|
| Dashboard e assistente de IA | Sim | Sim | Sim | Sim |
| Gestão de entregas | Sim | Sim | Sim | Apenas próprias |
| Gestão de veículos | Sim | Sim | Apenas visualização | Não |
| Gestão de motoristas | Sim | Sim | Apenas visualização | Não |
| Relatórios | Sim | Sim | Sim | Não |
| Usuários do sistema | Sim | Não | Não | Não |

As permissões devem ser verificadas no backend, de acordo com o perfil autenticado. Ocultar botões ou menus na interface não é suficiente para impedir acessos não autorizados.

## Segurança

O projeto prevê mecanismos de segurança para proteger os dados e as operações do sistema.

### PDO com Prepared Statements

Utilização de consultas preparadas para reduzir o risco de SQL Injection no acesso ao banco de dados.

### Proteção CSRF

Utilização de tokens CSRF nos formulários e nas requisições que modificam dados, com validação no servidor.

### Hash de senhas

Armazenamento de senhas utilizando funções seguras de hash do PHP, como `password_hash()` com bcrypt, e verificação com `password_verify()`.

### Proteção de chaves de API

Armazenamento das chaves de serviços externos no arquivo `.env`, com utilização pelo backend e sem exposição desnecessária ao navegador.

### Prevenção contra XSS

Utilização de `htmlspecialchars()` ao exibir dados não confiáveis em contextos HTML compatíveis, além da validação e do tratamento adequado das entradas.

### Controle de permissões

Verificação das permissões de cada perfil no servidor antes de permitir o acesso a páginas, relatórios, entregas, veículos e demais recursos protegidos.

**Observação:** os mecanismos descritos devem estar efetivamente implementados no código para que o sistema possa ser considerado protegido. A documentação, isoladamente, não comprova a existência dessas proteções.

## Solução de Problemas

### 1. Erro 404 ou página não encontrada

Verifique se está acessando o endereço correto:

`http://localhost/senn-ai-x/public`

Confirme também se:

- O Apache está em execução.
- O arquivo `.htaccess` existe dentro de `public/`.
- O módulo `mod_rewrite` está habilitado.
- A configuração do Apache permite a utilização das regras do `.htaccess`.

### 2. Erro de classe não encontrada

Verifique se os arquivos necessários estão sendo carregados e se os nomes das classes, os caminhos e os arquivos correspondem à estrutura do projeto.

Se o projeto utilizar carregamento manual, confira o mecanismo de inclusão no arquivo `public/index.php`. Por exemplo:

```php
foreach (glob(__DIR__ . '/../app/controllers/*.php') as $f) {
    require_once $f;
}
```

Esse exemplo só deve ser utilizado se for compatível com a organização das classes e com o mecanismo de carregamento já existente no projeto.

### 3. O CSS não carrega

Confira se a variável `APP_URL` está configurada corretamente:

```dotenv
APP_URL=http://localhost/senn-ai-x/public
```

Em seguida:

1. Confirme se os arquivos CSS existem em `public/assets/`.
2. Verifique se os caminhos utilizados nas páginas estão corretos.
3. Abra as ferramentas de desenvolvedor do navegador e confira se os arquivos retornam erro 404.
4. Pressione `Ctrl + F5` para atualizar a página sem utilizar os arquivos em cache.

### 4. A Inteligência Artificial responde no modo simulado

Verifique se as seguintes variáveis estão preenchidas corretamente:

```dotenv
AI_API_ENDPOINT=https://api.groq.com/openai/v1/chat/completions
AI_API_KEY=sua_chave_aqui
AI_MODEL=llama-3.3-70b-versatile
```

Confirme também se:

- A chave de API é válida.
- O modelo está disponível para sua conta.
- O endpoint está correto.
- O PHP possui a extensão `curl` habilitada.
- O servidor possui conexão com a internet.
- A aplicação trata corretamente os erros retornados pela API.

Se a integração externa não estiver disponível, o sistema poderá utilizar o modo simulado, caso essa funcionalidade esteja implementada.

### 5. Erro de conexão com o banco de dados

Confira as configurações de conexão no arquivo `.env`:

```dotenv
DB_HOST=127.0.0.1
DB_PORT=3306
DB_NAME=senn_aix
DB_USER=root
DB_PASS=
```

Verifique se o MySQL está em execução, se o banco `senn_aix` existe e se as credenciais correspondem às configurações do seu ambiente.