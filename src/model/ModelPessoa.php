<?php

namespace App\Model;

use ModelContato;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * Definição da entidade de pessoa
 * 
 * @author Evandro Gardolin <evandrogardolinn@gmail.com> (10/03/2023)
 */

#[Entity]
#[Table(name: 'pessoa')]
class ModelPessoa extends Model
{
    #[Id]
    #[Column(type: 'string')]
    #[GeneratedValue()]
    private int $id;

    #[Column(type: 'string')]
    private string $nome;

    #[Column(type: 'string')]
    private string $cpf;

    /** @var Collection<int, ModelContato> */
    #[ManyToOne(targetEntity: ModelContato::class)]
    private Collection $contatos;

    /**
     * Adiciona o vinculo de um contato a uma pessoa
     *
     * @param ModelContato $contato
     * @return void
     */
    public function addContato(ModelContato $contato):void
    {
        $this->contatos[] = $contato;
    }
}