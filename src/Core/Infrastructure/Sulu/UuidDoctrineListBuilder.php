<?php

namespace App\Core\Infrastructure\Sulu;

use Sulu\Component\Rest\ListBuilder\Doctrine\DoctrineListBuilder;
use Symfony\Component\Uid\AbstractUid;
use Symfony\Component\Uid\Uuid;

class UuidDoctrineListBuilder extends DoctrineListBuilder
{
    public function setIds($ids): self
    {
        return parent::setIds($this->mapUuids($ids));
    }

    public function setExcludedIds($excludedIds): self
    {
        return parent::setExcludedIds($this->mapUuids($excludedIds));
    }

    /**
     * @return string[]|int[]
     */
    protected function findIdsByGivenCriteria(): array
    {
        $ids = parent::findIdsByGivenCriteria();

        return $this->mapUuids($ids);
    }

    private function mapUuids(?array $ids): ?array
    {
        if (is_null($ids)) {
            return null;
        }

        return array_map(function ($id) {
            return match (gettype($id)) {
                'string' => Uuid::isValid($id) ? Uuid::fromString($id)->toBinary() : $id,
                'object' => $id instanceof AbstractUid ? $id->toBinary() : $id,
                default => $id,
            };
        }, $ids);
    }
}
