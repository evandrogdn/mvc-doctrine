<?php

// src
require __DIR__ . '/../Helper/HelperEntityManager.php';

// lib
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Controller padrão a ser extendido pelos demais controllers do projeto
 * 
 * @author Evandro Gardolin <evandrogardolinn@gmail.com> (10/03/2023)
 */
class Controller
{
    protected $model;
    protected $view;

    protected string $module;

    /**
     * @var EntityManagerInterface|EntityManager
     */
    protected $entityManager;

    public function __construct()
    {
        $this->entityManager = (new HelperEntityManager)();
    }

    /**
     * Carrega a instancia do model e da view referentes ao modulo
     *
     * @param string $classe
     * @return void
     */
    public function loadMVC(string $classe): void
    {
        require_once __DIR__ . '/../Model/Model' . ucfirst($classe) . '.php';
        require_once __DIR__ . '/../View/View' . ucfirst($classe) . '.php';

        $model = 'Model' . ucfirst($classe);
        $this->module = $model;
        $view = 'View' . ucfirst($classe);

        $this->model = new $model();
        $this->view = new $view();
    }

    /**
     * Insere o registro conforme os dados preechidos no formulário, e enviados via global $_POST
     *
     * @return void
     */
    public function insert(): void
    {
        foreach ($_POST as $field => $value) {
            // sem necessidade de chamar o metodo setter do registro, pois global __set implementado
            $this->model->{'set' . ucfirst($field)}($value);
        }

        // doctrine realiza a insercao do registro no banco de dados
        $this->entityManager->persist($this->model);
        $this->entityManager->flush();

        echo '
            <script type="text/javascript">
                window.location.href="index.php?class=' . $_GET['class'] . '&&method=list";
                alert("Registro inserido com sucesso");
            </script>
        ';
    }

    /**
     * Retorna uma listagem com todos os registros do modulo
     *
     * @return array
     */
    public function list(): array
    {
        $repository = $this->entityManager->getRepository($this->module);

        return $repository->findAll();
    }

    /**
     * Retorna o model de um unico registro
     * 
     * @param int $id => id do registro
     * @return mixed
     */
    public function show(int $id)
    {
        $this->model = $this->entityManager->find($this->module, $id);

        return $this->model;
    }

    /**
     * Remove um registro do banco de dados
     */
    public function delete()
    {
        $this->model = $this->entityManager->find($this->module, $_GET['id']);

        $this->entityManager->remove($this->model);
        $this->entityManager->flush();

        echo '
            <script type="text/javascript">
                window.location.href="index.php?class=' . $_GET['class'] . '&&method=list";
                alert("Registro removido com sucesso");
            </script>
        ';
    }

    /**
     * Atualiza um registro
     */
    public function update()
    {
        $this->model = $this->entityManager->find($this->module, $_GET['id']);

        foreach ($_POST as $field => $value) {
            if ($value === $this->model->{'get' . ucfirst($field)}()) {
                continue;
            }

            $this->model->{'set' . ucfirst($field)}($value);
        }

        $this->entityManager->flush();

        echo '
            <script type="text/javascript">
                window.location.href="index.php?class=' . $_GET['class'] . '&&method=list";
                alert("Registro alterado com sucesso");
            </script>
        ';
    }

    /**
     * Exibe a tela com a listagem dos registros do respetivo módulo
     *
     * @return void
     */
    public function showList(): void
    {
        echo $this->view->list();
    }

    /**
     * Exibe a tela para inserção dos registros do respectivo módulo
     *
     * @return void
     */
    public function showInsert(): void
    {
        echo $this->view->form();
    }

    /**
     * Exibe a tela para alterar o registro, mesma tela de inserção, apenas abre com
     * os campos do form preechidos
     *
     * @param integer $id => ID do registro
     * 
     * @return void
     */
    public function showUpdate(int $id): void
    {
        echo $this->view->form($id);
    }

    /**
     * Exibe a tela para visualizar o registro, mesma tela de inserção e atualização, apenas
     * abre com os campos do form preenchidos, e bloqueados para edição
     *
     * @param integer $id
     * @return void
     */
    public function showView(int $id): void
    {
        echo $this->view->form($id, 'readonly');
    }
}