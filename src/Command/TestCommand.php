<?php

declare(strict_types=1);

namespace App\Command;

use App\Dto\Participant\Response\ParticipantResponseDto;
use App\Dto\User\Request\RequestDto;
use App\Mapper\Mapper;
use App\Repository\ParticipantRepository;
use App\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\ObjectMapper\ObjectMapper;
use Symfony\Component\PropertyAccess\PropertyAccessor;

#[AsCommand(
    name: 'app:test',
    description: 'Test.',
    hidden: false
)]
class TestCommand extends Command
{
    public function __construct(
        private readonly Mapper $mapper,
        private readonly ParticipantRepository $participantRepository,
        private readonly UserRepository $userRepository,
        ?string $name = null,
    ) {
        parent::__construct($name);
    }

    public function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $participant = $this->participantRepository->findAll()[0];

        // test to convert entity to ResponseDto
//        $mapper = new ObjectMapper(propertyAccessor: new PropertyAccessor());
//        $mapper->map($participant, ParticipantResponseDto::class);

        // test to update entity with RequestDto
        $user = $this->userRepository->findAll()[0];

        $userRequestDto = (new RequestDto());
        $userRequestDto->email = 'test@grinjo.nl';
        $userRequestDto->password = 'test123';
        $userRequestDto->firstName = 'Henk';
        $userRequestDto->lastName = 'Janssen';


        $andereMapper = new ObjectMapper();

        dump($user);

//        $mapper->map($userRequestDto, $user);

        $this->mapper->mergeDtoIntoEntity($user, $userRequestDto);

        dump($user);

        return Command::SUCCESS;
    }
}
