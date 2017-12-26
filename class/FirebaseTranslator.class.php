<?php
/* Classe responsável por comunicar com o
 * firebase atravpesd da bliblioteca
 * kreait/firebase-php
 *
 *  22/12/2017 - Feito em PHP 7.1.9
*/

namespace FirebaseTranslator;

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class FirebaseTranslator {

    //Comporta a conexão do firebase
    private $firebaseConnection;
    private $firebaseWayKey;

    //Inicializa a conexão com o firebase
    public function __construct($serviceAccount, $apiKey, $databaseLink) {

        $this->firebaseConnection = (new Factory)
            ->withServiceAccountAndApiKey($serviceAccount, $apiKey)
            ->withDatabaseUri($databaseLink)
            ->create();

        $this->firebaseConnection =
            $this->firebaseConnection->getDatabase();

    }

    //Seta o caminho que vai ser acessado dentro do banco do Firebase
    public function setWayKey ($wayKey) {

        return $this->firebaseWayKey =
            $this->firebaseConnection->
                getReference($wayKey);

    }

    public function remove () {

        $this->firebaseWayKey->remove();

    }

    //Substitui o valor de determinada chave
    public function set ($value) {

        $this->firebaseWayKey->set($value);

    }

    //Cria uma chave aleatória dentro do caminho e insere o valor
    public function push ($value) {

        $this->firebaseWayKey->push($value);

    }

    //Obtem o valor de determinado caminho do firebase
    public function getValue () {

        return $this->firebaseWayKey->getValue ();

    }


}