<?php

namespace App\Message;


final class GivePointsMessage
{
     public function __construct(
         public readonly int $points,
     ) {
     }

     public function getPoints(): int
     {
         return $this->points;
     }
}
