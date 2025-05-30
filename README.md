
<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

# 📦 Projeto Clean Code

Este projeto é uma aplicação desenvolvida em **Laravel**, com o objetivo de aplicar os princípios de **Clean Code**, boas práticas de desenvolvimento, testes automatizados e containers Docker para garantir escalabilidade, manutenibilidade e clareza estrutural no código.

---

## 🧩 Descrição do Software

A aplicação permite o gerenciamento de pastas e arquivos `.torrent`, incluindo:
- Cadastro e visualização de pastas
- Upload, listagem e visualização de torrents
- Interface web com navegação simples e funcional

---

## 🔍 Análise dos Principais Problemas Detectados (Código Legado)

- Código monolítico e acoplado
- Funções misturadas com lógica de visualização (`funcoes.php`, `listar.php`, etc)
- Nomenclaturas vagas como `insert2.php`, `arq`, `aux`
- Ausência de testes automatizados
- Inexistência de padrões como MVC, PSR-12 ou arquitetura em camadas

---

## 🔧 Estratégia de Refatoração

- **Migração para Laravel** para aplicar MVC nativo
- Criação de camadas de **Service** e **Repository**
- Uso de **DTOs** com tipagem e validação
- Implementação de **testes automatizados**
- Padronização com **Laravel Pint (PSR-12)**
- Utilização de **Docker** para ambiente de desenvolvimento unificado

---

## 📋 CHANGELOG

### [1.0.0] - 2025-05-29

#### ✅ Adicionado
- Estrutura completa baseada no Laravel
- Docker com PHP-FPM, NGINX e Postgres configurado
- Seeder com dados fictícios para teste de navegação
- Testes PHPUnit cobrindo as rotas principais
- Interface fluente com encadeamento de métodos
- DTOs usando Spatie Laravel Data
- Linter Laravel Pint no Composer

#### ♻️ Refatorado
- Código legado procedural completamente eliminado
- Reestruturação em MVC com camadas de responsabilidade claras
- Nomes de variáveis e métodos substituídos por descrições semânticas
- Separação entre regras de negócio e persistência de dados

#### 🐛 Corrigido
- Acoplamento entre controller e acesso direto ao banco
- Funções sem reutilização, duplicidade de lógica e ausência de tipagem
- Falta de padronização e inexistência de validações

---

## 🧪 Testes Implementados

- `BasicTest` cobre:
  - Página inicial (`/`)
  - Rota de pastas (`/pastas`)
  - Rota de torrents (`/torrents`)
- Rodar via:
```bash
docker exec -it app php artisan test
```

---

## 🔗 Interface Fluente

Métodos encadeáveis foram utilizados em repositórios e query builders para clareza na lógica:

```php
Arquivo::query()
    ->where('ativo', true)
    ->latest()
    ->limit(5)
    ->get();
```

Facilita a leitura e permite construção fluente e segura de queries.

---

## 🛠️ Instalação e Execução

1. Copie `.env`:
```bash
cp .env.example .env
```

2. Suba os containers:
```bash
docker-compose up --build -d
```

3. Rode migrations e seeders:
```bash
docker exec -it app php artisan migrate
docker exec -it app php artisan db:seed
```

4. Acesse:
```
http://localhost:8000
```

---

## 🌱 Rodar Seeder Manualmente

```bash
docker exec -it app php artisan db:seed
```

---

## 🎨 Linter

```bash
docker exec -it app composer lint
```

---

## 🧱 Estrutura Geral

- `app/`: Código-fonte da aplicação
- `routes/web.php`: Rotas da aplicação
- `tests/`: Testes automatizados
- `docker-compose.yml`: Containers da aplicação

---

## 👨‍💻 Equipe

- Guilherme Machado Darabas  
- Paulo Roberto Simão  
- Rubens Scotti Junior  
- Stephan Anthony Marques  

---