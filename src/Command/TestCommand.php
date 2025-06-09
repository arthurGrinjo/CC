<?php

namespace App\Command;

use App\Dto\Participant\Response\ParticipantResponse;
use App\Repository\ParticipantRepository;
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
        private readonly ParticipantRepository $participantRepository,
        ?string $name = null,
    ) {
        parent::__construct($name);
    }

    public function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $participant = $this->participantRepository->findAll()[0];

        $mapper = new ObjectMapper(propertyAccessor: new PropertyAccessor());
        $mapper->map($participant, ParticipantResponse::class);

        return Command::SUCCESS;
    }
}