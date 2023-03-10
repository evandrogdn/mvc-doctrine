<?php

/**
 * Model padraão para o projeto, a ser extendido pelos demais a serem implementados
 * 
 * @author Evandro Gardolin <evandrogardolinn@gmail.com> (10/03/2023)
 */
class Model 
{
    /**
     * Método mágico para acessar as propriedades do objeto, sem necessidade de definir getter
     *
     * @param mixed $prop
     * @return mixed
     */
    public function __get(mixed $prop): mixed 
    {
        return $this->$prop;
    }

    /**
     * Método mágico para atribuir as propriedades do objeto, sem necessidade de definir setter
     *
     * @param mixed $prop
     * @param mixed $value
     * @return void
     */
    public function __set(mixed $prop, mixed $value): void
    {
        $this->$prop = $value;
    }
}