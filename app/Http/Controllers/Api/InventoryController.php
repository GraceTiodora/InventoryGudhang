<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInventoryRequest;
use App\Http\Requests\UpdateInventoryRequest;
use App\Http\Resources\InventoryResource;
use App\Services\InventoryService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class InventoryController extends Controller
{
    protected InventoryService $inventoryService;

    public function __construct(InventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

    /**
     * GET /api/inventories
     * Dapatkan semua inventory dengan pagination
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('per_page', 15);
            $inventories = $this->inventoryService->getAll($perPage);

            return response()->json([
                'success' => true,
                'message' => 'Data inventory berhasil diambil',
                'data' => InventoryResource::collection($inventories->items()),
                'pagination' => [
                    'total' => $inventories->total(),
                    'per_page' => $inventories->perPage(),
                    'current_page' => $inventories->currentPage(),
                    'last_page' => $inventories->lastPage(),
                    'from' => $inventories->firstItem(),
                    'to' => $inventories->lastItem(),
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * POST /api/inventories
     * Buat inventory baru
     */
    public function store(StoreInventoryRequest $request): JsonResponse
    {
        try {
            $inventory = $this->inventoryService->create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Inventory berhasil dibuat',
                'data' => new InventoryResource($inventory),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat inventory: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * GET /api/inventories/{id}
     * Dapatkan detail inventory berdasarkan ID
     */
    public function show(int $id): JsonResponse
    {
        try {
            $inventory = $this->inventoryService->getById($id);

            if (!$inventory) {
                return response()->json([
                    'success' => false,
                    'message' => 'Inventory tidak ditemukan',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Detail inventory berhasil diambil',
                'data' => new InventoryResource($inventory),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * PUT/PATCH /api/inventories/{id}
     * Update inventory
     */
    public function update(UpdateInventoryRequest $request, int $id): JsonResponse
    {
        try {
            $inventory = $this->inventoryService->update($id, $request->validated());

            if (!$inventory) {
                return response()->json([
                    'success' => false,
                    'message' => 'Inventory tidak ditemukan',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Inventory berhasil diperbarui',
                'data' => new InventoryResource($inventory),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui inventory: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * DELETE /api/inventories/{id}
     * Hapus inventory
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $deleted = $this->inventoryService->delete($id);

            if (!$deleted) {
                return response()->json([
                    'success' => false,
                    'message' => 'Inventory tidak ditemukan',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Inventory berhasil dihapus',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus inventory: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * GET /api/inventories/search
     * Cari inventory berdasarkan nama/kode
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $query = $request->query('q', '');
            $perPage = $request->query('per_page', 15);

            if (empty($query)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Parameter pencarian tidak boleh kosong',
                ], 400);
            }

            $inventories = $this->inventoryService->search($query, $perPage);

            return response()->json([
                'success' => true,
                'message' => 'Pencarian inventory berhasil',
                'data' => InventoryResource::collection($inventories->items()),
                'pagination' => [
                    'total' => $inventories->total(),
                    'per_page' => $inventories->perPage(),
                    'current_page' => $inventories->currentPage(),
                    'last_page' => $inventories->lastPage(),
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * POST /api/inventories/{id}/adjust-stock
     * Sesuaikan stok (tambah/kurangi)
     */
    public function adjustStock(Request $request, int $id): JsonResponse
    {
        try {
            $request->validate([
                'adjustment' => 'required|integer',
            ]);

            $inventory = $this->inventoryService->adjustStock($id, $request->input('adjustment'));

            if (!$inventory) {
                return response()->json([
                    'success' => false,
                    'message' => 'Inventory tidak ditemukan',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Stok berhasil disesuaikan',
                'data' => new InventoryResource($inventory),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * GET /api/inventories/category/{category}
     * Dapatkan inventory berdasarkan kategori
     */
    public function getByCategory(string $category, Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('per_page', 15);
            $inventories = $this->inventoryService->getByCategory($category, $perPage);

            return response()->json([
                'success' => true,
                'message' => 'Data inventory berhasil diambil',
                'data' => InventoryResource::collection($inventories->items()),
                'pagination' => [
                    'total' => $inventories->total(),
                    'per_page' => $inventories->perPage(),
                    'current_page' => $inventories->currentPage(),
                    'last_page' => $inventories->lastPage(),
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * GET /api/inventories/low-stock
     * Dapatkan inventory dengan stok rendah
     */
    public function getLowStock(Request $request): JsonResponse
    {
        try {
            $threshold = $request->query('threshold', 10);
            $perPage = $request->query('per_page', 15);
            $inventories = $this->inventoryService->getLowStock($threshold, $perPage);

            return response()->json([
                'success' => true,
                'message' => 'Data inventory dengan stok rendah berhasil diambil',
                'data' => InventoryResource::collection($inventories->items()),
                'pagination' => [
                    'total' => $inventories->total(),
                    'per_page' => $inventories->perPage(),
                    'current_page' => $inventories->currentPage(),
                    'last_page' => $inventories->lastPage(),
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * GET /api/inventories/out-of-stock
     * Dapatkan inventory dengan stok kosong
     */
    public function getOutOfStock(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('per_page', 15);
            $inventories = $this->inventoryService->getOutOfStock($perPage);

            return response()->json([
                'success' => true,
                'message' => 'Data inventory dengan stok kosong berhasil diambil',
                'data' => InventoryResource::collection($inventories->items()),
                'pagination' => [
                    'total' => $inventories->total(),
                    'per_page' => $inventories->perPage(),
                    'current_page' => $inventories->currentPage(),
                    'last_page' => $inventories->lastPage(),
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }
}
