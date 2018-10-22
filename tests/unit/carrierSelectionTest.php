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
                             "tags":"living plant"
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
      $this->transport->convertCartToArray();
      $this->assertEquals($this->transport->cart,json_decode($test_data));
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

}

