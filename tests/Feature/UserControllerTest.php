<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testLoginPage() 
    {
        $this->get("/login")
            ->assertSeeText('Login');
    }

    public function testLoginPageForMember()
    {
        $this->withSession([
            "user" => "aminrais"
        ])->get('/login')
            ->assertRedirect('/');
    }

    public function testLoginSuccess()
    {
        $this->post("/login", [
            "user" => "aminrais",
            "password" => "secret"
        ])->assertRedirect("/")
        ->assertSessionHas("user", "aminrais");
    }

    public function testLoginForUserAlreadyLogin()
    {
        $this->withSession([
            "user" => "aminrais"
        ])->post('/login', [
            "user" => "aminrais",
            "password" => "secret"
        ])->assertRedirect('/');
    }

    public function testLoginValidationError()
    {
        $this->post('/login', [])
            ->assertSeeText("User or password is required");
    }

    public function testLoginFailed()
    {
        $this->post('/login', [
            "user" => "haha",
            "password" => "haha"
        ])->assertSeeText("User or password is wrong");
    }

    public function testLogout()
    {
        $this->withSession([
            "user" => "aminrais"
        ])->post('/logout')
            ->assertRedirect("/")
            ->assertSessionMissing("user");
    }

    public function testLogoutGuest()
    {
        $this->post('logout')
            ->assertRedirect('/');
    }
}
