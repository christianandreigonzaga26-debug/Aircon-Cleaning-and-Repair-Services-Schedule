```blade
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

        /* =====================================================
           SEARCH BOX
        ====================================================== */

        .search-container {
            max-width: 500px;
            margin: 15px 0 20px 0;
        }

        #searchInput {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }

        #searchInput:focus {
            outline: none;
            border-color: #007bff;
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

    <h2>
        Edit Booking
    </h2>


    <form
        id="update-schedule-form"
        hidden
    >

        <input
            id="edit-id"
            type="hidden"
        >


        <label for="edit-customer-name">
            Customer Name
        </label>

        <input
            id="edit-customer-name"
            required
        >


        <label for="edit-phone">
            Phone Number
        </label>

        <input
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
            Schedule Date and Time
        </label>

        <input
            id="edit-schedule-date"
            type="datetime-local"
            required
        >


        <label for="edit-notes">
            Notes
        </label>

        <textarea
            id="edit-notes"
        ></textarea>


        <button
            id="update-button"
            type="submit"
        >
            Update Booking
        </button>


        <button
            id="cancel-update-button"
            type="button"
        >
            Cancel
        </button>


        <p
            id="update-loading"
            hidden
        >
            Updating booking...
        </p>


        <p
            id="update-success"
            class="success"
            hidden
        ></p>


        <div
            id="update-errors"
            class="error"
            role="alert"
            hidden
        ></div>

    </form>


    <hr>


    <!-- =====================================================
         CURRENT BOOKINGS
    ====================================================== -->

    <!-- =====================================================
         CURRENT BOOKINGS + SEARCH
    ====================================================== -->

    <h2>
        Current Bookings
    </h2>

    <!-- SEARCH TEXT FIELD -->
    <div class="search-container">
        <input
            type="text"
            id="searchInput"
            placeholder="Search aircon cleaning or repair services..."
        >
    </div>

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

            <li id="no-bookings">
                No bookings found.
            </li>

        @endforelse

    </ul>


    <!-- =====================================================
         JAVASCRIPT
    ====================================================== -->

    <script>

        /* =====================================================
           CSRF TOKEN
        ====================================================== */

        const csrfToken =
            document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content');


        /* =====================================================
           CREATE ELEMENTS
        ====================================================== */

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

        const scheduleList =
            document.querySelector('#schedule-list');


        /* =====================================================
           SEARCH BOOKINGS
        ====================================================== */

        const searchInput =
            document.querySelector('#searchInput');

        searchInput.addEventListener(
            'input',
            function () {

                const searchValue =
                    this.value
                        .toLowerCase()
                        .trim();

                const bookings =
                    document.querySelectorAll(
                        '#schedule-list .booking'
                    );

                bookings.forEach(
                    function (booking) {

                        const customerName =
                            booking.querySelector(
                                '.customer-name'
                            )?.textContent
                            .toLowerCase() || '';

                        const phone =
                            booking.querySelector(
                                '.phone'
                            )?.textContent
                            .toLowerCase() || '';

                        const serviceType =
                            booking.querySelector(
                                '.service-type'
                            )?.textContent
                            .toLowerCase() || '';

                        const notes =
                            booking.querySelector(
                                '.notes'
                            )?.textContent
                            .toLowerCase() || '';

                        const bookingData =
                            customerName + ' ' +
                            phone + ' ' +
                            serviceType + ' ' +
                            notes;

                        if (
                            bookingData.includes(
                                searchValue
                            )
                        ) {
                            booking.style.display = '';
                        } else {
                            booking.style.display = 'none';
                        }
                    }
                );
            }
        );


        /* =====================================================
           UPDATE ELEMENTS
        ====================================================== */

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


        /* =====================================================
           CREATE BOOKING
           POST /schedules
        ====================================================== */

        createForm.addEventListener(
            'submit',
            async (event) => {

                event.preventDefault();


                /* Clear previous messages */

                createErrors.innerHTML = '';
                createErrors.hidden = true;

                createSuccess.textContent = '';
                createSuccess.hidden = true;


                /* Loading state */

                createButton.disabled = true;
                createButton.textContent = 'Saving...';
                createLoading.hidden = false;


                /* Get form data */

                const formData =
                    new FormData(createForm);


                const data = {

                    customer_name:
                        formData.get('customer_name'),

                    phone:
                        formData.get('phone'),

                    service_type:
                        formData.get('service_type'),

                    schedule_date:
                        formData.get('schedule_date'),

                    notes:
                        formData.get('notes')

                };


                try {

                    /* Send POST request */

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


                    /* Validation errors */

                    if (response.status === 422) {

                        displayErrors(
                            createErrors,
                            result.errors
                        );

                        return;
                    }


                    /* Other server errors */

                    if (!response.ok) {

                        createErrors.textContent =
                            result.message ||
                            'Sorry, the booking could not be saved. Please try again.';

                        createErrors.hidden = false;

                        return;
                    }


                    /* Successful booking */

                    createSuccess.textContent =
                        result.message ||
                        'Booking saved successfully!';

                    createSuccess.hidden = false;


                    /* Add new booking without reload */

                    if (result.data) {

                        addBookingToPage(
                            result.data
                        );

                    }


                    /* Clear form */

                    createForm.reset();

                }


                catch (error) {

                    console.error(error);

                    createErrors.textContent =
                        'Network problem. Check your internet or server, then try again.';

                    createErrors.hidden = false;

                }


                finally {

                    createButton.disabled = false;

                    createButton.textContent =
                        'Save Booking';

                    createLoading.hidden = true;

                }

            }
        );


        /* =====================================================
           ADD NEW BOOKING TO PAGE
        ====================================================== */

        function addBookingToPage(booking) {

            /* Remove "No bookings found" */

            const emptyMessage =
                document.querySelector(
                    '#no-bookings'
                );

            if (emptyMessage) {

                emptyMessage.remove();

            }


            /* Create booking item */

            const item =
                document.createElement('li');

            item.id =
                `schedule-${booking.id}`;

            item.className =
                'booking';


            item.innerHTML = `

                <strong class="customer-name">
                    ${escapeHtml(
                        booking.customer_name || ''
                    )}
                </strong>

                <br>

                Phone:

                <span class="phone">
                    ${escapeHtml(
                        booking.phone || ''
                    )}
                </span>

                <br>

                Service:

                <span class="service-type">
                    ${escapeHtml(
                        booking.service_type || ''
                    )}
                </span>

                <br>

                Date:

                <span class="schedule-date">
                    ${escapeHtml(
                        booking.schedule_date || ''
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


            scheduleList.appendChild(item);


            /* Add Edit button listener */

            const editButton =
                item.querySelector(
                    '.edit-button'
                );


            updateEditButtonData(
                editButton,
                booking
            );


            editButton.addEventListener(
                'click',
                () => {

                    showUpdateForm(
                        booking
                    );

                }
            );

        }


        /* =====================================================
           EDIT EXISTING BOOKINGS
        ====================================================== */

        /*
         * This replaces the separate document click listener
         * from the supplied code.
         *
         * It gives each existing Edit button one listener.
         */

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


        /* =====================================================
           SHOW UPDATE FORM
        ====================================================== */

        function showUpdateForm(booking) {

            document.querySelector(
                '#edit-id'
            ).value =
                booking.id;


            document.querySelector(
                '#edit-customer-name'
            ).value =
                booking.customer_name || '';


            document.querySelector(
                '#edit-phone'
            ).value =
                booking.phone || '';


            document.querySelector(
                '#edit-service-type'
            ).value =
                booking.service_type || '';


            document.querySelector(
                '#edit-schedule-date'
            ).value =
                formatDateForInput(
                    booking.schedule_date
                );


            document.querySelector(
                '#edit-notes'
            ).value =
                booking.notes || '';


            /* Clear previous messages */

            updateErrors.innerHTML = '';
            updateErrors.hidden = true;

            updateSuccess.textContent = '';
            updateSuccess.hidden = true;


            /* Show form */

            updateForm.hidden = false;


            /* Scroll to form */

            updateForm.scrollIntoView({
                behavior: 'smooth'
            });

        }


        /* =====================================================
           UPDATE BOOKING
           PUT /schedules/{id}
        ====================================================== */

        updateForm.addEventListener(
            'submit',
            async (event) => {

                event.preventDefault();


                /* Clear previous messages */

                updateErrors.innerHTML = '';
                updateErrors.hidden = true;

                updateSuccess.textContent = '';
                updateSuccess.hidden = true;


                /* Loading state */

                updateButton.disabled = true;
                updateButton.textContent =
                    'Updating...';

                updateLoading.hidden = false;


                /* Get booking ID */

                const id =
                    document.querySelector(
                        '#edit-id'
                    ).value;


                /* Get updated values */

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

                    /* Send PUT request */

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


                    /* Validation errors */

                    if (response.status === 422) {

                        displayErrors(
                            updateErrors,
                            result.errors
                        );

                        return;
                    }


                    /* Other server errors */

                    if (!response.ok) {

                        updateErrors.textContent =
                            result.message ||
                            'Sorry, the booking could not be updated.';

                        updateErrors.hidden = false;

                        return;
                    }


                    /* Successful update */

                    updateSuccess.textContent =
                        result.message ||
                        'Booking updated successfully!';

                    updateSuccess.hidden = false;


                    /* Update booking on page */

                    if (result.data) {

                        updateBookingOnPage(
                            result.data
                        );

                    }


                    /* Hide update form */

                    updateForm.hidden = true;

                }


                catch (error) {

                    console.error(error);

                    updateErrors.textContent =
                        'Network problem. Please try again.';

                    updateErrors.hidden = false;

                }


                finally {

                    updateButton.disabled = false;

                    updateButton.textContent =
                        'Update Booking';

                    updateLoading.hidden = true;

                }

            }
        );


        /* =====================================================
           UPDATE BOOKING ON PAGE
        ====================================================== */

        function updateBookingOnPage(booking) {

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


            /* Update Edit button */

            const editButton =
                item.querySelector(
                    '.edit-button'
                );


            updateEditButtonData(
                editButton,
                booking
            );

        }


        /* =====================================================
           UPDATE EDIT BUTTON DATA
        ====================================================== */

        function updateEditButtonData(
            button,
            booking
        ) {

            if (!button) {

                return;

            }


            button.dataset.id =
                booking.id;

            button.dataset.customerName =
                booking.customer_name || '';

            button.dataset.phone =
                booking.phone || '';

            button.dataset.serviceType =
                booking.service_type || '';

            button.dataset.scheduleDate =
                formatDateForInput(
                    booking.schedule_date
                );

            button.dataset.notes =
                booking.notes || '';

        }


        /* =====================================================
           CANCEL UPDATE
        ====================================================== */

        cancelUpdateButton.addEventListener(
            'click',
            () => {

                updateForm.hidden = true;

                updateErrors.innerHTML = '';
                updateErrors.hidden = true;

                updateSuccess.textContent = '';
                updateSuccess.hidden = true;

            }
        );


        /* =====================================================
           DISPLAY VALIDATION ERRORS
        ====================================================== */

        function displayErrors(
            container,
            errors
        ) {

            container.innerHTML = '';


            if (!errors) {

                container.textContent =
                    'Please check your information.';

                container.hidden = false;

                return;

            }


            Object.values(errors)
                .forEach(
                    (messages) => {

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

                    }
                );


            container.hidden = false;

        }


        /* =====================================================
           FORMAT DATE
        ====================================================== */

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


        /* =====================================================
           ESCAPE HTML
        ====================================================== */

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
