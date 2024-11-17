
# Projeto Teste Kanastra

Este projeto foi feito em Laravel e configurado para rodar em um ambiente Docker. Ele utiliza serviços de PHP, Nginx, MySQL, Redis e Horizon para processar tarefas em segundo plano.

---

## **Pré-requisitos**

Antes de iniciar, você precisará dos seguintes softwares instalados:

1. **Docker** - [Instruções de instalação](https://docs.docker.com/get-docker/)
2. **Docker Compose** - [Instruções de instalação](https://docs.docker.com/compose/install/)

---

## **Instruções de Configuração**

### 1. **Configurar o `.env`**
Crie o arquivo `.env` baseado no arquivo de exemplo:
```bash
cp .env.example .env
```
Atualize as configurações do banco de dados no `.env` para coincidir com as configurações do Docker:
```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=user
DB_PASSWORD=password

QUEUE_CONNECTION=redis
REDIS_HOST=redis
REDIS_PORT=6379
```

### 2. **Configurar o Docker**
Certifique-se de que você possui os arquivos de configuração necessários:
- `docker-compose.yml`: Configura os serviços.
- `nginx/default.conf`: Configuração do Nginx.
- `php/php.ini`: Configuração do PHP.

### 3. **Subir os Containers**
No diretório do projeto, execute:
```bash
docker-compose up --build
```
Este comando irá construir as imagens e iniciar os containers.

### 4. **Instalar as Dependências do Laravel**
Acesse o container PHP para instalar as dependências:
```bash
docker exec -it laravel-app bash
composer install
php artisan key:generate
php artisan migrate
php artisan storage:link
exit
```

### 5. **Acessar o Projeto**
Após os containers estarem em execução:
- O Horizon estará disponível em: [http://localhost:8080/horizon](http://localhost:8080/horizon)

---

## **Trabalhando com o CSV**
A aplicação possui a rota API http://localhost:8080/api/upload-csv, a qual possui um parametro csv_file no qual deve ser inserido o csv a ser processado.

### 1. **Enviar CSV**
Utilize ferramentas como `Postman` ou `curl` para realizar a requisição:
```bash
curl --location 'http://localhost:8080/api/upload-csv' \
--form 'csv_file=@"/home/joaovictor/Downloads/input.csv"'
```

### 2. **Logs de Processamento**
Os logs do sistem serão registrados em (`storage/logs/laravel.log`). Já os logs do processamento dos boletos estarão em (`storage/logs/boletos_log.log`)

---

## **Comandos Úteis**

- **Subir os containers:** 
  ```bash
  docker-compose up -d
  ```
- **Parar os containers:** 
  ```bash
  docker-compose down
  ```
- **Acessar o container PHP:** 
  ```bash
  docker exec -it laravel-app bash
  ```
- **Limpar cache e otimizar:** 
  ```bash
  php artisan cache:clear
  php artisan config:cache
  php artisan route:cache
  ```

---
## **Rodando os testes unitários**

Para rodar os testes unitário será necessário executar o comando abaixo:
```bash
  docker exec -it laravel-app bash
  ```
---

## **Notas Finais**

- Certifique-se de que o ambiente de desenvolvimento esteja utilizando permissões corretas para evitar problemas com escrita/leitura.
- Em caso de dúvidas ou problemas, verifique os logs dos containers:
  ```bash
  docker logs laravel-app
  docker logs nginx-laravel
  docker logs mysql-laravel
  ```