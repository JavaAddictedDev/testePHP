<?php

namespace App\Repositories;

use App\Models\Cliente;
use PDO;

class ClienteRepository implements ClienteRepositoryInterface
{
    public function __construct(private PDO $pdo)
    {
    }

    public function findAll(int $page = 1, int $perPage = 20): array
    {
        $offset = ($page - 1) * $perPage;

        $stmt = $this->pdo->prepare(
            'SELECT * FROM Cliente ORDER BY nome LIMIT :limit OFFSET :offset'
        );

        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return array_map(
            fn($row) => $this->hydrate($row),
            $stmt->fetchAll(PDO::FETCH_ASSOC)
        );
    }

    public function findById(int $id): ?Cliente
    {
        $stmt = $this->pdo->prepare('SELECT * FROM Cliente WHERE id = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $this->hydrate($row) : null;
    }

    public function findByCpf(string $cpf): ?Cliente
    {
        $stmt = $this->pdo->prepare('SELECT * FROM Cliente WHERE cpf = :cpf');
        $stmt->bindValue(':cpf', $cpf);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $this->hydrate($row) : null;
    }

    public function save(Cliente $cliente): Cliente
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO Cliente (nome, cpf, email) VALUES (:nome, :cpf, :email)'
        );

        $stmt->execute([
            ':nome' => $cliente->getNome(),
            ':cpf' => $cliente->getCpf(),
            ':email' => $cliente->getEmail()
        ]);

        $cliente->setId((int)$this->pdo->lastInsertId());
        return $cliente;
    }

    public function update(Cliente $cliente): bool
    {
        $stmt = $this->pdo->prepare(
            'UPDATE Cliente SET nome = :nome, email = :email WHERE id = :id'
        );

        return $stmt->execute([
            ':id' => $cliente->getId(),
            ':nome' => $cliente->getNome(),
            ':email' => $cliente->getEmail()
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM Cliente WHERE id = :id');
        return $stmt->execute([':id' => $id]);
    }

    public function getTotalRecords(): int
    {
        return (int)$this->pdo->query('SELECT COUNT(*) FROM Cliente')
            ->fetchColumn();
    }

    private function hydrate(array $row): Cliente
    {
        $cliente = new Cliente([
            'nome' => $row['nome'],
            'cpf' => $row['cpf'],
            'email' => $row['email']
        ]);
        $cliente->setId((int)$row['id']);
        return $cliente;
    }
}