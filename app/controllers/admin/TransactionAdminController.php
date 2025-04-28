<?php

require_once __DIR__ . '/../Admin.php';

class TransactionAdminController extends Admin
{
    // List all transactions
    public function manageTransactions()
    {
        $transactions = $this->adminModel->getAllTransactions();
        $data = [
            'title' => 'Manage Transactions',
            'transactions' => $transactions
        ];
        $this->view('pages/admin/v_manage_transactions', $data);
    }

    // Show Edit Transaction Form
    public function editTransaction($transactionId)
    {
        $transaction = $this->adminModel->getTransactionById($transactionId);
        if (!$transaction) {
            Alert_Helper::error('Transaction not found', 'Transaction not found.');
            redirect('admin/transaction/manageTransactions');
        }
        $data = [
            'transaction_id' => $transactionId,
            'user_id' => $transaction->user_id,
            'book_id' => $transaction->book_id,
            'type' => $transaction->type,
            'status' => $transaction->status,
            'amount' => $transaction->amount,
            'date' => $transaction->date,
            'title' => 'Edit Transaction',
            'user_id_err' => '',
            'book_id_err' => '',
            'type_err' => '',
            'status_err' => '',
            'amount_err' => '',
            'date_err' => ''
        ];
        $this->view('pages/admin/v_edit_transaction', $data);
    }

    // Handle Update Transaction Submission
    public function updateTransaction($transactionId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $transaction = $this->adminModel->getTransactionById($transactionId);
            if (!$transaction) {
                Alert_Helper::error('Transaction not found', 'Transaction not found.');
                redirect('admin/transaction/manageTransactions');
                return;
            }
            $data = [
                'transaction_id' => $transactionId,
                'user_id' => trim($_POST['user_id']),
                'book_id' => trim($_POST['book_id']),
                'type' => trim($_POST['type']),
                'status' => trim($_POST['status']),
                'amount' => trim($_POST['amount']),
                'date' => trim($_POST['date']),
                'title' => 'Edit Transaction',
                'user_id_err' => '',
                'book_id_err' => '',
                'type_err' => '',
                'status_err' => '',
                'amount_err' => '',
                'date_err' => ''
            ];
            // Validation
            if (empty($data['user_id'])) {
                $data['user_id_err'] = 'Please select a user';
            }
            if (empty($data['book_id'])) {
                $data['book_id_err'] = 'Please select a book';
            }
            if (empty($data['type'])) {
                $data['type_err'] = 'Please enter transaction type';
            }
            if (empty($data['status'])) {
                $data['status_err'] = 'Please enter status';
            }
            if (empty($data['amount'])) {
                $data['amount_err'] = 'Please enter amount';
            } elseif (!is_numeric($data['amount']) || $data['amount'] < 0) {
                $data['amount_err'] = 'Please enter a valid amount';
            }
            if (empty($data['date'])) {
                $data['date_err'] = 'Please enter date';
            }
            if (empty($data['user_id_err']) && empty($data['book_id_err']) && empty($data['type_err']) && empty($data['status_err']) && empty($data['amount_err']) && empty($data['date_err'])) {
                if ($this->adminModel->updateTransaction($transactionId, $data)) {
                    Alert_Helper::success('Success', 'Transaction updated successfully.');
                    redirect('admin/transaction/manageTransactions');
                } else {
                    Alert_Helper::error('Update failed', 'Failed to update transaction.');
                    $this->view('pages/admin/v_edit_transaction', $data);
                }
            } else {
                $this->view('pages/admin/v_edit_transaction', $data);
            }
        } else {
            redirect('admin/transaction/manageTransactions');
        }
    }

    // Delete Transaction (Handles POST request)
    public function deleteTransaction($transactionId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->adminModel->deleteTransactionById($transactionId)) {
                Alert_Helper::success('Success', 'Transaction deleted successfully.');
            } else {
                Alert_Helper::error('Delete failed', 'Failed to delete transaction.');
            }
            redirect('admin/transaction/manageTransactions');
        } else {
            redirect('admin/transaction/manageTransactions');
        }
    }

    // Approve a transaction
    public function approveTransaction($transactionId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->adminModel->updateTransactionStatus($transactionId, 'approved')) {
                Alert_Helper::success('Success', 'Transaction approved successfully.');
            } else {
                Alert_Helper::error('Approval failed', 'Failed to approve transaction.');
            }
            redirect('admin/transaction/manageTransactions');
        } else {
            redirect('admin/transaction/manageTransactions');
        }
    }

    // Decline a transaction
    public function declineTransaction($transactionId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->adminModel->updateTransactionStatus($transactionId, 'declined')) {
                Alert_Helper::success('Success', 'Transaction declined.');
            } else {
                Alert_Helper::error('Decline failed', 'Failed to decline transaction.');
            }
            redirect('admin/transaction/manageTransactions');
        } else {
            redirect('admin/transaction/manageTransactions');
        }
    }
}
