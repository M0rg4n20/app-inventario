<?php

namespace App\Observers;

use App\Models\Marca;

class MarcaObserver
{
    /**
     * Handle the Marca "created" event.
     */
    public function creating(Marca $familia): void
    {
        sleep(1);

        $last = Marca::latest()->first();
        if(empty($last)){
            $familia->id=zero_fill(0,4);
        }else{
            $familia->id=zero_fill($last->id+1,4);
        }
        //$familia->id=$request;
    }
    public function created(Marca $familia): void
    {

        /*usleep(500000);
        $last = Marca::latest()->first();
        if(empty($last)){
            $familia->id=zero_fill(1,2);
        }else{
            $familia->id=zero_fill($last->id+1,2);
        }*/

    }

    /**
     * Handle the Marca "updated" event.
     */
    public function updated(Marca $familia): void
    {
        //
    }

    /**
     * Handle the Marca "deleted" event.
     */
    public function deleted(Marca $familia): void
    {
        //
    }

    /**
     * Handle the Marca "restored" event.
     */
    public function restored(Marca $familia): void
    {
        //
    }

    /**
     * Handle the Marca "force deleted" event.
     */
    public function forceDeleted(Marca $familia): void
    {
        //
    }
}
