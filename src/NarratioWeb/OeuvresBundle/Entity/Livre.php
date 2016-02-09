<?php
namespace NarratioWeb\OeuvresBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Livre
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="NarratioWeb\OeuvresBundle\Entity\LivreRepository")
 */
class Livre
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
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;
    /**
     * @ORM\ManyToMany(targetEntity="NarratioWeb\OeuvresBundle\Entity\Auteur")
     */
    private $auteur;
    
    /**
     * @ORM\ManyToOne(targetEntity="NarratioWeb\OeuvresBundle\Entity\Editeur")
     */
    private $editeur;
    
    /**
     * @ORM\ManyToOne(targetEntity="NarratioWeb\OeuvresBundle\Entity\OeuvreLitt",
     *                  cascade={"persist", "remove"})
     */
    private $oeuvreLitt;
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
     * Set titre
     *
     * @param string $titre
     * @return Livre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
        return $this;
    }
    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }
    /**
     * Set auteur
     *
     * @param \NarratioWeb\OeuvresBundle\Entity\Epoque $auteur
     * @return Livre
     */
    public function setAuteur(\NarratioWeb\OeuvresBundle\Entity\Epoque $auteur = null)
    {
        $this->auteur = $auteur;
        return $this;
    }
    /**
     * Get auteur
     *
     * @return \NarratioWeb\OeuvresBundle\Entity\Epoque 
     */
    public function getAuteur()
    {
        return $this->auteur;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->auteur = new \Doctrine\Common\Collections\ArrayCollection();
    }
    /**
     * Add auteur
     *
     * @param \NarratioWeb\OeuvresBundle\Entity\Auteur $auteur
     * @return Livre
     */
    public function addAuteur(\NarratioWeb\OeuvresBundle\Entity\Auteur $auteur)
    {
        $this->auteur[] = $auteur;
        return $this;
    }
    /**
     * Remove auteur
     *
     * @param \NarratioWeb\OeuvresBundle\Entity\Auteur $auteur
     */
    public function removeAuteur(\NarratioWeb\OeuvresBundle\Entity\Auteur $auteur)
    {
        $this->auteur->removeElement($auteur);
    }
    /**
     * Set editeur
     *
     * @param \NarratioWeb\OeuvresBundle\Entity\Editeur $editeur
     * @return Livre
     */
    public function setEditeur(\NarratioWeb\OeuvresBundle\Entity\Editeur $editeur = null)
    {
        $this->editeur = $editeur;
        return $this;
    }
    /**
     * Get editeur
     *
     * @return \NarratioWeb\OeuvresBundle\Entity\Editeur 
     */
    public function getEditeur()
    {
        return $this->editeur;
    }
    /**
     * Set oeuvreLitt
     *
     * @param \NarratioWeb\OeuvresBundle\Entity\OeuvreLitt $oeuvreLitt
     * @return Livre
     */
    public function setOeuvreLitt(\NarratioWeb\OeuvresBundle\Entity\OeuvreLitt $oeuvreLitt = null)
    {
        $this->oeuvreLitt = $oeuvreLitt;
        return $this;
    }
    /**
     * Get oeuvreLitt
     *
     * @return \NarratioWeb\OeuvresBundle\Entity\OeuvreLitt 
     */
    public function getOeuvreLitt()
    {
        return $this->oeuvreLitt;
    }
}
