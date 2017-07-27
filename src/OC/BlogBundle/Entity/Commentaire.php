<?php

namespace OC\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Commentaire
 *
 * @ORM\Table(name="commentaire")
 * @ORM\Entity(repositoryClass="OC\BlogBundle\Repository\CommentaireRepository")
 */
class Commentaire
{
    const LICITE = 0;
    const SIGNALE = 1;
    const MODERE = 2;
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank(message="L'email ne devrait pas être vide.")
     * @Assert\Email(message = "L'email '{{ value }}' n'est pas un email valide.",
     *     checkMX = true)
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var string
     * @Assert\NotBlank(message="Le pseudo ne devrait pas être vide.")
     * @ORM\Column(name="pseudo", type="string", length=255)
     */
    private $pseudo;

    /**
     * @var string
     * @Assert\NotBlank(message="Le contenu du message ne devrait pas être vide.")
     * @ORM\Column(name="contenu", type="text")
     */
    private $contenu;

    /**
     * @var Episode
     *
     * @ORM\ManyToOne(targetEntity="OC\BlogBundle\Entity\Episode", inversedBy="commentaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $episode;
    
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationDateTime", type="datetime")
     */
    private $creation;

    /**
     * @var boolean
     *
     * @ORM\Column(name="signalement", type="boolean")
     */
    private $signalement;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="modere", type="boolean")
     */
    private $modere;
    
    public function __construct() {
        $this->creation=new \DateTime();
        $this->signalement=false;
        $this->modere=false;
    }
    
    
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
     * Set email
     *
     * @param string $email
     *
     * @return Commentaire
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set pseudo
     *
     * @param string $pseudo
     *
     * @return Commentaire
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * Get pseudo
     *
     * @return string
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Commentaire
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set episode
     *
     * @param \OC\BlogBundle\Entity\Episode $episode
     *
     * @return Commentaire
     */
    public function setEpisode(\OC\BlogBundle\Entity\Episode $episode = null)
    {
        $this->episode = $episode;

        return $this;
    }

    /**
     * Get episode
     *
     * @return \OC\BlogBundle\Entity\Episode
     */
    public function getEpisode()
    {
        return $this->episode;
    }

    

    /**
     * Set creation
     *
     * @param \DateTime $creation
     *
     * @return Commentaire
     */
    public function setCreation($creation)
    {
        $this->creation = $creation;

        return $this;
    }

    /**
     * Get creation
     *
     * @return \DateTime
     */
    public function getCreation()
    {
        return $this->creation;
    }
    
    

    /**
     * Set signalement
     *
     * @param boolean $signalement
     *
     * @return Commentaire
     */
    public function setSignalement($signalement)
    {
        $this->signalement = $signalement;

        return $this;
    }

    /**
     * Get signalement
     *
     * @return boolean
     */
    public function getSignalement()
    {
        return $this->signalement;
    }

    /**
     * Set modere
     *
     * @param boolean $modere
     *
     * @return Commentaire
     */
    public function setModere($modere)
    {
        $this->modere = $modere;

        return $this;
    }

    /**
     * Get modere
     *
     * @return boolean
     */
    public function getModere()
    {
        return $this->modere;
    }
}
