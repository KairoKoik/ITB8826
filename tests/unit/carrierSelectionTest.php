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


}

