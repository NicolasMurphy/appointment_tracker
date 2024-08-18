function populateTimeSelect(
  selectElement: HTMLSelectElement,
  selectedValue: string
): void {
  for (let hour = 0; hour < 24; hour++) {
    for (let minutes = 0; minutes < 60; minutes += 15) {
      const timeValue24 = `${hour.toString().padStart(2, "0")}:${minutes
        .toString()
        .padStart(2, "0")}`;
      const period = hour < 12 ? "AM" : "PM";
      const hour12 = hour % 12 === 0 ? 12 : hour % 12;
      const timeValue12 = `${hour12}:${minutes
        .toString()
        .padStart(2, "0")} ${period}`;

      const option = document.createElement("option");
      option.value = timeValue24;
      option.textContent = timeValue12;

      if (timeValue24 === selectedValue) {
        option.selected = true;
      }

      selectElement.appendChild(option);
    }
  }
}

document.addEventListener("DOMContentLoaded", () => {
  const startTimeSelect = document.getElementById(
    "startTime"
  ) as HTMLSelectElement;
  const endTimeSelect = document.getElementById("endTime") as HTMLSelectElement;

  if (startTimeSelect && endTimeSelect) {
    const currentStartTime =
      startTimeSelect.getAttribute("data-start-time") || "12:00";
    const currentEndTime = endTimeSelect.getAttribute("data-end-time") || "13:00";

    populateTimeSelect(startTimeSelect, currentStartTime);
    populateTimeSelect(endTimeSelect, currentEndTime);
  }
});
