const sortClientButton = document.createElement("button");
sortClientButton.textContent = "Sort by Client";
document.body.insertBefore(
  sortClientButton,
  document.getElementById("appointment-list")
);

const sortCaregiverButton = document.createElement("button");
sortCaregiverButton.textContent = "Sort by Caregiver";
document.body.insertBefore(
  sortCaregiverButton,
  document.getElementById("appointment-list")
);

const sortDateButton = document.createElement("button");
sortDateButton.textContent = "Sort by Start Date";
document.body.insertBefore(
  sortDateButton,
  document.getElementById("appointment-list")
);

sortClientButton.addEventListener("click", () => {
  const appointmentList = document.getElementById("appointment-list");
  if (appointmentList) {
    const itemsArray = Array.from(appointmentList.querySelectorAll("li"));

    itemsArray.sort((a, b) => {
      const clientA = a.getAttribute("data-client")?.toLowerCase() || "";
      const clientB = b.getAttribute("data-client")?.toLowerCase() || "";
      return clientA.localeCompare(clientB);
    });

    appointmentList.innerHTML = "";

    itemsArray.forEach((item) => {
      appointmentList.appendChild(item);
    });
  } else {
    console.error("Element with id 'appointment-list' not found");
  }
});

sortCaregiverButton.addEventListener("click", () => {
  const appointmentList = document.getElementById("appointment-list");
  if (appointmentList) {
    const itemsArray = Array.from(appointmentList.querySelectorAll("li"));

    itemsArray.sort((a, b) => {
      const caregiverA = a.getAttribute("data-caregiver")?.toLowerCase() || "";
      const caregiverB = b.getAttribute("data-caregiver")?.toLowerCase() || "";
      return caregiverA.localeCompare(caregiverB);
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
