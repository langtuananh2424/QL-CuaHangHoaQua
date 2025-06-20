<?php

namespace App\DesignPatterns\Observer;

use App\DesignPatterns\Observer\OrderPlaced;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\DesignPatterns\Singleton\InventoryManager;
class UpdateStockAfterOrder
{
    /**
     * Create the event listener.
     */
    public function __construct(private InventoryManager $inventoryManager)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderPlaced $event): void
    {
        foreach ($event->order->items as $item) {
            $this->inventoryManager->reduceStock($item->fruit_id, $item->quantity);
    }
    }
}