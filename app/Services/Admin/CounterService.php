<?php

namespace App\Services\Admin;

use App\Models\Counter;
use Illuminate\Support\Facades\DB;
use Throwable;

class CounterService
{
    /**
     * Lấy dữ liệu Counter hiện tại.
     */
    public function getCounter(): ?Counter
    {
        return Counter::first();
    }

    /**
     * Cập nhật dữ liệu Counter.
     *
     * @param array $data
     * @throws Throwable
     */
    public function updateCounter(array $data): void
    {
        DB::transaction(function () use ($data) {
            Counter::updateOrCreate(
                ['id' => 1],
                [
                    'counter_one'   => $data['counter_one'],
                    'title_one'     => $data['title_one'],
                    'counter_two'   => $data['counter_two'],
                    'title_two'     => $data['title_two'],
                    'counter_three' => $data['counter_three'],
                    'title_three'   => $data['title_three'],
                    'counter_four'  => $data['counter_four'],
                    'title_four'    => $data['title_four'],
                ]
            );
        });
    }
}
