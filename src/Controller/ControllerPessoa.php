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
}