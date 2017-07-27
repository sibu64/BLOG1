<?php

namespace OC\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="OC\UserBundle\Repository\UserRepository")
 */
class User implements UserInterface {

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
     * @assert\Email( message = "L'email '{{ value }}' n'est pas un email valide.",
     *     checkMX = true)
     * @Assert\NotBlank(message="L'email ne peut pas être vide.")
     * @Assert\IsTrue(message = "L'email est invalide")
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var string
     * @SecurityAssert\UserPassword(
     *     message = "Mot de passe invalide")
     * @Assert\NotBlank(message="Le mot de passe ne peut pas être vide.")
     * @Assert\IsTrue(message = "Le mot de passe est invalide")
     * @ORM\Column(name="password", type="string", length=255, unique=true)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="jeton_reinitialisation", type="string", length=255, nullable=true)
     */
    private $jetonReinitialisation;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="reinitialisation_datetime", type="datetime", nullable=true)
     */
    private $reinitialisationDatetime;
    
    
    private $plainPassword;
    
    
    
    
    public function generateJetonReinitialisation(){
        $this->jetonReinitialisation= md5(random_bytes( 32));
        $this->reinitialisationDatetime= new \DateTime;
    }
    
    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password) {
        $this->password = $password;

        return $this;
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles() {
        return [];
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt() {
        return null;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername() {
        return $this->email;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials() {
        // TODO: Implement eraseCredentials() method.
    }



    /**
     * Set jetonReinitialisation
     *
     * @param string $jetonReinitialisation
     *
     * @return User
     */
    public function setJetonReinitialisation($jetonReinitialisation)
    {
        $this->jetonReinitialisation = $jetonReinitialisation;

        return $this;
    }

    /**
     * Get jetonReinitialisation
     *
     * @return string
     */
    public function getJetonReinitialisation()
    {
        return $this->jetonReinitialisation;
    }

    /**
     * Set reinitialisationDatetime
     *
     * @param \DateTime $reinitialisationDatetime
     *
     * @return User
     */
    public function setReinitialisationDatetime($reinitialisationDatetime)
    {
        $this->reinitialisationDatetime = $reinitialisationDatetime;

        return $this;
    }

    /**
     * Get reinitialisationDatetime
     *
     * @return \DateTime
     */
    public function getReinitialisationDatetime()
    {
        return $this->reinitialisationDatetime;
    }
    
    function getPlainPassword() {
        return $this->plainPassword;
    }

    function setPlainPassword($plainPassword) {
        $this->plainPassword = $plainPassword;
        return $this;
    }


}
