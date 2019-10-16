<?php

declare(strict_types = 1);
namespace Habitissimo\MultiForm\Serializer;

class Serializer implements SerializerInterface
{
  private $secret_key;

  public function __construct(string $secret_key)
  {
    $this->secret_key = $secret_key;
  }

  public function serialize(array $data): array
  {
    $serialized = base64_encode(serialize($data));

    return [
      'value' => $serialized,
      'signature' => $this->hash($serialized),
    ];
  }

  public function deserialize(string $data, string $signature): array
  {
    if ($this->hash($data) !== $signature) {
      throw new SignatureNotMatchException('Signature does not match data"');
    }

    return unserialize(base64_decode($data));
  }

  private function hash(string $str): string
  {
    return hash_hmac('sha256', $str, $this->secret_key);
  }
}
