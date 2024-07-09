<?php

class Order
{
    private $id;
    private User $user;
    private string $time;
    private string $location;
    private array $product;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }



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
     * @return string
     */
    public function getTime(): string
    {
        return $this->time;
    }

    /**
     * @param string $time
     */
    public function setTime(string $time): void
    {
        $this->time = $time;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @param string $location
     */
    public function setLocation(string $location): void
    {
        $this->location = $location;
    }

    /**
     * @return array
     */
    public function getProduct(): array
    {
        return $this->product;
    }

    /**
     * @param array $product
     */
    public function setProduct(array $product): void
    {
        $this->product = $product;
    }

    public function __set($name, $value)
    {
        if (!isset($this->user)) {
            $this->user = new User();
        }
        switch ($name) {
            case 'user_id':
                $this->user->setId($value);
                break;
            case 'name':
                $this->user->setName($value);
                break;
            default:
                $this->$name = $value;
                break;
        }
    }
}
