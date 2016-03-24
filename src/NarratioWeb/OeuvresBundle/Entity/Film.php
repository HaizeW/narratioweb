<?php
namespace NarratioWeb\OeuvresBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Film
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="NarratioWeb\OeuvresBundle\Entity\FilmRepository")
 */
class Film
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
     * @var integer
     *
     * @ORM\Column(name="duree", type="integer")
     */
    private $duree;
    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;
    
    /**
     * @var text
     *
     * @ORM\Column(name="synopsis", type="text")
     */
    private $synopsis;
    
    /**
     * @var string
     *
     * @ORM\Column(name="annee", type="string")
     */
    private $annee;
    
    /**
     * @ORM\ManyToOne(targetEntity="NarratioWeb\OeuvresBundle\Entity\Type")
     */
    private $type;
    
    /**
     * @ORM\ManyToOne(targetEntity="NarratioWeb\OeuvresBundle\Entity\Realisateur")
     */
    private $realisateur;
    
    /**
     * @ORM\ManyToMany(targetEntity="NarratioWeb\OeuvresBundle\Entity\Acteur", cascade={"persist"})
     */
    private $acteurs;

    /**
     * @ORM\ManyToOne(targetEntity="NarratioWeb\OeuvresBundle\Entity\Oeuvre")
     */
    private $oeuvre;
    
    /**
     * @ORM\OneToOne(targetEntity="NarratioWeb\OeuvresBundle\Entity\Image")
     */
    private $imageFilm;

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
     * Set duree
     *
     * @param integer $duree
     * @return Film
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;
        return $this;
    }
    /**
     * Get duree
     *
     * @return integer 
     */
    public function getDuree()
    {
        return $this->duree;
    }
    /**
     * Set titre
     *
     * @param string $titre
     * @return Film
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
     * Set synopsis
     *
     * @param string $synopsis
     * @return Oeuvre
     */
    public function setSynopsis($synopsis)
    {
        $this->synopsis = $synopsis;
        return $this;
    }
    /**
     * Get synopsis
     *
     * @return string 
     */
    public function getSynopsis()
    {
        return $this->synopsis;
    }
    /**
     * Set type
     *
     * @param \NarratioWeb\OeuvresBundle\Entity\Type $type
     * @return Film
     */
    public function setType(\NarratioWeb\OeuvresBundle\Entity\Type $type = null)
    {
        $this->type = $type;
        return $this;
    }
    /**
     * Get type
     *
     * @return \NarratioWeb\OeuvresBundle\Entity\Type 
     */
    public function getType()
    {
        return $this->type;
    }
    /**
     * Set realisateur
     *
     * @param \NarratioWeb\OeuvresBundle\Entity\Realisateur $realisateur
     * @return Film
     */
    public function setRealisateur(\NarratioWeb\OeuvresBundle\Entity\Realisateur $realisateur = null)
    {
        $this->realisateur = $realisateur;
        return $this;
    }
    /**
     * Get realisateur
     *
     * @return \NarratioWeb\OeuvresBundle\Entity\Realisateur 
     */
    public function getRealisateur()
    {
        return $this->realisateur;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->acteurs = new \Doctrine\Common\Collections\ArrayCollection();
    }
    /**
     * Add acteurs
     *
     * @param \NarratioWeb\OeuvresBundle\Entity\Acteur $acteurs
     * @return Film
     */
    public function addActeur(\NarratioWeb\OeuvresBundle\Entity\Acteur $acteurs)
    {
        $this->acteurs[] = $acteurs;
        return $this;
    }
    /**
     * Remove acteurs
     *
     * @param \NarratioWeb\OeuvresBundle\Entity\Acteur $acteurs
     */
    public function removeActeur(\NarratioWeb\OeuvresBundle\Entity\Acteur $acteurs)
    {
        $this->acteurs->removeElement($acteurs);
    }
    /**
     * Get acteurs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getActeurs()
    {
        return $this->acteurs;
    }
   
     /**
     * Set oeuvre
     *
     * @param \NarratioWeb\OeuvresBundle\Entity\Oeuvre $oeuvre
     * @return Film
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
     * Set imageFilm
     *
     * @param \NarratioWeb\OeuvresBundle\Entity\Image $imageFilm
     * @return Film
     */
    public function setImagefilm(\NarratioWeb\OeuvresBundle\Entity\Image $imageFilm = null)
    {
        $this->imageFilm = $imageFilm;
        return $this;
    }
    /**
     * Get imageFilm
     *
     * @return \NarratioWeb\OeuvresBundle\Entity\Image 
     */
    public function getImageFilm()
    {
        return $this->imageFilm;
    }

    /**
     * Set annee
     *
     * @param string $annee
     * @return Film
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
