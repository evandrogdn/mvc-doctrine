<?php

require_once __DIR__ . '/IView.php';
require_once __DIR__ . '/../Controller/ControllerPessoa.php';

/**
 * Implementações visuais da tela de pessoas
 * 
 * @author Evandro Gardolin <evandrogardolinn@gmail.com> (12/03/2023)
 */
class ViewPessoa implements IView
{
    /**
     * Monta o grid de consulta de todos os registros
     *
     * @return string
     */
    public function list(): string
    {
        $pessoas = (new ControllerPessoa())->list();

        $grid = '';
        // monta o grid dos registros salvos dentro do aplicativo
        foreach ($pessoas as $pessoa) {
            $grid .= '<tr>';
            $grid .= '<td style="text-align: center">' . $pessoa->getId() . '</td>';
            $grid .= '<td>' . $pessoa->getNome() . '</td>';
            $grid .= '<td style="text-align: center">' . $pessoa->getCpf() . '</td>';
            $grid .= '<td><a href="index.php?class=person&&method=update&&id=' . $pessoa->getId() . '"><i class="glyphicon glyphicon-pencil"></i></a></td>';
            $grid .= '<td><a href="index.php?class=person&&method=view&&id='  . $pessoa->getId() . '"><i class="glyphicon glyphicon-search"></i></a></td>';
            $grid .= '<td><a href="index.php?class=person&&method=doDelete&&id='  . $pessoa->getId() . '"><i class="glyphicon glyphicon-minus"></i></a></td>';
            $grid .= '<td><a href="index.php?class=contacts&&method=list&&person_id=' . $pessoa->getId() . '"><i class="glyphicon glyphicon-th-list"></i></a></td>';
            $grid .= '</tr>';
        }

        return '
            <div class="d-flex justify-content-center flex-nowrap" style="margin: 30px">
                <table class="table table-hover table-striped">

                    <form action="index.php?class=person&&method=list" method="post">
                        <div class="form-group row">
                            <a class="btn btn-outline-primary" role="button" href="index.php?class=person&&method=create">Novo</a>
                            <input type="text" name="filtro_nome" class="form-control"/>
                        </div>
                        <div class="form-group row">
                            <button class="btn btn-primary pull-right" type="submit">Filtrar</button>
                        </div>
                    </form>

                    <thead>
                        <tr>
                            <th style="text-align: center">ID</th>
                            <th style="text-align: center">Nome</th>
                            <th style="text-align: center">CPF</th>
                            <th style="text-align: center" colspan="4">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    ' . $grid . '
                    </tbody>
                </table>
            </div>
        ';
    }

    /**
     * Monta o formulario de insercao, visualizacao e edição do registro
     *
     * @param integer|null $id
     * @param string $mode
     * @return string
     */
    public function form(int $id = null, string $mode = ''): string
    {
        // carregamento de model quando edicao ou visualização de registro unico
        $model = null;
        if ($id) {
            $model = (new ControllerPessoa())->show($id);
        }

        // controle de acao, para que form controle se estamos lidando com update ou create
        $action = '';
        if (!$id && !$mode) {
            $action = 'index.php?class=person&&method=doCreate';
        } else {
            $action = 'index.php?class=person&&method=doUpdate&&id=' . $id;
        }

        // formulario de visualização não vai exibir nenhum botao
        $button = '';
        if ($mode !== 'readonly') {
            $button = '<div class="form-group row pull-right"> <input type="submit" class="btn btn-primary" value="Gravar" /> </div>';
        }

        $form = '
            <div class="d-flex justify-content-center flex-nowrap" style="margin: 30px">
                <form action="' . $action . '" method="post">
                    <div class="form-group row">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" name="nome" class="form-control" id="nome" required value="%s" %s />
                    </div>

                    <div class="form-group row">
                        <label for="cpf" class="form-label">CPF</label>
                        <input type="text" name="cpf" class="form-control" id="cpf" maxlength="11" required value="%s" %s />
                    </div>

                    %s
                </form>
            </div>
        ';

        // retornando de forma a facilitar tratamento quando renderizar em tela
        return sprintf(
            $form,
            $id ? $model->getNome() : '',
            $mode,
            $id ? $model->getCpf() : '',
            $mode,
            $button
        );
    }
}