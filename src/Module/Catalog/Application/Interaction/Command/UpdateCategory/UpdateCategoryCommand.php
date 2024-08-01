<?php

namespace App\Module\Catalog\Application\Interaction\Command\UpdateCategory;

use App\Core\Infrastructure\Interaction\Command\CommandInterface;
use App\Module\Catalog\UI\Admin\Dto\CategoryUpdateDto;
use Symfony\Component\Uid\Uuid;

readonly class UpdateCategoryCommand implements CommandInterface
{
    public function __construct(
        public Uuid $categoryId,
        public CategoryUpdateDto $category,
    ) {
    }
}
