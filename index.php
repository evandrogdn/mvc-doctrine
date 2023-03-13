<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    </head>

    <body>
        <header style="margin-left: 30px">
            <a class="btn btn-outline-primary" role="button" href="index.php?class=person&&method=list">Pessoas</a>
            <a class="btn btn-outline-primary" role="button" href="index.php?class=contacts&&method=list&&all=1">Contatos</a>
        </header>
    </body>
</html>

<?php

require './vendor/autoload.php';

require './src/Controller/ControllerPessoa.php';
require './src/Controller/ControllerContato.php';

if ($_GET['class'] && $_GET['method']) {
    $controller = null;

    switch ($_GET['class']) {
        case 'person':
            $controller = new ControllerPessoa();
            break;
        case 'contacts':
            $controller = new ControllerContato();
            break;
    }

    if ($controller) {
        switch ($_GET['method']) {
            // bloco de acoes de tela
            case 'list':
                $controller->showList();
                break;
            case 'view':
                $controller->showView($_GET['id']);
                break;
            case 'create':
                $controller->showInsert();
                break;
            case 'update':
                $controller->showUpdate($_GET['id']);
                break;
            
            // acoes originarias do formulário
            case 'doCreate':
                $controller->insert();
                break;
            case 'doUpdate':
                $controller->update();
                break;
            case 'doDelete':
                $controller->delete();
                break;
        }
    }
}