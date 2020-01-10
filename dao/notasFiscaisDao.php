<?php

require_once DIR_CONEXAOBD . 'conexaoPDO.php';

class NotasfiscaisDao {

    private $conexaoBD;

    public function __construct() {
        $this->conexaoBD = ConexaoPDO::getInstance();
    }

    public function pesquisar($post) {
        $where = 'WHERE 1=1';

        if (isset($post['st_nome_empresa']) && !empty($post['st_nome_empresa'])) {
            $where .= ' AND st_nome_empresa LIKE "%' . $post['st_nome_empresa'] . '%"';
        }

        if (isset($post['st_cnpj']) && !empty($post['st_cnpj'])) {
            $where .= ' AND st_cnpj = "' . $post['st_cnpj'] . '"';
        }

        if (isset($post['st_situacao']) && !empty($post['st_situacao'])) {
            $where .= ' AND st_situacao = "' . $post['st_situacao'] . '"';
        }

        $sql = "SELECT id, nr_nota, st_nome_empresa, st_cnpj, vl_valor_total_nota, st_situacao FROM notas_fiscais " . $where . " ORDER BY st_situacao DESC";

        try {
            $statement = $this->conexaoBD->prepare($sql);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e);
        }
    }

    public function quantidadeItensNota($id) {

        $sql = "SELECT id FROM itens_notas WHERE nota_id = " . $id;

        try {
            $statement = $this->conexaoBD->prepare($sql);
            $statement->execute();
            return $statement->rowCount();
        } catch (PDOException $e) {
            throw new Exception($e);
        }
    }

    public function cadastrar($post) {
        $sql = "INSERT INTO notas_fiscais (nr_nota, st_nome_empresa, st_cnpj, vl_valor_total_nota, dt_compra, dt_emissao_nota,st_observacao) "
                . "VALUES (:nr_nota, :st_nome_empresa, :st_cnpj, :vl_valor_total_nota, :dt_compra, :dt_emissao_nota, :st_observacao)";

        try {
            $statement = $this->conexaoBD->prepare($sql);
            $statement->bindValue(':nr_nota', $post['nr_nota'], PDO::PARAM_INT);
            $statement->bindValue(':st_nome_empresa', $post['st_nome_empresa'], PDO::PARAM_STR);
            $statement->bindValue(':st_cnpj', $post['st_cnpj'], PDO::PARAM_STR);
            $statement->bindValue(':vl_valor_total_nota', $post['vl_valor_total_nota'], PDO::PARAM_STR);
            $statement->bindValue(':dt_compra', $post['dt_compra'], PDO::PARAM_STR);
            $statement->bindValue(':dt_emissao_nota', $post['dt_emissao_nota'], PDO::PARAM_STR);
            $statement->bindValue(':st_observacao', $post['st_observacao'], PDO::PARAM_STR);
            $statement->execute();

            return $this->conexaoBD->lastInsertId();
        } catch (PDOException $e) {
            throw new Exception($e);
        }
    }

    public function buscarNotaFiscal($id) {
        $sql = "SELECT id, nr_nota, st_nome_empresa, vl_valor_total_nota, st_cnpj, dt_compra, dt_emissao_nota, st_observacao, st_situacao FROM notas_fiscais WHERE id= " . $id;

        try {
            $statement = $this->conexaoBD->prepare($sql);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e);
        }
    }

    public function editar($post, $id) {
        $sql = "UPDATE notas_fiscais
                    SET
                        nr_nota = :nr_nota,
                        st_nome_empresa = :st_nome_empresa,
                        st_cnpj = :st_cnpj,
                        vl_valor_total_nota = :vl_valor_total_nota,
                        dt_compra = :dt_compra,
                        dt_emissao_nota = :dt_emissao_nota,
                        st_observacao = :st_observacao
                    WHERE id = :id";

        try {
            $statement = $this->conexaoBD->prepare($sql);
            $statement->bindValue(":nr_nota", $post['nr_nota'], PDO::PARAM_INT);
            $statement->bindValue(":st_nome_empresa", $post['st_nome_empresa'], PDO::PARAM_STR);
            $statement->bindValue(":st_cnpj", $post['st_cnpj'], PDO::PARAM_STR);
            $statement->bindValue(":vl_valor_total_nota", $post['vl_valor_total_nota'], PDO::PARAM_STR);
            $statement->bindValue(":dt_compra", $post['dt_compra'], PDO::PARAM_STR);
            $statement->bindValue(":dt_emissao_nota", $post['dt_emissao_nota'], PDO::PARAM_STR);
            $statement->bindValue(":st_observacao", $post['st_observacao'], PDO::PARAM_STR);
            $statement->bindValue(":id", $id, PDO::PARAM_INT);
            $statement->execute();

            return 1;
        } catch (PDOException $e) {
            throw new Exception($e);
        }
    }

    public function confirmarNotaFiscal($id, $situacaoNotaFiscal) {
        $sql = "UPDATE notas_fiscais SET st_situacao = :st_situacao WHERE id = :id";

        try {
            $statement = $this->conexaoBD->prepare($sql);
            $statement->bindValue(":st_situacao",$situacaoNotaFiscal,PDO::PARAM_STR);
            $statement->bindValue(":id",$id,PDO::PARAM_INT);
            $statement->execute();

            return 1;
        } catch (PDOException $e) {
            throw new Exception($e);
        }
    }

}

?>
