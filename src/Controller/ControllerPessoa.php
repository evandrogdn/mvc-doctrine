<?php

require_once __DIR__ . '/Controller.php';

/**
 * Controller das acoes do modulo pessoa
 * 
 * @author Evandro Gardolin <evandrogardolinn@gmail.com> (12/03/2023)
 */
class ControllerPessoa extends Controller 
{
    public function __construct()
    {
        // chama construtor para iniciar o manager da entity
        parent::__construct();
        $this->loadMVC('Pessoa');
    }

    /**
     * Método sobreescrito para aplicacao de filtros na consulta das pessoas
     *
     * @return array
     */
    public function list(): array
    {
        if (!array_key_exists('filtro_nome', $_POST) || !$_POST['filtro_nome']) {
            return parent::list();
        }

        $repository = $this->entityManager->getRepository($this->module);

        return $repository->createQueryBuilder('pes')
            ->where('lower(pes.nome) like lower(:pessoa_nome)')
            ->setParameter(':pessoa_nome', '%' . $_POST['filtro_nome'] . '%')
            ->getQuery()
            ->execute();
    }
}