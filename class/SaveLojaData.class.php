<?php


class SaveLojaData extends GetMysqlConnection
{

    private $contratante;
    private $databaseConnection;
    private $FirebaseTranslator;

    public function __construct($contratante, $databaseName,
                                 $FirebaseTranslator) {

        $this->contratante = $contratante;
        $this->databaseConnection = $this->getDatabaseConnection($databaseName);
        $this->FirebaseTranslator = $FirebaseTranslator;

    }

    public function setLojaInFirebase () {

        return $this->sendToFirebase ( $this->getLojaDados ());

    }

    private function getLojaDados () {

        $sql =
        '
        SELECT c.id_gcm, a.matriculaLoja, a.config
        FROM ipe_meta a
        JOIN tb_matricula b ON(a.matriculaLoja = b.matricula)
        JOIN tb_tipocadastro c ON(SUBSTR(b.documento,1,6) = c.matricula)
        WHERE c.matricula = :contratante AND NOW() BETWEEN a.vigencia_inicial AND a.vigencia_final

        ';

        $currentOperation = $this->databaseConnection->prepare($sql);

        $currentOperation->bindValue(':contratante', $this->contratante);

        $currentOperation->execute();

        return $currentOperation->fetch(PDO::FETCH_ASSOC);

    }

    private function sendToFirebase ($lojaDados) {

        return
            $this->FirebaseTranslator->setWayKey
            ($lojaDados['id_gcm'].'/loja/'.$lojaDados['matriculaLoja'].'/info/')
            ->set(json_decode($lojaDados['config']));

    }

}