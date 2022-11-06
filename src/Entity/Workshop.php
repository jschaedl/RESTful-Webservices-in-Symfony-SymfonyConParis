<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\WorkshopRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation as Serializer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Webmozart\Assert\Assert;

#[ORM\Entity(repositoryClass: WorkshopRepository::class)]
class Workshop
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'uuid', unique: true)]
    private UuidInterface $identifier;

    #[ORM\Column(type: 'string', length: 255)]
    private string $title;

    #[ORM\Column(type: 'datetime_immutable', length: 255)]
    #[Serializer\Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
    // configuring the date format via AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER in the serializer context is also possible
    private \DateTimeImmutable $workshopDate;

    #[ORM\ManyToMany(targetEntity: Attendee::class, inversedBy: 'workshops')]
    private Collection $attendees;

    public function __construct(string $identifier, string $title, \DateTimeImmutable $workshopDate)
    {
        Assert::uuid($identifier, 'Argument $identifier is not a valid UUID: %s');

        $this->identifier = Uuid::fromString($identifier);
        $this->title = $title;
        $this->workshopDate = $workshopDate;

        $this->attendees = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdentifier(): string
    {
        return $this->identifier->toString();
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getWorkshopDate(): \DateTimeImmutable
    {
        return $this->workshopDate;
    }

    /**
     * @return Attendee[]
     */
    public function getAttendees(): array
    {
        return $this->attendees->toArray();
    }

    public function addAttendee(Attendee $attendee): self
    {
        if (!$this->attendees->contains($attendee)) {
            $this->attendees->add($attendee);
            $attendee->addWorkshop($this);
        }

        return $this;
    }

    public function removeAttendee(Attendee $attendee): self
    {
        if ($this->attendees->contains($attendee)) {
            $this->attendees->removeElement($attendee);
            $attendee->removeWorkshop($this);
        }

        return $this;
    }
}
