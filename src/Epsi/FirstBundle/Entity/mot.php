<?php

namespace Epsi\FirstBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * mot
 *
 * @ORM\Table(name="mot")
 * @ORM\Entity(repositoryClass="Epsi\FirstBundle\Repository\motRepository")
 */
class mot
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
     * @ORM\Column(name="Libelle", type="string", length=50)
     */
    private $libelle;

    /**
     * @ORM\ManyToOne(targetEntity="Epsi\FirstBundle\Entity\categorie")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;
    
    /**
     * @var string
     *
     * @ORM\Column(name="LibelleAnglais", type="string", length=50)
     */
    private $libelleAnglais;
    
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
     * Set libelle
     *
     * @param string $libelle
     *
     * @return mot
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }
    
    /**
     * Set categorie
     *
     * @param \Epsi\FirstBundle\Entity\categorie $categorie
     *
     * @return mot
     */
    public function setCategorie(\Epsi\FirstBundle\Entity\categorie $categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return \Epsi\FirstBundle\Entity\categorie
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set libelleAnglais
     *
     * @param string $libelleAnglais
     *
     * @return mot
     */
    public function setLibelleAnglais($libelleAnglais)
    {
        $this->libelleAnglais = $libelleAnglais;

        return $this;
    }

    /**
     * Get libelleAnglais
     *
     * @return string
     */
    public function getLibelleAnglais()
    {
        return $this->libelleAnglais;
    }
}
