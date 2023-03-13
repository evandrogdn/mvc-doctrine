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
            $grid .= '<td>' . $contato->getId() . '</td>';
            $grid .= '<td>' . ucfirst($contato->getTipo()) . '</td>';
            $grid .= '<td>' . $contato->getDescricao() . '</td>';
            if (array_key_exists('all', $_GET)) {
                if ($_GET['all']) {
                    $pessoa = (new ControllerPessoa)->show($contato->getIdPessoa());
                    $grid .= '<td>' . $pessoa->getNome() . '</td>';
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
            <th>Proprietário</th>
        ';
        if (!array_key_exists('all', $_GET) || !$_GET['all']) {
            $pessoa = (new ControllerPessoa)->show($_GET['person_id']);
            $buttons = '
                <form action="index.php?class=person&&method=list" method="post">
                    <a href="index.php?class=contacts&&method=create&&person_id=' . $_GET['person_id'] . '">Novo</a>
                    <p>Exibindo contatos de ' . $pessoa->getNome() . '</p>
                </form>
            ';

            $columnProprietario = '<th colspan="3">Ações</th>';
        }

        return '
            <table>
                ' . $buttons . '
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tipo</th>
                        <th>Contato</th>
                        ' . $columnProprietario . '
                    </tr>
                </thead>
                <tbody>
                ' . $grid . '
                </tbody>
            </table>
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
            $button = '<input type="submit" value="Gravar" />';
        }

        $form = '
            <form action="' . $action . '" method="post">
                <label for="tipo">Tipo</label>
                <select name=tipo id="tipo">
                    <option value="telefone" %s>Telefone</option>
                    <option value="email" %s>Email</option>
                </select>

                <label for="descricao">Contato</label>
                <input type="text" name="descricao" id="descricao" required value="%s" %s />

                <input type="hidden" value="%s" name="idPessoa" />
                %s
            </form>
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