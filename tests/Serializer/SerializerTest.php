<?php

declare(strict_types = 1);

namespace Habitissimo\MultiFormTest\Serializer;

use Habitissimo\MultiForm\Serializer\Serializer;
use Habitissimo\MultiForm\Serializer\SignatureNotMatchException;
use PHPUnit\Framework\TestCase;

class SerializerTest extends TestCase
{
  private $serializer;

  protected function setUp()
  {
    $this->serializer = new Serializer('secret_key');
  }

  public function test_serialize_data()
  {
    $serialize_data = $this->serializer->serialize(['key' => 'value']);

    $this->assertIsArray($serialize_data);
    $this->assertArrayHasKey('value', $serialize_data);
    $this->assertArrayHasKey('signature', $serialize_data);

    return $serialize_data;
  }

  /**
   * @depends test_serialize_data
   *
   * @param array $serialize_data
   */
  public function test_deserialize_data(array $serialize_data)
  {
    $deserialize_data = $this->serializer->deserialize(
      $serialize_data['value'], $serialize_data['signature']
    );

    $this->assertIsArray($deserialize_data);
    $this->assertArrayHasKey('key', $deserialize_data);
    $this->assertEquals('value', $deserialize_data['key']);
  }

  public function test_signature_not_match()
  {
    $this->expectException(SignatureNotMatchException::class);
    $this->serializer->deserialize('ex_value', 'ex_signature');
  }
}
