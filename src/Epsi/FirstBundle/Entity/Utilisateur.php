<?php

namespace Epsi\FirstBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Utilisateur
 *
 * @ORM\Table(name="utilisateur")
 * @ORM\Entity(repositoryClass="Epsi\FirstBundle\Repository\UtilisateurRepository")
 */
class Utilisateur implements UserInterface
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
     * @ORM\Column(name="Nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="Prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="Password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="CodePostal", type="string", length=5)
     */
    private $codePostal;

    /**
     * @var string
     *
     * @ORM\Column(name="Ville", type="string", length=255)
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="Adresse", type="string", length=255)
     */
    private $adresse;

    /**
    * @var string
    *
    * @ORM\Column(name="username", type="string", length=255, unique=true)
    */
    private $username;
    
    /**
    * @var string
    *
    * @ORM\Column(name="salt", type="string", length=255)
    */
    private $salt;
    /**
    * @var array
    *
    * @ORM\Column(name="roles", type="array")
    */
    private $roles=array();
    
    /**
     *@ORM\ManyToOne(targetEntity="Epsi\FirstBundle\Entity\Abonnement")
     *@ORM\JoinColumn(nullable=false)
     */
    private $abonnement;
    
    /**
     *@ORM\ManyToOne(targetEntity="Epsi\FirstBundle\Entity\Entreprise")
     *@ORM\JoinColumn(nullable=true)
     */
    private $entreprise;

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
     * Set nom
     *
     * @param string $nom
     *
     * @return Utilisateur
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Utilisateur
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set codePostal
     *
     * @param string $codePostal
     *
     * @return Utilisateur
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * Get codePostal
     *
     * @return string
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Utilisateur
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Utilisateur
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
    * Set username
    *
    * @param string $username
    *
    * @return User
    */
    public function setUsername($username)
    {
        $this->username = $username;
        
        return $this;
    }
    
    /**
    * Get username
    *
    * @return string
    */
    public function getUsername()
    {
        return $this->username;
    }
    
    /**
    * Set password
    *
    * @param string $password
    *
    * @return User
    */
    public function setPassword($password)
    {
        $this->password = $password;
        
        return $this;
    }
    
    /**
    * Get password
    *
    * @return string
    */
    public function getPassword()
    {
        return $this->password;        
    }
    
    /**
    * Set salt
    *
    * @param string $salt
    *
    * @return User
    */
    public function setSalt($salt)
    { 
        $this->salt = $salt;
        
        return $this;
    }
    
    /**
    * Get salt
    *
    * @return string
    */
    public function getSalt()
    {   
        return $this->salt;
    }
    
    /**
    * Set roles
    *
    * @param array $roles
    *
    * @return User
    */
    public function setRoles($roles)
    {
        $this->roles = $roles;
        
        return $this;
    }
    
    /**
    * Get roles
    *
    * @return array
    */
    public function getRoles()
    {
        return $this->roles;
    }
    
    public function eraseCredentials(){
        
    }
    
    /**
     * Set abonnement
     *
     * @param \Epsi\FirstBundle\Entity\Abonnement $abonnement
     *
     * @return Utilisateur
     */
    public function setAbonnement(\Epsi\FirstBundle\Entity\Abonnement $abonnement)
    {
        $this->abonnement = $abonnement;

        return $this;
    }

    /**
     * Get abonnement
     *
     * @return \Epsi\FirstBundle\Entity\Abonnement
     */
    public function getAbonnement()
    {
        return $this->abonnement;
    }

    /**
     * Set entreprise
     *
     * @param \Epsi\FirstBundle\Entity\Entreprise $entreprise
     *
     * @return Utilisateur
     */
    public function setEntreprise(\Epsi\FirstBundle\Entity\Entreprise $entreprise = null)
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    /**
     * Get entreprise
     *
     * @return \Epsi\FirstBundle\Entity\Entreprise
     */
    public function getEntreprise()
    {
        return $this->entreprise;
    }


}