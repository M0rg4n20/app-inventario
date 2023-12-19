<?php

namespace App\Observers;

use App\Models\SubProducto;

class SubProductoObserver
{
    /**
     * Handle the Familia "created" event.
     */
    public function creating(SubProducto $familia): void
    {
        sleep(1);

        $last = SubProducto::latest()->first();
        if(empty($last)){
            $familia->id=zero_fill(1,6);
        }else{
            $familia->id=zero_fill($last->id+1,6);
        }
    }
    public function created(SubProducto $familia): void
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
    public function updated(SubProducto $familia): void
    {
        //
    }

    /**
     * Handle the Familia "deleted" event.
     */
    public function deleted(SubProducto $familia): void
    {
        //
    }

    /**
     * Handle the Familia "restored" event.
     */
    public function restored(SubProducto $familia): void
    {
        //
    }

    /**
     * Handle the Familia "force deleted" event.
     */
    public function forceDeleted(SubProducto $familia): void
    {
        //
    }
}
