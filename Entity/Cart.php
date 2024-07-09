<?php

class Cart
{
    private User $user;
    private array $itemCart;

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return array
     */
    public function getItemCart(): array
    {
        return $this->itemCart;
    }

    /**
     * @param array $itemCart
     */
    public function setItemCart(array $itemCart): void
    {
        $this->itemCart = $itemCart;
    }
}