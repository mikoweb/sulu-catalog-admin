<?php

namespace App\Module\Catalog\Application\Interaction\Command\CreateCategory\Handler;

use App\Module\Catalog\Application\Interaction\Command\CreateCategory\CreateCategoryCommand;
use App\Module\Catalog\Infrastructure\Persistence\Category\CategoryPersistence;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Uid\Uuid;

readonly class CreateCategoryHandler
{
    public function __construct(
        private CategoryPersistence $categoryPersistence,
    ) {
    }

    #[AsMessageHandler(bus: 'command_bus')]
    public function handle(CreateCategoryCommand $command): Uuid
    {
        return $this->categoryPersistence->create($command->category)->getId();
    }
}
