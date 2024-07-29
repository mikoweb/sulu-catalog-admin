<?php

namespace App\Module\Catalog\Infrastructure\Repository;

use App\Module\Catalog\Domain\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;

readonly class CategoryRepositoryService
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function getRepository(): CategoryRepository
    {
        return $this->entityManager->getRepository(Category::class);
    }
}
