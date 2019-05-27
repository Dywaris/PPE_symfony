<?php

namespace Epsi\FirstBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Possede
 *
 * @ORM\Table(name="possede")
 * @ORM\Entity(repositoryClass="Epsi\FirstBundle\Repository\PossedeRepository")
 */
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * @ORM\Entity
 * @UniqueEntity(
 *  fields={"utilisateur","listeMot","id"},
 * )
 */

class Possede
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
     *@ORM\ManyToOne(targetEntity="Epsi\FirstBundle\Entity\Utilisateur")
     *@ORM\JoinColumn(nullable=false)
     */
    private $utilisateur;
    
    /**
     *@ORM\ManyToOne(targetEntity="Epsi\FirstBundle\Entity\listeMot")
     *@ORM\JoinColumn(nullable=false)
     */
    private $listeMot;

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
     * Set utilisateur
     *
     * @param \Epsi\FirstBundle\Entity\Utilisateur $utilisateur
     *
     * @return Possede
     */
    public function setUtilisateur(\Epsi\FirstBundle\Entity\Utilisateur $utilisateur)
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get utilisateur
     *
     * @return \Epsi\FirstBundle\Entity\Utilisateur
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    /**
     * Set listeMot
     *
     * @param \Epsi\FirstBundle\Entity\listeMot $listeMot
     *
     * @return Possede
     */
    public function setListeMot(\Epsi\FirstBundle\Entity\listeMot $listeMot)
    {
        $this->listeMot = $listeMot;

        return $this;
    }

    /**
     * Get listeMot
     *
     * @return \Epsi\FirstBundle\Entity\listeMot
     */
    public function getListeMot()
    {
        return $this->listeMot;
    }
}
