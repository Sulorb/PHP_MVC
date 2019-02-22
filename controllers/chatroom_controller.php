<?php
require_once '../models/Chatroom.class.php';
//demarrage session
session_start();

// try/catch pour lever les erreurs de connexion
try {
    $action = isset($_GET['action']) ? $_GET['action'] : '';

    $chatroom = new Chatroom();

    switch ($action) {
        case 'create':
            $result = $chatroom->create($_GET['name']);
            echo json_encode($result);
            break;

        case 'modify':
            $result = $chatroom->modify($_GET['id'], $_GET['newName']);
            echo json_encode($result);
            break;

        case 'delete':
            $result = $chatroom->delete($_GET['id']);
            echo json_encode($result);
            break;

        case 'addMessage':
            $result = $chatroom->addMessage($_GET['userId'], $_GET['chatroomId'], $_GET['content']);
            echo json_encode($result);
            break;

        case 'getChatrooms':
            $result = $chatroom->getChatrooms();
            echo json_encode($result);
            break;

        case 'getMessagesOfUser':
            $result = $chatroom->getMessagesOfUser($_GET['userId']);
            echo json_encode($result);
            break;

        case 'getMessagesOfChatroom':
            $result = $chatroom->getMessagesOfChatroom($_GET['chatroomId']);
            echo json_encode($result);
            break;

        case 'getChatroomsOfUser':
            $result = $chatroom->getChatroomsOfUser($_GET['userId']);
            echo json_encode($result);
            break;

        default:
            echo json_encode('fail mamene');
            break;
    }
} catch (Exception $e) {
    echo ('cacaboudin exception');
    print_r($e);
}
