<?php

namespace App\Module\Catalog\Application\Interaction\Command\DeleteCategory;

use App\Core\Infrastructure\Interaction\Command\CommandInterface;
use Symfony\Component\Uid\Uuid;

readonly class DeleteCategoryCommand implements CommandInterface
{
    public function __construct(
        public Uuid $categoryId,
    ) {
    }
}
