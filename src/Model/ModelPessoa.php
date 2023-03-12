<?php

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;

/**
 * Definição da entidade de pessoa
 * 
 * @author Evandro Gardolin <evandrogardolinn@gmail.com> (10/03/2023)
 */

#[Entity]
#[Table(name: 'pessoa')]
class ModelPessoa
{
    #[Id]
    #[Column(type: 'string')]
    #[GeneratedValue()]
    private int $id;

    #[Column(type: 'string')]
    private string $nome;

    #[Column(type: 'string')]
    private string $cpf;

    /**
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param integer $id
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     * @return void
     */
    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    /**
     * @return string
     */
    public function getCpf(): string
    {
        return $this->cpf;
    }

    /**
     * @param string $cpf
     * @return void
     */
    public function setCpf(string $cpf): void
    {
        $this->cpf = $cpf;
    }
}