<p align="center"><img src="https://github.com/simonedisegna/LojaAbc-ApiRest/blob/main/public/img/API_rest.png?raw=true" width="400" alt="Logo do projeto"></p>

## Documentação da API
### Descrição Geral:
A API foi desenvolvida para gerenciar vendas e produtos de uma loja. Ela fornece endpoints para listar produtos disponíveis, cadastrar novas vendas, consultar vendas realizadas, consultar uma venda específica e cancelar uma venda.

### Base URL:

```bash
http://localhost:8000/api/
```
### Endpoints Disponíveis:

#### Listar Produtos Disponíveis

```bash
GET /products
```
Este endpoint retorna uma lista de todos os produtos disponíveis na loja.

#### Cadastrar Nova Venda
```bash
POST /sales
```
Este endpoint permite cadastrar uma nova venda na loja, juntamente com os produtos vendidos.
##### Body

```json
{
  "products": [
    {
      "product_id": 1,
      "nome": "Celular 1",
      "price": 1800,
      "amount": 1
    },
    {
      "product_id": 2,
      "nome": "Celular 2",
      "price": 3200,
      "amount": 2
    }
  ]
}
```
#### Resposta
```json
{
    "message": "Venda cadastrada com sucesso",
    "data": {
        "id_sales": 16,
        "total_amount": 8200,
        "products": [
            {
                "product_id": 1,
                "nome": "Celular 1",
                "price": 1800,
                "amount": 1
            },
            {
                "product_id": 2,
                "nome": "Celular 2",
                "price": 3200,
                "amount": 2
            }
        ]
    }
}
```
**Parâmetros da Requisição:**

```bash
-sales_id (obrigatório): ID único da venda.
-total_amount (obrigatório): Valor total da venda.
-products (obrigatório): Array de objetos contendo os detalhes dos produtos vendidos.
  * product_id (obrigatório): ID do produto.
  * quantity (obrigatório): Quantidade do produto vendido.
  * price (obrigatório): Preço unitário do produto.
```

#### Consultar Vendas Realizadas
```bash
GET /sales
```
Este endpoint retorna uma lista de todas as vendas realizadas na loja, juntamente com os detalhes dos produtos vendidos em cada venda.

#### Consultar uma Venda Específica
```bash
GET /sales/{id}
```

#### Cancelar uma Venda
```bash
DELETE /sales/{id}
```
Este endpoint permite cancelar uma venda e remover os produtos associados a ela da loja.

#### Autenticação e Autorização:

A API é de acesso público e não requer autenticação para realizar as operações disponíveis.

### Exemplos de Uso:
Aqui estão alguns exemplos de como usar a API em diferentes cenários:

Listar Produtos Disponíveis:

```bash
GET http://localhost:8000/api/products
```

Cadastrar Nova Venda:

```bash
POST http://localhost:8000/api/sales
```

```bash
Body:
{
  "sales_id": "202301011",
  "total_amount": 8200,
  "products": [
    {
      "product_id": 1,
      "quantity": 1,
      "price": 1800
    },
    {
      "product_id": 2,
      "quantity": 2,
      "price": 3200
    }
  ]
}
```

Consultar Vendas Realizadas:

```bash
GET http://localhost:8000/api/sales
```
Consultar uma Venda Específica:

```bash
GET http://localhost:8000/api/sales/1
```
Cancelar uma Venda:

```bash
DELETE http://localhost:8000/api/sales/1
```

# Instalação
Siga estas etapas para instalar e configurar a API de Vendas:

1. Clone o repositório do projeto:

```bash
git clone https://github.com/seu-usuario/api-vendas.git
```

2. Navegue até o diretório do projeto:
```bash
cd api-vendas
```
3. Instale as dependências do Composer:
```bash
composer install
```
4. Copie o arquivo de ambiente de exemplo e configure-o conforme necessário:
```bash
cp .env.example .env
```
5. Gere uma nova chave de aplicativo:
```bash
php artisan key:generate
```
6. Configure seu banco de dados no arquivo .env.
7. Execute as migrações do banco de dados para criar as tabelas necessárias:
```bash
php artisan migrate
```
8. Inicie o servidor de desenvolvimento:
```bash
php artisan serve
```
A API de Vendas estará disponível em http://localhost:8000.