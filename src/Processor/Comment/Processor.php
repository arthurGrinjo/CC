<?php

declare(strict_types=1);

namespace App\Processor\Comment;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Post;
use App\Dto\Comment\Request\CommentRequestDto;
use App\Dto\Comment\Response\CommentResponseDto;
use App\Dto\ResponseDto;
use App\Entity\Chat;
use App\Entity\Comment;
use App\Entity\EntityInterface;
use App\Entity\Extension\Commentable;
use App\Entity\Trait\IdentifiableEntity;
use App\Entity\User;
use App\Mapper\Mapper;
use App\Processor\Validator;
use Doctrine\ORM\EntityManagerInterface;
use ReflectionException;
use RuntimeException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class Processor extends Validator
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private Mapper $mapper,
        protected ValidatorInterface $validator,
    ) {
        parent::__construct($validator);
    }

    /**
     * @param CommentRequestDto $data
     * @throws ReflectionException
     */
    public function process(mixed $data, Operation $operation): ResponseDto
    {
        $entityClass = ($operation->getStateOptions() instanceof Options)
            ? $operation->getStateOptions()->getEntityClass()
            : throw new RuntimeException('Provider: No entity class defined.')
        ;

        if (!is_string($entityClass) || !class_exists($entityClass)) {
            throw new RuntimeException('Provider: Not a valid EntityClass.');
        }

        if (!$operation instanceof Post) {
            throw new RuntimeException(sprintf('Operation not allowed: %s', $operation->getName()));
        }

        $this->validateDto($data);

        /** todo: Prevent from reposting comments within certain time.  */

        $entity = $this->mapper->getObjectFromIri($data->entity);
        $user = $this->mapper->getObjectFromIri($data->user);

        if (
            !$entity instanceof Commentable
            || !method_exists($entity, 'getId')
            || !is_int($entity->getId())
            || !$user instanceof User
        ) {
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
