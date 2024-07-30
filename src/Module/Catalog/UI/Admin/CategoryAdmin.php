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
        $viewCollection->add($this->createEditFormView());
        $viewCollection->add($this->createAddTabView());
        $viewCollection->add($this->createAddFormView());
    }

    private function createListView(): ListViewBuilderInterface
    {
        return $this->viewBuilderFactory->createListViewBuilder(
            CategoryResource::VIEW_LIST_NAME,
            CategoryResource::VIEW_LIST_PATH
        )
            ->setResourceKey(CategoryResource::RESOURCE_KEY)
            ->setListKey(CategoryResource::RESOURCE_KEY)
            ->addListAdapters(['table'])
            ->addToolbarActions([
                new ToolbarAction('sulu_admin.add'),
                new ToolbarAction('sulu_admin.delete'),
                new ToolbarAction('sulu_admin.move'),
            ])
            ->setAddView(CategoryResource::VIEW_ADD_NAME)
            ->setEditView(CategoryResource::VIEW_EDIT_NAME)
            ->setTitle(CategoryResource::VIEW_LIST_TITLE);
    }

    private function createEditTabView(): ResourceTabViewBuilderInterface
    {
        return $this->viewBuilderFactory->createResourceTabViewBuilder(
            CategoryResource::VIEW_EDIT_NAME,
            CategoryResource::VIEW_EDIT_PATH
        )
            ->setResourceKey(CategoryResource::RESOURCE_KEY)
            ->setBackView(CategoryResource::VIEW_LIST_NAME);
    }

    private function createEditFormView(): ViewBuilderInterface
    {
        return $this->viewBuilderFactory->createFormViewBuilder(
            CategoryResource::VIEW_EDIT_DETAILS_NAME,
            CategoryResource::VIEW_EDIT_DETAILS_PATH,
        )
            ->setResourceKey(CategoryResource::RESOURCE_KEY)
            ->setFormKey(CategoryResource::EDIT_FORM_TEMPLATE)
            ->setTabTitle('sulu_admin.details')
            ->addToolbarActions([
                new ToolbarAction('sulu_admin.save'),
                new ToolbarAction('sulu_admin.delete'),
            ])
            ->setParent(CategoryResource::VIEW_EDIT_NAME);
    }

    private function createAddTabView(): ResourceTabViewBuilderInterface
    {
        return $this->viewBuilderFactory->createResourceTabViewBuilder(
            CategoryResource::VIEW_ADD_NAME,
            CategoryResource::VIEW_ADD_PATH
        )
            ->setResourceKey(CategoryResource::RESOURCE_KEY)
            ->setBackView(CategoryResource::VIEW_LIST_NAME);
    }

    private function createAddFormView(): ViewBuilderInterface
    {
        return $this->viewBuilderFactory->createFormViewBuilder(
            CategoryResource::VIEW_ADD_DETAILS_NAME,
            CategoryResource::VIEW_ADD_DETAILS_PATH,
        )
            ->setResourceKey(CategoryResource::RESOURCE_KEY)
            ->setFormKey(CategoryResource::ADD_FORM_TEMPLATE)
            ->setTabTitle('sulu_admin.details')
            ->setEditView(CategoryResource::VIEW_EDIT_DETAILS_NAME)
            ->addToolbarActions([
                new ToolbarAction('sulu_admin.save'),
                new ToolbarAction('sulu_admin.delete'),
            ])
            ->setParent(CategoryResource::VIEW_ADD_NAME);
    }
}
