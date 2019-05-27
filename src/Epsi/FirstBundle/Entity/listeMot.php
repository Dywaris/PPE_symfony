<?php

namespace Epsi\FirstBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * listeMot
 *
 * @ORM\Table(name="liste_mot")
 * @ORM\Entity(repositoryClass="Epsi\FirstBundle\Repository\listeMotRepository")
 */
class listeMot
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
     *@ORM\ManyToMany(targetEntity="Epsi\FirstBundle\Entity\mot",cascade={"persist"}) 
     */
    private $mot;
    
    /**
     * @ORM\ManyToOne(targetEntity="Epsi\FirstBundle\Entity\Theme")
     * @ORM\JoinColumn(nullable=false)
     */
    private $theme;
    
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
     * @return listeMot
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
     * Constructor
     */
    public function __construct()
    {
        $this->mot = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add mot
     *
     * @param \Epsi\FirstBundle\Entity\Mot $mot
     *
     * @return listeMot
     */
    public function addMot(\Epsi\FirstBundle\Entity\Mot $mot)
    {
        $this->mot[] = $mot;

        return $this;
    }

    /**
     * Remove mot
     *
     * @param \Epsi\FirstBundle\Entity\Mot $mot
     */
    public function removeMot(\Epsi\FirstBundle\Entity\Mot $mot)
    {
        $this->mot->removeElement($mot);
    }

    /**
     * Get mot
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMot()
    {
        return $this->mot;
    }

    /**
     * Set theme
     *
     * @param \Epsi\FirstBundle\Entity\Theme $theme
     *
     * @return listeMot
     */
    public function setTheme(\Epsi\FirstBundle\Entity\Theme $theme)
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * Get theme
     *
     * @return \Epsi\FirstBundle\Entity\Theme
     */
    public function getTheme()
    {
        return $this->theme;
    }
}
