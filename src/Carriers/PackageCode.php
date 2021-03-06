<?php
/**
 * ShipEngine API Wrapper
 *
 * This file is subject to the terms and conditions defined in
 * file 'LICENSE.txt', which is found in the root folder of
 * this source code package.
 *
 * @author    John Hall
 */

namespace jsamhall\ShipEngine\Carriers;

use jsamhall\ShipEngine;

class PackageCode
{
    /**
     * @var string
     */
    protected $code;

    /**
     * PackageCode constructor.
     *
     * @param string $code
     */
    public function __construct(string $code)
    {
        $this->code = $code;
    }

    public function __toString()
    {
        return $this->code;
    }

    public function equals(PackageCode $serviceCode)
    {
        return $serviceCode->__toString() === $this->__toString();
    }
}
