# 📝 Teste de Admissão — Desenvolvedor Pleno Laravel + Filament

Este projeto consiste em um **construtor de formulários dinâmicos** com Laravel 12 e Filament 3, desenvolvido como parte de um teste técnico para uma vaga de desenvolvedor pleno.

---

## 🎯 Objetivo

Desenvolver um sistema web com as seguintes funcionalidades:

- Gerenciamento de formulários dinâmicos (título, descrição, status);
- Gerenciamento de perguntas e alternativas;
- Possibilidade de responder formulários ativos;
- Armazenamento das respostas com **snapshot do estado do formulário no momento da resposta**;
- Visualização do histórico completo de respostas;
- Exclusão lógica de formulários, perguntas e alternativas.

---

## 🧱 Arquitetura da Aplicação

A aplicação é construída com:

- **Laravel 12** — Backend robusto e moderno.
- **Filament 3** — Painel administrativo elegante e funcional.
- **MySQL 8** — Armazenamento relacional de dados.
- **Docker** — Ambiente isolado e reproduzível para desenvolvimento local.
- **Nginx + PHP-FPM** — Servidor web otimizado com suporte a HTTPS.
- **Vite** — Empacotador frontend moderno para Tailwind, Livewire e JavaScript (roda fora do Docker).

---

## 🐳 Docker: Serviços

| Serviço   | Descrição                                                                 |
|-----------|---------------------------------------------------------------------------|
| app       | Container principal rodando PHP-FPM e Laravel. Recebe requisições do Nginx. |
| nginx     | Servidor web que serve o Laravel em HTTPS, com certificado autoassinado. |
| mysql     | Banco de dados relacional MySQL 8.0, com persistência via volume local.   |
| artisan   | Container auxiliar para rodar comandos Artisan de forma isolada. Ideal para jobs manuais como php artisan migrate, tinker, etc. |

> ⚠️ O Vite **não roda mais em um container separado**. Agora, é necessário executar `npm run dev` no terminal local da sua máquina para ter hot reload durante o desenvolvimento frontend.

---

## 🔐 HTTPS com Certificado Autoassinado

O ambiente vem configurado com **HTTPS local via certificado autoassinado**, útil para:

- Testar **webhooks** de serviços como Stripe, Mercado Pago, etc.;
- Simular **integrações seguras** com APIs que exigem HTTPS (como apps móveis);
- Reduzir fricção em testes de ponta a ponta em desenvolvimento.

A aplicação pode ser acessada em:

https://localhost:8000

---

## 🚀 Como usar

### 1. Subir o ambiente

```bash
    docker compose -f docker-compose.dev.yml up --build
```

### 2. Instalar dependências Laravel e frontend

```bash
    docker compose -f docker-compose.dev.yml exec -it app sh
    composer install
    cp .env.example .env
    php artisan key:generate
exit
```

### 3. Instalar dependências e rodar Vite (no terminal local)

```bash
    npm install
    npm run dev
```

### ⚠️ Permissões

Para evitar problemas de permissão nos volumes do Docker, edite o `.env` e configure corretamente as variáveis:

```env
    HOST_UID=1000
    HOST_GID=1000
```

Substitua os valores conforme o UID e GID do seu usuário local (ex: output do comando `id -u` e `id -g`).

---

## 🔐 Acesso ao Painel Administrativo

O painel administrativo é construído com Filament 3.

Para acessá-lo, entre com um usuário autenticado e abra o menu no canto superior direito > clique em **“Painel”**.

---

## 🧠 Decisões Técnicas

Este projeto contém algumas decisões técnicas e implementações que visam demonstrar domínio de conceitos avançados:

- **Uso de Traits como `AutoOrdernable`**: para ordenar automaticamente perguntas e alternativas ao salvar.
- **Tabela `form_snapshots`**: pensada originalmente para permitir restauração de versões anteriores do formulário (como um histórico de estrutura). Essa funcionalidade foi descontinuada por não ser requerida.
- **Sistema de snapshots por resposta**: ao responder um formulário, é salva uma cópia (snapshot) da estrutura daquele formulário naquele momento.

---

## 🗑️ Features Descontinuadas

Durante a execução do projeto, algumas ideias foram exploradas, mas deixadas de lado conforme alinhamento com o solicitante do teste:

- **Integração com métodos de pagamento**: inicialmente, apenas usuários pagantes teriam acesso ao painel administrativo.
- **Sistema de integrações**: formulários poderiam disparar ações em serviços externos como o n8n ao serem respondidos.
- **Versões restauráveis de formulários**: embora a estrutura de snapshot ainda exista, o recurso de “restaurar versão” foi removido.

Essas funcionalidades foram descontinuadas para manter o escopo alinhado ao objetivo do teste técnico.

---

## 👨‍💻 Autor

Desenvolvido por **Rafael Alves**  
📧 rafa.dev.moc@gmail.com  
📌 Teste técnico para vaga Pleno PHP/Laravel.
