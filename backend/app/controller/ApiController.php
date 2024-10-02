<?php

require_once __DIR__ . '\..\model\Especialidade.php';
require_once __DIR__ . '\..\model\PlanoCategoria.php';
require_once __DIR__ . '\..\model\PlanoSaude.php';

class ApiController {
    private $especialidadeModel;
    private $planoSaudeModel;
    private $planoCategoriaModel;

    function __construct() {
        $this->especialidadeModel = new Especialidade();
        $this->planoSaudeModel = new PlanoSaude();
        $this->planoCategoriaModel = new PlanoCategoria();
    }

    function getAllData() {
        $especialidadeDados = $this->especialidadeModel->getEspecialidade();
        $planoSaudeDados = $this->planoSaudeModel->getPlanoSaude();
        $planoCategoriaDados = $this->planoCategoriaModel->getPlanoCategoria();

        $dados = [
            'especialidade' => $especialidadeDados,
            'planoSaude' => $planoSaudeDados,
            'planoCategoria' => $planoCategoriaDados,
        ];

        header('Content-Type: application/json');
        echo json_encode($dados);
    }

    function getContribuicaoValorConsulta($nm_especialidade, $id_categoria, $id_plano_saude) {
        $valorConsultaContribuicao = $this->planoSaudeModel->readContribuicaoValorConsulta($nm_especialidade, $id_categoria, $id_plano_saude);
        
        //header('Content-Type: application/json');
        //echo json_encode($valorConsultaContribuicao);
        return $valorConsultaContribuicao;
    }

    function createEspecialidade($id, $especialidade, $valor, $fk_plano_saude) {
        return $this->especialidadeModel->setEspecialidade($id, $especialidade, $valor, $fk_plano_saude);
    }

    function createPlanoSaude($id, $nome) {
        return $this->planoSaudeModel->setPlanoSaude($id, $nome);
    }

    function createPlanoCategoria($id, $participcacao, $fk_plano) {
        header('Content-Type: application/json');
        echo $this->planoCategoriaModel->setPlanoCategoria($id, $participcacao, $fk_plano);
    }

}