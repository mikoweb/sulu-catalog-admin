<?php

namespace App\Module\Catalog\Application\Interaction\Command\MoveCategory\Handler;

use App\Core\Application\Exception\NotFoundException;
use App\Module\Catalog\Application\Interaction\Command\MoveCategory\MoveCategoryCommand;
use App\Module\Catalog\Infrastructure\Persistence\Category\CategoryPersistence;
use App\Module\Catalog\Infrastructure\Repository\CategoryRepositoryService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

readonly class MoveCategoryHandler
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
    public function handle(MoveCategoryCommand $command): void
    {
        $this->categoryPersistence->move($command->categoryId, $command->destinationId);
        $this->entityManager->flush();
        $this->categoryRepositoryService->getRepository()->recover();
        $this->entityManager->flush();
    }
}
