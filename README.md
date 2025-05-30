
<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

# 📦 Projeto Clean Code

Este projeto é uma aplicação desenvolvida em **Laravel**, com o objetivo de aplicar os princípios de **Clean Code**, boas práticas de desenvolvimento, testes automatizados e uso de containers Docker para garantir escalabilidade e organização.

---

## 👨‍💻 Equipe

- Guilherme Machado Darabas  
- Paulo Roberto Simão  
- Rubens Scotti Junior  
- Stephan Anthony Marques  

---

## 🛠️ Tecnologias Utilizadas

### 🔧 Backend
- **Laravel** – Framework PHP moderno e robusto
- **PHP 8.3** – Linguagem utilizada
- **Composer** – Gerenciador de dependências

### 🧪 Testes
- **PHPUnit** – Testes automatizados
- **Artisan Test Runner** – Executor de testes Laravel

### 🐳 Infraestrutura
- **Docker & Docker Compose** – Ambiente conteinerizado
- **NGINX** – Servidor web

### 🌐 Frontend
- **Blade Templates** – Motor de views Laravel
- **Vite** – Empacotador de assets moderno (JS/CSS)

---

## 🔗 Acesso às Telas

Após subir o ambiente, acesse:

- 📂 [http://localhost:8000/pastas](http://localhost:8000/pastas)  
- 💾 [http://localhost:8000/torrents](http://localhost:8000/torrents)

---

## 🐳 Como Rodar com Docker

1. Copie o arquivo `.env`:
   ```bash
   cp .env.example .env
   ```

2. Suba os containers:
   ```bash
   docker-compose up --build -d
   ```

3. Acesse a aplicação:
   ```
   http://localhost:8000
   ```

4. Rode as migrations (opcional):
   ```bash
   docker exec -it app php artisan migrate
   ```

---

## ✅ Executar os Testes

```bash
docker exec -it app php artisan test
# ou
docker exec -it app ./vendor/bin/phpunit
```

---

## 🌱 Rodar Seeder

Como a aplicação ainda não possui login, foi criado um seeder para popular o banco com um usuário, pastas e arquivos de exemplo:

```bash
docker exec -it app php artisan db:seed
```

---

## 🎨 Linter e Estilo

- Segue o padrão **PSR-12**
- Utiliza **Laravel Pint** para formatação automática de código

Para rodar o lint:

```bash
# Fora do container
docker exec -it clean-code-laravel composer lint

# Dentro do container
composer lint
```

---

## 🧱 Estrutura Geral

- `app/` — código-fonte principal (controllers, models, services)
- `routes/web.php` — definição de rotas
- `tests/` — testes automatizados
- `docker-compose.yml` — definição dos serviços

---

## 🔁 Versão Refatorada (`main`)

### ✅ Migração para Laravel

**Por quê?**
- Resolver problemas como acoplamento excessivo, desorganização e nomes genéricos.
- Substituir estruturas confusas como `funcoes.php`, `insert2.php`, etc.

**Melhorias implementadas:**
- Arquitetura **MVC** bem definida
- Rotas nomeadas, middlewares, separation of concerns
- Padrões de organização automáticos do Laravel

---

### 📂 Camadas de Service e Repository

- `Service`: lógica de negócio (ex: `ArquivoService`)
- `Repository`: acesso a dados desacoplado (ex: `ArquivoRepository` com Eloquent)

---

### 📦 Uso de DTOs (Data Transfer Objects)

- Com **Spatie Laravel Data**
- Permite dados tipados, estruturados e fáceis de validar
- Melhora clareza dos parâmetros e facilita testes

---

### 🧼 Nomenclatura e Legibilidade

- Nomes claros e descritivos para métodos, variáveis e arquivos
- Substituição de siglas e termos genéricos como `arq`, `insert2`, etc

---

## 🌿 Branches

- `original`: versão PHP procedural sem estrutura
- `main`: versão Laravel com arquitetura limpa e modularizada

---

