<?php

declare(strict_types=1);

namespace App\Entity;

use App\Domain\Exception\AttendeeAlreadyAttendsOtherWorkshopOnThatDateException;
use App\Domain\Exception\AttendeeLimitReachedException;
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
    private string $name;

    #[ORM\Column(type: 'string', length: 255)]
    private string $email;

    #[ORM\ManyToMany(targetEntity: Workshop::class, inversedBy: 'attendees')]
    private Collection $workshops;

    public function __construct(string $identifier, string $firstname, string $lastname, string $name, string $email)
    {
        if ((!empty($firstname) || !empty($lastname)) && empty($name)) {
            @trigger_error('Passing values for argument "$firstname" or "$lastname" is deprecated. Pass a value for argument "$name" instead.', E_USER_DEPRECATED);
        }

        Assert::uuid($identifier, 'Argument $identifier is not a valid UUID: %s');

        if ((empty($firstname) || empty($lastname)) && empty($name)) {
            throw new \InvalidArgumentException('Passing values for argument "$firstname" and "$lastname" is deprecated. Pass a value for argument "$name" instead.');
        }

        Assert::email($email);

        $this->identifier = Uuid::fromString($identifier);
        $this->firstname = $firstname;
        $this->lastname = $lastname;

        $this->name = empty($name) ? $firstname.' '.$lastname : $name;

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
        @trigger_error('Calling Attendee::getFirstname() is deprecated. Use Attendee::getName()', E_USER_DEPRECATED);

        return $this->firstname;
    }

    public function getLastname(): string
    {
        @trigger_error('Calling Attendee::getLastname() is deprecated. Use Attendee::getName()', E_USER_DEPRECATED);

        return $this->lastname;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
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
        if ($this->workshops->contains($workshop)) {
            return $this;
        }

        if (!$this->canAttend($workshop)) {
            throw new AttendeeAlreadyAttendsOtherWorkshopOnThatDateException();
        }

        if (25 <= count($workshop->getAttendees())) {
            throw new AttendeeLimitReachedException();
        }

        $this->workshops[] = $workshop;

        return $this;
    }

    public function removeWorkshop(Workshop $workshop): self
    {
        if ($this->workshops->contains($workshop)) {
            $this->workshops->removeElement($workshop);
        }

        return $this;
    }

    public function updateFirstname(string $firstname)
    {
        @trigger_error('Calling Attendee::updateFirstname() is deprecated. Use Attendee::updateName()', E_USER_DEPRECATED);

        $this->firstname = $firstname;
    }

    public function updateLastname(string $lastname)
    {
        @trigger_error('Calling Attendee::updateLastname() is deprecated. Use Attendee::updateName()', E_USER_DEPRECATED);

        $this->lastname = $lastname;
    }

    public function updateName(string $name)
    {
        $this->name = $name;
    }

    public function updateEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * Every Attendee can only attend one workshop per day.
     */
    public function canAttend(Workshop $workshop): bool
    {
        foreach ($this->getWorkshops() as $attendeeWorkshop) {
            if ($workshop->getWorkshopDate()->getTimestamp() === $attendeeWorkshop->getWorkshopDate()->getTimestamp()) {
                return false;
            }
        }

        return true;
    }
}
