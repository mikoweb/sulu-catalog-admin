<?php

namespace App\Module\Catalog\Application\Interaction\Command\DeleteItem;

use App\Core\Infrastructure\Interaction\Command\CommandInterface;
use Symfony\Component\Uid\Uuid;

readonly class DeleteItemCommand implements CommandInterface
{
    public function __construct(
        public Uuid $itemId,
    ) {
    }
}
