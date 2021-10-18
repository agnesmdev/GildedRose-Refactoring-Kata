<?php

declare(strict_types=1);

namespace GildedRose;

final class GildedRose
{
    /**
     * @var Item[]
     */
    private $items;
    private $agedBrie = 'Aged Brie';
    private $backstagePasses = 'Backstage passes to a TAFKAL80ETC concert';
    private $sulfuras = 'Sulfuras, Hand of Ragnaros';

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            if ($item->name != $this->agedBrie and $item->name != $this->backstagePasses) {
                if ($item->quality > 0) {
                    if ($item->name != $this->sulfuras) {
                        $item->quality = $item->quality - 1;
                    }
                }
            } else {
                if ($item->quality < 50) {
                    $item->quality = $item->quality + 1;
                    if ($item->name == $this->backstagePasses) {
                        if ($item->sell_in < 11) {
                            if ($item->quality < 50) {
                                $item->quality = $item->quality + 1;
                            }
                        }
                        if ($item->sell_in < 6) {
                            if ($item->quality < 50) {
                                $item->quality = $item->quality + 1;
                            }
                        }
                    }
                }
            }

            if ($item->name != $this->sulfuras) {
                $item->sell_in = $item->sell_in - 1;
            }

            if ($item->sell_in < 0) {
                if ($item->name != $this->agedBrie) {
                    if ($item->name != $this->backstagePasses) {
                        if ($item->quality > 0) {
                            if ($item->name != $this->sulfuras) {
                                $item->quality = $item->quality - 1;
                            }
                        }
                    } else {
                        $item->quality = $item->quality - $item->quality;
                    }
                } else {
                    if ($item->quality < 50) {
                        $item->quality = $item->quality + 1;
                    }
                }
            }
        }
    }
}
