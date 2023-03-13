<?php
declare(strict_types=1);

namespace App\Fixtures;

use App\Admin\Entity\Admin;
use App\Claim\Entity\Claim;
use App\Client\Entity\Client;
use App\Common\Security\RolesInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{

    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }


    public function load(ObjectManager $manager)
    {
        $admin = new Admin();
        $admin->setEmail('admin@mail.com')
            ->setPassword($this->passwordHasher->hashPassword($admin, 'AdminAdmin'))
            ->addRole(RolesInterface::ROLE_ADMIN);

        $manager->persist($admin);

        $client = new Client();
        $client->setEmail('client@mail.com')
            ->setPassword($this->passwordHasher->hashPassword($admin, 'ClientClient'))
            ->addRole(RolesInterface::ROLE_CLIENT)
            ->setAddress('address for client')
            ->setPhoneNumber('232342323');

        for ($i = 0; $i < 5; $i++) {
            $claim = new Claim();
            $claim->setTitle("Claim #" . $i + 1)
                ->setDescription('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam aut cum dolorem ex exercitationem fugiat illum iste labore quasi vel.');

            $client->addClaim($claim);
        }

        $manager->persist($client);

        $manager->flush();
    }
}