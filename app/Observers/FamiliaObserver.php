<?php

namespace App\Observers;

use App\Models\Familia;

class FamiliaObserver
{
    /**
     * Handle the Familia "created" event.
     */
    public function creating(Familia $familia): void
    {
        sleep(1);

        $last = Familia::latest()->first();
        if(empty($last)){
            $familia->id=zero_fill(1,2);
        }else{
            $familia->id=zero_fill($last->id+1,2);
        }
        //$familia->id=$request;
    }
    public function created(Familia $familia): void
    {

        /*usleep(500000);
        $last = Familia::latest()->first();
        if(empty($last)){
            $familia->id=zero_fill(1,2);
        }else{
            $familia->id=zero_fill($last->id+1,2);
        }*/

    }

    /**
     * Handle the Familia "updated" event.
     */
    public function updated(Familia $familia): void
    {
        //
    }

    /**
     * Handle the Familia "deleted" event.
     */
    public function deleted(Familia $familia): void
    {
        //
    }

    /**
     * Handle the Familia "restored" event.
     */
    public function restored(Familia $familia): void
    {
        //
    }

    /**
     * Handle the Familia "force deleted" event.
     */
    public function forceDeleted(Familia $familia): void
    {
        //
    }
}
