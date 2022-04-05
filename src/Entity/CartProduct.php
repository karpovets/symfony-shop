<?php

namespace App\Entity;

use App\Repository\CartProductRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CartProductRepository::class)
 * @ApiResource(
 *     collectionOperations={
 *         "get"={
 *              "normalization_context"={"groups"="cart_product:list"}
 *          },
 *         "post"={
 *              "normalization_context"={"groups"="cart_product:list:write"},
 *              "security_post_denormalize"="is_granted('CART_PRODUCT_EDIT', object)"
 *         }
 *     },
 *     itemOperations={
 *      "get"={
 *          "normalization_context"={"groups"="cart_product:item"},
*           "security"="is_granted('CART_PRODUCT_READ', object)"
 *      },
 *      "delete"={
 *          "security"="is_granted('CART_PRODUCT_DELETE', object)"
 *      },
 *      "patch"={
 *          "security_post_denormalize"="is_granted('CART_PRODUCT_EDIT', object)"
 *      }
 *     }
 * )
 */
class CartProduct
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @Groups({"cart_product:item", "cart_product:list", "cart:item", "cart:list"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Cart::class, inversedBy="cartProducts")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Groups({"cart_product:item", "cart_product:list"})
     */
    private $cart;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="cartProducts")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Groups({"cart_product:item", "cart_product:list", "cart:item", "cart:list"})
     */
    private $product;

    /**
     * @ORM\Column(type="integer")
     *
     * @Groups({"cart_product:item", "cart_product:list", "cart:item", "cart:list"})
     */
    private $quantity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    public function setCart(?Cart $cart): self
    {
        $this->cart = $cart;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
