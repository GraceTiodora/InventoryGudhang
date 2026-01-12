<?php

namespace App\Services;

use App\Models\Inventory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Exceptions\InventoryException;

class InventoryService
{
    /**
     * Dapatkan semua inventory dengan pagination
     */
    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return Inventory::paginate($perPage);
    }

    /**
     * Dapatkan inventory berdasarkan ID
     */
    public function getById(int $id): ?Inventory
    {
        return Inventory::find($id);
    }

    /**
     * Cari inventory berdasarkan nama atau kode
     */
    public function search(string $query, int $perPage = 15): LengthAwarePaginator
    {
        return Inventory::where('name', 'like', "%{$query}%")
            ->orWhere('code', 'like', "%{$query}%")
            ->orWhere('category', 'like', "%{$query}%")
            ->paginate($perPage);
    }

    /**
     * Buat inventory baru
     */
    public function create(array $data): Inventory
    {
        return Inventory::create($data);
    }

    /**
     * Update inventory
     */
    public function update(int $id, array $data): ?Inventory
    {
        $inventory = Inventory::find($id);

        if (!$inventory) {
            return null;
        }

        $inventory->update($data);
        return $inventory;
    }

    /**
     * Hapus inventory
     */
    public function delete(int $id): bool
    {
        $inventory = Inventory::find($id);

        if (!$inventory) {
            return false;
        }

        return (bool) $inventory->delete();
    }

    /**
     * Update stok inventory
     */
    public function updateStock(int $id, int $quantity): ?Inventory
    {
        $inventory = Inventory::find($id);

        if (!$inventory) {
            return null;
        }

        $inventory->update(['quantity' => $quantity]);
        return $inventory;
    }

    /**
     * Tambah stok (positive) atau kurangi stok (negative)
     */
    public function adjustStock(int $id, int $adjustment): ?Inventory
    {
        $inventory = Inventory::find($id);

        if (!$inventory) {
            return null;
        }

        $newQuantity = $inventory->quantity + $adjustment;

        if ($newQuantity < 0) {
            throw new \Exception('Stok tidak boleh menjadi negatif');
        }

        $inventory->update(['quantity' => $newQuantity]);
        return $inventory;
    }

    /**
     * Dapatkan inventory berdasarkan kategori
     */
    public function getByCategory(string $category, int $perPage = 15): LengthAwarePaginator
    {
        return Inventory::where('category', $category)->paginate($perPage);
    }

    /**
     * Dapatkan inventory dengan stok rendah
     */
    public function getLowStock(int $threshold = 10, int $perPage = 15): LengthAwarePaginator
    {
        return Inventory::where('quantity', '<=', $threshold)->paginate($perPage);
    }

    /**
     * Dapatkan inventory dengan stok kosong
     */
    public function getOutOfStock(int $perPage = 15): LengthAwarePaginator
    {
        return Inventory::where('quantity', 0)->paginate($perPage);
    }

    /**
     * Cek apakah kode inventory sudah ada
     */
    public function codeExists(string $code, ?int $excludeId = null): bool
    {
        $query = Inventory::where('code', $code);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }
}
