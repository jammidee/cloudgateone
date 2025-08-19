<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <h2 class="mt-4 mb-3">2025 Holiday Calendar</h2>
    <div id="calendar"></div>
</div>

<!-- Bootstrap CSS & JS -->
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> -->

<!-- FullCalendar CSS & JS -->
<!-- <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet"> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script> -->

<!-- Add/Edit Holiday Modal -->
<div class="modal fade" id="holidayFormModal" tabindex="-1" aria-labelledby="holidayFormLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="holidayForm">
        <div class="modal-header">
          <h5 class="modal-title" id="holidayFormLabel">Add / Edit Holiday</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="holidayEventId">
            <div class="mb-3">
                <label class="form-label">Holiday Name</label>
                <input type="text" id="holidayTitle" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Date</label>
                <input type="date" id="holidayDateInput" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea id="holidayDescription" class="form-control"></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" id="deleteHolidayBtn" style="display:none;">Delete</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    let events = [
        { id: "1",  title: "New Year's Day", date: "2025-01-01", description: "Celebration of the start of the new year." },
        { id: "2",  title: "Valentine's Day", date: "2025-02-14", description: "A day to celebrate love and affection." },
        { id: "3",  title: "St. Patrick's Day", date: "2025-03-17", description: "Irish cultural celebration." },
        { id: "4",  title: "Maundy Thursday", date: "2025-04-17", description: "Christian observance before Good Friday." },
        { id: "5",  title: "Good Friday", date: "2025-04-18", description: "Christian commemoration of the crucifixion of Jesus Christ." },
        { id: "6",  title: "Easter Sunday", date: "2025-04-20", description: "Christian celebration of the resurrection of Jesus Christ." },
        { id: "7",  title: "Labor Day (PH)", date: "2025-05-01", description: "Honors workers in the Philippines." },
        { id: "8",  title: "Philippine Independence Day", date: "2025-06-12", description: "Marks independence from Spain in 1898." },
        { id: "9",  title: "US Independence Day", date: "2025-07-04", description: "Marks the US Declaration of Independence in 1776." },
        { id: "10", title: "National Heroes Day (PH)", date: "2025-08-25", description: "Honors national heroes of the Philippines." },
        { id: "11", title: "All Saints' Day", date: "2025-11-01", description: "Christian festival honoring all saints." },
        { id: "12", title: "All Souls' Day", date: "2025-11-02", description: "Christian day to remember all the faithful departed." },
        { id: "13", title: "Christmas Eve", date: "2025-12-24", description: "Evening before Christmas Day." },
        { id: "14", title: "Christmas Day", date: "2025-12-25", description: "Christian celebration of the birth of Jesus Christ." },
        { id: "15", title: "Rizal Day", date: "2025-12-30", description: "Commemorates the execution of Dr. José Rizal in 1896." },
        { id: "16", title: "New Year's Eve", date: "2025-12-31", description: "Celebration of the final day of the year." }
    ];

    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        initialDate: '2025-01-01',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,listMonth'
        },
        events: events,
        eventColor: '#ff4d4d',
        selectable: true,
        editable: true, // ✅ enables drag & drop
        dateClick: function(info) {
            // Add mode
            document.getElementById("holidayFormLabel").textContent = "Add Holiday";
            document.getElementById("holidayEventId").value = "";
            document.getElementById("holidayTitle").value = "";
            document.getElementById("holidayDateInput").value = info.dateStr;
            document.getElementById("holidayDescription").value = "";
            document.getElementById("deleteHolidayBtn").style.display = "none";
            new bootstrap.Modal(document.getElementById('holidayFormModal')).show();
        },
        eventClick: function(info) {
            // Edit mode
            document.getElementById("holidayFormLabel").textContent = "Edit Holiday";
            document.getElementById("holidayEventId").value = info.event.id;
            document.getElementById("holidayTitle").value = info.event.title;
            document.getElementById("holidayDateInput").value = info.event.startStr;
            document.getElementById("holidayDescription").value = info.event.extendedProps.description || "";
            document.getElementById("deleteHolidayBtn").style.display = "inline-block";
            new bootstrap.Modal(document.getElementById('holidayFormModal')).show();
        },
        eventDrop: function(info) {
            // When an event is dragged to a new date
            const event = calendar.getEventById(info.event.id);
            if (event) {
                // update in-memory data
                const evIndex = events.findIndex(e => e.id === event.id);
                if (evIndex > -1) {
                    events[evIndex].date = info.event.startStr;
                }
            }
            console.log(`"${info.event.title}" moved to ${info.event.startStr}`);
            // Optionally: send AJAX to backend to update database here
        }
    });

    calendar.render();

    // Save holiday (add/edit)
    document.getElementById("holidayForm").addEventListener("submit", function(e) {
        e.preventDefault();
        const id = document.getElementById("holidayEventId").value;
        const title = document.getElementById("holidayTitle").value;
        const date = document.getElementById("holidayDateInput").value;
        const description = document.getElementById("holidayDescription").value;

        if (id) {
            // Update existing
            const event = calendar.getEventById(id);
            if (event) {
                event.setProp("title", title);
                event.setStart(date);
                event.setExtendedProp("description", description);

                // Update in-memory
                const evIndex = events.findIndex(e => e.id === id);
                if (evIndex > -1) {
                    events[evIndex] = { id, title, date, description };
                }
            }
        } else {
            // Add new
            const newId = String(Date.now());
            calendar.addEvent({
                id: newId,
                title: title,
                start: date,
                description: description,
                color: '#ff4d4d'
            });
            events.push({ id: newId, title, date, description });
        }

        bootstrap.Modal.getInstance(document.getElementById('holidayFormModal')).hide();
    });

    // Delete holiday
    document.getElementById("deleteHolidayBtn").addEventListener("click", function() {
        const id = document.getElementById("holidayEventId").value;
        if (id && confirm("Delete this holiday?")) {
            const event = calendar.getEventById(id);
            if (event) {
                event.remove();
                events = events.filter(e => e.id !== id);
            }
            bootstrap.Modal.getInstance(document.getElementById('holidayFormModal')).hide();
        }
    });

});
</script>
