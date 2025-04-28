<?php
class M_Communities {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function create($data) {
        $this->db->query('INSERT INTO community (communityName, communityDescription, communityImage, membership_type, created_at, status) 
                          VALUES (:communityName, :communityDescription, :communityImage, :membership_type, NOW(), :status)');
        $this->db->bind(':communityName', $data['communityName']);
        $this->db->bind(':communityDescription', $data['communityDescription']);
        $this->db->bind(':communityImage', $data['communityImage']);
        $this->db->bind(':membership_type', $data['membership_type']);
        $this->db->bind(':status', 'pending');
    
        return $this->db->execute();
    }
    
    public function getAllCommunities() {
        $this->db->query("SELECT * FROM community");
        $results = $this->db->resultSet();
        return $results;
    }

    public function getCommunityById($communityId) {
        $this->db->query('SELECT * FROM community WHERE communityId = :communityId');
        $this->db->bind(':communityId', $communityId);

        $row = $this->db->single();
        return $row;
    }

    public function updateCommunity($data) {
        $this->db->query("
            UPDATE communities 
            SET communityName = :name, 
                membership_type = :type, 
                communityDescription = :description, 
                communityImage = :image
            WHERE communityId = :id
        ");
    
        $this->db->bind(':name', $data['community_name']);
        $this->db->bind(':type', $data['community_type']);
        $this->db->bind(':description', $data['community_description']);
        $this->db->bind(':image', $data['community_image']);
        $this->db->bind(':id', $data['id']);
    
        return $this->db->execute();
    }
    public function createDeleteRequest($communityId, $reason) {
        $this->db->query("INSERT INTO delete_requests (community_id, reason, request_status, created_at) 
                          VALUES (:community_id, :reason, :request_status, NOW())");
        $this->db->bind(':community_id', $communityId);
        $this->db->bind(':reason', $reason);
        $this->db->bind(':request_status', 'pending');
    
        return $this->db->execute();
    }
    

    public function markCommunityAsInactive($id) {
        $this->db->query("UPDATE community SET status = 'inactive' WHERE communityId = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
    
    
    

    public function addMembers($data) {
        $this->db->query("INSERT INTO community_member (community_member_name, community_id,event_id, user_id, writingGroup_id) 
        VALUES (:name, :community_id,NULL, :user_id, NULL)");
        
        $this->db->bind(':name', $data['community_member_name']);
        $this->db->bind(':community_id', $data['community_id']);
        $this->db->bind(':user_id', $data['user_id']);
    
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getCommunityMembers($communityId) {
        $this->db->query('SELECT * FROM community_member WHERE community_id = :community_id');
        $this->db->bind(':community_id', $communityId);
    
        return $this->db->resultSet(); // 
    }
    public function createWritingGroup($data) {
        $this->db->query('INSERT INTO writinggroup (writingGroup_name, writingGroup_description, community_id, image_path) 
                          VALUES (:writingGroup_name, :writingGroup_description, :community_id, :image_path)');
                          
        $this->db->bind(':writingGroup_name', $data['writingGroup_name']);
        $this->db->bind(':writingGroup_description', $data['writingGroup_description']);
        $this->db->bind(':community_id', $data['community_id']);
        $this->db->bind(':image_path', $data['image_path']);
    
        return $this->db->execute();
    }
    

    public function viewWritingGroups($communityId) {
    
        $this->db->query('SELECT * FROM writinggroup WHERE community_id = :community_id');
        $this->db->bind(':community_id', $communityId);
    
        return $this->db->resultSet(); // 
    }

    // Insert a request to delete a writing group
public function addDeleteRequest($data) {
    $this->db->query('INSERT INTO delete_requests (community_id, writingGroup_id, reason, request_status, created_at) 
                      VALUES (:community_id, :writingGroup_id, :reason, :request_status, :created_at)');

    $this->db->bind(':community_id', $data['community_id']);
    $this->db->bind(':writingGroup_id', $data['writingGroup_id']);
    $this->db->bind(':reason', $data['reason']);
    $this->db->bind(':request_status', 'pending'); // When requesting, default status = pending
    $this->db->bind(':created_at', date('Y-m-d H:i:s'));

    return $this->db->execute();
}
// Inside your CommunityModel
public function getWritingGroupsWithDeleteRequestStatus($communityId) {
    $this->db->query('
        SELECT wg.*, dr.request_status 
        FROM writing_groups wg
        LEFT JOIN delete_requests dr 
        ON wg.writingGroup_id = dr.writingGroup_id 
        WHERE wg.community_id = :communityId
    ');
    $this->db->bind(':communityId', $communityId);
    return $this->db->resultSet();
}

    
    public function updateWritingGroup($id, $name, $description) {
        $this->db->query('UPDATE writinggroup SET writingGroup_name = :name, writingGroup_description = :description WHERE writingGroup_id = :id');
        $this->db->bind(':name', $name);
        $this->db->bind(':description', $description);
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
    
    
     public function viewEvent($communityId){
        $this->db->query('SELECT * FROM event WHERE community_id = :community_id');
        $this->db->bind(':community_id', $communityId);
    
        return $this->db->resultSet(); //
     }

     public function addEvent($data) {
        $this->db->query('INSERT INTO event (event_name, event_description, event_place, event_date, event_time, community_id) 
                          VALUES (:event_name, :event_description, :event_place, :event_date, :event_time, :community_id)');
    
        $this->db->bind(':event_name', $data['event_name']);
        $this->db->bind(':event_description', $data['event_description']);
        $this->db->bind(':event_place', $data['event_place']);
        $this->db->bind(':event_date', $data['event_date']);
        $this->db->bind(':event_time', $data['event_time']);
        $this->db->bind(':community_id', $data['community_id']);
    
        return $this->db->execute();
    }

    public function viewEventDetails($eventid){
        $this->db->query('SELECT * FROM event where event_id = :eventid');
        $this->db->bind(':eventid', $eventid);

        return $this->db->single(); //
    }

    public function updateEvent($data) {
        $this->db->query('UPDATE event SET event_name = :name, event_description = :description, event_place = :place, event_date = :date, event_time = :time WHERE event_id = :id');
        $this->db->bind(':id', $data['event_id']);
        $this->db->bind(':name', $data['event_name']);
        $this->db->bind(':description', $data['event_description']);
        $this->db->bind(':place', $data['event_place']);
        $this->db->bind(':date', $data['event_date']);
        $this->db->bind(':time', $data['event_time']);
    
        return $this->db->execute();
    }

    public function deleteEvent($id) {
        $this->db->query('DELETE FROM event WHERE event_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
    

public function createWritingGroupPost($data)
{
    $this->db->query("INSERT INTO writing_group_posts (writingGroup_id, community_member_id, chapter_title, chapter_content, created_at) 
                      VALUES (:writingGroup_id, :community_member_id, :chapter_title, :chapter_content, NOW())");
    
    $this->db->bind(':writingGroup_id', $data['writingGroup_id']);
    $this->db->bind(':community_member_id', $data['community_member_id']);  
    $this->db->bind(':chapter_title', $data['chapter_title']);
    $this->db->bind(':chapter_content', $data['chapter_content']);
    
    return $this->db->execute();
}

public function getWritingGroupPosts($writingGroupId)
{
    $this->db->query("SELECT * FROM writing_group_posts WHERE writingGroup_id = :writingGroup_id ORDER BY created_at ASC");
    $this->db->bind(':writingGroup_id', $writingGroupId);
    return $this->db->resultSet();
}

public function getWritingGroupName($writingGroupId)
{
    $this->db->query("SELECT writingGroup_name FROM writinggroup WHERE writingGroup_id = :writingGroup_id");
    $this->db->bind(':writingGroup_id', $writingGroupId);
    return $this->db->single()->writingGroup_name;
}

public function getMemberById($memberId) {
    $this->db->query('SELECT community_member_name FROM community_member WHERE community_member_id = :member_id');
    
    $this->db->bind(':member_id', $memberId);
    
    $result = $this->db->single();
    return $result;
}

public function deleteWritingGroupPost($postId)
{
    $this->db->query("DELETE FROM writing_group_posts WHERE writingGroup_post_id = :post_id");
    $this->db->bind(':post_id', $postId);
    return $this->db->execute();
}

public function getWritingGroupPostById($postId)
{
    $this->db->query("SELECT * FROM writing_group_posts WHERE writingGroup_post_id = :post_id");
    $this->db->bind(':post_id', $postId);

    return $this->db->single();
}

public function createPost($data) {
    $this->db->query("INSERT INTO posts (community_id, community_member_id, title, content, created_at) 
                      VALUES (:community_id, :community_member_id, :title, :content, NOW())");

    $this->db->bind(':community_id', $data['community_id']);
    $this->db->bind(':community_member_id', $data['community_member_id']);
    $this->db->bind(':title', $data['title']);
    $this->db->bind(':content', $data['content']);

    return $this->db->execute();
}

public function checkUserExists($userId) {
    $this->db->query('SELECT * FROM community_member WHERE community_member_id = :user_id');
    $this->db->bind(':user_id', $userId);

    $row = $this->db->single();
    if ($row) {
        return true;
    } else {
        return false;
    }
}

public function getCommunityMemberId($userId, $communityId) {
    $this->db->query('SELECT community_member_id FROM community_member WHERE user_id = :user_id AND community_id = :community_id');
    $this->db->bind(':user_id', $userId);
    $this->db->bind(':community_id', $communityId);
    
    return $this->db->single(); 
}


public function isUserInCommunity($userId, $communityId) {
    $this->db->query('SELECT * FROM community_member WHERE community_member_id = :user_id AND community_id = :community_id');
    $this->db->bind(':user_id', $userId);
    $this->db->bind(':community_id', $communityId);

    $row = $this->db->single();

    return $row ? true : false;
}


public function getPostsByCommunity($communityId) {
    $this->db->query("SELECT * FROM posts WHERE community_id = :community_id ORDER BY created_at DESC");
    $this->db->bind(':community_id', $communityId);
    return $this->db->resultSet();
}
public function getPostById($postId) {
    $this->db->query("SELECT * FROM posts WHERE id = :id");
    $this->db->bind(':id', $postId);
    return $this->db->single();
}
public function deletePost($postId) {
    $this->db->query("DELETE FROM posts WHERE id = :id");
    $this->db->bind(':id', $postId);

    return $this->db->execute(); 
}





//user community functions

public function displayCommunity() {
    $this->db->query('SELECT * FROM community WHERE status = "approved"');
    return $this->db->resultSet();
}



public function joinCommunity($communityId){
    $this->db->query('INSERT INTO community_member (community_member_name, community_id, user_id) VALUES (:community_member_name, :community_id, :user_id)');
    $this->db->bind(':community_member_name', $_SESSION['user_name']);
    $this->db->bind(':community_id', $communityId);
    $this->db->bind(':user_id', $_SESSION['user_id']);

    return $this->db->execute();

}

public function getPosts($communityId) {
    $this->db->query("SELECT * FROM posts WHERE community_id = :community_id ORDER BY created_at DESC");
    $this->db->bind(':community_id', $communityId);
    return $this->db->resultSet();
}

public function getCommunityPostById($postId) {
    $this->db->query("SELECT * FROM posts WHERE id = :id");
    $this->db->bind(':id', $postId);
    return $this->db->single();
}


public function viewCommunityWritingGroups($communityId) {
    $this->db->query('SELECT * FROM writinggroup WHERE community_id = :community_id');
    $this->db->bind(':community_id', $communityId);
    return $this->db->resultSet(); // 

}

public function getCommunityWritingGroupPostsById($writingGroupId) {
    $this->db->query("SELECT * FROM writing_group_posts WHERE writingGroup_id = :writingGroup_id ORDER BY created_at ASC");
    $this->db->bind(':writingGroup_id', $writingGroupId);
    return $this->db->resultSet();
}

public function joinWritingGroup($writingGroupId) {
    $this->db->query('UPDATE community_member SET writingGroup_id = :writingGroup_id WHERE user_id = :user_id');
    $this->db->bind(':writingGroup_id', $writingGroupId);
    $this->db->bind(':user_id', $_SESSION['user_id']); 
    return $this->db->execute();
}

public function getCommunityMemberByUserIdAndGroupId($userId, $writingGroupId) {
    $this->db->query('SELECT * FROM community_member WHERE user_id = :user_id AND writingGroup_id = :writingGroup_id');
    $this->db->bind(':user_id', $userId);
    $this->db->bind(':writingGroup_id', $writingGroupId);
    return $this->db->single();
}

public function createCommunityWritingGroupPost($data) {
   
    $this->db->query("INSERT INTO writing_group_posts (writingGroup_id, community_member_id, chapter_title, chapter_content, created_at) 
                      VALUES (:writingGroup_id, :community_member_id, :chapter_title, :chapter_content, NOW())");
    
    $this->db->bind(':writingGroup_id', $data['writingGroup_id']);
    $this->db->bind(':community_member_id', $data['community_member_id']);  
    $this->db->bind(':chapter_title', $data['chapter_title']);
    $this->db->bind(':chapter_content', $data['chapter_content']);
    
    return $this->db->execute();
}


public function viewCommunityEvents($communityId){
    $this->db->query("SELECT * FROM event WHERE community_id = :community_id");
    $this->db->bind(':community_id', $communityId);
    return $this->db->resultset();
}

public function viewCommunityEventDetails($eventId){
    $this->db->query('SELECT * FROM event WHERE event_id = :event_id');
    $this->db->bind(':event_id', $eventId);
    return $this->db->single(); 

}

public function hasJoinedEvent($userId, $eventId) {
    $this->db->query('SELECT * FROM community_member WHERE user_id = :user_id AND event_id = :event_id');
    $this->db->bind(':user_id', $userId);
    $this->db->bind(':event_id', $eventId);

    $row = $this->db->single();
    return $row ? true : false;
}

public function joinEvent($userId, $eventId) {
    $this->db->query('UPDATE community_member SET event_id = :event_id WHERE user_id = :user_id');
    $this->db->bind(':event_id', $eventId);
    $this->db->bind(':user_id', $_SESSION['user_id']); 
    return $this->db->execute();
}

public function getUserJoinedCommunities($userId) {
    $this->db->query("SELECT c.* FROM community c
                      JOIN community_member cm ON c.communityId = cm.community_id
                      WHERE cm.user_id = :user_id");
    $this->db->bind(':user_id', $userId);
    return $this->db->resultSet();
}

public function leaveCommunity($userId, $communityId) {
    $this->db->query("DELETE FROM community_member WHERE user_id = :user_id AND community_id = :community_id");
    $this->db->bind(':user_id', $userId);
    $this->db->bind(':community_id', $communityId);
    return $this->db->execute();
}

public function getUserCommunityPosts($userId) {
    $this->db->query("SELECT * FROM posts WHERE user_id = :user_id");
    $this->db->bind(':user_id', $userId);
    return $this->db->resultSet();
}

public function getUserJoinedWritingGroups($userId) {
    $this->db->query("SELECT wg.* FROM writinggrou[ wg
                      JOIN community_member cm ON wg.writingGroup_id = cm.writingGroup_id
                      WHERE cm.user_id = :user_id");
    $this->db->bind(':user_id', $userId);
    return $this->db->resultSet();
}

public function leaveWritingGroup($userId, $groupId) {
    $this->db->query("DELETE FROM community_member WHERE user_id = :user_id AND writingGroup_id = :group_id");
    $this->db->bind(':user_id', $userId);
    $this->db->bind(':group_id', $groupId);
    return $this->db->execute();
}

public function getUserWritingGroupPosts($userId) {
    $this->db->query("SELECT * FROM writing_group_posts WHERE user_id = :user_id");
    $this->db->bind(':user_id', $userId);
    return $this->db->resultSet();
}

public function getUserJoinedEvents($userId) {
    $this->db->query("SELECT e.* FROM events e
                      JOIN event_participants ep ON e.event_id = ep.event_id
                      WHERE ep.user_id = :user_id");
    $this->db->bind(':user_id', $userId);
    return $this->db->resultSet();
}

public function leaveEvent($userId, $eventId) {
    $this->db->query("DELETE FROM event_participants WHERE user_id = :user_id AND event_id = :event_id");
    $this->db->bind(':user_id', $userId);
    $this->db->bind(':event_id', $eventId);
    return $this->db->execute();
}


}


?>
