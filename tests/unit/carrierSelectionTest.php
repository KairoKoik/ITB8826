<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class carrierSelectionTest extends TestCase
{

   protected $transport;
   public function setUp()
   {
      $this->transport = new \App\Controllers\Transport;
   }

   public function testIsCartEmpty (): void
   {
      $this->assertTrue($this->transport->isCartEmpty());
   }

   public function testIsCartNotValidJSON (): void
   {

      $this->transport->cart = '[{
                             "id": 1,
                             "name": "A green door",
                              price: 12.5,
                             "tags":"living plant",
                          }]';

      $this->assertFalse($this->transport->isCartValidJSON());
   }

    public function testconvertCartToArray (): void
   {
      $test_data = '[{
                             "id": 1,
                             "name": "A green door",
                             "price": 12.5,
                             "tags":"living plant"
                          },
                          {
                             "id": 1,
                             "name": "A green door",
                             "price": 12.5,
                             "tags":"living plant"
                           }]';


      $this->transport->cart = $test_data;
      $result= $this->transport->convertCartToArray();
      $this->assertEquals($result,json_decode($test_data));
   }

   public function testLivingPlantInCart (): void
   {

      $this->transport->cart = '[{
                             "id": 1,
                             "name": "A green door",
                             "price": 12.5,
                             "tags":"living plant"
                          },
                          {
                                "id": 1,
                                "name": "A green door",
                                "price": 12.5,
                                "tags":"living plant"
                           }]';

      $this->assertTrue($this->transport->islivingPlantInCart());
   }

   public function testNoLivingPlantInCart  (): void
   {

      $this->transport->cart = '[{
                             "id": 1,
                             "name": "A green door",
                             "price": 12.5,
                             "tags":"tools"
                          },
                           {
                             "id": 1,
                             "name": "A green door",
                             "price": 12.5,
                             "tags":"seeds"
                          }]';

      $this->assertFalse($this->transport->islivingPlantInCart());
   }
   public function testCanCartWithLivingPlantsBeTransportedWithCarrier(): void
   {

         $this->transport->cart = '[{
                                "id": 1,
                                "name": "A green door",
                                "price": 12.5,
                                "tags":"tools"
                             },{
                                "id": 1,
                                "name": "A green door",
                                "price": 12.5,
                                "tags":"living plant"
                             },
                              {
                                "id": 1,
                                "name": "A green door",
                                "price": 19.5,
                                "tags":"seeds"
                             }]';
         $this->assertFalse($this->transport->canCartBeTransportedWithCarrier());
  }

  public function testCanEmptyCartWithLivingPlantsBeTransportedWithCarrier(): void
  {
         $this->assertFalse($this->transport->canCartBeTransportedWithCarrier());
  }
  public function testCanNotValidJSONCartWithLivingPlantsBeTransportedWithCarrier(): void
  {

        $this->transport->cart = '[{
                             "id": 1,
                             "name": "A green door",
                              price: 12.5,
                             "tags":"living plant",
                          }]';
         $this->assertFalse($this->transport->canCartBeTransportedWithCarrier());
  }

  public function testCanCartWithoutLivingPlantsBeTransportedWithCarrier(): void
   {

         $this->transport->cart = '[{
                                "id": 1,
                                "name": "Hammer",
                                "price": 13.5,
                                "tags":"tools",
                                "parcel":"1"
                             },{
                                "id": 2,
                                "name": "Seeds A",
                                "price": 15.5,
                                "tags":"seeds",
                                "parcel":"0"
                             },
                              {
                                "id": 3,
                                "name": "Seed B",
                                "price": 17.5,
                                "tags":"seeds",
                                "parcel":"1"
                             }]';
         $this->assertTrue($this->transport->canCartBeTransportedWithCarrier());
   }

    public function testCanCartBeTransportedWithParcelNegative(): void
   {

         $this->transport->cart = '[{
                                "id": 1,
                                "name": "Hammer",
                                "price": 13.5,
                                "tags":"tools"
                                "parcel":"1"
                             },{
                                "id": 2,
                                "name": "Seeds A",
                                "price": 15.5,
                                "tags":"seeds",
                                "parcel":"0"
                             },
                              {
                                "id": 3,
                                "name": "Seed B",
                                "price": 17.5,
                                "tags":"seeds",
                                "parcel":"1"
                             }]';
         $this->assertFalse($this->transport->canCartBeTransportedWithParcel());
   }
  public function testCanCartBeTransportedWithParcel(): void
   {

         $this->transport->cart = '[{
                                "id": 1,
                                "name": "Hammer",
                                "price": 13.5,
                                "tags":"tools",
                                "parcel":"1"
                             },{
                                "id": 2,
                                "name": "Seeds A",
                                "price": 15.5,
                                "tags":"seeds",
                                "parcel":"1"
                             },
                              {
                                "id": 3,
                                "name": "Seed B",
                                "price": 17.5,
                                "tags":"seeds",
                                "parcel":"1"
                             }]';
         $this->assertTrue($this->transport->canCartBeTransportedWithParcel());
   }

   public function testCanEmptyCartBeTransportedWithParcel(): void
   {
         $this->assertFalse($this->transport->canCartBeTransportedWithParcel());
   }
   public function testCanNotValidJSONCartBeTransportedWithParcel(): void
   {

        $this->transport->cart = '[{
                             "id": 1,
                             "name": "A green door",
                              price: 12.5,
                             "tags":"living plant",
                          }]';
         $this->assertFalse($this->transport->canCartBeTransportedWithParcel());
   }


  public function testCanGetTransportOptionsCarrierOnly(): void
   {

         $this->transport->cart = '[{
                                "id": 1,
                                "name": "Hammer",
                                "price": 13.5,
                                "tags":"tools",
                                "parcel":"1"
                             },{
                                "id": 2,
                                "name": "Seeds A",
                                "price": 15.5,
                                "tags":"seeds",
                                "parcel":"0"
                             },
                              {
                                "id": 3,
                                "name": "Seed B",
                                "price": 17.5,
                                "tags":"seeds",
                                "parcel":"1"
                             }]';
         $this->assertEquals($this->transport->getTransportOptions(),array("carrier"=>true));
   }

  public function testCanGetTransportOptionsAll(): void
   {

         $this->transport->cart = '[{
                                "id": 1,
                                "name": "Hammer",
                                "price": 13.5,
                                "tags":"tools",
                                "parcel":"1"
                             },{
                                "id": 2,
                                "name": "Seeds A",
                                "price": 15.5,
                                "tags":"seeds",
                                "parcel":"1"
                             },
                              {
                                "id": 3,
                                "name": "Seed B",
                                "price": 17.5,
                                "tags":"seeds",
                                "parcel":"1"
                             }]';
         $this->assertEquals($this->transport->getTransportOptions(),array("carrier"=>true,"parcel"=>true));
   }



}

