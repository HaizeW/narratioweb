<?php
namespace NarratioWeb\OeuvresBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Oeuvre
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="NarratioWeb\OeuvresBundle\Entity\OeuvreRepository")
 */
class Oeuvre
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
     * @var text
     *
     * @ORM\Column(name="concept", type="text")
     */
    private $concept;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="compteurVues", type="integer")
     */
    private $compteurVues;
    
    /**
     * @var text
     *
     * @ORM\Column(name="prodDer", type="text")
     */
    private $prodDer;
    
    /**
     * @ORM\ManyToOne(targetEntity="NarratioWeb\OeuvresBundle\Entity\Epoque")
     */
    private $epoque;
    
    /**
     * @ORM\ManyToOne(targetEntity="NarratioWeb\OeuvresBundle\Entity\Genre")
     */
    private $genre;
    
    /**
     * @ORM\ManyToOne(targetEntity="NarratioWeb\OeuvresBundle\Entity\Thematique")
     */
    private $thematique;
    
    /**
     * @ORM\ManyToOne(targetEntity="NarratioWeb\OeuvresBundle\Entity\TrancheAge")
     */
    private $trancheAge;
    
    /**
     * @ORM\OneToOne(targetEntity="NarratioWeb\OeuvresBundle\Entity\Image", cascade={"persist"})
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
     * Set nom
     *
     * @param string $nom
     * @return Oeuvre
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
     * Set concept
     *
     * @param string $concept
     * @return Oeuvre
     */
    public function setConcept($concept)
    {
        $this->concept = $concept;
        return $this;
    }
    /**
     * Get concept
     *
     * @return string 
     */
    public function getConcept()
    {
        return $this->concept;
    }
    /**
     * Set compteurVues
     *
     * @param integer $compteurVues
     * @return Oeuvre
     */
    public function setCompteurVues($compteurVues)
    {
        $this->compteurVues = $compteurVues;
        return $this;
    }
    /**
     * Get compteurVues
     *
     * @return integer 
     */
    public function getCompteurVues()
    {
        return $this->compteurVues;
    }
    /**
     * Set prodDer
     *
     * @param string $prodDer
     * @return Oeuvre
     */
    public function setProdDer($prodDer)
    {
        $this->prodDer = $prodDer;
        return $this;
    }
    
    /**
     * Get prodDer
     *
     * @return string 
     */
    public function getProdDer()
    {
        return $this->prodDer;
    }
    /**
     * Set epoque
     *
     * @param \NarratioWeb\OeuvresBundle\Entity\Epoque $epoque
     * @return Oeuvre
     */
    public function setEpoque(\NarratioWeb\OeuvresBundle\Entity\Epoque $epoque = null)
    {
        $this->epoque = $epoque;
        return $this;
    }
    /**
     * Get epoque
     *
     * @return \NarratioWeb\OeuvresBundle\Entity\Epoque 
     */
    public function getEpoque()
    {
        return $this->epoque;
    }
    /**
     * Set genre
     *
     * @param \NarratioWeb\OeuvresBundle\Entity\Genre $genre
     * @return Oeuvre
     */
    public function setGenre(\NarratioWeb\OeuvresBundle\Entity\Genre $genre = null)
    {
        $this->genre = $genre;
        return $this;
    }
    /**
     * Get genre
     *
     * @return \NarratioWeb\OeuvresBundle\Entity\Genre 
     */
    public function getGenre()
    {
        return $this->genre;
    }
    /**
     * Set thematique
     *
     * @param \NarratioWeb\OeuvresBundle\Entity\Thematique $thematique
     * @return Oeuvre
     */
    public function setThematique(\NarratioWeb\OeuvresBundle\Entity\Thematique $thematique = null)
    {
        $this->thematique = $thematique;
        return $this;
    }
    /**
     * Get thematique
     *
     * @return \NarratioWeb\OeuvresBundle\Entity\Thematique 
     */
    public function getThematique()
    {
        return $this->thematique;
    }
    /**
     * Set trancheAge
     *
     * @param \NarratioWeb\OeuvresBundle\Entity\TrancheAge $trancheAge
     * @return Oeuvre
     */
    public function setTrancheAge(\NarratioWeb\OeuvresBundle\Entity\TrancheAge $trancheAge = null)
    {
        $this->trancheAge = $trancheAge;
        return $this;
    }
    /**
     * Get trancheAge
     *
     * @return \NarratioWeb\OeuvresBundle\Entity\TrancheAge 
     */
    public function getTrancheAge()
    {
        return $this->trancheAge;
    }
    
    public function __toString()
    {
        return $this->nom;
    }

    /**
     * Set image
     *
     * @param \NarratioWeb\OeuvresBundle\Entity\Image $image
     * @return Oeuvre
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
}
