<?php

namespace App\Module\Catalog\Infrastructure\Persistence\Item\Converter;

use App\Core\Application\Exception\NotFoundException;
use App\Module\Catalog\Domain\Entity\Item;
use App\Module\Catalog\Infrastructure\Repository\ItemRepository;
use App\Module\Catalog\UI\Admin\Dto\ItemCreateDto;
use App\Module\Catalog\UI\Admin\Dto\ItemUpdateDto;
use Symfony\Component\Uid\Uuid;

readonly class DtoToEntityConverter
{
    public function __construct(
        private ItemRepository $repository,
    ) {
    }

    public function convertCreateDto(ItemCreateDto $dto): Item
    {
        $item = new Item($dto->name);
        $item->setDescription($dto->description);

        if (!is_null($dto->slug)) {
            $item->setSlug($dto->slug);
        }

        return $item;
    }

    /**
     * @throws NotFoundException
     */
    public function convertUpdateDto(Uuid $itemId, ItemUpdateDto $dto): Item
    {
        $item = $this->repository->find($itemId);

        if (is_null($item)) {
            throw new NotFoundException(sprintf('Item with id `%s` does not exist.', $itemId));
        }

        $item
            ->setName($dto->name)
            ->setSlug($dto->slug)
            ->setDescription($dto->description)
        ;

        return $item;
    }
}
