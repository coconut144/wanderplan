<?php

require_once BASE_PATH . '/app/models/ActivityModel.php';

/**
 * ActivityController
 * จัดการ CRUD ของกิจกรรมภายในทริป
 */
class ActivityController
{
    /**
     * POST /?action=add_activity — เพิ่มกิจกรรม
     */
    public function store(int $tripId): void
    {
        ActivityModel::add($tripId, $_POST);
        header("Location: index.php?view={$tripId}");
        exit;
    }

    /**
     * GET /?action=toggle_activity&trip_id={id}&act_id={aid} — ติ๊ก done/undone
     */
    public function toggle(int $tripId, string $actId): void
    {
        ActivityModel::toggle($tripId, $actId);
        header("Location: index.php?view={$tripId}");
        exit;
    }

    /**
     * GET /?action=delete_activity&trip_id={id}&act_id={aid} — ลบกิจกรรม
     */
    public function destroy(int $tripId, string $actId): void
    {
        ActivityModel::delete($tripId, $actId);
        header("Location: index.php?view={$tripId}");
        exit;
    }
}
