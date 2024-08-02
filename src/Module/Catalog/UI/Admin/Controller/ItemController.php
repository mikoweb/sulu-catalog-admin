<?php

namespace App\Module\Catalog\UI\Admin\Controller;

use App\Core\Infrastructure\Bus\CommandBusInterface;
use App\Core\UI\Admin\Controller\AbstractAdminRestController;
use App\Module\Catalog\Application\Interaction\Command\CreateItem\CreateItemCommand;
use App\Module\Catalog\Application\Interaction\Command\DeleteItem\DeleteItemCommand;
use App\Module\Catalog\Application\Interaction\Command\UpdateItem\UpdateItemCommand;
use App\Module\Catalog\Domain\Admin\Resource\ItemResource;
use App\Module\Catalog\Domain\Entity\Item;
use App\Module\Catalog\Infrastructure\Repository\ItemRepository;
use App\Module\Catalog\UI\Admin\Dto\ItemCreateDto;
use App\Module\Catalog\UI\Admin\Dto\ItemUpdateDto;
use Sulu\Component\Rest\ListBuilder\Doctrine\DoctrineListBuilderFactoryInterface;
use Sulu\Component\Rest\ListBuilder\ListBuilderInterface;
use Sulu\Component\Rest\ListBuilder\Metadata\FieldDescriptorFactoryInterface;
use Sulu\Component\Rest\ListBuilder\PaginatedRepresentation;
use Sulu\Component\Rest\RestHelperInterface;
use Sulu\Component\Security\SecuredControllerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

class ItemController extends AbstractAdminRestController implements SecuredControllerInterface
{
    public function __construct(
        private readonly FieldDescriptorFactoryInterface $fieldDescriptorFactory,
        private readonly DoctrineListBuilderFactoryInterface $listBuilderFactory,
        private readonly RestHelperInterface $restHelper,
    ) {
    }

    public function getSecurityContext(): string
    {
        return ItemResource::SECURITY_CONTEXT;
    }

    public function index(): Response
    {
        $fieldDescriptors = $this->fieldDescriptorFactory->getFieldDescriptors(ItemResource::RESOURCE_KEY);
        $listBuilder = $this->listBuilderFactory
            ->create(Item::class)
            // @phpstan-ignore-next-line
            ->sort($fieldDescriptors['createdAt'], ListBuilderInterface::SORTORDER_DESC)
        ;

        // @phpstan-ignore-next-line
        $this->restHelper->initializeListBuilder($listBuilder, $fieldDescriptors);

        $listRepresentation = new PaginatedRepresentation(
            $listBuilder->execute() ?? [],
            ItemResource::RESOURCE_KEY,
            $listBuilder->getCurrentPage(),
            $listBuilder->getLimit() ?? 10,
            $listBuilder->count()
        );

        return $this->handleView($this->view($listRepresentation));
    }

    public function show(Item $item): Response
    {
        return $this->json($item, context: ['groups' => ['admin_read']]);
    }

    public function create(
        #[MapRequestPayload] ItemCreateDto $dto,
        CommandBusInterface $commandBus,
        ItemRepository $itemRepository,
    ): Response {
        $id = $commandBus->dispatch(new CreateItemCommand($dto));

        return $this->json(
            $itemRepository->find($id),
            context: ['groups' => ['admin_read']],
        );
    }

    public function update(
        Item $item,
        #[MapRequestPayload] ItemUpdateDto $dto,
        CommandBusInterface $commandBus,
        ItemRepository $itemRepository,
    ): Response {
        $commandBus->dispatch(new UpdateItemCommand($item->getId(), $dto));

        return $this->json(
            $itemRepository->find($item->getId()),
            context: ['groups' => ['admin_read']],
        );
    }

    public function delete(Item $item, CommandBusInterface $commandBus): Response
    {
        $commandBus->dispatch(new DeleteItemCommand($item->getId()));

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
