const sortTitleButton = document.createElement("button");
sortTitleButton.textContent = "Sort by Title";
document.body.insertBefore(
  sortTitleButton,
  document.getElementById("appointment-list")
);

const sortDateButton = document.createElement("button");
sortDateButton.textContent = "Sort by Date";
document.body.insertBefore(
  sortDateButton,
  document.getElementById("appointment-list")
);

sortTitleButton.addEventListener("click", () => {
  const appointmentList = document.getElementById("appointment-list");
  if (appointmentList) {
    const itemsArray = Array.from(appointmentList.querySelectorAll("li"));

    itemsArray.sort((a, b) => {
      const titleA = a.getAttribute("data-title")?.toLowerCase() || "";
      const titleB = b.getAttribute("data-title")?.toLowerCase() || "";
      return titleA.localeCompare(titleB);
    });

    appointmentList.innerHTML = "";

    itemsArray.forEach((item) => {
      appointmentList.appendChild(item);
    });
  } else {
    console.error("Element with id 'appointment-list' not found");
  }
});

sortDateButton.addEventListener("click", () => {
  const appointmentList = document.getElementById("appointment-list");
  if (appointmentList) {
    const itemsArray = Array.from(appointmentList.querySelectorAll("li"));

    itemsArray.sort((a, b) => {
      const dateA = new Date(a.getAttribute("data-date") || "");
      const dateB = new Date(b.getAttribute("data-date") || "");
      return dateA.getTime() - dateB.getTime();
    });

    appointmentList.innerHTML = "";

    itemsArray.forEach((item) => {
      appointmentList.appendChild(item);
    });
  } else {
    console.error("Element with id 'appointment-list' not found");
  }
});
