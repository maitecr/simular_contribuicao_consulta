<?php

require_once __DIR__ . '\..\config\Database.php';


class Especialidade extends Database{
    private $id_especialidade;
    private $nm_especialidade;
    private $vl_consulta;

    function getIdEspecialidade() {
        return $this->id_especialidade;
    }
    
    function getNmEspecialidade() {
        return $this->nm_especialidade;
    }
    
    function getVlConsulta() {
        return $this->vl_consulta;
    }
    
    function setIdEspecialidade($id) {
        $this->id_especialidade = $id;
    }
    
    function setNmEspecialidade($especialidade) {
        $this->nm_especialidade = $especialidade;
    }
    
    function setVlConsulta($valor) {
        $this->vl_consulta = $valor;
    }
    
    function getEspecialidade() {
        try {
            $sql = "SELECT * FROM tb_especialidade ORDER BY nm_especialidade ASC";
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

    function getEspecialidadePorPlano($id_plano_saude) {
        try {
            $sql = "SELECT nm_especialidade FROM tb_especialidade, tb_plano_saude WHERE fk_plano_saude = :id_plano_saude ORDER BY nm_especialidade ASC";
            $stmt = $this->connect()->query($sql);
            $stmt->bindParam(':id_plano_saude', $id_plano_saude, PDO::PARAM_INT);


            $array = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $array[] = $row;
            }

            return $array;
        } catch(PDOException $e) {
            die('ERROR' . $e->getMessage());
        }
    }


    function setEspecialidade($id, $especialidade, $valor, $fk_plano_saude) {

        try {
            $sql = "INSERT INTO tb_especialidade (id_especialidade, nm_especialidade, vl_consulta, fk_plano_saude) VALUES (:id_especialidade, :nm_especialidade, :vl_consulta, :fk_plano_saude)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(':id_especialidade', $id, PDO::PARAM_INT);
            $stmt->bindParam(':nm_especialidade', $especialidade, PDO::PARAM_STR);
            $stmt->bindParam(':vl_consulta', $valor, PDO::PARAM_STR);
            $stmt->bindParam(':fk_plano_saude', $fk_plano_saude, PDO::PARAM_INT);

            $result = $stmt->execute();

            return $result;
        } catch(PDOException $e) {
            die('ERROR' . $e->getMessage());
        }
    }

    function deleteEspecialidade($id) {
        try {
            $sql = "DELETE FROM tb_especialidade WHERE id_especialidade = :id_especialidade";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam('id_especialidade', $id, PDO::PARAM_STR);
            $result = $stmt->execute();

            return $result;
        } catch(PDOException $e) {
            die('ERROR' . $e->getMessage());
        }
    }


}

