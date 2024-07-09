<?php

class ProductDaoImpl
{
    public function fetchAllProduct()
    {
        $link = PDOUtil::createConnection();
        $query = "SELECT product.id AS id, product.name AS name, price, category_id, category.name AS category_name, stock, image FROM product JOIN category ON product.category_id = category.id WHERE stock > 0";
        $stmt = $link->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Product");
        $stmt->execute();
        $link = PDOUtil::closeConnection($link);
        return $stmt->fetchAll();
    }

    public function fetchAllProduct2()
    {
        $link = PDOUtil::createConnection();
        $query = "SELECT product.id AS id, product.name AS name, price, category_id, category.name AS category_name, stock, image FROM product JOIN category ON product.category_id = category.id";
        $stmt = $link->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Product");
        $stmt->execute();
        $link = PDOUtil::closeConnection($link);
        return $stmt->fetchAll();
    }

    public function fetchAllProductWithSearch($query)
    {
        $link = PDOUtil::createConnection();
        $query = "SELECT product.id AS id, product.name AS name, price, category_id, category.name AS category_name, stock, image FROM product JOIN category ON product.category_id = category.id WHERE product.name LIKE '%$query%' AND stock > 0";
        $stmt = $link->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Product");
        $stmt->execute();
        $link = PDOUtil::closeConnection($link);
        return $stmt->fetchAll();
    }

    public function fetchAllProductWithFilter($query)
    {
        $link = PDOUtil::createConnection();
        $query = "SELECT product.id AS id, product.name AS name, price, category_id, category.name AS category_name, stock, image FROM product JOIN category ON product.category_id = category.id WHERE category_id = $query AND stock > 0";
        $stmt = $link->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Product");
        $stmt->execute();
        $link = PDOUtil::closeConnection($link);
        return $stmt->fetchAll();
    }

    public function fetchAllProductWithSearchAndFilter($query, $filter)
    {
        $link = PDOUtil::createConnection();
        $query = "SELECT product.id AS id, product.name AS name, price, category_id, category.name AS category_name, stock, image FROM product JOIN category ON product.category_id = category.id WHERE category_id = $filter AND product.name LIKE '%$query%' AND stock > 0";
        $stmt = $link->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Product");
        $stmt->execute();
        $link = PDOUtil::closeConnection($link);
        return $stmt->fetchAll();
    }

    public function fetchProductById($id)
    {
        $link = PDOUtil::createConnection();
        $query = "SELECT product.id AS id, product.name AS name, price, stock, image, category_id, category.name AS category_name FROM product JOIN category ON product.category_id = category.id WHERE product.id = ?";
        $stmt = $link->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $link = PDOUtil::closeConnection($link);
        return $stmt->fetchObject('Product');
    }

    public function createProduct(Product $product)
    {
        $result = false;
        $link = PDOUtil::createConnection();
        $query = "INSERT INTO product(name, price, stock, image, category_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $link->prepare($query);
        $stmt->bindValue(1, $product->getName());
        $stmt->bindValue(2, $product->getPrice());
        $stmt->bindValue(3, $product->getStock());
        $stmt->bindValue(4, $product->getImage());
        $stmt->bindValue(5, $product->getCategory()->getId());
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

    public function updateProduct(Product $product)
    {
        $result = false;
        $link = PDOUtil::createConnection();
        $query = "UPDATE product SET name = ?, price = ?, stock = ?, image = ?, category_id = ? WHERE id = ?";
        $stmt = $link->prepare($query);
        $stmt->bindValue(1, $product->getName());
        $stmt->bindValue(2, $product->getPrice());
        $stmt->bindValue(3, $product->getStock());
        $stmt->bindValue(4, $product->getImage());
        $stmt->bindValue(5, $product->getCategory()->getId());
        $stmt->bindValue(6, $product->getId());
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

    public function deleteProduct($id)
    {
        $result = false;
        $link = PDOUtil::createConnection();
        $query = "DELETE FROM product WHERE id = ?";
        $stmt = $link->prepare($query);
        $stmt->bindParam(1, $id);
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
