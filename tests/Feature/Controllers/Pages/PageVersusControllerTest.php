<?php

it('shows the versus page', function () {

    loginAsUser();

    $response = $this->get(route('versus'));

    $response->assertStatus(200);
    $response->assertViewIs('pages.versus');
});

