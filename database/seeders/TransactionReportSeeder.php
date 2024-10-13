<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\TransactionReport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 transactions
        $transactions = Transaction::factory()->count(10)->create();

        // For each transaction, create one transaction report
        foreach ($transactions as $transaction) {
            TransactionReport::factory()->create([
                'transaction_id' => $transaction->id,
            ]);
        }
    }
}
