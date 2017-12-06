<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SaleDetail
 *
 * @ORM\Table(name="fe_sale_detail")
 * @ORM\Entity(repositoryClass="App\Repository\SaleDetailRepository")
 */
class SaleDetail
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="product_id", type="integer")
     */
    private $productId;

    /**
     * @var float
     *
     * @ORM\Column(name="quantity", type="float")
     */
    private $quantity;

    /**
     * @var string
     *
     * @ORM\Column(name="tax_code", type="string", length=3)
     */
    private $taxCode;

    /**
     * @var float
     *
     * @ORM\Column(name="igv", type="float")
     */
    private $igv;

    /**
     * @var float
     *
     * @ORM\Column(name="unit_value", type="float")
     */
    private $unitValue;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var float
     *
     * @ORM\Column(name="total", type="float")
     */
    private $total;

    /**
     * @var int
     *
     * @ORM\Column(name="sale_id", type="integer")
     */
    private $saleId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Sale", inversedBy="details")
     * @ORM\JoinColumn(name="sale_id", referencedColumnName="id")
     * @var Sale
     */
    private $sale;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set productId
     *
     * @param integer $productId
     *
     * @return SaleDetail
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;

        return $this;
    }

    /**
     * Get productId
     *
     * @return int
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * Set quantity
     *
     * @param float $quantity
     *
     * @return SaleDetail
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return float
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set taxCode
     *
     * @param string $taxCode
     *
     * @return SaleDetail
     */
    public function setTaxCode($taxCode)
    {
        $this->taxCode = $taxCode;

        return $this;
    }

    /**
     * Get taxCode
     *
     * @return string
     */
    public function getTaxCode()
    {
        return $this->taxCode;
    }

    /**
     * Set igv
     *
     * @param float $igv
     *
     * @return SaleDetail
     */
    public function setIgv($igv)
    {
        $this->igv = $igv;

        return $this;
    }

    /**
     * Get igv
     *
     * @return float
     */
    public function getIgv()
    {
        return $this->igv;
    }

    /**
     * Set unitValue
     *
     * @param float $unitValue
     *
     * @return SaleDetail
     */
    public function setUnitValue($unitValue)
    {
        $this->unitValue = $unitValue;

        return $this;
    }

    /**
     * Get unitValue
     *
     * @return float
     */
    public function getUnitValue()
    {
        return $this->unitValue;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return SaleDetail
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set total
     *
     * @param float $total
     *
     * @return SaleDetail
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set saleId
     *
     * @param integer $saleId
     *
     * @return SaleDetail
     */
    public function setSaleId($saleId)
    {
        $this->saleId = $saleId;

        return $this;
    }

    /**
     * Get saleId
     *
     * @return int
     */
    public function getSaleId()
    {
        return $this->saleId;
    }

    /**
     * @param Sale $sale
     * @return SaleDetail
     */
    public function setSale($sale)
    {
        $this->sale = $sale;
        return $this;
    }

    /**
     * @return Sale
     */
    public function getSale()
    {
        return $this->sale;
    }
}

