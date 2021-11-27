<?php

declare(strict_types=1);

namespace App\Domain\Model;

use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\NotBlank;

final class UpdateWorkshopModel
{
    #[NotBlank(allowNull: true)]
    public ?string $title = null;

    #[NotBlank(allowNull: true)]
    #[Date]
    public ?string $workshopDate = null;
}
