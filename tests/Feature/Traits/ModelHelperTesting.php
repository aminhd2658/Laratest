<?php

namespace Tests\Feature\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

trait ModelHelperTesting
{

    abstract protected function model(): Model;

    public function testInsertData(): void
    {

        $model = $this->model();
        $table = $model->getTable();
        $data = $model::factory()->make()->toArray();

        if ($model instanceof User) $data['password'] = Hash::make(123456);

        $model::create($data);
        $this->assertDatabaseHas($table, $data);
    }
}
