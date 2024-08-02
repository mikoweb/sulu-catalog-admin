<?php

namespace App\Module\Catalog\UI\Admin\Dto;

use Symfony\Component\Validator\Constraints as Assert;

readonly class ItemUpdateDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        public string $name,

        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        public string $slug,
        public ?string $description,
    ) {
    }
}
