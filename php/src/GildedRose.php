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
    private $conjured = 'Conjured';

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            switch ($item->name) {
                case $this->agedBrie:
                    $item->quality = $this->qualityUpgrade($item->quality, $this->qualityDegradeValue($item->sell_in));
                    $item->sell_in = $item->sell_in - 1;
                    break;
                case $this->backstagePasses:
                    $item->quality = $this->computePassesQuality($item);
                    $item->sell_in = $item->sell_in - 1;
                    break;
                case $this->sulfuras:
                    break;
                case $this->conjured:
                    $item->quality = $this->qualityDegrade($item, 2);
                    $item->sell_in = $item->sell_in - 1;
                    break;
                default:
                    $item->quality = $this->qualityDegrade($item);
                    $item->sell_in = $item->sell_in - 1;
            }
        }
    }

    private function qualityUpgrade(int $quality, int $upgrade = 1): int
    {
        return min(50, $quality + $upgrade);
    }

    private function qualityDegrade(Item $item, int $ratio = 1): int
    {
        return ($item->quality == 0) ? 0 : $item->quality - $ratio * $this->qualityDegradeValue($item->sell_in);
    }

    private function qualityDegradeValue(int $sell_in): int
    {
        return ($sell_in > 0) ? 1 : 2;
    }

    private function computePassesQuality(Item $item): int
    {
        switch($item->sell_in) {
            case $item->sell_in <= 0:
                return 0;
            case $item->sell_in <= 5:
                return $this->qualityUpgrade($item->quality, 3);
            case $item->sell_in <= 10:
                return $this->qualityUpgrade($item->quality, 2);
            default:
                return $this->qualityUpgrade($item->quality);
        }
    }
}
