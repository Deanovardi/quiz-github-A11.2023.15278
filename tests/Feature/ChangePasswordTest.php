<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ChangePasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_change_their_own_password(): void
    {
        $user = $this->makeUser();

        $response = $this->actingAs($user)->put(route('profile.password.update'), [
            'current_password' => 'password-lama',
            'password' => 'password-baru-123',
            'password_confirmation' => 'password-baru-123',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('success');
        $this->assertTrue(Hash::check('password-baru-123', $user->fresh()->password));
        $this->assertFalse(Hash::check('password-lama', $user->fresh()->password));
        $this->assertGuest();

        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Password berhasil diganti. Silakan login kembali.');

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password-baru-123',
        ])->assertRedirect(route('pasien.dashboard'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_wrong_old_password_is_rejected(): void
    {
        $user = $this->makeUser();

        $response = $this->actingAs($user)->from(route('profile.password.edit'))
            ->put(route('profile.password.update'), [
                'current_password' => 'password-salah',
                'password' => 'password-baru-123',
                'password_confirmation' => 'password-baru-123',
            ]);

        $response->assertRedirect(route('profile.password.edit'));
        $response->assertSessionHasErrors('current_password');
        $this->assertTrue(Hash::check('password-lama', $user->fresh()->password));
    }

    public function test_new_password_must_be_different_and_confirmed(): void
    {
        $user = $this->makeUser();

        $response = $this->actingAs($user)->from(route('profile.password.edit'))
            ->put(route('profile.password.update'), [
                'current_password' => 'password-lama',
                'password' => 'password-lama',
                'password_confirmation' => 'tidak-sama',
            ]);

        $response->assertRedirect(route('profile.password.edit'));
        $response->assertSessionHasErrors('password');
        $this->assertTrue(Hash::check('password-lama', $user->fresh()->password));
    }

    private function makeUser(): User
    {
        return User::create([
            'nama' => 'Test User',
            'email' => uniqid('user-', true) . '@example.test',
            'role' => 'pasien',
            'password' => Hash::make('password-lama'),
        ]);
    }

    public function test_password_page_requires_authentication(): void
    {
        $this->get(route('profile.password.edit'))
            ->assertRedirect(route('login'));
    }
}