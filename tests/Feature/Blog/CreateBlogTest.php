<?php

use App\Models\Category;

it('user can create blog', function () {
    $user = actingAs();

    $category = Category::factory()->create();

    $data = [
        'title' => fake()->title(),
        'body' => fake()->sentence(),
        'author' => fake()->name(),
        'category_id' => $category->id
    ];

    $response = $this->postJson(route('blog-post.store',$data));
    $response->assertStatus(200);

    $this->assertDatabaseCount('categories',1);
    $this->assertDatabaseCount('blogs',1);
    $this->assertDatabaseHas('blogs',[
        'title' => $data['title'],
        'body' => $data['body'],
        'author' => $data['author'],
        'category_id' => $data['category_id']
    ]);

    expect($response['status'])->toBeTruthy();
    expect($response['message'])->toBe("Blog created successfully");


});
