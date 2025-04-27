document.addEventListener('DOMContentLoaded', function () {
    // Ensure URLROOT is defined (should be defined in the view)
    if (typeof URLROOT === 'undefined') {
        console.error('URLROOT is not defined. Make sure it is set in your PHP view.');
        return; // Stop execution if URLROOT is missing
    }
    // Ensure currentUserId is defined (should be defined in the view)
    if (typeof currentUserId === 'undefined') {
        console.error('currentUserId is not defined. Make sure it is set in your PHP view.');
        // Allow execution but warn, as it's mainly for user actions display
    }

    const userSearchInput = document.getElementById('userSearchInput');
    const userTableBody = document.getElementById('user-table-body');
    const userResultsContainer = document.getElementById('user-results-container'); // Optional: for 'no results' message

    const bookSearchInput = document.getElementById('bookSearchInput');
    const bookTableBody = document.getElementById('book-table-body');
    const bookResultsContainer = document.getElementById('book-results-container'); // Optional: for 'no results' message

    let searchTimeout; // To debounce requests

    // --- User Search ---
    if (userSearchInput && userTableBody) {
        userSearchInput.addEventListener('input', function () {
            clearTimeout(searchTimeout); // Clear previous timeout
            const searchTerm = this.value.trim();

            // Debounce: Wait 300ms after user stops typing
            searchTimeout = setTimeout(() => {
                fetchUsers(searchTerm);
            }, 300);
        });
    }

    async function fetchUsers(searchTerm) {
        const url = `${URLROOT}/admin/ajaxSearchUsers?search=${encodeURIComponent(searchTerm)}`;
        let response; // Define response outside try block to access in catch

        try {
            response = await fetch(url); // Assign to outer scope variable
            if (!response.ok) {
                // Throw an error with status text to be caught below
                throw new Error(`HTTP error! status: ${response.status} ${response.statusText}`);
            }
            const users = await response.json();
            displayUsers(users, searchTerm);
        } catch (error) {
            console.error('Error fetching or processing users:', error);
            // Try to get more details from the response if available
            let errorDetails = 'Could not retrieve details.';
            if (response) {
                try {
                    // Attempt to read the response body as text for clues
                    const textResponse = await response.text();
                    errorDetails = `Status: ${response.status}, Response: ${textResponse.substring(0, 500)}${textResponse.length > 500 ? '...' : ''}`; // Limit length
                } catch (textError) {
                    errorDetails = `Status: ${response.status}. Could not read response body.`;
                }
            } else {
                errorDetails = `Fetch failed. Check network connection or URL: ${url}`;
            }
            console.error('Fetch error details:', errorDetails);
            userTableBody.innerHTML = `<tr><td colspan="5">Error loading results. Please check console (F12) for details.</td></tr>`;
            if (userResultsContainer) userResultsContainer.innerHTML = '';
        }
    }

    function displayUsers(users, searchTerm) {
        userTableBody.innerHTML = ''; // Clear existing rows
        if (userResultsContainer) userResultsContainer.innerHTML = ''; // Clear message area

        if (users.length === 0) {
            const message = searchTerm
                ? `No users found matching your search term "${escapeHTML(searchTerm)}".`
                : 'No users found.';
            userTableBody.innerHTML = `<tr><td colspan="5">${message}</td></tr>`;
        } else {
            users.forEach(user => {
                const row = document.createElement('tr');
                const isCurrentUser = user.user_id == currentUserId; // Compare with defined currentUserId

                // Action buttons logic
                let actionsHtml = `
                    <a href="${URLROOT}/admin/viewUser/${user.user_id}" class="btn-view">View/Edit Role</a>
                `;
                if (!isCurrentUser) { // Only show Edit/Delete if not the current user
                    actionsHtml += `
                        <a href="${URLROOT}/admin/editUser/${user.user_id}" class="btn-edit">Edit Details</a>
                        <form action="${URLROOT}/admin/deleteUser/${user.user_id}" method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                            <button type="submit" class="btn-delete">Delete</button>
                        </form>
                    `;
                } else {
                    actionsHtml += ' (Current Admin)';
                }

                row.innerHTML = `
                    <td>${user.user_id}</td>
                    <td>${escapeHTML(user.user_name)}</td>
                    <td>${escapeHTML(user.user_email)}</td>
                    <td>${escapeHTML(user.user_role)}</td>
                    <td>${actionsHtml}</td>
                `;
                userTableBody.appendChild(row);
            });
        }
    }

    // --- Book Search ---
    if (bookSearchInput && bookTableBody) {
        bookSearchInput.addEventListener('input', function () {
            clearTimeout(searchTimeout); // Clear previous timeout
            const searchTerm = this.value.trim();

            // Debounce: Wait 300ms after user stops typing
            searchTimeout = setTimeout(() => {
                fetchBooks(searchTerm);
            }, 300);
        });
    }

    async function fetchBooks(searchTerm) {
        const url = `${URLROOT}/admin/ajaxSearchBooks?search=${encodeURIComponent(searchTerm)}`;
        let response; // Define response outside try block to access in catch

        try {
            response = await fetch(url); // Assign to outer scope variable
            if (!response.ok) {
                // Throw an error with status text to be caught below
                throw new Error(`HTTP error! status: ${response.status} ${response.statusText}`);
            }
            const books = await response.json();
            displayBooks(books, searchTerm);
        } catch (error) {
            console.error('Error fetching or processing books:', error);
            // Try to get more details from the response if available
            let errorDetails = 'Could not retrieve details.';
            if (response) {
                try {
                    // Attempt to read the response body as text for clues
                    const textResponse = await response.text();
                    errorDetails = `Status: ${response.status}, Response: ${textResponse.substring(0, 500)}${textResponse.length > 500 ? '...' : ''}`; // Limit length
                } catch (textError) {
                    errorDetails = `Status: ${response.status}. Could not read response body.`;
                }
            } else {
                errorDetails = `Fetch failed. Check network connection or URL: ${url}`;
            }
            console.error('Fetch error details:', errorDetails);
            bookTableBody.innerHTML = `<tr><td colspan="6">Error loading results. Please check console (F12) for details.</td></tr>`;
            if (bookResultsContainer) bookResultsContainer.innerHTML = '';
        }
    }

    function displayBooks(books, searchTerm) {
        bookTableBody.innerHTML = ''; // Clear existing rows
        if (bookResultsContainer) bookResultsContainer.innerHTML = ''; // Clear message area

        if (books.length === 0) {
            const message = searchTerm
                ? `No books found matching your search term "${escapeHTML(searchTerm)}".`
                : 'No books found.';
            bookTableBody.innerHTML = `<tr><td colspan="6">${message}</td></tr>`;
        } else {
            books.forEach(book => {
                const row = document.createElement('tr');
                const postedDate = book.created_at ? new Date(book.created_at).toISOString().split('T')[0] : 'N/A'; // Format date YYYY-MM-DD

                row.innerHTML = `
                    <td>${book.book_id}</td>
                    <td>${escapeHTML(book.book_title || 'N/A')}</td>
                    <td>${escapeHTML(book.book_author || 'N/A')}</td>
                    <td>${escapeHTML(book.owner_name || 'N/A')} (ID: ${book.owner_id})</td>
                    <td>${postedDate}</td>
                    <td>
                        <a href="${URLROOT}/admin/viewBook/${book.book_id}" class="btn-view">View Details</a>
                        <a href="${URLROOT}/admin/editBook/${book.book_id}" class="btn-edit">Edit</a>
                        <form action="${URLROOT}/admin/deleteBook/${book.book_id}" method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this book? This action cannot be undone.');">
                            <button type="submit" class="btn-delete">Delete</button>
                        </form>
                    </td>
                `;
                bookTableBody.appendChild(row);
            });
        }
    }

    // Helper function to escape HTML special characters
    function escapeHTML(str) {
        if (str === null || str === undefined) return '';
        return str.toString()
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

});
