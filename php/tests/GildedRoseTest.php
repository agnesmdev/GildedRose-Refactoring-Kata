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

    public function testSulfuras(): void
    {
        // given
        $items = [new Item('Sulfuras, Hand of Ragnaros', 1, 1)];
        $gildedRose = new GildedRose($items);

        // when
        $gildedRose->updateQuality();

        // then
        $this->assertSame(1, $items[0]->sell_in);
        $this->assertSame(1, $items[0]->quality);
    }

    public function testBackstagePasses(): void
    {
        // given
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', 20, 1)];
        $gildedRose = new GildedRose($items);

        // when
        $gildedRose->updateQuality();

        // then
        $this->assertSame(19, $items[0]->sell_in);
        $this->assertSame(2, $items[0]->quality);
    }

    public function testBackstagePasses10dLeft(): void
    {
        // given
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', 10, 1)];
        $gildedRose = new GildedRose($items);

        // when
        $gildedRose->updateQuality();

        // then
        $this->assertSame(9, $items[0]->sell_in);
        $this->assertSame(3, $items[0]->quality);
    }

    public function testBackstagePasses5dLeft(): void
    {
        // given
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', 5, 1)];
        $gildedRose = new GildedRose($items);

        // when
        $gildedRose->updateQuality();

        // then
        $this->assertSame(4, $items[0]->sell_in);
        $this->assertSame(4, $items[0]->quality);
    }

    public function testBackstagePassesAfterConcert(): void
    {
        // given
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', -1, 10)];
        $gildedRose = new GildedRose($items);

        // when
        $gildedRose->updateQuality();

        // then
        $this->assertSame(-2, $items[0]->sell_in);
        $this->assertSame(0, $items[0]->quality);
    }

    public function testConjured(): void
    {
        // given
        $items = [new Item('Conjured', 1, 10)];
        $gildedRose = new GildedRose($items);

        // when
        $gildedRose->updateQuality();

        // then
        $this->assertSame(0, $items[0]->sell_in);
        $this->assertSame(8, $items[0]->quality);
    }

    public function testConjuredAfterSellIn(): void
    {
        // given
        $items = [new Item('Conjured', 0, 10)];
        $gildedRose = new GildedRose($items);

        // when
        $gildedRose->updateQuality();

        // then
        $this->assertSame(-1, $items[0]->sell_in);
        $this->assertSame(6, $items[0]->quality);
    }
}
