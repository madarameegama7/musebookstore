<?php

require_once __DIR__ . '/../Admin.php';

/**
 * Admin Reports Controller
 * Handles functionality for generating and downloading reports
 */
class ReportsAdminController extends Admin
{
    private $reportsModel;

    public function __construct()
    {
        // Call parent constructor to handle admin authentication
        parent::__construct();

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
        $startDate = $_SESSION['report_filter_start_date'] ?? date('Y-m-01'); // First day of current month
        $endDate = $_SESSION['report_filter_end_date'] ?? date('Y-m-d'); // Today

        // Process date range form submission
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $startDate = $_POST['start_date'] ?? date('Y-m-01');
            $endDate = $_POST['end_date'] ?? date('Y-m-d');

            // Store filter settings in session for persistence
            $_SESSION['report_filter_start_date'] = $startDate;
            $_SESSION['report_filter_end_date'] = $endDate;
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
        // Get filter parameters from POST, GET or session
        $filters = $this->getReportFilters('user');

        // Get filtered users based on criteria
        $users = $this->reportsModel->getUserReport($filters);

        if ($format == 'csv') {
            $this->downloadCsv($users, 'users_report');
        } elseif ($format == 'pdf') {
            $this->generatePdf($users, 'User Report', 'users_report');
        } else {
            // Get available roles for filter dropdown
            $roles = ['admin', 'parent', 'child', 'ambassador'];

            $data = [
                'title' => 'User Report',
                'users' => $users,
                'filters' => $filters,
                'roles' => $roles
            ];

            $this->view('pages/admin/v_user_report', $data);
        }
    }

    /**
     * Generate and download books report
     */
    public function books($format = 'html')
    {
        // Get filter parameters from POST, GET or session
        $filters = $this->getReportFilters('book');

        // Get filtered books based on criteria
        $books = $this->reportsModel->getBookReport($filters);

        if ($format == 'csv') {
            $this->downloadCsv($books, 'books_report');
        } elseif ($format == 'pdf') {
            $this->generatePdf($books, 'Book Report', 'books_report');
        } else {
            // Get available genres and conditions for filter dropdowns
            $genres = $this->reportsModel->getDistinctBookGenres();
            $conditions = ['new', 'used'];
            $statuses = ['available', 'sold', 'swapped'];
            $listingTypes = ['sell', 'swap'];

            $data = [
                'title' => 'Book Report',
                'books' => $books,
                'filters' => $filters,
                'genres' => $genres,
                'conditions' => $conditions,
                'statuses' => $statuses,
                'listingTypes' => $listingTypes
            ];

            $this->view('pages/admin/v_book_report', $data);
        }
    }

    /**
     * Generate and download transactions report
     */
    public function transactions($format = 'html')
    {
        // Get filter parameters from POST, GET or session
        $filters = $this->getReportFilters('transaction');

        // Get filtered transactions based on criteria
        $transactions = $this->reportsModel->getTransactionReport($filters);

        if ($format == 'csv') {
            $this->downloadCsv($transactions, 'transactions_report');
        } elseif ($format == 'pdf') {
            $this->generatePdf($transactions, 'Transaction Report', 'transactions_report');
        } else {
            // Get available transaction types and statuses for filter dropdowns
            $types = ['sell', 'swap'];
            $statuses = ['pending', 'approved', 'declined', 'completed'];

            $data = [
                'title' => 'Transaction Report',
                'transactions' => $transactions,
                'filters' => $filters,
                'types' => $types,
                'statuses' => $statuses
            ];

            $this->view('pages/admin/v_transaction_report', $data);
        }
    }

    /**
     * Generate and download payments report
     */
    public function payments($format = 'html')
    {
        // Get filter parameters from POST, GET or session
        $filters = $this->getReportFilters('payment');

        // Get filtered payments based on criteria
        $payments = $this->reportsModel->getPaymentReport($filters);

        if ($format == 'csv') {
            $this->downloadCsv($payments, 'payments_report');
        } elseif ($format == 'pdf') {
            $this->generatePdf($payments, 'Payment Report', 'payments_report');
        } else {
            // Get available payment types and statuses for filter dropdowns
            $types = ['Book Purchase', 'Token Purchase'];
            $statuses = ['pending', 'completed', 'failed', 'refunded'];

            $data = [
                'title' => 'Payment Report',
                'payments' => $payments,
                'filters' => $filters,
                'types' => $types,
                'statuses' => $statuses
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
            redirect('admin/reports/index');
        }

        $startDate = $_POST['start_date'] ?? date('Y-m-01');
        $endDate = $_POST['end_date'] ?? date('Y-m-d');
        $reportType = $_POST['report_type'] ?? 'user';

        // Store filter settings in session for persistence
        $_SESSION['report_filter_start_date'] = $startDate;
        $_SESSION['report_filter_end_date'] = $endDate;
        $_SESSION['report_filter_type'] = $reportType;

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
     * Helper method to get and process report filters
     * Retrieves filters from POST or session and handles persistence
     */
    private function getReportFilters($reportType)
    {
        $sessionKey = 'report_filter_' . $reportType;
        $filters = $_SESSION[$sessionKey] ?? [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['filter_submitted'])) {
            // Process date range
            $filters['start_date'] = $_POST['start_date'] ?? date('Y-m-01');
            $filters['end_date'] = $_POST['end_date'] ?? date('Y-m-d');

            // Process specific filters based on report type
            switch ($reportType) {
                case 'user':
                    $filters['role'] = $_POST['role'] ?? '';
                    $filters['status'] = $_POST['status'] ?? '';
                    $filters['search'] = $_POST['search'] ?? '';
                    break;

                case 'book':
                    $filters['genre'] = $_POST['genre'] ?? '';
                    $filters['condition'] = $_POST['condition'] ?? '';
                    $filters['status'] = $_POST['status'] ?? '';
                    $filters['listing_type'] = $_POST['listing_type'] ?? '';
                    $filters['child_safe'] = $_POST['child_safe'] ?? '';
                    $filters['search'] = $_POST['search'] ?? '';
                    break;

                case 'transaction':
                    $filters['type'] = $_POST['type'] ?? '';
                    $filters['status'] = $_POST['status'] ?? '';
                    $filters['search'] = $_POST['search'] ?? '';
                    break;

                case 'payment':
                    $filters['type'] = $_POST['type'] ?? '';
                    $filters['status'] = $_POST['status'] ?? '';
                    $filters['min_amount'] = $_POST['min_amount'] ?? '';
                    $filters['max_amount'] = $_POST['max_amount'] ?? '';
                    $filters['search'] = $_POST['search'] ?? '';
                    break;

                default:
                    break;
            }

            // Store filters in session
            $_SESSION[$sessionKey] = $filters;
        }

        // Add default date range if not set
        if (!isset($filters['start_date'])) {
            $filters['start_date'] = $_SESSION['report_filter_start_date'] ?? date('Y-m-01');
        }

        if (!isset($filters['end_date'])) {
            $filters['end_date'] = $_SESSION['report_filter_end_date'] ?? date('Y-m-d');
        }

        return $filters;
    }

    /**
     * Clear all report filters 
     */
    public function clearFilters($reportType = null, $redirect = 'index')
    {
        if ($reportType) {
            $sessionKey = 'report_filter_' . $reportType;
            if (isset($_SESSION[$sessionKey])) {
                unset($_SESSION[$sessionKey]);
            }
        } else {
            // Clear all report filters
            foreach ($_SESSION as $key => $value) {
                if (strpos($key, 'report_filter_') === 0) {
                    unset($_SESSION[$key]);
                }
            }
        }

        redirect('admin/reports/' . $redirect);
    }

    /**
     * Helper function to download data as CSV
     */
    private function downloadCsv($data, $filename)
    {
        if (empty($data)) {
            flash('report_message', 'No data available for export', 'alert alert-warning');
            redirect('admin/reports/index');
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
            redirect('admin/reports/index');
        }

        // Include FPDF and our extension
        $fpdfPath = APPROOT . '/libraries/FPDF/fpdf.php';
        $pdfReportPath = APPROOT . '/libraries/PDF_Report.php';

        if (!file_exists($fpdfPath)) {
            flash('report_message', 'PDF generation is not available. Please install FPDF library in app/libraries/FPDF.', 'alert alert-danger');
            redirect('admin/reports/index');
            return;
        }

        require_once($fpdfPath);
        require_once($pdfReportPath);

        // Create PDF document using our extended class
        $pdf = new PDF_Report();
        $pdf->AddPage();

        // Add company logo if available
        $logoPath = ROOTDIR . '/public/img/muse logo.png';
        if (file_exists($logoPath)) {
            $pdf->Image($logoPath, 10, 10, 30);
            $pdf->Ln(15);
        }

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
