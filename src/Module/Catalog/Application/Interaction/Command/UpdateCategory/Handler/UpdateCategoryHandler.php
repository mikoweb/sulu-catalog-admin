<?php

namespace App\Module\Catalog\Application\Interaction\Command\UpdateCategory\Handler;

use App\Core\Application\Exception\NotFoundException;
use App\Module\Catalog\Application\Interaction\Command\UpdateCategory\UpdateCategoryCommand;
use App\Module\Catalog\Infrastructure\Persistence\Category\CategoryPersistence;
use App\Module\Catalog\Infrastructure\Repository\CategoryRepositoryService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

readonly class UpdateCategoryHandler
{
    public function __construct(
        private CategoryPersistence $categoryPersistence,
        private CategoryRepositoryService $categoryRepositoryService,
        private EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @throws NotFoundException
     */
    #[AsMessageHandler(bus: 'command_bus')]
    public function handle(UpdateCategoryCommand $command): void
    {
        $this->categoryPersistence->update($command->categoryId, $command->category);
        $this->entityManager->flush();
        $this->categoryRepositoryService->getRepository()->recover();
        $this->entityManager->flush();
    }
}
