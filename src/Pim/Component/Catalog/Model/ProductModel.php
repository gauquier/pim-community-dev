<?php

namespace Pim\Component\Catalog\Model;

use Akeneo\Component\Classification\Model\CategoryInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @author    Damien Carcel (damien.carcel@akeneo.com)
 * @copyright 2017 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class ProductModel implements ProductModelInterface
{
    /** @var int */
    protected $id;

    /** @var string */
    protected $identifier;

    /** @var array */
    protected $rawValues;

    /**
     * Not persisted. Loaded on the fly via the $rawValues.
     *
     * @var ValueCollectionInterface
     */
    protected $values;

    /** @var \Datetime $created */
    protected $created;

    /** @var \Datetime $updated */
    protected $updated;

    /** @var int */
    protected $root;

    /** @var int */
    protected $level;

    /** @var int */
    protected $left;

    /** @var int */
    protected $right;

    /** @var Collection $categories */
    protected $categories;

    /** @var Collection $categories */
    protected $products;

    /** @var ProductModelInterface */
    protected $parent;

    /** @var Collection */
    protected $productModels;

    /** @var FamilyVariantInterface */
    protected $familyVariant;

    /**
     * Create an instance of ProductModel.
     */
    public function __construct()
    {
        $this->values = new ValueCollection();
        $this->categories = new ArrayCollection();
        $this->products = new ArrayCollection();
        $this->productModels = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * {@inheritdoc}
     */
    public function setIdentifier(string $identifier): void
    {
        $this->identifier = $identifier;
    }

    /**
     * {@inheritdoc}
     */
    public function getRawValues(): array
    {
        return $this->rawValues;
    }

    /**
     * {@inheritdoc}
     */
    public function setRawValues(array $rawValues): ProductModelInterface
    {
        $this->rawValues = $rawValues;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getValues(): ValueCollectionInterface
    {
        return $this->values;
    }

    /**
     * {@inheritdoc}
     */
    public function setValues(ValueCollectionInterface $values): ProductModelInterface
    {
        $this->values = $values;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue($attributeCode, $localeCode = null, $scopeCode = null): ?ValueInterface
    {
        return $this->values->getByCodes($attributeCode, $scopeCode, $localeCode);
    }

    /**
     * {@inheritdoc}
     */
    public function addValue(ValueInterface $value): ProductModelInterface
    {
        $this->values->add($value);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeValue(ValueInterface $value): ProductModelInterface
    {
        $this->values->remove($value);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributes(): array
    {
        return $this->values->getAttributes();
    }

    /**
     * {@inheritdoc}
     */
    public function hasAttribute(AttributeInterface $attribute): bool
    {
        return in_array($attribute, $this->values->getAttributes(), true);
    }

    /**
     * {@inheritdoc}
     */
    public function getUsedAttributeCodes(): array
    {
        return $this->values->getAttributesKeys();
    }

    /**
     * {@inheritdoc}
     */
    public function getCreated(): \DateTimeInterface
    {
        return $this->created;
    }

    /**
     * {@inheritdoc}
     */
    public function setCreated($created): ProductModelInterface
    {
        $this->created = $created;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdated(): \DateTimeInterface
    {
        return $this->updated;
    }

    /**
     * {@inheritdoc}
     */
    public function setUpdated($updated): ProductModelInterface
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    /**
     * {@inheritdoc}
     */
    public function removeCategory(CategoryInterface $category): ProductModelInterface
    {
        $this->categories->removeElement($category);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addCategory(CategoryInterface $category): ProductModelInterface
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCategoryCodes(): array
    {
        $codes = $this->getCategories()->map(function (CategoryInterface $category) {
            return $category->getCode();
        })->toArray();

        sort($codes);

        return $codes;
    }

    /**
     * {@inheritdoc}
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    /**
     * {@inheritdoc}
     */
    public function addProduct(ProductInterface $product): ProductModelInterface
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeProduct(ProductInterface $product): ProductModelInterface
    {
        $this->products->removeElement($product);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setRoot(int $root): ProductModelInterface
    {
        $this->root = $root;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoot(): int
    {
        return $this->root;
    }

    /**
     * {@inheritdoc}
     */
    public function isRoot(): bool
    {
        return (null === $this->getParent());
    }

    /**
     * {@inheritdoc}
     */
    public function setLevel(int $level): ProductModelInterface
    {
        $this->level = $level;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * {@inheritdoc}
     */
    public function setLeft(int $left): ProductModelInterface
    {
        $this->left = $left;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLeft(): int
    {
        return $this->left;
    }

    /**
     * {@inheritdoc}
     */
    public function setRight(int $right): ProductModelInterface
    {
        $this->right = $right;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRight(): int
    {
        return $this->right;
    }

    /**
     * {@inheritdoc}
     */
    public function setParent(ProductModelInterface $parent = null): ProductModelInterface
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent(): ?ProductModelInterface
    {
        return $this->parent;
    }

    /**
     * {@inheritdoc}
     */
    public function addProductModel(ProductModelInterface $child): ProductModelInterface
    {
        $this->productModels->add($child);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeProductModel(ProductModelInterface $children): ProductModelInterface
    {
        $this->productModels->removeElement($children);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function hasProductModels(): bool
    {
        return false === $this->getProductModels()->isEmpty();
    }

    /**
     * {@inheritdoc}
     */
    public function getProductModels(): Collection
    {
        return $this->productModels;
    }

    /**
     * {@inheritdoc}
     */
    public function getFamilyVariant(): ?FamilyVariantInterface
    {
        return $this->familyVariant;
    }

    /**
     * @param FamilyVariantInterface $familyVariant
     */
    public function setFamilyVariant(FamilyVariantInterface $familyVariant): void
    {
        $this->familyVariant = $familyVariant;
    }

    /**
     * {@inheritdoc}
     */
    public function getVariationLevel(): int
    {
        $entity = $this;
        $level = 0;

        while (true) {
            $entity = $entity->getParent();
            if (null === $entity) {
                return $level;
            }

            $level++;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isRootVariation(): bool
    {
        return null === $this->parent;
    }
}
