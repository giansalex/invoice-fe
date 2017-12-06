<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Client
 *
 * @ORM\Table(name="fe_client", indexes={@ORM\Index(name="client_user_id", columns={"user_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */
class Client
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
     * @ORM\Column(name="type_doc", type="string", length=2)
     */
    private $typeDoc;

    /**
     * @var string
     *
     * @ORM\Column(name="document", type="string", length=15)
     */
    private $document;

    /**
     * @var string
     *
     * @ORM\Column(name="name_rzs", type="string", length=100)
     */
    private $nameRzs;

    /**
     * @var string
     *
     * @ORM\Column(name="comercial_name", type="string", length=100, nullable=true)
     */
    private $comercialName;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=50, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=100, nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="observation", type="string", length=100, nullable=true)
     */
    private $observation;

    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @var User
     */
    private $user;

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
     * Set typeDoc
     *
     * @param string $typeDoc
     *
     * @return Client
     */
    public function setTypeDoc($typeDoc)
    {
        $this->typeDoc = $typeDoc;

        return $this;
    }

    /**
     * Get typeDoc
     *
     * @return string
     */
    public function getTypeDoc()
    {
        return $this->typeDoc;
    }

    /**
     * Set document
     *
     * @param string $document
     *
     * @return Client
     */
    public function setDocument($document)
    {
        $this->document = $document;

        return $this;
    }

    /**
     * Get document
     *
     * @return string
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * Set nameRzs
     *
     * @param string $nameRzs
     *
     * @return Client
     */
    public function setNameRzs($nameRzs)
    {
        $this->nameRzs = $nameRzs;

        return $this;
    }

    /**
     * Get nameRzs
     *
     * @return string
     */
    public function getNameRzs()
    {
        return $this->nameRzs;
    }

    /**
     * Set comercialName
     *
     * @param string $comercialName
     *
     * @return Client
     */
    public function setComercialName($comercialName)
    {
        $this->comercialName = $comercialName;

        return $this;
    }

    /**
     * Get comercialName
     *
     * @return string
     */
    public function getComercialName()
    {
        return $this->comercialName;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Client
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Client
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set observation
     *
     * @param string $observation
     *
     * @return Client
     */
    public function setObservation($observation)
    {
        $this->observation = $observation;

        return $this;
    }

    /**
     * Get observation
     *
     * @return string
     */
    public function getObservation()
    {
        return $this->observation;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Client
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

