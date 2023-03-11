<?php

declare(strict_types=1);

namespace App\Common\DTO;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

final class UserRegistrationDTO implements UserDTOInterface
{
    #[Assert\NotBlank(groups: ["user-register-dto"]),
        Assert\Length(max: 255, groups: ["user-register-dto"]),
        Assert\Email(message: "registration.email", groups: ["user-register-dto"])]
    #[Groups(['user-register-dto'])]
    public string $email;

    #[Assert\NotBlank(groups: ["user-register-dto"]),
        Assert\Length(min: 6, max: 255, groups: ["user-register-dto"])]
    #[Groups(['user-register-dto'])]
    public ?string $plainPassword;

    #[Assert\NotBlank(groups: ["user-register-dto"]),
        Assert\Choice(choices: UserDTOInterface::USER_TYPES, groups: ["user-register-dto"])]
    #[Groups(['user-register-dto'])]
    public string $type;
}
