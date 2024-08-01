<?php

namespace App\Module\Catalog\Application\Interaction\Command\MoveCategory;

use App\Core\Infrastructure\Interaction\Command\CommandInterface;
use Symfony\Component\Uid\Uuid;

readonly class MoveCategoryCommand implements CommandInterface
{
    public function __construct(
        public Uuid $categoryId,
        public Uuid $destinationId,
    ) {
    }
}
