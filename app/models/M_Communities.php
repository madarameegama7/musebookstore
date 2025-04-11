<?php
class M_Communities {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function create($data) {
        $this->db->query('INSERT INTO community (communityName, communityDescription, communityImage, membership_type, created_at) 
                          VALUES (:communityName, :communityDescription, :communityImage, :membership_type, NOW())');
        $this->db->bind(':communityName', $data['communityName']);
        $this->db->bind(':communityDescription', $data['communityDescription']);
        $this->db->bind(':communityImage', $data['communityImage']);
        $this->db->bind(':membership_type', $data['membership_type']);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getAllCommunities() {
        $this->db->query('SELECT * FROM community');
        $results = $this->db->resultSet();
        return $results;
    }

    public function getCommunityById($communityId) {
        $this->db->query('SELECT * FROM community WHERE communityId = :communityId');
        $this->db->bind(':communityId', $communityId);

        $row = $this->db->single();
        return $row;
    }

    public function update($data) {
        $this->db->query('UPDATE communities 
                          SET communityName = :communityName, communityDescription = :communityDescription, 
                              communityImage = :communityImage, membership_type = :membership_type 
                          WHERE communityId = :communityId');
        $this->db->bind(':communityId', $data['communityId']);
        $this->db->bind(':communityName', $data['communityName']);
        $this->db->bind(':communityDescription', $data['communityDescription']);
        $this->db->bind(':communityImage', $data['communityImage']);
        $this->db->bind(':membership_type', $data['membership_type']);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
?>
