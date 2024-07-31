<?php

namespace App\Module\Catalog\Infrastructure\Persistence\Category\Converter;

use App\Module\Catalog\Domain\Entity\Category;
use App\Module\Catalog\Infrastructure\Repository\CategoryRepositoryService;
use App\Module\Catalog\UI\Admin\Dto\CategoryCreateDto;

readonly class CategoryCreateDtoToEntityConverter
{
    public function __construct(
        private CategoryRepositoryService $categoryRepositoryService,
    ) {
    }

    public function convertToEntity(CategoryCreateDto $dto): Category
    {
        $category = new Category($dto->name, $dto->description);
        $category->setParent($this->categoryRepositoryService->getRepository()->find($dto->parent));

        if (!is_null($dto->slug)) {
            $category->setSlug($dto->slug);
        }

        return $category;
    }
}
