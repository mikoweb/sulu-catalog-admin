<?php

namespace App\Module\Catalog\Domain\Entity;

use App\Core\Infrastructure\Doctrine\Entity\Interfaces\TimestampableInterface;
use App\Core\Infrastructure\Doctrine\Entity\Traits\TimestampableTrait;
use App\Module\Catalog\Infrastructure\Repository\ItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
#[ORM\Table(name: 'catalog_items')]
class Item implements TimestampableInterface
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[Assert\NotNull]
    #[Groups(['admin_read'])]
    private Uuid $id;

    #[ORM\Column(name: 'name', type: Types::STRING, nullable: false)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    #[Groups(['admin_read'])]
    private string $name;

    #[ORM\Column(name: 'slug', type: Types::STRING, unique: true)]
    #[Assert\Length(max: 255)]
    #[Gedmo\Slug(fields: ['name'])]
    #[Groups(['admin_read'])]
    private string $slug;

    #[ORM\Column(name: 'description', type: Types::TEXT, nullable: true)]
    #[Groups(['admin_read'])]
    private ?string $description;

    /**
     * @var Category[]|Collection<int, Category>
     */
    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'items')]
    #[ORM\JoinTable(
        name: 'catalog_item_categories',
        joinColumns: new ORM\JoinColumn(name: 'item_id', referencedColumnName: 'id'),
        inverseJoinColumns: new ORM\JoinColumn(name: 'category_id', referencedColumnName: 'id'),
    )]
    private Collection $categories;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->categories = new ArrayCollection();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Category[]|Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }
}
