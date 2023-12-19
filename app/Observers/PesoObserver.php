<?php

namespace App\Observers;

use App\Models\Peso;

class PesoObserver
{
    /**
     * Handle the Marca "created" event.
     */
    public function creating(Peso $familia): void
    {
        sleep(1);

        $last = Peso::latest()->first();
        if(empty($last)){
            $familia->codigo=zero_fill(0,3);
        }else{
            $familia->codigo=zero_fill($last->id+1,3);
        }

    }



}
