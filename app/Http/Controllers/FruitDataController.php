<?php

namespace App\Http\Controllers;

use App\Services\FruitDataService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FruitDataController extends Controller
{
    private FruitDataService $fruitDataService;

    public function __construct(FruitDataService $fruitDataService)
    {
        $this->fruitDataService = $fruitDataService;
    }

    /**
     * Hiển thị trang quản lý dữ liệu trái cây
     */
    public function index()
    {
        $statistics = $this->fruitDataService->getStatistics();

        return view('admin.fruit-data', compact('statistics'));
    }

    /**
     * Tạo dữ liệu trái cây sử dụng Factory pattern
     */
    public function createData(Request $request): JsonResponse
    {
        $request->validate([
            'quantity' => 'integer|min:1|max:10',
            'clear_existing' => 'boolean'
        ]);

        $quantity = $request->input('quantity', 1);
        $clearExisting = $request->boolean('clear_existing', false);

        $result = $this->fruitDataService->createFruitData($quantity, $clearExisting);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => $result['message'],
                'data' => $result['data']
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message']
        ], 500);
    }

    /**
     * Tạo một loại trái cây cụ thể
     */
    public function createSingleFruit(Request $request): JsonResponse
    {
        $request->validate([
            'type' => 'required|string|in:apple,orange,mango,banana,pineapple,grape,watermelon,strawberry'
        ]);

        $type = $request->input('type');
        $result = $this->fruitDataService->createSingleFruit($type);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => $result['message'],
                'data' => $result['data']
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message']
        ], 500);
    }

    /**
     * Tạo dữ liệu demo
     */
    public function createDemoData(): JsonResponse
    {
        $result = $this->fruitDataService->createDemoData();

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => $result['message'],
                'data' => $result['data']
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message']
        ], 500);
    }

    /**
     * Xóa tất cả dữ liệu trái cây
     */
    public function clearData(): JsonResponse
    {
        $result = $this->fruitDataService->clearAllData();

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => $result['message'],
                'data' => $result['data']
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message']
        ], 500);
    }

    /**
     * Lấy thống kê dữ liệu
     */
    public function getStatistics(): JsonResponse
    {
        $statistics = $this->fruitDataService->getStatistics();

        return response()->json([
            'success' => true,
            'data' => $statistics
        ]);
    }
}
