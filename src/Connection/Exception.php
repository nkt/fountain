<?php


namespace Fountain\Connection;

/**
 * @author Nikita Gusakov <dev@nkt.me>
 */
class Exception extends \Exception
{
    public static function createFromPrevious(\Exception $e, $message = '', $code = 0)
    {
        return new static($message, $code, $e);
    }
}
