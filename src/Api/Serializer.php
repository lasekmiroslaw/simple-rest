<?php

namespace App\Api;

use JMS\Serializer\SerializerBuilder;

class Serializer
{
    public function serialize($data, $form = 'json')
    {
        $serializer = \JMS\Serializer\SerializerBuilder::create()
          ->build();

        return $serializer->serialize($data, $form);
    }
}
