<?php
class Communities extends Controller {
    private $communityModel;

    public function __construct() {
        $this->communityModel = $this->model('M_Communities');
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

    public function addMembers() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'community_id' => $community->id, // or from URL param
                'users' => $this->userModel->getAllUsers()
            ];
            $this->view('communities/v_addmembers', $data);

        } 
    }

    
    
}
?>
