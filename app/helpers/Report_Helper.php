<?php

/**
 * Report Helper Functions
 * Helper functions for the admin reporting system
 */

/**
 * Get CSS class for user role badge
 * 
 * @param string $role User role
 * @return string CSS class name
 */
function getUserRoleBadgeClass($role)
{
    switch ($role) {
        case 'admin':
            return 'danger';
        case 'parent':
            return 'primary';
        case 'child':
            return 'success';
        case 'ambassador':
            return 'warning text-dark';
        default:
            return 'secondary';
    }
}

/**
 * Get CSS class for status badge
 * 
 * @param string $status Status value
 * @return string CSS class name
 */
function getStatusBadgeClass($status)
{
    switch ($status) {
        case 'active':
        case 'approved':
        case 'completed':
        case 'available':
            return 'success';
        case 'pending':
            return 'warning text-dark';
        case 'inactive':
        case 'declined':
        case 'denied':
        case 'sold':
            return 'danger';
        case 'swapped':
            return 'info';
        default:
            return 'secondary';
    }
}

/**
 * Format currency value
 * 
 * @param float $amount Amount to format
 * @param string $currency Currency code (default: KES)
 * @return string Formatted currency value
 */
function formatCurrency($amount, $currency = 'KES')
{
    return $currency . ' ' . number_format($amount, 2);
}

/**
 * Get human-readable date format
 * 
 * @param string $date Date string
 * @param bool $includeTime Whether to include time
 * @return string Formatted date
 */
function formatReportDate($date, $includeTime = false)
{
    if (empty($date)) {
        return 'N/A';
    }

    return $includeTime
        ? date('Y-m-d H:i', strtotime($date))
        : date('Y-m-d', strtotime($date));
}

/**
 * Get percentage value
 * 
 * @param int $part Part value
 * @param int $total Total value
 * @return int Percentage value
 */
function calculatePercentage($part, $total)
{
    if ($total == 0) {
        return 0;
    }

    return round(($part / $total) * 100);
}

/**
 * Shorten text to specified length
 * 
 * @param string $text Text to shorten
 * @param int $length Maximum length
 * @return string Shortened text
 */
function shortenText($text, $length = 50)
{
    if (strlen($text) <= $length) {
        return $text;
    }

    return substr($text, 0, $length) . '...';
}

/**
 * Generate chart colors for data visualization
 * 
 * @param int $count Number of colors needed
 * @param float $opacity Opacity value (0-1)
 * @return array Array of color strings
 */
function getChartColors($count, $opacity = 0.7)
{
    $baseColors = [
        [255, 99, 132],    // red
        [54, 162, 235],    // blue
        [255, 206, 86],    // yellow
        [75, 192, 192],    // green
        [153, 102, 255],   // purple
        [255, 159, 64],    // orange
        [199, 199, 199],   // gray
        [83, 102, 255],    // indigo
        [40, 159, 64],     // forest green
        [210, 105, 30],    // chocolate
        [128, 0, 128],     // plum
        [0, 128, 128]      // teal
    ];

    $colors = [];

    for ($i = 0; $i < $count; $i++) {
        $colorIndex = $i % count($baseColors);
        $colors[] = 'rgba(' . $baseColors[$colorIndex][0] . ', ' . $baseColors[$colorIndex][1] . ', ' . $baseColors[$colorIndex][2] . ', ' . $opacity . ')';
    }

    return $colors;
}

/**
 * Generate a unique filename for a report export
 * 
 * @param string $reportType Type of report (users, books, etc.)
 * @param string $fileType File type (csv, pdf)
 * @return string Filename
 */
function generateReportFilename($reportType, $fileType = 'csv')
{
    return 'musebookstore_' . $reportType . '_report_' . date('Y-m-d_H-i-s') . '.' . $fileType;
}

/**
 * Group report data by date for charts
 * 
 * @param array $data Array of data objects
 * @param string $dateField Field name containing date
 * @param string $format Date format (Y-m-d, Y-m, etc.)
 * @return array Grouped data counts by date
 */
function groupDataByDate($data, $dateField, $format = 'Y-m')
{
    $grouped = [];

    foreach ($data as $item) {
        $date = date($format, strtotime($item->$dateField));

        if (!isset($grouped[$date])) {
            $grouped[$date] = 0;
        }

        $grouped[$date]++;
    }

    // Sort dates chronologically
    ksort($grouped);

    return $grouped;
}

/**
 * Count occurrences of a field value in an array of objects
 * 
 * @param array $data Array of data objects
 * @param string $field Field name to count
 * @return array Count of each value
 */
function countFieldValues($data, $field)
{
    $counts = [];

    foreach ($data as $item) {
        $value = $item->$field;

        if (!isset($counts[$value])) {
            $counts[$value] = 0;
        }

        $counts[$value]++;
    }

    return $counts;
}

/**
 * Get chart configuration for common report charts
 * 
 * @param string $type Chart type (pie, doughnut, bar, line)
 * @param array $labels Chart labels
 * @param array $data Chart data values
 * @param array $options Additional options
 * @return array Chart configuration
 */
function getChartConfig($type, $labels, $data, $options = [])
{
    $colors = getChartColors(count($data));

    $config = [
        'type' => $type,
        'data' => [
            'labels' => $labels,
            'datasets' => [
                [
                    'data' => $data,
                    'backgroundColor' => $colors,
                    'borderColor' => 'white',
                    'borderWidth' => 1
                ]
            ]
        ],
        'options' => [
            'responsive' => true,
            'maintainAspectRatio' => false
        ]
    ];

    // Merge additional options
    if (!empty($options)) {
        $config['options'] = array_merge($config['options'], $options);
    }

    return $config;
}
