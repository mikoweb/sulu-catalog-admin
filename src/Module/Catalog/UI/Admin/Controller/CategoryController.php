<?php

namespace App\Module\Catalog\UI\Admin\Controller;

use App\Core\UI\Admin\Controller\AbstractAdminRestController;
use App\Module\Catalog\Domain\Admin\Resource\CategoryResource;
use App\Module\Catalog\Domain\Entity\Category;
use App\Module\Catalog\Infrastructure\Repository\CategoryRepositoryService;
use Sulu\Component\Rest\ListBuilder\CollectionRepresentation;
use Sulu\Component\Rest\ListBuilder\Doctrine\DoctrineListBuilderFactoryInterface;
use Sulu\Component\Rest\ListBuilder\Metadata\FieldDescriptorFactoryInterface;
use Sulu\Component\Rest\RestHelperInterface;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends AbstractAdminRestController
{
    public function __construct(
        private readonly FieldDescriptorFactoryInterface $fieldDescriptorFactory,
        private readonly DoctrineListBuilderFactoryInterface $listBuilderFactory,
        private readonly RestHelperInterface $restHelper,
        private readonly CategoryRepositoryService $categoryRepositoryService,
    ) {
    }

    public function index(): Response
    {
        $fieldDescriptors = $this->fieldDescriptorFactory->getFieldDescriptors(CategoryResource::RESOURCE_KEY);
        $listBuilder = $this->listBuilderFactory
            ->create(Category::class)
            // @phpstan-ignore-next-line
            ->sort($fieldDescriptors['lft'])
        ;

        $listBuilder->where(
            // @phpstan-ignore-next-line
            $fieldDescriptors['root'],
            $this->categoryRepositoryService->getRepository()->findConnected()?->getId() ?? ''
        );

        // @phpstan-ignore-next-line
        $this->restHelper->initializeListBuilder($listBuilder, $fieldDescriptors);

        $listRepresentation = new CollectionRepresentation(
            $listBuilder->execute() ?? [],
            CategoryResource::RESOURCE_KEY,
        );

        return $this->handleView($this->view($listRepresentation));
    }

    public function show(Category $category): Response
    {
        return $this->handleView($this->view($category));
    }
}
