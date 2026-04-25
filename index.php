<?php
/**
 * index.php — Front Controller
 * จุดเข้าเดียวของทุก request แล้วกระจายไปยัง Controller ที่เหมาะสม
 */

session_start();

define('BASE_PATH', __DIR__);

// ── Autoload classes ──────────────────────────────────────────────────────────
require_once BASE_PATH . '/app/helpers/ViewHelper.php';
require_once BASE_PATH . '/app/models/TripModel.php';
require_once BASE_PATH . '/app/models/ActivityModel.php';
require_once BASE_PATH . '/app/controllers/TripController.php';
require_once BASE_PATH . '/app/controllers/ActivityController.php';

// ── Bootstrap data ────────────────────────────────────────────────────────────
TripModel::boot();

// ── Read request params ───────────────────────────────────────────────────────
$action  = $_POST['action'] ?? $_GET['action'] ?? '';
$tripId  = (int)($_POST['trip_id'] ?? $_GET['trip_id'] ?? 0);
$actId   = $_GET['act_id'] ?? '';
$status  = $_GET['status'] ?? 'planning';
$viewId  = (int)($_GET['view'] ?? 0);

// ── Route table ───────────────────────────────────────────────────────────────
$tripCtrl = new TripController();
$actCtrl  = new ActivityController();

switch ($action) {

    // Trip actions (POST)
    case 'add_trip':
        $tripCtrl->store();
        break;

    // Trip actions (GET)
    case 'delete_trip':
        $tripCtrl->destroy($tripId);
        break;

    case 'update_status':
        $tripCtrl->updateStatus($tripId, $status);
        break;

    // Activity actions (POST)
    case 'add_activity':
        $actCtrl->store($tripId);
        break;

    // Activity actions (GET)
    case 'toggle_activity':
        $actCtrl->toggle($tripId, $actId);
        break;

    case 'delete_activity':
        $actCtrl->destroy($tripId, $actId);
        break;

    // Default — display views
    default:
        if ($viewId > 0) {
            $tripCtrl->show($viewId);   // Detail page
        } else {
            $tripCtrl->index();         // Home page
        }
        break;
}
