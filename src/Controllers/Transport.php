<?php


namespace App\Controllers;

class Transport
{
   public $cart;

   public function isCartEmpty(){
      return empty($this->cart);
   }


}