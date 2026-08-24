<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class Scan24HoursTest extends TestCase
{
    //scan moins de 24 heures
    public function test_scan_less_than_24_hours_is_recent(): void
    {
        $updatedAt = now()->subHours(2);

        $isRecent = $updatedAt >= now()->subHours(24);

        $this->assertTrue($isRecent);
    }

    //scan plus de 24 heures
    public function test_scan_more_than_24_hours_is_not_recent(): void
    {
        $updatedAt = now()->subHours(25);

        $isRecent = $updatedAt >= now()->subHours(24);

        $this->assertFalse($isRecent);
    }

    //scan exact 24 heures
    public function test_scan_exactly_24_hours_is_recent(): void
    {
        $now = now();

        $updatedAt = $now->copy()->subHours(24);

        $isRecent = $updatedAt >= $now->copy()->subHours(24);

        $this->assertTrue($isRecent);
    }
}
