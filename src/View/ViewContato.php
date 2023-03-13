<?php

require_once __DIR__ . '/IView.php';
require_once __DIR__ . '/../Controller/ControllerContato.php';
require_once __DIR__ . '/../Controller/ControllerPessoa.php';

class ViewContato implements IView
{
    public function list(): string
    {
        if (array_key_exists('person_id', $_GET)) {
            $contatos = (new ControllerContato())->listContratosByPessoa($_GET['person_id']);
        } else {
            $contatos = (new ControllerContato())->list();
        }

        $grid = '';
        // monta o grid dos registros salvos dentro do aplicativo
        foreach ($contatos as $contato) {
            $grid .= '<tr>';
            $grid .= '<td style="text-align: center">' . $contato->getId() . '</td>';
            $grid .= '<td style="text-align: center">' . ucfirst($contato->getTipo()) . '</td>';
            $grid .= '<td style="text-align: center">' . $contato->getDescricao() . '</td>';
            if (array_key_exists('all', $_GET)) {
                if ($_GET['all']) {
                    $pessoa = (new ControllerPessoa)->show($contato->getIdPessoa());
                    $grid .= '<td style="text-align: center">' . $pessoa->getNome() . '</td>';
                }
            } else {
                $grid .= '<td><a href="index.php?class=contacts&&method=update&&id=' . $contato->getId() . '"><i class="glyphicon glyphicon-pencil"></i></a></td>';
                $grid .= '<td><a href="index.php?class=contacts&&method=view&&id='  . $contato->getId() . '"><i class="glyphicon glyphicon-search"></i></a></td>';
                $grid .= '<td><a href="index.php?class=contacts&&method=doDelete&&id='  . $contato->getId() . '"><i class="glyphicon glyphicon-minus"></i></a></td>';
            }
            $grid .= '</tr>';
        }

        $buttons = '';
        
        $columnProprietario = '
            <th style="text-align: center">Proprietário</th>
        ';
        if (!array_key_exists('all', $_GET) || !$_GET['all']) {
            $pessoa = (new ControllerPessoa)->show($_GET['person_id']);
            $buttons = '
                <form action="index.php?class=person&&method=list" method="post">
                    <div class="form-group">
                        <h5 style="text-align: center;">Exibindo contatos de ' . $pessoa->getNome() . '</h5>
                        <a class="btn btn-outline-primary" role="button" href="index.php?class=contacts&&method=create&&person_id=' . $_GET['person_id'] . '">Novo</a>
                    </div>
                </form>
            ';

            $columnProprietario = '<th style="text-align: center" colspan="3">Ações</th>';
        }

        return '
            <div class="d-flex justify-content-center flex-nowrap" style="margin: 30px">
                <table class="table table-hover table-striped">
                    ' . $buttons . '
                    <thead>
                        <tr>
                            <th style="text-align: center">ID</th>
                            <th style="text-align: center">Tipo</th>
                            <th style="text-align: center">Contato</th>
                            ' . $columnProprietario . '
                        </tr>
                    </thead>
                    <tbody>
                    ' . $grid . '
                    </tbody>
                </table>
            </div>
        ';
    }

    public function form(int $id = null, string $mode = ''): string
    {
        // carregamento de model quando edicao ou visualização de registro unico
        $model = null;
        if ($id) {
            $model = (new ControllerContato())->show($id);
        }

        // controle de acao, para que form controle se estamos lidando com update ou create
        $action = '';
        if (!$id && !$mode) {
            $action = 'index.php?class=contacts&&method=doCreate';
        } else {
            $action = 'index.php?class=contacts&&method=doUpdate&&id=' . $id;
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
                        <label for="tipo" class="form-label">Tipo</label>
                        <select class="form-control" name=tipo id="tipo">
                            <option value="telefone" %s>Telefone</option>
                            <option value="email" %s>Email</option>
                        </select>
                    </div>

                    <div class="form-group row">
                        <label for="descricao" class="form-label">Contato</label>
                        <input type="text" name="descricao" class="form-control" id="descricao" required value="%s" %s />
                    </div>

                    <div class="form-group row">
                        <input type="hidden" value="%s" name="idPessoa" />
                    </div>
                    %s
                </form>
            </div>
        ';

        // retornando de forma a facilitar tratamento quando renderizar em tela
        return sprintf(
            $form,
            $id && $model->getTipo() === 'telefone' ? 'selected' : '',
            $id && $model->getTipo() === 'email' ? 'selected' : '',
            $id ? $model->getDescricao() : '',
            $mode,
            $id ? $model->getIdPessoa() : $_GET['person_id'],
            $button
        );
    }
}