<?php

it('has blog/fetchblog page', function () {
    $response = $this->get('/blog/fetchblog');

    $response->assertStatus(200);
});
