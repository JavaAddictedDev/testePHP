-- Create database if not exists
CREATE
DATABASE IF NOT EXISTS sistema_pedidos;
USE
sistema_pedidos;

-- Cliente table
CREATE TABLE Cliente
(
    id         INT AUTO_INCREMENT PRIMARY KEY,
    nome       VARCHAR(100) NOT NULL,
    cpf        CHAR(11)     NOT NULL UNIQUE,
    email      VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Produto table
CREATE TABLE Produto
(
    id             INT AUTO_INCREMENT PRIMARY KEY,
    codigo_barras  VARCHAR(20)    NOT NULL UNIQUE,
    nome           VARCHAR(100)   NOT NULL,
    valor_unitario DECIMAL(10, 2) NOT NULL,
    created_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Pedido table
CREATE TABLE Pedido
(
    id          INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id  INT NOT NULL,
    data_pedido TIMESTAMP      DEFAULT CURRENT_TIMESTAMP,
    status      VARCHAR(20)    DEFAULT 'Em Aberto',
    desconto    DECIMAL(10, 2) DEFAULT 0.00,
    created_at  TIMESTAMP      DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP      DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (cliente_id) REFERENCES Cliente (id),
    CHECK (status IN ('Em Aberto', 'Pago', 'Cancelado'))
);

-- ItemPedido table
CREATE TABLE ItemPedido
(
    id             INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id      INT            NOT NULL,
    produto_id     INT            NOT NULL,
    quantidade     INT            NOT NULL,
    valor_unitario DECIMAL(10, 2) NOT NULL,
    created_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (pedido_id) REFERENCES Pedido (id),
    FOREIGN KEY (produto_id) REFERENCES Produto (id)
);