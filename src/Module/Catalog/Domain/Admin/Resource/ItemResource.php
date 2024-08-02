<?php

namespace App\Module\Catalog\Domain\Admin\Resource;

final class ItemResource
{
    public const string RESOURCE_KEY = 'catalog_item';
    public const string SECURITY_GROUP = 'Catalog';
    public const string SECURITY_CONTEXT = 'sulu.catalog.item';

    public const string MENU_NAME = 'admin.catalog_item.menu_name';

    public const string VIEW_LIST_TITLE = 'admin.catalog_item.list_title';
    public const string VIEW_LIST_NAME = 'admin.catalog_item.list';
    public const string VIEW_LIST_PATH = '/catalog/items';

    public const string EDIT_FORM_TEMPLATE = 'catalog_item_edit';
    public const string VIEW_EDIT_NAME = 'admin.catalog_item.edit';
    public const string VIEW_EDIT_PATH = '/catalog/items/:id';
    public const string VIEW_EDIT_DETAILS_NAME = 'admin.catalog_item.edit.details';
    public const string VIEW_EDIT_DETAILS_PATH = '/details';

    public const string ADD_FORM_TEMPLATE = 'catalog_item_add';
    public const string VIEW_ADD_NAME = 'admin.catalog_item.add';
    public const string VIEW_ADD_PATH = '/catalog/items/new/item';
    public const string VIEW_ADD_DETAILS_NAME = 'admin.catalog_item.add.details';
    public const string VIEW_ADD_DETAILS_PATH = '/details';
}
