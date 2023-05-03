const createModalContent = (image) => {
  return `<img src="${image}" id="modal-photo">`
}


let photos = document.querySelectorAll(".gallery-item");
let modal = document.getElementById("modal");
let modalContent = document.getElementsByClassName('modal-content')
photos.forEach((element) => {
  element.addEventListener("click", () => {
    document
    .querySelector(".modal-content")
    .insertAdjacentHTML("beforeend", createModalContent(element.alt));
    modal.style.display = "flex";
  });
});

let close = document.querySelectorAll("#close");
close.forEach((element) => {
  element.addEventListener("click", () => {
    modal.style.display = "none";
    document.getElementById('modal-photo').remove();
  });
});

window.addEventListener("click", (event) => {
  if (event.target == modal) {
    modal.style.display = "none";
    document.getElementById('modal-photo').remove();
  }
});

document.addEventListener("keydown", (event) => {
  if (event.key == "Escape") {
    modal.style.display = "none";
    document.getElementById('modal-photo').remove();
  }
});
