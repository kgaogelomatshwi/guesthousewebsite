<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class EnquiryController extends Controller
{
    public function index(): View
    {
        $enquiries = Enquiry::with('room')->orderByDesc('created_at')->paginate(20);

        return view('admin.enquiries.index', compact('enquiries'));
    }

    public function show(Enquiry $enquiry): View
    {
        $enquiry->load('room');

        return view('admin.enquiries.show', compact('enquiry'));
    }

    public function updateStatus(Request $request, Enquiry $enquiry): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'string', 'max:50'],
        ]);

        $enquiry->update(['status' => $data['status']]);

        return back()->with('success', 'Status updated.');
    }

    public function export(): Response
    {
        $enquiries = Enquiry::orderByDesc('created_at')->get();

        $lines = [];
        $lines[] = 'id,name,email,phone,check_in,check_out,guests,room_id,status,created_at';
        foreach ($enquiries as $enquiry) {
            $lines[] = implode(',', [
                $enquiry->id,
                $this->escape($enquiry->name),
                $this->escape($enquiry->email),
                $this->escape($enquiry->phone),
                $enquiry->check_in,
                $enquiry->check_out,
                $enquiry->guests,
                $enquiry->room_id,
                $enquiry->status,
                $enquiry->created_at,
            ]);
        }

        $csv = implode("\n", $lines);

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="enquiries.csv"',
        ]);
    }

    private function escape(?string $value): string
    {
        $value = (string) $value;
        $value = str_replace('"', '""', $value);
        return '"' . $value . '"';
    }
}
