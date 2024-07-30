<?php

namespace App\Core\Infrastructure\Sulu;

use Sulu\Component\Rest\ListBuilder\Doctrine\DoctrineListBuilder;
use Symfony\Component\Uid\AbstractUid;

class UuidDoctrineListBuilder extends DoctrineListBuilder
{
    /**
     * @return string[]|int[]
     */
    protected function findIdsByGivenCriteria(): array
    {
        $ids = parent::findIdsByGivenCriteria();

        return array_map(fn ($id) => $id instanceof AbstractUid ? $id->toBinary() : $id, $ids);
    }
}
