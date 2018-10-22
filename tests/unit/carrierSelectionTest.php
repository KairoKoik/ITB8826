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

}

