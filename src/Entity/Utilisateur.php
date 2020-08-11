<?php

namespace App\Entity;

use Serializable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Utilisateur
 *
 * @ORM\Table(name="utilisateur", uniqueConstraints={@ORM\UniqueConstraint(name="mail", columns={"mail"})})
 * @ORM\Entity
 */
class Utilisateur  implements UserInterface, Serializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="utilisateur_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $utilisateurId;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=100, nullable=false)
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="pass", type="string", length=255, nullable=false)
     */
    private $pass;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=200, nullable=true)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="surname", type="string", length=200, nullable=true)
     */
    private $surname;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status = '0';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="last_login", type="datetime", nullable=true)
     */
    private $lastLogin;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email_activation_key", type="string", length=200, nullable=true)
     */
    private $emailActivationKey;

    public function getRoles()
    {
        switch ($this->status) {
            case 10:
                return ["ROLE_MANAGER"];
                break;
            case 100:
                return ["ROLE_ADMIN"];
                break;
            case 5:
                return ["ROLE_FORMATEUR"];
                break;
            default:
                return ["ROLE_SIMPLE"];
                break;
        }
    }

    public function getPassword()
    {
        return $this->pass;
    }
    public function getUsername()
    {
        return $this->mail;
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
    }

    public function serialize()
    {
        return serialize(
            [
            $this->utilisateurId,
            $this->mail,
            $this->name,
            $this->surname,
            $this->pass
        ]
        );
    }
    public function unserialize($serialized)
    {
        list(
            $this->utilisateurId,
            $this->mail,
            $this->name,
            $this->surname,
            $this->pass
        ) = unserialize($serialized, ['allowed_classes' =>false]);
    }

    public function getUtilisateurId(): ?int
    {
        return $this->utilisateurId;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getPass(): ?string
    {
        return $this->pass;
    }

    public function setPass(string $pass): self
    {
        $this->pass = $pass;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(?string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getLastLogin(): ?\DateTimeInterface
    {
        return $this->lastLogin;
    }

    public function setLastLogin(?\DateTimeInterface $lastLogin): self
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    public function getEmailActivationKey(): ?string
    {
        return $this->emailActivationKey;
    }

    public function setEmailActivationKey(?string $emailActivationKey): self
    {
        $this->emailActivationKey = $emailActivationKey;

        return $this;
    }


}
