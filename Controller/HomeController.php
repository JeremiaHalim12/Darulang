<?php

class HomeController
{
   public function __construct()
   {
   }


   public function index()
   {

      include_once './View/home-view.php';
   }
}
