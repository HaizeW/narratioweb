<?php
namespace NarratioWeb\OeuvresBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Genre
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="NarratioWeb\OeuvresBundle\Entity\GenreRepository")
 */
class Genre
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
     * @ORM\Column(name="intitule", type="string", length=255)
     */
    private $intitule;
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
     * Set intitule
     *
     * @param string $intitule
     * @return Genre
     */
    public function setIntitule($intitule)
    {
        $this->intitule = $intitule;
        return $this;
    }
    /**
     * Get intitule
     *
     * @return string 
     */
    public function getIntitule()
    {
        return $this->intitule;
    }
    
    public function __toString()
    {
        return $this->intitule;
    }
}