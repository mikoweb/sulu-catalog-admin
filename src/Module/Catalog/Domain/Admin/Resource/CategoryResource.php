<?php

namespace App\Module\Catalog\Domain\Admin\Resource;

final class CategoryResource
{
    public const string RESOURCE_KEY = 'catalog_category';
    public const string SECURITY_GROUP = 'Catalog';
    public const string SECURITY_CONTEXT = 'sulu.catalog.category';

    public const string MENU_NAME = 'admin.catalog_category.menu_name';

    public const string VIEW_LIST_TITLE = 'admin.catalog_category.list_title';
    public const string VIEW_LIST_NAME = 'admin.catalog_category.list';
    public const string VIEW_LIST_PATH = '/catalog/categories';

    public const string EDIT_FORM_TEMPLATE = 'catalog_category_edit';
    public const string VIEW_EDIT_NAME = 'admin.catalog_category.edit';
    public const string VIEW_EDIT_PATH = '/catalog/categories/:id';
    public const string VIEW_EDIT_DETAILS_NAME = 'admin.catalog_category.edit.details';
    public const string VIEW_EDIT_DETAILS_PATH = '/details';

    public const string ADD_FORM_TEMPLATE = 'catalog_category_add';
    public const string VIEW_ADD_NAME = 'admin.catalog_category.add';
    public const string VIEW_ADD_PATH = '/catalog/categories/new/category';
    public const string VIEW_ADD_DETAILS_NAME = 'admin.catalog_category.add.details';
    public const string VIEW_ADD_DETAILS_PATH = '/details';
}
