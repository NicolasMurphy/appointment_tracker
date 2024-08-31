const sortClientButton = document.createElement("button");
sortClientButton.textContent = "Sort by Client";
document.body.insertBefore(
  sortClientButton,
  document.getElementById("visit-list")
);

const sortCaregiverButton = document.createElement("button");
sortCaregiverButton.textContent = "Sort by Caregiver";
document.body.insertBefore(
  sortCaregiverButton,
  document.getElementById("visit-list")
);

const sortDateButton = document.createElement("button");
sortDateButton.textContent = "Sort by Start Date";
document.body.insertBefore(
  sortDateButton,
  document.getElementById("visit-list")
);

sortClientButton.addEventListener("click", () => {
  const visitList = document.getElementById("visit-list");
  if (visitList) {
    const itemsArray = Array.from(visitList.querySelectorAll("li"));

    itemsArray.sort((a, b) => {
      const clientA = a.getAttribute("data-client")?.toLowerCase() || "";
      const clientB = b.getAttribute("data-client")?.toLowerCase() || "";
      return clientA.localeCompare(clientB);
    });

    visitList.innerHTML = "";

    itemsArray.forEach((item) => {
      visitList.appendChild(item);
    });
  } else {
    console.error("Element with id 'visit-list' not found");
  }
});

sortCaregiverButton.addEventListener("click", () => {
  const visitList = document.getElementById("visit-list");
  if (visitList) {
    const itemsArray = Array.from(visitList.querySelectorAll("li"));

    itemsArray.sort((a, b) => {
      const caregiverA = a.getAttribute("data-caregiver")?.toLowerCase() || "";
      const caregiverB = b.getAttribute("data-caregiver")?.toLowerCase() || "";
      return caregiverA.localeCompare(caregiverB);
    });

    visitList.innerHTML = "";

    itemsArray.forEach((item) => {
      visitList.appendChild(item);
    });
  } else {
    console.error("Element with id 'visit-list' not found");
  }
});

sortDateButton.addEventListener("click", () => {
  const visitList = document.getElementById("visit-list");
  if (visitList) {
    const itemsArray = Array.from(visitList.querySelectorAll("li"));

    itemsArray.sort((a, b) => {
      const dateA = new Date(a.getAttribute("data-date") || "");
      const dateB = new Date(b.getAttribute("data-date") || "");
      return dateA.getTime() - dateB.getTime();
    });

    visitList.innerHTML = "";

    itemsArray.forEach((item) => {
      visitList.appendChild(item);
    });
  } else {
    console.error("Element with id 'visit-list' not found");
  }
});
