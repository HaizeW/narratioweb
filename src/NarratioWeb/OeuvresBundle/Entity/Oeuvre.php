<?php
namespace NarratioWeb\OeuvresBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * 
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="NarratioWeb\OeuvresBundle\Entity\OeuvreRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"oeuvre" = "Oeuvre", "oeuvrelitt" = "OeuvreLitt", "oeuvrecine" = "OeuvreCine"})
 * 
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
     * @var string
     *
     * @ORM\Column(name="resume", type="string", length=255)
     */
    private $resume;
    
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
}