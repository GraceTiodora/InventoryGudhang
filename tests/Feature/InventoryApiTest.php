<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Inventory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InventoryApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed data untuk testing
        $this->createSampleInventories();
    }

    private function createSampleInventories()
    {
        Inventory::create([
            'code' => 'TEST001',
            'name' => 'Test Item 1',
            'category' => 'Test',
            'quantity' => 10,
            'unit' => 'pcs',
            'price' => 100000,
            'supplier' => 'Test Supplier',
            'description' => 'Item untuk testing',
        ]);

        Inventory::create([
            'code' => 'TEST002',
            'name' => 'Test Item 2',
            'category' => 'Test',
            'quantity' => 5,
            'unit' => 'pcs',
            'price' => 200000,
            'supplier' => 'Test Supplier',
            'description' => 'Item untuk testing',
        ]);
    }

    /**
     * Test GET /api/inventories - Index semua inventory
     */
    public function test_get_all_inventories()
    {
        $response = $this->getJson('/api/inventories');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'code',
                        'name',
                        'category',
                        'quantity',
                        'unit',
                        'price',
                        'supplier',
                        'description',
                        'total_value',
                        'created_at',
                        'updated_at',
                    ]
                ],
                'pagination' => [
                    'total',
                    'per_page',
                    'current_page',
                    'last_page',
                    'from',
                    'to',
                ]
            ])
            ->assertJson([
                'success' => true,
                'message' => 'Data inventory berhasil diambil',
            ]);
    }

    /**
     * Test POST /api/inventories - Create inventory dengan data valid
     */
    public function test_create_inventory_with_valid_data()
    {
        $data = [
            'code' => 'NEW001',
            'name' => 'New Inventory Item',
            'category' => 'Electronics',
            'quantity' => 20,
            'unit' => 'pcs',
            'price' => 500000,
            'supplier' => 'New Supplier',
            'description' => 'Item baru untuk testing',
        ];

        $response = $this->postJson('/api/inventories', $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'code',
                    'name',
                    'category',
                    'quantity',
                    'unit',
                    'price',
                    'supplier',
                    'description',
                    'total_value',
                    'created_at',
                    'updated_at',
                ]
            ])
            ->assertJson([
                'success' => true,
                'message' => 'Inventory berhasil dibuat',
                'data' => [
                    'code' => 'NEW001',
                    'name' => 'New Inventory Item',
                ]
            ]);

        $this->assertDatabaseHas('inventories', [
            'code' => 'NEW001',
            'name' => 'New Inventory Item',
        ]);
    }

    /**
     * Test POST /api/inventories - Create inventory dengan kode duplicate
     */
    public function test_create_inventory_with_duplicate_code()
    {
        $data = [
            'code' => 'TEST001', // Kode sudah ada
            'name' => 'Duplicate Code Item',
            'category' => 'Test',
            'quantity' => 10,
            'unit' => 'pcs',
            'price' => 100000,
        ];

        $response = $this->postJson('/api/inventories', $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['code']);
    }

    /**
     * Test POST /api/inventories - Create inventory dengan data invalid
     */
    public function test_create_inventory_with_invalid_data()
    {
        $data = [
            'code' => '', // Required
            'name' => '', // Required
            'category' => '', // Required
            'quantity' => 'invalid', // Must be integer
            'unit' => '', // Required
            'price' => 'invalid', // Must be numeric
        ];

        $response = $this->postJson('/api/inventories', $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'code',
                'name',
                'category',
                'quantity',
                'unit',
                'price',
            ]);
    }

    /**
     * Test POST /api/inventories - Create inventory dengan harga negatif
     */
    public function test_create_inventory_with_negative_price()
    {
        $data = [
            'code' => 'NEGATIVE001',
            'name' => 'Negative Price Item',
            'category' => 'Test',
            'quantity' => 10,
            'unit' => 'pcs',
            'price' => -100000, // Negative price
        ];

        $response = $this->postJson('/api/inventories', $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['price']);
    }

    /**
     * Test GET /api/inventories/{id} - Show detail inventory
     */
    public function test_show_inventory_detail()
    {
        $inventory = Inventory::first();

        $response = $this->getJson("/api/inventories/{$inventory->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'code',
                    'name',
                    'category',
                    'quantity',
                    'unit',
                    'price',
                    'supplier',
                    'description',
                    'total_value',
                    'created_at',
                    'updated_at',
                ]
            ])
            ->assertJson([
                'success' => true,
                'message' => 'Detail inventory berhasil diambil',
                'data' => [
                    'id' => $inventory->id,
                    'code' => $inventory->code,
                ]
            ]);
    }

    /**
     * Test GET /api/inventories/{id} - Show inventory tidak ditemukan
     */
    public function test_show_inventory_not_found()
    {
        $response = $this->getJson('/api/inventories/999');

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'Inventory tidak ditemukan',
            ]);
    }

    /**
     * Test PUT /api/inventories/{id} - Update inventory
     */
    public function test_update_inventory()
    {
        $inventory = Inventory::first();

        $updateData = [
            'name' => 'Updated Name',
            'quantity' => 25,
            'price' => 150000,
        ];

        $response = $this->putJson("/api/inventories/{$inventory->id}", $updateData);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Inventory berhasil diperbarui',
                'data' => [
                    'id' => $inventory->id,
                    'name' => 'Updated Name',
                    'quantity' => 25,
                    'price' => 150000,
                ]
            ]);

        $this->assertDatabaseHas('inventories', [
            'id' => $inventory->id,
            'name' => 'Updated Name',
        ]);
    }

    /**
     * Test PUT /api/inventories/{id} - Update inventory tidak ditemukan
     */
    public function test_update_inventory_not_found()
    {
        $updateData = [
            'name' => 'Updated Name',
        ];

        $response = $this->putJson('/api/inventories/999', $updateData);

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'Inventory tidak ditemukan',
            ]);
    }

    /**
     * Test DELETE /api/inventories/{id} - Delete inventory
     */
    public function test_delete_inventory()
    {
        $inventory = Inventory::first();
        $inventoryId = $inventory->id;

        $response = $this->deleteJson("/api/inventories/{$inventoryId}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Inventory berhasil dihapus',
            ]);

        $this->assertDatabaseMissing('inventories', [
            'id' => $inventoryId,
        ]);
    }

    /**
     * Test DELETE /api/inventories/{id} - Delete inventory tidak ditemukan
     */
    public function test_delete_inventory_not_found()
    {
        $response = $this->deleteJson('/api/inventories/999');

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'Inventory tidak ditemukan',
            ]);
    }

    /**
     * Test GET /api/inventories/search/query - Search inventory
     */
    public function test_search_inventory()
    {
        $response = $this->getJson('/api/inventories/search/query?q=Test');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'code',
                        'name',
                    ]
                ],
                'pagination',
            ])
            ->assertJson([
                'success' => true,
                'message' => 'Pencarian inventory berhasil',
            ]);
    }

    /**
     * Test GET /api/inventories/search/query - Search tanpa parameter
     */
    public function test_search_inventory_without_parameter()
    {
        $response = $this->getJson('/api/inventories/search/query');

        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'Parameter pencarian tidak boleh kosong',
            ]);
    }

    /**
     * Test POST /api/inventories/{id}/adjust-stock - Adjust stock positif
     */
    public function test_adjust_stock_positive()
    {
        $inventory = Inventory::first();
        $originalQuantity = $inventory->quantity;

        $response = $this->postJson("/api/inventories/{$inventory->id}/adjust-stock", [
            'adjustment' => 5,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Stok berhasil disesuaikan',
                'data' => [
                    'quantity' => $originalQuantity + 5,
                ]
            ]);
    }

    /**
     * Test POST /api/inventories/{id}/adjust-stock - Adjust stock negatif
     */
    public function test_adjust_stock_negative()
    {
        $inventory = Inventory::first();
        $originalQuantity = $inventory->quantity;

        $response = $this->postJson("/api/inventories/{$inventory->id}/adjust-stock", [
            'adjustment' => -3,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Stok berhasil disesuaikan',
                'data' => [
                    'quantity' => $originalQuantity - 3,
                ]
            ]);
    }

    /**
     * Test POST /api/inventories/{id}/adjust-stock - Stok menjadi negatif
     */
    public function test_adjust_stock_becomes_negative()
    {
        $inventory = Inventory::first();

        $response = $this->postJson("/api/inventories/{$inventory->id}/adjust-stock", [
            'adjustment' => -$inventory->quantity - 1, // Akan negatif
        ]);

        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'Stok tidak boleh menjadi negatif',
            ]);
    }

    /**
     * Test GET /api/inventories/category/{category} - Get by category
     */
    public function test_get_inventory_by_category()
    {
        $response = $this->getJson('/api/inventories/category/Test');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data',
                'pagination',
            ])
            ->assertJson([
                'success' => true,
                'message' => 'Data inventory berhasil diambil',
            ]);
    }

    /**
     * Test GET /api/inventories/report/low-stock - Get low stock items
     */
    public function test_get_low_stock_inventories()
    {
        $response = $this->getJson('/api/inventories/report/low-stock?threshold=10');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data',
                'pagination',
            ])
            ->assertJson([
                'success' => true,
                'message' => 'Data inventory dengan stok rendah berhasil diambil',
            ]);
    }

    /**
     * Test GET /api/inventories/report/out-of-stock - Get out of stock items
     */
    public function test_get_out_of_stock_inventories()
    {
        // Create out of stock item
        Inventory::create([
            'code' => 'OUTSTOCK001',
            'name' => 'Out of Stock Item',
            'category' => 'Test',
            'quantity' => 0,
            'unit' => 'pcs',
            'price' => 100000,
        ]);

        $response = $this->getJson('/api/inventories/report/out-of-stock');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data',
                'pagination',
            ])
            ->assertJson([
                'success' => true,
                'message' => 'Data inventory dengan stok kosong berhasil diambil',
            ]);
    }
}
