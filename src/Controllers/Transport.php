<?php
namespace App\Controllers;

class Transport
{
   public $cart;
   public $maxParcelQuantity = 4;

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
      
      if(!$this->isItemCountLowerThenLimit()){
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
   
    public function isItemCountLowerThenLimit(){
      
      $count_total = 0;
      $checked = array();
      $cart_array = $this->convertCartToArray();
       
      foreach ($cart_array as $key => $item) {
         if(!in_array($item->id,$checked)){
            $count_total += $this->countItemAmountInCart($item->id);
            $checked{] = $item->id;
         }         
      }
      
       if($count_total <= $this->maxParcelQuantity){
          return true;
       } else {
         return false
       }
    }
       
    public function countItemAmountInCart($id){
      
      $itemsAmountIntCart = 0;
      $cart_array = $this->convertCartToArray();
       foreach ($cart_array as $key => $item) {
         if($item->id == $id){
            $itemsAmountIntCart++;
         }
      }
      
      
      return $itemsAmountIntCart;
   }

}
