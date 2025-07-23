<?php

declare(strict_types=1);

namespace App\Processor\Participant;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\Participant\Request\ParticipantRequestDto;
use App\Dto\Participant\Response\ParticipantResponseDto;
use App\Dto\ResponseDto;
use App\Entity\Participant;
use App\Mapper\Mapper;
use App\Processor\Validator;
use Doctrine\ORM\Repository\Exception\InvalidMagicMethodCall;
use ReflectionException;
use RuntimeException;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class CreateParticipant extends Validator implements ProcessorInterface
{
    public function __construct(
        private Mapper $mapper,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
        protected ValidatorInterface $validator,
    ) {
        parent::__construct($validator);
    }

    /**
     * @throws RuntimeException|ReflectionException
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): ResponseDto
    {
        if (!$data instanceof ParticipantRequestDto) {
            throw new RuntimeException("Invalid input.", Response::HTTP_BAD_REQUEST);
        }

        $this->validateDto($data);
        $participant = $this->mapper->merge(dto: $data, entity: new Participant());

        try {
            return $this->mapper->entityToDto(
                entity: $this->persistProcessor->process($participant, $operation, $uriVariables, $context),
                target: ParticipantResponseDto::class,
            );
        } catch (InvalidMagicMethodCall|ReflectionException) {
            throw new RuntimeException("Unable to generate response.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
