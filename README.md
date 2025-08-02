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
- **Vite** — Empacotador frontend moderno para Tailwind, Livewire e JavaScript.

---

## 🐳 Docker: Serviços

| Serviço   | Descrição                                                                 |
|-----------|---------------------------------------------------------------------------|
| `app`     | Container principal rodando PHP-FPM e Laravel. Recebe requisições do Nginx. |
| `nginx`   | Servidor web que serve o Laravel em HTTPS, com certificado autoassinado. |
| `mysql`   | Banco de dados relacional MySQL 8.0, com persistência via volume local.   |
| `artisan` | Container auxiliar para rodar comandos Artisan de forma isolada. Ideal para jobs manuais como `php artisan migrate`, `tinker`, etc., sem afetar o container principal. |
| `vite`    | Container dedicado para rodar `npm run dev` com Vite + Hot Reload, sem depender do Node instalado na máquina host. |

---

## 🔐 HTTPS com Certificado Autoassinado

O ambiente vem configurado com **HTTPS local via certificado autoassinado**, útil para:

- Testar **webhooks** de serviços como Stripe, Mercado Pago, etc.
- Simular **integrações seguras** com APIs que exigem HTTPS (como apps móveis).
- Reduzir fricção em testes de ponta a ponta em desenvolvimento.

A aplicação pode ser acessada em:
```
https://localhost:8000
```

---

## 🚀 Como usar

### 1. Subir o ambiente

```bash
    docker compose -f docker-compose.dev.yml up --build
```

### 2. Instalar pacotes Laravel e dependências frontend

```bash
    docker compose -f docker-compose.dev.yml exec -it app sh
    composer install
    npm install
    cp .env.example .env
    php artisan key:generate
```

### 3. Acessar a aplicação

- Abra no navegador:  
  `https://localhost:8000`

### 4. (Opcional) Corrigir permissões

Se você estiver em um sistema Linux e houver erro de escrita nos diretórios `storage` ou `bootstrap/cache`:

**Fora do container:**

```bash 
    sudo chown -R www-data:www-data storage bootstrap/cache
    sudo chmod -R 775 storage bootstrap/cache
```

---

## 📦 Extras

- O Vite roda automaticamente no container `vite` e responde na porta `5173`.
- O container `artisan` pode ser usado para comandos individuais sem acessar o `app`.

### Exemplo:
```bash
docker compose run artisan migrate
```

---

## 👨‍💻 Autor

Desenvolvido por **Rafael Alves**  
📧 rafa.dev.moc@gmail.com  
📌 Teste técnico para vaga Pleno PHP/Laravel.
