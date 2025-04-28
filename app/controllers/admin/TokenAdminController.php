<?php

require_once __DIR__ . '/../Admin.php';

class TokenAdminController extends Admin
{
    // List all tokens
    public function manageTokens()
    {
        $tokens = $this->adminModel->getAllTokens();
        $users = $this->adminModel->getAllUsers();
        $data = [
            'title' => 'Manage Tokens',
            'tokens' => $tokens,
            'users' => $users
        ];
        $this->view('pages/admin/v_manage_tokens', $data);
    }

    // Show Add Token Form (GET) / Handle Add Token Submission (POST)
    public function addToken()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'user_id' => trim($_POST['user_id']),
                'token_count' => trim($_POST['token_count']),
                'amount_paid' => trim($_POST['amount_paid']),
                'purchase_date' => trim($_POST['purchase_date']),
                'title' => 'Add New Token',
                'user_id_err' => '',
                'token_count_err' => '',
                'amount_paid_err' => '',
                'purchase_date_err' => ''
            ];
            // Validation
            if (empty($data['user_id'])) {
                $data['user_id_err'] = 'Please select a user';
            }
            if (empty($data['token_count'])) {
                $data['token_count_err'] = 'Please enter token count';
            } elseif (!is_numeric($data['token_count']) || $data['token_count'] < 0) {
                $data['token_count_err'] = 'Please enter a valid token count';
            }
            if (empty($data['amount_paid'])) {
                $data['amount_paid_err'] = 'Please enter amount paid';
            } elseif (!is_numeric($data['amount_paid']) || $data['amount_paid'] < 0) {
                $data['amount_paid_err'] = 'Please enter a valid amount';
            }
            if (empty($data['purchase_date'])) {
                $data['purchase_date_err'] = 'Please enter purchase date';
            }
            if (empty($data['user_id_err']) && empty($data['token_count_err']) && empty($data['amount_paid_err']) && empty($data['purchase_date_err'])) {
                if ($this->adminModel->addToken($data)) {
                    Alert_Helper::success('Success', 'Token record added.');
                    redirect('admin/token/manageTokens');
                } else {
                    Alert_Helper::error('Add failed', 'Failed to add token.');
                    $this->view('pages/admin/v_add_token', $data);
                }
            } else {
                $this->view('pages/admin/v_add_token', $data);
            }
        } else {
            $data = [
                'user_id' => '',
                'token_count' => '',
                'amount_paid' => '',
                'purchase_date' => '',
                'title' => 'Add New Token',
                'user_id_err' => '',
                'token_count_err' => '',
                'amount_paid_err' => '',
                'purchase_date_err' => ''
            ];
            $this->view('pages/admin/v_add_token', $data);
        }
    }

    // Show Edit Token Form
    public function editToken($tokenId)
    {
        $token = null;
        foreach ($this->adminModel->getAllTokens() as $t) {
            if ($t->token_id == $tokenId) $token = $t;
        }
        $users = $this->adminModel->getAllUsers();
        if (!$token) {
            Alert_Helper::error('Token not found', 'Token not found.');
            redirect('admin/token/manageTokens');
        }
        $data = [
            'token_id' => $tokenId,
            'user_id' => $token->user_id,
            'token_count' => $token->token_count,
            'amount_paid' => $token->amount_paid,
            'purchase_date' => $token->purchase_date,
            'title' => 'Edit Token',
            'users' => $users,
            'user_id_err' => '',
            'token_count_err' => '',
            'amount_paid_err' => '',
            'purchase_date_err' => ''
        ];
        $this->view('pages/admin/v_edit_token', $data);
    }

    // Handle Update Token Submission
    public function updateToken($tokenId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $token = null;
            foreach ($this->adminModel->getAllTokens() as $t) {
                if ($t->token_id == $tokenId) $token = $t;
            }
            if (!$token) {
                Alert_Helper::error('Token not found', 'Token not found.');
                redirect('admin/token/manageTokens');
                return;
            }
            $data = [
                'token_id' => $tokenId,
                'user_id' => trim($_POST['user_id']),
                'token_count' => trim($_POST['token_count']),
                'amount_paid' => trim($_POST['amount_paid']),
                'purchase_date' => trim($_POST['purchase_date']),
                'title' => 'Edit Token',
                'user_id_err' => '',
                'token_count_err' => '',
                'amount_paid_err' => '',
                'purchase_date_err' => ''
            ];
            // Validation (same as addToken)
            if (empty($data['user_id'])) {
                $data['user_id_err'] = 'Please select a user';
            }
            if (empty($data['token_count'])) {
                $data['token_count_err'] = 'Please enter token count';
            } elseif (!is_numeric($data['token_count']) || $data['token_count'] < 0) {
                $data['token_count_err'] = 'Please enter a valid token count';
            }
            if (empty($data['amount_paid'])) {
                $data['amount_paid_err'] = 'Please enter amount paid';
            } elseif (!is_numeric($data['amount_paid']) || $data['amount_paid'] < 0) {
                $data['amount_paid_err'] = 'Please enter a valid amount';
            }
            if (empty($data['purchase_date'])) {
                $data['purchase_date_err'] = 'Please enter purchase date';
            }
            if (empty($data['user_id_err']) && empty($data['token_count_err']) && empty($data['amount_paid_err']) && empty($data['purchase_date_err'])) {
                if ($this->adminModel->updateToken($tokenId, $data)) {
                    Alert_Helper::success('Success', 'Token updated.');
                    redirect('admin/token/manageTokens');
                } else {
                    Alert_Helper::error('Update failed', 'Failed to update token.');
                    $this->view('pages/admin/v_edit_token', $data);
                }
            } else {
                $this->view('pages/admin/v_edit_token', $data);
            }
        } else {
            redirect('admin/token/manageTokens');
        }
    }

    // Delete Token (Handles POST request)
    public function deleteToken($tokenId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->adminModel->deleteTokenById($tokenId)) {
                Alert_Helper::success('Success', 'Token deleted.');
            } else {
                Alert_Helper::error('Delete failed', 'Failed to delete token.');
            }
            redirect('admin/token/manageTokens');
        } else {
            redirect('admin/token/manageTokens');
        }
    }
}
