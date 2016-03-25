<?php
namespace NarratioWeb\OeuvresBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
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
     * @Assert\Url()
     */
    private $url;
    
    /**
     * @ORM\OneToOne(targetEntity="NarratioWeb\OeuvresBundle\Entity\Oeuvre")
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
    
    public function __toString()
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
}
