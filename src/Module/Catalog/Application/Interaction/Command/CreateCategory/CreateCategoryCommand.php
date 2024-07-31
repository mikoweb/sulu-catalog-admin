<?php

namespace App\Module\Catalog\Application\Interaction\Command\CreateCategory;

use App\Core\Infrastructure\Interaction\Command\CommandInterface;
use App\Module\Catalog\UI\Admin\Dto\CategoryCreateDto;

readonly class CreateCategoryCommand implements CommandInterface
{
    public function __construct(
        public CategoryCreateDto $category,
    ) {
    }
}
