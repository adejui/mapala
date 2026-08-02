<?php

namespace App\Console\Commands;

use App\Mail\LoanOverdueMail;
use App\Mail\LoanReminderMail;
use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendLoanDateNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'loans:send-date-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim email pengingat H-1 dan email keterlambatan H+1 untuk peminjaman';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $tomorrow = Carbon::tomorrow()->toDateString();
        $yesterday = Carbon::yesterday()->toDateString();

        // ==============================
        // H-1 Pengingat Pengembalian
        // ==============================
        $dueSoon = Loan::with(['user', 'opa', 'details.item'])
            ->where('status', 'borrowed')
            ->whereDate('return_date', $tomorrow)
            ->get();

        foreach ($dueSoon as $loan) {

            $data = $this->buildData($loan);

            if ($data['email']) {

                Mail::to($data['email'])->send(new LoanReminderMail($data));

                $this->info("Reminder berhasil dikirim ke {$data['email']}");
            }
        }

        // ==============================
        // H+1 Terlambat Mengembalikan
        // ==============================
        $overdue = Loan::with(['user', 'opa', 'details.item'])
            ->where('status', 'borrowed')
            ->whereDate('return_date', $yesterday)
            ->get();

        foreach ($overdue as $loan) {

            $data = $this->buildData($loan);

            if ($data['email']) {

                Mail::to($data['email'])->send(new LoanOverdueMail($data));

                $this->info("Email keterlambatan berhasil dikirim ke {$data['email']}");
            }
        }

        $this->newLine();
        $this->info("=========================================");
        $this->info("Reminder terkirim : {$dueSoon->count()}");
        $this->info("Overdue terkirim  : {$overdue->count()}");
        $this->info("=========================================");
    }

    /**
     * Build email data.
     */
    private function buildData(Loan $loan): array
    {
        $user = $loan->user;
        $opa = $loan->opa;

        return [
            'id' => $loan->id,
            'name' => optional($user)->full_name ?? optional($opa)->name ?? '-',
            'email' => optional($user)->email ?? optional($opa)->email,
            'organization_name' => optional($opa)->organization_name,
            'campus_name' => optional($opa)->campus_name,
            'phone_number' => optional($user)->phone_number ?? optional($opa)->phone_number,
            'borrow_date' => $loan->borrow_date,
            'return_date' => $loan->return_date,
            'quantity' => $loan->details->sum('quantity'),
        ];
    }
}
