<?php

namespace App\Module\Catalog\Domain\Entity;

use App\Core\Infrastructure\Doctrine\Entity\Interfaces\TimestampableInterface;
use App\Core\Infrastructure\Doctrine\Entity\Traits\TimestampableTrait;
use App\Module\Catalog\Infrastructure\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

use function Symfony\Component\String\u;

#[Gedmo\Tree(type: 'nested')]
#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\Table(name: 'catalog_categories')]
class Category implements TimestampableInterface
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

    #[ORM\Column(name: 'indented_name', type: Types::STRING, nullable: true)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    #[Groups(['admin_read'])]
    private ?string $indentedName = null;

    #[ORM\Column(name: 'slug', type: Types::STRING, unique: true)]
    #[Gedmo\Slug(fields: ['name'])]
    #[Groups(['admin_read'])]
    private string $slug;

    #[ORM\Column(name: 'description', type: Types::TEXT, nullable: true)]
    #[Groups(['admin_read'])]
    private ?string $description;

    #[ORM\Column(name: 'is_connected', type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    #[Groups(['admin_read'])]
    private bool $connected = false;

    #[Gedmo\TreeLeft]
    #[ORM\Column(name: 'lft', type: Types::INTEGER)]
    #[Groups(['admin_read'])]
    private int $lft;

    #[Gedmo\TreeLevel]
    #[ORM\Column(name: 'lvl', type: Types::INTEGER)]
    #[Groups(['admin_read'])]
    private int $lvl;

    #[Gedmo\TreeRight]
    #[ORM\Column(name: 'rgt', type: Types::INTEGER)]
    #[Groups(['admin_read'])]
    private int $rgt;

    #[Gedmo\TreeRoot]
    #[ORM\ManyToOne(targetEntity: Category::class)]
    #[ORM\JoinColumn(name: 'tree_root', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private ?self $root = null;

    #[Gedmo\TreeParent]
    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'children')]
    #[ORM\JoinColumn(name: 'parent_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private ?self $parent = null;

    /**
     * @var Category[]|Collection<int, Category>
     */
    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: Category::class)]
    #[ORM\OrderBy(['lft' => 'ASC'])]
    private Collection $children;

    public function __construct(string $name, ?string $description = null)
    {
        $this->setName($name);
        $this->description = $description;
        $this->children = new ArrayCollection();
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

    public function getIndentedName(): ?string
    {
        return $this->indentedName;
    }

    public function updateIndentedName(): void
    {
        $this->indentedName = u(u('-')->repeat($this->lvl * 4))
            ->append(' ')
            ->append($this->name)
            ->trim()
            ->toString();
    }

    public function getSlug(): string
    {
        return $this->slug;
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

    public function isConnected(): bool
    {
        return $this->connected;
    }

    public function setConnected(bool $connected): void
    {
        $this->connected = $connected;
    }

    public function setRoot(?Category $root = null): self
    {
        $this->root = $root;

        return $this;
    }

    public function getLft(): int
    {
        return $this->lft;
    }

    public function getLvl(): int
    {
        return $this->lvl;
    }

    public function getRgt(): int
    {
        return $this->rgt;
    }

    public function getRoot(): ?self
    {
        return $this->root;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent = null): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Category[]|Collection<int, Category>
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }
}
