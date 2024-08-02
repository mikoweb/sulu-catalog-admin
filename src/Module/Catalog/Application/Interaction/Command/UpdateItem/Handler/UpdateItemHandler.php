<?php

namespace App\Module\Catalog\Application\Interaction\Command\UpdateItem\Handler;

use App\Core\Application\Exception\NotFoundException;
use App\Module\Catalog\Application\Interaction\Command\UpdateItem\UpdateItemCommand;
use App\Module\Catalog\Infrastructure\Persistence\Item\ItemPersistence;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

readonly class UpdateItemHandler
{
    public function __construct(
        private ItemPersistence $itemPersistence,
    ) {
    }

    /**
     * @throws NotFoundException
     */
    #[AsMessageHandler(bus: 'command_bus')]
    public function handle(UpdateItemCommand $command): void
    {
        $this->itemPersistence->update($command->itemId, $command->item);
    }
}
