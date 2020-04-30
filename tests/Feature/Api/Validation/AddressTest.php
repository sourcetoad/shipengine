<?php

namespace Feature\Api\Validation;

use jsamhall\ShipEngine\Address\Address;
use Tests\Mocks\Validation\AddressMock;

class AddressTest extends \PHPUnit_Framework_TestCase
{

    public function testValidateAddress()
    {
        //Arrange
        $address = new Address();
        $address->setAddressLine1("525 S Winchester Blvd")
            ->setCityLocality("San Jose")
            ->setStateProvince("CA")
            ->setPostalCode("95128")
            ->setCountryCode("US")
            ->setAddressResidentialIndicator("unknown");
        $shipEngineMock = new AddressMock();

        $request = $shipEngineMock->mockValidationSuccess();

        //Act
        $response = $request->validateAddress($address);

        //Assert
        $this->assertSame(strtoupper($address->getAddressLine1()), $response->getMatchedAddress()->getAddressLine1());
        $this->assertSame(strtoupper($address->getCityLocality()), $response->getMatchedAddress()->getCityLocality());
    }
}
