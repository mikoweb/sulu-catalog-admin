<?php

namespace App\Shared\UI\Admin\Dto\Media;

readonly class MediaDto
{
    public function __construct(
        public ?int $id,
        public ?string $displayOption,
    ) {
    }
}
