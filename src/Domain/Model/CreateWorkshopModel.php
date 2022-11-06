<?php

declare(strict_types=1);

namespace App\Domain\Model;

use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\NotBlank;

final class CreateWorkshopModel
{
    #[NotBlank]
    public string $title;

    #[NotBlank]
    #[Date]
    public string $workshopDate;
}
