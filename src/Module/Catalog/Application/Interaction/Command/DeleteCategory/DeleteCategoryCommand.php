<?php

namespace App\Module\Catalog\Application\Interaction\Command\DeleteCategory;

use App\Core\Infrastructure\Interaction\Command\CommandInterface;

readonly class DeleteCategoryCommand implements CommandInterface
{
    public function __construct(
        public string $categoryId,
    ) {
    }
}
