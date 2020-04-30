<?php

namespace Feature\Api\Validation;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use jsamhall\ShipEngine\Address\Address;
use jsamhall\ShipEngine\Address\ArrayFormatter;
use jsamhall\ShipEngine\ShipEngine;
use jsamhall\ShipEngine\Address\Factory as AddressFactory;
use jsamhall\ShipEngine\Exception;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class AddressTest extends \PHPUnit_Framework_TestCase
{

    public function testValidateAddress()
    {
        $address = new Address();
        $address->setAddressLine1("525 S WINCHESTER BLVD")
            ->setCityLocality("San Jose")
            ->setStateProvince("CA")
            ->setPostalCode("95128")
            ->setCountryCode("US")
            ->setAddressResidentialIndicator("unknown");
        $addressResponse = [
            [
                "status" => "verified",
                "original_address" => [
                    "name"                          => null,
                    "phone"                         => null,
                    "company_name"                  => null,
                    "address_line1"                 => "525 S Winchester Blvd",
                    "address_line2"                 => null,
                    "address_line3"                 => null,
                    "city_locality"                 => "San Jose",
                    "state_province"                => "CA",
                    "postal_code"                   => "95128",
                    "country_code"                  => "US",
                    "address_residential_indicator" => "unknown"
                ],
                "matched_address" => [
                    "name"                          => null,
                    "phone"                         => null,
                    "company_name"                  => null,
                    "address_line1"                 => "525 S WINCHESTER BLVD",
                    "address_line2"                 => "",
                    "address_line3"                 => null,
                    "city_locality"                 => "SAN JOSE",
                    "state_province"                => "CA",
                    "postal_code"                   => "95128-2537",
                    "country_code"                  => "US",
                    "address_residential_indicator" => "no"
                ],
                "messages" => []
            ]
        ];
        $mock = new MockHandler([new Response(200, [], json_encode($addressResponse))]);
        $mockStack = HandlerStack::create($mock);
        $mockOptions = ['handler' => $mockStack];

        $addressFormatter = new ArrayFormatter();

        $shipEngineAddress = new ShipEngine("API_KEY_HERE", $addressFormatter, $mockOptions);

        $response = $shipEngineAddress->validateAddress($address);

        $this->assertSame($address->getAddressLine1(), $response->getMatchedAddress()->getAddressLine1());
    }
}
