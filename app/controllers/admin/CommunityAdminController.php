<?php

require_once __DIR__ . '/../Admin.php';

class CommunityAdminController extends Admin
{

    /**
     * Manage Communities page 
     * Retrieves all communities and passes them to the view for rendering.
     * 
     * @return void
     */
    public function manageCommunities()
    {
        $communities = $this->adminModel->getAllCommunities();
        $data = [
            'title' => 'Manage Communities',
            'communities' => $communities
        ];
        $this->view('pages/admin/v_manage_communities', $data);
    }

    /**
     * @param mixed $communityId
     * @return void
     */
    public function approveCommunity($communityId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->adminModel->updateCommunityStatus($communityId, 'approved')) {
                Alert_Helper::success('Success', 'Community approved successfully.');
            } else {
                Alert_Helper::error('Approval failed', 'Failed to approve community.');
            }
            redirect('admin/community/manageCommunities');
        } else {
            redirect('admin/community/manageCommunities');
        }
    }

    /**
     * @param mixed $communityId
     * @return void
     */
    public function rejectCommunity($communityId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->adminModel->updateCommunityStatus($communityId, 'rejected')) {
                Alert_Helper::success('Success', 'Community rejected.');
            } else {
                Alert_Helper::error('Rejection failed', 'Failed to reject community.');
            }
            redirect('admin/community/manageCommunities');
        } else {
            redirect('admin/community/manageCommunities');
        }
    }

    /**
     * Delete a community
     * Deletes the specified community from the database.
     * Displays a success or failure message.
     * 
     * @param mixed $communityId The ID of the community to delete
     * @return void
     */
    public function deleteCommunity($communityId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->adminModel->deleteCommunityById($communityId)) {
                Alert_Helper::success('Success', 'Community deleted successfully.');
            } else {
                Alert_Helper::error('Delete failed', 'Failed to delete community.');
            }
            redirect('admin/community/manageCommunities');
        } else {
            redirect('admin/community/manageCommunities');
        }
    }

    /**
     * Add a new community
     * Handles the creation of a new community by validating and sanitizing the form input.
     * Displays a success or failure message.
     * 
     * @return void
     */
    public function addCommunity()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'communityName' => trim($_POST['communityName']),
                'communityDescription' => trim($_POST['communityDescription']),
                'communityImage' => trim($_POST['communityImage']),
                'membership_type' => trim($_POST['membership_type']),
                'title' => 'Add New Community',
                'communityName_err' => '',
                'communityDescription_err' => '',
                'communityImage_err' => '',
                'membership_type_err' => ''
            ];

            // Validation
            if (empty($data['communityName'])) {
                $data['communityName_err'] = 'Please enter a community name';
            }
            if (empty($data['communityDescription'])) {
                $data['communityDescription_err'] = 'Please enter a description';
            }
            if (empty($data['membership_type'])) {
                $data['membership_type_err'] = 'Please select a membership type';
            }
            // Optional: Validate image (e.g., URL or file upload)

            if (empty($data['communityName_err']) && empty($data['communityDescription_err']) && empty($data['communityImage_err']) && empty($data['membership_type_err'])) {
                if ($this->adminModel->addCommunity($data)) {
                    Alert_Helper::success('Success', 'Community added successfully.');
                    redirect('admin/community/manageCommunities');
                } else {
                    Alert_Helper::error('Add failed', 'Failed to add community.');
                    $this->view('pages/admin/v_add_community', $data);
                }
            } else {
                // Validation failed, reload form with errors
                $this->view('pages/admin/v_add_community', $data);
            }
        } else {
            $data = [
                'communityName' => '',
                'communityDescription' => '',
                'communityImage' => '',
                'membership_type' => '',
                'title' => 'Add New Community',
                'communityName_err' => '',
                'communityDescription_err' => '',
                'communityImage_err' => '',
                'membership_type_err' => ''
            ];
            $this->view('pages/admin/v_add_community', $data);
        }
    }

    /**
     * Manage Community Posts
     * Gets all community posts and displays them in a table
     */
    public function manageCommunityPosts()
    {
        $posts = $this->adminModel->getAllCommunityPosts();
        // Get all communities and community members for dropdowns
        $communities = $this->adminModel->getAllCommunities();
        $communityMembers = $this->adminModel->getAllCommunityMembers();

        $data = [
            'title' => 'Manage Community Posts',
            'posts' => $posts,
            'communities' => $communities,
            'communityMembers' => $communityMembers
        ];
        $this->view('pages/admin/v_manage_community_posts', $data);
    }

    /**
     * Add a new community post
     */
    public function addCommunityPost()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'community_id' => $_POST['community_id'],
                'community_member_id' => $_POST['community_member_id'],
                'title' => $_POST['title'],
                'content' => $_POST['content']
            ];
            if ($this->adminModel->addCommunityPost($data)) {
                Alert_Helper::success('Success', 'Community post added.');
            } else {
                Alert_Helper::error('Add failed', 'Failed to add post.');
            }
            redirect('admin/community/manageCommunityPosts');
        } else {
            $this->manageCommunityPosts();
        }
    }

    /**
     * Edit community post form and handler
     */
    public function editCommunityPost($postId)
    {
        $post = null;
        foreach ($this->adminModel->getAllCommunityPosts() as $p) {
            if ($p->id == $postId) $post = $p;
        }
        if (!$post) {
            Alert_Helper::error('Post not found', 'Post not found.');
            redirect('admin/community/manageCommunityPosts');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'title' => $_POST['title'],
                'content' => $_POST['content']
            ];
            if ($this->adminModel->updateCommunityPost($postId, $data)) {
                Alert_Helper::success('Success', 'Post updated.');
                redirect('admin/community/manageCommunityPosts');
            } else {
                Alert_Helper::error('Update failed', 'Failed to update post.');
                redirect('admin/community/manageCommunityPosts');
            }
        } else {
            $data = [
                'title' => 'Edit Community Post',
                'post' => $post
            ];
            $this->view('pages/admin/v_edit_community_post', $data);
        }
    }

    /**
     * Delete a community post
     */
    public function deleteCommunityPost($postId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->adminModel->deleteCommunityPostById($postId)) {
                Alert_Helper::success('Success', 'Community post deleted successfully.');
            } else {
                Alert_Helper::error('Delete failed', 'Failed to delete community post.');
            }
            redirect('admin/community/manageCommunityPosts');
        } else {
            redirect('admin/community/manageCommunityPosts');
        }
    }

    /**
     * Manage Delete Requests
     * Shows all pending community delete requests
     */
    public function deleteRequests()
    {
        $requests = $this->adminModel->getAllDeleteRequests();
        $data = [
            'title' => 'Manage Delete Requests',
            'requests' => $requests
        ];
        $this->view('pages/admin/v_manage_delete_requests', $data);
    }

    /**
     * Approve a delete request
     */
    public function approveDeleteRequest($requestId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->adminModel->updateDeleteRequestStatus($requestId, 'approved')) {
                Alert_Helper::success('Success', 'Delete request approved. Community marked for deletion.');
            } else {
                Alert_Helper::error('Approval failed', 'Failed to approve delete request.');
            }
            redirect('admin/deleteRequests');
        } else {
            redirect('admin/deleteRequests');
        }
    }

    /**
     * Reject a delete request
     */
    public function rejectDeleteRequest($requestId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->adminModel->updateDeleteRequestStatus($requestId, 'rejected')) {
                Alert_Helper::success('Success', 'Delete request rejected.');
            } else {
                Alert_Helper::error('Rejection failed', 'Failed to reject delete request.');
            }
            redirect('admin/deleteRequests');
        } else {
            redirect('admin/deleteRequests');
        }
    }
}
