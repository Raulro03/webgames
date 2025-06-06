<?php


it('shows the characters page', function () {
    $response = $this->get(route('characters'));

    $response->assertStatus(200);
    $response->assertViewIs('pages.characters');
});
