<?php
/**
 * Created by PhpStorm.
 * User: shyandsy
 * Date: 2/17/2019
 * Time: 11:19 AM
 */

namespace Shy\Exception;


class ExceptionBase extends \Exception{
    public function __construct($message, $code = 0, Exception $previous = null) {
        // some code

        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }

    // custom string representation of object
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}