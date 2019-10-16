<?php

declare(strict_types = 1);
namespace Habitissimo\MultiForm\Serializer;

interface SerializerInterface
{
  public function __construct(string $secret_key);

  public function serialize(array $data): array;

  public function deserialize(string $data, string $signature): array;
}
