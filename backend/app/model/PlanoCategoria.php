<?php

require_once __DIR__ . '\..\config\Database.php';

class PlanoCategoria extends Database {
    private $id_categoria; //chave composta
    private $pc_participacao; //chave composta
    private $fk_plano;

    function getIdCategoria() {
        return $this->id_categoria;
    }
    
    function getPcParticipacao() {
        return $this->pc_participacao;
    }
    
    function setIdCategoria($id) {
        $this->id_categoria = $id;
    }
    
    function setPcParticipacao($percentual) {
        $this->pc_participacao = $percentual;
    }
    
    function setFkPlano($fk_plano) {
        $this->fk_plano = $fk_plano;
    }

    function getPlanoCategoria() {
        try {
            $sql = "SELECT DISTINCT id_categoria FROM tb_plano_categoria ORDER BY id_categoria ASC";
            $stmt = $this->connect()->query($sql);

            $array = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $array[] = $row;
            }

            return $array;
        } catch(PDOException $e) {
            die('ERROR' . $e->getMessage());
        }
    }

    function setPlanoCategoria($id, $participcacao, $fk_plano) {

        try {
            $sql = "INSERT INTO tb_plano_categoria (id_categoria, pc_participacao, fk_plano) VALUES (:id_categoria, :pc_participacao, :fk_plano)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(':id_categoria', $id, PDO::PARAM_INT);
            $stmt->bindParam(':pc_participacao', $participcacao, PDO::PARAM_STR);
            $stmt->bindParam(':fk_plano', $fk_plano, PDO::PARAM_INT);
            $result = $stmt->execute();

            return $result;
        } catch(PDOException $e) {
            die('ERROR' . $e->getMessage());
        }
    }

    function deletePlanoCategoria($id, $percentual) {
        try {
            $sql = "DELETE FROM tb_plano_categoria WHERE id_categoria = :id_categoria AND pc_participacao = :pc_participacao";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam('id_categoria', $id, PDO::PARAM_INT);
            $stmt->bindParam('pc_participacao', $percentual, PDO::PARAM_STR);
            $result = $stmt->execute();

            return $result;
        } catch(PDOException $e) {
            die('ERROR' . $e->getMessage());
        }
    }
}

