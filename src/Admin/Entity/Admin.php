<?php

declare(strict_types=1);

namespace App\Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Common\Entity\User;

#[ORM\Entity]
class Admin extends User
{
}
