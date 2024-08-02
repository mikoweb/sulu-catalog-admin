<?php

namespace App\Module\Catalog\UI\Admin;

use App\Module\Catalog\Domain\Admin\Resource\ItemResource;
use Sulu\Bundle\AdminBundle\Admin\Admin;
use Sulu\Bundle\AdminBundle\Admin\View\FormViewBuilder;
use Sulu\Bundle\AdminBundle\Admin\View\ListViewBuilderInterface;
use Sulu\Bundle\AdminBundle\Admin\View\ResourceTabViewBuilderInterface;
use Sulu\Bundle\AdminBundle\Admin\View\ToolbarAction;
use Sulu\Bundle\AdminBundle\Admin\View\ViewBuilderFactoryInterface;
use Sulu\Bundle\AdminBundle\Admin\View\ViewCollection;
use Sulu\Bundle\AdminBundle\Admin\View\ViewBuilderInterface;
use Sulu\Component\Security\Authorization\PermissionTypes;
use Sulu\Component\Security\Authorization\SecurityCheckerInterface;

class ItemAdmin extends Admin
{
    public function __construct(
        private readonly ViewBuilderFactoryInterface $viewBuilderFactory,
        private readonly SecurityCheckerInterface $securityChecker,
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
        $view = $this->viewBuilderFactory->createListViewBuilder(
            ItemResource::VIEW_LIST_NAME,
            ItemResource::VIEW_LIST_PATH
        )
            ->setResourceKey(ItemResource::RESOURCE_KEY)
            ->setListKey(ItemResource::RESOURCE_KEY)
            ->addListAdapters(['table'])
            ->setTitle(ItemResource::VIEW_LIST_TITLE);

        if ($this->hasPermission(PermissionTypes::ADD)) {
            $view->setAddView(ItemResource::VIEW_ADD_NAME);
            $view->addToolbarActions([new ToolbarAction('sulu_admin.add')]);
        }

        if ($this->hasPermission(PermissionTypes::DELETE)) {
            $view->addToolbarActions([new ToolbarAction('sulu_admin.delete')]);
        }

        if ($this->hasPermission(PermissionTypes::EDIT)) {
            $view->setEditView(ItemResource::VIEW_EDIT_NAME);
        }

        return $view;
    }

    private function createEditTabView(): ResourceTabViewBuilderInterface
    {
        return $this->viewBuilderFactory->createResourceTabViewBuilder(
            ItemResource::VIEW_EDIT_NAME,
            ItemResource::VIEW_EDIT_PATH
        )
            ->setResourceKey(ItemResource::RESOURCE_KEY)
            ->setBackView(ItemResource::VIEW_LIST_NAME);
    }

    private function createEditFormView(): ViewBuilderInterface
    {
        /** @var FormViewBuilder $view */
        $view = $this->viewBuilderFactory->createFormViewBuilder(
            ItemResource::VIEW_EDIT_DETAILS_NAME,
            ItemResource::VIEW_EDIT_DETAILS_PATH,
        )
            ->setResourceKey(ItemResource::RESOURCE_KEY)
            ->setFormKey(ItemResource::EDIT_FORM_TEMPLATE)
            ->setTabTitle('sulu_admin.details')
            ->setParent(ItemResource::VIEW_EDIT_NAME);

        if ($this->hasPermission(PermissionTypes::EDIT)) {
            $view->addToolbarActions([new ToolbarAction('sulu_admin.save')]);
        }

        if ($this->hasPermission(PermissionTypes::DELETE)) {
            $view->addToolbarActions([new ToolbarAction('sulu_admin.delete')]);
        }

        return $view;
    }

    private function createAddTabView(): ResourceTabViewBuilderInterface
    {
        return $this->viewBuilderFactory->createResourceTabViewBuilder(
            ItemResource::VIEW_ADD_NAME,
            ItemResource::VIEW_ADD_PATH
        )
            ->setResourceKey(ItemResource::RESOURCE_KEY)
            ->setBackView(ItemResource::VIEW_LIST_NAME);
    }

    private function createAddFormView(): ViewBuilderInterface
    {
        /** @var FormViewBuilder $view */
        $view = $this->viewBuilderFactory->createFormViewBuilder(
            ItemResource::VIEW_ADD_DETAILS_NAME,
            ItemResource::VIEW_ADD_DETAILS_PATH,
        )
            ->setResourceKey(ItemResource::RESOURCE_KEY)
            ->setFormKey(ItemResource::ADD_FORM_TEMPLATE)
            ->setTabTitle('sulu_admin.details')
            ->setParent(ItemResource::VIEW_ADD_NAME);

        if ($this->hasPermission(PermissionTypes::ADD)) {
            $view->addToolbarActions([new ToolbarAction('sulu_admin.save')]);
        }

        if ($this->hasPermission(PermissionTypes::EDIT)) {
            $view->setEditView(ItemResource::VIEW_EDIT_DETAILS_NAME);
        }

        if ($this->hasPermission(PermissionTypes::DELETE)) {
            $view->addToolbarActions([new ToolbarAction('sulu_admin.delete')]);
        }

        return $view;
    }

    private function hasPermission(string $permission): bool
    {
        return $this->securityChecker->hasPermission(ItemResource::SECURITY_CONTEXT, $permission);
    }

    public function getSecurityContexts(): array
    {
        return [
            self::SULU_ADMIN_SECURITY_SYSTEM => [
                ItemResource::SECURITY_GROUP => [
                    ItemResource::SECURITY_CONTEXT => [
                        PermissionTypes::VIEW,
                        PermissionTypes::ADD,
                        PermissionTypes::EDIT,
                        PermissionTypes::DELETE,
                    ],
                ],
            ],
        ];
    }
}
