function showMessage(type, message) {
    const globalFeedback = document.querySelector("#global-feedback");

    globalFeedback.textContent = message;
    globalFeedback.className = type;
}

const scheduleList = document.querySelector("#schedule-list");
const listLoading = document.querySelector("#list-loading");
const retryLoad = document.querySelector("#retry-load");

async function loadBookings() {
    // Show loading message
    listLoading.hidden = false;

    // Hide retry button while loading
    retryLoad.hidden = true;

    try {
        const response = await fetch("/schedules", {
            method: "GET",
            headers: {
                "Accept": "application/json"
            }
        });

        try {
    const response = await fetch("/schedules", options);

    if (!response.ok) {
        throw new Error("Request failed");
    }
} catch (error) {
    showMessage(
        "error",
        "Something went wrong. Check your connection and try again."
    );
}

        // Check if request failed
        if (!response.ok) {
            throw new Error("Could not load bookings.");
        }

        const result = await response.json();

        // Clear old bookings
        scheduleList.innerHTML = "";

        // Display bookings
        result.forEach((schedule) => {
            const booking = document.createElement("div");

            booking.innerHTML = `
                <p>
                    <strong>Customer:</strong>
                    ${schedule.customer_name}
                </p>

                <p>
                    <strong>Phone:</strong>
                    ${schedule.phone}
                </p>

                <p>
                    <strong>Service:</strong>
                    ${schedule.service_type}
                </p>

                <p>
                    <strong>Date:</strong>
                    ${schedule.schedule_date}
                </p>

                <p>
                    <strong>Notes:</strong>
                    ${schedule.notes ?? ""}
                </p>

                <hr>
            `;

            scheduleList.appendChild(booking);
        });

        // Hide loading message
        listLoading.hidden = true;

    } catch (error) {
        console.error(error);

        // Hide loading message
        listLoading.hidden = true;

        // Show retry button
        retryLoad.hidden = false;

        // Show friendly error
        showMessage(
            "error",
            "We could not load bookings. Check your connection and try again."
        );
    }
}

// Try loading again when button is clicked
retryLoad.addEventListener("click", () => {
    loadBookings();
});

// Load bookings when page opens
loadBookings();
