<?php
namespace NarratioWeb\OeuvresBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Image
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="NarratioWeb\OeuvresBundle\Entity\ImageRepository")
 */
class Image
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
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;
    
    /**
     * @ORM\OneToOne(targetEntity="NarratioWeb\OeuvresBundle\Entity\Oeuvre")
     */
    private $oeuvreLitt;
    
    /**
     * @ORM\OneToOne(targetEntity="NarratioWeb\OeuvresBundle\Entity\Oeuvre")
     */
    private $oeuvreCine;
    
    /**
     * @ORM\OneToOne(targetEntity="NarratioWeb\OeuvresBundle\Entity\ProduitDer")
     */
    private $produit;
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
     * Set url
     *
     * @param string $url
     * @return Image
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }
    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }
    /**
     * Set oeuvre
     *
     * @param \NarratioWeb\OeuvresBundle\Entity\Oeuvre $oeuvre
     * @return Image
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
     * Set produit
     *
     * @param \NarratioWeb\OeuvresBundle\Entity\ProduitDer $produit
     * @return Image
     */
    public function setProduit(\NarratioWeb\OeuvresBundle\Entity\ProduitDer $produit = null)
    {
        $this->produit = $produit;
        return $this;
    }
    /**
     * Get produit
     *
     * @return \NarratioWeb\OeuvresBundle\Entity\ProduitDer 
     */
    public function getProduit()
    {
        return $this->produit;
    }

    /**
     * Set oeuvreLitt
     *
     * @param \NarratioWeb\OeuvresBundle\Entity\Oeuvre $oeuvreLitt
     * @return Image
     */
    public function setOeuvreLitt(\NarratioWeb\OeuvresBundle\Entity\Oeuvre $oeuvreLitt = null)
    {
        $this->oeuvreLitt = $oeuvreLitt;

        return $this;
    }

    /**
     * Get oeuvreLitt
     *
     * @return \NarratioWeb\OeuvresBundle\Entity\Oeuvre 
     */
    public function getOeuvreLitt()
    {
        return $this->oeuvreLitt;
    }

    /**
     * Set oeuvreCine
     *
     * @param \NarratioWeb\OeuvresBundle\Entity\Oeuvre $oeuvreCine
     * @return Image
     */
    public function setOeuvreCine(\NarratioWeb\OeuvresBundle\Entity\Oeuvre $oeuvreCine = null)
    {
        $this->oeuvreCine = $oeuvreCine;

        return $this;
    }

    /**
     * Get oeuvreCine
     *
     * @return \NarratioWeb\OeuvresBundle\Entity\Oeuvre 
     */
    public function getOeuvreCine()
    {
        return $this->oeuvreCine;
    }
}
