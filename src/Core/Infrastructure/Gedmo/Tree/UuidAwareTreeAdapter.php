<?php

namespace App\Core\Infrastructure\Gedmo\Tree;

use App\Core\Infrastructure\Doctrine\UuidAwareEntityManager;
use Gedmo\Mapping\Event\Adapter\ORM as BaseAdapterORM;
use Gedmo\Tree\Mapping\Event\TreeAdapter;

/**
 * @see https://github.com/doctrine-extensions/DoctrineExtensions/issues/2216#issuecomment-926767989
 */
class UuidAwareTreeAdapter extends BaseAdapterORM implements TreeAdapter
{
    public function getObjectManager(): UuidAwareEntityManager
    {
        return new UuidAwareEntityManager(parent::getObjectManager());
    }
}
