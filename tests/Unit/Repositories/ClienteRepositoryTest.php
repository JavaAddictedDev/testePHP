<?php

namespace Repositories;

use App\Models\Cliente;
use PHPUnit\Framework\TestCase;

class ClienteRepositoryTest extends TestCase
{
private \PDO $pdo;
private ClienteRepository $repository;

protected function setUp():void {
    parent::setUp();

    $this->pdo = new \PDO(
        'mysql:host=mysql;dbname=sistema_pedidos_test',
        'user',
        'password',
        [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
    );

    $this->pdo->exec('TRUNCATE TABLE Cliente');

    $this->repository = new ClienteRepository($this->pdo);
}

    public function test_deve_criar_novo_cliente(): void
    {
        $cliente = new Cliente([
            'nome' => 'João Silva',
            'cpf' => '12345678901',
            'email' => 'joao@email.com'
        ]);

        $clienteSalvo = $this->repository->save($cliente);

        $this->assertNotNull($clienteSalvo->getId());
        $this->assertEquals('João Silva', $clienteSalvo->getNome());
    }

    public function test_deve_buscar_cliente_por_id(): void
    {
        $cliente = new Cliente([
            'nome' => 'João Silva',
            'cpf' => '12345678901',
            'email' => 'joao@email.com'
        ]);

        $clienteSalvo = $this->repository->save($cliente);
        $clienteEncontrado = $this->repository->findById($clienteSalvo->getId());

        $this->assertEquals($clienteSalvo->getId(), $clienteEncontrado->getId());
        $this->assertEquals($clienteSalvo->getNome(), $clienteEncontrado->getNome());
    }

    public function test_deve_listar_clientes_paginados(): void
    {
        // Cria 25 clientes
        for ($i = 1; $i <= 25; $i++) {
            $cliente = new Cliente([
                'nome' => "Cliente {$i}",
                'cpf' => str_pad($i, 11, '0', STR_PAD_LEFT),
                'email' => "cliente{$i}@email.com"
            ]);
            $this->repository->save($cliente);
        }

        $clientes = $this->repository->findAll(1, 20);
        $this->assertCount(20, $clientes);

        $segundaPagina = $this->repository->findAll(2, 20);
        $this->assertCount(5, $segundaPagina);
    }

}