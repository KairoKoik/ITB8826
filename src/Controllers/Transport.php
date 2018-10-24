<?php
namespace App\Controllers;

class Transport
{
   public $cart;

   public function getTransportOptions(){

      $options = array();
      if($this->canCartBeTransportedWithCarrier()){
         $options["carrier"] = true;
      }
      if($this->canCartBeTransportedWithParcel()){
         $options["parcel"] = true;
      }

      return $options;
   }

   public function canCartBeTransportedWithCarrier(){


      if($this->isCartEmpty()){
         return false;
      }

      if(!$this->isCartValidJSON()){
         return false;
      }
      if($this->islivingPlantInCart()){
         return false;
      }


      return true;
   }

   public function canCartBeTransportedWithParcel(){

      if($this->isCartEmpty()){
         return false;
      }

      if(!$this->isCartValidJSON()){
         return false;
      }

      if(!$this->areAllItemsAllowedInParcel()){
         return false;
      }

      return true;
   }

   public function isCartEmpty(){
      return empty($this->cart);
   }

   public function isCartValidJSON(){
         json_decode($this->cart);
         return (json_last_error() == JSON_ERROR_NONE);
   }
   public function convertCartToArray(){
         return json_decode($this->cart);
   }
   public function islivingPlantInCart(){

      $cart_array = $this->convertCartToArray();
      $cartWithLivingPlant = false;
      foreach ($cart_array as $key => $item) {
         if($item->tags == "living plant"){
            $cartWithLivingPlant = true;
            break;
         }
      }

      return $cartWithLivingPlant;
   }

   public function areAllItemsAllowedInParcel(){

      $cart_array = $this->convertCartToArray();
      $allItemsCanBeTransportedWithParcel = true;
      foreach ($cart_array as $key => $item) {
         if($item->parcel == "0"){
            $allItemsCanBeTransportedWithParcel = false;
            break;
         }
      }

      return $allItemsCanBeTransportedWithParcel;
   }

}