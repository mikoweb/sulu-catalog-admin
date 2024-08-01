<?php

namespace App\Module\Catalog\UI\Admin\Dto;

use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

readonly class CategoryMoveDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Choice(['move'])]
        public string $action,

        #[Assert\NotBlank]
        #[Assert\Uuid]
        public Uuid $destination,
    ) {
    }
}
