<?php

namespace App\Http\Controllers;

use App\Exports\License_platesExport;
use App\Models\LicensePlate;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AdminLicensePlateController extends Controller
{
    private $licensePlates;
    public function __construct(LicensePlate $licensePlates)
    {
        $this->licensePlates = $licensePlates;
    }
    public function index()
    {
        $sidebar = 'licensePlates';
        $licensePlates = $this->licensePlates->latest()->paginate(5);
        return view('administrator.license-plates.index', compact('sidebar', 'licensePlates'));
    }
    public function indexQuery($query){
        $parts = explode('?', $query);
        $from = isset($parts[0]) ? str_replace("-", "/", $parts[0]) : null;
        $to = isset($parts[1]) ? str_replace("-", "/", $parts[1]) : null;
        $search = isset($parts[2]) ? $parts[2] : null;
        try {
            $fromDate = $from ? \Carbon\Carbon::createFromFormat('m/d/Y', $from)->startOfDay() : null;
        } catch (\Exception $e) {
            $fromDate = null;
        }

        try {
            $toDate = $to ? \Carbon\Carbon::createFromFormat('m/d/Y', $to)->endOfDay() : null;
        } catch (\Exception $e) {
            $toDate = null;
        }
        $query = $this->licensePlates->query();
        if ($fromDate) {
            $query->where('created_at', '>=', $fromDate);
        }
        if ($toDate) {
            $query->where('created_at', '<=', $toDate);
        }
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('license_number', 'like', '%' . $search . '%')
                  ->orWhere('price', 'like', '%' . $search . '%');
            });
        }
        $sidebar = 'licensePlates';
        $licensePlates = $query->latest()->paginate(5);
        $dateQuery = !$from ? null : $from . ' - ' . $to;
        return view('administrator.license-plates.index', compact('sidebar', 'licensePlates', 'dateQuery', 'search'));
    }
    public function export()
    {
        return Excel::download(new License_platesExport, 'license_plates.xlsx');
    }
}
