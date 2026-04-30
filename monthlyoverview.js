const monthSelect = document.getElementById('month-select');
const calendarContainer = document.getElementById('calendar-container');

const daysInMonth = {
    1: 31, 2: 28, 3: 31, 4: 30, 5: 31, 6: 30, 7: 31, 8: 31, 9: 30, 10: 31, 11: 30, 12: 31
};

// Function to populate the calendar based on the selected month
function generateCalendar(month) {
    // Clear any previous days
    calendarContainer.innerHTML = '';
    // Determine the number of days in the selected month
    let numDays = daysInMonth[month];
    
    // Add days to the container
    for (let i = 1; i <= numDays; i++) {
        const dayElement = document.createElement('div');
        dayElement.classList.add('day');
        dayElement.id = `day-${i}`;
        dayElement.innerHTML = ` 
            <svg class="progress-ring" width="100" height="100">
                <circle class="bg" cx="50" cy="50" r="45"></circle>
                <circle class="fg" cx="50" cy="50" r="45" stroke-dasharray="282.74" stroke-dashoffset="282.74"></circle>
            </svg>
            <div class="day-text">
                <span>${i}</span><br><small>70%</small>
            </div>
        `;
        calendarContainer.appendChild(dayElement);
        setProgress(`day-${i}`, 70); // Set progress (for demo purposes)
    }
}

// Function to set the progress for each day
function setProgress(dayId, percentage) {
    const circle = document.querySelector(`#${dayId} .fg`);
    const radius = circle.r.baseVal.value;
    const circumference = 2 * Math.PI * radius;
    const offset = circumference - (percentage / 100) * circumference;
    circle.style.strokeDashoffset = offset;
}

// Generate calendar for the first month (January)
generateCalendar(1);

// Event listener for month selection
monthSelect.addEventListener('change', (event) => {
    const selectedMonth = parseInt(event.target.value);
    generateCalendar(selectedMonth);
});
