<?php

namespace Epsi\FirstBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
* @ORM\Entity
* @UniqueEntity(
* fields={"test", "utilisateur", "date"},
* )
*/
/**
 * TestUtilisateur
 *
 * @ORM\Table(name="test_utilisateur")
 * @ORM\Entity(repositoryClass="Epsi\FirstBundle\Repository\TestUtilisateurRepository")
 */
class TestUtilisateur
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;
    /**
    * @ORM\ManyToOne(targetEntity="Epsi\FirstBundle\Entity\test")
    * @ORM\JoinColumn(nullable=false)
    */
    private $test;
    /**
    * @ORM\ManyToOne(targetEntity="Epsi\FirstBundle\Entity\Utilisateur")
    * @ORM\JoinColumn(nullable=false)
    */
    private $utilisateur;

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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return TestUtilisateur
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set test
     *
     * @param \Epsi\FirstBundle\Entity\test $test
     *
     * @return TestUtilisateur
     */
    public function setTest(\Epsi\FirstBundle\Entity\test $test)
    {
        $this->test = $test;

        return $this;
    }

    /**
     * Get test
     *
     * @return \Epsi\FirstBundle\Entity\test
     */
    public function getTest()
    {
        return $this->test;
    }

    /**
     * Set utilisateur
     *
     * @param \Epsi\FirstBundle\Entity\Utilisateur $utilisateur
     *
     * @return TestUtilisateur
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
}
