<?php

it('shows the platform page', function () {
    $response = $this->get(route('platforms'));

    $response->assertStatus(200);
    $response->assertViewIs('pages.platforms');
});
