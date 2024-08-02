<?php

namespace App\Module\Catalog\Application\Interaction\Command\CreateItem;

use App\Core\Infrastructure\Interaction\Command\CommandInterface;
use App\Module\Catalog\UI\Admin\Dto\ItemCreateDto;

readonly class CreateItemCommand implements CommandInterface
{
    public function __construct(
        public ItemCreateDto $item,
    ) {
    }
}
