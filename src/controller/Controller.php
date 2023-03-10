<?php

/**
 * Controller padrão a ser extendido pelos demais controllers do projeto
 * 
 * @author Evandro Gardolin <evandrogardolinn@gmail.com> (10/03/2023)
 */
class Controller
{
    private $model;
    private $view;

    public function __construct()
    {
        
    }

    /**
     * Carrega a instancia do model e da view referentes ao modulo
     *
     * @param string $classe
     * @return void
     */
    public function carregaMVC(string $classe): void
    {
        require '../model/Model' . ucfirst($classe) . '.php';
        require '../view/View' . ucfirst($classe) . '.php';

        $model = 'Model' . ucfirst($classe);
        $view = 'View' . ucfirst($classe);

        $this->model = new $model();
        $this->view = new $view();
    }
}