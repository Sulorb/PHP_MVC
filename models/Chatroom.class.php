<?php
require_once '../classes/Connection.class.php';

class Chatroom
{
    public function create($name)
    {
        $dbh = Connection::get();
        $sql = "insert into chatroom (name) values (:name)";
        $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        if ($sth->execute(array(
            ':name' => $name,
        ))) {
            return true;
        }
        return false;
    }

    public function modify($id, $newName)
    {
        $dbh = Connection::get();
        $sql = "update chatroom set name = :name where id = :id";
        $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array(
            ':name' => $newName,
            ':id' => $id,
        ));
        return true;
    }

    public function delete($id)
    {
        $dbh = Connection::get();
        $sql = "delete from chatroom where id = :id";
        $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array(
            ':id' => $id,
        ));
        return true;
    }

    // TO DO : INSERT chatroomWROTE
    public function addMessage($userId, $chatroomId, $content)
    {
        $dbh = Connection::get();
        $sql = "insert into message (user_id, chatroom_id, content) values (:user_id, :chatroom_id, :content)";
        $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        if ($sth->execute(array(
            ':user_id' => $userId,
            ':chatroom_id' => $chatroomId,
            ':content' => $content,
        ))) {
            return true;
        }
        return false;
    }

    public function getChatrooms()
    {
        $dbh = Connection::get();
        $sql = "select * from chatroom";
        $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        if ($sth->execute()) {
            return $sth->fetchAll(PDO::FETCH_CLASS);
        }
        return false;
    }

    public function getMessagesOfUser($userId)
    {
        $dbh = Connection::get();
        $sql = "select * from message where user_id = :userId";
        $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        if ($sth->execute(array(
            ':userId' => $userId,
        ))) {
            return $sth->fetchAll(PDO::FETCH_CLASS);
        }
        return false;
    }

    public function getMessagesOfChatroom($chatroomId)
    {
        $dbh = Connection::get();
        $sql = "select * from message where chatroom_id = :chatroomId";
        $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        if ($sth->execute(array(
            ':chatroomId' => $chatroomId,
        ))) {
            return $sth->fetchAll(PDO::FETCH_CLASS);
        }
        return false;
    }

    // donne liste des chatrooms selon l'userId
    public function getChatroomsOfUser($userId)
    {
        $dbh = Connection::get();
        $sql = "select * from message where user_id = :userId group by chatroom_id";
        $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        if ($sth->execute(array(
            ':userId' => $userId,
        ))) {
            return $sth->fetchAll(PDO::FETCH_CLASS);
        }
        return false;
    }

}
