<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Titulo
[descrever o proposito do projeto]

# Equipe

- Guilherme Machado Darabas
- RUBENS SCOTTI JUNIOR
- STEPHAN ANTHONY MARQUES DOS SANTOS
- PAULO ROBERTO SIMÃO

# Tecnologias

- PHP com laravel
- ....

# Como Instalar 🔨

Copiar o arquivo `.env.example` para `.env` e alterar conforme necessidade

O projeto conta com um docker-compose para facilitar o ambiente de desenvolvimento

```bash
docker compose up
```

Depois é necessário rodar as migrations

```bash
docker exec -it clean-code-laravel bash

php artisan migrate
```

# 🎨 Linter e Estilo
- Adotado o padrão **PSR-12** com **Laravel Pint** para manter estilo de código consistente.
- Adicionadas ferramentas de linting ao `composer.json`.

Para rodar o `pint`
```bash
# Fora do container
docker exec -it clean-code-laravel composer lint

# Dentro do container
composer lint
```

---

## 🔁 Versão Refatorada (`main`)

### ✅ Migração para Laravel
- **Motivo**: 
    Decidimos utilizar laravel para resolver problemas estruturais como código monolítico, 
    acoplamento excessivo e ausência de organização em camadas.
    Além da falta de padrão para pastas como `funcoes` `funcoes_usuario` e arquivos mal nomeados como `envia.php`, `listar.php`, `pesquisa.php`...
- **Melhorias**:
    - Adotado padrão **MVC** nativo do Laravel.
    - Organização automática de diretórios para controllers, models, views, services, etc.
    - Uso do sistema de rotas nomeadas e middlewares para segurança e controle de acesso.
    - Separação de responsabilidades entre as camadas de apresentação, lógica de negócio e persistência.

---

### 📂 Camadas de Service e Repository
- **Service Layer**:
    - Centraliza regras de negócio e operações de alto nível.
    - Exemplo: `ArquivoService` agora trata a lógica relacionada ao envio/listagem dos arquivos torrent.

- **Repository Layer**:
    - Encapsulamento das queries de banco de dados para manter desacoplamento.
    - Exemplo: `ArquivoRepository` manipula `Eloquent` com clareza e reutilização.
    - Facilita testes com mocks e permite evolução futura sem depender diretamente do ORM.

---

### 📦 Uso de DTOs (Data Transfer Objects)
- Implementado com **Spatie Laravel Data** para:
  - Organizar e tipar os dados de entrada com clareza que anteriormente não era tipado/documentado.
  - Melhorar legibilidade e reusabilidade dos parâmetros de filtros e formulários.
  - Converter automáticamente parametros para classes, facilitando leitura de código

---

### 🧼 Nomenclatura e Legibilidade
- Refatoração completa dos nomes de:
    - Variáveis e métodos para refletirem **intenção clara**.
    - Classes para refletirem sua responsabilidade de forma explícita.
- Remoção de siglas e nomes genéricos (`arq`, `insert2`, `obj`) substituídos por nomes descritivos.

---

## 🔗 Branches

- `original`: versão antiga em PHP puro, sem estrutura modular.
- `main`: versão refatorada com Laravel, camadas e arquitetura limpa.
