<?php

namespace Epsi\FirstBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comporte
 *
 * @ORM\Table(name="comporte")
 * @ORM\Entity(repositoryClass="Epsi\FirstBundle\Repository\ComporteRepository")
 */

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * @ORM\Entity
 * @UniqueEntity(
 *  fields={"mot","listeMot","id"},
 *)
 */

class Comporte
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
     * @ORM\ManyToOne(targetEntity="Epsi\FirstBundle\Entity\mot")
     * @ORM\JoinColumn(nullable=false)
     */
    private $mot;
    
    /**
     * @ORM\ManyToOne(targetEntity="Epsi\FirstBundle\Entity\listeMot")
     * @ORM\JoinColumn(nullable=false)
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
     * Set mot
     *
     * @param \Epsi\FirstBundle\Entity\mot $mot
     *
     * @return Comporte
     */
    public function setMot(\Epsi\FirstBundle\Entity\mot $mot)
    {
        $this->mot = $mot;

        return $this;
    }

    /**
     * Get mot
     *
     * @return \Epsi\FirstBundle\Entity\mot
     */
    public function getMot()
    {
        return $this->mot;
    }

    /**
     * Set listeMot
     *
     * @param \Epsi\FirstBundle\Entity\listeMot $listeMot
     *
     * @return Comporte
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
