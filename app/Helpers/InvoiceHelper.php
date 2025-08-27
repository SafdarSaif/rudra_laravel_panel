<?php

namespace App\Helpers;

use App\Models\Ledger;
use App\Models\Student;
use App\Models\University;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader;
use Rmunate\Utilities\SpellNumber;

class InvoiceHelper
{
    /**
     * Generate Invoice PDF
     */
    public static function generateInvoicePdf($ledgerId, $savePath)
    {
        $student_data = Ledger::where('id', $ledgerId)->first();
        $student = Student::select('students.*', 'courses.name as course_name')
            ->leftJoin('courses', 'courses.id', '=', 'students.course_id')
            ->where('students.id', $student_data->student_id)
            ->first();

        $university = University::select('name as uni_name')
            ->where('id', $student->university_id)
            ->first();

        $total_fee = $student->total_fee;
        $received_fee = $student_data->fee_received;
        $due_fee = $student->total_fee - $received_fee;
        $feeinwords = SpellNumber::value($received_fee)->locale('en')->toLetters();

        $pdf = new Fpdi();
        $pdf->AddPage();
        $pdf->setSourceFile(base_path('public/admin/pdf/edufinal.pdf'));
        $pageId = $pdf->importPage(1, PdfReader\PageBoundaries::MEDIA_BOX);
        $pdf->useImportedPage($pageId, 0, 0, 210);
        $pdf->SetFont('Arial','',11);

        // Fill Data
        $pdf->SetXY(60, 86);  $pdf->Write(1, $student->name);
        $pdf->SetXY(54, 96);  $pdf->Write(1, $student->father_name);
        $pdf->SetXY(54, 105); $pdf->Write(1, $student->course_name);
        $pdf->SetXY(160, 168);$pdf->Write(1, $total_fee."/INR");
        $pdf->SetXY(176, 176);$pdf->Write(1, $due_fee);
        $pdf->SetXY(47, 78);  $pdf->Write(1, $student_data->student_id.'/'.$student_data->created_at->format('Y'));
        $pdf->SetXY(133, 78); $pdf->Write(1, $student_data->created_at->format('d-m-Y'));
        $pdf->SetXY(150, 196.5); $pdf->Write(1, $student_data->transaction_id);
        $pdf->SetXY(160, 139); $pdf->Write(1, $received_fee.'/-');
        $pdf->SetXY(55, 196.5); $pdf->Write(1, $student_data->mode);

        // ✅ Save PDF file
        $pdf->Output('F', $savePath);
    }
}
