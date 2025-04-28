<?php

require_once __DIR__ . '/../Admin.php';

class PaymentAdminController extends Admin
{
    // List all payments
    public function managePayments()
    {
        $payments = $this->adminModel->getAllPayments();
        $data = [
            'title' => 'Manage Payments',
            'payments' => $payments
        ];
        $this->view('pages/admin/v_manage_payments', $data);
    }

    // Show Add Payment Form (GET) / Handle Add Payment Submission (POST)
    public function addPayment()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'user_id' => trim($_POST['user_id']),
                'amount' => trim($_POST['amount']),
                'payment_date' => trim($_POST['payment_date']),
                'payment_method' => trim($_POST['payment_method']),
                'title' => 'Add New Payment',
                'user_id_err' => '',
                'amount_err' => '',
                'payment_date_err' => '',
                'payment_method_err' => ''
            ];
            // Validation
            if (empty($data['user_id'])) {
                $data['user_id_err'] = 'Please select a user';
            }
            if (empty($data['amount'])) {
                $data['amount_err'] = 'Please enter amount';
            } elseif (!is_numeric($data['amount']) || $data['amount'] < 0) {
                $data['amount_err'] = 'Please enter a valid amount';
            }
            if (empty($data['payment_date'])) {
                $data['payment_date_err'] = 'Please enter payment date';
            }
            if (empty($data['payment_method'])) {
                $data['payment_method_err'] = 'Please enter payment method';
            }
            if (empty($data['user_id_err']) && empty($data['amount_err']) && empty($data['payment_date_err']) && empty($data['payment_method_err'])) {
                if ($this->adminModel->addPayment($data)) {
                    Alert_Helper::success('Success', 'Payment added successfully.');
                    redirect('admin/payment/managePayments');
                } else {
                    Alert_Helper::error('Add failed', 'Failed to add payment.');
                    $this->view('pages/admin/v_add_payment', $data);
                }
            } else {
                $this->view('pages/admin/v_add_payment', $data);
            }
        } else {
            $data = [
                'user_id' => '',
                'amount' => '',
                'payment_date' => '',
                'payment_method' => '',
                'title' => 'Add New Payment',
                'user_id_err' => '',
                'amount_err' => '',
                'payment_date_err' => '',
                'payment_method_err' => ''
            ];
            $this->view('pages/admin/v_add_payment', $data);
        }
    }

    // Show Edit Payment Form
    public function editPayment($paymentId)
    {
        $payment = $this->adminModel->getPaymentById($paymentId);
        if (!$payment) {
            Alert_Helper::error('Payment not found', 'Payment not found.');
            redirect('admin/payment/managePayments');
        }
        $data = [
            'payment_id' => $paymentId,
            'user_id' => $payment->user_id,
            'amount' => $payment->amount,
            'payment_date' => $payment->payment_date,
            'payment_method' => $payment->payment_method,
            'title' => 'Edit Payment',
            'user_id_err' => '',
            'amount_err' => '',
            'payment_date_err' => '',
            'payment_method_err' => ''
        ];
        $this->view('pages/admin/v_edit_payment', $data);
    }

    // Handle Update Payment Submission
    public function updatePayment($paymentId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $payment = $this->adminModel->getPaymentById($paymentId);
            if (!$payment) {
                Alert_Helper::error('Payment not found', 'Payment not found.');
                redirect('admin/payment/managePayments');
                return;
            }
            $data = [
                'payment_id' => $paymentId,
                'user_id' => trim($_POST['user_id']),
                'amount' => trim($_POST['amount']),
                'payment_date' => trim($_POST['payment_date']),
                'payment_method' => trim($_POST['payment_method']),
                'title' => 'Edit Payment',
                'user_id_err' => '',
                'amount_err' => '',
                'payment_date_err' => '',
                'payment_method_err' => ''
            ];
            // Validation (same as addPayment)
            if (empty($data['user_id'])) {
                $data['user_id_err'] = 'Please select a user';
            }
            if (empty($data['amount'])) {
                $data['amount_err'] = 'Please enter amount';
            } elseif (!is_numeric($data['amount']) || $data['amount'] < 0) {
                $data['amount_err'] = 'Please enter a valid amount';
            }
            if (empty($data['payment_date'])) {
                $data['payment_date_err'] = 'Please enter payment date';
            }
            if (empty($data['payment_method'])) {
                $data['payment_method_err'] = 'Please enter payment method';
            }
            if (empty($data['user_id_err']) && empty($data['amount_err']) && empty($data['payment_date_err']) && empty($data['payment_method_err'])) {
                if ($this->adminModel->updatePayment($paymentId, $data)) {
                    Alert_Helper::success('Success', 'Payment updated successfully.');
                    redirect('admin/payment/managePayments');
                } else {
                    Alert_Helper::error('Update failed', 'Failed to update payment.');
                    $this->view('pages/admin/v_edit_payment', $data);
                }
            } else {
                $this->view('pages/admin/v_edit_payment', $data);
            }
        } else {
            redirect('admin/payment/managePayments');
        }
    }

    // Delete Payment (Handles POST request)
    public function deletePayment($paymentId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->adminModel->deletePaymentById($paymentId)) {
                Alert_Helper::success('Success', 'Payment deleted successfully.');
            } else {
                Alert_Helper::error('Delete failed', 'Failed to delete payment.');
            }
            redirect('admin/payment/managePayments');
        } else {
            redirect('admin/payment/managePayments');
        }
    }

    // Payment report for admin
    public function reportPayments()
    {
        $totalPayments = $this->adminModel->getTotalPaymentsReceived();
        $paymentsByMonth = [];
        for ($m = 1; $m <= 12; $m++) {
            $paymentsByMonth[$m] = $this->adminModel->getPaymentsReceivedInMonth($m, date('Y'));
        }
        $payments = $this->adminModel->getAllPayments();
        $data = [
            'title' => 'Payment Report',
            'totalPayments' => $totalPayments,
            'paymentsByMonth' => $paymentsByMonth,
            'payments' => $payments
        ];
        $this->view('pages/admin/v_payment_report', $data);
    }
}
