<?php

namespace App\Observers;

use App\Models\Color;

class ColorObserver
{
    /**
     * Handle the Color "created" event.
     */
    public function creating(Color $familia): void
    {
        /*sleep(1);

        $last = Color::latest()->first();
        if(empty($last)){
            $familia->id=zero_fill(0,2);
        }else{
            $familia->id=zero_fill($last->id+1,2);
        }*/

    }


}
