<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class Scan24HoursTest extends TestCase
{
    //scan datant de 2 heues
    public function test_scan_less_than_24_hours_is_recent(): void
    {
        $updatedAt = now()->subHours(2);

        $isRecent = $updatedAt >= now()->subHours(24);

        $this->assertTrue($isRecent);
    }

    public function test_scan_more_than_24_hours_is_not_recent(): void
    {
        $updatedAt = now()->subHours(25);

        $isRecent = $updatedAt >= now()->subHours(24);

        $this->assertFalse($isRecent);
    }

    public function test_scan_exactly_24_hours_is_recent(): void
    {
        $now = now();

        $updatedAt = $now->copy()->subHours(24);

        $isRecent = $updatedAt >= $now->copy()->subHours(24);

        $this->assertTrue($isRecent);
    }
}
