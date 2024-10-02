<?php

require_once __DIR__ . '\..\model\PlanoCategoria.php';


class PlanoCategoriaController {
    private $planoCategoriaModel;

    function __construct() {
        $this->planoCategoriaModel = new PlanoCategoria();
    }

    function read() {
        return $this->planoCategoriaModel->getPlanoCategoria();
    }

    function create($id, $participcacao, $fk_plano) {
        return $this->planoCategoriaModel->setPlanoCategoria($id, $participcacao, $fk_plano);
    }

    function delete($id, $percentual) {
        return $this->planoCategoriaModel->deletePlanoCategoria($id, $percentual);
    }
}
