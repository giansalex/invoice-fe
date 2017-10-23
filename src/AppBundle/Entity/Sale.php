<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Sale
 * @ORM\Table(name="fe_sale", indexes={@ORM\Index(name="sale_user_id", columns={"user_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SaleRepository")
 */
class Sale
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
     * @var string
     *
     * @ORM\Column(name="doc_type", type="string", length=3)
     */
    private $docType;

    /**
     * @var string
     *
     * @ORM\Column(name="serie", type="string", length=4)
     */
    private $serie;

    /**
     * @var string
     *
     * @ORM\Column(name="correlativo", type="string", length=8)
     */
    private $correlativo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="emision", type="datetime")
     */
    private $emision;

    /**
     * @var string
     *
     * @ORM\Column(name="operation_type", type="string", length=3, nullable=true)
     */
    private $operationType;

    /**
     * @var string
     *
     * @ORM\Column(name="moneda", type="string", length=5)
     */
    private $moneda;

    /**
     * @var int
     *
     * @ORM\Column(name="client_id", type="integer")
     */
    private $clientId;

    /**
     * @var string
     *
     * @ORM\Column(name="doc_type_ref", type="string", length=3, nullable=true)
     */
    private $docTypeRef;

    /**
     * @var string
     *
     * @ORM\Column(name="serie_ref", type="string", length=4, nullable=true)
     */
    private $serieRef;

    /**
     * @var string
     *
     * @ORM\Column(name="correlativo_ref", type="string", length=8, nullable=true)
     */
    private $correlativoRef;

    /**
     * @var string
     *
     * @ORM\Column(name="motivo_code", type="string", length=3, nullable=true)
     */
    private $motivoCode;

    /**
     * @var float
     *
     * @ORM\Column(name="gravada", type="float")
     */
    private $gravada;

    /**
     * @var float
     *
     * @ORM\Column(name="exonerada", type="float")
     */
    private $exonerada;

    /**
     * @var float
     *
     * @ORM\Column(name="inafecta", type="float")
     */
    private $inafecta;

    /**
     * @var float
     *
     * @ORM\Column(name="gratuito", type="float", nullable=true)
     */
    private $gratuito;

    /**
     * @var float
     *
     * @ORM\Column(name="igv", type="float")
     */
    private $igv;

    /**
     * @var float
     *
     * @ORM\Column(name="total", type="float")
     */
    private $total;

    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\SaleDetail", mappedBy="sale")
     * @var SaleDetail[]
     */
    private $details;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @var User
     */
    private $user;

    public function __construct()
    {
        $this->details = new ArrayCollection();
    }

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
     * Set docType
     *
     * @param string $docType
     *
     * @return Sale
     */
    public function setDocType($docType)
    {
        $this->docType = $docType;

        return $this;
    }

    /**
     * Get docType
     *
     * @return string
     */
    public function getDocType()
    {
        return $this->docType;
    }

    /**
     * Set serie
     *
     * @param string $serie
     *
     * @return Sale
     */
    public function setSerie($serie)
    {
        $this->serie = $serie;

        return $this;
    }

    /**
     * Get serie
     *
     * @return string
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * Set correlativo
     *
     * @param string $correlativo
     *
     * @return Sale
     */
    public function setCorrelativo($correlativo)
    {
        $this->correlativo = $correlativo;

        return $this;
    }

    /**
     * Get correlativo
     *
     * @return string
     */
    public function getCorrelativo()
    {
        return $this->correlativo;
    }

    /**
     * Set emision
     *
     * @param \DateTime $emision
     *
     * @return Sale
     */
    public function setEmision($emision)
    {
        $this->emision = $emision;

        return $this;
    }

    /**
     * Get emision
     *
     * @return \DateTime
     */
    public function getEmision()
    {
        return $this->emision;
    }

    /**
     * Set operationType
     *
     * @param string $operationType
     *
     * @return Sale
     */
    public function setOperationType($operationType)
    {
        $this->operationType = $operationType;

        return $this;
    }

    /**
     * Get operationType
     *
     * @return string
     */
    public function getOperationType()
    {
        return $this->operationType;
    }

    /**
     * Set moneda
     *
     * @param string $moneda
     *
     * @return Sale
     */
    public function setMoneda($moneda)
    {
        $this->moneda = $moneda;

        return $this;
    }

    /**
     * Get moneda
     *
     * @return string
     */
    public function getMoneda()
    {
        return $this->moneda;
    }

    /**
     * Set clientId
     *
     * @param integer $clientId
     *
     * @return Sale
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;

        return $this;
    }

    /**
     * Get clientId
     *
     * @return int
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * Set docTypeRef
     *
     * @param string $docTypeRef
     *
     * @return Sale
     */
    public function setDocTypeRef($docTypeRef)
    {
        $this->docTypeRef = $docTypeRef;

        return $this;
    }

    /**
     * Get docTypeRef
     *
     * @return string
     */
    public function getDocTypeRef()
    {
        return $this->docTypeRef;
    }

    /**
     * Set serieRef
     *
     * @param string $serieRef
     *
     * @return Sale
     */
    public function setSerieRef($serieRef)
    {
        $this->serieRef = $serieRef;

        return $this;
    }

    /**
     * Get serieRef
     *
     * @return string
     */
    public function getSerieRef()
    {
        return $this->serieRef;
    }

    /**
     * Set correlativoRef
     *
     * @param string $correlativoRef
     *
     * @return Sale
     */
    public function setCorrelativoRef($correlativoRef)
    {
        $this->correlativoRef = $correlativoRef;

        return $this;
    }

    /**
     * Get correlativoRef
     *
     * @return string
     */
    public function getCorrelativoRef()
    {
        return $this->correlativoRef;
    }

    /**
     * Set motivoCode
     *
     * @param string $motivoCode
     *
     * @return Sale
     */
    public function setMotivoCode($motivoCode)
    {
        $this->motivoCode = $motivoCode;

        return $this;
    }

    /**
     * Get motivoCode
     *
     * @return string
     */
    public function getMotivoCode()
    {
        return $this->motivoCode;
    }

    /**
     * Set gravada
     *
     * @param float $gravada
     *
     * @return Sale
     */
    public function setGravada($gravada)
    {
        $this->gravada = $gravada;

        return $this;
    }

    /**
     * Get gravada
     *
     * @return float
     */
    public function getGravada()
    {
        return $this->gravada;
    }

    /**
     * Set exonerada
     *
     * @param float $exonerada
     *
     * @return Sale
     */
    public function setExonerada($exonerada)
    {
        $this->exonerada = $exonerada;

        return $this;
    }

    /**
     * Get exonerada
     *
     * @return float
     */
    public function getExonerada()
    {
        return $this->exonerada;
    }

    /**
     * Set inafecta
     *
     * @param float $inafecta
     *
     * @return Sale
     */
    public function setInafecta($inafecta)
    {
        $this->inafecta = $inafecta;

        return $this;
    }

    /**
     * Get inafecta
     *
     * @return float
     */
    public function getInafecta()
    {
        return $this->inafecta;
    }

    /**
     * Set gratuito
     *
     * @param float $gratuito
     *
     * @return Sale
     */
    public function setGratuito($gratuito)
    {
        $this->gratuito = $gratuito;

        return $this;
    }

    /**
     * Get gratuito
     *
     * @return float
     */
    public function getGratuito()
    {
        return $this->gratuito;
    }

    /**
     * Set igv
     *
     * @param float $igv
     *
     * @return Sale
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
     * Set total
     *
     * @param float $total
     *
     * @return Sale
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
     * Set userId
     *
     * @param integer $userId
     *
     * @return Sale
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return SaleDetail[]
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }
}

