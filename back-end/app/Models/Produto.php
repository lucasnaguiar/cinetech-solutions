<?php

namespace App\Models;

use PDO;
use Core\BaseModel;


class Produto extends BaseModel
{

    protected string $table = "produtos";

    public int $id;
    public string $nome;
    public string $descricao;
    public string $preco;
    public string $estoque;
    public string $data_criacao;

    // construtor de basemodel??

    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    public function setDescricao(string $descricao): void
    {
        $this->descricao = $descricao;
    }

    public function setPreco(string $preco): void
    {
        $this->preco = $preco;
    }

    public function setEstoque(string $estoque): void
    {
        $this->estoque = $estoque;
    }

    public function setDataCriacao(string $dataCriacao): void
    {
        $this->data_criacao = $dataCriacao;
    }
}
