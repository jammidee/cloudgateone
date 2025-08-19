<style>
  /* Ensure the calendar fits container */
  #calendar {
    max-width: 100%;
    overflow-x: auto;
  }

  /* Make toolbar responsive on small screens */
  .fc .fc-toolbar.fc-header-toolbar {
    flex-wrap: wrap;
    gap: 5px;
  }

  /* Default font sizes */
  .fc {
    font-size: 1rem; /* sets base font size for calendar */
  }
  .fc .fc-col-header-cell-cushion,
  .fc .fc-toolbar-title {
    font-size: 1.1rem;
  }
  .fc .fc-event-title {
    font-size: 0.95rem;
  }

  /* Responsive tweaks for mobile */
  @media (max-width: 768px) {
    .fc {
      font-size: 0.9rem; /* shrink overall text */
    }
    .fc .fc-col-header-cell-cushion,
    .fc .fc-toolbar-title {
      font-size: 1rem;
    }
    .fc .fc-event-title {
      font-size: 0.85rem;
    }
  }
</style>
<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <!-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><!= $title; ?></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/user/all">Users</a></li>
            <li class="breadcrumb-item active" aria-current="page">User</li>
        </ol>
    </div> -->

    <div class="col-lg-12">
        <div class="card mb-4">

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

                <div class="d-flex align-items-center">

                    <i class="fas fa-users text-primary mr-2"></i>
                    <h6 class="m-0 font-weight-bold text-primary mr-3">Calendar</h6>

                </div>

                <!-- Add Button -->
                <?php if (canAccessMenu('calendar_create', $this->session->userdata('user_role'))): ?>
                    <a href="<?= base_url('user/add'); ?>" class="btn btn-sm btn-primary" id="btnAddUser">
                        <i class="fas fa-plus mr-1"></i> Add Event
                    </a>
                <?php endif; ?>


            </div>

            <div class="table-responsive p-3">
                <h2 class="mt-4 mb-3">2025 Holiday Calendar</h2>
                <div id="calendar"></div>
            </div>


        </div>
    </div>


</div>
<!---Container Fluid-->

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

<style>
/* ✅ Ensure calendar fits container */
#calendar {
  max-width: 100%;
  overflow-x: auto; /* prevent overflow issues */
}

/* ✅ Make toolbar responsive on small screens */
.fc .fc-toolbar.fc-header-toolbar {
  flex-wrap: wrap;
  gap: 5px;
}
</style>

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
        // ✅ Switch view depending on screen size
        initialView: window.innerWidth < 768 ? 'listMonth' : 'dayGridMonth',
        initialDate: '2025-01-01',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: window.innerWidth < 768 ? '' : 'dayGridMonth,listMonth' // hide toggle on mobile
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

    // 🔄 Re-render on resize for responsiveness
    window.addEventListener('resize', function () {
        if (window.innerWidth < 768 && calendar.view.type !== 'listMonth') {
            calendar.changeView('listMonth');
        } else if (window.innerWidth >= 768 && calendar.view.type !== 'dayGridMonth') {
            calendar.changeView('dayGridMonth');
        }
    });

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
