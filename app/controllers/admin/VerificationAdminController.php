<?php

require_once __DIR__ . '/../Admin.php';

class VerificationAdminController extends Admin
{
    // List all users with verification status
    public function manageVerification()
    {
        $searchTerm = $_GET['search'] ?? null;
        $filter = $_GET['filter'] ?? null;
        $users = [];
        if ($searchTerm) {
            $searchTerm = trim(filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING));
            if (!empty($searchTerm)) {
                $users = $this->adminModel->searchUsersWithVerificationStatus($searchTerm, $filter);
            } else {
                $users = $this->adminModel->getAllUsersWithVerificationStatus($filter);
                $searchTerm = null;
            }
        } else {
            $users = $this->adminModel->getAllUsersWithVerificationStatus($filter);
        }
        $data = [
            'title' => 'Manage User Verification',
            'users' => $users,
            'searchTerm' => $searchTerm,
            'filter' => $filter
        ];
        $this->view('pages/admin/v_manage_verification', $data);
    }

    // Manually verify a user (admin action)
    public function verifyUser($userId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user = $this->adminModel->getUserById($userId);
            if (!$user) {
                Alert_Helper::error('User not found', 'User not found.');
                redirect('admin/verification/manageVerification');
                return;
            }
            if ($this->adminModel->verifyUser($userId)) {
                Alert_Helper::success('Success', 'User verified successfully.');
            } else {
                Alert_Helper::error('Verification failed', 'Failed to verify user.');
            }
            redirect('admin/verification/manageVerification');
        } else {
            redirect('admin/verification/manageVerification');
        }
    }

    // Mark a user as unverified (admin action)
    public function unverifyUser($userId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user = $this->adminModel->getUserById($userId);
            if (!$user) {
                Alert_Helper::error('User not found', 'User not found.');
                redirect('admin/verification/manageVerification');
                return;
            }
            if ($this->adminModel->unverifyUser($userId)) {
                Alert_Helper::success('Success', 'User marked as unverified.');
            } else {
                Alert_Helper::error('Update failed', 'Failed to update user status.');
            }
            redirect('admin/verification/manageVerification');
        } else {
            redirect('admin/verification/manageVerification');
        }
    }

    // Generate and send a new OTP for a user (admin action)
    public function resendOTP($userId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $result = $this->adminModel->generateNewOTP($userId);
            if ($result) {
                require_once APPROOT . '/helpers/Email_Helper.php';
                $emailSent = Email_Helper::sendOTP($result['user']->user_email, $result['user']->user_name, $result['otp']);
                if ($emailSent) {
                    Alert_Helper::success('Success', 'OTP generated and sent to user.');
                } else {
                    Alert_Helper::warning('Email failed', 'OTP generated but email sending failed. OTP: ' . $result['otp']);
                }
            } else {
                Alert_Helper::error('Generation failed', 'Failed to generate new OTP.');
            }
            redirect('admin/verification/manageVerification');
        } else {
            redirect('admin/verification/manageVerification');
        }
    }
}
