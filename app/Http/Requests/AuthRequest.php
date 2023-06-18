<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;

class AuthRequest extends Request
{
    public function name(): ?string
    {
        return $this->json('name') ?: $this->name;
    }

    public function email(): ?string
    {
        return $this->json('email') ?: $this->email;
    }

    public function password(): ?string
    {
        return $this->json('password') ?: $this->password;
    }
}
