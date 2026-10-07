<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Aircon Cleaning and Repair Service Schedule
    </title>

    <!-- Laravel CSRF Token -->
    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background: #f5f5f5;
            color: #222;
        }

        h1 {
            margin-bottom: 10px;
        }

        h2 {
            margin-top: 25px;
        }

        form {
            max-width: 500px;
            margin-bottom: 30px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }

        label {
            display: block;
            margin-top: 10px;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            margin-top: 15px;
            padding: 10px 15px;
            cursor: pointer;
            border: none;
            border-radius: 4px;
            background: #198754;
            color: white;
        }

        button:hover {
            background: #157347;
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
            border-radius: 4px;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            margin-top: 10px;
            border-radius: 4px;
        }

        #global-feedback {
            padding: 10px;
            margin: 15px 0;
            border-radius: 4px;
        }

        .booking {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 10px;
            background: white;
            border-radius: 8px;
            max-width: 600px;
        }

        #schedule-list {
            padding-left: 0;
            list-style: none;
        }

        #list-loading {
            font-style: italic;
            color: #666;
        }

        .edit-button {
            background: #0d6efd;
        }

        .edit-button:hover {
            background: #0b5ed7;
        }

        .delete-button {
            background: #dc3545;
        }

        .delete-button:hover {
            background: #bb2d3b;
        }

        #cancel-update-button {
            background: #6c757d;
        }

        #cancel-update-button:hover {
            background: #5c636a;
        }

        #retry-load {
            background: #dc3545;
        }

        #retry-load:hover {
            background: #bb2d3b;
        }

        .field-error {
            color: #721c24;
            margin-top: 5px;
        }

        hr {
            margin: 30px 0;
            border: 0;
            border-top: 1px solid #ddd;
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
         GLOBAL FEEDBACK
    ====================================================== -->

    <div
        id="global-feedback"
        role="alert"
    ></div>


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

        <p
            id="customer-name-error"
            class="field-error"
        ></p>


        <label for="phone">
            Phone Number
        </label>

        <input
            id="phone"
            name="phone"
            type="text"
            required
        >

        <p
            id="phone-error"
            class="field-error"
        ></p>


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

        <p
            id="service-type-error"
            class="field-error"
        ></p>


        <label for="schedule_date">
            Preferred Date and Time
        </label>

        <input
            id="schedule_date"
            name="schedule_date"
            type="datetime-local"
            required
        >

        <p
            id="schedule-date-error"
            class="field-error"
        ></p>


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


        <p
            id="create-loading"
            hidden
        >
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
            type="text"
            required
        >


        <label for="edit-phone">
            Phone Number
        </label>

        <input
            id="edit-phone"
            type="text"
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

        <p
            id="edit-schedule-date-error"
            class="field-error"
        ></p>


        <label for="edit-notes">
            Notes
        </label>

        <textarea
            id="edit-notes"
            rows="4"
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
         BOOKING LIST
    ====================================================== -->

    <h2>
        Aircon Service Bookings
    </h2>


    <p id="list-loading" hidden>
        Loading aircon service bookings...
    </p>


    <p
        id="list-error"
        class="error"
        hidden
    ></p>


    <button
        id="retry-load"
        type="button"
        hidden
    >
        Try Again
    </button>


    <!-- =====================================================
         BOOKING LIST
    ====================================================== -->

    <div id="schedule-list">

        @forelse ($schedules as $schedule)

            <div
                id="schedule-{{ $schedule->id }}"
                class="booking"
            >

                <p>
                    <strong>Customer:</strong>

                    <span class="customer-name">
                        {{ $schedule->customer_name }}
                    </span>
                </p>


                <p>
                    <strong>Phone:</strong>

                    <span class="phone">
                        {{ $schedule->phone }}
                    </span>
                </p>


                <p>
                    <strong>Service:</strong>

                    <span class="service-type">
                        {{ $schedule->service_type }}
                    </span>
                </p>


                <p>
                    <strong>Date:</strong>

                    <span class="schedule-date">
                        {{ $schedule->schedule_date }}
                    </span>
                </p>


                <p>
                    <strong>Notes:</strong>

                    <span class="notes">
                        {{ $schedule->notes }}
                    </span>
                </p>


                <!-- EDIT -->

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


                <!-- DELETE -->

                <button
                    type="button"
                    class="delete-button"
                    data-id="{{ $schedule->id }}"
                >
                    Delete Booking
                </button>

            </div>

        @empty

            <p id="no-bookings">
                No bookings found.
            </p>

        @endforelse

    </div>


    <!-- =====================================================
         JAVASCRIPT
    ====================================================== -->

    <script>

        /* =====================================================
           1. CSRF TOKEN
        ====================================================== */

        const csrfTokenElement =
            document.querySelector(
                'meta[name="csrf-token"]'
            );

        const csrfToken =
            csrfTokenElement
                ? csrfTokenElement.getAttribute('content')
                : '';


        /* =====================================================
           2. GLOBAL FEEDBACK
        ====================================================== */

        const globalFeedback =
            document.querySelector(
                '#global-feedback'
            );


        function showGlobalFeedback(
            message,
            type = 'success'
        ) {

            if (!globalFeedback) {
                return;
            }

            globalFeedback.textContent =
                message;

            globalFeedback.className =
                type === 'error'
                    ? 'error'
                    : 'success';
        }


        /* =====================================================
           3. ELEMENTS
        ====================================================== */

        const createForm =
            document.querySelector(
                '#create-schedule-form'
            );

        const createButton =
            document.querySelector(
                '#create-button'
            );

        const createLoading =
            document.querySelector(
                '#create-loading'
            );

        const createSuccess =
            document.querySelector(
                '#create-success'
            );

        const createErrors =
            document.querySelector(
                '#create-errors'
            );


        const scheduleList =
            document.querySelector(
                '#schedule-list'
            );


        const listLoading =
            document.querySelector(
                '#list-loading'
            );

        const listError =
            document.querySelector(
                '#list-error'
            );

        const retryLoad =
            document.querySelector(
                '#retry-load'
            );


        const updateForm =
            document.querySelector(
                '#update-schedule-form'
            );

        const updateButton =
            document.querySelector(
                '#update-button'
            );

        const updateLoading =
            document.querySelector(
                '#update-loading'
            );

        const updateSuccess =
            document.querySelector(
                '#update-success'
            );

        const updateErrors =
            document.querySelector(
                '#update-errors'
            );

        const cancelUpdateButton =
            document.querySelector(
                '#cancel-update-button'
            );


        /* =====================================================
           4. CREATE BOOKING
           POST /schedules
        ====================================================== */

        createForm.addEventListener(
            'submit',
            async (event) => {

                event.preventDefault();


                createErrors.innerHTML = '';
                createErrors.hidden = true;

                createSuccess.textContent = '';
                createSuccess.hidden = true;


                clearFieldErrors();


                createButton.disabled = true;

                createButton.textContent =
                    'Saving...';

                createLoading.hidden = false;


                try {

                    const formData =
                        new FormData(createForm);


                    const data = {

                        customer_name:
                            formData.get(
                                'customer_name'
                            ),

                        phone:
                            formData.get(
                                'phone'
                            ),

                        service_type:
                            formData.get(
                                'service_type'
                            ),

                        schedule_date:
                            formData.get(
                                'schedule_date'
                            ),

                        notes:
                            formData.get(
                                'notes'
                            )

                    };


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
                        await getResponseData(
                            response
                        );


                    /* Validation */

                    if (
                        response.status === 422
                    ) {

                        displayErrors(
                            createErrors,
                            result.errors
                        );

                        showGlobalFeedback(
                            'Please correct the errors.',
                            'error'
                        );

                        return;
                    }


                    /* Server error */

                    if (!response.ok) {

                        createErrors.textContent =
                            result.message ||
                            'Unable to save booking.';

                        createErrors.hidden =
                            false;

                        return;
                    }


                    /* Success */

                    createSuccess.textContent =
                        result.message ||
                        'Booking saved successfully!';

                    createSuccess.hidden =
                        false;


                    showGlobalFeedback(
                        'Booking saved successfully!'
                    );


                    /* Reset form */

                    createForm.reset();


                    /*
                     * If Laravel returned the
                     * newly created booking,
                     * add it immediately.
                     */

                    if (result.data) {

                        addBookingToPage(
                            result.data
                        );

                    } else {

                        /*
                         * Otherwise reload the page
                         * so the new booking appears.
                         */

                        setTimeout(
                            () => {
                                window.location.reload();
                            },
                            500
                        );

                    }


                } catch (error) {

                    console.error(
                        'Create error:',
                        error
                    );


                    createErrors.textContent =
                        'Something went wrong. Check your connection and try again.';

                    createErrors.hidden =
                        false;


                    showGlobalFeedback(
                        'Could not save booking.',
                        'error'
                    );


                } finally {

                    createButton.disabled =
                        false;

                    createButton.textContent =
                        'Save Booking';

                    createLoading.hidden =
                        true;

                }

            }
        );


        /* =====================================================
           5. ADD BOOKING TO PAGE
        ====================================================== */

        function addBookingToPage(
            booking
        ) {

            const emptyMessage =
                document.querySelector(
                    '#no-bookings'
                );


            if (emptyMessage) {
                emptyMessage.remove();
            }


            const item =
                document.createElement(
                    'div'
                );


            item.id =
                `schedule-${booking.id}`;

            item.className =
                'booking';


            item.innerHTML = `

                <p>
                    <strong>Customer:</strong>

                    <span class="customer-name"></span>
                </p>

                <p>
                    <strong>Phone:</strong>

                    <span class="phone"></span>
                </p>

                <p>
                    <strong>Service:</strong>

                    <span class="service-type"></span>
                </p>

                <p>
                    <strong>Date:</strong>

                    <span class="schedule-date"></span>
                </p>

                <p>
                    <strong>Notes:</strong>

                    <span class="notes"></span>
                </p>

                <button
                    type="button"
                    class="edit-button"
                >
                    Edit
                </button>

                <button
                    type="button"
                    class="delete-button"
                >
                    Delete Booking
                </button>

            `;


            /*
             * Put values into the page
             */

            item.querySelector(
                '.customer-name'
            ).textContent =
                booking.customer_name || '';


            item.querySelector(
                '.phone'
            ).textContent =
                booking.phone || '';


            item.querySelector(
                '.service-type'
            ).textContent =
                booking.service_type || '';


            item.querySelector(
                '.schedule-date'
            ).textContent =
                booking.schedule_date || '';


            item.querySelector(
                '.notes'
            ).textContent =
                booking.notes || '';


            scheduleList.appendChild(
                item
            );


            /*
             * Edit button
             */

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


            /*
             * Delete button
             */

            const deleteButton =
                item.querySelector(
                    '.delete-button'
                );


            deleteButton.dataset.id =
                booking.id;


            deleteButton.addEventListener(
                'click',
                () => {

                    deleteBooking(
                        booking.id,
                        deleteButton
                    );

                }
            );

        }


        /* =====================================================
           6. EDIT EXISTING BOOKINGS
        ====================================================== */

        document
            .querySelectorAll(
                '.edit-button'
            )
            .forEach(
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
           7. DELETE EXISTING BOOKINGS
        ====================================================== */

        document
            .querySelectorAll(
                '.delete-button'
            )
            .forEach(
                (button) => {

                    button.addEventListener(
                        'click',
                        () => {

                            deleteBooking(
                                button.dataset.id,
                                button
                            );

                        }
                    );

                }
            );


        /* =====================================================
           8. SHOW UPDATE FORM
        ====================================================== */

        function showUpdateForm(
            booking
        ) {

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


            updateErrors.innerHTML = '';

            updateErrors.hidden =
                true;


            updateSuccess.textContent = '';

            updateSuccess.hidden =
                true;


            updateForm.hidden =
                false;


            updateForm.scrollIntoView({
                behavior: 'smooth'
            });

        }


        /* =====================================================
           9. UPDATE BOOKING
           PUT /schedules/{id}
        ====================================================== */

        updateForm.addEventListener(
            'submit',
            async (event) => {

                event.preventDefault();


                updateErrors.innerHTML = '';

                updateErrors.hidden =
                    true;


                updateSuccess.textContent = '';

                updateSuccess.hidden =
                    true;


                updateButton.disabled =
                    true;

                updateButton.textContent =
                    'Updating...';

                updateLoading.hidden =
                    false;


                const id =
                    document.querySelector(
                        '#edit-id'
                    ).value;


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
                        await getResponseData(
                            response
                        );


                    if (
                        response.status === 422
                    ) {

                        displayErrors(
                            updateErrors,
                            result.errors
                        );

                        showGlobalFeedback(
                            'Please correct the errors.',
                            'error'
                        );

                        return;
                    }


                    if (!response.ok) {

                        updateErrors.textContent =
                            result.message ||
                            'Unable to update booking.';

                        updateErrors.hidden =
                            false;

                        return;
                    }


                    updateSuccess.textContent =
                        result.message ||
                        'Booking updated successfully!';

                    updateSuccess.hidden =
                        false;


                    showGlobalFeedback(
                        'Booking updated successfully!'
                    );


                    /*
                     * Update page without reload
                     */

                    if (result.data) {

                        updateBookingOnPage(
                            result.data
                        );

                    } else {

                        /*
                         * If Laravel does not return
                         * the updated booking, reload.
                         */

                        window.location.reload();

                    }


                    updateForm.hidden =
                        true;


                } catch (error) {

                    console.error(
                        'Update error:',
                        error
                    );


                    updateErrors.textContent =
                        'Something went wrong. Check your connection and try again.';

                    updateErrors.hidden =
                        false;


                    showGlobalFeedback(
                        'Could not update booking.',
                        'error'
                    );


                } finally {

                    updateButton.disabled =
                        false;

                    updateButton.textContent =
                        'Update Booking';

                    updateLoading.hidden =
                        true;

                }

            }
        );


        /* =====================================================
           10. UPDATE BOOKING ON PAGE
        ====================================================== */

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
                booking.customer_name || '';


            item.querySelector(
                '.phone'
            ).textContent =
                booking.phone || '';


            item.querySelector(
                '.service-type'
            ).textContent =
                booking.service_type || '';


            item.querySelector(
                '.schedule-date'
            ).textContent =
                booking.schedule_date || '';


            item.querySelector(
                '.notes'
            ).textContent =
                booking.notes || '';


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
           11. UPDATE EDIT BUTTON DATA
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
           12. DELETE BOOKING
           DELETE /schedules/{id}
        ====================================================== */

        async function deleteBooking(
            id,
            deleteButton
        ) {

            /*
             * Ask for confirmation
             */

            const confirmed =
                confirm(
                    'Delete this booking?\n\nThis cannot be undone.'
                );


            if (!confirmed) {
                return;
            }


            /*
             * Disable button
             */

            deleteButton.disabled =
                true;

            deleteButton.textContent =
                'Deleting...';


            try {

                const response =
                    await fetch(
                        `/schedules/${id}`,
                        {

                            method: 'DELETE',

                            headers: {

                                'Accept':
                                    'application/json',

                                'X-CSRF-TOKEN':
                                    csrfToken

                            }

                        }
                    );


                const result =
                    await getResponseData(
                        response
                    );


                if (!response.ok) {

                    throw new Error(
                        result.message ||
                        'Could not delete booking.'
                    );

                }


                /*
                 * Remove booking from page
                 */

                const booking =
                    document.querySelector(
                        `#schedule-${id}`
                    );


                if (booking) {
                    booking.remove();
                }


                /*
                 * Show empty message
                 */

                if (
                    scheduleList.querySelector(
                        '.booking'
                    ) === null
                ) {

                    scheduleList.innerHTML = `

                        <p id="no-bookings">
                            No bookings found.
                        </p>

                    `;

                }


                showGlobalFeedback(
                    result.message ||
                    'Booking deleted successfully!'
                );


            } catch (error) {

                console.error(
                    'Delete error:',
                    error
                );


                showGlobalFeedback(
                    'We could not delete this booking. Please try again.',
                    'error'
                );


                /*
                 * Enable button again
                 */

                deleteButton.disabled =
                    false;

                deleteButton.textContent =
                    'Delete Booking';

            }

        }


        /* =====================================================
           13. CANCEL UPDATE
        ====================================================== */

        cancelUpdateButton.addEventListener(
            'click',
            () => {

                updateForm.hidden =
                    true;

                updateErrors.innerHTML = '';

                updateErrors.hidden =
                    true;

                updateSuccess.textContent = '';

                updateSuccess.hidden =
                    true;

            }
        );


        /* =====================================================
           14. RETRY BUTTON
        ====================================================== */

        retryLoad.addEventListener(
            'click',
            () => {

                /*
                 * Since the page is server-rendered,
                 * simply reload the page.
                 */

                window.location.reload();

            }
        );


        /* =====================================================
           15. DISPLAY VALIDATION ERRORS
        ====================================================== */

        function displayErrors(
            container,
            errors
        ) {

            container.innerHTML = '';


            if (!errors) {

                container.textContent =
                    'Please check your information.';

                container.hidden =
                    false;

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


            container.hidden =
                false;

        }


        /* =====================================================
           16. CLEAR FIELD ERRORS
        ====================================================== */

        function clearFieldErrors() {

            const errors = [

                '#customer-name-error',
                '#phone-error',
                '#service-type-error',
                '#schedule-date-error',
                '#edit-schedule-date-error'

            ];


            errors.forEach(
                (selector) => {

                    const element =
                        document.querySelector(
                            selector
                        );


                    if (element) {

                        element.textContent =
                            '';

                    }

                }
            );

        }


        /* =====================================================
           17. GET RESPONSE DATA
        ====================================================== */

        async function getResponseData(
            response
        ) {

            try {

                return await response.json();

            } catch (error) {

                return {};

            }

        }


        /* =====================================================
           18. FORMAT DATE FOR DATETIME-LOCAL
        ====================================================== */

        function formatDateForInput(
            date
        ) {

            if (!date) {
                return '';
            }


            /*
             * Already formatted:
             * 2026-10-05T14:30
             */

            if (
                /^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}/
                    .test(date)
            ) {

                return date.substring(
                    0,
                    16
                );

            }


            const parsed =
                new Date(date);


            if (
                isNaN(
                    parsed.getTime()
                )
            ) {

                return '';

            }


            const year =
                parsed.getFullYear();


            const month =
                String(
                    parsed.getMonth() + 1
                ).padStart(
                    2,
                    '0'
                );


            const day =
                String(
                    parsed.getDate()
                ).padStart(
                    2,
                    '0'
                );


            const hours =
                String(
                    parsed.getHours()
                ).padStart(
                    2,
                    '0'
                );


            const minutes =
                String(
                    parsed.getMinutes()
                ).padStart(
                    2,
                    '0'
                );


            return `${year}-${month}-${day}T${hours}:${minutes}`;

        }


        /* =====================================================
           19. PAGE LOAD
        ====================================================== */

        window.addEventListener(
            'load',
            () => {

                if (listLoading) {

                    listLoading.hidden =
                        true;

                }

            }
        );

    </script>


</body>

</html>