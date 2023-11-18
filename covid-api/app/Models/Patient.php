<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'patients';
    protected $fillable = ['status_id', 'name', 'phone', 'address', 'in_date_at', 'out_date_at'];

    public function scopeFilterAndSort($query, $request) // Menggunakan scope Agar bisa menggunakan ::
    {
        return $query
            ->from('patients as a')
            ->leftJoin('patient_status as b', 'a.status_id', '=', 'b.id')
            ->select('a.*', 'b.name as status_name')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('a.name', 'like', '%' . $name . '%');
            })
            ->when($request->input('address'), function ($query, $address) {
                return $query->where('a.address', 'like', '%' . $address . '%');
            })
            ->when($request->input('status'), function ($query, $status) {
                return $query->where('b.name', $status);
            })
            ->when($request->has('sort'), function ($query) use ($request) {
                $order = $request->input('order', 'asc');

                switch ($request->input('sort')) {
                    case 'tanggal_masuk':
                        $query->orderBy('a.in_date_at', $order);
                        break;
                    case 'tanggal_keluar':
                        $query->orderBy('a.out_date_at', $order);
                        break;
                    case 'address':
                        $query->orderBy('a.address', $order);
                        break;
                }
            });
    }

    public function status() // Fungsi untuk relasi antara table pasien dengan pasien_status
    {
        return $this->belongsTo(PatientStatus::class, 'status_id', 'id');
    }
}
