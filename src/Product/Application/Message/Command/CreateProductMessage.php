<?php

declare(strict_types=1);

namespace App\Product\Application\Message\Command;

use App\Product\Domain\Model\Product;

class CreateProductMessage
{
    public function __construct(public readonly Product $product)
    {
    }
}