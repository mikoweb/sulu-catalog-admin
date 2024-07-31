<?php

namespace App\Module\Catalog\Infrastructure\Persistence\Category;

use App\Core\Application\Exception\NotFoundException;
use App\Module\Catalog\Domain\Entity\Category;
use App\Module\Catalog\Infrastructure\Persistence\Category\Converter\CategoryCreateDtoToEntityConverter;
use App\Module\Catalog\Infrastructure\Repository\CategoryRepository;
use App\Module\Catalog\Infrastructure\Repository\CategoryRepositoryService;
use App\Module\Catalog\UI\Admin\Dto\CategoryCreateDto;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;

readonly class CategoryPersistence
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private CategoryRepositoryService $categoryRepositoryService,
        private CategoryCreateDtoToEntityConverter $createDtoToEntityConverter,
    ) {
    }

    public function create(CategoryCreateDto $dto): Category
    {
        $category = $this->createDtoToEntityConverter->convertToEntity($dto);
        $this->entityManager->persist($category);

        return $category;
    }

    /**
     * @throws NotFoundException
     */
    public function delete(Uuid $categoryId): void
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
