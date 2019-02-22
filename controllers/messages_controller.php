<?php
require_once('../config/db_config.php');
//demarrage session
session_start();

// try/catch pour lever les erreurs de connexion
try {
    // on se connecte avec les acces,  IL FAUT QUE LA BASE EXISTE POUR MANIPULER
    $dbh = new PDO(
        'mysql:host=' . $db_config['host'] . ':' . $db_config['port'] . ';dbname=' . $db_config['schema'] . ";charset=" . $db_config['charset'],
        $db_config['user'],
        $db_config['password']
    );
    // tableau d'erreurs initial, vide
    $errors = [];

    $action = isset($_GET['action']) ? $_GET['action'] : '';

    switch ($action){
         default;
            //requete qui doit retourner des resultats
            $stmt = $dbh->query("select * from messages");
            $messages = $stmt->fetchAll(PDO::FETCH_CLASS);
            $_SESSION['messages'] = $messages;
            header('Location: ../views/messages_list.php');
            break;
    }
} catch (Exception $e) {
    echo('cacaboudin exception');
    print_r($e);
}
?>