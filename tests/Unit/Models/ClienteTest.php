<?php

namespace Tests\Unit\Models;

use App\Models\Cliente;
use http\Client;
use PHPUnit\Framework\TestCase;

class ClienteTest extends TestCase
{
    public function test_deve_criar_novo_cliente_com_dados_validos()
    {
        $dados = [
            'nome' => 'João Silva',
            'cpf' => '12345678901',
            'email' => 'joao@email.com'
        ];

        $cliente = new Cliente($dados);

        $this->assertEquals($dados['nome'], $cliente->getNome());
        $this->assertEquals($dados['cpf'], $cliente->getCpf());
        $this->assertEquals($dados['email'], $cliente->getEmail());
    }
    public function test_deve_validar_cpf_invalido() {
        $this->expectException(\InvalidArgumentException::class);

        $dados=[
            'nome' => 'João Silva',
            'cpf' => '123', // CPF inválido
            'email' => 'joao@email.com'
        ];

        new Cliente($dados);
    }

        public function test_deve_validar_email_invalido()
    {
        $this->expectException(\InvalidArgumentException::class);

        $dados = [
            'nome' => 'João Silva',
            'cpf' => '12345678901',
            'email' => 'email_invalido'
        ];

        new Cliente($dados);
    }
}