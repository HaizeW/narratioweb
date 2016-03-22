<?php
namespace NarratioWeb\OeuvresBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Note
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="NarratioWeb\OeuvresBundle\Entity\NoteRepository")
 */
class Note
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
     * @ORM\Column(name="valeur", type="integer")
     */
    private $valeur;
    
    /**
     * @ORM\ManyToOne(targetEntity="NarratioWeb\OeuvresBundle\Entity\Oeuvre")
     */
    private $oeuvre;
    
    /**
     * @ORM\OneToOne(targetEntity="NarratioWeb\UserBundle\Entity\User")
     */
    private $utilisateur;
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
     * Set valeur
     *
     * @param integer $valeur
     * @return Note
     */
    public function setValeur($valeur)
    {
        $this->valeur = $valeur;
        return $this;
    }
    /**
     * Get valeur
     *
     * @return integer 
     */
    public function getValeur()
    {
        return $this->valeur;
    }
    /**
     * Set oeuvre
     *
     * @param \NarratioWeb\OeuvresBundle\Entity\Oeuvre $oeuvre
     * @return Note
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