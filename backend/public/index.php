<?php

require_once __DIR__ . '\..\app\controller\EspecialidadeController.php';
require_once __DIR__ . '\..\app\controller\PlanoSaudeController.php';
require_once __DIR__ . '\..\app\controller\PlanoCategoriaController.php';
require_once __DIR__ . '\..\app\controller\ApiController.php';
require_once __DIR__ . '\..\app\config\Database.php';

if($_SERVER['REQUEST_METHOD'] === 'GET') {
        $api = new ApiController();
        $listagem = $api->getAllData();
    }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $api = new ApiController();

        $nm_especialidade = $_POST['nm_especialidade'];
        $id_categoria = $_POST['id_categoria'];
        $id_plano_saude = $_POST['id_plano_saude'];

        $valorConsulta = $api->getContribuicaoValorConsulta($nm_especialidade, $id_categoria, $id_plano_saude);
        
        header('Content-Type: application/json');

        echo json_encode(['valorConsulta' => $valorConsulta]);
        exit();
    }








