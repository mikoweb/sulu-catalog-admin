<?php

namespace App\Module\Catalog\Infrastructure\Persistence\Category;

use App\Core\Application\Exception\NotFoundException;
use App\Module\Catalog\Infrastructure\Repository\CategoryRepository;
use App\Module\Catalog\Infrastructure\Repository\CategoryRepositoryService;
use Doctrine\ORM\EntityManagerInterface;

readonly class CategoryPersistence
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private CategoryRepositoryService $categoryRepositoryService,
    ) {
    }

    /**
     * @throws NotFoundException
     */
    public function delete(string $categoryId): void
    {
        $category = $this->getRepository()->find($categoryId);

        if (is_null($category)) {
            throw new NotFoundException(sprintf('Category with id "%s" does not exist.', $categoryId));
        }

        $this->entityManager->remove($category);
    }

    private function getRepository(): CategoryRepository
    {
        return $this->categoryRepositoryService->getRepository();
    }
}
