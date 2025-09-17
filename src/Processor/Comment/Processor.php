<?php

declare(strict_types=1);

namespace App\Processor\Comment;

use ApiPlatform\Doctrine\Common\State\RemoveProcessor;
use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Post;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\Comment\Response\CommentResponseDto;
use App\Dto\RequestDto;
use App\Dto\ResponseDto;
use App\Entity\Chat;
use App\Entity\Comment;
use App\Entity\EntityInterface;
use App\Entity\Extension\Commentable;
use App\Entity\User;
use App\Mapper\Mapper;
use App\Processor\Validator;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Repository\Exception\InvalidMagicMethodCall;
use ReflectionException;
use RuntimeException;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @template T1
 * @template T2
 *
 * @implements ProcessorInterface<T1, T2>
 */
readonly class Processor extends Validator implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private Mapper $mapper,
        protected ValidatorInterface $validator,
    ) {
        parent::__construct($validator);
    }

    /**
     * @inheritDoc
     * @throws RuntimeException
     * @throws ReflectionException
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): ResponseDto|int
    {
        $entityClass = ($operation->getStateOptions() instanceof Options)
            ? $operation->getStateOptions()->getEntityClass()
            : throw new RuntimeException('Provider: No entity class defined.')
        ;

        if (!is_string($entityClass) || !class_exists($entityClass)) {
            throw new RuntimeException('Provider: Not a valid EntityClass.');
        }

        if (!$operation instanceof Post && $data instanceof RequestDto) {
            throw new RuntimeException(sprintf('Operation not allowed: %s', $operation->getName()));
        }

        $this->validateDto($data);

        $entity = $this->mapper->getObjectFromIri($data->entity);
        $user = $this->mapper->getObjectFromIri($data->user);

        if (!$entity instanceof Commentable || !$user instanceof User) {
            throw new RuntimeException('error!');
        }

        $chat = $entity->getChat() ?: (new Chat())
            ->setEntity(get_class($entity))
            ->setEntityId($entity->getId())
        ;
        $this->entityManager->persist($chat);

        $entity->setChat($chat);
        $this->entityManager->persist($entity);

        $comment = (new Comment)
            ->setComment($data->comment)
            ->setChat($chat)
            ->setUser($user)
        ;
        $this->entityManager->persist($comment);

        /** Save chat, comment, commented entity */
        $this->entityManager->flush();

        return $this->mapper->entityToDto(
            entity: $comment,
            target: CommentResponseDto::class,
        );
    }
}
