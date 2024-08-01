<?php

namespace App\Module\Catalog\UI\Admin\Dto;

use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

readonly class CategoryCreateDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        public string $name,

        #[Assert\Length(max: 255)]
        public ?string $slug,
        public ?string $description,

        #[Assert\NotBlank]
        #[Assert\Uuid]
        public Uuid $parentId,
    ) {
    }
}
