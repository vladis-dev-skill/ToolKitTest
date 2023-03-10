<?php
declare(strict_types=1);

namespace App\Common\Controller\Registration;

use App\Common\DTO\UserRegistrationDTO;
use App\Common\From\UserRegisterForm;
use App\Common\Service\Facade\Registration\UserRegistrationFacadeInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use function PHPUnit\Framework\exactly;

#[Route(path: "/api", name: "api")]
class RegistrationController extends AbstractController
{
    public function __construct(
        private readonly LoggerInterface                 $logger,
        private readonly UserRegistrationFacadeInterface $registrationFacade)
    {
    }

    #[Route(path: "/register", name: ".register", methods: ["POST"])]
    public function index(Request $request, SerializerInterface $serializer, ValidatorInterface $validator): Response
    {
        $userDTO = $serializer->deserialize(
            $request->getContent(),
            UserRegistrationDTO::class,
            'json'
        );
        $errors = $validator->validate($userDTO);
        if (count($errors) > 0) {
            throw new BadRequestHttpException((string)$errors);
        }

        try {
            $this->registrationFacade->registerUser($userDTO);
            return $this->json(['message' => 'Registered Successfully']);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage(), ['exception' => $e]);
        }

        return $this->json(['message' => 'Registration failed!']);
    }

}