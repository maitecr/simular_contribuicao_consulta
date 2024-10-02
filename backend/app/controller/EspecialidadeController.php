<?php

require_once __DIR__ . '\..\model\Especialidade.php';

class EspecialidadeController {
    private $especialidadeModel;

    function __construct() {
        $this->especialidadeModel = new Especialidade();
    }

    function read() {
        return $this->especialidadeModel->getEspecialidade();
    }

    function create($id, $especialidade, $valor, $fk_plano_saude) {
        return $this->especialidadeModel->setEspecialidade($id, $especialidade, $valor, $fk_plano_saude);
    }

    function delete($id) {
        return $this->especialidadeModel->deleteEspecialidade($id);
    }
}
