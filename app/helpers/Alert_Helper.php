<?php

/**
 * Alert Helper Class
 * This helper extends the session flash messages to work with our custom alert system
 */
class Alert_Helper
{
    /**
     * Set an alert message to be displayed later
     * 
     * @param string $type The type of alert ('success', 'error', 'warning', 'info')
     * @param string $title The alert title
     * @param string $message The alert message
     * @param int $timer Optional auto-close timer in milliseconds
     * @return void
     */
    public static function set($type, $title, $message, $timer = null)
    {
        $_SESSION['alert'] = [
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'timer' => $timer
        ];
    }

    /**
     * Set a success alert
     * 
     * @param string $title The alert title
     * @param string $message The alert message
     * @param int $timer Optional auto-close timer in milliseconds
     * @return void
     */
    public static function success($title, $message, $timer = null)
    {
        self::set('success', $title, $message, $timer);
    }

    /**
     * Set an error alert
     * 
     * @param string $title The alert title
     * @param string $message The alert message
     * @param int $timer Optional auto-close timer in milliseconds
     * @return void
     */
    public static function error($title, $message, $timer = null)
    {
        self::set('error', $title, $message, $timer);
    }

    /**
     * Set a warning alert
     * 
     * @param string $title The alert title
     * @param string $message The alert message
     * @param int $timer Optional auto-close timer in milliseconds
     * @return void
     */
    public static function warning($title, $message, $timer = null)
    {
        self::set('warning', $title, $message, $timer);
    }

    /**
     * Set an info alert
     * 
     * @param string $title The alert title
     * @param string $message The alert message
     * @param int $timer Optional auto-close timer in milliseconds
     * @return void
     */
    public static function info($title, $message, $timer = null)
    {
        self::set('info', $title, $message, $timer);
    }

    /**
     * Generate JavaScript code to display alert
     * 
     * @return string The JavaScript code to display the alert or empty string if no alert
     */
    public static function display()
    {
        if (isset($_SESSION['alert'])) {
            $alert = $_SESSION['alert'];
            $type = $alert['type'];
            $title = $alert['title'];
            $message = $alert['message'];
            $timer = $alert['timer'];

            // Clear the alert from session
            unset($_SESSION['alert']);

            // Build JavaScript to trigger alert
            $js = '<script>';
            $js .= 'document.addEventListener("DOMContentLoaded", function() {';
            $js .= '  alert.' . $type . '({';
            $js .= '    title: "' . addslashes($title) . '",';
            $js .= '    text: "' . addslashes($message) . '",';

            if ($timer !== null) {
                $js .= '    timer: ' . (int)$timer . ',';
            }

            $js .= '  });';
            $js .= '});';
            $js .= '</script>';

            return $js;
        }

        return '';
    }
}
