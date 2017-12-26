<?php
/**
 * Responsável por gerar a conexão com o banco mysql
 * de acordo com o banco
 *
 */

class GetMysqlConnection
{

    private $banco = 'mysql';
    private $host = 'prosp.sistemagiv.com.br';
    private $user = 'danielf';
    private $senha = '5566TE11';

    protected function getDatabaseConnection ($databaseName) {

        try {

            return new PDO($this->banco.':host='.$this->host.';dbname='.$databaseName, $this->user, $this->senha);

        } catch (PDOException $e) {

            echo 'Erro ao conectar ao banco: '.$e->getMessage();

        }

    }

}