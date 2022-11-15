<?php

namespace Hadihosseini88\Discount\Repositories;

use Hadihosseini88\Discount\Models\Discount;
use Morilog\Jalali\Jalalian;

class DiscountRepo
{
    public function find($id)
    {
        return Discount::query()->find($id);
    }
    public function store(array $data)
    {
        $discount = Discount::query()->create([
            'user_id' => auth()->id(),
            'code' => $data['code'],
            'percent' => $data['percent'],
            'usage_limitation' => $data['usage_limitation'],
            'expire_at' => $data['expire_at'] ? Jalalian::fromFormat("Y/m/d H:i", $data['expire_at'])->toCarbon() : null, //1401/8/22 10:40
            'type' => $data['type'],
            'link' => $data['link'],
            'description' => $data['description'],
            'uses' => 0,
        ]);
        if ($discount->type == Discount::TYPE_SPECIAL) {
            $discount->courses()->sync($data['courses']);
        }
    }

    public function paginateAll()
    {
        return Discount::query()->latest()->paginate();
    }

    public function update($id, array $data)
    {
        Discount::query()->where('id', $id)->update([
            'code' => $data['code'],
            'percent' => $data['percent'],
            'usage_limitation' => $data['usage_limitation'],
            'expire_at' => $data['expire_at'] ? Jalalian::fromFormat("Y/m/d H:i", $data['expire_at'])->toCarbon() : null, //1401/8/22 10:40
            'type' => $data['type'],
            'link' => $data['link'],
            'description' => $data['description'],
        ]);

        $discount = $this->find($id);
        if ($discount->type == Discount::TYPE_SPECIAL) {
            $discount->courses()->sync($data['courses']);
        } else {
            $discount->courses()->sync([]);
        }
    }
}
