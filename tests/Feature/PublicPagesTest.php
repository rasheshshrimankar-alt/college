<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_render_without_database_records(): void
    {
        foreach ([
            '/', '/about', '/principal', '/vision-mission', '/departments',
            '/courses', '/faculty', '/admissions', '/notices', '/news',
            '/events', '/gallery', '/facilities', '/library',
            '/scholarships', '/placements', '/contact',
        ] as $path) {
            $this->get($path)->assertOk();
        }
    }
}
