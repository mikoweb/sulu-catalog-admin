<?php

namespace App\Module\Catalog\Domain\Entity;

use App\Core\Application\Entity\TimestampableInterface;
use App\Core\Application\Entity\TimestampableTrait;
use App\Module\Catalog\Infrastructure\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\Table(name: 'catalog_categories')]
class Category implements TimestampableInterface
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 36, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[Assert\NotNull]
    private ?string $id;

    public function getId(): ?string
    {
        return $this->id;
    }
}
