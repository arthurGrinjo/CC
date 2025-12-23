<?php

namespace App\Entity;

use App\Dto\ManagerDto;
use Symfony\Component\ObjectMapper\Attribute\Map;

#[Map(target: ManagerDto::class)]
class TestManager
{
    public string $name = '';
    public int $age = 0;
 }
