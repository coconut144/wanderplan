<?php

/**
 * TripModel
 * จัดการข้อมูลทริปทั้งหมด (เก็บใน Session แทน Database)
 */
class TripModel
{
    // ── Bootstrap session ──────────────────────────────────────────────────────
    public static function boot(): void
    {
        if (!isset($_SESSION['trips']))   $_SESSION['trips']   = [];
        if (!isset($_SESSION['next_id'])) $_SESSION['next_id'] = 1;

        // Seed ข้อมูลตัวอย่างถ้ายังไม่มี
        // if (empty($_SESSION['trips'])) {
        //     self::seed();
        // }
    }

    // ── CRUD ───────────────────────────────────────────────────────────────────
    public static function all(): array
    {
        return $_SESSION['trips'] ?? [];
    }

    public static function find(int $id): ?array
    {
        foreach ($_SESSION['trips'] as $trip) {
            if ($trip['id'] === $id) return $trip;
        }
        return null;
    }

    public static function create(array $data): bool
    {
        $name        = htmlspecialchars(trim($data['name'] ?? ''));
        $destination = htmlspecialchars(trim($data['destination'] ?? ''));

        if (!$name || !$destination) return false;

        $_SESSION['trips'][] = [
            'id'          => $_SESSION['next_id']++,
            'name'        => $name,
            'destination' => $destination,
            'start_date'  => $data['start_date'] ?? '',
            'end_date'    => $data['end_date']   ?? '',
            'budget'      => (float)($data['budget'] ?? 0),
            'notes'       => htmlspecialchars(trim($data['notes'] ?? '')),
            'activities'  => [],
            'status'      => 'planning',
            'cover_emoji' => $data['cover_emoji'] ?? '✈️',
            'created_at'  => date('Y-m-d H:i:s'),
        ];
        return true;
    }

    public static function updateStatus(int $id, string $status): bool
    {
        $allowed = ['planning', 'ongoing', 'done'];
        if (!in_array($status, $allowed)) return false;

        foreach ($_SESSION['trips'] as &$trip) {
            if ($trip['id'] === $id) {
                $trip['status'] = $status;
                return true;
            }
        }
        return false;
    }

    public static function delete(int $id): bool
    {
        $before = count($_SESSION['trips']);
        $_SESSION['trips'] = array_values(
            array_filter($_SESSION['trips'], fn($t) => $t['id'] !== $id)
        );
        return count($_SESSION['trips']) < $before;
    }

    // ── Stats helpers ──────────────────────────────────────────────────────────
    public static function totalBudget(): float
    {
        return (float) array_sum(array_column($_SESSION['trips'], 'budget'));
    }

    public static function countByStatus(string $status): int
    {
        return count(array_filter($_SESSION['trips'], fn($t) => $t['status'] === $status));
    }

    public static function uniqueDestinations(): int
    {
        return count(array_unique(array_column($_SESSION['trips'], 'destination')));
    }

    // ── Seed ───────────────────────────────────────────────────────────────────
    // private static function seed(): void
    // {
    //     $_SESSION['trips'] = [
    //         [
    //             'id'          => $_SESSION['next_id']++,
    //             'name'        => 'ทริปญี่ปุ่น ซากุระบาน',
    //             'destination' => 'โตเกียว & เกียวโต, ญี่ปุ่น',
    //             'start_date'  => '2025-03-28',
    //             'end_date'    => '2025-04-05',
    //             'budget'      => 80000,
    //             'notes'       => 'ช่วงซากุระบาน ต้องจองโรงแรมล่วงหน้า',
    //             'status'      => 'planning',
    //             'cover_emoji' => '🌸',
    //             'created_at'  => date('Y-m-d H:i:s'),
    //             'activities'  => [
    //                 ['id' => 'a1', 'title' => 'เที่ยวอุเอโนะปาร์ค ดูซากุระ', 'time' => '09:00', 'cost' => 0,   'type' => 'sightseeing', 'done' => false],
    //                 ['id' => 'a2', 'title' => 'กินราเมนที่ Ichiran',           'time' => '12:00', 'cost' => 800, 'type' => 'food',        'done' => false],
    //                 ['id' => 'a3', 'title' => 'เที่ยววัดกิงกะกุจิ',           'time' => '15:00', 'cost' => 500, 'type' => 'sightseeing', 'done' => false],
    //             ],
    //         ],
    //     ];
    // }
}
