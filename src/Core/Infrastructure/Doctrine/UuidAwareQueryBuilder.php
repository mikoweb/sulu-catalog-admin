<?php

namespace App\Core\Infrastructure\Doctrine;

use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Uid\Ulid;
use Symfony\Component\Uid\Uuid;

/**
 * @see https://github.com/doctrine-extensions/DoctrineExtensions/issues/2216#issuecomment-926767989
 */
class UuidAwareQueryBuilder extends QueryBuilder
{
    public function setParameter($key, $value, $type = null): self
    {
        if (is_null($type)) {
            if (is_object($value) && method_exists($value, 'getId')) {
                $value = $value->getId();
            }

            $type = $value instanceof Uuid ? 'uuid' : ($value instanceof Ulid ? 'ulid' : $type);
        }

        return parent::setParameter($key, $value, $type);
    }
}
