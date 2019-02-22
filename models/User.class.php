<?php
require_once '../classes/Connection.class.php';

class User
{
    public $id;
    public $login;
    public $password;

    public $errors = [];

    public function __construct($id = null)
    {
        if (!is_null($id)) {
            $this->get($id);
        }
    }

    // ON RECUPERE UN SEUL USER
    // PAS BESOIN_____
    public function get($id = null)
    {
        if (!is_null($id)) {
            $dbh = Connection::get();
            //print_r($dbh);

            $stmt = $dbh->prepare("select * from users where id = :id limit 1");
            $stmt->execute(array(
                ':id' => $id
            ));
            // recupere les users et fout le resultat dans une variable sous forme de tableau de tableaux
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
            $user = $stmt->fetch();

            $this->id = $user->id;
            $this->login = $user->login;
            $this->password = $user->password;
        }
    }

    // VERIFIER L'INSCRIPTION
    public function validate($login, $password)
    {
        $this->errors = [];

        /* required fields */
        if (!isset($login)) {
            $this->errors[] = 'champ login vide';
        }
        if (!isset($password)) {
            $this->errors[] = 'champ password vide';
        }

        /* tests de formats */
        if (isset($login)) {
            if (empty($login)) {
                $this->errors[] = 'champ login vide';
                // si name > 50 chars
            } else if (mb_strlen($login) > 45) {
                $this->errors[] = 'champ login trop long (45max)';
            }
        }

        if (isset($password)) {
            if (empty($password)) {
                $this->errors[] = 'champ password vide';
                // si name > 50 chars
            } else if (mb_strlen($password) < 8) {
                $this->errors[] = 'champ password trop court (8 min)';
            } else if (mb_strlen($password) > 20) {
                $this->errors[] = 'champ password trop long (20 max)';
            }
        }

        if (count($this->errors) > 0) {
            return false;
        }
        return true;
    }

    // VERIFIER NOM USER EXISTANT
    private function loginExists($login = null)
    {
        if (!is_null($login)) {
            $dbh = Connection::get();
            $sql = "select count(id) from users where login = :login";
            $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $sth->execute(array(
                ':login' => $login
            ));
            if ($sth->fetchColumn() > 0) {
                $this->errors[] = 'login deja pris blaireau';
                return true;
            }
        }
        return false;
    }

    // RECUPERER TOUS LES USERS
    public function findAll()
    {
        $dbh = Connection::get();
        $stmt = $dbh->query("select * from users");
        // recupere les users et fout le resultat dans une variable sous forme de tableau de tableaux
        $users = $stmt->fetchAll(PDO::FETCH_CLASS);
        return $users;
    }

    // INSCRIPTION
    public function save($login, $password)
    {
        if ($this->validate($login, $password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            /* syntaxe avec preparedStatements */
            $dbh = Connection::get();
            $sql = "insert into users (login, password) values (:login, :password)";
            $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            if ($sth->execute(array(
                ':login' => $login,
                ':password' => $hashedPassword
            ))) {
                return true;
            } else {
                // ERROR
                // put errors in $session
                $this->errors['pas reussi a creer le user'];
            }
        }
        return false;
    }

    // TODO : VARIABLE SESSION
    // CONNEXION UTILISATEUR
    public function login($login, $password)
    {
        if ($this->validate($login, $password)) {
            $dbh = Connection::get();
            $sql = "select password from users where login = :login limit 1";
            $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $sth->execute(array(
                ':login' => $login
            ));
            $storedPassword = $sth->fetchColumn();
            if (password_verify($password, $storedPassword)) {
                return true;
            } else {
                // ERROR
                $this->errors[] = 'CASSE TOI !';
            }
        }
        return false;
    }

    public function modify($id, $newName)
    {
        $dbh = Connection::get();
        $sql = "update users set login = :login where id = :id";
        $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array(
            ':login' => $newName,
            ':id' => $id
        ));
        return true;
    }

    public function delete($id)
    {
        $dbh = Connection::get();
        $sql = "delete from users where id = :id";
        $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array(
            ':id' => $id
        ));
        return true;
    }

}
