<?php

namespace App\Module\Catalog\UI\Admin;

use App\Module\Catalog\Domain\Admin\Resource\CategoryResource;
use Sulu\Bundle\AdminBundle\Admin\Admin;
use Sulu\Bundle\AdminBundle\Admin\View\ListViewBuilderInterface;
use Sulu\Bundle\AdminBundle\Admin\View\ResourceTabViewBuilderInterface;
use Sulu\Bundle\AdminBundle\Admin\View\ToolbarAction;
use Sulu\Bundle\AdminBundle\Admin\View\ViewBuilderFactoryInterface;
use Sulu\Bundle\AdminBundle\Admin\View\ViewCollection;
use Sulu\Bundle\AdminBundle\Admin\View\ViewBuilderInterface;

class CategoryAdmin extends Admin
{
    public function __construct(
        private readonly ViewBuilderFactoryInterface $viewBuilderFactory
    ) {
    }

    public function configureViews(ViewCollection $viewCollection): void
    {
        $viewCollection->add($this->createListView());
        $viewCollection->add($this->createEditTabView());
        $viewCollection->add($this->createDetailsFormView());
    }

    private function createListView(): ListViewBuilderInterface
    {
        return $this->viewBuilderFactory->createListViewBuilder(
            CategoryResource::ADMIN_VIEW_LIST_NAME,
            CategoryResource::ADMIN_VIEW_LIST_PATH
        )
            ->setResourceKey(CategoryResource::RESOURCE_KEY)
            ->setListKey(CategoryResource::RESOURCE_KEY)
            ->addListAdapters(['table'])
            ->addToolbarActions([
                new ToolbarAction('sulu_admin.add'),
                new ToolbarAction('sulu_admin.delete'),
                new ToolbarAction('sulu_admin.move'),
            ])
            ->setEditView(CategoryResource::ADMIN_VIEW_EDIT_NAME)
            ->setTitle(CategoryResource::ADMIN_VIEW_LIST_TITLE);
    }

    private function createEditTabView(): ResourceTabViewBuilderInterface
    {
        return $this->viewBuilderFactory->createResourceTabViewBuilder(
            CategoryResource::ADMIN_VIEW_EDIT_NAME,
            CategoryResource::ADMIN_VIEW_EDIT_PATH
        )
            ->setResourceKey(CategoryResource::RESOURCE_KEY)
            ->setBackView(CategoryResource::ADMIN_VIEW_LIST_NAME);
    }

    private function createDetailsFormView(): ViewBuilderInterface
    {
        return $this->viewBuilderFactory->createFormViewBuilder(
            CategoryResource::ADMIN_VIEW_DETAILS_NAME,
            '/details'
        )
            ->setResourceKey(CategoryResource::RESOURCE_KEY)
            ->setFormKey(CategoryResource::FORM_DETAILS_KEY)
            ->setTabTitle('sulu_admin.details')
            ->addToolbarActions([])
            ->setParent(CategoryResource::ADMIN_VIEW_EDIT_NAME);
    }
}
