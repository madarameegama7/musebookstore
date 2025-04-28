<?php

require_once __DIR__ . '/../Admin.php';

class WritingGroupAdminController extends Admin
{
    // List all writing groups
    public function manageWritingGroups()
    {
        $groups = $this->adminModel->getAllWritingGroups();
        // Get all communities for the dropdown in the add form
        $communities = $this->adminModel->getAllCommunities();

        $data = [
            'title' => 'Manage Writing Groups',
            'groups' => $groups,
            'communities' => $communities // Pass communities to the view
        ];
        $this->view('pages/admin/v_manage_writing_groups', $data);
    }

    // Show Add Writing Group Form (GET) / Handle Add Writing Group Submission (POST)
    public function addWritingGroup()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $postData = [];
            foreach ($_POST as $key => $value) {
                $postData[$key] = trim(htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8'));
            }
            $data = [
                'writingGroup_name' => $postData['writingGroup_name'],
                'writingGroup_description' => $postData['writingGroup_description'],
                'community_id' => $postData['community_id'],
                'image_path' => $postData['image_path'] ?? '',
                'title' => 'Add New Writing Group',
                'writingGroup_name_err' => '',
                'writingGroup_description_err' => '',
                'community_id_err' => '',
                'image_path_err' => ''
            ];
            // Validation
            if (empty($data['writingGroup_name'])) {
                $data['writingGroup_name_err'] = 'Please enter a group name';
            }
            if (empty($data['writingGroup_description'])) {
                $data['writingGroup_description_err'] = 'Please enter a description';
            }
            if (empty($data['community_id'])) {
                $data['community_id_err'] = 'Please select a community';
            }
            // Optional: Validate image_path if needed
            if (empty($data['writingGroup_name_err']) && empty($data['writingGroup_description_err']) && empty($data['community_id_err'])) {
                if ($this->adminModel->addWritingGroup($data)) {
                    Alert_Helper::success('Success', 'Writing group added.');
                    redirect('admin/writingGroup/manageWritingGroups');
                } else {
                    Alert_Helper::error('Add failed', 'Failed to add writing group.');
                    $this->view('pages/admin/v_add_writing_group', $data);
                }
            } else {
                $this->view('pages/admin/v_add_writing_group', $data);
            }
        } else {
            // Get all communities for the dropdown
            $communities = $this->adminModel->getAllCommunities();

            $data = [
                'writingGroup_name' => '',
                'writingGroup_description' => '',
                'community_id' => '',
                'image_path' => '',
                'communities' => $communities, // Add communities to data
                'title' => 'Add New Writing Group',
                'writingGroup_name_err' => '',
                'writingGroup_description_err' => '',
                'community_id_err' => '',
                'image_path_err' => ''
            ];
            $this->view('pages/admin/v_add_writing_group', $data);
        }
    }

    // Show Edit Writing Group Form
    public function editWritingGroup($wgId)
    {
        // Get the writing group data
        $group = null;
        foreach ($this->adminModel->getAllWritingGroups() as $g) {
            if ($g->writingGroup_id == $wgId) $group = $g;
        }
        if (!$group) {
            Alert_Helper::error('Group not found', 'Writing group not found.');
            redirect('admin/writingGroup/manageWritingGroups');
        }

        // Get all available communities for the dropdown
        $communities = $this->adminModel->getAllCommunities();

        $data = [
            'writingGroup_id' => $wgId,
            'writingGroup_name' => $group->writingGroup_name,
            'writingGroup_description' => $group->writingGroup_description,
            'community_id' => $group->community_id,
            'image_path' => $group->image_path,
            'title' => 'Edit Writing Group',
            'writingGroup_name_err' => '',
            'writingGroup_description_err' => '',
            'community_id_err' => '',
            'image_path_err' => '',
            'communities' => $communities // Pass the communities to the view
        ];
        $this->view('pages/admin/v_edit_writing_group', $data);
    }

    // Handle Update Writing Group Submission
    public function updateWritingGroup($wgId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Replace deprecated FILTER_SANITIZE_STRING with modern filtering approach
            $postData = [];
            foreach ($_POST as $key => $value) {
                $postData[$key] = trim(htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8'));
            }

            $group = null;
            foreach ($this->adminModel->getAllWritingGroups() as $g) {
                if ($g->writingGroup_id == $wgId) $group = $g;
            }
            if (!$group) {
                Alert_Helper::error('Group not found', 'Writing group not found.');
                redirect('admin/writingGroup/manageWritingGroups');
                return;
            }
            $data = [
                'writingGroup_id' => $wgId,
                'writingGroup_name' => $postData['writingGroup_name'],
                'writingGroup_description' => $postData['writingGroup_description'],
                'community_id' => $postData['community_id'],
                'image_path' => $postData['image_path'] ?? '',
                'title' => 'Edit Writing Group',
                'writingGroup_name_err' => '',
                'writingGroup_description_err' => '',
                'community_id_err' => '',
                'image_path_err' => ''
            ];
            // Validation (same as addWritingGroup)
            if (empty($data['writingGroup_name'])) {
                $data['writingGroup_name_err'] = 'Please enter a group name';
            }
            if (empty($data['writingGroup_description'])) {
                $data['writingGroup_description_err'] = 'Please enter a description';
            }
            if (empty($data['community_id'])) {
                $data['community_id_err'] = 'Please select a community';
            }
            if (empty($data['writingGroup_name_err']) && empty($data['writingGroup_description_err']) && empty($data['community_id_err'])) {
                if ($this->adminModel->updateWritingGroup($wgId, $data)) {
                    Alert_Helper::success('Success', 'Writing group updated.');
                    redirect('admin/writingGroup/manageWritingGroups');
                } else {
                    Alert_Helper::error('Update failed', 'Failed to update writing group.');
                    $this->view('pages/admin/v_edit_writing_group', $data);
                }
            } else {
                $this->view('pages/admin/v_edit_writing_group', $data);
            }
        } else {
            redirect('admin/writingGroup/manageWritingGroups');
        }
    }

    // Delete Writing Group (Handles POST request)
    public function deleteWritingGroup($wgId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->adminModel->deleteWritingGroupById($wgId)) {
                Alert_Helper::success('Success', 'Writing group deleted successfully.');
            } else {
                Alert_Helper::error('Delete failed', 'Failed to delete writing group.');
            }
            redirect('admin/writingGroup/manageWritingGroups');
        } else {
            redirect('admin/writingGroup/manageWritingGroups');
        }
    }

    // Manage Writing Group Posts
    public function writingGroupPosts()
    {
        $posts = $this->adminModel->getAllWritingGroupPosts();
        // Get all writing groups and community members for dropdowns
        $writingGroups = $this->adminModel->getAllWritingGroups();
        $communityMembers = $this->adminModel->getAllCommunityMembers();

        $data = [
            'title' => 'Manage Writing Group Posts',
            'posts' => $posts,
            'writingGroups' => $writingGroups,
            'communityMembers' => $communityMembers
        ];
        $this->view('pages/admin/v_manage_writing_group_posts', $data);
    }

    public function deleteWritingGroupPost($postId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->adminModel->deleteWritingGroupPostById($postId)) {
                Alert_Helper::success('Success', 'Writing group post deleted successfully.');
            } else {
                Alert_Helper::error('Delete failed', 'Failed to delete writing group post.');
            }
            redirect('admin/writingGroup/writingGroupPosts');
        } else {
            redirect('admin/writingGroup/writingGroupPosts');
        }
    }

    public function addWritingGroupPost()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $postData = [];
            foreach ($_POST as $key => $value) {
                $postData[$key] = trim(htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8'));
            }
            $data = [
                'writingGroup_id' => $postData['writingGroup_id'],
                'community_member_id' => $postData['community_member_id'],
                'chapter_title' => $postData['chapter_title'],
                'chapter_content' => $postData['chapter_content']
            ];
            if ($this->adminModel->addWritingGroupPost($data)) {
                Alert_Helper::success('Success', 'Writing group post added.');
            } else {
                Alert_Helper::error('Add failed', 'Failed to add writing group post.');
            }
            redirect('admin/writingGroup/writingGroupPosts');
        } else {
            $this->writingGroupPosts();
        }
    }

    public function editWritingGroupPost($postId)
    {
        $post = null;
        foreach ($this->adminModel->getAllWritingGroupPosts() as $p) {
            if ($p->writingGroup_post_id == $postId) $post = $p;
        }
        if (!$post) {
            Alert_Helper::error('Post not found', 'Writing group post not found.');
            redirect('admin/writingGroup/writingGroupPosts');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $postData = [];
            foreach ($_POST as $key => $value) {
                $postData[$key] = trim(htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8'));
            }
            $data = [
                'chapter_title' => $postData['chapter_title'],
                'chapter_content' => $postData['chapter_content']
            ];
            if ($this->adminModel->updateWritingGroupPost($postId, $data)) {
                Alert_Helper::success('Success', 'Writing group post updated.');
                redirect('admin/writingGroup/writingGroupPosts');
            } else {
                Alert_Helper::error('Update failed', 'Failed to update writing group post.');
                redirect('admin/writingGroup/writingGroupPosts');
            }
        } else {
            $data = [
                'title' => 'Edit Writing Group Post',
                'post' => $post
            ];
            $this->view('pages/admin/v_edit_writing_group_post', $data);
        }
    }
}
