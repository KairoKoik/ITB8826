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
         $this->cart = json_decode($this->cart);
   }
   public function islivingPlantInCart(){

      $this->convertCartToArray();
      $cartWithLivingPlant = false;
      foreach ($this->cart as $key => $item) {
         if($item->tags == "living plant"){
            $cartWithLivingPlant = true;
            break;
         }
      }

      return $cartWithLivingPlant;
   }

}