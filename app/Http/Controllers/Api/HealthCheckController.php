<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class HealthCheckController extends Controller
{
    public function check()
    {
        $status = 'UP';
        $checks = [];

        // 1. Database Connection Check
        try {
            DB::connection()->getPdo();
            $checks['database'] = [
                'status' => 'UP',
                'message' => 'Database connection successful.',
            ];
        } catch (\Exception $e) {
            $status = 'DOWN';
            $checks['database'] = [
                'status' => 'DOWN',
                'message' => $e->getMessage(),
            ];
        }

        // 2. Storage Directory Writable Check
        $storagePath = storage_path('framework/cache');
        if (is_writable($storagePath)) {
            $checks['storage'] = [
                'status' => 'UP',
                'message' => 'Storage directory is writable.',
            ];
        } else {
            $status = 'DOWN';
            $checks['storage'] = [
                'status' => 'DOWN',
                'message' => 'Storage directory is not writable.',
            ];
        }

        // 3. Cache Check
        try {
            Cache::put('health_check_test_key', 'ok', 10);
            $cacheVal = Cache::get('health_check_test_key');
            if ($cacheVal === 'ok') {
                $checks['cache'] = [
                    'status' => 'UP',
                    'message' => 'Cache operations are functioning correctly.',
                ];
            } else {
                $status = 'DOWN';
                $checks['cache'] = [
                    'status' => 'DOWN',
                    'message' => 'Cache returned incorrect value.',
                ];
            }
        } catch (\Exception $e) {
            $status = 'DOWN';
            $checks['cache'] = [
                'status' => 'DOWN',
                'message' => $e->getMessage(),
            ];
        }

        $code = ($status === 'UP') ? 200 : 503;

        return response()->json([
            'status' => $status,
            'timestamp' => now()->toIso8601String(),
            'environment' => app()->environment(),
            'checks' => $checks,
        ], $code);
    }
}
