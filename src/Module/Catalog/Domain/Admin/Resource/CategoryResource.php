<?php

namespace App\Module\Catalog\Domain\Admin\Resource;

final class CategoryResource
{
    public const string RESOURCE_KEY = 'catalog_category';
    public const string FORM_DETAILS_KEY = 'catalog_category_form_details';

    public const string ADMIN_MENU_NAME = 'admin.catalog_category.menu_name';
    public const int ADMIN_MENU_POSITION = 31;
    public const string ADMIN_MENU_ICON = 'su-folder';

    public const string ADMIN_VIEW_LIST_TITLE = 'admin.catalog_category.list_title';
    public const string ADMIN_VIEW_LIST_NAME = 'admin.catalog_category.list';
    public const string ADMIN_VIEW_LIST_PATH = '/catalog/category';

    public const string ADMIN_VIEW_DETAILS_NAME = 'admin.catalog_category.details';

    public const string ADMIN_VIEW_EDIT_NAME = 'admin.catalog_category.edit';
    public const string ADMIN_VIEW_EDIT_PATH = '/catalog/category/:id';
}
