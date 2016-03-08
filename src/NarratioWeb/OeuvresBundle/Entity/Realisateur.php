<?php
namespace NarratioWeb\OeuvresBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Realisateur
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="NarratioWeb\OeuvresBundle\Entity\RealisateurRepository")
 */
class Realisateur
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;
    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Set nom
     *
     * @param string $nom
     * @return Realisateur
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
     * @return Realisateur
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
     * Get label
     *
     * @return string 
     */
    public function getLabel()
    {
        return $this->prenom.' '.$this->nom;
    }
}