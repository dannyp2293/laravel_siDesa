<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $guarded =[];

    public function getStatusLabelAttribute() //status label
    {
       return match($this->status){
        'new' => 'Baru',
        'processing' => 'Sedang Diproses',
        'completed' => 'Selesai',
        default => 'Tidak Diketahui',
       };

    }
    public function GetReportDateLabelAttribute() //Report_date_label
    {
        return \Carbon\Carbon::parse($this->report_date)->format('d M Y H:i:s');
    }
    public function getStatusColorAttribute() //status_color
    {
        return match($this->status){
        'new' => 'primary',
        'processing' => 'warning',
        'completed' => 'success',
        default => 'secondary',
       };

    }
    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }
}
