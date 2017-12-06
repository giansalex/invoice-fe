<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DocNumber
 *
 * @ORM\Table(name="fe_doc_number", indexes={@ORM\Index(name="doc_user_id", columns={"user_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\DocNumberRepository")
 */
class DocNumber
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
     * @ORM\Column(name="code", type="string", length=3)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="serie", type="string", length=4)
     */
    private $serie;

    /**
     * @var int
     *
     * @ORM\Column(name="correlativo", type="integer")
     */
    private $correlativo;

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
     * Set code
     *
     * @param string $code
     *
     * @return DocNumber
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set serie
     *
     * @param string $serie
     *
     * @return DocNumber
     */
    public function setSerie($serie)
    {
        $this->serie = strtoupper($serie);

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
     * @param integer $correlativo
     *
     * @return DocNumber
     */
    public function setCorrelativo($correlativo)
    {
        $this->correlativo = $correlativo;

        return $this;
    }

    /**
     * Get correlativo
     *
     * @return int
     */
    public function getCorrelativo()
    {
        return $this->correlativo;
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

