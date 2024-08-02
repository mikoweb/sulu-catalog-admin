<?php

namespace App\Module\Catalog\Application\Interaction\Command\CreateItem\Handler;

use App\Module\Catalog\Application\Interaction\Command\CreateItem\CreateItemCommand;
use App\Module\Catalog\Infrastructure\Persistence\Item\ItemPersistence;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Uid\Uuid;

readonly class CreateItemHandler
{
    public function __construct(
        private ItemPersistence $itemPersistence,
    ) {
    }

    #[AsMessageHandler(bus: 'command_bus')]
    public function handle(CreateItemCommand $command): Uuid
    {
        return $this->itemPersistence->create($command->item)->getId();
    }
}
