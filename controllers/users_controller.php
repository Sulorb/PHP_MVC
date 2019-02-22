<?php
require_once '../models/User.class.php';
//demarrage session
session_start();

// try/catch pour lever les erreurs de connexion
try {
    $action = isset($_GET['action']) ? $_GET['action'] : '';

    $user = new User();

    switch ($action) {

        case 'inscription':
            $users = $user->save($_GET['login'], $_GET['password']);
            echo json_encode($users);
            break;

        case 'connexion':
            $users = $user->login($_GET['login'], $_GET['password']);
            echo json_encode($users);
            break;

        case 'getUsers':
            $users = $user->findAll();
            echo json_encode($users);
            break;

        case 'modifyUser':
            $users = $user->modify($_GET['id'], $_GET['newName']);
            echo json_encode($users);
            break;

        case 'delete':
            $users = $user->delete($_GET['id']);
            echo json_encode($users);
            break;

        default:
            echo json_encode('fail mamene');
            break;
    }
} catch (Exception $e) {
    echo ('cacaboudin exception');
    print_r($e);
}
