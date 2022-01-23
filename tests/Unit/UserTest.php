<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class UserTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testUsersCount()
    {
        factory(User::class)->create();
        factory(User::class)->create();
        factory(User::class)->create();

        $users = User::all();

        $this->assertCount(3, $users); //確認資料筆數
    }

    public function testUserEdit()
    {
        $create = factory(User::class)->create();
        $user = factory(User::class)->make();
        $response = $this->put(
            "/user/$create->id",
            [ 'User'  =>
                [
                    'name'=>$user['name'],
                    'language'=>$user['language']
                ]]
        );

        $response->assertStatus(200);
    }

    public function testUserStatus()
    {
        $create = factory(User::class)->create();
        $response = $this->put("/user/status/$create->id", []);

        $response->assertStatus(200);
    }

    public function testUserList()
    {
        $response = $this->get(route('users.list'));
        $response->assertStatus(200);
    }

    public function testUploadMugShot()
    {
        Storage::fake('local');
        $create = factory(User::class)->create();

        $response = $this->post(
            'user/image/' . $create->id,
            ['image' => UploadedFile::fake()->image('file.png')]
        )->decodeResponseJson();
        dd($response);
        Storage::disk('local')->assertExists("/Users/linhongmin/Desktop/myPHP/new-prop/public/upload/" . '/file.jpg');
    }
}
