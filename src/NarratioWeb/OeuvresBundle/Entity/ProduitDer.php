<?php
namespace NarratioWeb\OeuvresBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * ProduitDer
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="NarratioWeb\OeuvresBundle\Entity\ProduitDerRepository")
 */
class ProduitDer
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
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;
    
    /**
     * @ORM\ManyToMany(targetEntity="NarratioWeb\OeuvresBundle\Entity\Oeuvre")
     */
    private $oeuvre;
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
     * Set description
     *
     * @param string $description
     * @return ProduitDer
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->oeuvre = new \Doctrine\Common\Collections\ArrayCollection();
    }
    /**
     * Add oeuvre
     *
     * @param \NarratioWeb\OeuvresBundle\Entity\Oeuvre $oeuvre
     * @return ProduitDer
     */
    public function addOeuvre(\NarratioWeb\OeuvresBundle\Entity\Oeuvre $oeuvre)
    {
        $this->oeuvre[] = $oeuvre;
        return $this;
    }
    /**
     * Remove oeuvre
     *
     * @param \NarratioWeb\OeuvresBundle\Entity\Oeuvre $oeuvre
     */
    public function removeOeuvre(\NarratioWeb\OeuvresBundle\Entity\Oeuvre $oeuvre)
    {
        $this->oeuvre->removeElement($oeuvre);
    }
    /**
     * Get oeuvre
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOeuvre()
    {
        return $this->oeuvre;
    }
}