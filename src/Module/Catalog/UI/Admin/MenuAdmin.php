<?php

namespace App\Module\Catalog\UI\Admin;

use App\Module\Catalog\Domain\Admin\Resource\CatalogResource;
use App\Module\Catalog\Domain\Admin\Resource\CategoryResource;
use App\Module\Catalog\Domain\Admin\Resource\ItemResource;
use Sulu\Bundle\AdminBundle\Admin\Admin;
use Sulu\Bundle\AdminBundle\Admin\Navigation\NavigationItem;
use Sulu\Bundle\AdminBundle\Admin\Navigation\NavigationItemCollection;
use Sulu\Component\Security\Authorization\PermissionTypes;
use Sulu\Component\Security\Authorization\SecurityCheckerInterface;

class MenuAdmin extends Admin
{
    public function __construct(
        private readonly SecurityCheckerInterface $securityChecker,
    ) {
    }

    public function configureNavigationItems(NavigationItemCollection $navigationItemCollection): void
    {
        $catalog = new NavigationItem(CatalogResource::ADMIN_MENU_NAME);
        $catalog->setIcon(CatalogResource::ADMIN_MENU_ICON);
        $catalog->setPosition(CatalogResource::ADMIN_MENU_POSITION);

        $navigationItemCollection->add($catalog);

        if ($this->securityChecker->hasPermission(CategoryResource::SECURITY_CONTEXT, PermissionTypes::VIEW)) {
            $category = new NavigationItem(CategoryResource::MENU_NAME);
            $category->setView(CategoryResource::VIEW_LIST_NAME);
            $catalog->addChild($category);
        }

        if ($this->securityChecker->hasPermission(ItemResource::SECURITY_CONTEXT, PermissionTypes::VIEW)) {
            $item = new NavigationItem(ItemResource::MENU_NAME);
            $item->setView(ItemResource::VIEW_LIST_NAME);
            $catalog->addChild($item);
        }
    }
}
