<?php

namespace App\Repositories;

use App\Models\Cliente;

interface ClienteRepositoryInterface
{
    public function findAll(int $page = 1, int $perPage = 20): array;
    public function findById(int $id): ?Cliente;
    public function findByCpf(string $cpf): ?Cliente;
    public function save(Cliente $cliente): Cliente;
    public function update(Cliente $cliente): bool;
    public function delete(int $id): bool;
    public function getTotalRecords(): int;
}