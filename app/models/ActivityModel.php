<?php

/**
 * ActivityModel
 * จัดการกิจกรรม (activities) ภายในทริป
 */
class ActivityModel
{
    public static function add(int $tripId, array $data): bool
    {
        $title = htmlspecialchars(trim($data['title'] ?? ''));
        if (!$title) return false;

        foreach ($_SESSION['trips'] as &$trip) {
            if ($trip['id'] === $tripId) {
                $trip['activities'][] = [
                    'id'    => uniqid(),
                    'title' => $title,
                    'time'  => $data['time'] ?? '',
                    'cost'  => (float)($data['cost'] ?? 0),
                    'type'  => $data['type'] ?? 'other',
                    'done'  => false,
                ];
                return true;
            }
        }
        return false;
    }

    public static function toggle(int $tripId, string $actId): bool
    {
        foreach ($_SESSION['trips'] as &$trip) {
            if ($trip['id'] === $tripId) {
                foreach ($trip['activities'] as &$act) {
                    if ($act['id'] === $actId) {
                        $act['done'] = !$act['done'];
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public static function delete(int $tripId, string $actId): bool
    {
        foreach ($_SESSION['trips'] as &$trip) {
            if ($trip['id'] === $tripId) {
                $before = count($trip['activities']);
                $trip['activities'] = array_values(
                    array_filter($trip['activities'], fn($a) => $a['id'] !== $actId)
                );
                return count($trip['activities']) < $before;
            }
        }
        return false;
    }

    // ── Helpers ────────────────────────────────────────────────────────────────
    public static function totalCost(array $activities): float
    {
        return (float) array_sum(array_column($activities, 'cost'));
    }

    public static function doneCount(array $activities): int
    {
        return count(array_filter($activities, fn($a) => $a['done']));
    }
}
