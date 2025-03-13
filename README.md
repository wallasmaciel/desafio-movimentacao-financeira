
# Desafio movimentação financeira

## Pré-requisitos
Antes de rodar o projeto, verifique se você tem as seguintes ferramentas instaladas:
- [Docker](https://www.docker.com) (para containerização do ambiente)
- [Docker compose](https://docs.docker.com/compose) (para orquestrar múltiplos containers)
- [Git](https://git-scm.com) (para clonar o repositório)

## Rodando o Projeto
### 1. Clonando o Repositório

Clone o repositório para sua máquina local e acesse a pasta:

```bash
  git clone https://github.com/wallasmaciel/desafio-movimentacao-financeira.git
  cd desafio-movimentacao-financeira
```

### 2. Copiar o arquivo **back/.env** de exemplo:

```bash
   cp back/.env.example back/.env
```

### 3. Substitua os seguintes campos no arquivo **back/.env**

```bash    
   DB_HOST="desafio-movimentacao-financeira-db"
   DB_PASSWORD="movimentacaoFinanceiraDB@123"
```

### 4. Subir os containers Docker

```bash    
   docker-compose up --build -d
```

### 5. Acesse o terminal do container

```bash    
   docker exec -it desafio-movimentacao-financeira-back bash
```

### 6. Rodar as migrações e seeders e sair do terminal
```bash
   php artisan migrate
   php artisan db:seed
   exit
```

## Pronto para Uso

Após seguir os passos acima, o seu ambiente estará configurado e o aplicativo estará pronto para uso. Você pode acessar a aplicação no seu navegador através do endereço:

http://localhost:3000