<?php

require_once __DIR__ . '\..\config\Database.php';

//Para linux:
//require_once(realpath(dirname(__FILE__) . '/..') .'/config/Database.php');


class PlanoSaude extends Database {
    private $id_plano_saude;
    private $nm_plano;

    function getIdPlanoSaude() {
        return $this->id_plano_saude;
    }
    
    function getNmPlanoSaude() {
        return $this->nm_plano;
    }
    
    function setIdPlanoSaude($id) {
        $this->id_plano_saude = $id;
    }
    
    function setNmPlanoSaude($plano_saude) {
        $this->nm_plano = $plano_saude;
    }
    
    function getPlanoSaude() {
        try {
            $sql = "SELECT * FROM tb_plano_saude";
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

    function setPlanoSaude($id, $nome) {

        try {
            $sql = "INSERT INTO tb_plano_saude (id_plano_saude, nm_plano) VALUES (:id_plano_saude, :nm_plano)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(':id_plano_saude', $id, PDO::PARAM_INT);
            $stmt->bindParam(':nm_plano', $nome, PDO::PARAM_STR);
            $result = $stmt->execute();

            return $result;
        } catch(PDOException $e) {
            die('ERROR' . $e->getMessage());
        }
    }

    function deletePlanoSaude($id) {
        try {
            $sql = "DELETE FROM tb_plano_saude WHERE id_plano_saude = :id_plano_saude";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam('id_plano_saude', $id, PDO::PARAM_STR);
            $result = $stmt->execute();

            return $result;
        } catch(PDOException $e) {
            die('ERROR' . $e->getMessage());
        }
    }

    function readContribuicaoValorConsulta($nm_especialidade, $id_categoria, $id_plano_saude) {
        $sql = "SELECT ((TPC.pc_participacao/100) * TE.vl_consulta) 
                FROM tb_especialidade TE, tb_plano_saude TPS, tb_plano_categoria TPC
                WHERE TE.nm_especialidade = :nm_especialidade
                AND :id_plano_saude = TE.fk_plano_saude
                AND TPC.id_categoria = :id_categoria
                AND :id_plano_saude = TPC.fk_plano";
        $stmt = $this->connect()->prepare($sql);

        $stmt->execute([
            ':nm_especialidade' => $nm_especialidade,
            ':id_categoria' => $id_categoria,
            ':id_plano_saude' => $id_plano_saude
        ]);

        return $stmt->fetchColumn();    
    }
}

