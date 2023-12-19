<?php

namespace App\Observers;

use App\Models\Curva;

class CurvaObserver
{
    /**
     * Handle the Curva "created" event.
     */
    public function creating(Curva $familia): void
    {
        sleep(1);

        $last = Curva::latest()->first();
        if(empty($last)){
            $familia->id=zero_fill(0,2);
        }else{
            $familia->id=zero_fill($last->id+1,2);
        }

    }


}
