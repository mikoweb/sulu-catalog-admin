<?php

namespace App\Module\Catalog\Infrastructure\Persistence\Category\Converter;

use App\Module\Catalog\Domain\Entity\Category;
use App\Module\Catalog\UI\Admin\Dto\CategoryCreateDto;

readonly class CategoryCreateDtoToEntityConverter
{
    public function convertToEntity(CategoryCreateDto $dto): Category
    {
        $category = new Category($dto->name, $dto->description);

        if (!is_null($dto->slug)) {
            $category->setSlug($dto->slug);
        }

        return $category;
    }
}
