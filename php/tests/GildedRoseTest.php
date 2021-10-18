<?php

declare(strict_types=1);

use GildedRose\GildedRose;
use GildedRose\Item;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{
    public function testQualityNeverNegative(): void
    {
        // given
        $items = [new Item('foo', 0, 0)];
        $gildedRose = new GildedRose($items);

        // when
        $gildedRose->updateQuality();

        // then
        $this->assertSame(-1, $items[0]->sell_in);
        $this->assertSame(0, $items[0]->quality);
    }

    public function testQualityDecreases(): void
    {
        // given
        $items = [new Item('foo', 1, 2)];
        $gildedRose = new GildedRose($items);

        // when
        $gildedRose->updateQuality();

        // then
        $this->assertSame(0, $items[0]->sell_in);
        $this->assertSame(1, $items[0]->quality);
    }

    public function testQualityDecreasesTwice(): void
    {
        // given
        $items = [new Item('foo', -1, 2)];
        $gildedRose = new GildedRose($items);

        // when
        $gildedRose->updateQuality();

        // then
        $this->assertSame(-2, $items[0]->sell_in);
        $this->assertSame(0, $items[0]->quality);
    }

    public function testAgedBrie(): void
    {
        // given
        $items = [new Item('Aged Brie', 1, 1)];
        $gildedRose = new GildedRose($items);

        // when
        $gildedRose->updateQuality();

        // then
        $this->assertSame(0, $items[0]->sell_in);
        $this->assertSame(2, $items[0]->quality);
    }

    public function testAgedBriePastSellIn(): void
    {
        // given
        $items = [new Item('Aged Brie', 0, 1)];
        $gildedRose = new GildedRose($items);

        // when
        $gildedRose->updateQuality();

        // then
        $this->assertSame(-1, $items[0]->sell_in);
        $this->assertSame(3, $items[0]->quality);
    }

    public function testQualityInf50(): void
    {
        // given
        $items = [new Item('Aged Brie', 0, 50)];
        $gildedRose = new GildedRose($items);

        // when
        $gildedRose->updateQuality();

        // then
        $this->assertSame(-1, $items[0]->sell_in);
        $this->assertSame(50, $items[0]->quality);
    }
}
