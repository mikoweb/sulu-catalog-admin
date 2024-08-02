<?php

namespace App\Module\Catalog\Infrastructure\Persistence\Item;

use App\Core\Application\Exception\NotFoundException;
use App\Module\Catalog\Domain\Entity\Item;
use App\Module\Catalog\Infrastructure\Persistence\Item\Converter\DtoToEntityConverter;
use App\Module\Catalog\Infrastructure\Repository\ItemRepository;
use App\Module\Catalog\UI\Admin\Dto\ItemCreateDto;
use App\Module\Catalog\UI\Admin\Dto\ItemUpdateDto;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;

readonly class ItemPersistence
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ItemRepository $repository,
        private DtoToEntityConverter $dtoToEntityConverter,
    ) {
    }

    public function create(ItemCreateDto $dto): Item
    {
        $item = $this->dtoToEntityConverter->convertCreateDto($dto);
        $this->entityManager->persist($item);

        return $item;
    }

    /**
     * @throws NotFoundException
     */
    public function update(Uuid $itemId, ItemUpdateDto $dto): Item
    {
        $item = $this->dtoToEntityConverter->convertUpdateDto($itemId, $dto);
        $this->entityManager->persist($item);

        return $item;
    }

    /**
     * @throws NotFoundException
     */
    public function delete(Uuid $itemId): void
    {
        $item = $this->repository->find($itemId);

        if (is_null($item)) {
            throw new NotFoundException(sprintf('Item with id `%s` does not exist.', $itemId));
        }

        $this->entityManager->remove($item);
    }
}
