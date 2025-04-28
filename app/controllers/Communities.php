<?php
class Communities extends Controller {
    private $communityModel;

    public function __construct() {
        $this->communityModel = $this->model('M_Communities');
        $this->userModel = $this->model('M_Users');
    }

    public function index() {
        $communities = $this->communityModel->getAllCommunities();
        $data = ['communities' => $communities];
        $this->view('communities/v_displaycommunity', $data);
    }
   

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'communityName' => trim($_POST['community_name']),
                'membership_type' => trim($_POST['community_type']),
                'communityDescription' => trim($_POST['community_description']),
                'communityImage' => '',
                'communityName_err' => '',
                'membership_type_err' => '',
                'communityImage_err' => ''
            ];

            // Handle image upload
            if (isset($_FILES['community_image']) && $_FILES['community_image']['error'] === 0) {
                $target_dir = APPROOT . "/../public/img/community/";
                
                // Ensure directory exists
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }

                $target_file = $target_dir . basename($_FILES["community_image"]["name"]);
                if (move_uploaded_file($_FILES["community_image"]["tmp_name"], $target_file)) {
                    $data['communityImage'] = "public/img/community/" . basename($_FILES["community_image"]["name"]);
                } else {
                    $data['communityImage_err'] = "Error uploading image.";
                }
            }

            // Validation
            if (empty($data['communityName'])) {
                $data['communityName_err'] = "Please enter a community name.";
            }
            if (empty($data['membership_type'])) {
                $data['membership_type_err'] = "Invalid membership type.";
            }

            if (empty($data['communityName_err']) && empty($data['membership_type_err']) && empty($data['communityImage_err'])) {
                if ($this->communityModel->create($data)) {
                    echo "<script>showAlert();</script>";
                    $communities = $this->communityModel->getAllCommunities();
                    $data = ['communities' => $communities];
                    $this->view('communities/v_displaycommunity', $data);
                } else {
                    die("Something went wrong");
                }
            } else {
                $this->view('communities/v_createCommunity', $data);
            }
        } else {
            $data = [
                'community_name' => '',
                'community_description' => '',
                'community_image' => '',
                'community_type' => 'open',
                'community_name_err' => '',
                'membership_type_err' => ''
            ];
            $this->view('communities/v_createCommunity', $data);
        }
    }

    public function show() {
        $communities = $this->communityModel->getAllCommunities();
        $data = ['communities' => $communities];
        $this->view('communities/v_displaycommunity', $data);
    }
    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'communityId' => $id,
                'communityName' => trim($_POST['communityName']),
                'communityDescription' => trim($_POST['communityDescription']),
                'communityImage' => '',
                'membership_type' => trim($_POST['membership_type']),
                'communityName_err' => '',
                'membership_type_err' => '',
                'communityImage_err' => ''
            ];

            // Handle image upload
            if (isset($_FILES['community_image']) && $_FILES['community_image']['error'] === 0) {
                $target_dir = APPROOT . "/../public/img/community/";
                
                // Ensure directory exists
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }

                $target_file = $target_dir . basename($_FILES["community_image"]["name"]);
                if (move_uploaded_file($_FILES["community_image"]["tmp_name"], $target_file)) {
                    $data['communityImage'] = "public/img/community/" . basename($_FILES["community_image"]["name"]);
                } else {
                    $data['communityImage_err'] = "Error uploading image.";
                }
            } else {
                $data['communityImage'] = trim($_POST['communityImage']); // Keep existing image if no new upload
            }

            // Validation
            if (empty($data['communityName'])) {
                $data['communityName_err'] = "Please enter a community name.";
            }
            if (!in_array($data['membership_type'], ['open', 'private'])) {
                $data['membership_type_err'] = "Invalid membership type.";
            }

            if (empty($data['communityName_err']) && empty($data['membership_type_err']) && empty($data['communityImage_err'])) {
                if ($this->communityModel->update($data)) {
                    echo "<script>showAlert();</script>";
                    header("Location: " . URLROOT . "/communities");
                    exit;
                } else {
                    die("Something went wrong");
                }
            } else {
                $this->view('communities/v_edit', $data);
            }
        } else {
            $community = $this->communityModel->getCommunityById($id);
            $data = [
                'communityId' => $community->communityId,
                'communityName' => $community->communityName,
                'communityDescription' => $community->communityDescription,
                'communityImage' => $community->communityImage,
                'membership_type' => $community->membership_type,
                'communityName_err' => '',
                'membership_type_err' => ''
            ];
            $this->view('communities/v_edit', $data);
        }
    }
    public function details($id) {
        $community = $this->communityModel->getCommunityById($id);
        if (!$community) {
            $data = ['error' => 'nocommunityid'];
            $this->view('communities/v_displaycommunity', $data);
            return;
        }
        $data = ['community' => $community];
        $this->view('communities/v_comDetails', $data);
    }

    public function editCom($id) {
    $community = $this->communityModel->getCommunityById($id);

    if (!$community) {
        die('Community not found');
    }

    $data = [
        'community' => $community,
        'error' => ''
    ];

    $this->view('communities/v_editcommunity', $data);
}
public function requestDeleteForm($id) {
    $community = $this->communityModel->getCommunityById($id);

    if (!$community) {
        die("Community not found");
    }

    $data = [
        'community' => $community,
        'error' => ''
    ];

    $this->view('communities/v_requestDelete', $data);
}
public function requestDelete($id) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $reason = trim($_POST['reason']);
        $community = $this->communityModel->getCommunityById($id);

        if (empty($reason)) {
            $data = [
                'community' => $community,
                'error' => 'Please enter a reason'
            ];
            $this->view('communities/v_requestDelete', $data);
            return;
        }

        if ($this->communityModel->createDeleteRequest($id, $reason)) {
            $this->communityModel->markCommunityAsInactive($id);

            echo "<script>
                    alert('Delete request submitted successfully. The community is now inactive.');
                    window.location.href = '" . URLROOT . "/communities';
                  </script>";
        } else {
            die("Something went wrong while submitting the request.");
        }
    }
}


public function createPost($communityId) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        if (!isset($_SESSION['user_id'])) {
            die('User is not logged in.');
        }

        $userId = $_SESSION['user_id'];

        $memberRecord = $this->communityModel->getCommunityMemberId($userId, $communityId);

        if (!$memberRecord) {
            die('You are not a member of this community.');
        }

        $communityMemberId = $memberRecord->community_member_id;

        $data = [
            'title' => trim($_POST['title']),
            'content' => trim($_POST['content']),
            'community_id' => $communityId,
            'community_member_id' => $communityMemberId,
            'title_err' => '',
            'content_err' => ''
        ];

        if (empty($data['title'])) {
            $data['title_err'] = 'Please enter a title.';
        }

        if (empty($data['content'])) {
            $data['content_err'] = 'Please enter content.';
        }

        if (empty($data['title_err']) && empty($data['content_err'])) {
            if ($this->communityModel->createPost($data)) {
                header("Location: " . URLROOT . "/communities/viewPosts/" . $communityId);
                exit;
            } else {
                die('Failed to create post.');
            }
        } else {
            $this->view('communities/v_createPosts', $data);
        }
    } else {
        $data = [
            'title' => '',
            'content' => '',
            'community_id' => $communityId,
            'community_member_id' => '', 
            'title_err' => '',
            'content_err' => ''
        ];
        $this->view('communities/v_createPosts', $data);
    }
}


public function viewPosts($communityId) {
    $posts = $this->communityModel->getPostsByCommunity($communityId);
    $community = $this->communityModel->getCommunityById($communityId);

    if (!$community) {
        $data = ['error' => 'Community not found'];
    } else {
        $data = [
            'community' => $community,
            'posts' => $posts
        ];
    }

    $this->view('communities/v_viewPosts', $data);
}

public function viewSinglePost($postId) {
    $post = $this->communityModel->getPostById($postId);

    if ($post) {
        $data = ['post' => $post];
        $this->view('communities/v_viewSinglePost', $data);
    } else {
        $data = ['error' => 'Post not found'];
        $this->view('communities/v_viewSinglePost', $data);
    }
}

public function deletePost($postId) {
    $post = $this->communityModel->getPostById($postId);

    if ($post) {
        $deleted = $this->communityModel->deletePost($postId);

        if ($deleted) {
            header('Location: ' . URLROOT . '/communities/viewPosts/' . $post->community_id);
            exit();
        } else {
            die('Something went wrong while deleting the post.');
        }
    } else {
        die('Post not found.');
    }
}


    

    public function addMembers($communityId = null) {
        $users = $this->userModel->getAllUsers();
        var_dump($users);
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
           $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    
            $data = [
                'community_member_name' => trim($_POST['community_member_name']),
                'community_id' => $communityId,
                'user_id' => trim($_POST['user_id']),
                'error' => '',
                'success' => '',
                'user' => $users 
            ];
    
            if (empty($data['community_member_name']) || empty($data['user_id'])) {
                $data['error'] = "All fields are required.";
                $this->view('communities/v_displayMembers', $data);
            } else {
                if ($this->communityModel->addMembers($data)) {
                    redirect('communities/viewMembers/' . $communityId); // Redirect to view members page
                } else {
                    $data['error'] = "Failed to add member.";
                    $this->view('communities/v_displayMembers', $data);
                }
            }
        } else {
            $data = [
                'community_id' => $communityId,
                'community_member_name' => '',
                'user_id' => '',
                'user' => $users,
                'error' => '',
                'success' => ''
            ];
            $this->view('communities/v_displayMembers', $data);
        }
    }
    
    public function viewMembers($communityId) {
        $members = $this->communityModel->getCommunityMembers($communityId);
        $community = $this->communityModel->getCommunityById($communityId);
        $users = $this->userModel->getAllUsers();
    
        if (!$community) {
            $data = ['error' => 'Community not found'];
        } else {
            $data = [
                'members' => $members,
                'community' => $community,
                'users' => $users 
            ];
        }
    
        $this->view('communities/v_displayMembers', $data);
    }
    
    public function viewWritingGroups($communityId){
        $community = $this->communityModel->getCommunityById($communityId);
        if (!$community) {
            $data = ['error' => 'Community not found'];
        }else {
            $writingGroups = $this->communityModel->viewWritingGroups($communityId);
            $data = [
                'writingGroups' => $writingGroups,
                'community' => $community
            ];
        }
        $this->view('communities/v_writingGroups', $data);
    }

    public function createWritingGroups($communityId) {
        $community = $this->communityModel->getCommunityById($communityId);
    
        if (!$community) {
            $data = ['error' => 'Community not found'];
            $this->view('communities/v_createWritingGroups', $data);
            return;
        }
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    
            $imagePath = '';
    
            // Image upload handling
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $target_dir = APPROOT . '/../public/img/community/';
    
                // Ensure the folder exists
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
    
                $fileName = time() . '_' . basename($_FILES['image']['name']);
                $target_file = $target_dir . $fileName;
    
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                    // Store the path relative to the public folder
                    $imagePath = 'public/img/community/' . $fileName;
                } else {
                    $data['error'] = "Image upload failed!";
                }
            }
    
            $data = [
                'writingGroup_name' => trim($_POST['writingGroup_name']),
                'writingGroup_description' => trim($_POST['writingGroup_description']),
                'community_id' => $communityId,
                'image_path' => $imagePath,
                'group_name_err' => '',
                'description_err' => '',
                'community' => $community
            ];
    
            if (empty($data['writingGroup_name'])) {
                $data['group_name_err'] = "Please enter a group name.";
            }
    
            if (empty($data['writingGroup_description'])) {
                $data['description_err'] = "Please enter a description.";
            }
    
            if (empty($data['group_name_err']) && empty($data['description_err'])) {
                if ($this->communityModel->createWritingGroup($data)) {
                    header("Location: " . URLROOT . "/communities/viewWritingGroups/" . $communityId);
                    exit;
                } else {
                    die("Failed to create writing group.");
                }
            } else {
                $this->view('communities/v_createWritingGroups', $data);
            }
        } else {
            $data = [
                'writingGroup_name' => '',
                'writingGroup_description' => '',
                'community_id' => $communityId,
                'group_name_err' => '',
                'description_err' => '',
                'community' => $community
            ];
            $this->view('communities/v_createWritingGroups', $data);
        }
    }
    


    public function updateWritingGroup() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $communityId = $_POST['communityId'];
    
            if ($this->communityModel->updateWritingGroup($id, $name, $description)) {
                flash('group_message', 'Writing Group updated successfully');
                redirect('communities/viewWritingGroups/' . $communityId);
            } else {
                die('Something went wrong');
            }
        } else {
            $this->view('errors/404');
        }
    }
    

    public function deleteWritingGroup($writingGroupId) {
        if ($this->communityModel->deleteWritingGroupById($writingGroupId)) {
            flash('group_message', 'Writing Group deleted successfully');
        } else {
            flash('group_message', 'Failed to delete Writing Group');
        }
    
        $communityId = $_SESSION['current_community_id'] ?? null; // OR pass it another way
    
        if ($communityId) {
            $community = $this->communityModel->getCommunityById($communityId);
            $writingGroups = $this->communityModel->getWritingGroupsByCommunityId($communityId); // You need to have this function
            $data = [
                'community' => $community,
                'writingGroups' => $writingGroups
            ];
            $this->view('communities/v_viewWritingGroups', $data);
        } else {
            redirect('communities/viewWritingGroups');
        }
    }
    
    
    public function viewEvent($communityId){
        $community = $this->communityModel->getCommunityById($communityId);
        if (!$community) {
            $data = [
                'error' => 'Community not found',
                'community_id' => $communityId 
            ];
        } else {
            $events = $this->communityModel->viewEvent($communityId);
            $data = [
                'events' => $events,
                'community' => $community,
                'community_id' => $communityId 
            ];
        }
        $this->view('communities/v_viewEvents', $data);
    }
    

    public function createEvent($communityId = null) {
        if (!$communityId) {
            die("Community ID not provided.");
        }
    
        $community = $this->communityModel->getCommunityById($communityId);
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    
            $data = [
                'event_name' => trim($_POST['event_name']),
                'event_description' => trim($_POST['event_description']),
                'event_place' => trim($_POST['event_place']),
                'event_date' => $_POST['event_date'],
                'event_time' => $_POST['event_time'],
                'community_id' => $communityId
            ];
    
            // Validation
            if (empty($data['event_name']) || empty($data['event_description']) || empty($data['event_place']) || empty($data['event_date']) || empty($data['event_time'])) {
                $data['error'] = "Please fill in all fields.";
                $this->view('communities/v_createEvent', $data);
                return;
            }
    
            // Save
            if ($this->communityModel->addEvent($data)) {
                redirect('communities/viewEvent/' . $communityId); 
            } else {
                $data['error'] = "Something went wrong, please try again.";
                $this->view('communities/v_createEvent', $data);
            }
    
        } else {
            $data = [
                'event_name' => '',
                'event_description' => '',
                'event_place' => '',
                'event_date' => '',
                'event_time' => '',
                'community_id' => $communityId,
                'error' => ''
            ];
            $this->view('communities/v_createEvent', $data);
        }
    }

    public function viewEventDetails($eventid){
        $event = $this->communityModel->viewEventDetails($eventid); // ✅ Correct variable and model call
    
        if (!$event) {
            die('Event not found!');
        }
    
        $this->view('communities/v_viewEventDetails', [
            'event' => $event
        ]);
    }
    
    public function editEvent($id) {
        $event = $this->communityModel->viewEventDetails($id);
    
        if (!$event) {
            die('Event not found!');
        }
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    
            $data = [
                'event_id' => $id,
                'event_name' => trim($_POST['event_name']),
                'event_description' => trim($_POST['event_description']),
                'event_place' => trim($_POST['event_place']),
                'event_date' => trim($_POST['event_date']),
                'event_time' => trim($_POST['event_time']),
                'community_id' => $event->community_id
            ];
    
            if ($this->communityModel->updateEvent($data)) {
                redirect('communities/viewEvent/' . $event->community_id);
            } else {
                die('Something went wrong');
            }
        } else {
            $this->view('communities/v_editEvent', ['event' => $event]);
        }
    }

    public function deleteEvent($id) {
        $event = $this->communityModel->viewEventDetails($id);
    
        if (!$event) {
            die('Event not found!');
        }
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->communityModel->deleteEvent($id)) {
                redirect('communities/viewEvent/' . $event->community_id);
            } else {
                die('Something went wrong');
            }
        } else {
            $this->view('communities/v_deleteEvent', ['event' => $event]);
        }
    }
    
    public function createWritingGroupPost($writingGroupId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    
            if (!isset($_SESSION['user_id'])) {
                die('User is not logged in.');
            }
    
            $userId = $_SESSION['user_id'];
            $memberRecord = $this->communityModel->getCommunityMemberId($userId, $writingGroupId);
    
            if (!$memberRecord) {
                die('You are not a member of this writing group.');
            }
    
            $communityMemberId = $memberRecord->community_member_id;
    
            $data = [
                'chapter_title' => trim($_POST['chapter_title']),
                'chapter_content' => trim($_POST['chapter_content']),
                'writingGroup_id' => $writingGroupId,
                'community_member_id' => $communityMemberId,
                'error' => ''
            ];
    
            if (empty($data['chapter_title']) || empty($data['chapter_content'])) {
                $data['error'] = "Both fields are required.";
                $this->view('communities/v_createWritingGroupPost', $data);
                return;
            }
    
            if ($this->communityModel->createWritingGroupPost($data)) {
                redirect('communities/viewWritingGroupPosts/' . $writingGroupId);
            } else {
                $data['error'] = "There was an error creating the chapter.";
                $this->view('communities/v_createWritingGroupPost', $data);
            }
        } else {
            $data = [
                'chapter_title' => '',
                'chapter_content' => '',
                'writingGroup_id' => $writingGroupId,
                'community_member_id' => '',
                'error' => ''
            ];
    
            $this->view('communities/v_createWritingGroupPost', $data);
        }
    }
    

public function viewWritingGroupPosts($writingGroupId)
{
    $posts = $this->communityModel->getWritingGroupPosts($writingGroupId);

    $data = [
        'writingGroup_id' => $writingGroupId,
        'posts' => $posts,
        'writingGroup_name' => $this->communityModel->getWritingGroupName($writingGroupId),
    ];

    $this->view('communities/v_writingGroupPosts', $data);
}

public function deleteWritingGroupPost($writingGroupId, $postId)
{
    if ($this->communityModel->deleteWritingGroupPost($postId)) {
        flash('post_message', 'Chapter deleted successfully');
    } else {
        flash('post_message', 'Failed to delete chapter', 'alert alert-danger');
    }

    redirect('communities/viewWritingGroupPosts/' . $writingGroupId);
}












//user side community functions

public function displayCommunity() {
    $communities = $this->communityModel->displayCommunity();
    $data = ['communities' => $communities];
    $this->view('pages/parent/v_communities', $data);
}

public function viewCommunityDetails($id) {
    // Fetch community details
    $community = $this->communityModel->getCommunityById($id);

    // If no community is found, return an error
    if (!$community) {
        $data = ['error' => 'No community found with this ID'];
        $this->view('pages/parent/v_communities', $data);
        return;
    }

    // Fetch posts related to the community
    $posts = $this->communityModel->getPosts($id);

    // Pass community and posts to the view
    $data = [
        'community' => $community,
        'posts' => $posts
    ];

    // Load the view
    $this->view('pages/parent/v_communityDetails', $data);
}


public function joinCommunity($communityId){
    if (!isset($_SESSION['user_id'])) {
        die('User is not logged in.');
    }

    $userId = $_SESSION['user_id'];
    $community_member_name = $_SESSION['user_name'];

    $communityMemberId = $this->communityModel->getCommunityMemberId($userId, $communityId);

    if ($communityMemberId) {
        die('You are already a member of this community.');
    }

    if ($this->communityModel->joinCommunity($communityId, $userId, $community_member_name)) {
        flash('join_success', 'You have successfully joined the community!');
        echo "<script>alert('You have successfully joined the community.');</script>";
        header("Location: " . URLROOT . "/communities/viewCommunitydetails/" . $communityId);
        exit;
    } else {
        die("Failed to join the community.");
    }
}


public function viewCommunityPosts($communityId) {
    $posts = $this->communityModel->getPosts($communityId);
    $community = $this->communityModel->getCommunityById($communityId);

    if (!$community) {
        $data = ['error' => 'Community not found'];
    } else {
        $data = [
            'community' => $community,
            'posts' => $posts
        ];
    }

    $this->view('pages/parent/v_viewSingleCommunityPost', $data);
    
}
public function viewSingleCommunityPost($postId) {
    $post = $this->communityModel->getCommunityPostById($postId);

    if ($post) {
        $data = ['post' => $post];
        $this->view('pages/parent/v_singlePost', $data);
    } else {
        $data = ['error' => 'Post not found'];
        $this->view('pages/parent/v_singlePost', $data);
    }
}

public function createCommunityPost($communityId) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        if (!isset($_SESSION['user_id'])) {
            die('User is not logged in.');
        }

        $userId = $_SESSION['user_id'];

        $memberRecord = $this->communityModel->getCommunityMemberId($userId, $communityId);

        if (!$memberRecord) {
            die('You are not a member of this community.');
        }

        $communityMemberId = $memberRecord->community_member_id;

        $data = [
            'title' => trim($_POST['title']),
            'content' => trim($_POST['content']),
            'community_id' => $communityId,
            'community_member_id' => $communityMemberId,
            'title_err' => '',
            'content_err' => ''
        ];

        if (empty($data['title'])) {
            $data['title_err'] = 'Please enter a title.';
        }

        if (empty($data['content'])) {
            $data['content_err'] = 'Please enter content.';
        }

        if (empty($data['title_err']) && empty($data['content_err'])) {
            if ($this->communityModel->createPost($data)) {
                header("Location: " . URLROOT . "/communities/viewCommunityPosts/" . $communityId);
                exit;
            } else {
                die('Failed to create post.');
            }
        } else {
            $this->view('pages/parent/v_createCommunityPosts', $data);
        }
    } else {
        $data = [
            'title' => '',
            'content' => '',
            'community_id' => $communityId,
            'community_member_id' => '', 
            'title_err' => '',
            'content_err' => ''
        ];
        $this->view('pages/parent/v_createCommunityPosts', $data);
    }
}

public function viewCommunitySinglePost($postId) {
    $post = $this->communityModel->getPostById($postId);

    if ($post) {
        $data = ['post' => $post];
        $this->view('pages/parent/v_singlePost', $data);
    } else {
        $data = ['error' => 'Post not found'];
        $this->view('pages/parent/v_singlePost', $data);
    }
}
public function viewCommunityWritingGroups($communityId) {
    $community = $this->communityModel->getCommunityById($communityId);
    if (!$community) {
        $data = ['error' => 'Community not found'];
    } else {
        // Get the writing groups
        $writingGroups = $this->communityModel->viewCommunityWritingGroups($communityId);
        
        // Pass the writing groups directly without checking user membership
        $data = [
            'writingGroups' => $writingGroups,
            'community' => $community
        ];
    }
    $this->view('pages/parent/v_writingGroups', $data);
}


public function viewCommunityWritingGroupPosts($writingGroupId)
{
    $posts = $this->communityModel->getCommunityWritingGroupPostsById($writingGroupId);
    $userCommunityMemberId = $this->communityModel->getCommunityMemberId($_SESSION['user_id'], $writingGroupId);

    $data = [
        'writingGroup_id' => $writingGroupId,
        'posts' => $posts,
        'writingGroup_name' => $this->communityModel->getWritingGroupName($writingGroupId),
        'user_community_member_id' => $userCommunityMemberId,
    ];

    $this->view('pages/parent/v_writingGroupPosts', $data);
}

public function joinWritingGroupAction() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $groupId = $_POST['group_id'];

        if ($this->communityModel->joinWritingGroup($groupId)) {
            flash('join_success', 'You have successfully joined the writing group!');
            redirect('communities/viewCommunityWritingGroupPosts/' . $groupId);
        } else {
            flash('join_error', 'Something went wrong. Please try again.', 'alert alert-danger');
            redirect('communities');
        }
    } else {
        redirect('communities');
    }
}


public function createWritingGroupPostAction($writingGroupId) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $chapterTitle = trim($_POST['chapter_title']);
        $chapterContent = trim($_POST['chapter_content']);

        // First get the correct community_member_id (NOT user_id)
        $communityMember = $this->communityModel->getCommunityMemberByUserIdAndGroupId($_SESSION['user_id'], $writingGroupId);

        if (!$communityMember) {
            flash('post_error', 'You are not a member of this writing group.', 'alert alert-danger');
            redirect('communities/viewCommunityWritingGroupPosts/' . $writingGroupId);
            return;
        }

        $data = [
            'writingGroup_id' => $writingGroupId,
            'community_member_id' => $communityMember->community_member_id, // <-- THIS!!
            'chapter_title' => $chapterTitle,
            'chapter_content' => $chapterContent,
        ];

        if ($this->communityModel->createCommunityWritingGroupPost($data)) {
            flash('post_success', 'Chapter created successfully!');
            redirect('communities/viewCommunityWritingGroupPosts/' . $writingGroupId);
        } else {
            flash('post_error', 'Failed to create chapter.', 'alert alert-danger');
            redirect('communities/viewCommunityWritingGroupPosts/' . $writingGroupId);
        }
    } else {
        $data = [
            'chapter_title' => '',
            'chapter_content' => '',
            'writingGroup_id' => $writingGroupId,
            'community_member_id' => '',
            'title_err' => '',
            'content_err' => ''
        ];

        $this->view('pages/parent/v_createWritingGroupPosts', $data);
    }
}

public function viewCommunityEvents($communityId){
    $community = $this->communityModel->getCommunityById($communityId);
    if(!$community){
        $data = [
            'error' => 'No Community Found',
            'community_id' => $communityId
        ];
    }else {
            $events = $this->communityModel->viewCommunityEvents($communityId);
            $data = [
                'events' => $events,
                'community' => $community,
                'community_id'=> $communityId  

            ];
            $this->view('pages/parent/v_communityEvents', $data);
    }

}

public function viewCommunityEventDetails($eventid){
    $event = $this->communityModel->viewCommunityEventDetails($eventid); 

    if (!$event) {
        die('Event not found!');
    }

    $this->view('pages/parent/v_communityEventDetails', [
        'event' => $event
    ]);
}

public function joinEventAction() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $eventId = $_POST['event_id'];
        $userId = $_SESSION['user_id']; // Assume user is logged in and user_id is in session

        // Check if user has already joined the event
        if ($this->communityModel->hasJoinedEvent($userId, $eventId)) {
            redirect('communities/viewCommunityEventDetails/' . $eventId . '?status=error');
        }

        // Update user's event_id in community_member table
        if ($this->communityModel->joinEvent($userId, $eventId)) {
            redirect('communities/viewCommunityEventDetails/' . $eventId . '?status=success&joined=true');
        } else {
            redirect('communities/viewCommunityEventDetails/' . $eventId . '?status=error');
        }
    } else {
        redirect('events');
    }
}

public function myCommunities() {
    $userId = $_SESSION['user_id'];

    $joinedCommunities = $this->communityModel->getUserJoinedCommunities($userId);

    $this->view('pages/parent/v_myCommunities', [
        'joinedCommunities' => $joinedCommunities
    ]);
}

public function leaveCommunity($communityId) {
    $userId = $_SESSION['user_id'];
    $this->communityModel->leaveCommunity($userId, $communityId);
    flash('leave_success', 'You have left the community.');
    redirect('communities/myCommunities');
}

public function myCommunityPosts() {
    $userId = $_SESSION['user_id'];
    $posts = $this->communityModel->getUserCommunityPosts($userId);

    $this->view('pages/parent/v_myCommunityPosts', [
        'posts' => $posts
    ]);
}

public function myWritingGroups() {
    $userId = $_SESSION['user_id'];
    $joinedWritingGroups = $this->communityModel->getUserJoinedWritingGroups($userId);

    $this->view('pages/parent/v_myWritingGroups', [
        'joinedWritingGroups' => $joinedWritingGroups
    ]);
}

public function leaveWritingGroup($groupId) {
    $userId = $_SESSION['user_id'];
    $this->communityModel->leaveWritingGroup($userId, $groupId);
    flash('leave_success', 'You have left the writing group.');
    redirect('communities/myWritingGroups');
}

public function myWritingGroupPosts() {
    $userId = $_SESSION['user_id'];
    $chapters = $this->communityModel->getUserWritingGroupPosts($userId);

    $this->view('pages/parent/v_myWritingGroupPosts', [
        'chapters' => $chapters
    ]);
}

public function myEvents() {
    $userId = $_SESSION['user_id'];
    $joinedEvents = $this->communityModel->getUserJoinedEvents($userId);

    $this->view('pages/parent/v_myEvents', [
        'joinedEvents' => $joinedEvents
    ]);
}

public function leaveEvent($eventId) {
    $userId = $_SESSION['user_id'];
    $this->communityModel->leaveEvent($userId, $eventId);
    flash('leave_success', 'You have left the event.');
    redirect('communities/myEvents');
}


}
?>
