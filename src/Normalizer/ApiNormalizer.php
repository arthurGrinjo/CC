<?php

namespace App\Normalizer;

use App\Dto\Response;
use ArrayObject;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[AsDecorator('api_platform.jsonld.normalizer.item')]
readonly class ApiNormalizer implements NormalizerInterface, SerializerAwareInterface
{
    public function __construct(
        private NormalizerInterface $normalizer,
    ) {
    }

    public function normalize($object, $format = null, array $context = []): float|array|ArrayObject|bool|int|string|null
    {
        dd('test');
        $this->normalizer->normalize($object, $format, $context);

        foreach ($data as $key => $value) {
            $obj = null;
            $func = 'get' . ucfirst($key);

            if (method_exists($object, $func)) {
                $obj = $object->$func();
            }

            /**
             * Rewrite "{entity}Response": "/api/{entity}/{entity}response/1ee9c2c9-2ea7-6770-8088-4f86a24e5a19",
             */
            if (is_string($value) && $obj instanceof Response) {
                unset($data[$key]);
                $methods = get_class_methods($obj);

                if (in_array('getId', $methods)) {
                    $data[$key]['@id'] = $this->rewriteIri($value);
                    $data[$key]['@type'] = str_replace('Response', '', ucfirst($key));
                }

                foreach (preg_grep('/^get/', $methods) as $method) {
                    $attribute = lcfirst(str_replace('get', '', $method));
                    $data[$key][$attribute] = $obj->$method();
                }
            }

            if (
                is_string($data[$key])
                && str_starts_with($key, '@')
                && str_starts_with($value, '/api/')
            ) {
                $data[$key] = $this->rewriteIri($value);
            }
        }

        foreach (preg_grep('/^get/', get_class_methods($object)) as $method) {
            $attribute = lcfirst(str_replace('get', '', $method));
            $value = $object->$method();

            if (!$value instanceof Response) {
                $data[$attribute] = $value;
            }
        }

        return $data;
    }

    private function rewriteIri(string $iri): string
    {
        return preg_replace('/^(\/\w*\/\w*\/)(\w*)\//i', '$1', $iri);
    }

    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        return $this->normalizer->supportsNormalization($data, $format);
    }

    public function setSerializer(SerializerInterface $serializer): void
    {
        if ($this->normalizer instanceof SerializerAwareInterface) {
            $this->normalizer->setSerializer($serializer);
        }
    }

    public function getSupportedTypes(?string $format): array
    {
        return [];
    }
}