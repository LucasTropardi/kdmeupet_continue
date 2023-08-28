<?php

class Adocao {

    public static function buscaTodos($mysqli)
    {
        $query = "SELECT
                      a.*,
                      t.t_nome AS tipo,
                      r.r_nome AS raca,
                      tm.t_nometm AS tamanho,
                      c.c_cor AS cor
                  FROM
                      `cadastro_adocao` a
                  INNER JOIN `cadastro_tipo` t ON
                      a.p_tipo = t.t_id
                  INNER JOIN `cadastro_raca` r ON
                      a.p_raca = r.r_id AND t.t_id = r.r_tipos
                  INNER JOIN `cadastro_tamanho` tm ON
                      a.p_tamanho = tm.t_id
                  INNER JOIN `cadastro_cor` c ON
                      a.p_cor = c.c_id
                  ORDER BY
                      a.p_nome ASC";

        $sql = $mysqli->query($query) or die($mysqli->error);
        
        $animais = array();
        while ($row = $sql->fetch_array(MYSQLI_ASSOC)) {
            array_push($animais, $row);
        }
        return $animais;
    }

    public static function buscaTodosDisponiveis($mysqli)
    {
        $query = "SELECT
                      a.*,
                      t.t_nome AS tipo,
                      r.r_nome AS raca,
                      tm.t_nometm AS tamanho,
                      c.c_cor AS cor
                  FROM
                      `cadastro_adocao` a
                  INNER JOIN `cadastro_tipo` t ON
                      a.p_tipo = t.t_id
                  INNER JOIN `cadastro_raca` r ON
                      a.p_raca = r.r_id AND t.t_id = r.r_tipos
                  INNER JOIN `cadastro_tamanho` tm ON
                      a.p_tamanho = tm.t_id
                  INNER JOIN `cadastro_cor` c ON
                      a.p_cor = c.c_id
                  WHERE
                      a.p_status = 0
                  ORDER BY
                      a.p_nome ASC";

        $sql = $mysqli->query($query) or die($mysqli->error);
        
        $animais = array();
        while ($row = $sql->fetch_array(MYSQLI_ASSOC)) {
            array_push($animais, $row);
        }
        return $animais;
    }

    public static function buscaPorId($mysqli, $id)
    {
        $query = "SELECT
                      a.*,
                      t.t_nome AS tipo,
                      r.r_nome AS raca,
                      tm.t_nometm AS tamanho,
                      c.c_cor AS cor
                  FROM
                      `cadastro_adocao` a
                  INNER JOIN `cadastro_tipo` t ON
                      a.p_tipo = t.t_id
                  INNER JOIN `cadastro_raca` r ON
                      a.p_raca = r.r_id AND t.t_id = r.r_tipos
                  INNER JOIN `cadastro_tamanho` tm ON
                      a.p_tamanho = tm.t_id
                  INNER JOIN `cadastro_cor` c ON
                      a.p_cor = c.c_id
                  WHERE a.p_id = $id";

        $sql = $mysqli->query($query) or die($mysqli->error);

        $result = $sql->fetch_array(MYSQLI_ASSOC);
        if ($result) {
            return $result;
        }
        return false;
    }

    public static function buscaPorUsuario($mysqli, $id)
    {
        $query = "SELECT
                      a.*,
                      i.i_mensagem,
                      i.i_lida,
                      t.t_nome AS tipo,
                      r.r_nome AS raca,
                      tm.t_nometm AS tamanho,
                      c.c_cor AS cor
                  FROM
                      `cadastro_adocao_interesse` i
                  INNER JOIN `cadastro_adocao` a ON
                      i.i_adocao = a.p_id
                  INNER JOIN `cadastro_tipo` t ON
                      a.p_tipo = t.t_id
                  INNER JOIN `cadastro_raca` r ON
                      a.p_raca = r.r_id AND t.t_id = r.r_tipos
                  INNER JOIN `cadastro_tamanho` tm ON
                      a.p_tamanho = tm.t_id
                  INNER JOIN `cadastro_cor` c ON
                      a.p_cor = c.c_id
                  WHERE
                      i.i_usuario = $id
                  ORDER BY
                      a.p_status,
                      a.p_id DESC";

        $sql = $mysqli->query($query) or die($mysqli->error);
                
        $animais = array();
        while ($row = $sql->fetch_array(MYSQLI_ASSOC)) {
            array_push($animais, $row);
        }
        return $animais;
    }
}