<?php

class CartItem
{
    private Product $product;
    private int $amount;

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @param Product $Product
     */
    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    public function __set($name, $value)
    {
        if (!isset($this->product)) {
            $this->product = new Product();
        }
        switch ($name) {
            case 'product_id':
                $this->product->setId($value);
                break;
            case 'name':
                $this->product->setName($value);
                break;
            case 'price':
                $this->product->setPrice($value);
                break;
            case 'amount':
                $this->amount = $value;
                break;
            default:
                $this->$name = $value;
                break;
        }
    }
}
