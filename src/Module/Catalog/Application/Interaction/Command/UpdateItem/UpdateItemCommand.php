<?php

namespace App\Module\Catalog\Application\Interaction\Command\UpdateItem;

use App\Core\Infrastructure\Interaction\Command\CommandInterface;
use App\Module\Catalog\UI\Admin\Dto\ItemUpdateDto;
use Symfony\Component\Uid\Uuid;

readonly class UpdateItemCommand implements CommandInterface
{
    public function __construct(
        public Uuid $itemId,
        public ItemUpdateDto $item,
    ) {
    }
}
