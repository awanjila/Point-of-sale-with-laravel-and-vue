<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\SaleDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SaleController extends Controller
{
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $saleData = json_decode($request->sale_data, true);
            
            // Create sale
            $sale = Sale::create([
                'sale_no' => $saleData['sale_no'],
                'customer_id' => $saleData['customer_id'],
                'delivery_person_id' => $saleData['delivery_person_id'],
                'sale_type' => $saleData['sale_type'],
                'status' => $saleData['status'],
                'sale_date' => $saleData['sale_date'],
                'payment_terms' => $saleData['payment_terms'],
                'subtotal' => $saleData['subtotal'],
                'tax_rate' => $saleData['tax_rate'],
                'tax_amount' => $saleData['tax_amount'],
                'discount_type' => $saleData['discount_type'],
                'discount_amount' => $saleData['discount_amount'],
                'shipping_charges' => $saleData['shipping_charges'],
                'total' => $saleData['total'],
                'paid_amount' => $saleData['paid_amount'],
                'due_amount' => $saleData['due_amount'],
                'payment_status' => $saleData['payment_status'],
                'payment_method' => $saleData['payment_method'],
                'payment_reference' => $saleData['payment_reference'],
                'notes' => $saleData['notes']
            ]);

            // Create sale items
            foreach ($saleData['items'] as $item) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'discount_type' => $item['discount_type'],
                    'discount_amount' => $item['discount'],
                    'tax_amount' => $item['tax_amount'],
                    'total' => $item['total']
                ]);
            }

            // Handle document uploads
            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $document) {
                    $path = $document->store('sales/documents', 'public');
                    $sale->documents()->create([
                        'document_path' => $path,
                        'document_name' => $document->getClientOriginalName(),
                        'document_type' => $document->getClientMimeType()
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Sale created successfully',
                'sale' => $sale->load('items', 'documents')
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Sale creation failed: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create sale'
            ], 500);
        }
    }

    /**
     * Upload documents for a sale
     */
    public function uploadDocuments(Request $request, Sale $sale)
    {
        try {
            $request->validate([
                'documents.*' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048'
            ]);

            $uploadedDocuments = [];

            foreach ($request->file('documents') as $document) {
                $path = $document->store('sales/documents', 'public');
                
                $doc = $sale->documents()->create([
                    'document_path' => $path,
                    'document_name' => $document->getClientOriginalName(),
                    'document_type' => $document->getClientMimeType()
                ]);

                $uploadedDocuments[] = $doc;
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Documents uploaded successfully',
                'documents' => $uploadedDocuments
            ]);

        } catch (\Exception $e) {
            Log::error('Document upload failed: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to upload documents'
            ], 500);
        }
    }

    /**
     * Delete a document
     */
    public function deleteDocument(SaleDocument $document)
    {
        try {
            $document->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Document deleted successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Document deletion failed: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete document'
            ], 500);
        }
    }

    public function index(Request $request)
    {
        try {
            $query = Sale::with(['customer', 'items'])
                ->when($request->search, function($q) use ($request) {
                    $q->where('sale_no', 'like', "%{$request->search}%")
                      ->orWhereHas('customer', function($q) use ($request) {
                          $q->where('name', 'like', "%{$request->search}%");
                      });
                })
                ->when($request->status, function($q) use ($request) {
                    $q->where('status', $request->status);
                })
                ->when($request->type, function($q) use ($request) {
                    $q->where('sale_type', $request->type);
                })
                ->when($request->date_from, function($q) use ($request) {
                    $q->whereDate('sale_date', '>=', $request->date_from);
                })
                ->when($request->date_to, function($q) use ($request) {
                    $q->whereDate('sale_date', '<=', $request->date_to);
                })
                ->orderBy('created_at', 'desc');

            $sales = $query->paginate(10);

            return response()->json([
                'status' => 'success',
                'data' => $sales->items(),
                'meta' => [
                    'current_page' => $sales->currentPage(),
                    'from' => $sales->firstItem(),
                    'to' => $sales->lastItem(),
                    'total' => $sales->total(),
                    'last_page' => $sales->lastPage()
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching sales: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Error fetching sales'
            ], 500);
        }
    }

    public function ListSales()
    {
        return view('backoffice.sales.list_sales');
    }

    /**
     * Show sale details
     */
    public function show(Sale $sale)
    {
        try {
            $sale->load(['customer', 'items.product', 'documents', 'deliveryPerson']);
            
            return response()->json([
                'status' => 'success',
                'sale' => $sale
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching sale details: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Error fetching sale details'
            ], 500);
        }
    }

    /**
     * Delete sale
     */
    public function destroy(Sale $sale)
    {
        try {
            DB::beginTransaction();

            // Delete related records (documents will be automatically deleted via model events)
            $sale->items()->delete();
            $sale->delete();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Sale deleted successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting sale: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Error deleting sale'
            ], 500);
        }
    }

    /**
     * Show sale view
     */
    public function viewSale($id)
    {
        return view('backoffice.sales.view_sale', compact('id'));
    }

    // Add other controller methods (index, show, updateStatus, destroy) as needed
} 