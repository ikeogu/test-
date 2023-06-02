<?php

it('has blog/updateblog page', function () {
    $response = $this->get('/blog/updateblog');

    $response->assertStatus(200);
});
