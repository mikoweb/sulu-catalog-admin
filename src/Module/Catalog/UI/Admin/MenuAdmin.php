<?php

namespace App\Module\Catalog\UI\Admin;

use App\Module\Catalog\Domain\Admin\Resource\CatalogResource;
use App\Module\Catalog\Domain\Admin\Resource\CategoryResource;
use Sulu\Bundle\AdminBundle\Admin\Admin;
use Sulu\Bundle\AdminBundle\Admin\Navigation\NavigationItem;
use Sulu\Bundle\AdminBundle\Admin\Navigation\NavigationItemCollection;

class MenuAdmin extends Admin
{
    public function configureNavigationItems(NavigationItemCollection $navigationItemCollection): void
    {
        $catalog = new NavigationItem(CatalogResource::ADMIN_MENU_NAME);
        $catalog->setIcon(CatalogResource::ADMIN_MENU_ICON);
        $catalog->setPosition(CatalogResource::ADMIN_MENU_POSITION);

        $navigationItemCollection->add($catalog);

        $category = new NavigationItem(CategoryResource::MENU_NAME);
        $category->setView(CategoryResource::VIEW_LIST_NAME);
        $catalog->addChild($category);
    }
}
