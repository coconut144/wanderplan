<?php

require_once BASE_PATH . '/app/models/TripModel.php';
require_once BASE_PATH . '/app/models/ActivityModel.php';
require_once BASE_PATH . '/app/helpers/ViewHelper.php';

/**
 * TripController
 * รับ request จาก index.php แล้วเลือก action ที่เหมาะสม
 */
class TripController
{
    /**
     * GET / — หน้าหลัก แสดงรายการทริปทั้งหมด
     */
    public function index(): void
    {
        $trips = TripModel::all();

        $stats = [
            'total_trips'  => count($trips),
            'total_budget' => TripModel::totalBudget(),
            'destinations' => TripModel::uniqueDestinations(),
            'ongoing'      => TripModel::countByStatus('ongoing'),
        ];

        ViewHelper::render('layouts/main', [
            'title'   => 'WanderPlan — แพลนเนอร์ทริป',
            'content' => 'trips/index',
            'trips'   => $trips,
            'stats'   => $stats,
        ]);
    }

    /**
     * GET /?view={id} — หน้ารายละเอียดทริป
     */
    public function show(int $id): void
    {
        $trip = TripModel::find($id);
        if (!$trip) {
            header('Location: index.php');
            exit;
        }

        $spent   = ActivityModel::totalCost($trip['activities']);
        $doneCount = ActivityModel::doneCount($trip['activities']);

        $tripStats = [
            'days'       => ViewHelper::daysCount($trip['start_date'], $trip['end_date']),
            'spent'      => $spent,
            'budget_pct' => ViewHelper::budgetPercent((float)$trip['budget'], $spent),
            'done_count' => $doneCount,
            'total_act'  => count($trip['activities']),
        ];

        ViewHelper::render('layouts/main', [
            'title'      => $trip['name'] . ' — WanderPlan',
            'content'    => 'trips/show',
            'trip'       => $trip,
            'tripStats'  => $tripStats,
        ]);
    }

    /**
     * POST /?action=add_trip — เพิ่มทริปใหม่
     */
    public function store(): void
    {
        TripModel::create($_POST);
        header('Location: index.php');
        exit;
    }

    /**
     * GET /?action=delete_trip&trip_id={id} — ลบทริป
     */
    public function destroy(int $id): void
    {
        TripModel::delete($id);
        header('Location: index.php');
        exit;
    }

    /**
     * GET /?action=update_status&trip_id={id}&status={status} — เปลี่ยนสถานะ
     */
    public function updateStatus(int $id, string $status): void
    {
        TripModel::updateStatus($id, $status);
        header("Location: index.php?view={$id}");
        exit;
    }
}
