<?php
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