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
     * @var string
     *
     * @ORM\Column(name="resume", type="string")
     */
    private $resume;
    /**
     * @var string
     *
     * @ORM\Column(name="annee", type="string")
     */
    private $annee;
    /**
     * @ORM\ManyToMany(targetEntity="NarratioWeb\OeuvresBundle\Entity\Auteur")
     */
    private $auteur;
    
    /**
     * @ORM\ManyToOne(targetEntity="NarratioWeb\OeuvresBundle\Entity\Editeur")
     */
    private $editeur;

    /**
     * @ORM\ManyToOne(targetEntity="NarratioWeb\OeuvresBundle\Entity\Oeuvre")
     */
    private $oeuvre;
    
    /**
     * @ORM\OneToOne(targetEntity="NarratioWeb\OeuvresBundle\Entity\Image")
     */
    private $image;

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
     * Set resume
     *
     * @param string $resume
     * @return Oeuvre
     */
    public function setResume($resume)
    {
        $this->resume = $resume;
        return $this;
    }
    /**
     * Get resume
     *
     * @return string 
     */
    public function getResume()
    {
        return $this->resume;
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
     * Set oeuvre
     *
     * @param \NarratioWeb\OeuvresBundle\Entity\Oeuvre $oeuvre
     * @return Livre
     */
    public function setOeuvre(\NarratioWeb\OeuvresBundle\Entity\Oeuvre $oeuvre = null)
    {
        $this->oeuvre = $oeuvre;
        return $this;
    }
    /**
     * Get oeuvre
     *
     * @return \NarratioWeb\OeuvresBundle\Entity\Oeuvre 
     */
    public function getOeuvre()
    {
        return $this->oeuvre;
    }
    
    /**
     * Set image
     *
     * @param \NarratioWeb\OeuvresBundle\Entity\Image $image
     * @return Livre
     */
    public function setImage(\NarratioWeb\OeuvresBundle\Entity\Image $image = null)
    {
        $this->image = $image;
        return $this;
    }
    /**
     * Get image
     *
     * @return \NarratioWeb\OeuvresBundle\Entity\Image 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set annee
     *
     * @param string $annee
     * @return Livre
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * Get annee
     *
     * @return string 
     */
    public function getAnnee()
    {
        return $this->annee;
    }
}
