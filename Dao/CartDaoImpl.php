<?php

class CartDaoImpl
{
    public function addCart(CartItem $item, Cart $cart)
    {
        $result = false;
        $link = PDOUtil::createConnection();
        $query = "INSERT INTO cart(product_id, user_id, amount) VALUES (?, ?, ?)";
        $stmt = $link->prepare($query);
        $stmt->bindValue(1, $item->getProduct()->getId());
        $stmt->bindValue(2, $cart->getUser()->getId());
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

    public function fetchUserCart($user_id)
    {
        $link = PDOUtil::createConnection();
        $query = "SELECT user_id, product_id, product.name AS name, product.price AS price, amount FROM cart JOIN product ON product.id = cart.product_id WHERE user_id = ?;";
        $stmt = $link->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Cartitem");
        $stmt->bindParam(1, $user_id);
        $stmt->execute();
        $link = PDOUtil::closeConnection($link);
        return $stmt->fetchAll();
    }

    public function updateCart(Cart $cart, CartItem $item)
    {
        $result = false;
        $link = PDOUtil::createConnection();
        $query = "UPDATE cart SET amount = ? WHERE user_id = ? AND product_id = ?";
        $stmt = $link->prepare($query);
        $stmt->bindValue(1, $item->getAmount());
        $stmt->bindValue(2, $cart->getUser()->getId());
        $stmt->bindValue(3, $item->getProduct()->getId());
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

    public function deleteCart(Cart $cart, $product_id)
    {
        $result = false;
        $link = PDOUtil::createConnection();
        $query = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
        $stmt = $link->prepare($query);
        $stmt->bindValue(1, $cart->getUser()->getId());
        $stmt->bindValue(2, $product_id);
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
}
