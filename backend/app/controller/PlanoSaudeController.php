<?php

require_once __DIR__ . '\..\model\PlanoSaude.php';


class PlanoSaudeController {
    private $planoSaudeModel;

    function __construct() {
        $this->planoSaudeModel = new PlanoSaude();
    }

    function read() {
        return $this->planoSaudeModel->getPlanoSaude();
    }

    function create($id, $nome) {
        return $this->planoSaudeModel->setPlanoSaude($id, $nome);
    }

    function delete($id) {
        return $this->planoSaudeModel->deletePlanoSaude($id);
    }

}