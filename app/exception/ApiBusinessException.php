<?php

namespace app\exception;

class ApiBusinessException extends \RuntimeException
{
    public $message;

    public string|null $originalMessage;

    public $code;


    /**
     * @param string $message
     * @param string|null $originalMessage
     * @param int $code
     */
    public function __construct(string $message, string $originalMessage = null, $code = 500)
    {
        parent::__construct();

        $this->message = $message;
        $this->originalMessage = $originalMessage;
        $this->code = $code;
    }

    /**
     * @return string|null
     */
    public function getOriginalMessage(): string|null
    {
        return $this->originalMessage;
    }


}