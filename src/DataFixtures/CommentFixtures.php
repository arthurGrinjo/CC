<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\DataFixtures\Trait\Numbers;
use App\Factory\CommentFactory;
use App\Repository\ChatRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use function Zenstruck\Foundry\Persistence\repository;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    use Numbers;

    public function __construct(
        private readonly ChatRepository $chatRepository,
    ) {}

    public function load(ObjectManager $manager): void
    {
        $chats = $this->chatRepository->findAll();

        foreach($chats as $chat) {
            $obj = repository($chat->getEntity())->find($chat->getEntityId());

            if (!method_exists($obj, 'setChat')) {
                printf("\nError: Class %s does not extend the Commentable extension.\n\n", $chat->getEntity());
                exit;
            }

            $obj->setChat($chat);
            $manager->persist($obj);

            CommentFactory::createRange(
                self::COMMENTS['min'],
                self::COMMENTS['max'],
                ['chat' => $chat],
            );
        }
    }

    public function getDependencies(): array
    {
        return [
            ChatFixtures::class,
        ];
    }
}
