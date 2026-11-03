<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class BookAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
        $this->seed(RolePermissionSeeder::class);
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    private function userWithRole(string $role): User
    {
        return User::role($role)->firstOrFail();
    }

    private function bookData(array $overrides = []): array
    {
        return array_merge([
            'title' => 'Pemrograman Web Lanjut',
            'author' => 'Penulis',
            'isbn' => '978-0000000001',
            'year' => 2026,
            'description' => 'Buku contoh.',
        ], $overrides);
    }

    public function test_guest_is_redirected_to_login_when_opening_books_page(): void
    {
        $this->get(route('books.index'))->assertRedirect(route('login'));
    }

    public function test_mahasiswa_can_view_books_but_cannot_manage_them(): void
    {
        $book = Book::create($this->bookData());
        $mahasiswa = $this->userWithRole('Mahasiswa');

        $this->actingAs($mahasiswa)->get(route('books.index'))->assertOk();
        $this->actingAs($mahasiswa)->get(route('books.show', $book))->assertOk();

        $this->actingAs($mahasiswa)->get(route('books.create'))->assertForbidden();
        $this->actingAs($mahasiswa)->post(route('books.store'), $this->bookData(['isbn' => '978-0000000002']))->assertForbidden();
        $this->actingAs($mahasiswa)->get(route('books.edit', $book))->assertForbidden();
        $this->actingAs($mahasiswa)->put(route('books.update', $book), $this->bookData(['title' => 'Diubah']))->assertForbidden();
        $this->actingAs($mahasiswa)->delete(route('books.destroy', $book))->assertForbidden();

        $this->assertDatabaseHas('books', ['id' => $book->id, 'title' => 'Pemrograman Web Lanjut']);
        $this->assertDatabaseCount('books', 1);
    }

    public function test_dosen_can_create_and_update_but_not_delete(): void
    {
        $dosen = $this->userWithRole('Dosen');

        $this->actingAs($dosen)->get(route('books.create'))->assertOk();
        $this->actingAs($dosen)->post(route('books.store'), $this->bookData())
            ->assertRedirect(route('books.index'));

        $book = Book::firstOrFail();

        $this->actingAs($dosen)->get(route('books.edit', $book))->assertOk();
        $this->actingAs($dosen)->put(route('books.update', $book), $this->bookData(['title' => 'Judul Baru']))
            ->assertRedirect(route('books.index'));

        $this->assertDatabaseHas('books', ['id' => $book->id, 'title' => 'Judul Baru']);

        $this->actingAs($dosen)->delete(route('books.destroy', $book))->assertForbidden();
        $this->assertDatabaseHas('books', ['id' => $book->id]);
    }

    public function test_admin_can_delete_books_and_manage_user_roles(): void
    {
        $book = Book::create($this->bookData());
        $admin = $this->userWithRole('Admin');
        $mahasiswa = $this->userWithRole('Mahasiswa');

        $this->actingAs($admin)->delete(route('books.destroy', $book))
            ->assertRedirect(route('books.index'));
        $this->assertDatabaseMissing('books', ['id' => $book->id]);

        $this->actingAs($admin)->get(route('users.index'))->assertOk();
        $this->actingAs($admin)->put(route('users.role.update', $mahasiswa), ['role' => 'Dosen'])
            ->assertRedirect(route('users.index'));

        $this->assertTrue($mahasiswa->fresh()->hasRole('Dosen'));
    }

    public function test_dosen_and_mahasiswa_cannot_manage_user_roles(): void
    {
        $this->actingAs($this->userWithRole('Dosen'))->get(route('users.index'))->assertForbidden();
        $this->actingAs($this->userWithRole('Mahasiswa'))->get(route('users.index'))->assertForbidden();
    }

    public function test_logout_ends_session_and_protected_pages_are_not_accessible(): void
    {
        $mahasiswa = $this->userWithRole('Mahasiswa');

        $this->actingAs($mahasiswa)->post(route('logout'))->assertRedirect('/');
        $this->assertGuest();

        $this->get(route('books.index'))->assertRedirect(route('login'));
    }
}
