<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AttendeeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Webmozart\Assert\Assert;

#[ORM\Entity(repositoryClass: AttendeeRepository::class)]
class Attendee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'uuid', unique: true)]
    private UuidInterface $identifier;

    #[ORM\Column(type: 'string', length: 255)]
    private string $firstname;

    #[ORM\Column(type: 'string', length: 255)]
    private string $lastname;

    #[ORM\Column(type: 'string', length: 255)]
    private string $email;

    #[ORM\ManyToMany(targetEntity: Workshop::class, inversedBy: 'attendees')]
    private Collection $workshops;

    public function __construct(string $identifier, string $firstname, string $lastname, string $email)
    {
        Assert::uuid($identifier, 'Argument $identifier is not a valid UUID: %s');
        Assert::email($email);

        $this->identifier = Uuid::fromString($identifier);
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;

        $this->workshops = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdentifier(): string
    {
        return $this->identifier->toString();
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function changeFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function changeLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function changeEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Workshop[]
     */
    public function getWorkshops(): array
    {
        return $this->workshops->toArray();
    }

    public function addWorkshop(Workshop $workshop): self
    {
        if (!$this->workshops->contains($workshop)) {
            $this->workshops[] = $workshop;
        }

        return $this;
    }

    public function removeWorkshop(Workshop $workshop): self
    {
        if ($this->workshops->contains($workshop)) {
            $this->workshops->removeElement($workshop);
        }

        return $this;
    }
}
