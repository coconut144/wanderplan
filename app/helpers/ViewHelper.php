<?php

class ViewHelper
{
    public static function daysCount(string $start, string $end): int
    {
        if (!$start || !$end) return 0;
        return (new DateTime($end))->diff(new DateTime($start))->days + 1;
    }

    public static function statusLabel(string $status): string
    {
        return match ($status) {
            'planning' => 'วางแผน',
            'ongoing'  => 'กำลังเดินทาง',
            'done'     => 'เสร็จสิ้น',
            default    => $status,
        };
    }

    public static function statusClass(string $status): string
    {
        return match ($status) {
            'planning' => 'badge-planning',
            'ongoing'  => 'badge-ongoing',
            'done'     => 'badge-done',
            default    => '',
        };
    }

    public static function typeIcon(string $type): string
    {
        return match ($type) {
            'food'        => '🍜',
            'sightseeing' => '🗺️',
            'transport'   => '🚂',
            'hotel'       => '🏨',
            'shopping'    => '🛍️',
            default       => '📌',
        };
    }

    public static function budgetPercent(float $budget, float $spent): int
    {
        return $budget > 0 ? min(100, (int) round($spent / $budget * 100)) : 0;
    }

    public static function render(string $view, array $data = []): void
    {
        $__file = BASE_PATH . '/views/' . $view . '.php';
        if (!file_exists($__file)) {
            die("View not found: {$view}");
        }
        extract($data);
        require $__file;
    }
}