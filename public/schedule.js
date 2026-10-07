function showMessage(type, message) {
    const globalFeedback = document.querySelector("#global-feedback");

    if (!globalFeedback) return;

    globalFeedback.textContent = message;
    globalFeedback.className = type;
}

const scheduleList = document.querySelector("#schedule-list");
const listLoading = document.querySelector("#list-loading");
const retryLoad = document.querySelector("#retry-load");

async function loadBookings() {
    if (!scheduleList || !listLoading || !retryLoad) return;

    listLoading.hidden = false;
    retryLoad.hidden = true;

    try {
        const response = await fetch("/schedules", {
            method: "GET",
            headers: {
                Accept: "application/json"
            }
        });

        if (!response.ok) {
            throw new Error("Could not load bookings.");
        }

        const result = await response.json();
        const schedules = Array.isArray(result.data) ? result.data : Array.isArray(result) ? result : [];

        scheduleList.innerHTML = "";

        if (!schedules.length) {
            scheduleList.innerHTML = "<p>No bookings found.</p>";
            listLoading.hidden = true;
            return;
        }

        schedules.forEach((schedule) => {
            const booking = document.createElement("div");

            booking.innerHTML = `
                <p>
                    <strong>Customer:</strong>
                    ${schedule.customer_name ?? schedule.customerName ?? "Unknown customer"}
                </p>

                <p>
                    <strong>Phone:</strong>
                    ${schedule.phone ?? "Not provided"}
                </p>

                <p>
                    <strong>Service:</strong>
                    ${schedule.service_type ?? schedule.service ?? "General Service"}
                </p>

                <p>
                    <strong>Date:</strong>
                    ${schedule.schedule_date ?? schedule.date ?? "Not scheduled"}
                </p>

                <p>
                    <strong>Notes:</strong>
                    ${schedule.notes ?? ""}
                </p>

                <hr>
            `;

            scheduleList.appendChild(booking);
        });

        listLoading.hidden = true;
    } catch (error) {
        console.error(error);

        listLoading.hidden = true;
        retryLoad.hidden = false;
        showMessage(
            "error",
            "We could not load bookings. Check your connection and try again."
        );
    }
}

if (retryLoad) {
    retryLoad.addEventListener("click", () => {
        loadBookings();
    });
}

if (scheduleList) {
    loadBookings();
}
