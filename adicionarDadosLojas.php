<?php
require __DIR__.'/vendor/autoload.php';

require 'class/GetMysqlConnection.class.php';
require 'class/FirebaseTranslator.class.php';
require 'class/SaveLojaData.class.php';

use Kreait\Firebase\ServiceAccount;

if (!empty ($_REQUEST['contratante']) && !empty ($_REQUEST['databaseName'])) {

    //Seta os patâmetros vindos da requisição
    $contratante =
        addslashes($_REQUEST['contratante']);

    $databaseName =
        addslashes($_REQUEST['databaseName']);

    //Instancia c conexão com o firebase
    $FirebaseTranslator =
        new \FirebaseTranslator\FirebaseTranslator(

            ServiceAccount::fromJsonFile(__DIR__.'/google-service-account.json'),
            //Note que estes dois parametros seguintes são particulares do giv1 e pode um dia ser alterada
            '<AIzaSyD1b9wX2DjhnZbgsmfcsdfsfxESPrZmAt_CfRY>',
            'https://giv1-8e545.firebaseio.com/'

        );


    //Chama a classe que ira passar ao firebase os valores a serem salvos
    $SaveLojaData = new SaveLojaData ($contratante, $databaseName, $FirebaseTranslator);

    $SaveLojaData->setLojaInFirebase();

} else {

    echo 'Parâmetros passados são insuficientes.';

}