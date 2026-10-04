```php
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Aircon Cleaning and Repair Service Schedule</title>

    <!-- Laravel CSRF Token -->
    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }

        form {
            max-width: 500px;
            margin-bottom: 30px;
        }

        label {
            display: block;
            margin-top: 10px;
            margin-bottom: 5px;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        button {
            margin-top: 15px;
            padding: 10px 15px;
            cursor: pointer;
        }

        button:disabled {
            cursor: not-allowed;
            opacity: 0.6;
        }

        .success {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            margin-top: 10px;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            margin-top: 10px;
        }

        .booking {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 10px;
        }

    </style>

</head>


<body>


    <!-- =====================================================
         PAGE TITLE
    ====================================================== -->

    <h1>
        Aircon Cleaning and Repair Service Schedule
    </h1>


    <!-- =====================================================
         CREATE BOOKING
    ====================================================== -->

    <h2>
        Create Booking
    </h2>


    <form id="create-schedule-form">


        <label for="customer_name">
            Customer Name
        </label>

        <input
            id="customer_name"
            name="customer_name"
            type="text"
            required
        >


        <label for="phone">
            Phone Number
        </label>

        <input
            id="phone"
            name="phone"
            type="text"
            required
        >


        <label for="service_type">
            Service Needed
        </label>

        <select
            id="service_type"
            name="service_type"
            required
        >

            <option value="">
                Choose one
            </option>

            <option value="Cleaning">
                Aircon Cleaning
            </option>

            <option value="Repair">
                Aircon Repair
            </option>

            <option value="Cleaning and Repair">
                Cleaning and Repair
            </option>

        </select>


        <label for="schedule_date">
            Preferred Date and Time
        </label>

        <input
            id="schedule_date"
            name="schedule_date"
            type="datetime-local"
            required
        >


        <label for="notes">
            Notes
        </label>

        <textarea
            id="notes"
            name="notes"
            rows="4"
        ></textarea>


        <button
            id="create-button"
            type="submit"
        >
            Save Booking
        </button>


        <p id="create-loading" hidden>
            Saving booking...
        </p>


        <p
            id="create-success"
            class="success"
            hidden
        ></p>


        <div
            id="create-errors"
            class="error"
            role="alert"
            hidden
        ></div>


    </form>


    <hr>


    <!-- =====================================================
         UPDATE BOOKING
    ====================================================== -->

    <form
        id="update-schedule-form"
        hidden
    >

        <h2>
            Update Booking
        </h2>


        <!--
            Hidden ID

            The user does not see this.

            Example:
            edit-id = 3

            This means:
            Update booking #3
        -->

        <input
            type="hidden"
            id="edit-id"
        >


        <label for="edit-customer-name">
            Customer Name
        </label>

        <input
            type="text"
            id="edit-customer-name"
            required
        >


        <label for="edit-phone">
            Phone Number
        </label>

        <input
            type="text"
            id="edit-phone"
            required
        >


        <label for="edit-service-type">
            Service Needed
        </label>

        <select
            id="edit-service-type"
            required
        >

            <option value="Cleaning">
                Aircon Cleaning
            </option>

            <option value="Repair">
                Aircon Repair
            </option>

            <option value="Cleaning and Repair">
                Cleaning and Repair
            </option>

        </select>


        <label for="edit-schedule-date">
            Preferred Date and Time
        </label>

        <input
            type="datetime-local"
            id="edit-schedule-date"
            required
        >


        <label for="edit-notes">
            Notes
        </label>

        <textarea
            id="edit-notes"
            rows="4"
        ></textarea>


        <button
            type="submit"
            id="update-button"
        >
            Update Booking
        </button>


        <button
            type="button"
            id="cancel-update-button"
        >
            Cancel
        </button>


        <p id="update-loading" hidden>
            Updating booking...
        </p>


        <div
            id="update-success"
            class="success"
            hidden
        ></div>


        <div
            id="update-errors"
            class="error"
            hidden
        ></div>


    </form>


    <hr>


    <!-- =====================================================
         CURRENT BOOKINGS
    ====================================================== -->

    <h2>
        Current Bookings
    </h2>


    <ul id="schedule-list">

        @forelse ($schedules as $schedule)

            <li
                id="schedule-{{ $schedule->id }}"
                class="booking"
            >

                <strong class="customer-name">
                    {{ $schedule->customer_name }}
                </strong>

                <br>


                Phone:

                <span class="phone">
                    {{ $schedule->phone }}
                </span>

                <br>


                Service:

                <span class="service-type">
                    {{ $schedule->service_type }}
                </span>

                <br>


                Date:

                <span class="schedule-date">
                    {{ $schedule->schedule_date }}
                </span>

                <br>


                Notes:

                <span class="notes">
                    {{ $schedule->notes }}
                </span>

                <br>


                <!-- EDIT BUTTON -->

                <button
                    type="button"
                    class="edit-button"

                    data-id="{{ $schedule->id }}"

                    data-customer-name="{{ $schedule->customer_name }}"

                    data-phone="{{ $schedule->phone }}"

                    data-service-type="{{ $schedule->service_type }}"

                    data-schedule-date="{{ \Carbon\Carbon::parse($schedule->schedule_date)->format('Y-m-d\TH:i') }}"

                    data-notes="{{ $schedule->notes }}"
                >
                    Edit
                </button>


            </li>

        @empty

            <li>
                No bookings found.
            </li>

        @endforelse

    </ul>


    <!-- =====================================================
         JAVASCRIPT
    ====================================================== -->

    <script>


    /* ========================================================
       CSRF TOKEN
    ======================================================== */

    const csrfToken =
        document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute('content');


    /* ========================================================
       CREATE ELEMENTS
    ======================================================== */

    const createForm =
        document.querySelector('#create-schedule-form');

    const createButton =
        document.querySelector('#create-button');

    const createLoading =
        document.querySelector('#create-loading');

    const createSuccess =
        document.querySelector('#create-success');

    const createErrors =
        document.querySelector('#create-errors');


    /* ========================================================
       UPDATE ELEMENTS
    ======================================================== */

    const updateForm =
        document.querySelector('#update-schedule-form');

    const updateButton =
        document.querySelector('#update-button');

    const updateLoading =
        document.querySelector('#update-loading');

    const updateSuccess =
        document.querySelector('#update-success');

    const updateErrors =
        document.querySelector('#update-errors');

    const cancelUpdateButton =
        document.querySelector('#cancel-update-button');


    /* ========================================================
       CREATE BOOKING
    ======================================================== */

    createForm.addEventListener(
        'submit',
        async (event) => {

            event.preventDefault();


            // Clear previous messages

            createErrors.hidden = true;

            createErrors.innerHTML = '';

            createSuccess.hidden = true;

            createSuccess.innerHTML = '';


            // Loading state

            createButton.disabled = true;

            createButton.textContent =
                'Saving...';

            createLoading.hidden = false;


            // Get form values

            const data = {

                customer_name:
                    document.querySelector(
                        '#customer_name'
                    ).value,

                phone:
                    document.querySelector(
                        '#phone'
                    ).value,

                service_type:
                    document.querySelector(
                        '#service_type'
                    ).value,

                schedule_date:
                    document.querySelector(
                        '#schedule_date'
                    ).value,

                notes:
                    document.querySelector(
                        '#notes'
                    ).value

            };


            try {


                // Send POST request

                const response =
                    await fetch(
                        '/schedules',
                        {

                            method: 'POST',

                            headers: {

                                'Content-Type':
                                    'application/json',

                                'Accept':
                                    'application/json',

                                'X-CSRF-TOKEN':
                                    csrfToken

                            },

                            body:
                                JSON.stringify(data)

                        }
                    );


                const result =
                    await response.json();


                // Validation errors

                if (
                    response.status === 422
                ) {

                    displayErrors(
                        createErrors,
                        result.errors
                    );

                    return;
                }


                // Other error

                if (!response.ok) {

                    createErrors.innerHTML =
                        result.message ||
                        'Something went wrong.';

                    createErrors.hidden =
                        false;

                    return;
                }


                // Success

                createSuccess.textContent =
                    result.message ||
                    'Booking created successfully!';

                createSuccess.hidden =
                    false;


                // Clear form

                createForm.reset();


                // Add new booking to page

                addBookingToPage(
                    result.data
                );


            }


            catch (error) {

                console.error(error);

                createErrors.textContent =
                    'Unable to connect to the server.';

                createErrors.hidden =
                    false;

            }


            finally {

                createButton.disabled =
                    false;

                createButton.textContent =
                    'Save Booking';

                createLoading.hidden =
                    true;

            }

        }
    );


    /* ========================================================
       ADD NEW BOOKING TO PAGE
    ======================================================== */

    function addBookingToPage(booking) {

        const list =
            document.querySelector(
                '#schedule-list'
            );


        // Remove "No bookings found"

        const emptyMessage =
            list.querySelector('li:not([id])');

        if (emptyMessage) {

            emptyMessage.remove();

        }


        // Create booking element

        const item =
            document.createElement('li');

        item.id =
            `schedule-${booking.id}`;

        item.className =
            'booking';


        item.innerHTML = `

            <strong class="customer-name">
                ${escapeHtml(
                    booking.customer_name
                )}
            </strong>

            <br>

            Phone:

            <span class="phone">
                ${escapeHtml(
                    booking.phone
                )}
            </span>

            <br>

            Service:

            <span class="service-type">
                ${escapeHtml(
                    booking.service_type
                )}
            </span>

            <br>

            Date:

            <span class="schedule-date">
                ${escapeHtml(
                    booking.schedule_date
                )}
            </span>

            <br>

            Notes:

            <span class="notes">
                ${escapeHtml(
                    booking.notes || ''
                )}
            </span>

            <br>

            <button
                type="button"
                class="edit-button"
            >
                Edit
            </button>

        `;


        list.appendChild(item);


        // Add Edit button function

        const editButton =
            item.querySelector(
                '.edit-button'
            );


        editButton.addEventListener(
            'click',
            () => {

                showUpdateForm(
                    booking
                );

            }
        );


        // Store updated information
        updateEditButtonData(
            editButton,
            booking
        );

    }


    /* ========================================================
       FIND EXISTING EDIT BUTTONS
    ======================================================== */

    const editButtons =
        document.querySelectorAll(
            '.edit-button'
        );


    editButtons.forEach(
        (button) => {

            button.addEventListener(
                'click',
                () => {

                    const booking = {

                        id:
                            button.dataset.id,

                        customer_name:
                            button.dataset.customerName,

                        phone:
                            button.dataset.phone,

                        service_type:
                            button.dataset.serviceType,

                        schedule_date:
                            button.dataset.scheduleDate,

                        notes:
                            button.dataset.notes

                    };


                    showUpdateForm(
                        booking
                    );

                }
            );

        }
    );


    /* ========================================================
       SHOW UPDATE FORM
    ======================================================== */

    function showUpdateForm(booking) {


        // Put booking ID into hidden input

        document.querySelector(
            '#edit-id'
        ).value =
            booking.id;


        // Put customer name

        document.querySelector(
            '#edit-customer-name'
        ).value =
            booking.customer_name || '';


        // Put phone

        document.querySelector(
            '#edit-phone'
        ).value =
            booking.phone || '';


        // Put service

        document.querySelector(
            '#edit-service-type'
        ).value =
            booking.service_type || '';


        // Put date

        document.querySelector(
            '#edit-schedule-date'
        ).value =
            formatDateForInput(
                booking.schedule_date
            );


        // Put notes

        document.querySelector(
            '#edit-notes'
        ).value =
            booking.notes || '';


        // Clear messages

        updateErrors.hidden =
            true;

        updateErrors.innerHTML =
            '';

        updateSuccess.hidden =
            true;

        updateSuccess.innerHTML =
            '';


        // Show form

        updateForm.hidden =
            false;


        // Scroll to form

        updateForm.scrollIntoView({
            behavior: 'smooth'
        });

    }


    /* ========================================================
       UPDATE BOOKING
    ======================================================== */

    updateForm.addEventListener(
        'submit',
        async (event) => {

            event.preventDefault();


            // Clear messages

            updateErrors.hidden =
                true;

            updateErrors.innerHTML =
                '';

            updateSuccess.hidden =
                true;

            updateSuccess.innerHTML =
                '';


            // Loading

            updateButton.disabled =
                true;

            updateButton.textContent =
                'Updating...';

            updateLoading.hidden =
                false;


            // Get ID

            const id =
                document.querySelector(
                    '#edit-id'
                ).value;


            // Get updated values

            const data = {

                customer_name:
                    document.querySelector(
                        '#edit-customer-name'
                    ).value,

                phone:
                    document.querySelector(
                        '#edit-phone'
                    ).value,

                service_type:
                    document.querySelector(
                        '#edit-service-type'
                    ).value,

                schedule_date:
                    document.querySelector(
                        '#edit-schedule-date'
                    ).value,

                notes:
                    document.querySelector(
                        '#edit-notes'
                    ).value

            };


            try {


                // Send PUT request

                const response =
                    await fetch(
                        `/schedules/${id}`,
                        {

                            method: 'PUT',

                            headers: {

                                'Content-Type':
                                    'application/json',

                                'Accept':
                                    'application/json',

                                'X-CSRF-TOKEN':
                                    csrfToken

                            },

                            body:
                                JSON.stringify(data)

                        }
                    );


                const result =
                    await response.json();


                // Validation error

                if (
                    response.status === 422
                ) {

                    displayErrors(
                        updateErrors,
                        result.errors
                    );

                    return;
                }


                // Other server error

                if (!response.ok) {

                    updateErrors.innerHTML =
                        result.message ||
                        'Unable to update booking.';

                    updateErrors.hidden =
                        false;

                    return;
                }


                // Success

                updateSuccess.textContent =
                    result.message ||
                    'Booking updated successfully!';

                updateSuccess.hidden =
                    false;


                // Update booking on screen

                updateBookingOnPage(
                    result.data
                );


                // Hide form

                setTimeout(() => {

                    updateForm.hidden =
                        true;

                }, 1000);

            }


            catch (error) {

                console.error(error);

                updateErrors.textContent =
                    'Unable to connect to the server.';

                updateErrors.hidden =
                    false;

            }


            finally {

                updateButton.disabled =
                    false;

                updateButton.textContent =
                    'Update Booking';

                updateLoading.hidden =
                    true;

            }

        }
    );


    /* ========================================================
       UPDATE BOOKING ON PAGE
    ======================================================== */

    function updateBookingOnPage(
        booking
    ) {

        const item =
            document.querySelector(
                `#schedule-${booking.id}`
            );


        if (!item) {

            return;

        }


        item.querySelector(
            '.customer-name'
        ).textContent =
            booking.customer_name;


        item.querySelector(
            '.phone'
        ).textContent =
            booking.phone;


        item.querySelector(
            '.service-type'
        ).textContent =
            booking.service_type;


        item.querySelector(
            '.schedule-date'
        ).textContent =
            booking.schedule_date;


        item.querySelector(
            '.notes'
        ).textContent =
            booking.notes || '';


        // Update Edit button

        const editButton =
            item.querySelector(
                '.edit-button'
            );


        updateEditButtonData(
            editButton,
            booking
        );

    }


    /* ========================================================
       UPDATE EDIT BUTTON DATA
    ======================================================== */

    function updateEditButtonData(
        button,
        booking
    ) {

        button.dataset.id =
            booking.id;

        button.dataset.customerName =
            booking.customer_name;

        button.dataset.phone =
            booking.phone;

        button.dataset.serviceType =
            booking.service_type;

        button.dataset.scheduleDate =
            formatDateForInput(
                booking.schedule_date
            );

        button.dataset.notes =
            booking.notes || '';

    }


    /* ========================================================
       CANCEL UPDATE
    ======================================================== */

    cancelUpdateButton.addEventListener(
        'click',
        () => {

            updateForm.hidden =
                true;

            updateErrors.hidden =
                true;

            updateSuccess.hidden =
                true;

        }
    );


    /* ========================================================
       DISPLAY ERRORS
    ======================================================== */

    function displayErrors(
        container,
        errors
    ) {

        container.innerHTML =
            '';


        if (!errors) {

            container.textContent =
                'Please check your information.';

            container.hidden =
                false;

            return;

        }


        Object.values(errors)
            .forEach((messages) => {

                messages.forEach(
                    (message) => {

                        const paragraph =
                            document.createElement(
                                'p'
                            );

                        paragraph.textContent =
                            message;

                        container.appendChild(
                            paragraph
                        );

                    }
                );

            });


        container.hidden =
            false;

    }


    /* ========================================================
       FORMAT DATE
    ======================================================== */

    function formatDateForInput(
        date
    ) {

        if (!date) {

            return '';

        }


        return date
            .replace(' ', 'T')
            .substring(0, 16);

    }


    /* ========================================================
       ESCAPE HTML
    ======================================================== */

    function escapeHtml(
        value
    ) {

        const div =
            document.createElement(
                'div'
            );

        div.textContent =
            value;

        return div.innerHTML;

    }


    </script>


</body>

</html>
```
