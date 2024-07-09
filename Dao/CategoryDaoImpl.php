<?php

class CategoryDaoImpl
{
    public function fetchAllCategory() 
    {
        $link = PDOUtil::createConnection();
        $query = "SELECT * FROM category";
        $stmt = $link->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Category");
        $stmt->execute();
        $link = PDOUtil::closeConnection($link);
        return $stmt->fetchAll();
    }

    public function fetchCategoryById($id)
    {
        $link = PDOUtil::createConnection();
        $query = "SELECT * FROM category WHERE id = ?";
        $stmt = $link->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $link = PDOUtil::closeConnection($link);
        return $stmt->fetchObject('Category');
    }

    public function createCategory(Category $category)
    {
        $result = false;
        $link = PDOUtil::createConnection();
        $query = "INSERT INTO category(name) VALUES (?)";
        $stmt = $link->prepare($query);
        $stmt->bindValue(1, $category->getName());
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