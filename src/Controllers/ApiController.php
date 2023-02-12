<?php

declare(strict_types=1);

namespace Api\Controllers;

use Api\Controllers\HttpResponse;
use Api\Controllers\EmailSender;
use Dotenv\Dotenv;

class ApiController extends EmailSender
{
    use HttpResponse;
    protected string $email;
    private string $key;
    protected string $suject;

    public function __construct(string $email, string $key, $suject = null)
    {
        $this->email = $email;
        $this->key = $key;
        $this->subject = $suject;
    }
    public function proccess(): string
    {
        if (!$this->validMail()) {
            http_response_code(400);
            return $this->error([], 'Enter A Valid Email');
            exit();
        }
        if (!$this->checkApi()) {
            http_response_code(401);
            return $this->error([], 'Invalid Api Key!');

            exit();
        }
        return $this->sendEmail($this->email, $this->subject);
    }
    private function validMail(): bool
    {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }
    private function checkApi()
    {
        $dotenv = Dotenv::createImmutable('../');
        $dotenv->load();

        if ($this->key !== $_ENV['API_KEY']) {
            return false;
        }
        return true;
    }
}
