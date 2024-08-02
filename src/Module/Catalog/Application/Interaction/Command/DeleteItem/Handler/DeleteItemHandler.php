<?php

namespace App\Module\Catalog\Application\Interaction\Command\DeleteItem\Handler;

use App\Core\Application\Exception\NotFoundException;
use App\Module\Catalog\Application\Interaction\Command\DeleteItem\DeleteItemCommand;
use App\Module\Catalog\Infrastructure\Persistence\Item\ItemPersistence;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

readonly class DeleteItemHandler
{
    public function __construct(
        private ItemPersistence $itemPersistence,
    ) {
    }

    /**
     * @throws NotFoundException
     */
    #[AsMessageHandler(bus: 'command_bus')]
    public function handle(DeleteItemCommand $command): void
    {
        $this->itemPersistence->delete($command->itemId);
    }
}
