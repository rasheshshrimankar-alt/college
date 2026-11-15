<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FormSubmission;
use Illuminate\Http\Request;
use ZipArchive;

class FormSubmissionController extends Controller
{
    public function index(Request $request)
    {
        $query = FormSubmission::query();

        if ($request->filled('type')) {
            $query->where('form_type', $request->string('type')->toString());
        }

        if ($request->filled('search')) {
            $term = $request->string('search')->toString();
            $query->where(function ($builder) use ($term) {
                $builder->where('name', 'like', '%' . $term . '%')
                    ->orWhere('email', 'like', '%' . $term . '%')
                    ->orWhere('phone', 'like', '%' . $term . '%');
            });
        }

        $submissions = $query->latest()->paginate(20)->withQueryString();
        $total = FormSubmission::count();
        $types = FormSubmission::query()
            ->select('form_type')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('form_type')
            ->orderBy('form_type')
            ->get();

        return view('admin.form-submissions.index', compact('submissions', 'total', 'types'));
    }

    public function export(Request $request)
    {
        $query = FormSubmission::query()->latest();

        if ($request->filled('type')) {
            $query->where('form_type', $request->string('type')->toString());
        }

        $submissions = $query->get();
        $rows = [[
            'Submitted At', 'Form Type', 'Name', 'Email', 'Phone', 'Account', 'Additional Details',
        ]];

        foreach ($submissions as $submission) {
            $details = [];
            foreach (($submission->payload ?? []) as $key => $value) {
                if (is_array($value)) {
                    $value = json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                }
                $details[] = ucfirst(str_replace('_', ' ', (string) $key)) . ': ' . (string) $value;
            }

            $rows[] = [
                optional($submission->created_at)->format('Y-m-d H:i:s'),
                $submission->form_type,
                $submission->name,
                $submission->email,
                $submission->phone,
                $submission->user_id ? 'Registered account' : 'Guest',
                implode(' | ', $details),
            ];
        }

        if (!class_exists(ZipArchive::class)) {
            return back()->with('error', 'Excel export is unavailable because the ZIP extension is missing.');
        }

        $file = tempnam(sys_get_temp_dir(), 'smart-campus-');
        if ($file === false) {
            return back()->with('error', 'Unable to prepare the Excel file. Please try again.');
        }
        @unlink($file);
        $file .= '.xlsx';

        $zip = new ZipArchive();
        if ($zip->open($file, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            return back()->with('error', 'Unable to create the Excel workbook. Please try again.');
        }

        $zip->addFromString('[Content_Types].xml', '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'
            . '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>'
            . '<Default Extension="xml" ContentType="application/xml"/>'
            . '<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>'
            . '<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>'
            . '</Types>');

        $zip->addFromString('_rels/.rels', '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>'
            . '</Relationships>');

        $zip->addFromString('xl/workbook.xml', '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" '
            . 'xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
            . '<sheets><sheet name="Form Submissions" sheetId="1" r:id="rId1"/></sheets></workbook>');

        $zip->addFromString('xl/_rels/workbook.xml.rels', '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>'
            . '</Relationships>');

        $sheet = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main"><sheetData>';

        foreach ($rows as $rowIndex => $row) {
            $excelRow = $rowIndex + 1;
            $sheet .= '<row r="' . $excelRow . '">';
            foreach ($row as $columnIndex => $value) {
                $column = '';
                $number = $columnIndex + 1;
                while ($number > 0) {
                    $remainder = ($number - 1) % 26;
                    $column = chr(65 + $remainder) . $column;
                    $number = intdiv($number - 1, 26);
                }

                $text = (string) ($value ?? '');
                $text = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F]/u', '', $text) ?? '';
                $escaped = htmlspecialchars($text, ENT_XML1 | ENT_COMPAT, 'UTF-8');
                $sheet .= '<c r="' . $column . $excelRow . '" t="inlineStr"><is><t xml:space="preserve">'
                    . $escaped . '</t></is></c>';
            }
            $sheet .= '</row>';
        }

        $sheet .= '</sheetData></worksheet>';
        $zip->addFromString('xl/worksheets/sheet1.xml', $sheet);
        $zip->close();

        return response()->download($file, 'smart-campus-form-submissions-' . now()->format('Y-m-d') . '.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }
}
