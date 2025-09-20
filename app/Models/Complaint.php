<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $guarded =[];

    public function getStatusLabelAttribute() //status label
    {
       return match($this->ststus){
        'new' => 'Baru',
        'processing' => 'Sedang Diproses',
        'completed' => 'Selesai',
        default => 'Tidak Diketahui',
       };

    }
    public function GetReportDateLabelAttribute() //Report_date_label
    {
        return \Carbon\Carbon::parse($this->report_date)->format('d M Y H:1:s');
    }
}
