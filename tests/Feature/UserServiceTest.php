<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\UserService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserServiceTest extends TestCase
{
    private UserService $userService;

    protected function setUp():void
    {
        parent::setUp();

        $this->userService = $this->app->make(UserService::class);
    }

    public function testLoginSuccess()
    {
        self::assertTrue($this->userService->login("aminrais", "secret"));
    }
    
    public function testLoginUserNotFound()
    {
        self::assertFalse($this->userService->login("haha", "haha"));
    }

    public function testLoginWrongPassword(){
        self::assertFalse($this->userService->login("aminrais", "gatau"));
    }
}
