<?php

require_once __DIR__ . '/../Admin.php';

class EventAdminController extends Admin
{
    // List all events
    public function manageEvents()
    {
        $events = $this->adminModel->getAllEvents();
        $data = [
            'title' => 'Manage Events',
            'events' => $events
        ];
        $this->view('pages/admin/v_manage_events', $data);
    }

    // Show Add Event Form (GET) / Handle Add Event Submission (POST)
    public function addEvent()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'event_name' => trim($_POST['event_name']),
                'event_description' => trim($_POST['event_description']),
                'event_place' => trim($_POST['event_place']),
                'event_date' => trim($_POST['event_date']),
                'event_time' => trim($_POST['event_time']),
                'community_id' => trim($_POST['community_id']),
                'title' => 'Add New Event',
                'event_name_err' => '',
                'event_description_err' => '',
                'event_place_err' => '',
                'event_date_err' => '',
                'event_time_err' => '',
                'community_id_err' => ''
            ];

            // Validation
            if (empty($data['event_name'])) {
                $data['event_name_err'] = 'Please enter event name';
            }
            if (empty($data['event_description'])) {
                $data['event_description_err'] = 'Please enter description';
            }
            if (empty($data['event_place'])) {
                $data['event_place_err'] = 'Please enter place';
            }
            if (empty($data['event_date'])) {
                $data['event_date_err'] = 'Please enter date';
            }
            if (empty($data['event_time'])) {
                $data['event_time_err'] = 'Please enter time';
            }
            if (empty($data['community_id'])) {
                $data['community_id_err'] = 'Please select a community';
            }

            if (empty($data['event_name_err']) && empty($data['event_description_err']) && empty($data['event_place_err']) && empty($data['event_date_err']) && empty($data['event_time_err']) && empty($data['community_id_err'])) {
                if ($this->adminModel->addEvent($data)) {
                    Alert_Helper::success('Success', 'Event added successfully.');
                    redirect('admin/event/manageEvents');
                } else {
                    Alert_Helper::error('Add failed', 'Failed to add event.');
                    $this->view('pages/admin/v_add_event', $data);
                }
            } else {
                $this->view('pages/admin/v_add_event', $data);
            }
        } else {
            $data = [
                'event_name' => '',
                'event_description' => '',
                'event_place' => '',
                'event_date' => '',
                'event_time' => '',
                'community_id' => '',
                'title' => 'Add New Event',
                'event_name_err' => '',
                'event_description_err' => '',
                'event_place_err' => '',
                'event_date_err' => '',
                'event_time_err' => '',
                'community_id_err' => ''
            ];
            $this->view('pages/admin/v_add_event', $data);
        }
    }

    // Show Edit Event Form
    public function editEvent($eventId)
    {
        $event = $this->adminModel->getEventById($eventId);
        if (!$event) {
            Alert_Helper::error('Event not found', 'Event not found.');
            redirect('admin/event/manageEvents');
        }
        $data = [
            'event_id' => $eventId,
            'event_name' => $event->event_name,
            'event_description' => $event->event_description,
            'event_place' => $event->event_place,
            'event_date' => $event->event_date,
            'event_time' => $event->event_time,
            'community_id' => $event->community_id,
            'title' => 'Edit Event',
            'event_name_err' => '',
            'event_description_err' => '',
            'event_place_err' => '',
            'event_date_err' => '',
            'event_time_err' => '',
            'community_id_err' => ''
        ];
        $this->view('pages/admin/v_edit_event', $data);
    }

    // Handle Update Event Submission
    public function updateEvent($eventId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $event = $this->adminModel->getEventById($eventId);
            if (!$event) {
                Alert_Helper::error('Event not found', 'Event not found.');
                redirect('admin/event/manageEvents');
                return;
            }
            $data = [
                'event_id' => $eventId,
                'event_name' => trim($_POST['event_name']),
                'event_description' => trim($_POST['event_description']),
                'event_place' => trim($_POST['event_place']),
                'event_date' => trim($_POST['event_date']),
                'event_time' => trim($_POST['event_time']),
                'community_id' => trim($_POST['community_id']),
                'title' => 'Edit Event',
                'event_name_err' => '',
                'event_description_err' => '',
                'event_place_err' => '',
                'event_date_err' => '',
                'event_time_err' => '',
                'community_id_err' => ''
            ];
            // Validation (same as addEvent)
            if (empty($data['event_name'])) {
                $data['event_name_err'] = 'Please enter event name';
            }
            if (empty($data['event_description'])) {
                $data['event_description_err'] = 'Please enter description';
            }
            if (empty($data['event_place'])) {
                $data['event_place_err'] = 'Please enter place';
            }
            if (empty($data['event_date'])) {
                $data['event_date_err'] = 'Please enter date';
            }
            if (empty($data['event_time'])) {
                $data['event_time_err'] = 'Please enter time';
            }
            if (empty($data['community_id'])) {
                $data['community_id_err'] = 'Please select a community';
            }
            if (empty($data['event_name_err']) && empty($data['event_description_err']) && empty($data['event_place_err']) && empty($data['event_date_err']) && empty($data['event_time_err']) && empty($data['community_id_err'])) {
                if ($this->adminModel->updateEvent($eventId, $data)) {
                    Alert_Helper::success('Success', 'Event updated successfully.');
                    redirect('admin/event/manageEvents');
                } else {
                    Alert_Helper::error('Update failed', 'Failed to update event.');
                    $this->view('pages/admin/v_edit_event', $data);
                }
            } else {
                $this->view('pages/admin/v_edit_event', $data);
            }
        } else {
            redirect('admin/event/manageEvents');
        }
    }

    // Delete Event (Handles POST request)
    public function deleteEvent($eventId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->adminModel->deleteEvent($eventId)) {
                Alert_Helper::success('Success', 'Event deleted successfully.');
            } else {
                Alert_Helper::error('Delete failed', 'Failed to delete event.');
            }
            redirect('admin/event/manageEvents');
        } else {
            redirect('admin/event/manageEvents');
        }
    }
}
