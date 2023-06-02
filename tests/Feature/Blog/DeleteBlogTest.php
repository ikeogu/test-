<?php

it('has blog/deleteblog page', function () {
    $response = $this->get('/blog/deleteblog');

    $response->assertStatus(200);
});
