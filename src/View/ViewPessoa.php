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
            $grid .= '<td>' . $pessoa->getId() . '</td>';
            $grid .= '<td>' . $pessoa->getNome() . '</td>';
            $grid .= '<td>' . $pessoa->getCpf() . '</td>';
            $grid .= '<td><a href="index.php?class=person&&method=update&&id=' . $pessoa->getId() . '">editar</a></td>';
            $grid .= '<td><a href="index.php?class=person&&method=view&&id='  . $pessoa->getId() . '">visualizar</a></td>';
            $grid .= '<td><a href="index.php?class=person&&method=doDelete&&id='  . $pessoa->getId() . '">remover</a></td>';
            $grid .= '<td><a href="index.php?class=contacts&&method=list&&person_id=' . $pessoa->getId() . '">contatos</a></td>';
            $grid .= '</tr>';
        }

        return '
            <table>

                <a href="index.php?class=person&&method=create">Novo</a>
                <input type="text" name="filtro_nome">
                <a href="index.php?class=person&&method=list">Filtrar</a>

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th colspan="3">Ações</th>
                    </tr>
                </thead>
                <tbody>
                ' . $grid . '
                </tbody>
            </table>
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
            $button = '<input type="submit" value="Gravar" />';
        }

        $form = '
            <form action="' . $action . '" method="post">
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" required value="%s" %s />

                <label for="cpf">CPF</label>
                <input type="text" name="cpf" id="cpf" maxlength="11" required value="%s" %s />

                %s
            </form>
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