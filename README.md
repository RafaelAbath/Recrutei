# Locadora de Veículos API

Este repositório contém uma API em Laravel para gerenciar veículos, clientes, aluguéis e um serviço Python para relatórios de faturamento.

---

## Pré-requisitos

- Docker & Docker Compose
- PHP 8.3+ (via container)
- Composer (via container)
- MySQL 8.1
- Redis
- Elasticsearch 8.x
- Node.js & npm (para front-end ou assets, se necessário)

---

## 1. Setup do projeto Laravel

### 1.1. Clonar o repositório

```bash
git clone git@github.com:RafaelAbath/recrutei.git
```

### 1.2. Copiar e configurar o `.env`

```bash
cd src
cp .env.example .env
```

Edite o arquivo `.env` com as configurações:

```dotenv
APP_NAME="Locadora API"
APP_ENV=local
APP_KEY=                        # será gerado abaixo
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=locadora
DB_USERNAME=locadora
DB_PASSWORD=locadora

CACHE_DRIVER=file
QUEUE_CONNECTION=redis
REDIS_HOST=redis

SCOUT_DRIVER=elastic
ELASTIC_HOST=elasticsearch:9200

JWT_SECRET=                     # será gerado abaixo

REPORT_SERVICE_URL=http://report:8000
```

### 1.3. Subir os containers e instalar dependências

```bash
docker compose up -d
docker compose exec app composer install
docker compose exec app npm install   
```

### 1.4. Gerar chaves e secrets

```bash
docker compose exec app php artisan key:generate
docker compose exec app php artisan jwt:secret
```

### 1.5. Executar migrations e seeders

```bash
docker compose exec app php artisan migrate
docker compose exec app php artisan db:seed
```

### 1.6. Configurar e importar índice Elasticsearch

1. Aguarde o Elasticsearch estar `healthy`:
   ```bash
   docker compose ps
   ```
2. Importe os veículos para o índice:
   ```bash
   docker compose exec app php artisan scout:import "App\Models\Vehicle"
   ```

---

## 2. Testando a API

Use o Postman ou cURL para testar os endpoints:

- **Autenticação**: `/api/register`, `/api/login`, `/api/logout`
- **CRUD Veículos**: `/api/vehicles`
- **CRUD Clientes**: `/api/customers`
- **Aluguéis**: `/api/rentals`, `/api/rentals/{id}/start`, `/api/rentals/{id}/end`
- **Busca Elasticsearch**: `/api/vehicles/search?q=termo`
- **Relatórios**: `/api/reports/revenue?start=YYYY-MM-DD&end=YYYY-MM-DD`

---

## 3. Serviço Python de Relatórios (Opcional)

### 3.1. Estrutura e requisitos

Dentro da raiz do projeto, existe a pasta `python-report` com:

- `Dockerfile`
- `requirements.txt`
- `main.py`
- `.env`

### 3.2. Exemplo de `.env` para o serviço Python

```dotenv
DATABASE_URL=mysql+pymysql://locadora:locadora@mysql/locadora
```

### 3.3. Build e execução

O `docker-compose.yml` já inclui o serviço `report`. Para buildar e subir:

```bash
docker compose up -d --build report
```

### 3.4. Testar o serviço Python

No host ou via curl:

```bash
curl -i -G http://localhost:8000/reports/revenue   --data-urlencode "start=2025-05-01"   --data-urlencode "end=2025-05-02"
```

Se retornar 200 com JSON, o serviço está funcionando(lembrar que é necessário ter registros no banco).

---

## 4.0. Instalação do Scribe no Dockerfile

Para garantir que o Laravel Scribe seja instalado automaticamente na build da imagem Docker, adicione ao seu `Dockerfile` (na raiz do projeto) as seguintes etapas:

```dockerfile
# 8) Instale o Scribe e publique a config
RUN composer require --dev knuckleswtf/scribe \
 && php artisan vendor:publish \
      --provider="Knuckles\\Scribe\\ScribeServiceProvider" \
      --ansi --force
```

Com isso, ao reconstruir a imagem:

```bash
docker compose up -d --build app
```

o Scribe será instalado e configurado automaticamente. Depois, gere a documentação:

```bash
docker compose exec app php artisan scribe:generate
```

E acesse no navegador:

```
http://localhost/docs
```

para visualizar o Swagger UI gerado pelo Scribe.
