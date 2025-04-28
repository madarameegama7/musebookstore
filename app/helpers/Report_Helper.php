<?php

/**
 * Report helper functions
 * Contains utility functions for report views
 */

/**
 * Get badge color class for user role
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
 * Get badge color class for book status
 */
function getStatusBadgeClass($status)
{
    switch ($status) {
        case 'available':
            return 'success';
        case 'sold':
            return 'danger';
        case 'swapped':
            return 'info';
        default:
            return 'secondary';
    }
}

/**
 * Get badge color class for transaction status
 */
function getTransactionStatusBadgeClass($status)
{
    switch ($status) {
        case 'pending':
            return 'warning text-dark';
        case 'approved':
            return 'info';
        case 'declined':
            return 'danger';
        case 'completed':
            return 'success';
        default:
            return 'secondary';
    }
}

/**
 * Get badge color class for payment status
 */
function getPaymentStatusBadgeClass($status)
{
    switch ($status) {
        case 'completed':
            return 'success';
        case 'pending':
            return 'warning text-dark';
        case 'failed':
            return 'danger';
        default:
            return 'secondary';
    }
}
