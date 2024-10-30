<?php

namespace Tests\Feature;

use App\Models\Click;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\Exception;
use Tests\TestCase;

class ClickFieldsTest extends TestCase
{
    public function testInsertData()
    {

        $data = [
            'binom_click_id' => 'b3cb1bzg52tfvfe804',
            'affise_click_id' => 'test',
            'req_id' => '456787068',
            'cid' => 967,
            'aff_click_id' => '5fdb6h9a2y9b4039f',
            'aff_id' => null,
            'subid1' => 'empty',
            'subid2' => '2fd236h9a2y32b4039f',
            'subid3' => 'test',
            'is_charged' => true,
            'id_main' => '1',
        ];
        try {
            Click::create($data);

        } catch (Exception $e) {
            var_dump($e->getMessage());
        }

        $this->assertDatabaseHas('clicks', $data);
    }
}
