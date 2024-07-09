<?php

class OrderDaoImpl
{
    public function createOrder(Order $order)
    {
        $link = PDOUtil::createConnection();
        $query = "INSERT INTO darulang_product.order(time, location, user_id) VALUES (?, ? , ?)";
        $stmt = $link->prepare($query);
        $stmt->bindValue(1, $order->getTime());
        $stmt->bindValue(2, $order->getLocation());
        $stmt->bindValue(3, $order->getUser()->getId());
        $link->beginTransaction();
        if ($stmt->execute()) {
            $id = $link->lastInsertId();
            $link->commit();
        } else {
            $link->rollBack();
        }
        $link = PDOUtil::closeConnection($link);
        return $id;
    }

    public function processOrder(Order $order, CartItem $item)
    {
        $result = false;
        $link = PDOUtil::createConnection();
        $query = "INSERT INTO order_has_product(order_id, product_id, amount) VALUES (?, ? , ?)";
        $stmt = $link->prepare($query);
        $stmt->bindValue(1, $order->getId());
        $stmt->bindValue(2, $item->getProduct()->getId());
        $stmt->bindValue(3, $item->getAmount());
        $link->beginTransaction();
        if ($stmt->execute()) {
            $link->commit();
            $result = true;
        } else {
            $link->rollBack();
        }
        $link = PDOUtil::closeConnection($link);
        return $result;
    }

    public function fetchAll()
    {
        $link = PDOUtil::createConnection();
        $query = "SELECT user.id AS user_id, darulang_product.order.id, name, time, location FROM darulang_product.order JOIN user ON darulang_product.order.user_id = user.id";
        $stmt = $link->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Order");
        $stmt->execute();
        $link = PDOUtil::closeConnection($link);
        return $stmt->fetchAll();
    }

    public function fetchUserOrder()
    {
        $link = PDOUtil::createConnection();
        $query = "SELECT * FROM darulang_product.order  WHERE user_id = ?";
        //        $query = "SELECT * FROM order JOIN order_has_product ON order.id = order_has_product.order_id JOIN product ON order_has_product.product_id = product.id WHERE user_id = ?";
        $stmt = $link->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Order");
        $stmt->bindParam(1, $_SESSION['web_user_id']);
        $stmt->execute();
        $link = PDOUtil::closeConnection($link);
        return $stmt->fetchAll();
    }

    public function fetchProductOrder($user_id, $id)
    {
        $link = PDOUtil::createConnection();
        $query = "SELECT product_id AS id, amount, name, price FROM darulang_product.order JOIN order_has_product ON darulang_product.order.id = order_has_product.order_id JOIN product ON order_has_product.product_id = product.id WHERE user_id = ? AND order_id = ?";
        $stmt = $link->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Product");
        $stmt->bindParam(1, $user_id);
        $stmt->bindParam(2, $id);
        $stmt->execute();
        $link = PDOUtil::closeConnection($link);
        return $stmt->fetchAll();
    }

    public function fetchCountOrder()
    {
        $link = PDOUtil::createConnection();
        $query = "SELECT COUNT(time) AS count, time FROM darulang_product.order GROUP BY time";
        $stmt = $link->prepare($query);
        $stmt->execute();
        $link = PDOUtil::closeConnection($link);
        return $stmt->fetchAll();
    }

    public function fetchTotalUsers()
    {
        $link = PDOUtil::createConnection();
        $query = "SELECT COUNT(id) AS count FROM user WHERE role != 'Admin'";
        $stmt = $link->prepare($query);
        $stmt->execute();
        $link = PDOUtil::closeConnection($link);
        return $stmt->fetchAll();
    }

    public function fetchTotalOrders()
    {
        $link = PDOUtil::createConnection();
        $query = "SELECT COUNT(*) AS count FROM darulang_product.order";
        $stmt = $link->prepare($query);
        $stmt->execute();
        $link = PDOUtil::closeConnection($link);
        return $stmt->fetchAll();
    }
}
