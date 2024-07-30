<?php

namespace App\Core\Infrastructure\Gedmo\Tree;

use Doctrine\Common\EventArgs;
use Gedmo\Tree\TreeListener;

/**
 * @see https://github.com/doctrine-extensions/DoctrineExtensions/issues/2216#issuecomment-926767989
 */
class UuidAwareTreeListener extends TreeListener
{
    protected function getEventAdapter(EventArgs $args): UuidAwareTreeAdapter
    {
        $adapter = new UuidAwareTreeAdapter();
        $adapter->setEventArgs($args);

        return $adapter;
    }
}
