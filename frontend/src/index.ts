const message: string = "Hello from TypeScript!!";
console.log(message);

const messageElement = document.getElementById("message");
if (messageElement) {
  messageElement.innerText = message;
} else {
  console.error('Element with id "message" not found');
}
