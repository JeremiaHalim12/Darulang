<?php

class UserDaoImpl
{
    public function userLogin($emailId, $passwordId) {
        $conn = PDOUtil::createConnection();
        $query = "SELECT * FROM user WHERE email = ? AND password = MD5(?)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1,$emailId);
        $stmt->bindParam(2,$passwordId);
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        $stmt->execute();
        return $stmt->fetchObject("User");
    }

    public function register(User $user) {
        $result = 0;
        $link = PDOUtil::createConnection();
        $query = 'INSERT INTO user (name,phone,email,password) VALUES(?,?,?,MD5(?))';
        $stmt = $link->prepare($query);
        $stmt->bindValue(1,$user->getName());
        $stmt->bindValue(2,$user->getPhone());
        $stmt->bindValue(3,$user->getEmail());
        $stmt->bindValue(4,$user->getPassword());
        $link->beginTransaction();
        if ($stmt->execute()) {
            $link->commit();
            $result = 1;
        } else {
            $link->rollBack();
        }
        $link = null;
        return $result;
    }

    public function fetchCurrentUser() {
        $conn = PDOUtil::createConnection();
        $query = "SELECT * FROM user WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1,$_SESSION['web_user_id']);
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        $stmt->execute();
        return $stmt->fetchObject("User");
    }
}