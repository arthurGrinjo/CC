<?php

declare(strict_types=1);

namespace App\Processor\Comment;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Symfony\Routing\IriConverter;
use App\Dto\Comment\Request\CommentRequestDto;
use App\Dto\Comment\Response\CommentResponseDto;
use App\Dto\ResponseDto;
use App\Entity\Chat;
use App\Entity\Comment;
use App\Entity\Extension\Commentable;
use App\Entity\User;
use App\Processor\Validator;
use Doctrine\ORM\EntityManagerInterface;
use ReflectionException;
use RuntimeException;
use Symfony\Component\ObjectMapper\ObjectMapperInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class Processor extends Validator
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private IriConverter $iriConverter,
        private ObjectMapperInterface $objectMapper,
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

        $entity = $this->iriConverter->getResourceFromIri($data->entity);
        /** @var User $user */
        $user = $this->iriConverter->getResourceFromIri($data->user);

        if (
            $entity instanceof Commentable
            && method_exists($entity, 'getId')
            && is_int($entity->getId())
            && $user instanceof User
        ) {
            /** todo: Personalize this error!! */
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

        return $this->objectMapper->map(
            source: $comment,
            target: CommentResponseDto::class,
        );
    }
}
