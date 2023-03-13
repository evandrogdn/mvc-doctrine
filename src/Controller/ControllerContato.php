<?php

require_once 'Controller.php';

/**
 * Controller das ações do modulo de contatos
 * 
 * @author Evandro Gardolin <evandrogardolinn@gmail.com> (12/03/2023)
 */
class ControllerContato extends Controller
{
    public function __construct()
    {
        // chama construtor para iniciar o manager da entity
        parent::__construct();
        $this->loadMVC('Contato');
    }

    /**
     * Retorna a lista de contatos vinculados a uma pessoa
     *
     * @param integer $pessoaID
     * @return array
     */
    public function listContratosByPessoa(int $pessoaID): array
    {
        $repository = $this->entityManager->getRepository($this->module);

        return $repository->findBy(['idPessoa' => $pessoaID], ['id' => 'desc']);
    }

    /**
     * Reescreve o metodo de insercao para garantir a passagem dos params de pessoa
     *
     * @param string $complemento
     * @return void
     */
    public function insert(string $complemento = ''): void
    {
        parent::insert('&&person_id=' . $_POST['idPessoa']);
    }

    /**
     * Reescreve o metodo de atualizacao para garantir a passagem dos params de pessoa
     *
     * @param string $complemento
     * @return void
     */
    public function update(string $complemento = ''): void
    {
        parent::update('&&person_id=' . $_POST['idPessoa']);
    }
}