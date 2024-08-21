<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Ad;

class AdTest extends TestCase
{
    public function testCreateAd()
    {
        $response = $this->postJson('/api/ads', [
            'title' => 'Test Ad',
            'description' => 'Test Description',
            'images' => ['http://example.com/image1.jpg'],
            'price' => 100,
        ]);

        $response->assertStatus(200)->assertJson(['status' => 'success']);
    }

    public function testGetAdList()
    {
        $response = $this->getJson('/api/ads');
        $response->assertStatus(200);
    }

    public function testGetAdDetail()
    {
        $ad = Ad::factory()->create();

        $response = $this->getJson('/api/ads/' . $ad->id);
        $response->assertStatus(200)->assertJson(['title' => $ad->title]);
    }
}
