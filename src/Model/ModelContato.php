<?php

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;

/**
 * Definicao da entidade de contatos
 * 
 * @author Evandro Gardolin <evandrogardolinn@gmail.com> (12/03/2023)
 */
#[Entity]
#[Table(name: 'contato')]
class ModelContato
{
    #[Id]
    #[Column(type: 'integer')]
    #[GeneratedValue()]
    private int $id;

    #[Column(type: 'string')]
    private string $tipo;

    #[Column(type: 'string')]
    private string $descricao;

    #[Column(name: 'id_pessoa', type: 'integer')]
    private int $idPessoa;

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
    public function getTipo(): string
    {
        return $this->tipo;
    }

    /**
     * @param string $tipo
     * @return void
     */
    public function setTipo(string $tipo): void
    {
        $this->tipo = $tipo;
    }

    /**
     * @return string
     */
    public function getDescricao(): string
    {
        return $this->descricao;
    }

    /**
     * @param string $descricao
     * @return void
     */
    public function setDescricao(string $descricao): void
    {
        $this->descricao = $descricao;
    }

    /**
     * @return integer
     */
    public function getIdPessoa(): int
    {
        return $this->idPessoa;
    }

    /**
     * @param integer $idPessoa
     * @return void
     */
    public function setIdPessoa(int $idPessoa): void
    {
        $this->idPessoa = $idPessoa;
    }
}