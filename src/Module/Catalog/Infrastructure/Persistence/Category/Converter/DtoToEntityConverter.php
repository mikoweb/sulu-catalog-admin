<?php

namespace App\Module\Catalog\Infrastructure\Persistence\Category\Converter;

use App\Core\Application\Exception\NotFoundException;
use App\Module\Catalog\Domain\Entity\Category;
use App\Module\Catalog\Infrastructure\Repository\CategoryRepository;
use App\Module\Catalog\Infrastructure\Repository\CategoryRepositoryService;
use App\Module\Catalog\UI\Admin\Dto\CategoryCreateDto;
use App\Module\Catalog\UI\Admin\Dto\CategoryUpdateDto;
use Sulu\Bundle\MediaBundle\Entity\MediaRepositoryInterface;
use Symfony\Component\Uid\Uuid;

readonly class DtoToEntityConverter
{
    public function __construct(
        private CategoryRepositoryService $categoryRepositoryService,
        private MediaRepositoryInterface $mediaRepository,
    ) {
    }

    public function convertCreateDto(CategoryCreateDto $dto): Category
    {
        $category = new Category($dto->name, $dto->description);
        $category
            ->setParent($this->getRepository()->find($dto->parentId))
            ->setBanner(is_null($dto->banner?->id) ? null : $this->mediaRepository->find($dto->banner->id))
        ;

        if (!is_null($dto->slug)) {
            $category->setSlug($dto->slug);
        }

        return $category;
    }

    /**
     * @throws NotFoundException
     */
    public function convertUpdateDto(Uuid $categoryId, CategoryUpdateDto $dto): Category
    {
        $category = $this->getRepository()->find($categoryId);

        if (is_null($category)) {
            throw new NotFoundException(sprintf('Category with id `%s` does not exist.', $categoryId));
        }

        $category
            ->setName($dto->name)
            ->setSlug($dto->slug)
            ->setDescription($dto->description)
            ->setParent($this->getRepository()->find($dto->parentId))
            ->setBanner(is_null($dto->banner?->id) ? null : $this->mediaRepository->find($dto->banner->id))
            ->setLft($dto->lft)
        ;

        return $category;
    }

    private function getRepository(): CategoryRepository
    {
        return $this->categoryRepositoryService->getRepository();
    }
}
