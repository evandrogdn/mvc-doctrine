<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
    </head>

    <body>
        <header>
            <a href="index.php?class=person&&method=list">Pessoas</a>
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
        }
    }
}