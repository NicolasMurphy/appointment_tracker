const cheeseArray = ["Cheddar", "Mozzarella", "Parmesan", "Gouda", "Manchego"];

console.log("testing");

const appDiv = document.getElementById('app');

if (appDiv) {
    const ul = document.createElement('ul');
    cheeseArray.forEach(cheese => {
        const li = document.createElement('li');
        li.textContent = cheese;
        ul.appendChild(li);
    });
    appDiv.appendChild(ul);
} else {
    console.error("Element with id 'app' not found");
}
