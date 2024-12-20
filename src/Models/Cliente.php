<?php

namespace App\Models;

class Cliente
{
private string $nome;
private string $cpf;
private string $email;
    public function __construct(array $dados)
    {
        $this->setNome($dados['nome']);
        $this->setCpf($dados['cpf']);
        $this->setEmail($dados['email']);
    }

    private function setNome(string $nome): void
    {
        if (empty($nome)) {
            throw new \InvalidArgumentException('Nome não pode ser vazio');
        }
        $this->nome = $nome;
    }

    private function setCpf(string $cpf): void
    {
        if (!$this->validaCpf($cpf)) {
            throw new \InvalidArgumentException('CPF inválido');
        }
        $this->cpf = $cpf;
    }

    private function setEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Email inválido');
        }
        $this->email = $email;
    }

    private function validaCpf(string $cpf): bool
    {
        return strlen($cpf) === 11 && ctype_digit($cpf);
    }

    // Getters
    public function getNome(): string
    {
        return $this->nome;
    }

    public function getCpf(): string
    {
        return $this->cpf;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}