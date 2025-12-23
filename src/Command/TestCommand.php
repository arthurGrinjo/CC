<?php

declare(strict_types=1);

namespace App\Command;

use App\Dto\Event\Response\EventResponseDto;
use App\Dto\UserDto;
use App\Entity\Event;
use App\Entity\Location;
use DateTimeImmutable;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\ObjectMapper\ObjectMapper;

#[AsCommand(name: 'app:test')]
final readonly class TestCommand
{
    public function __invoke(OutputInterface $output): int
    {
//        $manager = new TestManager();
//        $manager->name = 'Manager Alice';
//        $manager->age = 21;
//        $user = new TestUser();
//        $user->name = 'User Bob';
//        $user->manager = $manager;
//
//        $mapper = new ObjectMapper();
//        $managerDto = $mapper->map($manager, ManagerDto::class);
//        $managerExtendedDto = $mapper->map($manager, ManagerExtendedDto::class);
//        $userDto = $mapper->map($user, UserDto::class);
//
//        $output->write("\033\143");
//        dump($manager);
//        $output->writeln('-----------');
//        dump($managerDto);
//        $output->writeln('-----------');
//        dump($managerExtendedDto);
//        $output->writeln('-----------');
//        dump($user, $userDto);

        $location = new Location();
        $location->name = 'Naampje';
        ;
        $event = new Event();
        $event->name = 'User Bob';
        $event->startDatetime = new DateTimeImmutable();
        $event->endDatetime = new DateTimeImmutable();
        $event->location = $location;

        $mapper = new ObjectMapper();
        $eventDto = $mapper->map($event, EventResponseDto::class);

        $output->write("\033\143");
        $output->writeln('-----------');
        dump($event, $eventDto);

        return Command::SUCCESS;
    }
}
