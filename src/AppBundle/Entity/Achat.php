<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Achat
 *
 * @ORM\Table(name="achat")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AchatRepository")
 */
class Achat
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
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="produit", type="string", length=255)
     */
    private $produit;

    /**
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer")
     */
    private $quantite;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data", type="datetime")
     */
    private $data;

    /**
     * @var int
     *
     * @ORM\Column(name="PU", type="integer")
     */
    private $pU;
    
 
    /**
     * Get id
     *
     * @return int
     */

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\fournisseur", inversedBy="achats")
     * @ORM\JoinColumn(name="fournisseur_id", referencedColumnName="id", nullable=true)
     */
    protected $fournisseur;

    public function getId()
    {
        return $this->id;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Achat
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set produit
     *
     * @param string $produit
     *
     * @return Achat
     */
    public function setProduit($produit)
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * Get produit
     *
     * @return string
     */
    public function getProduit()
    {
        return $this->produit;
    }

    /**
     * Set quantite
     *
     * @param integer $quantite
     *
     * @return Achat
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return int
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set data
     *
     * @param \DateTime $data
     *
     * @return Achat
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return \DateTime
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set pU
     *
     * @param integer $pU
     *
     * @return Achat
     */
    public function setPU($pU)
    {
        $this->pU = $pU;

        return $this;
    }

    /**
     * Get pU
     *
     * @return int
     */
    public function getPU()
    {
        return $this->pU;
    }

    /**
     * Set fournisseur
     *
     * @param \AppBundle\Entity\fournisseur $fournisseur
     *
     * @return Achat
     */
    public function setFournisseur(\AppBundle\Entity\fournisseur $fournisseur = null)
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    /**
     * Get fournisseur
     *
     * @return \AppBundle\Entity\fournisseur
     */
    public function getFournisseur()
    {
        return $this->fournisseur;
    }
}
