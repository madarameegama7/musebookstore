<?php

/**
 * Admin Reports Controller
 * Handles functionality for generating and downloading reports
 */
class Reports extends Controller
{
    private $reportsModel;

    public function __construct()
    {
        // Check if user is logged in and is an admin
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            redirect('users/login');
        }

        // Load report helper functions
        require_once APPROOT . '/helpers/Report_Helper.php';

        $this->reportsModel = $this->model('admin_models/M_Reports');
    }

    /**
     * Main reports dashboard
     */
    public function index()
    {
        // Default to current month period
        $startDate = date('Y-m-01'); // First day of current month
        $endDate = date('Y-m-d'); // Today

        // Process date range form submission
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $startDate = $_POST['start_date'] ?? date('Y-m-01');
            $endDate = $_POST['end_date'] ?? date('Y-m-d');
        }

        // Get summary statistics for the period
        $userStats = $this->reportsModel->getUserRegistrationStats($startDate, $endDate);
        $bookStats = $this->reportsModel->getBookListingStats($startDate, $endDate);
        $transactionStats = $this->reportsModel->getTransactionStats($startDate, $endDate);
        $financialStats = $this->reportsModel->getFinancialStats($startDate, $endDate);
        $tokenStats = $this->reportsModel->getTokenStats($startDate, $endDate);
        $requestStats = $this->reportsModel->getBookRequestStats($startDate, $endDate);

        $data = [
            'title' => 'Reports Dashboard',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'user_stats' => $userStats,
            'book_stats' => $bookStats,
            'transaction_stats' => $transactionStats,
            'financial_stats' => $financialStats,
            'token_stats' => $tokenStats,
            'request_stats' => $requestStats
        ];

        $this->view('pages/admin/v_reports_dashboard', $data);
    }

    /**
     * Generate and download user report
     */
    public function users($format = 'html')
    {
        $users = $this->reportsModel->getUserReport();

        if ($format == 'csv') {
            $this->downloadCsv($users, 'users_report');
        } elseif ($format == 'pdf') {
            $this->generatePdf($users, 'User Report', 'users_report');
        } else {
            $data = [
                'title' => 'User Report',
                'users' => $users
            ];

            $this->view('pages/admin/v_user_report', $data);
        }
    }

    /**
     * Generate and download books report
     */
    public function books($format = 'html')
    {
        $books = $this->reportsModel->getBookReport();

        if ($format == 'csv') {
            $this->downloadCsv($books, 'books_report');
        } elseif ($format == 'pdf') {
            $this->generatePdf($books, 'Book Report', 'books_report');
        } else {
            $data = [
                'title' => 'Book Report',
                'books' => $books
            ];

            $this->view('pages/admin/v_book_report', $data);
        }
    }

    /**
     * Generate and download transactions report
     */
    public function transactions($format = 'html')
    {
        $transactions = $this->reportsModel->getTransactionReport();

        if ($format == 'csv') {
            $this->downloadCsv($transactions, 'transactions_report');
        } elseif ($format == 'pdf') {
            $this->generatePdf($transactions, 'Transaction Report', 'transactions_report');
        } else {
            $data = [
                'title' => 'Transaction Report',
                'transactions' => $transactions
            ];

            $this->view('pages/admin/v_transaction_report', $data);
        }
    }

    /**
     * Generate and download payments report
     */
    public function payments($format = 'html')
    {
        $payments = $this->reportsModel->getPaymentReport();

        if ($format == 'csv') {
            $this->downloadCsv($payments, 'payments_report');
        } elseif ($format == 'pdf') {
            $this->generatePdf($payments, 'Payment Report', 'payments_report');
        } else {
            $data = [
                'title' => 'Payment Report',
                'payments' => $payments
            ];

            $this->view('pages/admin/v_payment_report', $data);
        }
    }

    /**
     * Generate statistics for a custom period
     */
    public function customPeriod()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            redirect('admin/reports');
        }

        $startDate = $_POST['start_date'] ?? date('Y-m-01');
        $endDate = $_POST['end_date'] ?? date('Y-m-d');
        $reportType = $_POST['report_type'] ?? 'user';

        switch ($reportType) {
            case 'user':
                $stats = $this->reportsModel->getUserRegistrationStats($startDate, $endDate);
                break;
            case 'book':
                $stats = $this->reportsModel->getBookListingStats($startDate, $endDate);
                break;
            case 'transaction':
                $stats = $this->reportsModel->getTransactionStats($startDate, $endDate);
                break;
            case 'financial':
                $stats = $this->reportsModel->getFinancialStats($startDate, $endDate);
                break;
            case 'token':
                $stats = $this->reportsModel->getTokenStats($startDate, $endDate);
                break;
            case 'request':
                $stats = $this->reportsModel->getBookRequestStats($startDate, $endDate);
                break;
            default:
                $stats = [];
        }

        $format = $_POST['format'] ?? 'html';

        if ($format == 'csv') {
            $this->downloadCsv($stats, $reportType . '_stats');
        } elseif ($format == 'pdf') {
            $this->generatePdf($stats, ucfirst($reportType) . ' Statistics', $reportType . '_stats');
        } else {
            $data = [
                'title' => ucfirst($reportType) . ' Statistics',
                'stats' => $stats,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'report_type' => $reportType
            ];

            $this->view('pages/admin/v_statistics_report', $data);
        }
    }

    /**
     * Helper function to download data as CSV
     */
    private function downloadCsv($data, $filename)
    {
        if (empty($data)) {
            flash('report_message', 'No data available for export', 'alert alert-warning');
            redirect('admin/reports');
        }

        // Set headers for CSV download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '_' . date('Y-m-d') . '.csv"');

        // Create a file pointer connected to the output stream
        $output = fopen('php://output', 'w');

        // Get column headers from first row of data
        fputcsv($output, array_keys((array)$data[0]));

        // Output each row of data
        foreach ($data as $row) {
            fputcsv($output, (array)$row);
        }

        fclose($output);
        exit;
    }

    /**
     * Helper function to generate and download PDF
     * Uses our extended FPDF library
     */
    private function generatePdf($data, $title, $filename)
    {
        if (empty($data)) {
            flash('report_message', 'No data available for export', 'alert alert-warning');
            redirect('admin/reports');
        }

        // Include FPDF and our extension
        $fpdfPath = APPROOT . '/libraries/FPDF/fpdf.php';
        $pdfReportPath = APPROOT . '/libraries/PDF_Report.php';

        if (!file_exists($fpdfPath)) {
            flash('report_message', 'PDF generation is not available. Please install FPDF library in app/libraries/FPDF.', 'alert alert-danger');
            redirect('admin/reports');
            return;
        }

        require_once($fpdfPath);
        require_once($pdfReportPath);

        // Create PDF document using our extended class
        $pdf = new PDF_Report();
        $pdf->AddPage();

        // Set document title
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Muse Bookstore', 0, 1, 'C');
        $pdf->Cell(0, 10, $title, 0, 1, 'C');
        $pdf->Cell(0, 10, 'Generated on ' . date('Y-m-d H:i:s'), 0, 1, 'C');
        $pdf->Ln(10);

        // Get column headers
        $headers = array_keys((array)$data[0]);
        $columnCount = count($headers);

        // Calculate column width (fit to page)
        $pageWidth = 190; // A4 width with margins
        $columnWidth = $pageWidth / $columnCount;

        // Format headers for display
        $formattedHeaders = [];
        foreach ($headers as $header) {
            $formattedHeaders[] = ucfirst(str_replace('_', ' ', $header));
        }

        // Set up header row
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(200, 220, 255);
        $pdf->SetTextColor(0);

        // Write header row
        foreach ($formattedHeaders as $header) {
            $pdf->Cell($columnWidth, 7, $header, 1, 0, 'C', true);
        }
        $pdf->Ln();

        // Set up data rows
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetFillColor(255, 255, 255);
        $fill = false;

        // Write data rows
        foreach ($data as $row) {
            // Check if we're near the bottom of the page
            if ($pdf->GetY() > 250) {
                $pdf->AddPage();

                // Reprint header row
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->SetFillColor(200, 220, 255);

                foreach ($formattedHeaders as $header) {
                    $pdf->Cell($columnWidth, 7, $header, 1, 0, 'C', true);
                }
                $pdf->Ln();
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetFillColor(255, 255, 255);
            }

            // Use our custom method to write the row with proper multi-line handling
            $pdf->WriteRow((array)$row, $columnWidth, 6, 1, $fill);
            $fill = !$fill; // Alternate row colors
        }

        // Output the PDF document for download
        $pdf->Output('D', $filename . '_' . date('Y-m-d') . '.pdf');
        exit;
    }
}
