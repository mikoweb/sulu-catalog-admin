<?php

namespace App\Module\Catalog\Application\Interaction\Command\DeleteCategory\Handler;

use App\Core\Application\Exception\NotFoundException;
use App\Module\Catalog\Application\Interaction\Command\DeleteCategory\DeleteCategoryCommand;
use App\Module\Catalog\Infrastructure\Persistence\Category\CategoryPersistence;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

readonly class DeleteCategoryHandler
{
    public function __construct(
        private CategoryPersistence $categoryPersistence,
    ) {
    }

    /**
     * @throws NotFoundException
     */
    #[AsMessageHandler(bus: 'command_bus')]
    public function handle(DeleteCategoryCommand $command): void
    {
        $this->categoryPersistence->delete($command->categoryId);
    }
}
