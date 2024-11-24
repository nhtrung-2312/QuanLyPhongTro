<?php

namespace App\Jobs;

use App\Models\PhongTro;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdatePhongStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $maPhong;

    /**
     * Create a new job instance.
     */
    public function __construct($maPhong)
    {
        $this->maPhong = $maPhong;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $phongTro = PhongTro::find($this->maPhong);

        // Chỉ reset nếu phòng vẫn đang ở trạng thái "Đang xử lý"
        if ($phongTro && $phongTro->TrangThai === 'Đang xử lý') {
            $phongTro->update(['TrangThai' => 'Đang trống']);
        }
    }
}
