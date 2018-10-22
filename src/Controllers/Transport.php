<?php


namespace App\Controllers;

class Transport
{
   public $cart;

   public function isCartEmpty(){
      return empty($this->cart);
   }

   public function isCartValidJSON(){
         json_decode($this->cart);
         return (json_last_error() == JSON_ERROR_NONE);
   }
   public function convertCartToArray(){
         $this->cart = array(
                             "0" =>
                             (object) [
                               'id' => 1,
                               'name' => 'A green door',
                               'price' => 12.5,
                               'tags' => 'living plant',
                             ],
                             1 =>
                             (object)[
                               'id' => 1,
                               'name' => 'A green door',
                               'price' => 12.5,
                               'tags' => 'living plant',
                             ],
                           );
   }

}