// Custom Alert System similar to SweetAlert

// Create a test alert function to debug positioning issues
function testAlert(message) {
    // Create container if it doesn't exist
    let container = document.getElementById('testAlertContainer');
    if (!container) {
        container = document.createElement('div');
        container.id = 'testAlertContainer';
        document.body.appendChild(container);
    }
    
    // Clear any existing alerts
    container.innerHTML = '';
    
    // Create the alert HTML
    const alertHTML = `
        <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); display: flex; justify-content: center; align-items: center; z-index: 9999999;">
            <div style="background-color: white; border: 3px solid #333; border-radius: 8px; padding: 20px; width: 90%; max-width: 400px; text-align: center; box-shadow: 0 4px 16px rgba(0,0,0,0.2);">
                <h3 style="margin-top: 0; color: #333;">${message}</h3>
                <button onclick="document.getElementById('testAlertContainer').innerHTML = '';" style="background-color: #4CAF50; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer; margin-top: 15px;">OK</button>
            </div>
        </div>
    `;
    
    // Add the alert to the container
    container.innerHTML = alertHTML;
}

class CustomAlert {
    constructor() {
        this.createAlertContainer();
    }

    createAlertContainer() {
        // Create the alert overlay container if it doesn't exist
        if (!document.getElementById('customAlertContainer')) {
            const container = document.createElement('div');
            container.id = 'customAlertContainer';
            document.body.appendChild(container);
        }
    }

    // Main alert function similar to SweetAlert
    fire(options) {
        const container = document.getElementById('customAlertContainer');

        // Default options
        const defaults = {
            title: '',
            text: '',
            icon: 'info', // 'success', 'error', 'warning', 'info'
            confirmButtonText: 'OK',
            showCancelButton: false,
            cancelButtonText: 'Cancel',
            onConfirm: null,
            onCancel: null,
            timer: null
        };

        // Merge defaults with provided options
        const settings = { ...defaults, ...options };

        // Create alert HTML with inline styles
        const alertHTML = `
            <div class="custom-alert-overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); display: flex; justify-content: center; align-items: center; z-index: 999999;">
                <div class="custom-alert" style="background-color: #fff; border-radius: 8px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25); max-width: 400px; width: 90%; padding: 25px; text-align: center; z-index: 1000000; border: 3px solid #333; color: #222; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                    ${settings.icon ? `<div class="custom-alert-icon ${settings.icon}">
                        ${this.getIconHTML(settings.icon)}
                    </div>` : ''}
                    ${settings.title ? `<div class="custom-alert-title">${settings.title}</div>` : ''}
                    ${settings.text ? `<div class="custom-alert-message">${settings.text}</div>` : ''}
                    <div class="custom-alert-buttons">
                        <button class="custom-alert-btn custom-alert-btn-primary" id="alertConfirmBtn">${settings.confirmButtonText}</button>
                        ${settings.showCancelButton ? `<button class="custom-alert-btn custom-alert-btn-cancel" id="alertCancelBtn">${settings.cancelButtonText}</button>` : ''}
                    </div>
                </div>
            </div>
        `;

        // Add alert to container
        container.innerHTML = alertHTML;

        // Get elements
        const overlay = container.querySelector('.custom-alert-overlay');
        const confirmBtn = container.querySelector('#alertConfirmBtn');
        
        // Handle confirm button click
        confirmBtn.addEventListener('click', () => {
            this.closeAlert(overlay);
            if (typeof settings.onConfirm === 'function') {
                settings.onConfirm();
            }
        });

        // Handle cancel button click if shown
        if (settings.showCancelButton) {
            const cancelBtn = container.querySelector('#alertCancelBtn');
            cancelBtn.addEventListener('click', () => {
                this.closeAlert(overlay);
                if (typeof settings.onCancel === 'function') {
                    settings.onCancel();
                }
            });
        }

        // Handle auto-close if timer is set
        if (settings.timer && settings.timer > 0) {
            setTimeout(() => {
                this.closeAlert(overlay);
                if (typeof settings.onConfirm === 'function') {
                    settings.onConfirm();
                }
            }, settings.timer);
        }

        // Return promise for async handling
        return new Promise((resolve, reject) => {
            confirmBtn.addEventListener('click', () => {
                resolve('confirmed');
            });

            if (settings.showCancelButton) {
                const cancelBtn = container.querySelector('#alertCancelBtn');
                cancelBtn.addEventListener('click', () => {
                    resolve('canceled');
                });
            }
        });
    }

    // Close alert
    closeAlert(overlay) {
        if (overlay && overlay.parentNode) {
            overlay.parentNode.removeChild(overlay);
        }
    }

    // Get icon HTML based on type
    getIconHTML(icon) {
        switch (icon) {
            case 'success':
                return '✓';
            case 'error':
                return '✕';
            case 'warning':
                return '!';
            case 'info':
                return 'i';
            default:
                return 'i';
        }
    }

    // Convenience methods for common alert types
    success(options) {
        return this.fire({
            icon: 'success',
            ...options
        });
    }

    error(options) {
        return this.fire({
            icon: 'error',
            ...options
        });
    }

    warning(options) {
        return this.fire({
            icon: 'warning',
            ...options
        });
    }

    info(options) {
        return this.fire({
            icon: 'info',
            ...options
        });
    }

    confirm(options) {
        return this.fire({
            icon: 'warning',
            showCancelButton: true,
            ...options
        });
    }

    // New method that uses the test alert approach
    simpleAlert(options) {
        const settings = {
            title: 'Alert',
            text: '',
            ...options
        };
        
        const message = settings.title + (settings.text ? '<br>' + settings.text : '');
        testAlert(message);
        
        return new Promise(resolve => {
            // Resolve after button click
            const checkInterval = setInterval(() => {
                if (document.getElementById('testAlertContainer').innerHTML === '') {
                    clearInterval(checkInterval);
                    resolve('confirmed');
                }
            }, 100);
        });
    }
}

// Initialize the alert system
const alert = new CustomAlert();

// Add a global test function that can be called from the console
window.showTestAlert = function(message = "Test Alert") {
    testAlert(message);
};